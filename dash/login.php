<?php
include('conn.php');
session_start();
if($_SERVER['REQUEST_METHOD'] == "POST")
{
//Username and Password sent from Form
$username = mysqli_real_escape_string($conn, $_POST['user']);
$password = mysqli_real_escape_string($conn, $_POST['pass']);
$password = md5($password);
$sql = "SELECT * FROM Users WHERE User_naam='$username' AND User_Pass= '$password'";
$query = mysqli_query($conn, $sql);
$res=mysqli_num_rows($query);
//If result match $username and $password Table row must be 1 row
if($res == 1)
{
    $_SESSION["user"] = $username;
    //echo $_SESSION["user"];
    header("Location: welcome.php");
}
else
{
echo "Invalid Username or Password";
}
}
?>
<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Dashboard | Login</title>
</head>
<body>
<h1>Login</h1>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
<label>Username</label>
<input type="text" name="user"><br/><br/>
<label>Password</label>
<input type="password" name="pass"><br/><br/>
<input type="submit" name="submit" value="Login"><br/>
</form>
</body>
</html>