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
	$antwoord['data'] = "Geen resultaten gevonden.";
    //stel the charset in
	mysqli_set_charset($conn,'utf8');
	/* prepare de query (maak de query zonder de variabelen op te nemen)*/
	$stmt1 = $conn->prepare("SELECT concat(Shows.show_name,': alle afleveringen ') as titel,sum(time_to_sec(runtime)) as total FROM `episodes` inner join serials on episodes.serial_id=serials.id INNER join seasons on seasons.id=serials.season_id inner join Shows on seasons.show_id=Shows.show_id group by Shows.show_id union SELECT 'Classic & New who: alle afleveringen 'as titel,sum(time_to_sec(runtime)) as total FROM `episodes` inner join serials on episodes.serial_id=serials.id INNER join seasons on seasons.id=serials.season_id inner join Shows on seasons.show_id=Shows.show_id where (Shows.show_name='New Who' or Shows.show_name= 'Classic Who') union select concat(Shows.show_name,': exclusief vermiste afleveringen ')as titel,sum(time_to_sec(runtime)) as total FROM `episodes` inner join serials on episodes.serial_id=serials.id INNER join seasons on seasons.id=serials.season_id inner join Shows on seasons.show_id=Shows.show_id where missing=0 group by Shows.show_id union SELECT 'Classic & New Who: exclusief vermiste afleveringen 'as titel,sum(time_to_sec(runtime)) as total FROM `episodes` inner join serials on episodes.serial_id=serials.id INNER join seasons on seasons.id=serials.season_id inner join Shows on seasons.show_id=Shows.show_id where (Shows.show_name='New Who' or Shows.show_name= 'Classic Who') and missing=0 union select concat(Shows.show_name,': enkel vermiste afleveringen ')as titel,sum(time_to_sec(runtime)) as total FROM `episodes` inner join serials on episodes.serial_id=serials.id INNER join seasons on seasons.id=serials.season_id inner join Shows on seasons.show_id=Shows.show_id where missing=1 group by Shows.show_id union select 'Classic & New who: enkel vermiste afleveringen 'as titel,sum(time_to_sec(runtime)) as total FROM `episodes` inner join serials on episodes.serial_id=serials.id INNER join seasons on seasons.id=serials.season_id inner join Shows on seasons.show_id=Shows.show_id where (Shows.show_name='New Who' or Shows.show_name= 'Classic Who') and missing=1 group by Shows.show_id union select concat(Shows.show_name,': recreated ')as titel,sum(time_to_sec(runtime)) as total FROM `episodes` inner join serials on episodes.serial_id=serials.id INNER join seasons on seasons.id=serials.season_id inner join Shows on seasons.show_id=Shows.show_id where recreated=1 group by Shows.show_id union select 'Classic & New who: recreated 'as titel,sum(time_to_sec(runtime)) as total FROM `episodes` inner join serials on episodes.serial_id=serials.id INNER join seasons on seasons.id=serials.season_id inner join Shows on seasons.show_id=Shows.show_id where (Shows.show_name='New Who' or Shows.show_name= 'Classic Who') and recreated=1 group by Shows.show_id order by titel");
    //als het preparen mislukt --> die
	if(!$stmt1){
        die("Statement preparing failed: " . $conn->error);
	}
    //haal de variabelen op
    
    //bind de parameters aan hun ?(op volgorde s=string, i=integer,d=double,b=blob(packets))
	
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
        $json_string = json_encode($antwoord, JSON_PRETTY_PRINT);
        echo $json_string;
	}
    //sluit de query en de connectie af
    $stmt1->close();
    $conn->close();
?>