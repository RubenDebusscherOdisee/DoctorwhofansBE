<?php session_start();
$_SESSION["Menu"]="";?>
<!Doctype>
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
<html lang="nl-BE">

<head>
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <title>
        Doctor Who Fans België
    </title>
    <meta name=author content="Ruben Debusscher" />
    <meta charset=UTF-8 />
    <meta http-equiv=X-UA-Compatible content="chrome=1, IE=edge">
    <meta name=viewport content="width=device-width, initial-scale=1.0" />
    <link rel="manifest" href="https://www.doctorwhofans.be/manifest.json">
    <meta name="theme-color" content="#306090"/>
    <link rel="apple-touch-icon" href="https://ww.doctorwhofans.be/images/logo/apple-icon.png">
    <script>
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', async ()=> {
                let sw = await navigator.serviceWorker.register('https://www.doctorwhofans.be/sw.js');
                console.log(sw);
            })
        }
        /* async function subscribe(){
            let sw = await navigator.serviceWorker.ready;
            let push = await sw.pushManager.subscribe({
                userVisibleOnly:true,
                applicationServerKey:'BAZuh0JHL2M50rX6FSoS-YIRVP6MG1px1f33YAFfxeAEAm40F1xq-Fk8jRe8qV-sJwkCWCux0YWD-acG-HAoWIc'
            })
            console.log(JSON.stringify(push));
        } */
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
    <script type="application/javascript" src="https://sdki.truepush.com/sdk/v2.0.2/app.js" async></script>
<script>
var truepush = window.truepush || [];
truepush.push(function(){
    truepush.Init({
        id: "5fee1993ac24647e216e7ad2"
        }, function(error){
          if(error) console.error(error);
        })
    })
</script>
</body>

</html>


<script>
        var menu = "<?php echo $menu?>";
        var id=Number("<?php echo $id?>");
        if (menu==""){
            menu="Home"
        }
        var main_path='https://www.doctorwhofans.be';
        //getAvailableLangcodes();
        //checkCookie()
    </script>