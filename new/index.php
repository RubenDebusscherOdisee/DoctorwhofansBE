<?php session_start();
$_SESSION["Menu"]="";?>
<!Doctype html lang="nl-BE">
<?php 
    if(isset($_GET['menu'])){
        $menu=$_GET['menu'];
    }else if ($_SESSION["Menu"] !==""){
        $menu=$_SESSION["Menu"];
    }else{
        $menu= "Home";
    }
    if(isset($_GET['id'])){
        $id= $_GET['id'];
    }

    
?>
<html lang="nl">

<head>
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <title>
        Test
    </title>
    <meta name=author content="Ruben Debusscher" />
    <meta charset=UTF-8 />
    <meta http-equiv=X-UA-Compatible content="chrome=1, IE=edge">
    <meta name=viewport content="width=device-width, initial-scale=1.0" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="/js/new.js"></script>
    <link rel="stylesheet" href="/css/main.css" />
</head>

<body>
<a href="#SiteContent" class="sr-only skip">Skip to content</a>

    <?php
        include_once 'includes/nav.html';
        include_once 'includes/main.html';
        include_once 'includes/overlays.html';
        include_once 'includes/footer.html';
    ?>
</body>

</html>

<script>
        var menu = "<?php echo $menu?>";
        if (menu==""){
            menu="Home"
        }
        var main_path='https://www.doctorwhofans.be';
        getAvailableLangcodes();
        GetContent(menu);
    </script>