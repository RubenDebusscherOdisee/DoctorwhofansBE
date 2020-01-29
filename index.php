<?php session_start();$_SESSION["Menu"];include_once('php/functions.php');?>
<!Doctype html lang ="nl-BE">
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
    <script src="https://www.localeplanet.com/api/auto/icu.js"></script>
    <script src="https://www.localeplanet.com/api/translate.js"></script>
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
            getAvailableLangcodes();
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
                return false
            });
            jQuery(".close").click(function (e) {
                e.preventDefault();
                jQuery("#overlay_background, #overlay").fadeOut(b);
                a();
                return false
            });
            function a() {
                document.documentElement.style.overflow = "auto";
                document.body.scroll = "yes"
            }
            function d() {
                document.documentElement.style.overflow = "hidden";
                document.body.scroll = "no"
            }
        });
        $(function () {
            $("#foto_taal_button").click(function () {
                function a() {
                    document.getElementById("overlay").style.display = "block";
                    document.getElementById("overlay_background").style.display = "block"
                }
                function b() {
                    document.getElementById("overlay").style.display = "none";
                    document.getElementById("overlay_background").style.display = "none"
                }
            })
        });
        setTimeout(function () {
            $("#loading_div").fadeOut(300);
            setTimeout(function () {
                $(".col-6").fadeIn(300);
                $(".under").fadeIn(300)
            }, 100)
        }, 1500);
    </script>
</head>
<body class=init onload="">
    <button role=button onclick="ToggleMenu()" id=show-menu> <i class="fa fa-navicon"></i> Menu&nbsp;&nbsp; </button>
    
    <nav>
        <ul class="nav-menu">
            <li class="nav-item">
                <a href="../Home/" aria-label="Home"><img src="../images/gallifreyan_black.png" alt="Logo of Doctorwhofans Belgium" id="Logo"/> Home</a>
            </li>
            <li class="nav-item">
                <a href="#">who is Who? <i class="fa fa-arrow-down" aria-hidden="true"></i></a>
                <div class="sub-nav">
                    <ul class="sub-nav-group">
                        <h3>Doctors</h3>
                        <li><a href="../First_Doctor/">First Doctor</a></li>
                        <li><a href="../Second_Doctor/">Second Doctor</a></li>
                        <li><a href="../Third_Doctor/">Third Doctor</a></li>
                        <li><a href="../Fourth_Doctor/">Fourth Doctor</a></li>
                        <li><a href="../Fifth_Doctor/">Fifth Doctor</a></li>
                        <li><a href="../Sixth_Doctor/">Sixth Doctor</a></li>
                        <li><a href="../Seventh_Doctor/">Seventh Doctor</a></li>
                        <li><a href="../Eighth_Doctor/">Eighth Doctor</a></li>
                        <li>
                            <hr>
                        </li>
                        <li><a href="../War_Doctor/">The War Doctor</a></li>
                        <li><a href="../Ninth_Doctor/">Ninth Doctor</a></li>
                        <li><a href="../Tenth_Doctor/">Tenth Doctor</a></li>
                        <li><a href="../Eleventh_Doctor/">Eleventh Doctor</a></li>
                        <li><a href="../Twelfth_Doctor/">Twelfth Doctor</a></li>
                        <li><a href="../Thirteenth_Doctor/">Thirteenth Doctor</a></li>
                    </ul>
                    <ul class="sub-nav-group">
                        <h3>Characters</h3>
                        <li>
                            <a href="../Companions/" aria-label="Companions">
                                <span class="fa-layers fa-fw">
                                    <i class="fa fa-male" data-fa-transform="right:18"></i>
                                    <i class="fa fa-female" data-fa-transform="left-18"></i>
                                </span>Companions
                            </a>
                        </li>
                        <li><a href="../Villains/">Villains</a></li>
                        <li><a href="../Allies/">Allies</a></li>
                        <li>
                            <hr>
                        </li>
                        <h3>Spin-off</h3>
                        <li><a href="../Torchwood/"><img src="../images/Torchwood.png" alt="Torchwood logo" />Torchwood</a></li>
                        <li><a href="../Sarah_Jane_Adventures/"><img src="../images/SJA.png" alt="Sarah Jane Adventures logo" /> Sarah Jane Adventures</a></li>
                        <li><a href="../Class/"><img src="../images/Class.png" alt="Class logo" /> Class</a></li>
                    </ul>
                    <ul class="sub-nav-group">
                        <h3>Concepts</h3>

                        <li><a href="../TARDIS/"><img src="../images/tardis.png" alt="TARDIS logo" />T.A.R.D.I.S</a></li>
                        <li><a href="../Sonic_Screwdriver/">Sonic Screwdriver</a>
                        </li>
                        <li><a href="../UNIT/"><img src="../images/UNIT.png" alt="UNIT logo" /> UN.I.T</a></li>
                        
                        <li>
                            <hr>
                        </li>
                        <li><a href="../Species/">Species</a></li>
                        <li><a href="../Places/"><i class="fa fa-compass" aria-hidden="true"></i> Places</a></li>
                        <li><a href="../Times/"><i class="fa fa-code-fork" aria-hidden="true"></i> Times</a></li>
                        <li><a href="../Quotes/"> <i class="fa fa-quote-right" aria-hidden="true"></i> Quotes</a></li>
                    </ul>
                </div>
            </li>
            <li class="nav-item">
                <a href="#">Series <i class="fa fa-arrow-down" aria-hidden="true"></i></a>
                <div class="sub-nav">
                    <ul class="sub-nav-group">
                        <h3>the Show</h3>
                        <li><a href="../Synopsis/">Synopsis</a></li>
                        <li><a href="../Episodes/">Episodes</a></li>
                        <li><a href="../History/">History</a></li>
                        <li><a href="../Crew/">Crew</a></li>
                        <li><a href="../Cast/">Cast</a></li>
                        <li><a href="../Characters/">Characters</a></li>
                        <li><a href="../Music/"><i class="fa fa-music" aria-hidden="true"></i> Music</a></li>
                        <li>
                            <hr>
                        </li>
                        <li><a href="../Reviews/">Reviews</a></li>
                    </ul>
                    <ul class="sub-nav-group">
                        <h3>Media</h3>
                        <li><a href="../DVD/">DVD</a></li>
                        <li><a href="../Books/"><i class="fa fa-book" aria-hidden="true"></i> Books</a></li>
                        <li><a href="../Comics/">Comics</a></li>
                        <li><a href="../Audio/">Audio</a></li>
                        <li><a href="../Non_Fiction/"> Non-fiction</a></li>
                        <li><a href="../Magazines/">Magazines</a></li>
                        <li><a href="../Varia/">Varia</a></li>
                        <li><a href="../Merchandise/">Merchandise</a></li>
                    </ul>
                    
                </div>
            </li>
            <li class="nav-item">
                <a href="#">Fans <i class="fa fa-arrow-down" aria-hidden="true"></i></a>
                <div class="sub-nav">
                    <ul class="sub-nav-group">
                       <h3>To see</h3> 
                       <li><a href="../Pictures/"><i class="fa fa-file-image-o" aria-hidden="true"></i> Pictures</a></li>
                        <li><a href="../Video/"><i class="fa fa-youtube-play" aria-hidden="true"></i> Video</a></li>
                        <li><a href="../Transcripts/"><i class="fa fa-file-text-o" aria-hidden="true"></i>Transcripts</a></li>
                        <li><a href="../Cosplay/"><i class="fa fa-user-secret" aria-hidden="true"></i>Cosplay</a></li>
                    </ul>
                    <ul class="sub-nav-group">
                        <h3>To Join</h3>
                        <li><a href="../Events/"><i class="fa fa-calendar" aria-hidden="true"></i> Events</a></li>
                        <li><a href="../Fanclubs/"><i class="fa fa-users" aria-hidden="true"></i> Fanclubs</a></li>
                        <li><a href="../Links/"><i class="fa fa-link" aria-hidden="true"></i>Links</a></li>
                        <li><a href="../DIY/"><i class="fa fa-wrench" aria-hidden="true"></i>DIY</a></li>
                    </ul>               
                </div>
            </li>
            <li class="nav-item">
                <a href="../News/" aria-label="News"><i class="fa fa-newspaper-o" aria-hidden="true"></i> News</a>
            </li>

            <li class="nav-item">
                <a href="https://forum.doctorwhofans.be"><i class="fa fa-comments-o"></i> Forum</a>
            </li>
            <li class="nav-item">
                <a href="../Contact/"><i class="fa fa-envelope" aria-hidden="true"></i> Contact</a>
            </li>
            <li class="nav-item right">
                <a href="#"><i class="fa fa-search fa-2x" aria-hidden="true" title="Zoeken"></i></a>
                <div class="sub-nav">
                    <form method="post" class="zoekformulier">
                        <label for="zoekterm" class="zoeklabel">Zoeken: </label>
                        <input class="zoekterm" type="text" name="zoekterm" placeholder="Zoeken..." value=""
                            title="zoeken" id="zoekterm" />
                        <button class="zoekknop" type="submit" title="Zoeken" name="zoeken" onclick="ZoekPagina()"
                            value=" "></button>
                    </form>
                </div>
            </li>
            <li class="nav-item right">
                <a href="#"><i class="fa fa-gear fa-2x" aria-hidden="true" title="Instellingen"></i></a>
                <div class="sub-nav">
                    <form>
                        <fieldset>
                            <legend>Accessibility</legend>
                            <button class=toegang id=toegang onclick="addAcces()" type="button">Toegankelijkheid verhogen</button>
                            <button class="toegang hide" id=toegangRemove onclick="removeAccess()" type="button">Normale modus</button>
                            <button class="RemoveImages" id="RemoveImages" type="button" onclick="RemoveImg()">Verwijder Afbeeldingen</button>
                            <button class="RemoveImages hide" id="RestoreImages" type="button" onclick="RestoreImg()">Toon Afbeeldingen</button>
                            <input type="button" id="increase" value="+">
                            <span id="size">0</span>
                            <input type="button" id="decrease" value="-">
                        </fieldset>
                        <button id="print" type="button" onclick="window.print()">Print</button>
                        <button class="taal_link" type="button" title="taalkeuze">
                            <img src="../images/overlay/52349.png" alt="Globe voor taalkeuze" class="taal_link" /> Kies uw taal</button>
                    </form>
                </div>
            </li>
        </ul>
    </nav>
    
    <div id="wrapper">
    <div class="path"></div>

    <div id=loading_div>
        <img id=loading src="../images/ledtorch.1498524411.png" class="loading_img" alt="Laden">
    </div>
    <article class=col-6>
        <?php
                if($menu=="Sitemap"){
                    $res = fetchCategoryTreeList();
                    foreach ($res as $r) {
                        echo  $r;
                    }
                    ?>
        <script>
            $(".parent").next().hide();
            $("ul:first").css("margin-left", "-4em");
        </script>
        <?php
                }
                ?>
    </article>
    <article class="under col-5">
        <?php
                if($menu=='Contact'){
                    require("php/Contact.php");
                }
                if($menu=='Events'){
                    require("php/Kalender.php");
                }
            ?>
    </article>
    </div>
    
    <footer id=footer class=col-5>
        <p class='mededeling'>  </p>
        <p class="socialmedia">
            <a href="https://www.facebook.com/DoctorWhoFansBE/" target="_blank"><img
                    src="../images/Social/facebook_logo.png" alt="Facebook Logo" /></a>
            <a href="https://rubendebusscherodisee.github.io/DoctorwhofansBE/" target="_blank"><img
                    src="../images/Social/github_logo.png" class="Github_Logo" alt="Github Logo" /></a><br>
            <a href="../Sitemap/" class=" socialmedia_full link">Sitemap</a>
        </p>
        <p class=disclaimer> 
        </p>
    </footer>
    
    <script async src="../js/toegang.js" async></script>
    <a href="#" class=back-to-top><img src="../images/back_to_top.png" class=back_to_top_IMG alt="Back to top" /></a>
    <div id=overlay_background></div>
    <div id="overlay_Zoeken">
        <a href=# class="close_zoeken link"><img src="../images/overlay/981077-32.png" alt="Sluiten/Close"
                class=close_IMG /> Close</a>
        <div class="open-close">
            <div class="resultset holder" style="border:4px solid yelllow" id="resultset1">
                <div class="header" style="width:100%;background-color:yellow;color:black">
                    <a class="opner" href="#" onClick="ToggleResult('resultcontent')">Pages</a>
                </div>
            </div>
            <div class="resultset second holder" style="border:1px solid yelllow" id="resultset2">
                <div class="header" style="width:100%;background-color:yellow;color:black">
                    <a class="opner" href="#" onClick="ToggleResult('resultvideo')">Videos</a>
                </div>
            </div>
            <div class="resultset third holder" style="border:1px solid yelllow" id="resultset3">
                <div class="header" style="width:100%;background-color:yellow;color:black">
                    <a class="opner" href="#" onClick="ToggleResult('resultQuote')">Quotes</a>
                </div>
            </div>
        </div>
    </div>
    <div id=overlay>
        <h1>Kies uw taal</h1>
        <div class=taal>
            <a href="#" class="link" onClick='changelang("nl")'>
                <img src="../images/overlay/belgium_640.png" alt="vlag van Belgi&euml; voor Nederlands."
                    class="foto_taal_button" />
                Nederlands
                <img src="../images/overlay/netherlands_640.png" alt="vlag van Nederland; voor Nederlands."
                    class=foto_taal_button>
            </a>
        </div>
        <div class=taal>
            <a href="#" class="link" onClick='changelang("en")'>
                <img src="../images/overlay/united_kingdom_640.png" alt="vlag van Engeland voor Engels."
                    class="foto_taal_button" />
                English
                <img src="../images/overlay/united_states_of_america_64.png" alt="vlag van de VS; voor Engels."
                    class=foto_taal_button>
            </a>
        </div>
        <div class=taal>
            <a href=# class="close link"><img src="../images/overlay/981077-32.png" alt="Sluiten/Close"
                    class=close_IMG /> Close</a>
        </div>
    </div>
    <script src="../js/jquery-accessibleMegaMenu.js"></script>

</body>
</html>