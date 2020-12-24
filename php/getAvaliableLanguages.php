<?php
  require("cors.php");
  require("connect.php");
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }
  $antwoord = [];
  mysqli_set_charset($conn,'utf8');
  $stmt = $conn->prepare("select language_Name from management__languages");
  if(!$stmt){
    die("Statement prepare failed: " . $conn->connect_error);
  }

  if(!$stmt->execute()){
    die("Statement execution failed: " . $stmt->error);
  }else{
    $result = $stmt->get_result();
    if($result->num_rows === 0) {
      echo 'false';
      return;
    }else{
      $antwoord= $result->fetch_all(MYSQLI_ASSOC);
    }
  }
  echo json_encode($antwoord, JSON_UNESCAPED_UNICODE)
?>