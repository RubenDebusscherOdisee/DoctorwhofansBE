<?php
    require("cors.php");
    require("connect.php");     //check if there is any error in the connection, if so --> die
	if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $antwoord = [];
	$antwoord['data'] = "Geen resultaten gevonden.";
	mysqli_set_charset($conn,'utf8');
	$stmt1 = $conn->prepare("select count(link) as Aantal, A_Pagina,link, topic from Topics left join alles on link=A_Pagina where (((A_Pagina like ? or A_Waarde like ?) and (A_Taal = ? or A_Taal = 'null' )and A_Actief =1 and A_Type <> 'Alt' and A_Type <> 'Afbeelding')  OR link like ? or topic like ?) group by link order by Aantal desc");
	if(!$stmt1){
        die("Statement preparing failed: " . $conn->error);
	}
    $menu = $_GET['menu'];$taal = $_GET['taal'];$zoekterm = "%{$_GET['zoekterm']}%";
	if(!$stmt1->bind_param("sssss",$zoekterm,$zoekterm,$taal,$zoekterm,$zoekterm)){
	    die("Statement binding failed: " . $conn->connect_error);
	}
	if(!$stmt1->execute()){
	    die("Statement execution failed: " . $stmt1->error);
	}else{
	    //return de json data
	    $result = $stmt1->get_result();
	    if($result->num_rows === 0) exit('No rows');
        $antwoord['data'] = $result->fetch_all(MYSQLI_ASSOC);
        //zet het anwoord om in JSON
        echo json_encode($antwoord, JSON_UNESCAPED_UNICODE);
	}
    $stmt1->close();
    $conn->close();
?>