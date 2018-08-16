<?php
    require("cors.php");
    require("connect.php");
	if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $antwoord = [];
	$antwoord['data'] = "Geen resultaten gevonden.";
	mysqli_set_charset($conn,'utf8');
	$stmt1 = $conn->prepare("select id, Video_Name, Video_Beschrijving from Videos where  Video_Name like ? or Video_Beschrijving like ? ");
	if(!$stmt1){
        die("Statement preparing failed: " . $conn->error);
	}
    $menu = $_GET['menu'];
    $zoekterm = "%{$_GET['zoekterm']}%";
    if(!$stmt1->bind_param("ss",$zoekterm,$zoekterm)){
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