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
        $_SESSION["Menu"]="Home";
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
    <link rel="manifest" href="manifest.json">
    <link rel="manifest" href="manifest.webmanifest">
    <meta name="theme-color" content="#000090" />
    <link rel="apple-touch-icon" href="images/logo/apple-icon.png">
    <script>



        if ('serviceWorker' in navigator) {
        navigator.serviceWorker.register('sw.js')
        .then((reg) => {
            // registration worked
            console.log('Registration succeeded. Scope is ' + reg.scope);
        }).catch((error) => {
            // registration failed
            console.log('Registration failed with ' + error);
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
    <?php
        if (strripos($menu, '/') !== false) {
            $title = strrchr($menu, '/');;
            $title = str_replace('/', '', $title);
            $title = str_replace("_", " ", $title);
        
            
        }else{
            $title = str_replace("_"," ", $menu);
        }
            ?>
    <title>
        <?php echo $title. " | Doctor Who Fans BE";?>
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
    <link rel=icon href="https://www.doctorwhofans.be/images/favicon.ico" type="Images/ico" async>
    <script src='https://www.doctorwhofans.be/js/full.js'></script>
    <script defer>
        var id;
        var ItemId;
        session = "<?php echo session_id();?>";
        menu = '<?php echo $menu ;?>';
        ItemId = '<?php echo $id ;?>';
        var rootURL = getRootUrl();
        $(document).ready(function () {
            getAvailableLangcodes();
            $("nav a[href$='.html']" ).each(function(){ 
            var oldUrl = $(this).attr("href"); // Get current url
            oldUrl = rootURL+oldUrl
            var newUrl = oldUrl.replace("http://", "https://"); // Create new url
            $(this).attr("href", newUrl); // Set href value
        });
        });
    </script>
    <link rel=stylesheet href="https://www.doctorwhofans.be/opmaak/new.min.css" defer preload />
    <script defer>
        $(document).ready(function () {
            var currentPage = rootURL+window.location.pathname;
            $('li a[href$="'+window.location.pathname+'"]').addClass('current_page');
            $('li a[href$="'+window.location.pathname+'"]').parent().parent().parent().parent().parent().parent().children('h2').children().addClass('current_page');
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
                <h2><a href="Home.html" class="toplink"><img class="lazyLoad" data-src="https://www.doctorwhofans.be/images/gallifreyan_black.png"
                            alt="Logo of Doctor Who Fans Belgium" id="Logo" />Home</a></h2>
                <div class="cols-0">
                </div>
            </li>
            <li>
                <h2><a href="#whoIsWho">who is Who <i class="fa fa-arrow-down" aria-hidden="true"></i></a></h2>
                <div class="cols-4c">
                    <ol>
                        <li class="accessible-megamenu-panel-group">
                            <h3><a href="The_Doctor.html">The Doctor</a></h3>
                            <ol>
                                <li><a href="First_Doctor.html">First Doctor</a></li>
                                <li><a href="Second_Doctor.html">Second Doctor</a></li>
                                <li><a href="Third_Doctor.html">Third Doctor</a></li>
                                <li><a href="Fourth_Doctor.html">Fourth Doctor</a></li>
                                <li><a href="Fifth_Doctor.html">Fifth Doctor</a></li>
                                <li><a href="Sixth_Doctor.html">Sixth Doctor</a></li>
                                <li><a href="Seventh_Doctor.html">Seventh Doctor</a></li>
                                <li><a href="Eighth_Doctor.html">Eighth Doctor</a></li>

                                <hr>
                                <li><a href="War_Doctor.html">The War Doctor</a></li>
                                <li><a href="Ninth_Doctor.html">Ninth Doctor</a></li>
                                <li><a href="Tenth_Doctor.html">Tenth Doctor</a></li>
                                <li><a href="Eleventh_Doctor.html">Eleventh Doctor</a></li>
                                <li><a href="Twelfth_Doctor.html">Twelfth Doctor</a></li>
                                <li><a href="Thirteenth_Doctor.html">Thirteenth Doctor</a></li>
                            </ol>
                        </li>
                        <li class="accessible-megamenu-panel-group">
                            <h3><a href="Characters.html">Characters</a></h3>
                            <ol>
                                <li>
                                    <a href="Category:Companions.html" aria-label="Companions"> Companions <i
                                            class="fa fa-male"></i><i class="fa fa-female"></i>
                                    </a>
                                </li>
                                <li><a href="Villains.html">Villains</a></li>
                                <li><a href="Allies.html">Allies</a></li>
                            </ol>
                            <hr>
                            <h2>Spin-off</h2>
                            <ol>
                                <li><a href="Torchwood.html"><img class="lazyLoad" data-src="https://www.doctorwhofans.be/images/Torchwood.png" alt="Torchwood logo" />Torchwood</a></li>
                                <li><a href="Sarah_Jane_Adventures.html"><img class="lazyLoad" data-src="https://www.doctorwhofans.be/images/SJA.png" alt="Sarah Jane Adventures logo" /> Sarah Jane Adventures</a></li>
                                <li><a href="Class.html"><img class="lazyLoad" data-src="https://www.doctorwhofans.be/images/Class.png" alt="Class logo" /> Class</a></li>
                            </ol>
                        </li>
                        <li class="accessible-megamenu-panel-group">
                            <h3>Concepts</h3>
                            <ol>
                                <li><a href="TARDIS.html"><img class="lazyLoad" data-src="https://www.doctorwhofans.be/images/tardis.png"
                                            alt="TARDIS logo" />T.A.R.D.I.S</a></li>
                                <li><a href="Sonic_Screwdriver.html">Sonic Screwdriver</a>
                                </li>
                                <li><a href="UNIT.html"><img class="lazyLoad" data-src="https://www.doctorwhofans.be/images/UNIT.png"
                                            alt="UNIT logo" />
                                        UN.I.T</a></li>

                                <li>
                            </ol>
                            <hr>
                            <ol>
                                <li><a href="Species.html">Species</a></li>
                                <li><a href="Places.html"><i class="fa fa-compass" aria-hidden="true"></i> Places</a>
                                </li>
                                <li><a href="Times.html"><i class="fa fa-code-fork" aria-hidden="true"></i> Times</a>
                                </li>
                                <li><a href="Quotes.html"> <i class="fa fa-quote-right" aria-hidden="true"></i> Quotes</a></li>
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
                                <li><a href="Synopsis.html">Synopsis</a></li>
                                <li><a href="Episodes.html">Episodes</a></li>
                                <li><a href="History.html">History</a></li>
                                <li><a href="Crew.html">Crew</a></li>
                                <li><a href="Cast.html">Cast</a></li>
                                <li><a href="Music.html"><i class="fa fa-music" aria-hidden="true"></i> Music</a></li>
                                <hr>
                                <li><a href="Reviews.html">Reviews</a></li>
                            </ol>
                        </li>
                        <li class="accessible-megamenu-panel-group">
                            <h3>Media</h3>
                            <ol>
                                <li><a href="DVD.html">DVD</a></li>
                                <li><a href="Books.html"><i class="fa fa-book" aria-hidden="true"></i> Books</a></li>
                                <li><a href="Comics.html">Comics</a></li>
                                <li><a href="Audio.html">Audio</a></li>
                                <li><a href="Non_Fiction.html"> Non-fiction</a></li>
                                <li><a href="Magazines.html">Magazines</a></li>
                                <li><a href="Varia.html">Varia</a></li>
                                <li><a href="Merchandise.html">Merchandise</a></li>
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
                                <li><a href="Fans/Pictures.html"><i class="fa fa-file-image-o" aria-hidden="true"></i>
                                        Pictures</a></li>
                                <li><a href="Video.html"><i class="fa fa-youtube-play" aria-hidden="true"></i> Video</a>
                                </li>
                                <li><a href="Transcripts.html"><i class="fa fa-file-text-o" aria-hidden="true"></i>
                                        Transcripts</a></li>
                            </ol>
                            <hr>
                            <h3>To learn</h3>
                            <ol>
                                <li><a href="Questions.html"><i class="fa fa-question" aria-hidden="true"></i>
                                        Questions</a></li>
                            </ol>
                        </li>
                        <li class="accessible-megamenu-panel-group">
                            <h3>To Do</h3>
                            <ol>
                                <li><a href="Events.html"><i class="fa fa-calendar" aria-hidden="true"></i> Events</a>
                                </li>
                                <li><a href="Fanclubs.html"><i class="fa fa-users" aria-hidden="true"></i> Fanclubs</a>
                                </li>
                                <li><a href="Links.html"><i class="fa fa-link" aria-hidden="true"></i> Links</a></li>
                                <li><a href="Cosplay.html"><i class="fa fa-user-secret" aria-hidden="true"></i>
                                        Cosplay</a></li>
                                <li><a href="DIY.html"><i class="fa fa-wrench" aria-hidden="true"></i> DIY</a></li>
                            </ol>
                        </li>
                    </ol>
                </div>
            </li>
            <li>
                <h2><a href="News.html" class="toplink">News <i class="fa fa-newspaper-o" aria-hidden="true"></i></a>
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
                <h2><a href="Contact.html" class="toplink">Contact <i class="fa fa-envelope" aria-hidden="true"></i></a>
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
            <li class="rightItem installButton" onclick="A2HS()">
                <h2><a href="#" class="toplink">Install <i class="fa fa-plus-circle" aria-hidden="true"></i></a>
                </h2>
                <div class="cols-0">
                </div>
            </li>

        </ol>
    </nav>

    <main id="wrapper">

        <div class="path DarkBlueBackground"></div>
        <div id=loading_div>
            <img id=loading data-src="https://www.doctorwhofans.be/images/gallifreyan_blue.png" class="lazyLoad loading_img" alt="Laden">
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
        <a href="Sitemap.html" class=" socialMedia_full link">Sitemap</a><br>
        <p class='mededeling max_34 column'> </p>
        <div class="socialMedia column">

            <div class="sharethis-inline-follow-buttons"></div>
            <span>Or Share this page:</span>
            <div class="sharethis-inline-share-buttons"></div>
        </div>
        <p class='quote bordered padded DarkBlueBackground max_20 column'></p>
        <p class=disclaimer>
        </p>
    </footer>

    <a href="#" id="Back_To_Top" class="back-to-top" onclick="topFunction(0)"><img class="lazyLoad back_to_top_IMG"
            data-src="https://www.doctorwhofans.be/images/back_to_top.png" class=back_to_top_IMG alt="Back to top" /></a>
    <div id=overlay_background onclick="CloseDialogs()"></div>
    <div id="overlay_Zoeken" class="darkBlueBackground bordered padded">
        <a href=# class="close_zoeken link" onclick="CloseDialogs()"><img class="lazyLoad" data-src="https://www.doctorwhofans.be/images/overlay/981077-32.png" alt="Sluiten/Close" class=close_IMG /> Close</a>
        <div id="resultSet"></div>
    </div>
    <div id="overlay_PWA" class="darkBlueBackground bordered padded">
                <h1 id="PWA_Title"></h1>
                <p id="PWA_Body"></p>
                <button class="Yes" onclick="window.location.reload()"></button><button class="No" OnClick="clearInterval(Checkinterval);CloseDialogs()"></button>
    </div>
    <div id="overlay_Update" class="darkBlueBackground bordered padded">
    <div id="Update_text"></div>
    <button class="Yes" onclick="window.location.reload()"></button><button class="No" OnClick="clearInterval(Checkinterval);CloseDialogs()"></button>
    </div>
    <div id=overlay class="darkBlueBackground bordered padded">
        <h1>Kies uw taal</h1>
        <div class=taal>
            <a href="#" class="link" onClick='changelang("nl")'>
                <img class="lazyLoad" data-src="https://www.doctorwhofans.be/images/overlay/belgium_640.png"
                    alt="vlag van België; voor Nederlands." class="foto_taal_button" />
                Nederlands
                <img class="lazyLoad" data-src="https://www.doctorwhofans.be/images/overlay/netherlands_640.png"
                    alt="vlag van Nederland; voor Nederlands." class=foto_taal_button>
            </a>
        </div>
        <div class=taal>
            <a href="#" class="link" onClick='changelang("en")'>
                <img class="lazyLoad" data-src="https://www.doctorwhofans.be/images/overlay/united_kingdom_640.png"
                    alt="vlag van Engeland voor Engels." class="foto_taal_button" />
                English
                <img class="lazyLoad" data-src="https://www.doctorwhofans.be/images/overlay/united_states_of_america_64.png"
                    alt="vlag van de VS; voor Engels." class=foto_taal_button>
            </a>
        </div>
        <div class=taal>
            <a href=# class="close link"  onclick="CloseDialogs()"> 
                <img class="lazyLoad" data-src="https://www.doctorwhofans.be/images/overlay/981077-32.png" alt="Sluiten/Close" class=close_IMG />
                Close</a>
    </div>

</body>

</html>