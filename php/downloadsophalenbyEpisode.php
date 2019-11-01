<?php
    require("cors.php");
    require("connect.php");
	if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $antwoord = [];
	$antwoord['data'] = "Geen resultaten gevonden.";
	mysqli_set_charset($conn,'utf8');
	$stmt1 = $conn->prepare("select * from downloads inner join Topics on Topics.id=download_pagina where Topics.link= ? ");
	if(!$stmt1){
        die("Statement preparing failed: " . $conn->error);
	}
    $Episode = $_GET['Episode'];
    if(!$stmt1->bind_param("s",$Episode)){
	    die("Statement binding failed: " . $conn->connect_error);
	}
	if(!$stmt1->execute()){
	    die("Statement execution failed: " . $stmt1->error);
	}else{
	    $result = $stmt1->get_result();
	    if($result->num_rows === 0) exit('No rows');
        $antwoord['data'] = $result->fetch_all(MYSQLI_ASSOC);
        echo json_encode($antwoord, JSON_UNESCAPED_UNICODE);
	}
    $stmt1->close();
    $conn->close();
?>