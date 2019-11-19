var aantalrecords;
var img;
var eerdermenu;
var taal;
var menu;var currentTopic;var user;var UID = 0;var toon = "false";var slideIndex = 1;var ip;var session;var CONTENTID;var zoekterm;



function ip_callback() {
    $.get("/php/getIp.php", function(data) {
        ip= data;
    })
}
function checkmenu(menu) {
    ip_callback();
    if(menu=="API"){
        event.preventDefault();
        window.location.href = "https://www.doctorwhofans.be/API/index.html";
        return;
    }
    gegevens={}
    gegevens.menu=menu;
    gegevens.ip=ip;
    gegevens.session=document.cookie.match(/PHPSESSID=[^;]+/).toString().substr(10);
    $.ajax({
        type: "POST",
        url: "/php/checkmenu.php",
        dataType: 'json',
        cache: false,
        data:gegevens
    }).done(
        function(resultaat) {
            if(resultaat === false) {
                window.location.href = "https://www.doctorwhofans.be/notfound.html";
            }else{
                var interval = setInterval(function() {
                    $.ajax({
                        type: "GET",
                        url: "/php/alles.php?taal=" + getCookie("lang") + "&menu=" + menu,
                        dataType: 'json',
                        cache: false
                    }).done(function(resultaat) {
                        if(aantalrecords == resultaat.data.length) {
                        }else{
                            if(confirm("Wilt u de nieuwe content ophalen?")) {
                                window.location.reload();
                            }else{
                                clearInterval(interval);
                            }
                        }
                    }).fail(function(response, statusText, xhr) {
                    }).always(function() {
                    });
                }, 10000);
            }
        }).fail(function(response, statusText, xhr) {
    }).always(function() {
    });
}
 function ZoekPagina(){
    event.preventDefault();
    $("#resultcontent").remove();
    $("#resultquotes").remove();
    $("#resultvideo").remove();
    if (($("#zoekterm").val().indexOf('=') !== -1)||($("#zoekterm").val().indexOf('<') !== -1)||($("#zoekterm").val().indexOf('>') !== -1)||($("#zoekterm").val().indexOf('</') !== -1)) {
        alert("Error, invalid search parameter, please do not use '"+$("#zoekterm").val()+"'.")
    } else {
        zoeken(taal,menu,id,$("#zoekterm").val());
        videozoeken(taal,menu,id,$("#zoekterm").val());
        quotezoeken(taal,menu,id,$("#zoekterm").val());
        jQuery("html, body").animate({scrollTop:0},500);
                var e=window.innerHeight||document.documentElement.clientHeight||document.body.clientHeight;
                document.getElementById("overlay_background").style.height=e;
                jQuery("#overlay_background, #overlay_Zoeken").fadeIn(500);
                $('html, body').css({
                    overflow: 'hidden',
                    height: '100%'
                });
                return false
                
    }
}
function zoeken(taal, menu, zoekterm, ip, UID) {
    zoekterm=$("#zoekterm").val()
    $.ajax({
        type: "GET",
        url: "/php/zoeken.php?taal=" + taal + "&menu=" + menu + "&zoekterm=" + zoekterm,
        dataType: 'json',
        cache: false
    }).done(
        function(resultaat) {
            $("#resultset1").append("<div class ='result slide' id='resultcontent'></div>");
            $("#resultcontent").hide();
            var i;
            for (i = 0; i < resultaat.data.length; i += 1) {
                if(resultaat.data[i].link.indexOf("Forum") >= 0) {
                    $("#resultcontent").append("<a href='../" + resultaat.data[i].link + "/'  ><h3>" + resultaat.data[i].topic + " (Forum)</h3></a>");
                }else{$("#resultcontent").append("<a href='../" + resultaat.data[i].link + "/'  ><h3>" + resultaat.data[i].topic + "</h3></a>");}
            }
        }).fail(function(response, statusText, xhr) {
    }).always(function() {
    });
}
function getpad(menu){
    $.ajax({
        type: "GET",
        url: "/php/pad.php?menu=" + menu,
        dataType: 'json',
        crossDomain: true,
        cache: false
    }).done(
        function(resultaat) {
            $(".path").prepend("<span>" + resultaat.data[0].pad + "</span>");
            $(".path a").addClass("link");
            if(menu === "Video" || resultaat.data[0].pad.search("Video") > 0) {videosophalen(menu);}
            if(menu === "Quotes" || resultaat.data[0].pad.search("Quotes") > 0) {quotesophalen(menu, id);}
        }).fail(function(response, statusText, xhr) {
    }).always(function() {
    });
}
function random() {
    $.ajax({
        type: "GET",
        url: "/php/random.php",
        dataType: 'json',
        crossDomain: true,
        cache: false,
    }).done(
        function(resultaat) {
            for (i = 0; i < resultaat.data.length; i += 1) {$("#links").append("<a href='../" + resultaat.data[i].link + "/' >" + resultaat.data[i].topic + "</a></br>");}
        }).fail(function(response, statusText, xhr) {
    }).always(function() {
    });
}
function getchildren(menu) {
    $.ajax({
        type: "GET",
        url: "/php/children.php?menu=" + menu,
        dataType: 'json',
        crossDomain: true,
        cache: false
    }).done(
        function(resultaat) {
            var i;
            for (i = 0; i < resultaat.data.length; i += 1) {
                if(resultaat.data[i].direct_children > 0) {
                    $(".topics").append("<div class='OverzichtItem'><a href='../" + resultaat.data[i].link + "/'  ><h3>" + resultaat.data[i].topic + "</h3> <span>(Pages: " + resultaat.data[i].direct_children + ")</span></a></div>");
                }else{$(".topics").append("<div class='OverzichtItem'><a href='../" + resultaat.data[i].link + "/'  ><h3>" + resultaat.data[i].topic + "</h3></a></div>");
                }
            }
        }).fail(function(response, statusText, xhr) {
    }).always(function() {
    });
}
function videozoeken(taal, menu, zoekterm) {
    zoekterm=$("#zoekterm").val()
    $.ajax({
        type: "GET",
        url: "/php/zoekenvideo.php?taal=" + taal + "&menu=" + menu + "&zoekterm=" + zoekterm,
        dataType: 'json'
    }).done(function(resultaat) {
        $("#resultset2").append("<div class ='result slide' id='resultvideo'></div>");
        $("#resultvideo").hide();
        var i;
        for (i = 0; i < resultaat.data.length; i += 1) {
            $("#resultvideo").append("<a href='../Video/' onclick=event.preventDefault();$('.col-6').html('');videosophalen('Video'," + resultaat.data[i].id + ")  ><h3>" + resultaat.data[i].Video_Name + "</h3</a>");
            $("#resultvideo").append("<p>" + resultaat.data[i].Video_Beschrijving + "...</p>");
        }
    }).fail(function(response, statusText, xhr) {
    }).always(function() {
    });
}
function quotezoeken(taal, menu, zoekterm) {
    zoekterm=$("#zoekterm").val()
    $.ajax({
        type: "GET",
        url: "/php/zoekenquote.php?taal=" + taal + "&menu=" + menu + "&zoekterm=" + zoekterm,
        dataType: 'json'
    }).done(function(resultaat) {
        $("#resultset3").append("<div class ='result slide' id='resultQuote'></div>");
        $("#resultQuote").hide();
        var i;
        for (i = 0; i < resultaat.data.length; i += 1) {
            $("#resultQuote").append("<a href='../Quotes/' onclick=event.preventDefault();$('.col-6').html('');quotesophalen('Quotes'," + resultaat.data[i].id + ")><h3>" + resultaat.data[i].Aflevering + "</h3</a>");
            $("#resultQuote").append("<p>" + resultaat.data[i].Quote + "...</p>");
        }
    }).fail(function(response, statusText, xhr) {
    }).always(function() {
    });
}
function companionsophalen(taal, menu,id) {
    $.ajax({
        type: "GET",
        url: "/php/companionsophalen.php?taal=" + taal + "&menu=" + menu,
        dataType: 'json'
    }).done(function(resultaat) {
        $(".open-close").append("<div class='resultset holder' style='border:1px solid yelllow' id='D1'>");
        $("#D1").append("<div class='header'><a class='opner' onclick=ToggleCompanion('D1') href='#First'>First Doctor<img class='upDown' src='../images/up_down.png'alt='up-down First Doctor'/></a></div>");
        $("#D1").append("<div class ='result companion slide' id='resultD1'></div>");
        $(".open-close").append("<div class='resultset holder' style='border:1px solid yelllow' id='D2'>");
        $("#D2").append("<div class='header'><a class='opner' onclick=ToggleCompanion('D2') href='#Second'>Second Doctor<img class='upDown' src='../images/up_down.png'alt='up-down Second Doctor'/></a></div>");
        $("#D2").append("<div class ='result companion slide' id='resultD2'></div>");
        $(".open-close").append("<div class='resultset holder' style='border:1px solid yelllow' id='D3'>");
        $("#D3").append("<div class='header'><a class='opner' onclick=ToggleCompanion('D3') href='#Third'>Third Doctor<img class='upDown' src='../images/up_down.png'alt='up-down Third Doctor'/></a></div>");
        $("#D3").append("<div class ='result companion slide' id='resultD3'></div>");
        $(".open-close").append("<div class='resultset holder' style='border:1px solid yelllow' id='D4'>");
        $("#D4").append("<div class='header'><a class='opner' onclick=ToggleCompanion('D4') href='#Fourth'>Fourth Doctor<img class='upDown' src='../images/up_down.png'alt='up-down Fourth Doctor'/></a></div>");
        $("#D4").append("<div class ='result companion slide' id='resultD4'></div>");
        $(".open-close").append("<div class='resultset holder' style='border:1px solid yelllow' id='D5'>");
        $("#D5").append("<div class='header'><a class='opner' onclick=ToggleCompanion('D5') href='#Fifth'>Fifth Doctor<img class='upDown' src='../images/up_down.png'alt='up-down Fifth Doctor'/></a></div>");
        $("#D5").append("<div class ='result companion slide' id='resultD5'></div>");
        $(".open-close").append("<div class='resultset holder' style='border:1px solid yelllow' id='D6'>");
        $("#D6").append("<div class='header'><a class='opner' onclick=ToggleCompanion('D6') href='#Sixth'>Sixth Doctor<img class='upDown' src='../images/up_down.png'alt='up-down Sixth Doctor'/></a></div>");
        $("#D6").append("<div class ='result companion slide' id='resultD6'></div>");
        $(".open-close").append("<div class='resultset holder' style='border:1px solid yelllow' id='D7'>");
        $("#D7").append("<div class='header'><a class='opner' onclick=ToggleCompanion('D7') href='#Seventh'>Seventh Doctor<img class='upDown' src='../images/up_down.png'alt='up-down Seventh Doctor'/></a></div>");
        $("#D7").append("<div class ='result companion slide' id='resultD7'></div>");
        $(".open-close").append("<div class='resultset holder' style='border:1px solid yelllow' id='D8'>");
        $("#D8").append("<div class='header'><a class='opner' onclick=ToggleCompanion('D8') href='#Eighth'>Eighth Doctor<img class='upDown' src='../images/up_down.png'alt='up-down Eighth Doctor'/></a></div>");
        $("#D8").append("<div class ='result companion slide' id='resultD8'></div>");
        $(".open-close").append("<div class='resultset holder' style='border:1px solid yelllow' id='DW'>");
        $("#DW").append("<div class='header'><a class='opner' onclick=ToggleCompanion('DW') href='#War'>War Doctor<img class='upDown' src='../images/up_down.png'alt='up-down War Doctor'/></a></div>");
        $("#DW").append("<div class ='result companion slide' id='resultDW'></div>");
        $(".open-close").append("<div class='resultset holder' style='border:1px solid yelllow' id='D9'>");
        $("#D9").append("<div class='header'><a class='opner' onclick=ToggleCompanion('D9') href='#'>Ninth Doctor<img class='upDown' src='../images/up_down.png'alt='up-down Ninth Doctor'/></a></div>");
        $("#D9").append("<div class ='result companion slide' id='resultD9'></div>");
        $(".open-close").append("<div class='resultset holder' style='border:1px solid yelllow' id='D10'>");
        $("#D10").append("<div class='header'><a class='opner' onclick=ToggleCompanion('D10') href='#'>Tenth Doctor<img class='upDown' src='../images/up_down.png'alt='up-down Tenth Doctor'/></a></div>");
        $("#D10").append("<div class ='result companion slide' id='resultD10'></div>");
        $(".open-close").append("<div class='resultset holder' style='border:1px solid yelllow' id='D11'>");
        $("#D11").append("<div class='header'><a class='opner' onclick=ToggleCompanion('D11') href='#'>Eleventh Doctor<img class='upDown' src='../images/up_down.png'alt='up-down Eleventh Doctor'/></a></div>");
        $("#D11").append("<div class ='result companion slide' id='resultD11'></div>");
        $(".open-close").append("<div class='resultset holder' style='border:1px solid yelllow' id='D12'>");
        $("#D12").append("<div class='header'><a class='opner' onclick=ToggleCompanion('D12') href='#'>Twelfth Doctor<img class='upDown' src='../images/up_down.png'alt='up-down Twelfth Doctor'/></a></div>");
        $("#D12").append("<div class ='result companion slide' id='resultD12'></div>");
        $(".open-close").append("<div class='resultset holder' style='border:1px solid yelllow' id='D13'>");
        $("#D13").append("<div class='header'><a class='opner' onclick=ToggleCompanion('D13') href='#'>Thirteenth Doctor<img class='upDown' src='../images/up_down.png'alt='up-down Thirteenth Doctor'/></a></div>");
        $("#D13").append("<div class ='result companion slide' id='resultD13'></div>");
        var i;
        for (i = 0; i < resultaat.data.length; i += 1) {
            if(resultaat.data[i].Doctor == "1" || resultaat.data[i].Doctor2 == "1" || resultaat.data[i].Doctor3 == "1" || resultaat.data[i].Doctor4 == "1") {
                $("#resultD1").append("<div><a href='../" + resultaat.data[i].Pagina_Naam + "/'  ><h3>" + resultaat.data[i].Naam + "</h3></a></div>");}
            if(resultaat.data[i].Doctor == "2" || resultaat.data[i].Doctor2 == "2" || resultaat.data[i].Doctor3 == "2" || resultaat.data[i].Doctor4 == "2") {
                $("#resultD2").append("<div><a href='../" + resultaat.data[i].Pagina_Naam + "/'  ><h3>" + resultaat.data[i].Naam + "</h3></a></div>");}
            if(resultaat.data[i].Doctor == "3" || resultaat.data[i].Doctor2 == "3" || resultaat.data[i].Doctor3 == "3" || resultaat.data[i].Doctor4 == "3") {
                $("#resultD3").append("<div><a href='../" + resultaat.data[i].Pagina_Naam + "/'  ><h3>" + resultaat.data[i].Naam + "</h3></a></div>");}
            if(resultaat.data[i].Doctor == "4" || resultaat.data[i].Doctor2 == "4" || resultaat.data[i].Doctor3 == "4" || resultaat.data[i].Doctor4 == "4") {
                $("#resultD4").append("<div><a href='../" + resultaat.data[i].Pagina_Naam + "/' ><h3>" + resultaat.data[i].Naam + "</h3></a></div>");}
            if(resultaat.data[i].Doctor == "5" || resultaat.data[i].Doctor2 == "5" || resultaat.data[i].Doctor3 == "5" || resultaat.data[i].Doctor4 == "5") {
                $("#resultD5").append("<div><a href='../" + resultaat.data[i].Pagina_Naam + "/' ><h3>" + resultaat.data[i].Naam + "</h3></a></div>");}
            if(resultaat.data[i].Doctor == "6" || resultaat.data[i].Doctor2 == "6" || resultaat.data[i].Doctor3 == "6" || resultaat.data[i].Doctor4 == "6") {
                $("#resultD6").append("<div><a href='../" + resultaat.data[i].Pagina_Naam + "/' ><h3>" + resultaat.data[i].Naam + "</h3></a></div>");}
            if(resultaat.data[i].Doctor == "7" || resultaat.data[i].Doctor2 == "7" || resultaat.data[i].Doctor3 == "7" || resultaat.data[i].Doctor4 == "7") {
                $("#resultD7").append("<div><a href='../" + resultaat.data[i].Pagina_Naam + "/' ><h3>" + resultaat.data[i].Naam + "</h3></a></div>");}
            if(resultaat.data[i].Doctor == "8" || resultaat.data[i].Doctor2 == "8" || resultaat.data[i].Doctor3 == "8" || resultaat.data[i].Doctor4 == "8") {
                $("#resultD8").append("<div><a href='../" + resultaat.data[i].Pagina_Naam + "/' ><h3>" + resultaat.data[i].Naam + "</h3></a></div>");}
            if(resultaat.data[i].Doctor == "9" || resultaat.data[i].Doctor2 == "9" || resultaat.data[i].Doctor3 == "9" || resultaat.data[i].Doctor4 == "9") {
                $("#resultDW").append("<div><a href='../" + resultaat.data[i].Pagina_Naam + "/' ><h3>" + resultaat.data[i].Naam + "</h3></a></div>");}
            if(resultaat.data[i].Doctor == "10" || resultaat.data[i].Doctor2 == "10" || resultaat.data[i].Doctor3 == "10" || resultaat.data[i].Doctor4 == "10") {
                $("#resultD9").append("<div><a href='../" + resultaat.data[i].Pagina_Naam + "/' ><h3>" + resultaat.data[i].Naam + "</h3></a></div>");}
            if(resultaat.data[i].Doctor == "11" || resultaat.data[i].Doctor2 == "11" || resultaat.data[i].Doctor3 == "11" || resultaat.data[i].Doctor4 == "11") {
                $("#resultD10").append("<div><a href='../" + resultaat.data[i].Pagina_Naam + "/' ><h3>" + resultaat.data[i].Naam + "</h3></a></div>");}
            if(resultaat.data[i].Doctor == "12" || resultaat.data[i].Doctor2 == "12" || resultaat.data[i].Doctor3 == "12" || resultaat.data[i].Doctor4 == "12") {
                $("#resultD11").append("<div><a href='../" + resultaat.data[i].Pagina_Naam + "/' ><h3>" + resultaat.data[i].Naam + "</h3></a></div>");}
            if(resultaat.data[i].Doctor == "13" || resultaat.data[i].Doctor2 == "13" || resultaat.data[i].Doctor3 == "13" || resultaat.data[i].Doctor4 == "13") {
                $("#resultD12").append("<div><a href='../" + resultaat.data[i].Pagina_Naam + "/' ><h3>" + resultaat.data[i].Naam + "</h3></a></div>");}
            if(resultaat.data[i].Doctor == "14" || resultaat.data[i].Doctor2 == "14" || resultaat.data[i].Doctor3 == "14" || resultaat.data[i].Doctor4 == "14") {
                $("#resultD13").append("<div><a href='../" + resultaat.data[i].Pagina_Naam + "/' ><h3>" + resultaat.data[i].Naam + "</h3></a></div>");}
        }
    }).fail(function(response, statusText, xhr) {
    }).always(function() {
    });
}
function videosophalen(menu, id) {
    $.ajax({
        type: "GET",
        url: "/php/videosophalen.php?menu=" + menu + "&id=" + id,
        dataType: 'json',
        cache: false
    }).done(function(resultaat) {
        $(".col-6").append("<div class='main_vid'></div>");
        $(".col-6").append("<div class='vid_choice'></div>");
        if(id === "0" || id == null) {id = Math.floor((Math.random() * resultaat.data.length) + 1);}else{id=id;}
        for(i = 0; i < resultaat.data.length; i++) {
            if(id === resultaat.data[i].id) {
                if(resultaat.data[i].Video_Type === "Youtube") {
                    $(".main_vid").append("<h2>" + resultaat.data[i].Video_Name + "</h2>");
                    $(".main_vid").append("<iframe width='853' height='480' src='" + resultaat.data[i].Video_URL + "' frameborder='0' allowfullscreen></iframe>");
                }else{
                    $(".main_vid").append("<h2>" + resultaat.data[i].Video_Name + "</h2>")
                    $(".main_vid").append("<video width='480' controls controlsList='nodownload'><source src='../" + resultaat.data[i].Video_URL + "' type='video/mp4'></video>");
                }
            }else{
                if(resultaat.data[i].SPOILER === 1) {
                    $(".vid_choice").append("<a href='#' title='" + resultaat.data[i].Video_Name + "' onclick=event.preventDefault();$('.col-6').html('');videosophalen('Video'," + resultaat.data[i].id + ") class='inline_vid' ><div class=keuze><div><img src='../" + resultaat.data[i].Video_Image + "' class='thumbnail' style='display:inline;background-color:red' alt='" + resultaat.data[i].Video_Name + "'></div><p title='" + resultaat.data[i].Video_Name + "'>" + resultaat.data[i].Video_Name.substr(0, 13) + "...</p></div></a>");
                }else{
                    $(".vid_choice").append("<a href='#' title='" + resultaat.data[i].Video_Name + "' onclick=event.preventDefault();$('.col-6').html('');videosophalen('Video'," + resultaat.data[i].id + ") class='inline_vid' ><div class=keuze><div><img src='../" + resultaat.data[i].Video_Image + "' class='thumbnail' style='display:inline;' alt='" + resultaat.data[i].Video_Name + "'></div><p title='" + resultaat.data[i].Video_Name + "'>" + resultaat.data[i].Video_Name.substr(0, 13) + "...</p></div></a>");
                }
            }
        }
    }).fail(function(response, statusText, xhr) {
    }).always(function() {
    });
}
function quotesophalen(menu, id) {
    $.ajax({
        type: "GET",
        url: "/php/quotesophalen.php?menu=" + menu + "&id=" + id,
        dataType: 'json',
        cache: false
    }).done(function(resultaat) {
        $(".col-6").append("<div class='main_quote' style=''></div>");
        $(".col-6").append("<div class='selectie'></div>");
        $(".selectie").append("<div class='linkerquote'></div>");
        $(".selectie").append("<div class='rechterquote'></div>");
        if(id === "0" || id== null) {id = Math.floor((Math.random() * resultaat.data.length) + 1);}else{id = id;}
        for (i = 0; i < resultaat.data.length; i++) {
            if(id === resultaat.data[i].id) {
                $(".main_quote").append("<h1>" + resultaat.data[i].Aflevering + "</h1>");
                $(".main_quote").append("<div><img class='quote_picture' src='" + resultaat.data[i].QuotePic + "'/><p class='quotetext'>" + resultaat.data[i].Quote + "</p><p>" + resultaat.data[i].Personage + "</p><div>");
            }else{
                var quote = resultaat.data[i].Quote;
                var quote_short = quote.substring(0, 60);
                if(quote_short.indexOf('<br>') >= 0) {var quote_short_zonder_enter = quote_short.substring(0, quote_short.indexOf('<br'));
                }else{var quote_short_zonder_enter = quote_short;}
                if(i % 2 === 0) {
                    $(".linkerquote").append("<div><a href='#' onclick=event.preventDefault();$('.col-6').html('');quotesophalen('Quotes'," + resultaat.data[i].id + ")>" + quote_short_zonder_enter + "</a></div>");
                }else{
                    $(".rechterquote").append("<div><a href='#' onclick=event.preventDefault();$('.col-6').html('');quotesophalen('Quotes'," + resultaat.data[i].id + ")>" + quote_short_zonder_enter + "</a></div>");
                }
            }
        }
    }).fail(function(response, statusText, xhr) {}).always(function() {});
}
function GetNews() {
    $.ajax({
        type: "GET",
        url: "/php/GetNews.php",
        dataType: 'json',
        cache: false
    }).done(function(resultaat) {
        $(".col-6").append("<div class='news' style=''></div>");
        for (i = 0; i < resultaat.data.length; i++) {
            $(".news").append("<div class='newsitem' id='" + resultaat.data[i].id + "'></div>");
            $("#" + resultaat.data[i].id).append("<h2>" + resultaat.data[i].Titel + "</h2>");
            $("#" + resultaat.data[i].id).append("<h3>" + resultaat.data[i].Datum + "</h3>");
            $("#" + resultaat.data[i].id).append("<img src='" + resultaat.data[i].Foto + "' alt='" + resultaat.data[i].alt + "' class='" + resultaat.data[i].Class + "'/><span class='" + resultaat.data[i].Class_Text + "'>" + resultaat.data[i].Bericht + "</span>");
        }
         
    }).fail(function(response, statusText, xhr) {
    }).always(function() {
    });
    
}
function GetQuotesByCharacter(Character) {
    Character = Character.trim();
    $.ajax({
        type: "GET",
        url: "/php/quotesophalenbyCharacter.php?Character=" + Character,
        dataType: 'json',
        cache: false
    }).done(function(resultaat) {
        if(resultaat.data.length === 0) {$("#Quotes").append("<p>Er werden voor dit personage nog geen quotes gevonden.</p>");
        }else{for (i = 0; i < resultaat.data.length; i++) {$("#Quotes").append("<p class='quoteitem'>" + resultaat.data[i].Quote + "</p>");}}
    }).fail(function(response, statusText, xhr) {
        $("#Quotes").append("<p>Er werden voor dit personage nog geen quotes gevonden.</p>");
    }).always(function() {});
}
function GetQuotesByEpisode(Episode) {
    Episode = Episode.trim();
    $.ajax({
        type: "GET",
        url: "/php/quotesophalenbyEpisode.php?Episode=" + Episode,
        dataType: 'json',
        cache: false
    }).done(function(resultaat) {
        if(resultaat.data.length === 0) {$("#Quotes").append("<p>Er werden voor deze aflevering nog geen quotes gevonden.</p>");}else{
            for (i = 0; i < resultaat.data.length; i++) {$("#Quotes").append("<p class='quoteitem'>" + resultaat.data[i].Quote + "</p>");}
        }
    }).fail(function(response, statusText, xhr) {
        $("#Quotes").append("<p>Er werden voor deze aflevering nog geen quotes gevonden.</p>");
    }).always(function() {});
}
function GetDownloadsByEpisode(Episode) {
    Episode = Episode.trim();
    $.ajax({
        type: "GET",
        url: "/php/downloadsophalenbyEpisode.php?Episode=" + Episode,
        dataType: 'json',
        cache: false
    }).done(function(resultaat) {
        if(resultaat.data.length === 0) {$("#Downloads").append("<p>Er werden voor deze aflevering nog geen downloads gevonden.</p>");}else{
            for (i = 0; i < resultaat.data.length; i++) {
                $("#Downloads").append("<p>" + resultaat.data[i].download_Type + ": <a href='"+resultaat.data[i].download_link+"' target='_blank'>"+resultaat.data[i].download_Naam+"</a> ("+resultaat.data[i].download_Taal+") <a href='"+resultaat.data[i].download_link+"' download>Direct Download</a></p>");}
        }
    }).fail(function(response, statusText, xhr) {
        $("#Downloads").append("<p>Er werden voor deze aflevering nog geen downloads gevonden.</p>");
    }).always(function() {});
}
function GetOneRandomQuote() {
    $.ajax({
        type: "GET",
        url: "/php/GetOneRandomQuote.php",
        dataType: 'json',
        cache: false
    }).done(function(resultaat) {
        $('.quote').append("<p>" + resultaat.data[0].Quote + " ...</p>")
        if(taal == "NL") {
            $('.quote').append("<a href='../Quotes/'>Lees meer</a>");
        }else{
            $('.quote').append("<a href='../Quotes/'> Read More</a>");
        }
        $('.quote').append("<p>" + resultaat.data[0].Personage + " - " + resultaat.data[0].Aflevering + "</p>")
    }).fail(function(response, statusText, xhr) {
    }).always(function() {
    });
}
function contentophalen(taal, menu) {
    $.ajax({
        type: "GET",
        url: "/php/alles.php?taal=" + taal + "&menu=" + menu,
        dataType: 'json',
        cache: false
    }).done(function(resultaat) {
        aantalrecords = resultaat.data.length;
        var i;
        for (i = 0; i < resultaat.data.length; i += 1) {
            if(resultaat.data[i].A_Pagina_Type === "Slider") {
                $(".col-6").append("<div class='slideshow-container'><a class='prev' onclick='plusSlides(-1)'>&#10094;</a><a class='next' onclick='plusSlides(1)'>&#10095;</a></div>");
            }
            if(resultaat.data[i].A_Pagina_Type === "WikiPagina") {
                $(".col-6").append("<div id='WikiDetails'></div>");
                $(".under").append("<div id='Voetnoot'><h2>Voetnoten</h2><ol></ol></div>");
                $("#WikiDetails").append("<div id='Items'></div>");
            }
            if(resultaat.data[i].A_Type === "Titel" || resultaat.data[i].A_Type === "EpisodeTitel"||resultaat.data[i].A_Type === "CharacterTitel") {
                $(".col-6").prepend("<h1>" + resultaat.data[i].A_Waarde + "</h1>");
                if(resultaat.data[i].A_Type === "EpisodeTitel") {
                    $(".under").prepend("<div id='Under_Upper'>")
                    $("#Under_Upper").append("<div id='Quotes' class='anchor'></div>");
                    $("#Under_Upper").append("<div id='Downloads' class='anchor'><h2>Downloads</h2></div>");
                    $("#Quotes").append("<h2>Quotes</h2>");
                    var Episode = resultaat.data[i].A_Pagina;
                    GetQuotesByEpisode(Episode);
                    GetDownloadsByEpisode(Episode);
                    
                }
                if(resultaat.data[i].A_Type === "CharacterTitel") {
                    $(".under").prepend("<div id='Under_Upper'>")
                    $("#Under_Upper").append("<div id='Quotes'></div>");
                    $("#Quotes").append("<h2>Quotes</h2>");
                    var Character = resultaat.data[i].A_Waarde;
                    GetQuotesByCharacter(menu.split('_').join(' '));
                }
            }
            if(resultaat.data[i].A_Type === "EpisodeStatus") {
                $("#Items").prepend("<div class='WikiItemTitel " + resultaat.data[i].A_Klasse + "'>Status: " + resultaat.data[i].A_Waarde + "</div>");
            }
            if(resultaat.data[i].A_Type === "EpisodeDoctorList") {
                $("#Items").append("<div class=WikiItemTitel>Cast</div>");
                $("#Items").append("<span class=WikiRule>Doctor: <ul>" + resultaat.data[i].A_Waarde + "</ul></span>");
            }
            if(resultaat.data[i].A_Type === "EpisodeMainSetting") {
                $("#Items").append("<div class=WikiItemTitel>Story</div>");
                $("#Items").append("<span class=WikiRule>Main setting: <ul>" + resultaat.data[i].A_Waarde + "</ul></span>");
            }
            if(resultaat.data[i].A_Type === "EpisodeMainEnemy") {
                $("#Items").append("<span class=WikiRule>Main Enemy: <ul>" + resultaat.data[i].A_Waarde + "</ul></span>");
            }
            if(resultaat.data[i].A_Type === "EpisodeCompanionList") {
                $("#Items").append("<span class=WikiRule>Companions: <ul>" + resultaat.data[i].A_Waarde + "</ul></span>");
            }
            if(resultaat.data[i].A_Type === "EpisodeOtherList") {
                if(taal === "NL") {$("#Items").append("<span class=WikiRule>Anderen: <ul>" + resultaat.data[i].A_Waarde + "</ul></span>");}else{
                    $("#Items").append("<span class=WikiRule>Others: <ul>" + resultaat.data[i].A_Waarde + "</ul></span>");}
            }
            if(resultaat.data[i].A_Type === "EpisodeDirectorList") {
                if(taal === "NL") {
                    $("#Items").append("<div class=WikiItemTitel>Productie</div>");
                    $("#Items").append("<div class=WikiRule>Geregisseerd door: <ul>" + resultaat.data[i].A_Waarde + "</ul></div>");
                }else{
                    $("#Items").append("<div class=WikiItemTitel>Production</div>");
                    $("#Items").append("<div class=WikiRule>Directed by: <ul class='singular_list_item>" + resultaat.data[i].A_Waarde + "</ul></div>");
                }
            }
            if(resultaat.data[i].A_Type === "EpisodePrevious") {
                if(taal === "NL") {
                    $("#Items").append("<div class='WikiItemTitel'>Chronologie</div>");
                    $("#Items").append("<div class='Chronologie'></div>");
                    $(".Chronologie").append("<div class='Half'>Vorige aflevering:<br>" + resultaat.data[i].A_Waarde + "</div>");
                }else{
                    $("#Items").append("<div class='WikiItemTitel'>Chronology</div>");
                    $("#Items").append("<div class='Chronologie'></div>");
                    $(".Chronologie").append("<div class='Half'>Previous episode:<br>" + resultaat.data[i].A_Waarde + "</div>");
                }
            }
            if(resultaat.data[i].A_Type === "EpisodeNext") {
                if(taal === "NL"){$(".Chronologie").append("<div class='Half Rechts'>Volgende aflevering:<br>" + resultaat.data[i].A_Waarde + "</div>");
                }else{$(".Chronologie").append("<div class='Half Rechts'>Next episode:<br>" + resultaat.data[i].A_Waarde + "</div>");}
            }
            if(resultaat.data[i].A_Type === "EpisodeWriterList") {
                if(taal === "NL"){$("#Items").append("<div class=WikiRule>Geschreven door: <ul>" + resultaat.data[i].A_Waarde + "</ul></div>");
                }else{$("#Items").append("<div class=WikiRule>Written by: <ul>" + resultaat.data[i].A_Waarde + "</ul></div>");}
            }
            if(resultaat.data[i].A_Type === "EpisodeEditorList") {$("#Items").append("<div class=WikiRule>Script editor: <ul>" + resultaat.data[i].A_Waarde + "</ul></div>");}
            if(resultaat.data[i].A_Type === "EpisodeProducerList") {
                if(taal === "NL"){$("#Items").append("<div class=WikiRule>Geproduced door: <ul>" + resultaat.data[i].A_Waarde + "</ul></div>");
                }else{$("#Items").append("<div class=WikiRule>Produced by: <ul>" + resultaat.data[i].A_Waarde + "</ul></div>");}
            }
            if(resultaat.data[i].A_Type === "EpisodeComposerList") {
                if(taal === "NL"){$("#Items").append("<div class=WikiRule>Incidentele componist : <ul>" + resultaat.data[i].A_Waarde + "</ul></div>");
                }else{$("#Items").append("<div class=WikiRule>Incidental music composer: <ul>" + resultaat.data[i].A_Waarde + "</ul></div>");}
            }
            if(resultaat.data[i].A_Type === "EpisodeProductionCode") {
                if(taal === "NL"){$("#Items").append("<div class=WikiRule>Productiecode : <span>" + resultaat.data[i].A_Waarde + "</span></div>");
                }else{$("#Items").append("<div class=WikiRule>Production Code : <span>" + resultaat.data[i].A_Waarde + "</span></div>");}
            }
            if(resultaat.data[i].A_Type === "EpisodeSeries") {$("#Items").append("<div class=WikiRule>Series : <span>" + resultaat.data[i].A_Waarde + "</span></div>");}
            if(resultaat.data[i].A_Type === "EpisodeLength") {
                if(taal === "NL") {$("#Items").append("<div class=WikiRule>Lengte : <span>" + resultaat.data[i].A_Waarde + "</span></div>");
                }else{$("#Items").append("<div class=WikiRule>Length : <span>" + resultaat.data[i].A_Waarde + "</span></div>");}
            }
            if(resultaat.data[i].A_Type === "EpisodeDateStarted") {
                if(taal === "NL") {$("#Items").append("<div class=WikiRule>Startdatum : <span>" + resultaat.data[i].A_Waarde + "</span></div>");
                }else{$("#Items").append("<div class=WikiRule>Date Started : <span>" + resultaat.data[i].A_Waarde + "</span></div>");}
            }
            if(resultaat.data[i].A_Type === "EpisodeDateEnded") {
                if(taal === "NL") {$("#Items").append("<div class=WikiRule>Einddatum : <span>" + resultaat.data[i].A_Waarde + "</span></div>");
                }else{$("#Items").append("<div class=WikiRule>Date Ended : <span>" + resultaat.data[i].A_Waarde + "</span></div>");}
            }
            if(resultaat.data[i].A_Type === "Inleiding") {
                $(".col-6").append("<div class='" + resultaat.data[i].A_Klasse + "'>" + resultaat.data[i].A_Waarde + "</div>");
                $(".col-6").append("<div id='Inhoud'>Inhoudstafel<ol></ol></div>");
            }
            if(resultaat.data[i].A_Type === "Tekst") {$(".col-6").append("<div class='" + resultaat.data[i].A_Klasse + "'>" + resultaat.data[i].A_Waarde + "</div>");}
            if(resultaat.data[i].A_Type === "Losse_Code") {$(".col-6").append(resultaat.data[i].A_Waarde);}
            if(resultaat.data[i].A_Type === "VoetnootItem") {$("#Voetnoot ol").append("<li class='" + resultaat.data[i].A_Klasse + "'>" + resultaat.data[i].A_Waarde + "</li>");}
            if(resultaat.data[i].A_Type === "Voetnoot") {$("#Voetnoot ol").append(resultaat.data[i].A_Waarde);}

            if(resultaat.data[i].A_Type === "Kop2") {
                
                    $(".col-6").append("<h2 class='" + resultaat.data[i].A_Klasse + " anchor' id='" + resultaat.data[i].A_ID + "'>" + resultaat.data[i].A_Waarde + "</h2>");
            }
            if(resultaat.data[i].A_Type === "Kop3") {
                
                $(".col-6").append("<h3 class='" + resultaat.data[i].A_Klasse + "' id='" + resultaat.data[i].A_ID + "'>" + resultaat.data[i].A_Waarde + "</h3>");}
            if(resultaat.data[i].A_Type === "Kop4") {
                
                $(".col-6").append("<h4 class='" + resultaat.data[i].A_Klasse + "' id='" + resultaat.data[i].A_ID + "'>" + resultaat.data[i].A_Waarde + "</h4>");}
            if(resultaat.data[i].A_Type === "Kop5") {
                
                $(".col-6").append("<h5 class='" + resultaat.data[i].A_Klasse + "' id='" + resultaat.data[i].A_ID + "'>" + resultaat.data[i].A_Waarde + "</h5>");}
            if(resultaat.data[i].A_Type === "Kop6") {
                
                $(".col-6").append("<h6 class='" + resultaat.data[i].A_Klasse + "' id='" + resultaat.data[i].A_ID + "'>" + resultaat.data[i].A_Waarde + "</h6>");
            }
            if(resultaat.data[i].A_Type === "Lijst") {
                $(".col-6").append("<ul class='" + resultaat.data[i].A_Klasse + "' id='" + resultaat.data[i].A_ID + "'>" + resultaat.data[i].A_Waarde + "</ul>");
            }
            if(resultaat.data[i].A_Pagina_Type === "Overzicht") {
                $(".under").append("<div class='topics'></div>");
                getchildren(menu);
            }
            if(resultaat.data[i].A_Type === "Afbeelding") {
                if(resultaat.data[i].A_Pagina_Type === "Wiki") {
                    var j;
                    for (j = 0; j < resultaat.data.length; j += 1) {
                        if(resultaat.data[j].A_Hoort_Bij === resultaat.data[i].A_ID && (resultaat.data[j].A_Type === "Bijschrijft" || resultaat.data[j].A_Type === "Alt")) {
                            $("#WikiDetails").prepend("<div><img src='" + resultaat.data[i].A_Waarde + "' class='Wiki_Foto " + resultaat.data[i].A_Klasse + "' title='" + resultaat.data[j].A_Waarde + " ' alt='" + resultaat.data[j].A_Waarde + "'></div>");
                        }
                    }
                }else if(resultaat.data[i].A_Pagina_Type === "Slide") {
                    for (j = 0; j < resultaat.data.length; j += 1) {
                        if(resultaat.data[j].A_Hoort_Bij === resultaat.data[i].A_ID && (resultaat.data[j].A_Type === "Alt" || resultaat.data[j].A_Type === "Bijschrift")) {
                            $(".slideshow-container").append("<div class='mySlides fade'><img src='" + resultaat.data[i].A_Waarde + "' alt='" + resultaat.data[j].A_Waarde + " tile='" + resultaat.data[j].A_Waarde + "'style='80%;padding-left:6em;'><div class='text'>" + resultaat.data[j].A_Waarde + "</div></div>");
                        }
                    }
                    setTimeout(function() {
                        showSlides(slideIndex);
                    }, 1000);
                }else{
                    var j;
                    for (j = 0; j < resultaat.data.length; j += 1) {
                        if(resultaat.data[j].A_Hoort_Bij === resultaat.data[i].A_ID && (resultaat.data[j].A_Type === "Alt" || resultaat.data[j].A_Type === "Bijschrift")) {
                            $(".col-6").append("<div id='" + resultaat.data[i].A_ID + "' class='foto_met_text " + resultaat.data[i].A_Klasse + "'></div>");
                            $("#" + resultaat.data[i].A_ID).append("<img src='" + resultaat.data[i].A_Waarde + "' alt='" + resultaat.data[j].A_Waarde + " title='" + resultaat.data[j].A_Waarde + "'>");
                            $("#" + resultaat.data[i].A_ID).append("<p class='" + resultaat.data[j].A_Klasse + "'>" + resultaat.data[j].A_Waarde + "</p>");
                        }
                    }
                }
            }
            if(resultaat.data[i].A_Type === "WikiItemPlayedBy") {
                if(taal === "NL") {
                    $("#Items").append("<div class='WikiRule'><span class='WikiItem'>Gespeeld door:</span><span class='WikiItem content'>" + resultaat.data[i].A_Waarde + "</span></div>");
                }else{
                    $("#Items").append("<div class='WikiRule'><span class='WikiItem'>Played by:</span><span class='WikiItem content'>" + resultaat.data[i].A_Waarde + "</span></div>");
                }
            }
            if(resultaat.data[i].A_Type === "WikiItemPlayedByList") {
                if(taal === "NL") {
                    $("#Items").append("<div class='WikiRule'><span class='WikiItem'>Gespeeld door:</span><ul class='WikiItem content List'>" + resultaat.data[i].A_Waarde + "</ul></div>");
                }else{
                    $("#Items").append("<div class='WikiRule'><span class='WikiItem'>Played by:</span><ul class='WikiItem content List'>" + resultaat.data[i].A_Waarde + "</ul></div>");
                }
            }
            if(resultaat.data[i].A_Type === "AantalSeizoenen") {
                if(taal === "NL") {
                    $("#Items").append("<div class='WikiRule'><span class='WikiItem'>Aantal seizoenen:</span><span class='WikiItem content'>" + resultaat.data[i].A_Waarde + "</span></div>");
                }else{
                    $("#Items").append("<div class='WikiRule'><span class='WikiItem'>Number of Seasons</span><span class='WikiItem content'>" + resultaat.data[i].A_Waarde + "</span></div>");
                }
            }
            if(resultaat.data[i].A_Type === "Verschijningen") {
                if(taal === "NL") {
                    $("#Items").append("<div class='WikiRule'><span class='WikiItem'>Aantal <br>verschijningen:</span><span class='WikiItem content'>" + resultaat.data[i].A_Waarde + "</span></div>");
                }else{
                    $("#Items").append("<div class='WikiRule'><span class='WikiItem'>Number of<br>appearances:</span><span class='WikiItem content'>" + resultaat.data[i].A_Waarde + "</span></div>");
                }
            }
            if(resultaat.data[i].A_Type === "Periode") {
                if(taal === "NL") {
                    $("#Items").append("<div class='WikiRule'><span class='WikiItem'>Periode: </span><span class='WikiItem content'>" + resultaat.data[i].A_Waarde + "</span></div>");
                }else{
                    $("#Items").append("<div class='WikiRule'><span class='WikiItem'>Tenure:</span><span class='WikiItem content'>" + resultaat.data[i].A_Waarde + "</span></div>");
                }
            }
            if(resultaat.data[i].A_Type === "WikiItemFirstEpisode") {
                if(taal === "NL") {
                    $("#Items").append("<div class='WikiRule'><span class='WikiItem'>Eerste Aflevering:</span><span class='WikiItem content'>" + resultaat.data[i].A_Waarde + "</span></div>");
                }else{
                    $("#Items").append("<div class='WikiRule'><span class='WikiItem'>First Episode:</span><span class='WikiItem content'>" + resultaat.data[i].A_Waarde + "</span></div>");
                }
            }
            if(resultaat.data[i].A_Type === "WikiItemLastEpisode") {
                if(taal === "NL") {
                    $("#Items").append("<div class='WikiRule'><span class='WikiItem'>Laatste Aflevering:</span><span class='WikiItem content'>" + resultaat.data[i].A_Waarde + "</span></div>");
                }else{
                    $("#Items").append("<div class='WikiRule'><span class='WikiItem'>Last Episode:</span><span class='WikiItem content'>" + resultaat.data[i].A_Waarde + "</span></div>");
                }
            }
            if(resultaat.data[i].A_Type === "WikiItemFirstEpisodeList") {
                if(taal === "NL") {
                    $("#Items").append("<div class='WikiRule'><span class='WikiItem'>Eerste Aflevering:</span><ul class='WikiItem content List'>" + resultaat.data[i].A_Waarde + "</ul></div>");
                }else{
                    $("#Items").append("<div class='WikiRule'><span class='WikiItem'>First Episode:</span><ul class='WikiItem content List'>" + resultaat.data[i].A_Waarde + "</ul></div>");
                }
            }
            if(resultaat.data[i].A_Type === "WikiItemLastEpisodeList") {
                if(taal === "NL") {
                    $("#Items").append("<div class='WikiRule'><span class='WikiItem'>Laatste Aflevering:</span><ul class='WikiItem content List'>" + resultaat.data[i].A_Waarde + "</ul></div>");
                }else{
                    $("#Items").append("<div class='WikiRule'><span class='WikiItem'>Last Episode:</span><ul class='WikiItem content List'>" + resultaat.data[i].A_Waarde + "</ul></div>");
                }
            }
            if(resultaat.data[i].A_Type === "CompanionList") {
                $("#Items").append("<div class='WikiRule'><span class='WikiItem'>Companions:</span><ul class='WikiItem content List'>" + resultaat.data[i].A_Waarde + "</ul></div>");
            }
            if(resultaat.data[i].A_Type === "SeriesList") {
                $("#Items").append("<div class='WikiRule'><span class='WikiItem'>Series:</span><ul class='WikiItem content List'>" + resultaat.data[i].A_Waarde + "</ul></div>");
            }
            if(resultaat.data[i].A_Type === "Form") {
                $(".col-6").append(resultaat.data[i].A_Waarde);
            }
                
            
        }
        $("#Inhoud ol").toc({content: "article", headings: "h2,h3,h4,h5,h6"});
         $('a[href^="http"]').each(function() {
                    var link = $(this).attr("href");
                    if (link.indexOf("doctorwhofans.be") === -1 && link.indexOf("https://www.facebook.com/DoctorWhoFansBE/") === -1 && link.indexOf("https://rubendebusscherodisee.github.io/DoctorwhofansBE/") === -1 ) {
                        $(this).after('<sup><a href="'+link+'" target="_blank" title="open in a new tab"><i class="fa fa-external-link" aria-hidden="true"></i></a></sup>')
                    }

                });
                if (getCookie("size") != "") {
                    getSizesfromCookie()
                }
    }).fail(function(response, statusText, xhr) {
    }).always(function() {
        
    });
        
    

}


(function($) {
    'use strict';
    $.fn.fitVids = function(options) {
        var settings = {
            customSelector: null,
            ignore: null
        };
        if(!document.getElementById('fit-vids-style')) {
            var head = document.head || document.getElementsByTagName('head')[0];
            var css = '.fluid-width-video-wrapper{width:100%;position:relative;padding:0;}.fluid-width-video-wrapper iframe,.fluid-width-video-wrapper object,.fluid-width-video-wrapper embed {position:absolute;top:0;left:0;width:100%;height:100%;}';
            var div = document.createElement("div");
            div.innerHTML = '<p>x</p><style id="fit-vids-style">' + css + '</style>';
            head.appendChild(div.childNodes[1]);
        }
        if(options) {
            $.extend(settings, options);
        }
        return this.each(function() {
            var selectors = ['iframe[src*="player.vimeo.com"]', 'iframe[src*="youtube.com"]', 'iframe[src*="youtube-nocookie.com"]', 'iframe[src*="kickstarter.com"][src*="video.html"]', 'object', 'embed'];
            if(settings.customSelector) {
                selectors.push(settings.customSelector);
            }
            var ignoreList = '.fitvidsignore';
            if(settings.ignore) {
                ignoreList = ignoreList + ', ' + settings.ignore;
            }
            var $allVideos = $(this).find(selectors.join(','));
            $allVideos = $allVideos.not('object object');
            $allVideos = $allVideos.not(ignoreList);
            $allVideos.each(function() {
                var $this = $(this);
                if($this.parents(ignoreList).length > 0) {
                    return;
                }
                if(this.tagName.toLowerCase() === 'embed' && $this.parent('object').length || $this.parent('.fluid-width-video-wrapper').length) {
                    return;
                }
                if((!$this.css('height') && !$this.css('width')) && (isNaN($this.attr('height')) || isNaN($this.attr('width')))) {
                    $this.attr('height', 9);
                    $this.attr('width', 16);
                }
                var height = (this.tagName.toLowerCase() === 'object' || ($this.attr('height') && !isNaN(parseInt($this.attr('height'), 10)))) ? parseInt($this.attr('height'), 10) : $this.height(),
                    width = !isNaN(parseInt($this.attr('width'), 10)) ? parseInt($this.attr('width'), 10) : $this.width(),
                    aspectRatio = height / width;
                if(!$this.attr('name')) {
                    var videoName = 'fitvid' + $.fn.fitVids._count;
                    $this.attr('name', videoName);
                    $.fn.fitVids._count++;
                }
                $this.wrap('<div class="fluid-width-video-wrapper"></div>').parent('.fluid-width-video-wrapper').css('padding-top', (aspectRatio * 100) + '%');
                $this.removeAttr('height').removeAttr('width');
            });
        });
    };
    $.fn.fitVids._count = 0;
})(window.jQuery || window.Zepto)
$(function() {
    jQuery(".SitemapButton").click(function() {
        jQuery(this).parent().next().toggle();
        if(jQuery(this).parent().next().attr('display') === 'none' || jQuery(this).text() == "+") {
            jQuery(this).text("-");
        }else if(jQuery(this).parent().next().attr('display') === 'block' || jQuery(this).text() == "-") {
            jQuery(this).text("+");
        }
    });
    
})

function ToggleMenu(){
    $('nav').slideToggle();
}

function ToggleCompanion(Doctor){
    event.preventDefault();
    $("#result"+Doctor).slideToggle();
}

function ToggleResult(div){
    event.preventDefault();
    $("#"+div).slideToggle();
}

function Spoilertonen(content) {
    stopVideos();
    $('#' + content).toggle();
}
function stopVideos() {
    $("iframe").each(function() {
        var src = $(this).attr('src');
        $(this).attr('src', src);
    });
}
function on() {
    document.getElementById("overlay_Afbeelding").style.display = "block";
}
function off() {
    document.getElementById("overlay_Afbeelding").style.display = "none";
}
function plusSlides(n) {
    showSlides(slideIndex += n);
}
function showSlides(n) {
    var i;
    var slides = document.getElementsByClassName("mySlides");
    if(n > slides.length) {
       slideIndex = 1
    }
    for (i = 0; i < slides.length; i++) {
        slides[i].style.display = "none";
    }
    slides[slideIndex - 1].style.display = "block";
}


