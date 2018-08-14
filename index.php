<?php session_start();$_SESSION["name"];$_SESSION["Status"]="Anoniem";$_SESSION["Taal"];$_SESSION["Menu"];
$ingevuld=false;$overeenkomst=false;include_once('functions.php');?>
<!Doctype html>
<?php 
    
    if(isset($_GET['taal'])){
        if (is_numeric($_GET['taal'])) {
            $_SESSION["Taal"]='NL';
        } else if($_SESSION["Taal"]!=$_GET['taal']){
            $_SESSION["Taal"]=$_GET['taal'];
        }else{
            $_SESSION["Taal"]=$_GET['taal'];
        }
    }else if ($_SESSION["Taal"] ==null){
        $_SESSION["Taal"]='NL';
        
        
    }else{
        $_SESSION["Taal"]=$_SESSION["Taal"];
    }
    $taal = $_SESSION["Taal"];
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
    $id=0;if(isset($_GET['id'])){$id=$_GET['id'];}$parent="null";if(isset($_GET['parent'])){$parent=$_GET['parent'];}$child="null";if(isset($_GET['child'])){$child=$_GET['child'];}?>
<html lang="nl">
    <head>
        <title>
            <?php  $title = str_replace("_", " ", $menu);  if(isset($_GET['taal'])){echo $taal;echo " - ";echo $title;}else{echo $title;}echo" - Doctor Who Fans BE";?>
        </title>
        <meta name=author content="Ruben Debuscher" />
        <meta charset=UTF-8 />
        <meta http-equiv=X-UA-Compatible content="IE=edge">
        <meta http-equiv=X-UA-Compatible content="chrome=1">
        <meta name=description lang=nl content="Doctor who is een fenomeen, wereldwijd.  Tijd dat de nederlandstalige fans nu ook een eigen platform krijgen." />
        <META NAME="ROBOTS" CONTENT="NOYDIR, NOODP, NOARCHIVE"/>
        <meta name=viewport content="width=device-width, initial-scale=1.0"/>
        <meta http-equiv=Content-Type content="text/html; charset=utf-8" />
        <link rel="shortcut icon" href="images/favicon.ico" />
        <link rel=icon href="../images/favicon.ico" type="Images/ico">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
        
        <!--<script src="js/jquery-2.1.0.min.js"></script>-->
        <!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>-->
        <script src="../js/jquery-accessibleMegaMenu.js" async></script>
        <script src="../js/app.js"></script>
        <script>
        var uploadImg;
        session = "<?php echo session_id();?>"
        status = '<?php echo $_SESSION["Status"] ?>';
            taal = '<?php echo $_SESSION["Taal"] ?>';
            menu = '<?php echo $menu ?>';
            var id = '<?php echo $id ?>';
            var parent = '<?php echo $parent ?>';
            var child = "<?php echo $child ?>";
            var zoekterm = "<?php echo $zoekterm ?>";
            $(document).ready(function(){
                //kijk na of de pagina bestaat
                if (menu !=="Quotes"){
                    checkmenu(menu);
                }
                
             contentophalen(taal,menu,id,parent,child);
                if (menu!=="Home"){
                    getpad(menu);
                    
                } 
                if(menu==="Contact"){
                    
                    $("#txtEditor").Editor();
                }
            }
                
                );
   
        </script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js" async></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js" async></script>
		<script src="../js/editor.js" async></script>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
		<link href="../opmaak/editor.css" type="text/css" rel="stylesheet"/>	
		<link rel=stylesheet href="../opmaak/opmaak.css" />
	   <link href="../opmaak/themify-icons.css" rel="stylesheet">
        <link rel=stylesheet href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <script>
            jQuery(document).ready(
                function(){
                    var c=220;
                    var b=500;
                    jQuery(window).scroll(function(){
                        if(jQuery(this).scrollTop()>c){
                            jQuery(".back-to-top").fadeIn(b);
                        }else{
                            jQuery(".back-to-top").fadeOut(b);
                        }
                    }
            );
            jQuery(".back-to-top").click(function(e){
                e.preventDefault();
                jQuery("html, body").animate({scrollTop:0},b);
                return false;
            });
            jQuery(".taal_link").click(function(f){f.preventDefault();jQuery("html, body").animate({scrollTop:0},b);var e=window.innerHeight||document.documentElement.clientHeight||document.body.clientHeight;document.getElementById("overlay_background").style.height=e;jQuery("#overlay_background, #overlay").fadeIn(b);d();return false});jQuery(".close").click(function(e){e.preventDefault();jQuery("#overlay_background, #overlay").fadeOut(b);a();return false});function a(){document.documentElement.style.overflow="auto";document.body.scroll="yes"}function d(){document.documentElement.style.overflow="hidden";document.body.scroll="no"}});$(function(){$("#foto_taal_button").click(function(){function a(){document.getElementById("overlay").style.display="block";document.getElementById("overlay_background").style.display="block"}function b(){document.getElementById("overlay").style.display="none";document.getElementById("overlay_background").style.display="none"}})});setTimeout(
                function(){
                    $("#loading_div").fadeOut(100);
                    setTimeout(function(){
                        $(".col-6").fadeIn(100);
                        $(".under").fadeIn(100)
                        
                    },100)
                    
                },1500);
                $(".footer a:first-child").css("background-color", "yellow");
                    
        </script>
        
    </head>
    <body class=init>
        <input type=checkbox id=show-menu role=button class=show_menu_checkbox>
        <label for=show-menu class=show-menu> <i class="fa fa-navicon"></i> Menu&nbsp;&nbsp; </label>
        <nav class=megamenu>
            <ol>
                <li class="standaard" style="width:10%">
                    <span>
                        <a href="https://www.doctorwhofans.be/Home/" aria-label="Home"><img style="width:60px" src="../images/gallifreyan_black.png" alt="Logo" /></a>
                    </span>
            		<div class="cols-4" style="display:none;"></div>
            	</li>
            	<li class="standaard">
            		<span><a href="#" aria-label="who is Who?">who is Who <i class="fa fa-arrow-down" aria-hidden="true"></i></a></span>
            		<div class="cols-4b standaard">
            			<ol>
            				<li class="accessible-megamenu-panel-group">
            					<span>Doctors</span>
            					<ol>
            						<li><a href="../First_Doctor/">First Doctor</a></li>
            						<li><a href="../Second_Doctor/">Second Doctor</a></li>
            						<li><a href="../Third_Doctor/">Third Doctor</a></li>
            						<li><a href="../Fourth_Doctor/">Fourth Doctor</a></li>
            						<li><a href="../Fifth_Doctor/">Fifth Doctor</a></li>
            						<li><a href="../Sixth_Doctor/">Sixth Doctor</a></li>
            						<li><a href="../Seventh_Doctor/">Seventh Doctor</a></li>
            						<li><a href="../Eighth_Doctor/">Eighth Doctor</a></li>
            						<li><hr></li>
            						<li><a href="../War_Doctor/">The War Doctor</a></li>
            						<li><a href="../Ninth_Doctor/">Ninth Doctor</a></li>
            						<li><a href="../Tenth_Doctor/">Tenth Doctor</a></li>
            						<li><a href="../Eleventh_Doctor/">Eleventh Doctor</a></li>
            						<li><a href="../Twelfth_Doctor/">Twelfth Doctor</a></li>
            						<li><a href="../Thirteenth_Doctor/">Thirteenth Doctor</a></li>
            					</ol>
            				</li>
            				<li class="accessible-megamenu-panel-group">
            					<span>Characters</span>
            					<ol>
            					    <li>
            						    
            						    <a href="../Companions/" aria-label="Companions">
            						        <span class="fa-layers fa-fw" style="margin-right: -1em;">
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
                                        <li>
                                            <a href="../Torchwood/"><img src="../images/Torchwood.png" alt="Torchwood logo" /> Torchwood</a>
                                        </li>
                                        <li>
                                            <a href="../Sarah_Jane_Adventures/"><img src="../images/SJA.png" alt="Sarah Jane Adventures logo" /> Sarah Jane Adventures</a>
                                        </li>
                                        <li><a href="../Class/"><img src="../images/Class.png" alt="Class logo" /> Class</a></li>
            					</ol>
            				</li>
            				<li class="accessible-megamenu-panel-group">
            				    <span>Concepts and other things</span>
            					<ol>
                                    <li><a href="../Species/">Species</a></li>
                                    <li><a href="../TARDIS/" style="padding-left:0em;"><img src="../images/tardis.png" alt="TARDIS logo"/>T.A.R.D.I.S</a></li>
                                    <li><a href="../Sonic_Screwdriver/">Sonic Screwdriver</a></li>
                                    <li>
                                            <a href="../UNIT/"><img src="../images/UNIT.png" alt="UNIT logo" /> UN.I.T</a>
                                        </li>
                                    <li><a href="../Places/"><i class="fa fa-compass" aria-hidden="true"></i> Places</a></li>
                                    <li><a href="../Times/"><i class="fa fa-code-fork" aria-hidden="true"></i> Times</a></li>
                                    <li>
                                        <hr> </li>
                                    <li><a href="../Quotes/"> <i class="fa fa-quote-right" aria-hidden="true"></i> Quotes</a></li>
            					</ol>
            				</li>
            			</ol>
            		</div>
            	</li>
            	<li class="standaard">
            		<span><a href="#">Series <i class="fa fa-arrow-down" aria-hidden="true"></i></a></span>
            		<div class="cols-3 standaard">
            			<ol>
            				<li class="accessible-megamenu-panel-group">
            					<span>the Show</span>
            					<ol>
            						
                                    <li><a href="../Synopsis/">Synopsis</a></li>
                                    <li><a href="../Episodes/">Episodes</a></li>
                                    <li><a href="../History/">History</a></li>
                                    <li><a href="../Crew/">Crew</a></li>
                                    <li><a href="../Cast/">Cast</a></li>
                                    <li><a href="../Music/"><i class="fa fa-music" aria-hidden="true"></i> Music</a></li>
                                    <li>
                                        <hr> </li>
                                    <li><a href="../Reviews/">Reviews</a></li>
                                    
            					</ol>
            				</li>
            				<li class="accessible-megamenu-panel-group">
            					<span>Media</span>
            					<ol>
            						
                                    <li><a href="../DVD/">DVD</a></li>
                                    <li><a href="../Books/"><i class="fa fa-book" aria-hidden="true"></i> Books</a></li>
                                    <li><a href="../Comics/">Comics</a></li>
                                    <li><a href="../Audio/">Audio</a></li>
                                    <li><a href="../Non_Fiction/"><span class="fa-stack">
                                            <i class="fa fa-book fa-stack-1x" aria-hidden="true"></i>
                                            <i class="fa fa-ban fa-stack-2x text-danger" aria-hidden="true"></i>
                                        </span> Non-fiction</a></li>
                                    <li>
                                        <hr> </li>
                                    <li><a href="../Merchandise/">Merchandise</a></li>
                                    
            					</ol>
            				</li>
            			</ol>
            		</div>
            	</li>
            	<li class="standaard">
            		<span><a href="#">Fans <i class="fa fa-arrow-down" aria-hidden="true"></i></a></span>
            		<div class="cols-3">
            			<ol>
            				<li class="accessible-megamenu-panel-group">
            					<ol>
            						
                                    <li><a href="../Pictures/"><i class="fa fa-file-image-o" aria-hidden="true"></i> Pictures</a></li>
                                    <li><a href="../Video/"><i class="fa fa-youtube-play" aria-hidden="true"></i> Video</a></li>
                                    <li><a href="../Transcripts/"><i class="fa fa-file-text-o" aria-hidden="true"></i> Transcripts</a></li>
                                    <li>
                                        <hr> </li>
                                    <li><a href="../Events/"><i class="fa fa-calendar" aria-hidden="true"></i> Events</a></li>
                                    <li><a href="../Fanclubs/"><i class="fa fa-users" aria-hidden="true"></i> Fanclubs</a></li>
                                    <li><a href="../Links/"><i class="fa fa-link" aria-hidden="true"></i>Links</a></li>
                                    <li>
                                        <hr> </li>
                                    <li><a href="../DIY/"><i class="fa fa-wrench" aria-hidden="true"></i>DIY</a></li>
                                    <li><a href="../Cosplay/"><i class="fa fa-user-secret" aria-hidden="true"></i> Cosplay</a></li>
                                    
            					</ol>
            				</li>
            			</ol>
            		</div>
            	</li>
            	<li class="nav-item standaard">
            		
                    <span><a href="../News/" aria-label="News"><i class="fa fa-newspaper-o" aria-hidden="true"></i> News</a></span>
                    <div class="cols-4b standaard" style="display:none;width:0%;"> </div>
                    
                </li>
                <li class="nav-item standaard">
                    
                    <a href="https://forum.doctorwhofans.be"><i class="fa fa-comments-o"></i> Forum</a>
                    <div class="cols-4b" style="display:none;width:0%;"> </div>
                    
                </li>
                <li class="nav-item standaard">
                    
                    <span><a href="../Contact/"><i class="fa fa-envelope" aria-hidden="true"></i> Contact</a></span>
                    <div class="cols-4b" style="display:none;width:0%;"> </div>
                    
                </li>
                <li class="zoekmenu">
            		<span><a href="#"><i class="fa fa-search fa-2x" aria-hidden="true" title="Zoeken"></i> Zoeken</a></span>
            		<div class="cols-3 zoekmenu">
            				<form action="../Zoeken/" method="post" class="zoekformulier">
                					    <label for="zoekterm" class="zoeklabel">Zoeken: </label>
                                        <input class="zoekterm" type="text" name="zoekterm" placeholder="Zoeken..." value="" title="zoeken" id="zoekterm" />
                                        <input class="zoekknop" type="submit" name="zoeken" value=" " style="margin-top:0.5em;"/>
                                    </form>
            		</div>
            	</li>
</ol>
        </nav>
        <div id=loading_div>
            <img id=loading src="../images/ledtorch.1498524411.png" style="width:2%" alt="Laden">
        </div>
        <div class="path"></div>
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
                        $( "ul:first" ).css( "margin-left", "-4em" );                        
                    </script>
                    <?php
                }
                if ( !$_SESSION['loggedin'] )
                {
                    ?>
                            <script>$('.privaat').hide();</script>
                    <?php
                }else{
                    ?>
                            <script>$('.privaat').show();</script>
                    <?php
                }
                if(isset($_POST['verzenden'])){
                    $bericht=$_POST['Bericht'];
                    $bericht->real_escape_string;
                    $naam=$_SESSION['name'];
                    $naam->real_escape_string;
                    $topic=$_POST['Topic'];
                    $subtopic=$_POST['subtopic'];
                    require('connect.php');
                    $queryidentificatie="SELECT * FROM Gebruikers WHERE Gebruikersnaam = '$naam'";
                    $resultidentificatie=mysqli_query($verbinding,$queryidentificatie);
                    $rowidentificatie=$resultidentificatie->fetch_assoc();
                    if(mysqli_num_rows($resultidentificatie)==1){
                        $query4="INSERT INTO Berichten ( 'bericht', 'gebruiker') VALUES ( '$bericht', '$naam')";
                        $result4=mysqli_query($verbinding,$query4);
                        echo"bericht verzonden";
                    }else{
                        echo"Gelieve eerst in te loggen";
                    }
                }
                if(isset($_POST['zoeken'])){
                    $zoekterm = $_POST['zoekterm'];
                ?>
                    <script type=text/javascript>
                        var taal = '<?php echo $_SESSION['Taal']?>';
                        var menu = '<?php echo $menu ?>';
                        var id = '<?php echo $id ?>';
                        var parent = '<?php echo $parent ?>';
                        var child = "<?php echo $child ?>";
                        var zoekterm = "<?php echo $zoekterm ?>";
                        if ((zoekterm.indexOf('=') !== -1)||(zoekterm.indexOf('<') !== -1)||(zoekterm.indexOf('>') !== -1)||(zoekterm.indexOf('</') !== -1)) {
                           alert("Error, invalid search parameter, please do not use '"+zoekterm+"'.")
                        } else {
                            $(document).ready(zoeken(taal,menu,id,parent,child,zoekterm));
                            $(document).ready(videozoeken(taal,menu,id,parent,child,zoekterm));
                            $(document).ready(quotezoeken(taal,menu,id,parent,child,zoekterm));
                        }
                    </script>
                    <div class="open-close">
                        <div class="resultset holder" style="border:1px solid yelllow" id="resultset1">
                            <div class="header" style="width:100%;background-color:yellow;color:black"><a class="opner" href="#">Pages</a></div>
                        </div>
                        <div class="resultset second holder" style="border:1px solid yelllow" id="resultset2">
                            <div class="header" style="width:100%;background-color:yellow;color:black"><a class="opner" href="#">Videos</a></div>
                            
                        </div>
                        <div class="resultset third holder" style="border:1px solid yelllow" id="resultset3">
                            <div class="header" style="width:100%;background-color:yellow;color:black"><a class="opner" href="#">Quotes</a></div>
                            
                        </div>
                    </div>
                    
            <?php
                }
            ?>
        </article>
        <article class="under">
            <?php
                if($menu=='Contact'){
                    require("Content/Contact.php");
                }
                if($menu=='Events'){
                    require("Kalender.php");
                }
                if($menu=='Companions'){
            ?>
                    <div class="open-close">
            <script type=text/javascript>
                var taal = '<?php echo $taal ?>';
                var menu = '<?php echo $menu ?>';
                var id = '<?php echo $id ?>';
                var parent = '<?php echo $parent ?>';
                var child = "<?php echo $child ?>";
                $(document).ready(companionsophalen(taal,menu,id,parent,child));
            </script>
        </div>
            <?php
    
            }
                if($menu=='Profiel'){
                    
            ?>
                    <script type=text/javascript>
                    
                        taal = '<?php echo $taal ?>';
                        menu = '<?php echo $menu ?>';
                        User_ID = '<?php echo $User_ID ?>';
                        $(document).ready(Userophalen(taal,menu,User_ID));
                    </script>
            <?php
                }
                //if($menu=='Video'){
                   // require("Content/Videos.php");
                //}
                if($menu=='News'){
                    require("Content/News.php");
                }
                if($menu=='Registreren'){
                    require("Content/Registreren.php");
                }
            ?>
        </article>
        
        <footer id=footer>
       <hr>
            <?php
            switch($taal){
                    case 'NL':echo"<p class='mededeling'> Momenteel is 'Doctor Who Fans België' in aanbouw. Als jullie nog verdere informatie, voorstellen of vragen hebben, mogen jullie me dat altijd laten weten. Ook verzoeken of inzendingen met betrekking tot de videos of foto's ed. zijn altijd welkom. Gegevens vind je op de contactpagina.  Hier kan je ons ook rechtstreeks contacteren via het formulier. </p>";
                        break;
                    case 'ENG':echo"<p class='mededeling'> At this moment, 'Doctor Who Fans Belgium' is still under construction. In the case there might be any questions, propositions, or additional information to provide, please feel free to contact me.  Requests or submissions related to the videos, pictures, etc. are welcome as well.  Contact informationis provided on the corresponding page. You will also be able to contact us directly from that page.</p>";
                        break;
                    default:echo"<p class=mededeling> Momenteel is 'Doctor Who Fans België' in aanbouw. Als jullie nog verdere informatie, voorstellen of vragen hebben, mogen jullie me dat altijd laten weten. Ook verzoeken of inzendingen met betrekking tot de videos of foto's ed. zijn altijd welkom. Gegevens vind je op de contactpagina.  Hier kan je ons ook rechtstreeks contacteren via het formulier. </p>";
                        break;
            }
           
            if($menu=="Home"){
            ?>

            <p class=quote>
                <?php 
                    $num=Rand(3,27);
                    require("connect.php");
                    $sql="select SUBSTRING( Quote, 1, 70) AS Quote, Personage, Aflevering,id from QuotesTabel where id = '$num'";
                    $result=mysqli_query($verbinding,$sql);
                    while($row=$result->fetch_assoc()){
                ?>
                        <?=$row['Quote']?> ...
                        <br>
                        <a href="../Quotes/" class='link' onclick=event.preventDefault();$('.col-6').html('');quotesophalen('Quotes',<?=$row['id']?>)>Lees meer</a>
                        <span>
                            <br>
                            <?=$row['Personage']?>
                        </span>
                        <br>
                        <span>
                            <?=$row['Aflevering']?>
                        </span>
                <?php
                    }
                ?>
            </p>
            <?php
            }
            ?>
            <p class=disclaimer> Doctor Who and related marks are trademarks of the BBC. Copyright &copy;1963, Present
                <br> The web pages on this site are for educational and entertainment purposes only.
                <br> All other copyrights are property of their respective holders.
                <br> Most of my sources are anonymous, so if you find any of your work, or you know any of the resources, please contact us and we will credit your work properly.
            </p>
            <a href="../Sitemap/" class="link">Sitemap</a>
        </footer>
        <form class=access>
            <fieldset>
                <legend>Instellingen/Settings</legend>
                <button class=toegang id=toegang onclick="addAcces()" type="button">Toegankelijkheid verhogen</button>
                <button class="toegang hide" id=toegangRemove onclick="removeAccess()" type="button">Normale modus</button>
                
                <button class=print id=print type="button" onclick="printContent()">Print</button>
                <button class="print hide" id=printClose type="button" onclick="Closeprint()">Close Print</button>
                
                <button class="RemoveImages" id="RemoveImages" type="button" onclick="RemoveImg()">Verwijder Afbeeldingen</button>
                <button class="RemoveImages hide" id="RestoreImages" type="button" onclick="RestoreImg()">Toon Afbeeldingen</button>

                <a href="#" class="link" onclick="show()"><img src="../images/overlay/52349.png" alt="Globe voor taalkeuze" class ="taal_link foto_taal_button"/></a>
            </fieldset>
        </form>
        <script async src="../js/toegang.js"></script>
        <a href="#" class=back-to-top><img src="../images/back_to_top.png" class=back_to_top_IMG alt="Back to top"/></a>
        <div id=overlay_background></div>
        <div id=overlay>
            <h1>Kies uw taal</h1>
            <div class=taal>
                <?php
                    echo'<a href="../NL/" class="link">';
                ?>
                <img src="../images/overlay/belgium_640.png" alt="vlag van Belgi&euml; voor Nederlands." class="foto_taal_button"/>
                Nederlands
                <img src="../images/overlay/netherlands_640.png" alt="vlag van Nederland; voor Nederlands." class=foto_taal_button>
                <?php
                    echo"</a>";
                ?>
            </div>
            <div class=taal>
                <?php
                    echo'<a href=../ENG/ class="link">';
                ?>
                    <img src="../images/overlay/united_kingdom_640.png" alt="vlag van Engeland voor Engels." class="foto_taal_button"/>
                    English
                    <img src="../images/overlay/united_states_of_america_64.png" alt="vlag van de VS; voor Engels." class=foto_taal_button>
                </a>
            </div>
            <div class=taal>
                <a href=# class="close link"><img src="../images/overlay/981077-32.png" alt="Sluiten/Close" class=close_IMG/> Close</a>
            </div>
        </div>
        
        
    </body>
</html>
