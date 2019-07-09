<?php 
    require ("connect.php");
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $topic['data'] = "Geen topic gevonden.";
    mysqli_set_charset($conn, 'utf8');
    $stmt = $conn->prepare("INSERT INTO Alles_Logs (LOG_USER, Type, LOG_RECORD,LOG_Timestamp,LOG_IP) VALUES (?,'Insert Record',?,CURRENT_TIMESTAMP,?)");
    if (!$stmt) {
        die("Statement prepare failed: " . $conn->connect_error);
    }
    $User = $_POST['User'];
    $IP = $_POST['IP'];
    $Record = $_POST['Record'];
    if (!$stmt->bind_param("sis", $User, $Record, $IP)) {
        die("Statement binding failed: " . $conn->connect_error);
    }
    if (!$stmt->execute()) {
        die("Statement execution failed: " . $stmt->error);
    }
    $stmt->close();
    $conn->close();
    echo '{"status":"ok"}';
?>
