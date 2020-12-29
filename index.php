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
        Doctor Who Fans België
    </title>
    <meta name=author content="Ruben Debusscher" />
    <meta charset=UTF-8 />
    <meta http-equiv=X-UA-Compatible content="chrome=1, IE=edge">
    <meta name=viewport content="width=device-width, initial-scale=1.0" />
    <link rel="manifest" href="manifest.json">
    <meta name="theme-color" content="#306090"/>
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
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-107369097-3"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'UA-107369097-3');
    </script>
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<!--     <script>window.jQuery || document.write('<script src="https://www.doctorwhofans.be/trumbowyg/js/vendor/jquery-3.3.1.min.js"><\/script>')</script>
 -->


    <script src="https://www.doctorwhofans.be/js/new.js"></script>


    <link rel="stylesheet" href="https://www.doctorwhofans.be/css/main.css" />
    <script type="text/javascript"
        src="https://platform-api.sharethis.com/js/sharethis.js#property=5e66a481fb4445001239b600&product=inline-share-buttons"
        async="async" async defer></script>
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
        //getAvailableLangcodes();
        //checkCookie()
    </script>