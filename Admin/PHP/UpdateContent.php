<?php

    require("connect.php");
    if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
    }
	$topic['data'] = "Geen topic gevonden.";
	mysqli_set_charset($conn,'utf8');
	
	$stmt = $conn->prepare("UPDATE alles SET A_Pagina = ?, A_Pagina_Type = ?,A_Type=?,A_Waarde=?,A_Actief=?,A_Taal=?,A_Klasse=?,A_Hoort_Bij=?,A_Level=? WHERE A_ID =?");

	if(!$stmt){
	    die("Statement prepare failed: " . $conn->connect_error);
	}
    
    $pagina=$_POST['A_Pagina'];
    $paginaType=$_POST['A_Pagina_Type'];
    $type=$_POST['A_Type'];
    $waarde=$_POST['A_Waarde'];
    $taal=$_POST['A_Taal'];
    $Level = $_POST['A_Level'];
    $klasse=$_POST['A_Klasse'];
    $Hoort_Bij=$_POST['A_Hoort_Bij'];
    $Actief=$_POST['A_Actief'];
    $ID=$_POST['A_ID'];
  
    if(
        !$stmt->bind_param("ssssissiii",$pagina, $paginaType,$type, $waarde,$Actief,$taal,$klasse,$Hoort_Bij,$Level,$ID)){
	    die("Statement binding failed: " . $conn->connect_error);
	}
	
    if(!$stmt->execute()){
	    die("Statement execution failed: " . $stmt->error);
	}
	
    $stmt->close();
    $conn->close();
    echo '{"status":"ok"}';
?>