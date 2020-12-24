<?php
	require("cors.php");
	require("connect.php");
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
	$antwoord = [];
	mysqli_set_charset($conn,'utf8');
	$stmt = $conn->prepare("call checkPage(?,?,?)");
	if(!$stmt){
		die("Statement prepare failed: " . $conn->connect_error);
	}
	$menu=$_POST['menu'];
	$language = $_POST['lang'];
	$ip=json_encode(apache_request_headers());
	$session=$_COOKIE['PHPSESSID'];
	if(!$stmt->bind_param("sss",$menu,$ip,$session)){
		die("Statement binding failed: " . $conn->connect_error);
	}
	if(!$stmt->execute()){
		die("Statement execution failed: " . $stmt->error);
	}else{
		$result = $stmt->get_result();
		if($result->num_rows === 0) {
			echo 'false';
			return;
		}else{
			$antwoord['Page'] = $result->fetch_all(MYSQLI_ASSOC);
			$current_Page=$antwoord['Page'][0]['page_Link'];
			$current_Page_Id =$antwoord['Page'][0]['page_Id'];
			$prefix = $antwoord['Page'][0]['pagetype_Name'];
			$Page_Name = substr(strrchr($current_Page, "/"), 1);
			$stmt->close();
			$antwoord['EpisodesOf_The_day'] = "Geen resultaten gevonden.";
			$stmtEOTD = $conn->prepare("SELECT * from Episodes_Of_The_Day where EXTRACT( MONTH FROM episode_Original_airdate)=EXTRACT( MONTH FROM CONVERT_TZ(CURRENT_TIMESTAMP(),'GMT','Europe/Brussels')) and EXTRACT( day FROM episode_Original_airdate)=EXTRACT( day FROM CONVERT_TZ(CURRENT_TIMESTAMP(),'GMT','Europe/Brussels'))");//prepare de query (maak de query zonder de variabelen op te nemen)
			if(!$stmtEOTD){
				die("Statement preparing failed: " . $conn->error);
			}
			if(!$stmtEOTD->execute()){
				die("Statement execution failed: " . $stmtEOTD->error);
			}else{
				//return de json data
				$result = $stmtEOTD->get_result();
				if($result->num_rows === 0) exit('No rows');
					$antwoord['EpisodesOf_The_day'] = $result->fetch_all(MYSQLI_ASSOC);
			}
			$stmtEOTD->close();
			$stmtPathArray = $conn->prepare("SELECT `GetAncestry`(?) AS 'parents'");
			if(!$stmtPathArray){
					die("Statement preparing failed: " . $conn->error);
			}
			if(!$stmtPathArray->bind_param("i",$current_Page_Id)){
					die("Statement binding failed: " . $conn->connect_error);
			}
			if(!$stmtPathArray->execute()){
					die("Statement execution failed: " . $stmt1->error);
			}else{
					//return de json data
				$result = $stmtPathArray->get_result();
				if($result->num_rows === 0){
					$parents = $antwoord['Path'][0]['parents']=0;
				}else{
					$antwoord['Path'] = $result->fetch_all(MYSQLI_ASSOC);
					$parents = $antwoord['Path'][0]['parents'];
					$parentsarray = explode(',', $parents);
					$resultArray = array_map('intval', array_filter($parentsarray, 'is_numeric'));
				}
			}
			$stmtPathArray->close();
			if(count($resultArray)>0){
				$in  = str_repeat('?,', count($resultArray) - 1) . '?';
				$sql = "SELECT page_Link,page_Name from management__pages where page_Id in ($in) order by page_Parent_Id asc";
				$stmtPath = $conn->prepare($sql);
				if(!$stmtPath){
					die("Statement preparing failed: " . $conn->error);
				}
				$types = str_repeat('s', count($resultArray));
				if(!$stmtPath->bind_param($types,...$resultArray)){
					die("Statement binding failed: " . $conn->connect_error);
				}
				if(!$stmtPath->execute()){
						die("Statement execution failed: " . $stmt2->error);
				}else{
						//return de json data
						$result = $stmtPath->get_result();
						if($result->num_rows === 0){}
							else{
								$antwoord['Path'] = $result->fetch_all(MYSQLI_ASSOC);
							}
				}
				$stmtPath->close();
			}else{
				$antwoord['Path'] = "";
			}
			switch ($prefix) {
				case "Sitemap":





				$stmtMap = $conn->prepare("SELECT page_Id,page_Link,page_Name,page_parent_id,exists(select 1 from management__pages t1 where t1.page_Parent_Id = management__pages.page_Id) collapsible FROM `management__pages` order by page_parent_id asc,collapsible desc,page_Order asc,page_Name asc");
				if(!$stmtMap){
						die("Statement preparing failed: " . $conn->error);
				}
				
				
				if(!$stmtMap->execute()){
						die("Statement execution failed: " . $stmtMap->error);
				}else{
						//return de json data
						$result = $stmtMap->get_result();
						if($result->num_rows === 0) {
							$antwoord['Sitemap'] = "No Sitemap found";

						}else{
							$antwoord['Sitemap'] = $result->fetch_all(MYSQLI_ASSOC);

						}
				}
					$stmtMap->close();
					break;
				case "Episode":
					$stmtSerial = $conn->prepare("select * from Serials where serial_Id=?");
					if(!$stmtSerial){
						die("Statement prepare failed: " . $conn->connect_error);
					}
					$API_Item = $antwoord['Page'][0]['page_API_Item'];
					if(!$stmtSerial->bind_param("i",$API_Item)){
						die("Statement binding failed: " . $conn->connect_error);
					}
					if(!$stmtSerial->execute()){
						die("Statement execution failed: " . $stmtSerial->error);
					}else{
						//return de json data
						$result = $stmtSerial->get_result();
						if($result->num_rows === 0){
							$antwoord['Serial']="No Serial found";
						}else{
							$antwoord['Serial'] = $result->fetch_all(MYSQLI_ASSOC);
							$stmtSerial->close();
							$stmtEpisodes = $conn->prepare("select *,time_format(SEC_TO_TIME(episode_Runtime_in_seconds),'%T') as Runtime from Episodes_With_State where episode_Serial_Id=? order by episode_Order");
							if(!$stmtEpisodes){
								die("Statement prepare failed: " . $conn->connect_error);
							}
							if(!$stmtEpisodes->bind_param("i",$API_Item)){
								die("Statement binding failed: " . $conn->connect_error);
							}
							if(!$stmtEpisodes->execute()){
								die("Statement execution failed: " . $stmtEpisodes->error);
							}else{
								$result = $stmtEpisodes->get_result();
								if($result->num_rows === 0){
									$antwoord['Serial']['Episodes'] = "No Episodes found";
								}else{
									$antwoord['Serial']['Episodes'] = $result->fetch_all(MYSQLI_ASSOC);
									$stmtEpisodes->close();
									$stmtCharacters = $conn->prepare("select Characters_With_Actor.*,SC_Type from api__serials_characters inner join Characters_With_Actor on Characters_With_Actor.character_Id=api__serials_characters.SC_Character_Id where api__serials_characters.SC_Serial_Id=?");
									if(!$stmtCharacters){
										die("Statement prepare failed: " . $conn->connect_error);
									}
									if(!$stmtCharacters->bind_param("i",$API_Item)){
										die("Statement binding failed: " . $conn->connect_error);
									}
									if(!$stmtCharacters->execute()){
										die("Statement execution failed: " . $stmtCharacters->error);
									}else{
										//return de json data
										$result = $stmtCharacters->get_result();
										if($result->num_rows === 0){
											$antwoord['Serial']['Characters'] = "";
										}else{
											$antwoord['Serial']['Characters'] = $result->fetch_all(MYSQLI_ASSOC);
										}
									}
									$stmtCrew = $conn->prepare("select api__crew.* from api__serials_crew inner join api__crew on api__crew.crew_Id=api__serials_crew.SC_crew_Id where api__serials_crew.SC_Serial_Id=?");
									if(!$stmtCrew){
										die("Statement prepare failed: " . $conn->connect_error);
									}
									if(!$stmtCrew->bind_param("i",$API_Item)){
										die("Statement binding failed: " . $conn->connect_error);
									}
									if(!$stmtCrew->execute()){
										die("Statement execution failed: " . $stmtCharacters->error);
									}else{
										//return de json data
										$result = $stmtCrew->get_result();
										if($result->num_rows === 0){
											$antwoord['Serial']['Crew'] = "No Characters for this episode";
										}else{
											$antwoord['Serial']['Crew'] = $result->fetch_all(MYSQLI_ASSOC);
										}
									}
								}
							}
						}
					}
					break;
				case "Doctor":
				$stmtDoctor = $conn->prepare("select * from api__characters where character_Id=?");
				if(!$stmtDoctor){
					die("Statement prepare failed: " . $conn->connect_error);
				}
				$API_Item = $antwoord['Page'][0]['page_API_Item'];
				if(!$stmtDoctor->bind_param("i",$API_Item)){
					die("Statement binding failed: " . $conn->connect_error);
				}
				if(!$stmtDoctor->execute()){
					die("Statement execution failed: " . $stmtDoctor->error);
				}else{
					//return de json data
					$result = $stmtDoctor->get_result();
					if($result->num_rows === 0){
						$antwoord['Doctor']="No Doctor found";
					}else{
						$antwoord['Doctor'] = $result->fetch_all(MYSQLI_ASSOC);
						$stmtDoctor->close();
					}
				}
					break;
				case "Character":
					$stmtCharacter = $conn->prepare("select * from api__characters where character_Id=?");
				if(!$stmtCharacter){
					die("Statement prepare failed: " . $conn->connect_error);
				}
				$API_Item = $antwoord['Page'][0]['page_API_Item'];
				if(!$stmtCharacter->bind_param("i",$API_Item)){
					die("Statement binding failed: " . $conn->connect_error);
				}
				if(!$stmtCharacter->execute()){
					die("Statement execution failed: " . $stmtCharacter->error);
				}else{
					//return de json data
					$result = $stmtCharacter->get_result();
					if($result->num_rows === 0){
						$antwoord['Character']="No Character found";
					}else{
						$antwoord['Character'] = $result->fetch_all(MYSQLI_ASSOC);
						$stmtCharacter->close();
					}
				}
					break;
				case "Book":
					echo "Zoek de data van een Book: ".$Page_Name;
					break;
				case "Crew":
					echo "Zoek de data van een Crewlid: ".$Page_Name;
					break;
			}
			$stmtContent = $conn->prepare('SELECT * FROM content_With_Lang where item_Page=? and language_Name=?');
			if(!$stmtContent){
				die('Statement preparing failed: ' . $conn->error);
			}
			if(!$stmtContent->bind_param("is",$current_Page_Id,$language)){
				die('Statement binding failed: ' . $conn->connect_error);
			}
			if(!$stmtContent->execute()){
				die('Statement execution failed: ' . $stmtContent->error);
			}else{
				$resultContent = $stmtContent->get_result();
				if($resultContent->num_rows === 0){
					$antwoord['Content']="";
				} else{
					$antwoord['Content'] = $resultContent->fetch_all(MYSQLI_ASSOC);
				}
			}
			//$antwoord['Content']="Er is nog geen content gevonden";
			$stmtContent->close();
			$stmtDownloads = $conn->prepare('select * from Downloads where download_Page=?');
			if(!$stmtDownloads){
				die('Statement preparing failed: ' . $conn->error);
			}
			if(!$stmtDownloads->bind_param('i',$current_Page_Id)){
				die('Statement binding failed: ' . $conn->connect_error);
			}
			if(!$stmtDownloads->execute()){
				die('Statement execution failed: ' . $stmtDownloads->error);
			}else{
				$resultDownloads = $stmtDownloads->get_result();
				if($resultDownloads->num_rows === 0){
					$antwoord['Downloads']='No rows';
				} else{
					$antwoord['Downloads'] = $resultDownloads->fetch_all(MYSQLI_ASSOC);
				}
			}
			echo json_encode($antwoord, JSON_UNESCAPED_UNICODE);
			return;
		}
	}
	$conn->close();

	
?>