<?php
    require("cors.php");
    require("connect.php");     //check if there is any error in the connection, if so --> die
	if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $antwoord = [];
	$antwoord['data'] = "Geen resultaten gevonden.";
	mysqli_set_charset($conn,'utf8');
	$stmt1 = $conn->prepare("call SearchFullFunction(?,?)");
	if(!$stmt1){
        die("Statement preparing failed: " . $conn->error);
	}
	$menu = $_GET['menu'];
	$taal = $_GET['taal'];
	$zoekterm = $_GET['zoekterm'];
	
	if(!$stmt1->bind_param("ss",$zoekterm,$taal)){
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