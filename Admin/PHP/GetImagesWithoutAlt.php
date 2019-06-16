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
	$stmt1 = $conn->prepare("SELECT A.A_ID as id1,B.A_ID as id2,A.A_WAARDE as waarde1,B.A_Waarde as waarde2, A.A_Pagina as Pagina FROM `alles`A left outer join alles B on A.A_ID=B.A_Hoort_Bij where A.A_Type='Afbeelding'and B.A_Waarde is null");
	if(!$stmt1){
	    	    die("Statement preparing failed: " . $conn->error);

	}
	$menu =$_GET['menu'];
	
	if(!$stmt1->execute()){
	    die("Statement execution failed: " . $stmt1->error);
	}else{
	    //return de json data
	    $result = $stmt1->get_result();
	    //if($result->num_rows === 0) exit('No rows');
        $antwoord['data'] = $result->fetch_all(MYSQLI_ASSOC);
        echo json_encode($antwoord, JSON_UNESCAPED_UNICODE);
   
	}
    
    
    $stmt1->close();
    $conn->close();
?>