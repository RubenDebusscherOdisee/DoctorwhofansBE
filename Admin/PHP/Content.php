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
	$stmt1 = $conn->prepare("SELECT * from alles where A_Pagina=?");
	if(!$stmt1){
	    	    die("Statement preparing failed: " . $conn->error);

	}
	$Pagina=$_POST['Pagina'];
 
    //$Naam="rubendemeno@meno.com";

  
  
    if(!$stmt1->bind_param("s",$Pagina)){
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