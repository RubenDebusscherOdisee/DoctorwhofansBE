<?php
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
    header('Access-Control-Max-Age: 1000');
    header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
    require("connect.php");
    if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
    }
	$topic['data'] = "Geen topic gevonden.";
	mysqli_set_charset($conn,'utf8');
	
	$stmt = $conn->prepare("UPDATE Topics SET Uitklapbaar = 1 WHERE id=?;");

//    $stmt = $conn->prepare("select * from Users");
	if(!$stmt){
	    die("Statement prepare failed: " . $conn->connect_error);
	}
    //$Voornaam="Gildeon";
    $parent=$_POST['parent'];

//TODO
  
  
    if(!$stmt->bind_param("i", $parent)){
	    die("Statement binding failed: " . $conn->connect_error);
	}
	
    if(!$stmt->execute()){
	    die("Statement execution failed: " . $stmt->error);
	}
	
    $stmt->close();
    $conn->close();
    echo '{"status":"ok"}';
?>