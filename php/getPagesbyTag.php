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
	mysqli_set_charset($conn,'utf8');
	$stmt1 = $conn->prepare("SELECT Topics.link,Topics.topic,categories.cat_name FROM Topics inner join cat_pages on cat_pages.page_id=Topics.id inner join categories on cat_pages.cat_id=categories.cat_id where categories.cat_name=?");

    //als het preparen mislukt --> die
	if(!$stmt1){
        die("Statem2nt preparing failed: " . $conn->error);
    }
   
    //haal de variabelen op
    $tag = str_replace("_"," ",$_GET['tag']);
    //bind de parameters aan hun ?(op volgorde s=string, i=integer,d=double,b=blob(packets))
	if(!$stmt1->bind_param("s",$tag)){
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
        echo json_encode($antwoord, JSON_UNESCAPED_UNICODE);

    }
    
    //sluit de query en de connectie af
    $stmt1->close();
    $conn->close();
?>