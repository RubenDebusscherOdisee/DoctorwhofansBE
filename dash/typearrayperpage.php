<?php
    require("cors.php");            //set cors
	require("connect.php");         //open connection
	if ($conn->connect_error) {     //check if there is any error in the connection, if so --> die
        die("Connection failed: " . $conn->connect_error);
    }     
    $antwoord = []; //maak een object aan
	$antwoord['data'] = "Geen resultaten gevonden."; //geef mee wat er in het object zit
	mysqli_set_charset($conn,'utf8'); //stel the charset in
	/* prepare de query (maak de query zonder de variabelen op te nemen)*/
	$stmt1 = $conn->prepare("SELECT lpad(Topics.id,7,0) as id,concat('<span title=',A.A_Pagina,'>',Topics.topic,'</span>') as Pagina, A.A_Taal as taal, GROUP_CONCAT(A.count order by A.A_level asc SEPARATOR ', ') as items FROM (SELECT A_Type,A_ID,A_Level,A_Pagina,A_Taal, CONCAT(IF(A_Type !='WikiLooseItem', A_Type, concat('LI: ',LEFT(A_Waarde,LOCATE(':',A_Waarde) - 1))), ' (', count(IF(A_Type !='WikiLooseItem', A_Type, concat('LI:',LEFT(A_Waarde,LOCATE(':',A_Waarde) - 1)))), ')') AS count FROM V_Actieve_Content GROUP BY A_Pagina, A_Taal,IF(A_Type !='WikiLooseItem', A_Type, LEFT(A_Waarde,LOCATE(':',A_Waarde) - 1))) A inner join Topics on Topics.link=A.A_Pagina GROUP BY A.A_Pagina, A.A_Taal");
    
	if(!$stmt1){    //als het preparen mislukt --> die
        die("Statement preparing failed: " . $conn->error);
	}
	if(!$stmt1->execute()){    //voer de query uit
	    die("Statement execution failed: " . $stmt1->error);
	}
    else{
	    $result = $stmt1->get_result();	    //return de json data
	    if($result->num_rows === 0) exit('No rows');
        $antwoord['data'] = $result->fetch_all(MYSQLI_ASSOC);
        echo json_encode($antwoord, JSON_UNESCAPED_UNICODE);//zet het anwoord om in JSON
	}
    $stmt1->close();    //sluit de query en de connectie af
    $conn->close();
?>