<?php
	require("cors.php");
	require("connect.php");
	if ($conn->connect_error) {
    	die("Connection failed: " . $conn->connect_error);
    }
   $antwoord = [];
	$antwoord['data'] = "Geen resultaten gevonden.";
	mysqli_set_charset($conn,'utf8');
	$stmt1 = $conn->prepare("SELECT `Topics`.*,`V_children`.direct_children FROM `Topics` inner join `V_children` on `Topics`.id= `V_children`.id where Topics.parent_id = (select id from Topics where link= ?) order by Topics.Episode_Order, Topics.topic");
	if(!$stmt1){
	    die("Statement preparing failed: " . $conn->error);
	}
	$menu =$_GET['menu'];
	
	if(!$stmt1->bind_param("s",$menu)){
	    die("Statement binding failed: " . $conn->connect_error);
	}
	if(!$stmt1->execute()){
	    die("Statement execution failed: " . $stmt1->error);
	}else{
	    //return de json data
	    $result = $stmt1->get_result();
	    if($result->num_rows === 0) exit('No rows');
        $antwoord['data'] = $result->fetch_all(MYSQLI_ASSOC);
        echo json_encode($antwoord, JSON_UNESCAPED_UNICODE);
	}
    $stmt1->close();
    $conn->close();
?>