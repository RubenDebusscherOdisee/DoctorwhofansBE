<?php session_start();$_SESSION["Menu"];include_once('php/functions.php');?>
<!Doctype html>
<?php 
    if(isset($_GET['menu'])){
        if (is_numeric($_GET['menu'])) {
            $_SESSION["Menu"]='Home';
        }else{
            $_SESSION["Menu"]=$_GET['menu'];
        }
    }else if ($_SESSION["Menu"] ==null){
        $_SESSION["Menu"]='Home';
    }else{
        $_SESSION["Menu"]=$_SESSION["Menu"];
    }
    $menu = $_SESSION["Menu"];
?>
<html lang="nl">
<head>
    
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-107369097-3"></script>
    <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'UA-107369097-3');
    </script>
    <title>
        <?php $title = str_replace("_", " ", $menu);echo $title. " | Doctor Who Fans BE";?>
    </title>
    <meta name=author content="Ruben Debusscher" />
    <meta charset=UTF-8 />
    <meta http-equiv=X-UA-Compatible content="chrome=1, IE=edge">
    <meta name=description lang=nl
        content="Doctor who is een fenomeen, wereldwijd.  Tijd dat de nederlandstalige fans nu ook een eigen platform krijgen. Hier vind je meer info over <?php echo $title;?>." />
    <meta name=description lang=en
        content="Doctor who is a phenomenon, worldwide. Time that Dutch-speaking fans now also get their own platform. Here you can find more info about <?php echo $title;?>." />
    <META NAME="ROBOTS" CONTENT="NOYDIR, NOODP, NOARCHIVE" />
    <meta name=viewport content="width=device-width, initial-scale=1.0" />
    <link rel="shortcut icon" href="images/favicon.ico" />
    <link rel=icon href="../images/favicon.ico" type="Images/ico" async>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <script src="//code.jquery.com/jquery-1.10.1.min.js"></script>
    <script src="../js/cookies.js"></script>
    <script src="../js/jquery.toc.js"></script>
    <script src="../js/jquery.toc.min.js"></script>
    <script src="../js/main.js"></script>
    <script src="../js/app.js" async></script>
    <script>
        var id;
        session = "<?php echo session_id();?>";
        menu = '<?php echo $menu ;?>';
        $(document).ready(function () {
            if(getCookie("lang")==""){
                setCookie("lang", "nl", 30);
            }
            renderpage(getCookie("lang"),menu)
        });
    </script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js" async></script>
    <script src="../js/editor.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" async>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" async>
    <link href="../opmaak/editor.css" type="text/css" rel="stylesheet" async />
    <link rel=stylesheet href="../opmaak/nav.css" async />
    <link rel=stylesheet href="../opmaak/opmaak.css" async />
    <link href="../opmaak/themify-icons.css" rel="stylesheet" async>
    <link rel=stylesheet href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"
        async>
    <script async>
        $(document).ready(function () {
            if ($(window).width() < 800) {
                $('nav').hide();}
            $('input[type=text]').on('keydown', function (e) {
                if (e.which == 13) {
                    e.preventDefault();
                    ZoekPagina();
                }
            });
        })
        jQuery(document).ready(function () {
            var c = 220,
                b = 500;
            jQuery(window).scroll(function () {
                if (jQuery(this).scrollTop() > c) {
                    jQuery(".back-to-top").fadeIn(b);
                } else {
                    jQuery(".back-to-top").fadeOut(b);
                }
            });
            jQuery(".back-to-top").click(function (e) {
                e.preventDefault();
                jQuery("html, body").animate({
                    scrollTop: 0
                }, b);
                return false;
            });
            jQuery(".taal_link").click(function (f) {
                f.preventDefault();
                jQuery("html, body").animate({
                    scrollTop: 0
                }, b);
                var e = window.innerHeight || document.documentElement.clientHeight || document.body
                    .clientHeight;
                document.getElementById("overlay_background").style.height = e;
                jQuery("#overlay_background, #overlay").fadeIn(b);
                d();
                return false
            });
            jQuery(".close_zoeken").click(function (e) {
                e.preventDefault();
                jQuery("#overlay_background, #overlay_Zoeken").fadeOut(b);
                a();
                return fals