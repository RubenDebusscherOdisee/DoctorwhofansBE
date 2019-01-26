<?php
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
    header('Access-Control-Max-Age: 1000');
    header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
  
    require("connect.php");
	if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
    }
   $antwoord = [];
	$antwoord['data'] = "Geen resultaten gevonden.";
	mysqli_set_charset($conn,'utf8');
	
	$verified=false;
	$stmt1 = $conn->prepare("SELECT CONCAT(REPEAT('-', level - 1), CAST(hi.topic AS CHAR)) AS treeitem, topic,parent_id, level,link, hi.id FROM (SELECT  hierarchy_connect_by_parent_eq_prior_id(id) AS id, @level AS level FROM (SELECT  @start_with := 0,@id := @start_with,@level := 0) vars, Topics WHERE  @id IS NOT NULL) ho JOIN Topics hi ON hi.id = ho.id");
	if(!$stmt1){
	    	    die("Statement preparing failed: " . $conn->error);

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