<?php
    require("connect.php");
    if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
    }
	$topic['data'] = "Geen topic gevonden.";
	mysqli_set_charset($conn,'utf8');
	
	$stmt = $conn->prepare("INSERT INTO QuotesTabel (Quote, Personage, Aflevering,QuotePic) VALUES (?,?,?,?)");

//    $stmt = $conn->prepare("select * from Users");
	if(!$stmt){
	    die("Statement prepare failed: " . $conn->connect_error);
	}
    //$Voornaam="Gildeon";
    $Quote=$_POST['Quote'];
    $Personage=$_POST['Personage'];
    $Aflevering=$_POST['Aflevering'];
    $QuotePic=$_POST['QuotePic'];
    
    //$naam="D
//TODO
  
  
    if(!$stmt->bind_param("ssss",$Quote, $Personage,$Aflevering, $QuotePic)){
	    die("Statement binding failed: " . $conn->connect_error);
	}
	
    if(!$stmt->execute()){
	    die("Statement execution failed: " . $stmt->error);
	}
	
    $stmt->close();
    $conn->close();
    echo '{"status":"ok"}';
?>