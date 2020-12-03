<?php
		$antwoord = [];
	

	require("cors.php");

	require('connectAPI.php');

    if ($connAPI->connect_error) {
    	die("Connection failed: " . $connAPI->connect_error);
		}
		
		$antwoord = [];
	$antwoord['Episodes'] = "Geen resultaten gevonden.";
	$antwoord['Path'] = "Geen resultaten gevonden.";
    mysqli_set_charset($connAPI,'utf8');

    $stmtAPI = $connAPI->prepare("SELECT *,episodes.title as Episode_titel FROM episodes inner join serials on serial_id = serials.id where EXTRACT( MONTH FROM original_air_date)=EXTRACT( MONTH FROM CONVERT_TZ(CURRENT_TIMESTAMP(),'GMT','Europe/Brussels')) and EXTRACT( day FROM original_air_date)=EXTRACT( day FROM CONVERT_TZ(CURRENT_TIMESTAMP(),'GMT','Europe/Brussels'))");//prepare de query (maak de query zonder de variabelen op te nemen)
    if(!$stmtAPI){
	    die("Statement preparing failed: " . $connAPI->error);
    }
    if(!$stmtAPI->execute()){
	    die("Statement execution failed: " . $stmtAPI->error);
	  }else{
	    //return de json data
	    $result = $stmtAPI->get_result();
	    if($result->num_rows === 0) exit('No rows');
        $antwoord['Episodes'] = $result->fetch_all(MYSQLI_ASSOC);
        //echo json_encode($antwoord, JSON_UNESCAPED_UNICODE);
  }
    $stmtAPI->close();
    $connAPI->close();
    require("connect.php");
    if ($conn->connect_error) {
    	die("Connection failed: " . $conn->connect_error);
    }
	mysqli_set_charset($conn,'utf8');
	$stmt1 = $conn->prepare("SELECT `GetAncestry`(getID(?)) as parents");
	if(!$stmt1){
	    die("Statement preparing failed: " . $conn->error);
	}
	$menu =$_GET['menu'];
	if(!$stmt1->bind_param("s",$menu)){
	    die("Statement binding failed: " . $conn->connect_error);
	}
	if(!$stmt1->execute()){
	    die("Statement execution failed: " . $stmt1->error);
	}else{
	    //return de json data
	    $result = $stmt1->get_result();
	    if($result->num_rows === 0) exit('No rows');
        $antwoord['Path'] = $result->fetch_all(MYSQLI_ASSOC);
				$parents = $antwoord['Path'][0]['parents'];
				$parentsarray = explode(',', $parents);
				$resultarray = array_map('intval', array_filter($parentsarray, 'is_numeric'));

				
	}
		$stmt1->close();

		
		if(count($resultarray)>0){

			$in  = str_repeat('?,', count($resultarray) - 1) . '?';
			$sql = "SELECT link,topic from Topics where id in ($in) order by parent_id asc";


			$stmt2 = $conn->prepare($sql);
			if(!$stmt2){
				die("Statement preparing failed: " . $conn->error);
			}
			$types = str_repeat('s', count($resultarray));
			if(!$stmt2->bind_param($types,...$resultarray)){
				die("Statement binding failed: " . $conn->connect_error);
			}
			if(!$stmt2->execute()){
					die("Statement execution failed: " . $stmt2->error);
			}else{
					//return de json data
					$result = $stmt2->get_result();
					if($result->num_rows === 0) exit('No rows');
					$antwoord['Path'] = $result->fetch_all(MYSQLI_ASSOC);
					echo json_encode($antwoord, JSON_FORCE_OBJECT);
						
			}
			$stmt2->close();

		}else{
			$antwoord['Path'] = "";
			echo json_encode($antwoord, JSON_FORCE_OBJECT);
		}

		
		$conn->close();
		
?>