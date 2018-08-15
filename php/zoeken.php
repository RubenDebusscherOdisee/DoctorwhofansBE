<?php
    //set cors
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
    header('Access-Control-Max-Age: 1000');
    header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
    //open connection
    require("connect.php");     //check if there is any error in the connection, if so --> die
	if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    //maak een object aan
    $antwoord = [];
    //geef mee wat er in het object zit
	$antwoord['data'] = "Geen resultaten gevonden.";
    //stel the charset in
	mysqli_set_charset($conn,'utf8');
	/* prepare de query (maak de query zonder de variabelen op te nemen)
    voorbeeld select
    select * from testdata where id=?
    */
	$stmt1 = $conn->prepare("select count(link) as Aantal, A_Pagina,link, topic from Topics left join alles on link=A_Pagina where (((A_Pagina like ? or A_Waarde like ?) and (A_Taal = ? or A_Taal = 'null' )and A_Actief =1 and A_Type <> 'Alt' and A_Type <> 'Afbeelding')  OR link like ? or topic like ?) group by link order by Aantal desc");
    //als het preparen ùmislukt --> die
	if(!$stmt1){
        die("Statement preparing failed: " . $conn->error);

	}
    //haal de variabelen op
    $menu = $_GET['menu'];
    $taal = $_GET['taal'];
    $zoekterm = "%{$_GET['zoekterm']}%";

    //bind de parameters aan hun ?(op volgorde s=string, i=integer,d=double,b=blob(packets))
	if(!$stmt1->bind_param("sssss",$zoekterm,$zoekterm,$taal,$zoekterm,$zoekterm)){
	    die("Statement binding failed: " . $conn->connect_error);
	}
    //voer de query uit
	if(!$stmt1->execute()){
	    die("Statement execution failed: " . $stmt1->error);
	}
    else{
	    //return de json data
	    $result = $stmt1->get_result();
	    if($result->num_rows === 0) exit('No rows');
        $antwoord['data'] = $result->fetch_all(MYSQLI_ASSOC);
        //zet het anwoord om in JSON
        echo json_encode($antwoord, JSON_UNESCAPED_UNICODE);
   
	}
    
    //sluit de query en de connectie af
    $stmt1->close();
    $conn->close();
?>