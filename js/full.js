/*SEND MESSAGES*/
$(function () {
	var form = $('#ajax-contact');
	var formMessages = $('#editor').innerhtml;
	$('#SendEmailButton').click(function (event) {
		event.preventDefault();
		if ($('#Phone').val() === "") {
			var mail = {};
			mail.name = $('#name').val();
			mail.subject = $('#subject').val();
			mail.emailToReply = $('#email').val();
			jQuery.get('https://www.doctorwhofans.be/mail.html', function (data) {
				var template = data;
			});
			mail.message = $("#txtEditor").Editor("getText");
			$.ajax({
					type: 'POST',
					url: $(form).attr('action'),
					data: mail
				})
				.done(function (response) {
					$(formMessages).removeClass('error');
					$(formMessages).addClass('success');
					$(formMessages).text(response);
					$('#name').val('');
					$('#subject').val('');
					$('#email').val('');
					$('#Phone').val('');
					$("#txtEditor").Editor("setText", "");
				})
				.fail(function (data) {
					$(formMessages).removeClass('success');
					$(formMessages).addClass('error');
					if (data.responseText !== '') {
						$(formMessages).text(data.responseText);
					} else {
						$(formMessages).text('Oops! An error occured and your message could not be sent.');
					}
				});
		}
	});
});












































/*COOKIES */
var AvailableLangCodes = [];


function setCookie(cname, cvalue, exdays) {
	var d = new Date();
	d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
	var expires = "expires=" + d.toUTCString();
	document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
	if(cname=="lang"){
		$('meta[name=language]').attr('content', cvalue.replace('_', '-'));
		$('html').attr('lang', cvalue.replace('_', '-'));
	}
	

}


function getAvailableLangcodes() {
	$.ajax({
		type: "GET",
		url: "/php/getAvailable_Lang.php",
		dataType: 'json',
		crossDomain: true,
		cache: false
	}).done(
		function (resultaat) {
			AvailableLangCodes = resultaat;
			checkCookie();
			//setLangstrings(getCookie("lang"));
		}).fail(function (response, statusText, xhr) {}).always(function () {});
}

function getCookie(cname) {
	var name = cname + "=";
	var decodedCookie = decodeURIComponent(document.cookie);
	var ca = decodedCookie.split(';');
	for (var i = 0; i < ca.length; i++) {
		var c = ca[i];
		while (c.charAt(0) == ' ') {
			c = c.substring(1);
		}
		if (c.indexOf(name) == 0) {
			return c.substring(name.length, c.length);
		}
	}
	return "";
}

function checkCookie() {

	var lang = getCookie("lang");
	if (lang == "") {
		if (AvailableLangCodes.includes(navigator.language) === true) {
			setCookie("lang", navigator.language, 30);
		} else {
			setCookie("lang", "en", 30);

		}
	} else {
		if (AvailableLangCodes.includes(lang) === true) {} else {
			setCookie("lang", "en", 30);
		}
	}
	setLangstrings(getCookie("lang"));

}

function renderpage(taal, menu) {

	checkmenu(menu);
	if (menu === "Contact") {
		$("#txtEditor").Editor();
	}
	if (menu !== "Home") {
		$(".quote").remove();
		getpad(menu);
	}
	if (menu === "Home") {
		$('.path').remove();
		GetOneRandomQuote();
	}
	if (menu === "News") {
		GetNews();
	}

	contentophalen(taal, menu);
}


function getSizesfromCookie() {
	$('#size').text(getCookie("size"));
	$(".col-6,.under,footer").children().each(function () {
		var size = parseInt($(this).css("font-size"));
		size = size + parseInt(getCookie("size")) + "px";
		$(this).css({
			'font-size': size
		});
	});
}

function rerenderpage(taal, menu) {
	$('.col-6, .under, .path').hide();


	checkmenu(menu);
	if (menu === "Contact") {
		$("#txtEditor").Editor();
	}
	if (menu !== "Home") {
		getpad(menu);
	}
	if (menu === "Home") {
		$('.path').remove();
	}
	if (menu === "News") {
		GetNews();
	}
	contentophalen(taal, menu);
}

function changelang(taal) {
	jQuery("#overlay_background, #overlay").fadeOut(500);
	document.documentElement.style.overflow = "auto";
	document.body.scroll = "yes";
	$('meta[name=language]').attr('content', taal.replace('_', '-'));
	$('html').attr('lang', taal.replace('_', '-'));

	$('.col-6, .under, .path').fadeOut(800);
	setCookie("lang", taal, 30);

	$('.col-6, .under, .path').empty();
	$('#overlay_background, #overlay').hide();
	$.get("/Locale/" + getCookie('lang') + "/" + getCookie('lang') + ".json", function (translation) {
		translations.length=0;
		translations.push(translation);
		filltext(); //fill these in first to verift function runs ok
		//renderpage(getCookie("lang"), menu);

	});
	rerenderpage(getCookie("lang"), menu);
	$('.col-6, .under, .path').fadeIn();
}




function ToggleNightMode() {
	//TODO: #41 Finish dark mode in order to allow full night view
	event.preventDefault();
	if(getCookie('mode')==='night'){
		setCookie('mode','day',0.5);
	}else{
		setCookie('mode','night',0.5);
	}
	//$('body,button,input[type="button"],.bordered,.DarkBlueBackground,.WikiRule,i').toggleClass('dark-mode');
	$('*').toggleClass('dark-mode');
	$('#NightMode i').toggleClass('fa-moon-o fa-sun-o');
	
	
		

	
	
 }


function checkModefromCookie(){
	if(getCookie('mode')=='night'){
		$('*').toggleClass('dark-mode');
		$('#NightMode i').toggleClass('fa-moon-o fa-sun-o');

	}
	
}





/*MAIN */
var aantalrecords=[];
var img;
var eerdermenu;
var taal;
var menu;
var currentTopic;
var user;
var UID = 0;
var toon = "false";
var slideIndex = 1;
var ip;
var session;
var CONTENTID;
var zoekterm;
var translations = [];

function convertDate(original) {
	var rawdate = new Date(original);
	var month = rawdate.toLocaleString('default', {
		month: 'long'
	});
	var day = rawdate.getDate();
	var year = rawdate.getUTCFullYear();
	var newdate = day + " " + month + " " + year;
	return newdate;
}

function getYear(original) {
	var rawdate = new Date(original);
	var year = rawdate.getUTCFullYear();
	return year;
}

function setLangstrings(langstring) {
	$.get("/Locale/" + langstring + "/" + langstring + ".json", function (translation) {
		translations.push(translation);
		filltext(); //fill these in first to verift function runs ok
		renderpage(getCookie("lang"), menu);

	});

	
}


function filltext() {
	$('.mededeling').html(translations[0].Announcement);
	$('.Disclaimer').html(translations[0].Disclaimer);


}


function ip_callback() {
	$.get("/php/getIp.php", function (data) {
		return data;
	});
}

function checkmenu(menu) {
	if (menu == "API") {
		event.preventDefault();
		window.location.href = "https://www.doctorwhofans.be/API/index.html";
		return;
	}
	gegevens = {};
	gegevens.menu = menu;
	gegevens.ip = ip_callback();
	gegevens.session = getCookie("PHPSESSID");
	if (getCookie("PHPSESSID").length > 0) {
		gegevens.session = getCookie("PHPSESSID");
	} else {
		gegevens.session = "Unknown device, PWA activated";
	}
	if (menu.startsWith('Category:') === true) {
		var prefix = "Category:";
		tag = menu.substr(prefix.length, menu.length);
		$('.path').remove();
		$('.col-6').append("<h1>" + translations[0].Category + ": " + tag.replace('_',' ')+ "</h1>");
		$(".under").append("<div class='topics'></div>");
		$.ajax({
			type: "GET",
			url: "/php/getPagesbyTag.php?tag=" + tag,
			dataType: 'json',
			cache: false
		}).done(function (resultaat) {
			for (var i = 0; i < resultaat.data.length; i++) {
				//$('.under').append("<a href='../"+resultaat.data[i].link+"/'>"+resultaat.data[i].topic+"</a>")
				$(".topics").append("<div class='OverzichtItem'><a href='../" + resultaat.data[i].link + "/'  ><h2>" + resultaat.data[i].topic + "</h2></a></div>");

			}

		}).fail(function (response, statusText, xhr) {}).always(function () {});

	} else {
		$.ajax({
			type: "POST",
			url: "/php/checkmenu.php",
			dataType: 'json',
			cache: false,
			data: gegevens
		}).done(
			function (resultaat) {
				if (resultaat !== true) {
					window.location.href = "https://www.doctorwhofans.be/notfound.html";
				} else {
					var interval = setInterval(function () {
						$.ajax({
							type: "GET",
							url: "/php/alles.php?taal=" + getCookie("lang") + "&menu=" + menu,
							dataType: 'json',
							cache: false
						}).done(function (resultaat) {
							if (JSON.stringify(aantalrecords) == JSON.stringify(resultaat.data)) {} else {
								if (confirm("Wilt u de nieuwe content ophalen?")) {
									window.location.reload();
								} else {
									clearInterval(interval);
								}
							}
						}).fail(function (response, statusText, xhr) {}).always(function () {});
					}, 10000);
				}
			}).fail(function (response, statusText, xhr) {}).always(function () {});
	}

}

function ZoekPagina() {
	event.preventDefault();
	$("#resultcontent").remove();
	$("#resultquotes").remove();
	$("#resultvideo").remove();
	if (($("#zoekterm").val().indexOf('=') !== -1) || ($("#zoekterm").val().indexOf('<') !== -1) || ($("#zoekterm").val().indexOf('>') !== -1) || ($("#zoekterm").val().indexOf('</') !== -1)) {
		alert("Error, invalid search parameter, please do not use '" + $("#zoekterm").val() + "'.");
	} else {
		zoeken(getCookie("lang"), menu, id, $("#zoekterm").val());
		jQuery("html, body").animate({
			scrollTop: 0
		}, 500);
		var e = window.innerHeight || document.documentElement.clientHeight || document.body.clientHeight;
		document.getElementById("overlay_background").style.height = e;
		jQuery("#overlay_background, #overlay_Zoeken").fadeIn(500);

		return false;

	}
}

function zoeken(taal, menu, zoekterm, ip, UID) {
	zoekterm = $("#zoekterm").val();
	$("#overlay_background").height($("body").height())
	$.ajax({
		type: "GET",
		url: "/php/zoeken.php?taal=" + taal + "&menu=" + menu + "&zoekterm=" + zoekterm,
		dataType: 'json',
		cache: false
	}).done(
		function (resultaat) {
			$("#resultset1").append("<div class ='result slide' id='resultcontent'></div>");
			$("#resultcontent").hide();
			var i;
			for (i = 0; i < resultaat.data.length; i += 1) {
				if (resultaat.data[i].link.indexOf("Forum") >= 0) {
					$("#overlay_Zoeken").append("<a href='" + resultaat.data[i].link + "'  ><h3>" + resultaat.data[i].topic + " (Forum)</h3></a>");
				} else {
					$("#overlay_Zoeken").append("<a href='" + resultaat.data[i].link + "'  ><h3>" + resultaat.data[i].topic + "</h3></a>");
				}
			}
		}).fail(function (response, statusText, xhr) {}).always(function () {});
}

function getpad(menu) {
	$.ajax({
		type: "GET",
		url: "/php/pad.php?menu=" + menu,
		dataType: 'json',
		crossDomain: true,
		cache: false
	}).done(
		function (resultaat) {
			$(".path").prepend("<span>" + resultaat.data[0].pad + "</span>");
			$(".path a").addClass("link");
			if (menu === "Video" || resultaat.data[0].pad.search("Video") > 0) {
				videosophalen(menu,ItemId);
				
			}
			if (menu === "Quotes" || resultaat.data[0].pad.search("Quotes") > 0) {
				quotesophalen(menu, ItemId);
				if(getCookie('mode')=='night'){
					$('*').addClass('dark-mode')
				}
			}
		}).fail(function (response, statusText, xhr) {}).always(function () {});
}

function random() {
	$.ajax({
		type: "GET",
		url: "/php/random.php",
		dataType: 'json',
		crossDomain: true,
		cache: false,
	}).done(
		function (resultaat) {
			for (i = 0; i < resultaat.data.length; i += 1) {
				$("#links").append("<a href='../" + resultaat.data[i].link + "/' >" + resultaat.data[i].topic + "</a></br>");
			}
		}).fail(function (response, statusText, xhr) {}).always(function () {});
}
function getchildren(menu) {
	$.ajax({
		type: "GET",
		url: "/php/children.php?menu=" + menu,
		dataType: 'json',
		crossDomain: true,
		cache: false
	}).done(
		function (resultaat) {
			var i;
			for (i = 0; i < resultaat.data.length; i += 1) {
				if (resultaat.data[i].direct_children > 0) {
					$(".topics").append("<div class='OverzichtItem'><a href='../" + resultaat.data[i].link + "/'  ><h3>" + resultaat.data[i].topic + "</h3> <span>(Pages: " + resultaat.data[i].direct_children + ")</span></a></div>");
				} else {
					$(".topics").append("<div class='OverzichtItem'><a href='../" + resultaat.data[i].link + "/'  ><h3>" + resultaat.data[i].topic + "</h3></a></div>");
				}
			}
		}).fail(function (response, statusText, xhr) {}).always(function () {});
}


function videosophalen(menu, id) {
	$.ajax({
		type: "GET",
		url: "/php/videosophalen.php?menu=" + menu + "&id=" + id,
		dataType: 'json',
		cache: false
	}).done(function (resultaat) {
		$('.main_vid,.vid_choice').fadeOut(300).remove();
		$('#loading_div').fadeIn(300);
		$(".col-6").append("<div class='main_vid bordered DarkBlueBackground' style='display:none'></div>");
		$(".col-6").append("<div class='vid_choice' style='display:none'></div>");
		if (resultaat.data.some(e => e.id === Number(id))==false) {
			id = Math.floor((Math.random() * resultaat.data.length) + 1);
		}
		for (i = 0; i < resultaat.data.length; i++) {
			if (Number(id) === resultaat.data[i].id) {
				if (resultaat.data[i].Video_Type === "Youtube") {
					$(".main_vid").append("<h2>" + resultaat.data[i].Video_Name + "</h2>");
					$(".main_vid").append("<iframe width='853' height='480' src='" + resultaat.data[i].Video_URL + "' frameborder='0' allowfullscreen></iframe>");
				} else {
					$(".main_vid").append("<h2>" + resultaat.data[i].Video_Name + "</h2>");
					$(".main_vid").append("<video width='480' controls controlsList='nodownload'><source src='../" + resultaat.data[i].Video_URL + "' type='video/mp4'></video>");
				}
			} else {
				if (resultaat.data[i].SPOILER === 1) {
					$(".vid_choice").append("<a href='../Video/" + resultaat.data[i].id + "' title='" + resultaat.data[i].Video_Name + " class='inline_vid bordered DarkBlueBackground spoilervid' ><div><img data-src='../" + resultaat.data[i].Video_Image + "' class='lazyload' alt='" + resultaat.data[i].Video_Name + "'><p title='" + resultaat.data[i].Video_Name + "'>" + resultaat.data[i].Video_Name.substr(0, 13) + "...</p></div></a>");
				} else {
					$(".vid_choice").append("<a href='../Video/" + resultaat.data[i].id + "' title='" + resultaat.data[i].Video_Name + "' class='inline_vid bordered DarkBlueBackground' ><div><img data-src='../" + resultaat.data[i].Video_Image + "' class='lazyload' style='display:inline;' alt='" + resultaat.data[i].Video_Name + "'><p title='" + resultaat.data[i].Video_Name + "'>" + resultaat.data[i].Video_Name.substr(0, 13) + "...</p></div></a>");
				}
			}
		}
		$('#loading_div').fadeOut(300);
		$('.main_vid,.vid_choice').fadeIn(300);

	}).fail(function (response, statusText, xhr) {}).always(function () {
		if(getCookie('mode')=='night'){
					$('*').addClass('dark-mode')
				}
	});
}

function quotesophalen(menu, id) {
	$.ajax({
		type: "GET",
		url: "/php/quotesophalen.php?menu=" + menu + "&id=" + id,
		dataType: 'json',
		cache: false
	}).done(function (resultaat) {
		$('#MainQuote').fadeOut(300).remove();
		$('.selectie').fadeOut(300).remove();
		$('#loading_div').fadeIn(300);
		$(".col-6").append("<div class='main_quote bordered DarkBlueBackground' id='MainQuote' style='display:none'></div>");
		$(".col-6").append("<div class='selectie' style='display:none'></div>");
		$(".selectie").append("<div class='linkerquote'></div>");
		$(".selectie").append("<div class='rechterquote'></div>");
		if (resultaat.data.some(e => e.id === Number(id))==false) {
			id = Math.floor((Math.random() * resultaat.data.length) + 1);
		}
		for (i = 0; i < resultaat.data.length; i++) {
			if (Number(id) === resultaat.data[i].id) {
				$(".main_quote").append("<img class='quote_picture lazyload padded' data-src='../images/Quotes/" + resultaat.data[i].QuotePic + "'/><h1>" + resultaat.data[i].Aflevering + "</h1>");
				$(".main_quote").append("<div><p class='quotetext'>" + resultaat.data[i].Quote + "</p><p>" + resultaat.data[i].Personage + "</p><div>");
			} else {
				var quote = resultaat.data[i].Quote.substring(0, 60).replace(/<(.|\n)*?>/g, '');
				if (i % 2 === 0) {
					$(".linkerquote").append("<a href='../Quotes/" + resultaat.data[i].id + "'>" + quote + "</a>");
				} else {
					$(".rechterquote").append("<a href='../Quotes/" + resultaat.data[i].id + "'>" + quote + "</a>");
				}
			}
		}
		$('#MainQuote').fadeIn(300);
		$('.selectie').fadeIn(300);
		$('#loading_div').fadeOut(300);

	}).fail(function (response, statusText, xhr) {}).always(function () {});
}

function GetNews() {
	$.ajax({
		type: "GET",
		url: "/php/GetNews.php",
		dataType: 'json',
		cache: false
	}).done(function (resultaat) {
		$(".col-6").append("<div class='news' style=''></div>");
		for (i = 0; i < resultaat.data.length; i++) {
			$(".news").append("<div class='newsitem' id='" + resultaat.data[i].id + "'></div>");
			$("#" + resultaat.data[i].id).append("<h2>" + resultaat.data[i].Titel + "</h2>");
			$("#" + resultaat.data[i].id).append("<h3>" + resultaat.data[i].Datum + "</h3>");
			$("#" + resultaat.data[i].id).append("<img data-src='" + resultaat.data[i].Foto + "' alt='" + resultaat.data[i].alt + "' class='" + resultaat.data[i].Class + " lazyload'/><span class='" + resultaat.data[i].Class_Text + "'>" + resultaat.data[i].Bericht + "</span>");
		}

	}).fail(function (response, statusText, xhr) {}).always(function () {});

}

function GetQuotesByCharacter(Character) {
	Character = Character.trim();
	$.ajax({
		type: "GET",
		url: "/php/quotesophalenbyCharacter.php?Character=" + Character,
		dataType: 'json',
		cache: false
	}).done(function (resultaat) {
		if (resultaat.data.length === 0) {
			$("#Quotes").append("<p>" + translations[0].NoQuotesForChar + "</p>");
		} else {
			for (i = 0; i < resultaat.data.length; i++) {
				$("#Quotes").append("<div class='quoteitem bordered DarkBlueBackground " + resultaat.data[i].Class + "'><div class='quoteQuote'><p><img src='../images/Quotes/" + resultaat.data[i].QuotePic + "' alt='" + resultaat.data[i].Aflevering + "'/>" + resultaat.data[i].Quote + "</p></img><div class='quoteEpisode'><p><b>" + resultaat.data[i].Aflevering + "</b></p></div></div>");
			}
		}
	}).fail(function (response, statusText, xhr) {
		$("#Quotes").append("<p>" + translations[0].NoQuotesForChar + "</p>");
	}).always(function () {
		if(getCookie('mode')=='night'){
			$('*').addClass('dark-mode')
		}
	});
}

function GetQuotesByEpisode(Episode) {
	Episode = Episode.trim();
	$.ajax({
		type: "GET",
		url: "/php/quotesophalenbyEpisode.php?Episode=" + Episode,
		dataType: 'json',
		cache: false
	}).done(function (resultaat) {
		if (resultaat.data.length === 0) {
			$("#Quotes").append("<p>" + translations[0].NoQuotesForEpisode + "</p>");
		} else {
			for (i = 0; i < resultaat.data.length; i++) {
				$("#Quotes").append("<div class='quoteitem bordered DarkBlueBackground " + resultaat.data[i].Class + "'><div class='quoteQuote'><p><img src='../images/Quotes/" + resultaat.data[i].QuotePic + "' alt='" + resultaat.data[i].Aflevering + "'/>" + resultaat.data[i].Quote + "</p></img><div class='quoteEpisode'><p><b>" + resultaat.data[i].Personage + "</b></p></div></div>");
			}
		}
	}).fail(function (response, statusText, xhr) {
		$("#Quotes").append("<p>" + translations[0].NoQuotesForEpisode + "</p>");
	}).always(function () {
		if(getCookie('mode')=='night'){
			$('*').addClass('dark-mode')
		}
	});
}

function GetDownloadsByEpisode(Episode) {
	Episode = Episode.trim();
	$.ajax({
		type: "GET",
		url: "/php/downloadsophalenbyEpisode.php?Episode=" + Episode,
		dataType: 'json',
		cache: false
	}).done(function (resultaat) {
		if (resultaat.data.length === 0) {
			$("#Downloads").append("<p>" + translations[0].NoDownloadsForEpisode + "</p>");
		} else {
			for (i = 0; i < resultaat.data.length; i++) {
				$("#Downloads").append("<p>" + resultaat.data[i].download_Type + ": <a href='" + resultaat.data[i].download_link + "' target='_blank'>" + resultaat.data[i].download_Naam + "</a> (" + resultaat.data[i].download_Taal + ") <a href='" + resultaat.data[i].download_link + "' download>Direct Download</a></p>");
			}
		}
	}).fail(function (response, statusText, xhr) {
		$("#Downloads").append("<p>" + translations[0].NoDownloadsForEpisode + "</p>");
	}).always(function () {});
}

function makeid(length) {
	var result           = '';
	var characters       = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
	var charactersLength = characters.length;
	for ( var i = 0; i < length; i++ ) {
	   result += characters.charAt(Math.floor(Math.random() * charactersLength));
	}
	return result;
 }
function secondsToDhms(seconds) {

	seconds = Number(seconds);
  
	var d = Math.floor(seconds / (3600 * 24));
  
	var h = Math.floor((seconds % (3600 * 24)) / 3600);
  
	var m = Math.floor((seconds % 3600) / 60);
  
	var s = Math.floor(seconds % 60);
  
  
  
	var dDisplay = d > 0 ? d + (d == 1 ? " day, " : " days, ") : "";
  
	var hDisplay = h > 0 ? h + (h == 1 ? " hour, " : " hours, ") : "";
  
	var mDisplay = m > 0 ? m + (m == 1 ? " minute, " : " minutes, ") : "";
  
	var sDisplay = s > 0 ? s + (s == 1 ? " second" : " seconds") : "";
  
	return dDisplay + hDisplay + mDisplay + sDisplay;
  
  }
function GetSecondsforEpisodes(dataurl){
	$.ajax({
		type: "GET",
		url: dataurl,
		dataType: 'json',
		cache: false
	}).done(function (resultaat) {
		var identifier = makeid(8);
		$(".col-6").append("<div id='"+identifier+"'></div>");

		for(var i=0;i<resultaat.data.length;i++){
			$("#"+identifier).append("<div class='TimeDiv padded max_20 DarkBlueBackground bordered'><span><b>"+resultaat.data[i].titel+":</b></span><br><p>"+secondsToDhms(resultaat.data[i].total).replace(/,\s*$/, "")+"</p></div>");
			
		}

	}).fail(function(response, statusText, xhr) {

                    }).always(function() {

                    });
}
function GetOneRandomQuote() {
	$.ajax({
		type: "GET",
		url: "/php/GetOneRandomQuote.php",
		dataType: 'json',
		cache: false
	}).done(function (resultaat) {
		$('.quote').append("<p>" + resultaat.data[0].Quote + " ...</p>");
		$('.quote').append("<a href='../Quotes/"+resultaat.data[0].id+"'>" + translations[0].ReadMore + "</a>");
		$('.quote').append("<p>" + resultaat.data[0].Personage + " - " + resultaat.data[0].Aflevering + "</p>");
	}).fail(function (response, statusText, xhr) {}).always(function () {});
}

function contentophalen(taal, menu) {
	$.ajax({
		type: "GET",
		url: "/php/alles.php?taal=" + taal + "&menu=" + menu,
		dataType: 'json',
		cache: false
	}).done(function (resultaat) {
		aantalrecords = resultaat.data;
		var i;

		for (i = 0; i < resultaat.data.length; i += 1) {
			if (resultaat.data[i].A_Pagina_Type === "Slider") {
				$(".col-6").append("<div class='slideshow-container'><a class='prev' onclick='plusSlides(-1)'>&#10094;</a><a class='next' onclick='plusSlides(1)'>&#10095;</a></div>");
			}
			if (resultaat.data[i].A_Pagina_Type === "WikiPagina") {
				$(".col-6").append("<div id='WikiDetails' class='bordered DarkBlueBackground'></div>");
				$(".under").append("<div id='Voetnoot'><h2>" + translations[0].Footnotes + "</h2><ol></ol></div>");
				$("#WikiDetails").append("<div id='Items'></div>");
			}
			if (resultaat.data[i].A_Type === "Titel" || resultaat.data[i].A_Type === "EpisodeTitel" || resultaat.data[i].A_Type === "CharacterTitel") {
				$(".col-6").prepend("<h1>" + resultaat.data[i].A_Waarde + "</h1>");
				if (resultaat.data[i].A_Type === "EpisodeTitel") {
					$(".under").prepend("<div id='Under_Upper'>");
					$("#Under_Upper").append("<div id='Quotes' class='anchor'></div>");
					$("#Under_Upper").append("<div id='Downloads' class='anchor'><h2>" + translations[0].Downloads + "</h2></div>");
					$("#Quotes").append("<h2>" + translations[0].Quotes + "</h2>");
					var Episode = resultaat.data[i].A_Pagina;
					GetQuotesByEpisode(Episode);
					GetDownloadsByEpisode(Episode);

				}
				if (resultaat.data[i].A_Type === "CharacterTitel") {
					$(".under").prepend("<div id='Under_Upper'>");
					$("#Under_Upper").append("<div id='Quotes'></div>");
					$("#Quotes").append("<h2>" + translations[0].Quotes + "</h2>");
					var Character = resultaat.data[i].A_Waarde;
					GetQuotesByCharacter(menu.split('_').join(' '));
				}
			}
			if(resultaat.data[i].A_Pagina_Type=="Call"){
				if(resultaat.data[i].A_Type=="GetSecondsforEpisodes"){
					GetSecondsforEpisodes(resultaat.data[i].A_Waarde);
				}

			}
			if (resultaat.data[i].A_Type === "EpisodeStatus") {
				$("#Items").prepend("<div class='WikiItemTitel " + resultaat.data[i].A_Klasse + "'>" + translations[0].Status + ": " + resultaat.data[i].A_Waarde + "</div>");
			}
			if (resultaat.data[i].A_Type === "EpisodeDoctorList") {
				$("#Items").append("<div class=WikiItemTitel>" + translations[0].Cast + "</div>");
				$("#Items").append("<div class=WikiRule>" + translations[0].Doctor + ": <span>" + resultaat.data[i].A_Waarde + "</span></div>");
			}
			if (resultaat.data[i].A_Type === "EpisodeMainSetting") {
				$("#Items").append("<div class=WikiItemTitel>" + translations[0].Story + "</div>");
				$("#Items").append("<div class=WikiRule>" + translations[0].main_setting + ": <span>" + resultaat.data[i].A_Waarde + "</span></div>");
			}
			if (resultaat.data[i].A_Type === "EpisodeMainEnemy") {
				$("#Items").append("<div class=WikiRule>" + translations[0].main_enemy + ": <span>" + resultaat.data[i].A_Waarde + "</span></div>");
			}
			if (resultaat.data[i].A_Type === "EpisodeCompanionList") {
				$("#Items").append("<div class=WikiRule>" + translations[0].Companions + ": <span>" + resultaat.data[i].A_Waarde + "</span></div>");
			}
			if (resultaat.data[i].A_Type === "EpisodeOtherList") {
				$("#Items").append("<div class=WikiRule>" + translations[0].Others + ": <span>" + resultaat.data[i].A_Waarde + "</span></div>");
			}
			if (resultaat.data[i].A_Type === "EpisodeDirectorList") {
				$("#Items").append("<div class=WikiItemTitel>" + translations[0].Production + "</div>");
				$("#Items").append("<div class=WikiRule>" + translations[0].directed_by + ": <span>" + resultaat.data[i].A_Waarde + "</span></div>");

			}
			if (resultaat.data[i].A_Type === "EpisodePrevious") {
				$("#Items").append("<div class='WikiItemTitel'>" + translations[0].Chronology + "</div>");
				$("#Items").append("<div class='Chronologie'></div>");
				$(".Chronologie").append("<div class='Half'>" + translations[0].previous_episode + ":<br>" + resultaat.data[i].A_Waarde + "</div>");}
			if (resultaat.data[i].A_Type === "EpisodeNext") {$(".Chronologie").append("<div class='Half Rechts'>" + translations[0].next_episode + ":<br>" + resultaat.data[i].A_Waarde + "</div>");}
			if (resultaat.data[i].A_Type === "EpisodePreviousIssue") {
				$("#Items").append("<div class='WikiItemTitel'>" + translations[0].Chronology + "</div>");
				$("#Items").append("<div class='Chronologie'></div>");
				$(".Chronologie").append("<div class='Half'>" + translations[0].previous_issue + ":<br>" + resultaat.data[i].A_Waarde + "</div>");}
			if (resultaat.data[i].A_Type === "EpisodeNextIssue") {$(".Chronologie").append("<div class='Half Rechts'>" + translations[0].next_issue + ":<br>" + resultaat.data[i].A_Waarde + "</div>");}
			if (resultaat.data[i].A_Type === "EpisodeWriterList") {$("#Items").append("<div class=WikiRule>" + translations[0].written_by + ": <span>" + resultaat.data[i].A_Waarde + "</span></div>");}
			if (resultaat.data[i].A_Type === "EpisodeEditorList") {$("#Items").append("<div class=WikiRule>" + translations[0].script_editor + ": <span>" + resultaat.data[i].A_Waarde + "</span></div>");}
			if (resultaat.data[i].A_Type === "EpisodeProducerList") {$("#Items").append("<div class=WikiRule>" + translations[0].produced_by + ": <span>" + resultaat.data[i].A_Waarde + "</span></div>");}
			if (resultaat.data[i].A_Type === "EpisodeExecutiveProducerList") {$("#Items").append("<div class=WikiRule>" + translations[0].ExecutiveProducer + ": <span>" + resultaat.data[i].A_Waarde + "</span></div>");}
			if (resultaat.data[i].A_Type === "EpisodeComposer") {$("#Items").append("<div class=WikiRule>" + translations[0].incidental_composer + ": <span>" + resultaat.data[i].A_Waarde + "</span></div>");}
			if (resultaat.data[i].A_Type === "EpisodeProductionCode") {if (resultaat.data[i].A_Waarde.includes('.')===true){$("#Items").append("<div class=WikiRule>" + translations[0].production_code + ": <span>" + Number(resultaat.data[i].A_Waarde).toFixed(2) + "</span></div>");}else{$("#Items").append("<div class=WikiRule>" + translations[0].production_code + ": <span>" + resultaat.data[i].A_Waarde + "</span></div>");}}
			if (resultaat.data[i].A_Type === "EpisodeSeries") {$("#Items").append("<div class=WikiRule>" + translations[0].Series + ": <span>" + resultaat.data[i].A_Waarde + "</span></div>");}
			if (resultaat.data[i].A_Type === "EpisodeLength") {$("#Items").append("<div class=WikiRule>" + translations[0].Length + ": <span>" + resultaat.data[i].A_Waarde + "</span></div>");}
			if (resultaat.data[i].A_Type === "EpisodeDateStarted") {$("#Items").append("<div class=WikiRule>" + translations[0].Startdate + ": <span>" + convertDate(resultaat.data[i].A_Waarde) + "</span></div>");}
			if (resultaat.data[i].A_Type === "EpisodeDateEnded") {$("#Items").append("<div class=WikiRule>" + translations[0].Enddate + ": <span>" + convertDate(resultaat.data[i].A_Waarde) + "</span></div>");}
			if (resultaat.data[i].A_Type === "EpisodeAirDate") {$("#Items").append("<div class=WikiRule>" + translations[0].AirDate + ": <span>" + convertDate(resultaat.data[i].A_Waarde) + "</span></div>");}
			if (resultaat.data[i].A_Type === "WikiLooseItem") {$("#Items").append("<div class=WikiRule>" + resultaat.data[i].A_Waarde + "</div>");}
			if (resultaat.data[i].A_Type === "WikiHeadingBar") {$("#Items").append("<div class=WikiItemTitel>" + resultaat.data[i].A_Waarde + "</div>");}
			if (resultaat.data[i].A_Type === "Inleiding") {$(".col-6").append("<div class='" + resultaat.data[i].A_Klasse + "'>" + resultaat.data[i].A_Waarde + "</div>");$(".col-6").append("<div id='Inhoud' class='bordered DarkBlueBackground'>" + translations[0].TOC + "<ol></ol></div>");}
			if (resultaat.data[i].A_Type === "Tekst") {$(".col-6").append("<div class='" + resultaat.data[i].A_Klasse + "'>" + resultaat.data[i].A_Waarde + "</div>");}
			if (resultaat.data[i].A_Type === "Code") {var code = resultaat.data[i].A_Waarde;}
			if (resultaat.data[i].A_Type === "GetEpisodesofToday") {
				$('.col-6').append("<div id='EpisodesOfToday' class='bordered DarkBlueBackground "+resultaat.data[i].A_Klasse +"'><h2>Episodes of the Day</h2><ol></ol></div>");
				GetEpisodesofToday();}
			if (resultaat.data[i].A_Type === "VoetnootItem") {$("#Voetnoot ol").append("<li class='" + resultaat.data[i].A_Klasse + "'>" + resultaat.data[i].A_Waarde + "</li>");}
			if (resultaat.data[i].A_Type === "Voetnoot") {$("#Voetnoot ol").append(resultaat.data[i].A_Waarde);}
			if (resultaat.data[i].A_Type === "Kop2") {$(".col-6").append("<h2 class='" + resultaat.data[i].A_Klasse + " anchor' id='" + resultaat.data[i].A_ID + "'>" + resultaat.data[i].A_Waarde + "</h2>");}
			if (resultaat.data[i].A_Type === "Kop3") {$(".col-6").append("<h3 class='" + resultaat.data[i].A_Klasse + "' id='" + resultaat.data[i].A_ID + "'>" + resultaat.data[i].A_Waarde + "</h3>");}
			if (resultaat.data[i].A_Type === "Kop4") {$(".col-6").append("<h4 class='" + resultaat.data[i].A_Klasse + "' id='" + resultaat.data[i].A_ID + "'>" + resultaat.data[i].A_Waarde + "</h4>");}
			if (resultaat.data[i].A_Type === "Kop5") {$(".col-6").append("<h5 class='" + resultaat.data[i].A_Klasse + "' id='" + resultaat.data[i].A_ID + "'>" + resultaat.data[i].A_Waarde + "</h5>");}
			if (resultaat.data[i].A_Type === "Kop6") {$(".col-6").append("<h6 class='" + resultaat.data[i].A_Klasse + "' id='" + resultaat.data[i].A_ID + "'>" + resultaat.data[i].A_Waarde + "</h6>");}
			if (resultaat.data[i].A_Type === "Lijst") {$(".col-6").append("<ul class='" + resultaat.data[i].A_Klasse + "' id='" + resultaat.data[i].A_ID + "'>" + resultaat.data[i].A_Waarde + "</ul>");}
			if (resultaat.data[i].A_Pagina_Type === "Overzicht") {$(".under").append("<div class='topics'></div>");getchildren(menu);}
			if (resultaat.data[i].A_Type === "Afbeelding") {
				if (resultaat.data[i].A_Pagina_Type === "Wiki") {
					for (var j = 0; j < resultaat.data.length; j += 1) {
						if (resultaat.data[j].A_Hoort_Bij === resultaat.data[i].A_ID && (resultaat.data[j].A_Type === "Bijschrift" || resultaat.data[j].A_Type === "Alt")) {
							if(resultaat.data[j].A_Type === "Bijschrift"){
								$("#WikiDetails").prepend("<div><img data-src='" + resultaat.data[i].A_Waarde + "' class='Wiki_Foto " + resultaat.data[i].A_Klasse + " lazyload' title='" + resultaat.data[j].A_Waarde + "' alt='" + resultaat.data[j].A_Waarde + "'><span>" + resultaat.data[j].A_Waarde + "</span></div>");
							}else{
								$("#WikiDetails").prepend("<div><img data-src='" + resultaat.data[i].A_Waarde + "' class='Wiki_Foto " + resultaat.data[i].A_Klasse + " lazyload' title='" + resultaat.data[j].A_Waarde + "' alt='" + resultaat.data[j].A_Waarde + "'></div>");
							}
						}
					}
				} else if (resultaat.data[i].A_Pagina_Type === "Slide") {
					for (var l = 0; l < resultaat.data.length; l += 1) {
						if (resultaat.data[l].A_Hoort_Bij === resultaat.data[i].A_ID && (resultaat.data[l].A_Type === "Alt" || resultaat.data[l].A_Type === "Bijschrift")) {
							$(".slideshow-container").append("<div class='mySlides'><img src='" + resultaat.data[i].A_Waarde + "' alt='" + resultaat.data[l].A_Waarde + "' title='" + resultaat.data[l].A_Waarde + "'style='width:80%;padding-left:6em;'><div class='text'>" + resultaat.data[l].A_Waarde + "</div></div>");
						}
					}
					setTimeout(function () {
						showSlides(this.slideIndex);
					}, 1000);
				} else {
					for (var m = 0; m < resultaat.data.length; m += 1) {
						if (resultaat.data[m].A_Hoort_Bij === resultaat.data[i].A_ID && (resultaat.data[m].A_Type === "Alt" || resultaat.data[m].A_Type === "Bijschrift")) {
							$(".col-6").append("<div id='" + resultaat.data[i].A_ID + "' class='foto_met_text bordered DarkBlueBackground " + resultaat.data[i].A_Klasse + "'></div>");
							$("#" + resultaat.data[i].A_ID).append("<img data-src='" + resultaat.data[i].A_Waarde + "' alt='" + resultaat.data[m].A_Waarde + " title='" + resultaat.data[m].A_Waarde + "' class='" + resultaat.data[i].A_Klasse + " lazyload'>");
							if(resultaat.data[m].A_Type=== "Bijschrift"){
								$("#" + resultaat.data[i].A_ID).append("<p class='" + resultaat.data[m].A_Klasse + "'>" + resultaat.data[m].A_Waarde + "</p>");

							}
						}
					}
				}
			}
			if (resultaat.data[i].A_Type === "WikiItemPlayedBy") {
				$("#Items").append("<div class='WikiRule'>" + translations[0].played_by + ": <span>" + resultaat.data[i].A_Waarde + "</span></div>");
			}
			if (resultaat.data[i].A_Type === "AantalSeizoenen") {
				$("#Items").append("<div class='WikiRule'>" + translations[0].nr_seasons + ": <span>" + resultaat.data[i].A_Waarde + "</span></div>");
			}
			if (resultaat.data[i].A_Type === "Verschijningen") {
				$("#Items").append("<div class='WikiRule'>" + translations[0].nr_appareances + ": <span>" + resultaat.data[i].A_Waarde + "</span></div>");
			}
			if (resultaat.data[i].A_Type === "Periode") {
				var times = resultaat.data[i].A_Waarde.split(' - ');
				for (var time = 0; time < times.length; time++) {
					times[time] = convertDate(times[time]);
				}
				$("#Items").append("<div class='WikiRule'>" + translations[0].tenure + ": <span>" + times.join(" - ") + "</span></div>");
			}
			if (resultaat.data[i].A_Type === "WikiItemFirstEpisode") {
				$("#Items").append("<div class='WikiRule'>" + translations[0].first_episode + ": <span>" + resultaat.data[i].A_Waarde + "</span></div>");
			}
			if (resultaat.data[i].A_Type === "WikiItemLastEpisode") {
				$("#Items").append("<div class='WikiRule'>" + translations[0].last_episode + ": " + resultaat.data[i].A_Waarde + "</div>");
			}
			if (resultaat.data[i].A_Type === "CompanionList") {
				$("#Items").append("<div class='WikiRule'>" + translations[0].Companions + ": " + resultaat.data[i].A_Waarde + "</div>");
			}
			if (resultaat.data[i].A_Type === "SeriesList") {
				$("#Items").append("<div class='WikiRule'>" + translations[0].Series + ": " + resultaat.data[i].A_Waarde + "</div>");
			}
			if (resultaat.data[i].A_Type === "Form") {
				$(".col-6").append(resultaat.data[i].A_Waarde);
			}


		}
		$("#Inhoud ol").toc({
			content: "article",
			headings: "h2,h3,h4,h5,h6"
		});
		$('a[href^="http"]').each(function () {
			var link = $(this).attr("href");
			if (link.indexOf("doctorwhofans.be") === -1 && link.indexOf("https://www.facebook.com/DoctorWhoFansBE/") === -1 && link.indexOf("https://rubendebusscherodisee.github.io/DoctorwhofansBE/") === -1) {
				return $(this).after('<sup><a href="' + link + '" target="_blank" title="open in a new tab"><i class="fa fa-external-link" aria-hidden="true"></i></a></sup>');

		}
		if (resultaat.tags != "No rows") {
			$(".under").append("<aside id='Tags'></aside>");
			var tagstring = "Tags: ";
			for (var i = 0; i < resultaat.tags.length; i++) {
				if (i == resultaat.tags.length - 1) {
					tagstring += "<a href='../Category:" + resultaat.tags[i].cat_name.split(' ').join('_') + "/'>" + resultaat.tags[i].cat_name + "</a>";
				} else {
					tagstring += "<a href='../Category:" + resultaat.tags[i].cat_name.split(' ').join('_') + "/'>" + resultaat.tags[i].cat_name + "</a>, ";
				}
			}
			$('#Tags').html(tagstring);
		}
		//checkModefromCookie()
		
		if (getCookie("size") != "") {
			getSizesfromCookie();
		}
	});
	if(getCookie('mode')=='night'){
		$('*').addClass('dark-mode')
	}
	
}).fail(function (response, statusText, xhr) {}).always(function () {

	});

}


(function ($) {
	'use strict';
	$.fn.fitVids = function (options) {
		var settings = {
			customSelector: null,
			ignore: null
		};
		if (!document.getElementById('fit-vids-style')) {
			var head = document.head || document.getElementsByTagName('head')[0];
			var css = '.fluid-width-video-wrapper{width:100%;position:relative;padding:0;}.fluid-width-video-wrapper iframe,.fluid-width-video-wrapper object,.fluid-width-video-wrapper embed {position:absolute;top:0;left:0;width:100%;height:100%;}';
			var div = document.createElement("div");
			div.innerHTML = '<p>x</p><style id="fit-vids-style">' + css + '</style>';
			head.appendChild(div.childNodes[1]);
		}
		if (options) {
			$.extend(settings, options);
		}
		return this.each(function () {
			var selectors = ['iframe[src*="player.vimeo.com"]', 'iframe[src*="youtube.com"]', 'iframe[src*="youtube-nocookie.com"]', 'iframe[src*="kickstarter.com"][src*="video.html"]', 'object', 'embed'];
			if (settings.customSelector) {
				selectors.push(settings.customSelector);
			}
			var ignoreList = '.fitvidsignore';
			if (settings.ignore) {
				ignoreList = ignoreList + ', ' + settings.ignore;
			}
			var $allVideos = $(this).find(selectors.join(','));
			$allVideos = $allVideos.not('object object');
			$allVideos = $allVideos.not(ignoreList);
			$allVideos.each(function () {
				var $this = $(this);
				if ($this.parents(ignoreList).length > 0) {
					return;
				}
				if (this.tagName.toLowerCase() === 'embed' && $this.parent('object').length || $this.parent('.fluid-width-video-wrapper').length) {
					return;
				}
				if ((!$this.css('height') && !$this.css('width')) && (isNaN($this.attr('height')) || isNaN($this.attr('width')))) {
					$this.attr('height', 9);
					$this.attr('width', 16);
				}
				var height = (this.tagName.toLowerCase() === 'object' || ($this.attr('height') && !isNaN(parseInt($this.attr('height'), 10)))) ? parseInt($this.attr('height'), 10) : $this.height(),
					width = !isNaN(parseInt($this.attr('width'), 10)) ? parseInt($this.attr('width'), 10) : $this.width(),
					aspectRatio = height / width;
				if (!$this.attr('name')) {
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
})(window.jQuery || window.Zepto);
$(function () {
	jQuery(".SitemapButton").click(function () {
		jQuery(this).parent().next().toggle();
		if (jQuery(this).parent().next().attr('display') === 'none' || jQuery(this).text() == "+") {
			jQuery(this).text("-");
		} else if (jQuery(this).parent().next().attr('display') === 'block' || jQuery(this).text() == "-") {
			jQuery(this).text("+");
		}
	});

});

function ToggleMenu() {
	$('nav').slideToggle();
}


function Spoilertonen(content) {
	stopVideos();
	$('#' + content).toggle();
}

function stopVideos() {
	$("iframe").each(function () {
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
	if (n > slides.length) {
		slideIndex = 1;
	}
	for (i = 0; i < slides.length; i++) {
		slides[i].style.display = "none";
	}
	slides[slideIndex - 1].style.display = "block";
}
$(window).scroll(function () {
	if ($(this).scrollTop() > 100) {
		$('#Back_To_Top').fadeIn();
	} else {
		$('#Back_To_Top').fadeOut();
	}
});
function topFunction(position) {
	//0 for top,  $("#element").offset().top; for a specific place         var bottom = $(document).height() - $(window).height();

	//$("html, body").animate({ scrollTop: position }, 'slow'); 
	//return true;
	document.body.scrollTop = position;
	document.documentElement.scrollTop = position;
	$("html, body").scrollTop(position);

}

function GetEpisodesofToday() {

	$.ajax({
		type: "GET",
		url: "/API/EpisodesforToday.php",
		dataType: 'json',
		cache: false
	}).done(function (resultaat) {
		if (resultaat.Seasons.length > 0) {
			for (i = 0; i < resultaat.Seasons.length; i++) {
				$("#EpisodesOfToday ol").append("<li>" + resultaat.Seasons[i].title + ": " + resultaat.Seasons[i].Episode_titel + " (" + getYear(resultaat.Seasons[i].original_air_date) + ")</li>");
			}
		} else {
			$("#EpisodesOfToday").innerHTML("<p>" + translations[0].NoEpisodeOftheDay + "</p>");
		}


	}).fail(function (response, statusText, xhr) {}).always(function () {});
}






/*TOC */
(function ($) {
	"use strict";


	var toc = function (options) {
			return this.each(function () {
				var root = $(this),
					data = root.data(),
					thisOptions,
					stack = [root],
					listTag = this.tagName,
					currentLevel = 0,
					headingSelectors;

				thisOptions = $.extend({
						content: "body",
						headings: "h1,h2,h3"
					}, {
						content: data.toc || undefined,
						headings: data.tocHeadings || undefined
					},
					options
				);
				headingSelectors = thisOptions.headings.split(",");

				$(thisOptions.content).find(thisOptions.headings).attr("id", function (index, attr) {

					var generateUniqueId = function (text) {

						if (text.length === 0) {
							text = "?";
						}

						var baseId = text.replace(/\s+/g, "_"),
							suffix = "",
							count = 1;

						while (document.getElementById(baseId + suffix) !== null) {
							suffix = "_" + count++;
						}

						return baseId + suffix;
					};

					return attr || generateUniqueId($(this).text());
				}).each(function () {
					var elem = $(this),
						level = $.map(headingSelectors, function (selector, index) {
							return elem.is(selector) ? index : undefined;
						})[0];

					if (level > currentLevel) {

						var parentItem = stack[0].children("li:last")[0];
						if (parentItem) {
							stack.unshift($("<" + listTag + "/>").appendTo(parentItem));
						}
					} else {

						stack.splice(0, Math.min(currentLevel - level, Math.max(stack.length - 1, 0)));
					}

					$("<li/>").appendTo(stack[0]).append(
						$("<a/>").text(elem.text()).attr("href", "#" + elem.attr("id"))
					);

					currentLevel = level;
				});
			});
		},
		old = $.fn.toc;

	$.fn.toc = toc;

	$.fn.toc.noConflict = function () {
		$.fn.toc = old;
		return this;
	};

	$(function () {
		toc.call($("[data-toc]"));
	});
}(window.jQuery));






/*LAZYSIZES */
/*! lazysizes - v5.2.0 */
! function (a, b) {
	var c = b(a, a.document, Date);
	a.lazySizes = c, "object" == typeof module && module.exports && (module.exports = c);
}("undefined" != typeof window ? window : {}, function (a, b, c) {
	"use strict";
	var d, e;
	if (function () {
			var b, c = {
				lazyClass: "lazyload",
				loadedClass: "lazyloaded",
				loadingClass: "lazyloading",
				preloadClass: "lazypreload",
				errorClass: "lazyerror",
				autosizesClass: "lazyautosizes",
				srcAttr: "data-src",
				srcsetAttr: "data-srcset",
				sizesAttr: "data-sizes",
				minSize: 40,
				customMedia: {},
				init: !0,
				expFactor: 1.5,
				hFac: 0.8,
				loadMode: 2,
				loadHidden: !0,
				ricTimeout: 0,
				throttleDelay: 125
			};
			e = a.lazySizesConfig || a.lazysizesConfig || {};
			for (b in c) b in e || (e[b] = c[b]);
		}(), !b || !b.getElementsByClassName) return {
		init: function () {},
		cfg: e,
		noSupport: !0
	};
	var f = b.documentElement,
		g = a.HTMLPictureElement,
		h = "addEventListener",
		i = "getAttribute",
		j = a[h].bind(a),
		k = a.setTimeout,
		l = a.requestAnimationFrame || k,
		m = a.requestIdleCallback,
		n = /^picture$/i,
		o = ["load", "error", "lazyincluded", "_lazyloaded"],
		p = {},
		q = Array.prototype.forEach,
		r = function (a, b) {
			return p[b] || (p[b] = new RegExp("(\\s|^)" + b + "(\\s|$)")), p[b].test(a[i]("class") || "") && p[b];
		},
		s = function (a, b) {
			r(a, b) || a.setAttribute("class", (a[i]("class") || "").trim() + " " + b);
		},
		t = function (a, b) {
			var c;
			(c = r(a, b)) && a.setAttribute("class", (a[i]("class") || "").replace(c, " "));
		},
		u = function (a, b, c) {
			var d = c ? h : "removeEventListener";
			c && u(a, b), o.forEach(function (c) {
				a[d](c, b);
			});
		},
		v = function (a, c, e, f, g) {
			var h = b.createEvent("Event");
			return e || (e = {}), e.instance = d, h.initEvent(c, !f, !g), h.detail = e, a.dispatchEvent(h), h;
		},
		w = function (b, c) {
			var d;
			!g && (d = a.picturefill || e.pf) ? (c && c.src && !b[i]("srcset") && b.setAttribute("srcset", c.src), d({
				reevaluate: !0,
				elements: [b]
			})) : c && c.src && (b.src = c.src);
		},
		x = function (a, b) {
			return (getComputedStyle(a, null) || {})[b];
		},
		y = function (a, b, c) {
			for (c = c || a.offsetWidth; c < e.minSize && b && !a._lazysizesWidth;) c = b.offsetWidth, b = b.parentNode;
			return c;
		},
		z = function () {
			var a, c, d = [],
				e = [],
				f = d,
				g = function () {
					var b = f;
					for (f = d.length ? e : d, a = !0, c = !1; b.length;) b.shift()();
					a = !1;
				},
				h = function (d, e) {
					a && !e ? d.apply(this, arguments) : (f.push(d), c || (c = !0, (b.hidden ? k : l)(g)));
				};
			return h._lsFlush = g, h;
		}(),
		A = function (a, b) {
			return b ? function () {
				z(a);
			} : function () {
				var b = this,
					c = arguments;
				z(function () {
					a.apply(b, c);
				});
			};
		},
		B = function (a) {
			var b, d = 0,
				f = e.throttleDelay,
				g = e.ricTimeout,
				h = function () {
					b = !1, d = c.now(), a();
				},
				i = m && g > 49 ? function () {
					m(h, {
						timeout: g
					}), g !== e.ricTimeout && (g = e.ricTimeout);
				} : A(function () {
					k(h);
				}, !0);
			return function (a) {
				var e;
				(a != 0 === a) && (g = 33), b || (b = !0, e = f - (c.now() - d), e < 0 && (e = 0), a || e < 9 ? i() : k(i, e));
			};
		},
		C = function (a) {
			var b, d, e = 99,
				f = function () {
					b = null, a();
				},
				g = function () {
					var a = c.now() - d;
					a < e ? k(g, e - a) : (m || f)(f);
				};
			return function () {
				d = c.now(), b || (b = k(g, e));
			};
		},
		D = function () {
			var g, m, o, p, y, D, F, G, H, I, J, K, L = /^img$/i,
				M = /^iframe$/i,
				N = "onscroll" in a && !/(gle|ing)bot/.test(navigator.userAgent),
				O = 0,
				P = 0,
				Q = 0,
				R = -1,
				S = function (a) {
					Q--, (!a || Q < 0 || !a.target) && (Q = 0);
				},
				T = function (a) {
					return null == K && (K = "hidden" == x(b.body, "visibility")), K || !("hidden" == x(a.parentNode, "visibility") && "hidden" == x(a, "visibility"));
				},
				U = function (a, c) {
					var d, e = a,
						g = T(a);
					for (G -= c, J += c, H -= c, I += c; g && (e = e.offsetParent) && e != b.body && e != f;)(g = (x(e, "opacity") || 1) > 0) && "visible" != x(e, "overflow") && (d = e.getBoundingClientRect(), g = I > d.left && H < d.right && J > d.top - 1 && G < d.bottom + 1);
					return g;
				},
				V = function () {
					var a, c, h, j, k, l, n, o, q, r, s, t, u = d.elements;
					if ((p = e.loadMode) && Q < 8 && (a = u.length)) {
						for (c = 0, R++; c < a; c++)
							if (u[c] && !u[c]._lazyRace)
								if (!N || d.prematureUnveil && d.prematureUnveil(u[c])) ba(u[c]);
								else if ((o = u[c][i]("data-expand")) && (l = 1 * o) || (l = P), r || (r = !e.expand || e.expand < 1 ? f.clientHeight > 500 && f.clientWidth > 500 ? 500 : 370 : e.expand, d._defEx = r, s = r * e.expFactor, t = e.hFac, K = null, P < s && Q < 1 && R > 2 && p > 2 && !b.hidden ? (P = s, R = 0) : P = p > 1 && R > 1 && Q < 6 ? r : O), q !== l && (D = innerWidth + l * t, F = innerHeight + l, n = -1 * l, q = l), h = u[c].getBoundingClientRect(), (J = h.bottom) >= n && (G = h.top) <= F && (I = h.right) >= n * t && (H = h.left) <= D && (J || I || H || G) && (e.loadHidden || T(u[c])) && (m && Q < 3 && !o && (p < 3 || R < 4) || U(u[c], l))) {
							if (ba(u[c]), k = !0, Q > 9) break;
						} else !k && m && !j && Q < 4 && R < 4 && p > 2 && (g[0] || e.preloadAfterLoad) && (g[0] || !o && (J || I || H || G || "auto" != u[c][i](e.sizesAttr))) && (j = g[0] || u[c]);
						j && !k && ba(j);
					}
				},
				W = B(V),
				X = function (a) {
					var b = a.target;
					if (b._lazyCache) return void delete b._lazyCache;
					S(a), s(b, e.loadedClass), t(b, e.loadingClass), u(b, Z), v(b, "lazyloaded");
				},
				Y = A(X),
				Z = function (a) {
					Y({
						target: a.target
					});
				},
				$ = function (a, b) {
					try {
						a.contentWindow.location.replace(b);
					} catch (c) {
						a.src = b;
					}
				},
				_ = function (a) {
					var b, c = a[i](e.srcsetAttr);
					(b = e.customMedia[a[i]("data-media") || a[i]("media")]) && a.setAttribute("media", b), c && a.setAttribute("srcset", c);
				},
				aa = A(function (a, b, c, d, f) {
					var g, h, j, l, m, p;
					(m = v(a, "lazybeforeunveil", b)).defaultPrevented || (d && (c ? s(a, e.autosizesClass) : a.setAttribute("sizes", d)), h = a[i](e.srcsetAttr), g = a[i](e.srcAttr), f && (j = a.parentNode, l = j && n.test(j.nodeName || "")), p = b.firesLoad || "src" in a && (h || g || l), m = {
						target: a
					}, s(a, e.loadingClass), p && (clearTimeout(o), o = k(S, 2500), u(a, Z, !0)), l && q.call(j.getElementsByTagName("source"), _), h ? a.setAttribute("srcset", h) : g && !l && (M.test(a.nodeName) ? $(a, g) : a.src = g), f && (h || l) && w(a, {
						src: g
					})), a._lazyRace && delete a._lazyRace, t(a, e.lazyClass), z(function () {
						var b = a.complete && a.naturalWidth > 1;
						p && !b || (b && s(a, "ls-is-cached"), X(m), a._lazyCache = !0, k(function () {
							"_lazyCache" in a && delete a._lazyCache;
						}, 9)), "lazy" == a.loading && Q--;
					}, !0);
				}),
				ba = function (a) {
					if (!a._lazyRace) {
						var b, c = L.test(a.nodeName),
							d = c && (a[i](e.sizesAttr) || a[i]("sizes")),
							f = "auto" == d;
						(!f && m || !c || !a[i]("src") && !a.srcset || a.complete || r(a, e.errorClass) || !r(a, e.lazyClass)) && (b = v(a, "lazyunveilread").detail, f && E.updateElem(a, !0, a.offsetWidth), a._lazyRace = !0, Q++, aa(a, b, f, d, c));
					}
				},
				ca = C(function () {
					e.loadMode = 3, W();
				}),
				da = function () {
					3 == e.loadMode && (e.loadMode = 2), ca();
				},
				ea = function () {
					if (!m) {
						if (c.now() - y < 999) return void k(ea, 999);
						m = !0, e.loadMode = 3, W(), j("scroll", da, !0);
					}
				};
			return {
				_: function () {
					y = c.now(), d.elements = b.getElementsByClassName(e.lazyClass), g = b.getElementsByClassName(e.lazyClass + " " + e.preloadClass), j("scroll", W, !0), j("resize", W, !0), j("pageshow", function (a) {
						if (a.persisted) {
							var c = b.querySelectorAll("." + e.loadingClass);
							c.length && c.forEach && l(function () {
								c.forEach(function (a) {
									a.complete && ba(a);
								});
							});
						}
					}), a.MutationObserver ? new MutationObserver(W).observe(f, {
						childList: !0,
						subtree: !0,
						attributes: !0
					}) : (f[h]("DOMNodeInserted", W, !0), f[h]("DOMAttrModified", W, !0), setInterval(W, 999)), j("hashchange", W, !0), ["focus", "mouseover", "click", "load", "transitionend", "animationend"].forEach(function (a) {
						b[h](a, W, !0);
					}), /d$|^c/.test(b.readyState) ? ea() : (j("load", ea), b[h]("DOMContentLoaded", W), k(ea, 2e4)), d.elements.length ? (V(), z._lsFlush()) : W();
				},
				checkElems: W,
				unveil: ba,
				_aLSL: da
			};
		}(),
		E = function () {
			var a, c = A(function (a, b, c, d) {
					var e, f, g;
					if (a._lazysizesWidth = d, d += "px", a.setAttribute("sizes", d), n.test(b.nodeName || ""))
						for (e = b.getElementsByTagName("source"), f = 0, g = e.length; f < g; f++) e[f].setAttribute("sizes", d);
					c.detail.dataAttr || w(a, c.detail);
				}),
				d = function (a, b, d) {
					var e, f = a.parentNode;
					f && (d = y(a, f, d), e = v(a, "lazybeforesizes", {
						width: d,
						dataAttr: !!b
					}), e.defaultPrevented || (d = e.detail.width) && d !== a._lazysizesWidth && c(a, f, e, d));
				},
				f = function () {
					var b, c = a.length;
					if (c)
						for (b = 0; b < c; b++) d(a[b]);
				},
				g = C(f);
			return {
				_: function () {
					a = b.getElementsByClassName(e.autosizesClass), j("resize", g);
				},
				checkElems: g,
				updateElem: d
			};
		}(),
		F = function () {
			!F.i && b.getElementsByClassName && (F.i = !0, E._(), D._());
		};
	return k(function () {
		e.init && F();
	}), d = {
		cfg: e,
		autoSizer: E,
		loader: D,
		init: F,
		uP: w,
		aC: s,
		rC: t,
		hC: r,
		fire: v,
		gW: y,
		rAF: z
	};
});