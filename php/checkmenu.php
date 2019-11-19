<?php
	require("cors.php");
	require("connect.php");
	if ($conn->connect_error) {
    	die("Connection failed: " . $conn->connect_error);
    }
	$antwoord = [];
	$antwoord['data'] = "Geen resultaten gevonden.";	mysqli_set_charset($conn,'utf8');
	$stmt = $conn->prepare("call checkPage(?,?,?)");
	if(!$stmt){
	    die("Statement prepare failed: " . $conn->connect_error);
	}
	$menu=$_POST['menu'];
	$ip=json_encode(apache_request_headers());
	$sessie=$_POST['session'];
    if(!$stmt->bind_param("sss",$menu,$ip,$sessie)){
	    die("Statement binding failed: " . $conn->connect_error);
	}
    if(!$stmt->execute()){
	    die("Statement execution failed: " . $stmt->error);
	}else{
		//return de json data
	    $result = $stmt->get_result();
	    if($result->num_rows === 0) {
			echo 'false';  
		    return; 
	    }else{
			echo 'true';  
			return; 
		}
	}
    $stmt->close();
    $conn->close();
?>