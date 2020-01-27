<?php
    //set cors
    require("cors.php");
    //open connection
	require("connect.php");
    //check if there is any error in the connection, if so --> die
	if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    //maak een object aan
    $antwoord = [];
    //geef mee wat er in het object zit
    $antwoord['data'] = "Geen resultaten gevonden.";
    $antwoord['tags']= "no tags";
	mysqli_set_charset($conn,'utf8');
	$stmt1 = $conn->prepare("select * from Content where A_Pagina = ? and A_Actief  and (A_Taal ='null' or A_Taal=?) ORDER BY A_level asc, A_ID asc");
	$stmt2 = $conn->prepare("select categories.*,Topics.link,Topics.topic FROM cat_pages inner join categories on cat_pages.cat_id=categories.cat_id inner join Topics on Topics.id=cat_pages.page_id where Topics.link = ?");

    //als het preparen mislukt --> die
	if(!$stmt1){
        die("Statem2nt preparing failed: " . $conn->error);
    }
    if(!$stmt1){
        die("Statement preparing failed: " . $conn->error);
	}
    //haal de variabelen op
    $menu = $_GET['menu'];
    $taal = $_GET['taal'];
    //bind de parameters aan hun ?(op volgorde s=string, i=integer,d=double,b=blob(packets))
	if(!$stmt1->bind_param("ss",$menu,$taal)){
	    die("Statement binding failed: " . $conn->connect_error);
    }
    if(!$stmt2->bind_param("s",$menu)){
	    die("Statement binding failed: " . $conn->connect_error);
	}
    //voer de query uit
	if(!$stmt1->execute()){
	    die("Statement execution failed: " . $stmt1->error);
	}
    else{
	    //return de json data
	    $result = $stmt1->get_result();
	    if($result->num_rows === 0){
			$antwoord['data']='No rows';
		} else{
			$antwoord['data'] = $result->fetch_all(MYSQLI_ASSOC);
		}
        //zet het anwoord om in JSON
    }
    if(!$stmt2->execute()){
	    die("Statement execution failed: " . $stmt1->error);
	}
    else{
	    //return de json data
	    $result = $stmt2->get_result();
	    if($result->num_rows === 0){
			$antwoord['tags']='No rows';
		} else{
			$antwoord['tags'] = $result->fetch_all(MYSQLI_ASSOC);
		}
        //zet het anwoord om in JSON
        echo json_encode($antwoord, JSON_UNESCAPED_UNICODE);
	}
    //sluit de query en de connectie af
    $stmt1->close();
    $stmt2->close();
    $conn->close();
?>