<?php
    require("connect.php");
    if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
    }
	$topic['data'] = "Geen topic gevonden.";
	mysqli_set_charset($conn,'utf8');
	
	$stmt = $conn->prepare("INSERT INTO alles (A_Pagina, A_Pagina_Type, A_Type,A_Waarde,A_Actief,A_TIMESTAMP,A_Taal,A_Klasse,A_Hoort_Bij,A_Level) VALUES (?,?,?,?,?,CURRENT_TIMESTAMP,?,?,?,?)");

//    $stmt = $conn->prepare("select * from Users");
	if(!$stmt){
	    die("Statement prepare failed: " . $conn->connect_error);
	}
    //$Voornaam="Gildeon";
    $pagina=$_POST['Pagina'];
    $paginaType=$_POST['TypePagina'];
    $type=$_POST['Type'];
    $waarde=$_POST['Waarde'];
    $taal=$_POST['Taal'];
    $Level = $_POST['Level'];
    $klasse=$_POST['Klasse'];
    $Hoort_Bij=$_POST['IDHB'];
    $Actief=$_POST['Actief'];
    //$naam="D
//TODO
  
  
    if(!$stmt->bind_param("ssssissii",$pagina, $paginaType,$type, $waarde,$Actief,$taal,$klasse,$Hoort_Bij,$Level)){
	    die("Statement binding failed: " . $conn->connect_error);
	}
	
    if(!$stmt->execute()){
	    die("Statement execution failed: " . $stmt->error);
	}
	
    $stmt->close();
    $conn->close();
    echo '{"status":"ok"}';
?>