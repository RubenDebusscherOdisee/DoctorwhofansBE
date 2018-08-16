<?php
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
    //stel the charset in
	mysqli_set_charset($conn,'utf8');
	/* prepare de query (maak de query zonder de variabelen op te nemen)*/
	$stmt1 = $conn->prepare("SELECT SUBSTRING( Quote, 1, 70) AS Quote, Personage, Aflevering,id FROM `QuotesTabel` order by rand() limit 1");
    //als het preparen ùmislukt --> die
	if(!$stmt1){
        die("Statement preparing failed: " . $conn->error);
	}
    //voer de query uit
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
    //sluit de query en de connectie af
    $stmt1->close();
    $conn->close();
?>