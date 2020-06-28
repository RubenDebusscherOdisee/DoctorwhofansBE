<?php session_start();$_SESSION["Menu"];include_once('php/functions.php');?>
<!Doctype html lang="nl-BE">

<?php 
    if(isset($_GET['menu'])){
        if (is_numeric($_GET['menu'])||searchForFile($_SERVER['DOCUMENT_ROOT'].$_GET['menu'].".*")==TRUE) {
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

    if(isset($_GET['id'])){
        $id= $_GET['id'];
    }

    function searchForFile($fileToSearchFor){
        $numberOfFiles = count(glob($fileToSearchFor));
        if($numberOfFiles == 0){ return(FALSE); } else { return(TRUE);}
    }
?>
<html lang="nl">

<head>
    <link rel="manifest" href="../manifest.json">
    <link rel="manifest" href="../manifest.webmanifest">
    <meta name="theme-color" content="#000090" />
    <link rel="apple-touch-icon" href="../images/logo/apple-icon.png">
    <script>
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', function () {
                navigator.serviceWorker.register('../sw.js').then(function (registration) {
                    // Registration was successful
                    console.log('ServiceWorker registration successful with scope: ', registration
                        .scope);
                }, function (err) {
                    //registration failed :(
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
    <script src="../js/full.min.js"></script>
    <script defer>
        var id;
        var ItemId;
        session = "<?php echo session_id();?>";
        menu = '<?php echo $menu ;?>';
        ItemId = '<?php echo $id ;?>';
        $(document).ready(function () {
            getAvailableLangcodes();
        });
    </script>
    <link rel=stylesheet href="../opmaak/new.min.css" async defer preload />
    <script defer>
        $(document).ready(function () {
            $('li a[href="..'+window.location.pathname.substring(0, window.location.pathname.lastIndexOf('/')+1)+'"]').addClass('current_page')
            $(".col-6").hide();
            $(".under").hide();
            checkModefromCookie();
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
            $(".col-6").fadeIn(400);
            $(".under").fadeIn(400);
        }, 1500);
    </script>
    <script type="text/javascript"
        src="https://platform-api.sharethis.com/js/sharethis.js#property=5e66a481fb4445001239b600&product=inline-share-buttons"
        async="async" async defer></script>
</head>

<body class=init onload="">
    <!-- TODO: #42 Create a button to skip to the content for screen readers-->
    <nav class="megamenu">
        <button class="accessible-megamenu-toggle" aria-expanded="false">
            <span class="sr-only">Toggle Navigation</span>
            <span></span><span></span><span></span>
        </button>
        <ol>
            <li>
                <h2><a href="../Home/" class="toplink"><img class="lazyload" data-src="../images/gallifreyan_black.png"
                            alt="Logo of Doctorwhofans Belgium" id="Logo" />Home</a></h2>
                <div class="cols-0">
                </div>
            </li>
            <li>
                <h2><a href="#whoIsWho">who is Who <i class="fa fa-arrow-down" aria-hidden="true"></i></a></h2>
                <div class="cols-4c">
                    <ol>
                        <li class="accessible-megamenu-panel-group">
                            <h3><a href="../The_Doctor/">The Doctor</a></h3>
                            <ol>
                                <li><a href="../First_Doctor/">First Doctor</a></li>
                                <li><a href="../Second_Doctor/">Second Doctor</a></li>
                                <li><a href="../Third_Doctor/">Third Doctor</a></li>
                                <li><a href="../Fourth_Doctor/">Fourth Doctor</a></li>
                                <li><a href="../Fifth_Doctor/">Fifth Doctor</a></li>
                                <li><a href="../Sixth_Doctor/">Sixth Doctor</a></li>
                                <li><a href="../Seventh_Doctor/">Seventh Doctor</a></li>
                                <li><a href="../Eighth_Doctor/">Eighth Doctor</a></li>

                                <hr>
                                <li><a href="../War_Doctor/">The War Doctor</a></li>
                                <li><a href="../Ninth_Doctor/">Ninth Doctor</a></li>
                                <li><a href="../Tenth_Doctor/">Tenth Doctor</a></li>
                                <li><a href="../Eleventh_Doctor/">Eleventh Doctor</a></li>
                                <li><a href="../Twelfth_Doctor/">Twelfth Doctor</a></li>
                                <li><a href="../Thirteenth_Doctor/">Thirteenth Doctor</a></li>
                            </ol>
                        </li>
                        <li class="accessible-megamenu-panel-group">
                            <h3><a href="../Characters/">Characters</a></h3>
                            <ol>
                                <li>
                                    <a href="../Category:Companions/" aria-label="Companions"> Companions <i
                                            class="fa fa-male"></i><i class="fa fa-female"></i>
                                    </a>
                                </li>
                                <li><a href="../Villains/">Villains</a></li>
                                <li><a href="../Allies/">Allies</a></li>
                            </ol>
                            <hr>
                            <h2>Spin-off</h2>
                            <ol>
                                <li><a href="../Torchwood/"><img class="lazyload" data-src="../images/Torchwood.png" alt="Torchwood logo" />Torchwood</a></li>
                                <li><a href="../Sarah_Jane_Adventures/"><img class="lazyload" data-src="../images/SJA.png" alt="Sarah Jane Adventures logo" /> Sarah Jane Adventures</a></li>
                                <li><a href="../Class/"><img class="lazyload" data-src="../images/Class.png" alt="Class logo" /> Class</a></li>
                            </ol>
                        </li>
                        <li class="accessible-megamenu-panel-group">
                            <h3>Concepts</h3>
                            <ol>
                                <li><a href="../TARDIS/"><img class="lazyload" data-src="../images/tardis.png"
                                            alt="TARDIS logo" />T.A.R.D.I.S</a></li>
                                <li><a href="../Sonic_Screwdriver/">Sonic Screwdriver</a>
                                </li>
                                <li><a href="../UNIT/"><img class="lazyload" data-src="../images/UNIT.png"
                                            alt="UNIT logo" />
                                        UN.I.T</a></li>

                                <li>
                            </ol>
                            <hr>
                            <ol>
                                <li><a href="../Species/">Species</a></li>
                                <li><a href="../Places/"><i class="fa fa-compass" aria-hidden="true"></i> Places</a>
                                </li>
                                <li><a href="../Times/"><i class="fa fa-code-fork" aria-hidden="true"></i> Times</a>
                                </li>
                                <li><a href="../Quotes/"> <i class="fa fa-quote-right" aria-hidden="true"></i> Quotes</a></li>
                            </ol>
                        </li>
                    </ol>
                </div>
            </li>
            <li>
                <h2><a href="#">Series <i class="fa fa-arrow-down" aria-hidden="true"></i></a></h2>
                <div class="cols-4d">
                    <ol>
                        <li class="accessible-megamenu-panel-group">
                            <h3>The Show</h3>
                            <ol>
                                <li><a href="../Synopsis/">Synopsis</a></li>
                                <li><a href="../Episodes/">Episodes</a></li>
                                <li><a href="../History/">History</a></li>
                                <li><a href="../Crew/">Crew</a></li>
                                <li><a href="../Cast/">Cast</a></li>
                                <li><a href="../Music/"><i class="fa fa-music" aria-hidden="true"></i> Music</a></li>
                                <hr>
                                <li><a href="../Reviews/">Reviews</a></li>
                            </ol>
                        </li>
                        <li class="accessible-megamenu-panel-group">
                            <h3>Media</h3>
                            <ol>
                                <li><a href="../DVD/">DVD</a></li>
                                <li><a href="../Books/"><i class="fa fa-book" aria-hidden="true"></i> Books</a></li>
                                <li><a href="../Comics/">Comics</a></li>
                                <li><a href="../Audio/">Audio</a></li>
                                <li><a href="../Non_Fiction/"> Non-fiction</a></li>
                                <li><a href="../Magazines/">Magazines</a></li>
                                <li><a href="../Varia/">Varia</a></li>
                                <li><a href="../Merchandise/">Merchandise</a></li>
                            </ol>
                        </li>
                    </ol>
                </div>
            </li>
            <li>
                <h2><a href="#">Fans <i class="fa fa-arrow-down" aria-hidden="true"></i></a></h2>
                <div class="cols-4d">
                    <ol>
                        <li class="accessible-megamenu-panel-group">
                            <h3>To Watch</h3>
                            <ol>
                                <li><a href="../Pictures/"><i class="fa fa-file-image-o" aria-hidden="true"></i>
                                        Pictures</a></li>
                                <li><a href="../Video/"><i class="fa fa-youtube-play" aria-hidden="true"></i> Video</a>
                                </li>
                                <li><a href="../Transcripts/"><i class="fa fa-file-text-o" aria-hidden="true"></i>
                                        Transcripts</a></li>
                            </ol>
                            <hr>
                            <h3>To learn</h3>
                            <ol>
                                <li><a href="../Questions/"><i class="fa fa-question" aria-hidden="true"></i>
                                        Questions</a></li>
                            </ol>
                        </li>
                        <li class="accessible-megamenu-panel-group">
                            <h3>To Do</h3>
                            <ol>
                                <li><a href="../Events/"><i class="fa fa-calendar" aria-hidden="true"></i> Events</a>
                                </li>
                                <li><a href="../Fanclubs/"><i class="fa fa-users" aria-hidden="true"></i> Fanclubs</a>
                                </li>
                                <li><a href="../Links/"><i class="fa fa-link" aria-hidden="true"></i> Links</a></li>
                                <li><a href="../Cosplay/"><i class="fa fa-user-secret" aria-hidden="true"></i>
                                        Cosplay</a></li>
                                <li><a href="../DIY/"><i class="fa fa-wrench" aria-hidden="true"></i> DIY</a></li>
                            </ol>
                        </li>
                    </ol>
                </div>
            </li>
            <li>
                <h2><a href="../News/" class="toplink">News <i class="fa fa-newspaper-o" aria-hidden="true"></i></a>
                </h2>
                <div class="cols-0">
                </div>
            </li>
            <li>
                <h2><a href="https://forum.doctorwhofans.be" class="toplink">Forum <i class="fa fa-comments-o"
                            aria-hidden="true"></i></a></h2>
                <div class="cols-0">
                </div>
            </li>
            <li>
                <h2><a href="../Contact/" class="toplink">Contact <i class="fa fa-envelope" aria-hidden="true"></i></a>
                </h2>
                <div class="cols-0">
                </div>
            </li>
            <li id="search" class="rightItem">
                <h2><a href="#Search">Zoeken <i class="fa fa-search" aria-hidden="true" title="Zoeken"></i></a></h2>
                <div class="cols-4d rightBox">
                    <ol>
                        <form method="post" class="zoekformulier">
                            <label for="zoekterm" class="zoeklabel">Zoeken: </label>
                            <input class="zoekterm" type="text" name="zoekterm" placeholder="Zoeken..." value=""
                                title="zoeken" id="zoekterm" />
                            <button class="zoekknop" type="submit" title="Zoeken" name="zoeken" onclick="ZoekPagina()"
                                value=" ">
                                <i class="fa fa-search" aria-hidden="true"></i>
                            </button>
                        </form>
                    </ol>
                </div>
            </li>
            <li class="rightItem">
                <h2><a href="#Search">Settings <i class="fa fa-gear" aria-hidden="true" title="Settings"></i></a></h2>
                <div class="cols-4d rightBox">
                    <h3>Settings</h3>
                    <ol>
                        <form>
                            <fieldset>
                                <legend>Accessibility</legend>
                                <button class=toegang id=toegang onclick="toggleAccess()" type="button">Toegankelijkheid
                                    verhogen</button>

                                <button class="RemoveImages" id="RemoveImages" type="button"
                                    onclick="ToggleImg()">Toggle
                                    Afbeeldingen</button>
                                <input type="button" id="increase" value="+">
                                <span id="size">0</span>
                                <input type="button" id="decrease" value="-">
                                <button onclick="ToggleNightMode()" id="NightMode"><i class="fa fa-moon-o"
                                        aria-hidden="true"></i></button>
                                <!--TODO: #40 Allow for different fonts, so user can change the font to one that works best for him/her-->
                            </fieldset>
                            <button id="print" type="button" onclick="window.print()">Print</button>
                            <button class="taal_link" type="button" title="taalkeuze">
                                <i class="fa fa-globe"></i> Kies uw taal</button>
                        </form>
                    </ol>
                </div>
            </li>

        </ol>
    </nav>

    <main id="wrapper">

        <div class="path DarkBlueBackground"></div>
        <div id=loading_div>
            <img id=loading data-src="../images/gallifreyan_blue.png" class="lazyload loading_img" alt="Laden">
        </div>
        <article class=col-6>
           
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
    </main>

    <footer id=footer class=col-5>
        <a href="../Sitemap/" class=" socialmedia_full link">Sitemap</a><br>
        <p class='mededeling max_34 column'> </p>
        <div class="socialmedia column">

            <div class="sharethis-inline-follow-buttons"></div>
            <span>Or Share this page:</span>
            <div class="sharethis-inline-share-buttons"></div>
        </div>
        <p class='quote bordered padded DarkBlueBackground max_20 column'></p>
        <p class=disclaimer>
        </p>
    </footer>

    <a href="#" id="Back_To_Top" class="back-to-top" onclick="topFunction(0)"><img class="lazyload back_to_top_IMG"
            data-src="../images/back_to_top.png" class=back_to_top_IMG alt="Back to top" /></a>
    <div id=overlay_background></div>
    <div id="overlay_Zoeken" class="darkBlueBackground bordered padded">
        <a href=# class="close_zoeken link"><img class="lazyload" data-src="../images/overlay/981077-32.png" alt="Sluiten/Close" class=close_IMG /> Close</a>
        <div id="resultSet"></div>
    </div>
    <div id=overlay class="darkBlueBackground bordered padded">
        <h1>Kies uw taal</h1>
        <div class=taal>
            <a href="#" class="link" onClick='changelang("nl")'>
                <img class="lazyload" data-src="../images/overlay/belgium_640.png"
                    alt="vlag van België; voor Nederlands." class="foto_taal_button" />
                Nederlands
                <img class="lazyload" data-src="../images/overlay/netherlands_640.png"
                    alt="vlag van Nederland; voor Nederlands." class=foto_taal_button>
            </a>
        </div>
        <div class=taal>
            <a href="#" class="link" onClick='changelang("en")'>
                <img class="lazyload" data-src="../images/overlay/united_kingdom_640.png"
                    alt="vlag van Engeland voor Engels." class="foto_taal_button" />
                English
                <img class="lazyload" data-src="../images/overlay/united_states_of_america_64.png"
                    alt="vlag van de VS; voor Engels." class=foto_taal_button>
            </a>
        </div>
        <div class=taal>
            <a href=# class="close link">
                <img class="lazyload" data-src="../images/overlay/981077-32.png" alt="Sluiten/Close" class=close_IMG />
                Close</a>
        </div>
    </div>

</body>

</html>