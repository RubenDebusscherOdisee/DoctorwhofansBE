<?php
    require("cors.php");
    require("connect.php");     //check if there is any error in the connection, if so --> die
	if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $antwoord = [];
	$antwoord['data'] = "Geen resultaten gevonden.";
	mysqli_set_charset($conn,'utf8');
	$stmt1 = $conn->prepare("select count_str(upper(concat(A_waarde,topic,link)),upper(?)) as Aantal,b.link,b.topic from alles a inner join Topics b on a.A_Pagina =b.id  inner join L_Taal on L_Taal.LTa_id = a.A_Taal  inner join L_Types on L_Types.LT_Id = a.A_Type where (a.A_Waarde like ? or b.topic like ? or b.link like ?) and (L_Taal.LTa_naam = ? or L_Taal.LTa_naam  = 'null' ) and a.A_Actief=1 and L_Types.LT_Naam <> 'Alt' and L_Types.LT_Naam  <> 'Afbeelding' group by b.link order by Aantal desc");
	if(!$stmt1){
        die("Statement preparing failed: " . $conn->error);
	}
	$menu = $_GET['menu'];$taal = $_GET['taal'];$zoekterm = "%{$_GET['zoekterm']}%";$zoektermraw=$_GET['zoekterm'];
	if(!$stmt1->bind_param("sssss",$zoektermraw,$zoekterm,$zoekterm,$zoekterm,$taal)){
	    die("Statement binding failed: " . $conn->connect_error);
	}
	if(!$stmt1->execute()){
	    die("Statement execution failed: " . $stmt1->error);
	}else{
	    //return de json data
	    $result = $stmt1->get_result();
	    if($result->num_rows === 0) exit('No rows');
        $antwoord['data'] = $result->fetch_all(MYSQLI_ASSOC);
        //zet het anwoord om in JSON
        echo json_encode($antwoord, JSON_UNESCAPED_UNICODE);
	}
    $stmt1->close();
    $conn->close();
?>