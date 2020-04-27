<?php
    header('Content-Type: application/json');
    require("core/cors.php");//set cors
	require("core/connect.php");//open connection
	if ($conn->connect_error) {//check if there is any error in the connection, if so --> die
        die("Connection failed: " . $conn->connect_error);
    }
    $antwoord = [];//maak een object aan
	$antwoord['Seasons'] = "Geen resultaten gevonden.";//geef mee wat er in het object zit
	mysqli_set_charset($conn,'utf8');//stel the charset in
	$stmt1 = $conn->prepare("SELECT *,episodes.title as Episode_titel FROM episodes inner join serials on serial_id = serials.id where EXTRACT( MONTH FROM original_air_date)=EXTRACT( MONTH FROM CONVERT_TZ(CURRENT_TIMESTAMP(),'GMT','Europe/Brussels')) and EXTRACT( day FROM original_air_date)=EXTRACT( day FROM CONVERT_TZ(CURRENT_TIMESTAMP(),'GMT','Europe/Brussels'))");//prepare de query (maak de query zonder de variabelen op te nemen)
	if(!$stmt1){//als het preparen mislukt --> die
        die("Statement preparing failed: " . $conn->error);
	}
    //voer de query uit
	if(!$stmt1->execute()){
	    die("Statement execution failed: " . $stmt1->error);
	}
    else{
	    $result = $stmt1->get_result();//return de json data
	    if($result->num_rows === 0) exit('No rows');
        $antwoord['Seasons'] = $result->fetch_all(MYSQLI_ASSOC);
        //zet het anwoord om in JSON
        $json_string = json_encode($antwoord, JSON_PRETTY_PRINT);
        echo $json_string;
	}
    //sluit de query en de connectie af
    $stmt1->close();
    $conn->close();
?>