<?php
    require("cors.php");            //set cors
	require("connect.php");         //open connection
	if ($conn->connect_error) {     //check if there is any error in the connection, if so --> die
        die("Connection failed: " . $conn->connect_error);
    }     
    $antwoord = []; //maak een object aan
	$antwoord['data'] = "Geen resultaten gevonden."; //geef mee wat er in het object zit
	mysqli_set_charset($conn,'utf8'); //stel the charset in
	/* prepare de query (maak de query zonder de variabelen op te nemen)*/
	$stmt1 = $conn->prepare("SELECT lpad(Topics.id,7,0) as id, A_Pagina as Pagina,count(DISTINCT A_Taal) as aantal_talen,  GROUP_CONCAT(DISTINCT A_Taal ORDER BY A_Taal ASC SEPARATOR ', ') as taal_array FROM `Content` inner join Topics on Topics.link=Content.A_Pagina group by A_Pagina");
    
	if(!$stmt1){    //als het preparen mislukt --> die
        die("Statement preparing failed: " . $conn->error);
	}
	if(!$stmt1->execute()){    //voer de query uit
	    die("Statement execution failed: " . $stmt1->error);
	}
    else{
	    $result = $stmt1->get_result();	    //return de json data
	    if($result->num_rows === 0) exit('No rows');
        $antwoord['data'] = $result->fetch_all(MYSQLI_ASSOC);
        echo json_encode($antwoord, JSON_UNESCAPED_UNICODE);//zet het anwoord om in JSON
	}
    $stmt1->close();    //sluit de query en de connectie af
    $conn->close();
?>