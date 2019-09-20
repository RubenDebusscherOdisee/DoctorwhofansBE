<?php 
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
    header('Access-Control-Max-Age: 1000');
    header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
    require ("connect.php");
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $topic['data'] = "Geen topic gevonden.";
    mysqli_set_charset($conn, 'utf8');
    $stmt = $conn->prepare('INSERT INTO Alles_Changes (AC_IP, AC_Old, AC_New,AC_Record,AC_User) VALUES (?,?,?,?,?)');
    if (!$stmt) {die("Statement prepare failed: " . $conn->connect_error);}
    $IP = $_POST['IP'];
    $Old=$_POST['Old'];
    $New= $_POST['New'];
    $Record = $_POST['Id'];
    $User= $_POST['User'];
    if (!$stmt->bind_param("sssis", $IP,$Old,$New,$Record,$User)) {
        die("Statement binding failed: " . $conn->connect_error);
    }
    if (!$stmt->execute()) {
        die("Statement execution failed: " . $stmt->error);
    }
    $stmt->close();
    $conn->close();
    echo '{"status":"ok"}';
?>