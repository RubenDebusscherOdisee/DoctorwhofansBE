<?php
header('Content-Type: application/json');
    //set cors
    require("core/cors.php");
    //open connection
	require("core/connect.php");
    //check if there is any error in the connection, if so --> die
	if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    //maak een object aan
    $antwoord = [];
    //geef mee wat er in het object zit
	$antwoord['DoctorsforEpisode'] = "Geen resultaten gevonden.";
    //stel the charset in
	mysqli_set_charset($conn,'utf8');
	/* prepare de query (maak de query zonder de variabelen op te nemen)*/
	$stmt1 = $conn->prepare("SELECT serial_id,doctor_id,incarnation,primary_actor,name,gender FROM `serials_doctors` inner join doctors on serials_doctors.doctor_id=doctors.id inner join actors on actors.id=doctors.primary_actor where serial_id=?");
    //als het preparen mislukt --> die
	if(!$stmt1){
        die("Statement preparing failed: " . $conn->error);
	}
    //haal de variabelen op
    $id=$_GET['id'];
    //bind de parameters aan hun ?(op volgorde s=string, i=integer,d=double,b=blob(packets))
	if(!$stmt1->bind_param("i",$id)){
        die("Statement binding failed: " . $conn->connect_error);
	}
    //voer de query uit
	if(!$stmt1->execute()){
	    die("Statement execution failed: " . $stmt1->error);
	}
    else{
	    //return de json data
	    $result = $stmt1->get_result();
	    if($result->num_rows === 0) exit('No rows');
        $antwoord['DoctorsforEpisode'] = $result->fetch_all(MYSQLI_ASSOC);
        //zet het anwoord om in JSON
        $json_string = json_encode($antwoord, JSON_PRETTY_PRINT);
        echo $json_string;
	}
    //sluit de query en de connectie af
    $stmt1->close();
    $conn->close();
?>