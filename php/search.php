<?php
require('cors.php');
require('connect.php');
if ($conn->connect_error) {
  die('Connection failed: ' . $conn->connect_error);
}
$antwoord = [];
$antwoord['results'] = "Geen resultaten gevonden.";
$stmt1 = $conn->prepare('call SearchContentFunction(?,?)');
if(!$stmt1){
  die('Statement preparing failed: ' . $conn->error);
}
$search=$_POST['search'];
$lang = $_POST['lang'];
if(!$stmt1->bind_param("ss",$search,$lang)){
  die('Statement binding failed: ' . $conn->connect_error);
}
if(!$stmt1->execute()){
  die('Statement execution failed: ' . $stmt1->error);
}else{
  $result = $stmt1->get_result();
  if($result->num_rows == 0){
    $antwoord['results']="";
  } else{
    $antwoord['results'] = $result->fetch_all(MYSQLI_ASSOC);

  }
  echo json_encode($antwoord, JSON_PRETTY_PRINT);

}
$stmt1->close();
// TODO: #58 add API, Quotes and Videos to the search
$conn->close();
?>

