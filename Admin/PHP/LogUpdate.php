<?php 
    require ("connect.php");
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $topic['data'] = "Geen topic gevonden.";
    mysqli_set_charset($conn, 'utf8');
    $stmt = $conn->prepare("INSERT INTO Alles_Changes (AC_Old, AC_New,AC_Datum,AC_Record,AC_User,AC_IP) VALUES (?,?,CURRENT_TIMESTAMP,?,?,?)");
    if (!$stmt) {
        die("Statement prepare failed: " . $conn->connect_error);
    }
    $User = $_POST['User'];
    $IP = $_POST['IP'];
    $Record = $_POST['Record'];
    $Old=$_POST['Old'];
    $Old = json_encode($Old);
    $Old= substr($Old, 1);
    $Old = substr($Old, 0, -1);
    $Old = "'{". $Old. "}'";

    $New=$_POST['New'];
    $New = json_encode($New);
    $New= substr($New, 1);
    $New = substr($New, 0, -1);
    $New = "'{". $New. "}'";
    echo $Old;
    if (!$stmt->bind_param("ssiss",$Old,$New, $Record, $User,$IP)) {
        die("Statement binding failed: " . $conn->connect_error);
    }
    if (!$stmt->execute()) {
        die("Statement execution failed: " . $stmt->error);
    }
    $stmt->close();
    $conn->close();
    echo '{"status":"ok"}';
?>
