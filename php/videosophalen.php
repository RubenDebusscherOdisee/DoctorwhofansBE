<?php
    //set cors
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
    header('Access-Control-Max-Age: 1000');
    header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
    //open connection
    require("connect.php");     //check if there is any error in the connection, if so --> die
	if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    //maak een object aan
    $antwoord = [];
    //geef mee wat er in het object zit
	$antwoord['data'] = "Geen resultaten gevonden.";
    //stel the charset in
	mysqli_set_charset($conn,'utf8');

	$stmt1 = $conn->prepare("SELECT *  FROM `Videos` ORDER BY rand()");
    //als het preparen ùmislukt --> die
	if(!$stmt1){
        die("Statement preparing failed: " . $conn->error);

	}
   
    //voer de query uit
	if(!$stmt1->execute()){
	    die("Statement execution failed: " . $stmt1->error);
	}
    else{
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