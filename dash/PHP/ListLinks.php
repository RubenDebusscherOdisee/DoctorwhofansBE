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
	$stmt1 = $conn->prepare("SELECT Replace(Replace(A_Pagina,')',''),'(','') as A_Pagina,Replace(Replace(A_Waarde,')',''),'(','') as A_Waarde from Content where A_Waarde like '%<a href%' and A_Actief=1");
	if(!$stmt1){
	    	    die("Statement preparing failed: " . $conn->error);

	}
	$menu =$_GET['menu'];
	
	if(!$stmt1->execute()){
	    die("Statement execution failed: " . $stmt1->error);
	}else{
	    //return de json data
	    $result = $stmt1->get_result();
	    if($result->num_rows === 0) exit('No rows');
        $antwoord['data'] = $result->fetch_all(MYSQLI_ASSOC);
        echo json_encode($antwoord, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_NUMERIC_CHECK | JSON_PRETTY_PRINT | JSON_UNESCAPED_LINE_TERMINATORS );
   
	}
    
    
    $stmt1->close();
    $conn->close();
?>