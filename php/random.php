<?php
    require("cors.php");
    require("connect.php"); 
    if ($conn->connect_error) {
    	die("Connection failed: " . $conn->connect_error);
    }
	$antwoord = [];
	$antwoord['data'] = "Geen links gevonden.";
	mysqli_set_charset($conn,'utf8');
	$stmt1 = $conn->prepare("SELECT * FROM Topics where Actief = 1 ORDER BY RAND() LIMIT 4");
	if(!$stmt1){
		die("Statement preparing failed: " . $conn->error);
	}
	if(!$stmt1->execute()){
	    die("Statement execution failed: " . $stmt1->error);
	}else{
	    //return de json data
	    $result = $stmt1->get_result();
	    if($result->num_rows === 0) {
	        $antwoord['data'] = "No Rows";
	    }else{
	        $antwoord['data'] = $result->fetch_all(MYSQLI_ASSOC);
	    }
        echo json_encode($antwoord, JSON_UNESCAPED_UNICODE);
	}
    $stmt1->close();
    $conn->close();
?>