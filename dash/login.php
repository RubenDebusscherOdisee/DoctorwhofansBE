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
<meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="">
        <link rel="manifest" href="manifest.json">
        <meta name="theme-color" content="#000090"/>
        <link rel="apple-touch-icon" href="images/logo/apple-icon.png">
        <script>
            if ('serviceWorker' in navigator) {
                window.addEventListener('load', function() {
                    navigator.serviceWorker.register('/sw.js').then(function(registration) {
                    // Registration was successful
                    //console.log('ServiceWorker registration successful with scope: ', registration.scope);
                    }, function(err) {
                    // registration failed :(
                    console.error('ServiceWorker registration failed: ', err);
                    });
                });
            }
        </script>
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