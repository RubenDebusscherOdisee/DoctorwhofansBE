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
		getpad(menu);
	}
	if (menu === "Home") {
		$('.path').remove();
		$('footer').prepend("<p class='quote'></p>");
		GetOneRandomQuote();
	}
	if (menu === "News") {
		GetNews();
	}
	if (menu === "Companions") {
		$(".col-6").append('<div class="open-close"></div>');
		companionsophalen(taal, menu, id);
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
	if (menu === "Companions") {
		$(".col-6").append('<div class="open-close"></div>');
		companionsophalen(taal, menu, id);
	}
	contentophalen(taal, menu);
}

function changelang(taal) {
	$('meta[name=language]').attr('content', taal.replace('_', '-'));
	$('html').attr('lang', taal.replace('_', '-'));

	$('.col-6, .under, .path').fadeOut(800);
	setCookie("lang", taal, 30);

	$('.col-6, .under, .path').empty();
	$('#overlay_background, #overlay').hide();
	rerenderpage(getCookie("lang"), menu);
	$('.col-6, .under, .path').fadeIn();
}













/*MAIN */
var aantalrecords;
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
	if (menu.startsWith('Category') === true) {
		var prefix = "Category_";
		tag = menu.substr(prefix.length, menu.length);
		$('.path').remove();
		$('.col-6').append("<h1>" + translations[0].Category + ": " + tag.split('_').join(' ') + "</h1>");
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
							if (aantalrecords == resultaat.data.length) {} else {
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
		videozoeken(getCookie("lang"), menu, id, $("#zoekterm").val());
		quotezoeken(getCookie("lang"), menu, id, $("#zoekterm").val());
		jQuery("html, body").animate({
			scrollTop: 0
		}, 500);
		var e = window.innerHeight || document.documentElement.clientHeight || document.body.clientHeight;
		document.getElementById("overlay_background").style.height = e;
		jQuery("#overlay_background, #overlay_Zoeken").fadeIn(500);
		$('html, body').css({
			overflow: 'hidden',
			height: '100%'
		});
		return false;

	}
}

function zoeken(taal, menu, zoekterm, ip, UID) {
	zoekterm = $("#zoekterm").val();
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
					$("#resultcontent").append("<a href='../" + resultaat.data[i].link + "/'  ><h3>" + resultaat.data[i].topic + " (Forum)</h3></a>");
				} else {
					$("#resultcontent").append("<a href='../" + resultaat.data[i].link + "/'  ><h3>" + resultaat.data[i].topic + "</h3></a>");
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
				videosophalen(menu);
			}
			if (menu === "Quotes" || resultaat.data[0].pad.search("Quotes") > 0) {
				quotesophalen(menu, id);
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
function videozoeken(taal, menu, zoekterm) {
	zoekterm = $("#zoekterm").val();
	$.ajax({
		type: "GET",
		url: "/php/zoekenvideo.php?taal=" + taal + "&menu=" + menu + "&zoekterm=" + zoekterm,
		dataType: 'json'
	}).done(function (resultaat) {
		$("#resultset2").append("<div class ='result slide' id='resultvideo'></div>");
		$("#resultvideo").hide();
		var i;
		for (i = 0; i < resultaat.data.length; i += 1) {
			$("#resultvideo").append("<a href='../Video/' onclick=event.preventDefault();$('.col-6').html('');videosophalen('Video'," + resultaat.data[i].id + ")  ><h3>" + resultaat.data[i].Video_Name + "</h3</a>");
			$("#resultvideo").append("<p>" + resultaat.data[i].Video_Beschrijving + "...</p>");
		}
	}).fail(function (response, statusText, xhr) {}).always(function () {});
}
function quotezoeken(taal, menu, zoekterm) {
	zoekterm = $("#zoekterm").val();
	$.ajax({
		type: "GET",
		url: "/php/zoekenquote.php?taal=" + taal + "&menu=" + menu + "&zoekterm=" + zoekterm,
		dataType: 'json'
	}).done(function (resultaat) {
		$("#resultset3").append("<div class ='result slide' id='resultQuote'></div>");
		$("#resultQuote").hide();
		var i;
		for (i = 0; i < resultaat.data.length; i += 1) {
			$("#resultQuote").append("<a href='../Quotes/' onclick=event.preventDefault();$('.col-6').html('');quotesophalen('Quotes'," + resultaat.data[i].id + ")><h3>" + resultaat.data[i].Aflevering + "</h3</a>");
			$("#resultQuote").append("<p>" + resultaat.data[i].Quote + "...</p>");
		}
	}).fail(function (response, statusText, xhr) {}).always(function () {});
}
function companionsophalen(taal, menu, id) {
	$.ajax({
		type: "GET",
		url: "/php/companionsophalen.php?taal=" + taal + "&menu=" + menu,
		dataType: 'json'
	}).done(function (resultaat) {
		$(".open-close").append("<div class='resultset holder' style='border:1px solid yelllow' id='D1'>");
		$("#D1").append("<div class='header'><a class='opner' onclick=ToggleCompanion('D1') href='#First'>First Doctor<img class='upDown lazyload' data-src='../images/up_down.png'alt='up-down First Doctor'/></a></div>");
		$("#D1").append("<div class ='result companion slide' id='resultD1'></div>");
		$(".open-close").append("<div class='resultset holder' style='border:1px solid yelllow' id='D2'>");
		$("#D2").append("<div class='header'><a class='opner' onclick=ToggleCompanion('D2') href='#Second'>Second Doctor<img class='upDown lazyload' data-src='../images/up_down.png'alt='up-down Second Doctor'/></a></div>");
		$("#D2").append("<div class ='result companion slide' id='resultD2'></div>");
		$(".open-close").append("<div class='resultset holder' style='border:1px solid yelllow' id='D3'>");
		$("#D3").append("<div class='header'><a class='opner' onclick=ToggleCompanion('D3') href='#Third'>Third Doctor<img class='upDown lazyload' data-src='../images/up_down.png'alt='up-down Third Doctor'/></a></div>");
		$("#D3").append("<div class ='result companion slide' id='resultD3'></div>");
		$(".open-close").append("<div class='resultset holder' style='border:1px solid yelllow' id='D4'>");
		$("#D4").append("<div class='header'><a class='opner' onclick=ToggleCompanion('D4') href='#Fourth'>Fourth Doctor<img class='upDown lazyload' data-src='../images/up_down.png'alt='up-down Fourth Doctor'/></a></div>");
		$("#D4").append("<div class ='result companion slide' id='resultD4'></div>");
		$(".open-close").append("<div class='resultset holder' style='border:1px solid yelllow' id='D5'>");
		$("#D5").append("<div class='header'><a class='opner' onclick=ToggleCompanion('D5') href='#Fifth'>Fifth Doctor<img class='upDown lazyload' data-src='../images/up_down.png'alt='up-down Fifth Doctor'/></a></div>");
		$("#D5").append("<div class ='result companion slide' id='resultD5'></div>");
		$(".open-close").append("<div class='resultset holder' style='border:1px solid yelllow' id='D6'>");
		$("#D6").append("<div class='header'><a class='opner' onclick=ToggleCompanion('D6') href='#Sixth'>Sixth Doctor<img class='upDown lazyload' data-src='../images/up_down.png'alt='up-down Sixth Doctor'/></a></div>");
		$("#D6").append("<div class ='result companion slide' id='resultD6'></div>");
		$(".open-close").append("<div class='resultset holder' style='border:1px solid yelllow' id='D7'>");
		$("#D7").append("<div class='header'><a class='opner' onclick=ToggleCompanion('D7') href='#Seventh'>Seventh Doctor<img class='upDown lazyload' data-src='../images/up_down.png'alt='up-down Seventh Doctor'/></a></div>");
		$("#D7").append("<div class ='result companion slide' id='resultD7'></div>");
		$(".open-close").append("<div class='resultset holder' style='border:1px solid yelllow' id='D8'>");
		$("#D8").append("<div class='header'><a class='opner' onclick=ToggleCompanion('D8') href='#Eighth'>Eighth Doctor<img class='upDown lazyload' data-src='../images/up_down.png'alt='up-down Eighth Doctor'/></a></div>");
		$("#D8").append("<div class ='result companion slide' id='resultD8'></div>");
		$(".open-close").append("<div class='resultset holder' style='border:1px solid yelllow' id='DW'>");
		$("#DW").append("<div class='header'><a class='opner' onclick=ToggleCompanion('DW') href='#War'>War Doctor<img class='upDown lazyload' data-src='../images/up_down.png'alt='up-down War Doctor'/></a></div>");
		$("#DW").append("<div class ='result companion slide' id='resultDW'></div>");
		$(".open-close").append("<div class='resultset holder' style='border:1px solid yelllow' id='D9'>");
		$("#D9").append("<div class='header'><a class='opner' onclick=ToggleCompanion('D9') href='#'>Ninth Doctor<img class='upDown lazyload' data-src='../images/up_down.png'alt='up-down Ninth Doctor'/></a></div>");
		$("#D9").append("<div class ='result companion slide' id='resultD9'></div>");
		$(".open-close").append("<div class='resultset holder' style='border:1px solid yelllow' id='D10'>");
		$("#D10").append("<div class='header'><a class='opner' onclick=ToggleCompanion('D10') href='#'>Tenth Doctor<img class='upDown lazyload' data-src='../images/up_down.png'alt='up-down Tenth Doctor'/></a></div>");
		$("#D10").append("<div class ='result companion slide' id='resultD10'></div>");
		$(".open-close").append("<div class='resultset holder' style='border:1px solid yelllow' id='D11'>");
		$("#D11").append("<div class='header'><a class='opner' onclick=ToggleCompanion('D11') href='#'>Eleventh Doctor<img class='upDown lazyload' data-src='../images/up_down.png'alt='up-down Eleventh Doctor'/></a></div>");
		$("#D11").append("<div class ='result companion slide' id='resultD11'></div>");
		$(".open-close").append("<div class='resultset holder' style='border:1px solid yelllow' id='D12'>");
		$("#D12").append("<div class='header'><a class='opner' onclick=ToggleCompanion('D12') href='#'>Twelfth Doctor<img class='upDown lazyload' data-src='../images/up_down.png'alt='up-down Twelfth Doctor'/></a></div>");
		$("#D12").append("<div class ='result companion slide' id='resultD12'></div>");
		$(".open-close").append("<div class='resultset holder' style='border:1px solid yelllow' id='D13'>");
		$("#D13").append("<div class='header'><a class='opner' onclick=ToggleCompanion('D13') href='#'>Thirteenth Doctor<img class='upDown lazyload' data-src='../images/up_down.png'alt='up-down Thirteenth Doctor'/></a></div>");
		$("#D13").append("<div class ='result companion slide' id='resultD13'></div>");
		var i;
		for (i = 0; i < resultaat.data.length; i += 1) {
			if (resultaat.data[i].Doctor == "1" || resultaat.data[i].Doctor2 == "1" || resultaat.data[i].Doctor3 == "1" || resultaat.data[i].Doctor4 == "1") {
				$("#resultD1").append("<div><a href='../" + resultaat.data[i].Pagina_Naam + "/'  ><h3>" + resultaat.data[i].Naam + "</h3></a></div>");
			}
			if (resultaat.data[i].Doctor == "2" || resultaat.data[i].Doctor2 == "2" || resultaat.data[i].Doctor3 == "2" || resultaat.data[i].Doctor4 == "2") {
				$("#resultD2").append("<div><a href='../" + resultaat.data[i].Pagina_Naam + "/'  ><h3>" + resultaat.data[i].Naam + "</h3></a></div>");
			}
			if (resultaat.data[i].Doctor == "3" || resultaat.data[i].Doctor2 == "3" || resultaat.data[i].Doctor3 == "3" || resultaat.data[i].Doctor4 == "3") {
				$("#resultD3").append("<div><a href='../" + resultaat.data[i].Pagina_Naam + "/'  ><h3>" + resultaat.data[i].Naam + "</h3></a></div>");
			}
			if (resultaat.data[i].Doctor == "4" || resultaat.data[i].Doctor2 == "4" || resultaat.data[i].Doctor3 == "4" || resultaat.data[i].Doctor4 == "4") {
				$("#resultD4").append("<div><a href='../" + resultaat.data[i].Pagina_Naam + "/' ><h3>" + resultaat.data[i].Naam + "</h3></a></div>");
			}
			if (resultaat.data[i].Doctor == "5" || resultaat.data[i].Doctor2 == "5" || resultaat.data[i].Doctor3 == "5" || resultaat.data[i].Doctor4 == "5") {
				$("#resultD5").append("<div><a href='../" + resultaat.data[i].Pagina_Naam + "/' ><h3>" + resultaat.data[i].Naam + "</h3></a></div>");
			}
			if (resultaat.data[i].Doctor == "6" || resultaat.data[i].Doctor2 == "6" || resultaat.data[i].Doctor3 == "6" || resultaat.data[i].Doctor4 == "6") {
				$("#resultD6").append("<div><a href='../" + resultaat.data[i].Pagina_Naam + "/' ><h3>" + resultaat.data[i].Naam + "</h3></a></div>");
			}
			if (resultaat.data[i].Doctor == "7" || resultaat.data[i].Doctor2 == "7" || resultaat.data[i].Doctor3 == "7" || resultaat.data[i].Doctor4 == "7") {
				$("#resultD7").append("<div><a href='../" + resultaat.data[i].Pagina_Naam + "/' ><h3>" + resultaat.data[i].Naam + "</h3></a></div>");
			}
			if (resultaat.data[i].Doctor == "8" || resultaat.data[i].Doctor2 == "8" || resultaat.data[i].Doctor3 == "8" || resultaat.data[i].Doctor4 == "8") {
				$("#resultD8").append("<div><a href='../" + resultaat.data[i].Pagina_Naam + "/' ><h3>" + resultaat.data[i].Naam + "</h3></a></div>");
			}
			if (resultaat.data[i].Doctor == "9" || resultaat.data[i].Doctor2 == "9" || resultaat.data[i].Doctor3 == "9" || resultaat.data[i].Doctor4 == "9") {
				$("#resultDW").append("<div><a href='../" + resultaat.data[i].Pagina_Naam + "/' ><h3>" + resultaat.data[i].Naam + "</h3></a></div>");
			}
			if (resultaat.data[i].Doctor == "10" || resultaat.data[i].Doctor2 == "10" || resultaat.data[i].Doctor3 == "10" || resultaat.data[i].Doctor4 == "10") {
				$("#resultD9").append("<div><a href='../" + resultaat.data[i].Pagina_Naam + "/' ><h3>" + resultaat.data[i].Naam + "</h3></a></div>");
			}
			if (resultaat.data[i].Doctor == "11" || resultaat.data[i].Doctor2 == "11" || resultaat.data[i].Doctor3 == "11" || resultaat.data[i].Doctor4 == "11") {
				$("#resultD10").append("<div><a href='../" + resultaat.data[i].Pagina_Naam + "/' ><h3>" + resultaat.data[i].Naam + "</h3></a></div>");
			}
			if (resultaat.data[i].Doctor == "12" || resultaat.data[i].Doctor2 == "12" || resultaat.data[i].Doctor3 == "12" || resultaat.data[i].Doctor4 == "12") {
				$("#resultD11").append("<div><a href='../" + resultaat.data[i].Pagina_Naam + "/' ><h3>" + resultaat.data[i].Naam + "</h3></a></div>");
			}
			if (resultaat.data[i].Doctor == "13" || resultaat.data[i].Doctor2 == "13" || resultaat.data[i].Doctor3 == "13" || resultaat.data[i].Doctor4 == "13") {
				$("#resultD12").append("<div><a href='../" + resultaat.data[i].Pagina_Naam + "/' ><h3>" + resultaat.data[i].Naam + "</h3></a></div>");
			}
			if (resultaat.data[i].Doctor == "14" || resultaat.data[i].Doctor2 == "14" || resultaat.data[i].Doctor3 == "14" || resultaat.data[i].Doctor4 == "14") {
				$("#resultD13").append("<div><a href='../" + resultaat.data[i].Pagina_Naam + "/' ><h3>" + resultaat.data[i].Naam + "</h3></a></div>");
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
		$(".col-6").append("<div class='main_vid'></div>");
		$(".col-6").append("<div class='vid_choice'></div>");
		if (id === "0" || id == null) {
			id = Math.floor((Math.random() * resultaat.data.length) + 1);
		} else {
			id = id;
		}
		for (i = 0; i < resultaat.data.length; i++) {
			if (id === resultaat.data[i].id) {
				if (resultaat.data[i].Video_Type === "Youtube") {
					$(".main_vid").append("<h2>" + resultaat.data[i].Video_Name + "</h2>");
					$(".main_vid").append("<iframe width='853' height='480' src='" + resultaat.data[i].Video_URL + "' frameborder='0' allowfullscreen></iframe>");
				} else {
					$(".main_vid").append("<h2>" + resultaat.data[i].Video_Name + "</h2>");
					$(".main_vid").append("<video width='480' controls controlsList='nodownload'><source src='../" + resultaat.data[i].Video_URL + "' type='video/mp4'></video>");
				}
			} else {
				if (resultaat.data[i].SPOILER === 1) {
					$(".vid_choice").append("<a href='#' title='" + resultaat.data[i].Video_Name + "' onclick=event.preventDefault();$('.col-6').html('');videosophalen('Video'," + resultaat.data[i].id + ") class='inline_vid' ><div class=keuze><div><img data-src='../" + resultaat.data[i].Video_Image + "' class='thumbnail lazyload' style='display:inline;background-color:red' alt='" + resultaat.data[i].Video_Name + "'></div><p title='" + resultaat.data[i].Video_Name + "'>" + resultaat.data[i].Video_Name.substr(0, 13) + "...</p></div></a>");
				} else {
					$(".vid_choice").append("<a href='#' title='" + resultaat.data[i].Video_Name + "' onclick=event.preventDefault();$('.col-6').html('');videosophalen('Video'," + resultaat.data[i].id + ") class='inline_vid' ><div class=keuze><div><img data-src='../" + resultaat.data[i].Video_Image + "' class='thumbnail lazyload' style='display:inline;' alt='" + resultaat.data[i].Video_Name + "'></div><p title='" + resultaat.data[i].Video_Name + "'>" + resultaat.data[i].Video_Name.substr(0, 13) + "...</p></div></a>");
				}
			}
		}
	}).fail(function (response, statusText, xhr) {}).always(function () {});
}

function quotesophalen(menu, id) {
	$.ajax({
		type: "GET",
		url: "/php/quotesophalen.php?menu=" + menu + "&id=" + id,
		dataType: 'json',
		cache: false
	}).done(function (resultaat) {
		$(".col-6").append("<div class='main_quote' style=''></div>");
		$(".col-6").append("<div class='selectie'></div>");
		$(".selectie").append("<div class='linkerquote'></div>");
		$(".selectie").append("<div class='rechterquote'></div>");
		if (id === "0" || id == null) {
			id = Math.floor((Math.random() * resultaat.data.length) + 1);
		} else {
			id = id;
		}
		for (i = 0; i < resultaat.data.length; i++) {
			if (id === resultaat.data[i].id) {
				$(".main_quote").append("<img class='quote_picture lazyload' data-src='../images/Quotes/" + resultaat.data[i].QuotePic + "'/><h1>" + resultaat.data[i].Aflevering + "</h1>");
				$(".main_quote").append("<div><p class='quotetext'>" + resultaat.data[i].Quote + "</p><p>" + resultaat.data[i].Personage + "</p><div>");
			} else {
				var quote = resultaat.data[i].Quote.substring(0, 60).replace(/<(.|\n)*?>/g, '');
				if (i % 2 === 0) {
					$(".linkerquote").append("<div><a href='#' onclick=event.preventDefault();$('.col-6').html('');quotesophalen('Quotes'," + resultaat.data[i].id + ")>" + quote + "</a></div>");
				} else {
					$(".rechterquote").append("<div><a href='#' onclick=event.preventDefault();$('.col-6').html('');quotesophalen('Quotes'," + resultaat.data[i].id + ")>" + quote + "</a></div>");
				}
			}
		}
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
				$("#Quotes").append("<div class='quoteitem'><div class='quoteQuote'><p>" + resultaat.data[i].Quote + "</p></><div class='quoteEpisode'><p><b>" + resultaat.data[i].Aflevering + "</b></p></div></div>");
			}
		}
	}).fail(function (response, statusText, xhr) {
		$("#Quotes").append("<p>" + translations[0].NoQuotesForChar + "</p>");
	}).always(function () {});
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
				$("#Quotes").append("<p class='quoteitem'>" + resultaat.data[i].Quote + "</p>");
			}
		}
	}).fail(function (response, statusText, xhr) {
		$("#Quotes").append("<p>" + translations[0].NoQuotesForEpisode + "</p>");
	}).always(function () {});
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
			$("#"+identifier).append("<div class=TimeDiv><span><b>"+resultaat.data[i].titel+":</b></span><br><p>"+secondsToDhms(resultaat.data[i].total).replace(/,\s*$/, "")+"</p></div>");
			
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
		$('.quote').append("<a href='../Quotes/'>" + translations[0].ReadMore + "</a>");
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
		aantalrecords = resultaat.data.length;
		var i;

		for (i = 0; i < resultaat.data.length; i += 1) {
			if (resultaat.data[i].A_Pagina_Type === "Slider") {
				$(".col-6").append("<div class='slideshow-container'><a class='prev' onclick='plusSlides(-1)'>&#10094;</a><a class='next' onclick='plusSlides(1)'>&#10095;</a></div>");
			}
			if (resultaat.data[i].A_Pagina_Type === "WikiPagina") {
				$(".col-6").append("<div id='WikiDetails'></div>");
				$(".under").append("<div id='Voetnoot'><h2>" + translations[0].References + "</h2><ol></ol></div>");
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
				$(".Chronologie").append("<div class='Half'>" + translations[0].previous_episode + ":<br>" + resultaat.data[i].A_Waarde + "</div>");

			}
			if (resultaat.data[i].A_Type === "EpisodeNext") {
				$(".Chronologie").append("<div class='Half Rechts'>" + translations[0].next_episode + ":<br>" + resultaat.data[i].A_Waarde + "</div>");
			}
			if (resultaat.data[i].A_Type === "EpisodeWriterList") {
				$("#Items").append("<div class=WikiRule>" + translations[0].written_by + ": <span>" + resultaat.data[i].A_Waarde + "</span></div>");
			}
			if (resultaat.data[i].A_Type === "EpisodeEditorList") {
				$("#Items").append("<div class=WikiRule>" + translations[0].script_editor + ": <span>" + resultaat.data[i].A_Waarde + "</span></div>");
			}
			if (resultaat.data[i].A_Type === "EpisodeProducerList") {
				$("#Items").append("<div class=WikiRule>" + translations[0].produced_by + ": <span>" + resultaat.data[i].A_Waarde + "</span></div>");
			}
			if (resultaat.data[i].A_Type === "EpisodeExecutiveProducerList") {
				$("#Items").append("<div class=WikiRule>" + translations[0].ExecutiveProducer + ": <span>" + resultaat.data[i].A_Waarde + "</span></div>");
			}
			if (resultaat.data[i].A_Type === "EpisodeComposer") {
				$("#Items").append("<div class=WikiRule>" + translations[0].incidental_composer + ": <span>" + resultaat.data[i].A_Waarde + "</span></div>");
			}
			if (resultaat.data[i].A_Type === "EpisodeProductionCode") {
				if (resultaat.data[i].A_Waarde.includes('.')===true){
					$("#Items").append("<div class=WikiRule>" + translations[0].production_code + ": <span>" + Number(resultaat.data[i].A_Waarde).toFixed(2) + "</span></div>");

				}else{
					$("#Items").append("<div class=WikiRule>" + translations[0].production_code + ": <span>" + resultaat.data[i].A_Waarde + "</span></div>");

				}
			}
			if (resultaat.data[i].A_Type === "EpisodeSeries") {
				$("#Items").append("<div class=WikiRule>" + translations[0].Series + ": <span>" + resultaat.data[i].A_Waarde + "</span></div>");
			}
			if (resultaat.data[i].A_Type === "EpisodeLength") {
				$("#Items").append("<div class=WikiRule>" + translations[0].Length + ": <span>" + resultaat.data[i].A_Waarde + "</span></div>");
			}
			if (resultaat.data[i].A_Type === "EpisodeDateStarted") {
				$("#Items").append("<div class=WikiRule>" + translations[0].Startdate + ": <span>" + convertDate(resultaat.data[i].A_Waarde) + "</span></div>");
			}
			if (resultaat.data[i].A_Type === "EpisodeDateEnded") {
				$("#Items").append("<div class=WikiRule>" + translations[0].Enddate + ": <span>" + convertDate(resultaat.data[i].A_Waarde) + "</span></div>");
			}
			if (resultaat.data[i].A_Type === "EpisodeAirDate") {
				$("#Items").append("<div class=WikiRule>" + translations[0].AirDate + ": <span>" + convertDate(resultaat.data[i].A_Waarde) + "</span></div>");
			}
			if (resultaat.data[i].A_Type === "WikiLooseItem") {
				$("#Items").append("<div class=WikiRule>" + resultaat.data[i].A_Waarde + "</div>");
			}
			if (resultaat.data[i].A_Type === "WikiHeadingBar") {
				$("#Items").append("<div class=WikiItemTitel>" + resultaat.data[i].A_Waarde + "</div>");
			}
			if (resultaat.data[i].A_Type === "Inleiding") {
				$(".col-6").append("<div class='" + resultaat.data[i].A_Klasse + "'>" + resultaat.data[i].A_Waarde + "</div>");
				$(".col-6").append("<div id='Inhoud'>" + translations[0].TOC + "<ol></ol></div>");
			}
			if (resultaat.data[i].A_Type === "Tekst") {
				$(".col-6").append("<div class='" + resultaat.data[i].A_Klasse + "'>" + resultaat.data[i].A_Waarde + "</div>");
			}
			if (resultaat.data[i].A_Type === "Code") {
				var code = resultaat.data[i].A_Waarde;
			}
			if (resultaat.data[i].A_Type === "GetEpisodesofToday") {
				GetEpisodesofToday();
			}


			if (resultaat.data[i].A_Type === "VoetnootItem") {
				$("#Voetnoot ol").append("<li class='" + resultaat.data[i].A_Klasse + "'>" + resultaat.data[i].A_Waarde + "</li>");
			}
			if (resultaat.data[i].A_Type === "Voetnoot") {
				$("#Voetnoot ol").append(resultaat.data[i].A_Waarde);
			}

			if (resultaat.data[i].A_Type === "Kop2") {
				$(".col-6").append("<h2 class='" + resultaat.data[i].A_Klasse + " anchor' id='" + resultaat.data[i].A_ID + "'>" + resultaat.data[i].A_Waarde + "</h2>");
			}
			if (resultaat.data[i].A_Type === "Kop3") {

				$(".col-6").append("<h3 class='" + resultaat.data[i].A_Klasse + "' id='" + resultaat.data[i].A_ID + "'>" + resultaat.data[i].A_Waarde + "</h3>");
			}
			if (resultaat.data[i].A_Type === "Kop4") {

				$(".col-6").append("<h4 class='" + resultaat.data[i].A_Klasse + "' id='" + resultaat.data[i].A_ID + "'>" + resultaat.data[i].A_Waarde + "</h4>");
			}
			if (resultaat.data[i].A_Type === "Kop5") {

				$(".col-6").append("<h5 class='" + resultaat.data[i].A_Klasse + "' id='" + resultaat.data[i].A_ID + "'>" + resultaat.data[i].A_Waarde + "</h5>");
			}
			if (resultaat.data[i].A_Type === "Kop6") {

				$(".col-6").append("<h6 class='" + resultaat.data[i].A_Klasse + "' id='" + resultaat.data[i].A_ID + "'>" + resultaat.data[i].A_Waarde + "</h6>");
			}
			if (resultaat.data[i].A_Type === "Lijst") {
				$(".col-6").append("<ul class='" + resultaat.data[i].A_Klasse + "' id='" + resultaat.data[i].A_ID + "'>" + resultaat.data[i].A_Waarde + "</ul>");
			}
			if (resultaat.data[i].A_Pagina_Type === "Overzicht") {
				$(".under").append("<div class='topics'></div>");
				getchildren(menu);
			}
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
							$(".slideshow-container").append("<div class='mySlides fade'><img data-src='" + resultaat.data[i].A_Waarde + " lazyload' alt='" + resultaat.data[l].A_Waarde + " tile='" + resultaat.data[l].A_Waarde + "'style='80%;padding-left:6em;'><div class='text'>" + resultaat.data[l].A_Waarde + "</div></div>");
						}
					}
					setTimeout(function () {
						showSlides(this.slideIndex);
					}, 1000);
				} else {
					for (var m = 0; m < resultaat.data.length; m += 1) {
						if (resultaat.data[m].A_Hoort_Bij === resultaat.data[i].A_ID && (resultaat.data[m].A_Type === "Alt" || resultaat.data[m].A_Type === "Bijschrift")) {
							$(".col-6").append("<div id='" + resultaat.data[i].A_ID + "' class='foto_met_text " + resultaat.data[i].A_Klasse + "'></div>");
							$("#" + resultaat.data[i].A_ID).append("<img data-src='" + resultaat.data[i].A_Waarde + "' alt='" + resultaat.data[m].A_Waarde + " title='" + resultaat.data[m].A_Waarde + "' class='" + resultaat.data[i].A_Klasse + " lazyload'>");
							$("#" + resultaat.data[i].A_ID).append("<p class='" + resultaat.data[m].A_Klasse + "'>" + resultaat.data[m].A_Waarde + "</p>");
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
				$("#Items").append("<div class='WikiRule'>" + translations[0].first_episode + ":<span>" + resultaat.data[i].A_Waarde + "</span></div>");
			}
			if (resultaat.data[i].A_Type === "WikiItemLastEpisode") {
				$("#Items").append("<div class='WikiRule'>" + translations[0].last_episode + ":" + resultaat.data[i].A_Waarde + "</div>");
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
					tagstring += "<a href='../Category_" + resultaat.tags[i].cat_name.split(' ').join('_') + "/'>" + resultaat.tags[i].cat_name + "</a>";
				} else {
					tagstring += "<a href='../Category_" + resultaat.tags[i].cat_name.split(' ').join('_') + "/'>" + resultaat.tags[i].cat_name + "</a>, ";
				}
			}
			$('#Tags').html(tagstring);
		}

		if (getCookie("size") != "") {
			getSizesfromCookie();
		}
	}).fail(function (response, statusText, xhr) {}).always(function () {

	});



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

function ToggleCompanion(Doctor) {
	event.preventDefault();
	$("#result" + Doctor).slideToggle();
}

function ToggleResult(div) {
	event.preventDefault();
	$("#" + div).slideToggle();
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
	$('.col-6').append("<div id='EpisodesOfToday'><h2>Episodes of the Day</h2><ol></ol></div>");

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




















/*EDITOR */
(function ($) {
	var editorObj;
	var methods = {
		saveSelection: function () {
			//Function to save the text selection range from the editor
			$(this).data('editor').focus();
			if (window.getSelection) {
				sel = window.getSelection();
				if (sel.getRangeAt && sel.rangeCount) {
					$(this).data('currentRange', sel.getRangeAt(0));
				}
			} else if (document.selection && document.selection.createRange) {
				$(this).data('currentRange', document.selection.createRange());
			} else
				$(this).data('currentRange', null);
		},

		restoreSelection: function (text, mode) {
			//Function to restore the text selection range from the editor
			var node;
			if(typeof text !=='undefined'){
				text=false;
			}
			if(typeof mode !=='undefined'){
				mode="";
			}
			var range = $(this).data('currentRange');
			if (range) {
				if (window.getSelection) {
					if (text) {
						range.deleteContents();
						if (mode == "html") {
							var el = document.createElement("div");
							el.innerHTML = text;
							var frag = document.createDocumentFragment(),
								lastNode;
							while ((node = el.firstChild)) {
								lastNode = frag.appendChild(node);
							}
							range.insertNode(frag);
						} else
							range.insertNode(document.createTextNode(text));

					}
					sel = window.getSelection();
					sel.removeAllRanges();
					sel.addRange(range);
				} else if (document.selection && range.select) {
					range.select();
					if (text) {
						if (mode == "html")
							range.pasteHTML(text);
						else
							range.text = text;
					}
				}
			}
		},

		restoreIESelection: function () {
			//Function to restore the text selection range from the editor in IE
			var range = $(this).data('currentRange');
			if (range) {
				if (window.getSelection) {
					sel = window.getSelection();
					sel.removeAllRanges();
					sel.addRange(range);
				} else if (document.selection && range.select) {
					range.select();
				}
			}
		},

		insertTextAtSelection: function (text, mode) {
			var sel, range, node;
			if(typeof mode !=='undefined'){
				mode="";
			}
			if (window.getSelection) {
				sel = window.getSelection();
				if (sel.getRangeAt && sel.rangeCount) {
					range = sel.getRangeAt(0);
					range.deleteContents();
					var textNode = document.createTextNode(text);

					if (mode == "html") {
						var el = document.createElement("div");
						el.innerHTML = text;
						var frag = document.createDocumentFragment(),
							lastNode;
						while ((node = el.firstChild)) {
							lastNode = frag.appendChild(node);
						}
						range.insertNode(frag);
					} else {
						range.insertNode(textNode);
						range.selectNode(textNode);
					}
					sel.removeAllRanges();
					range = range.cloneRange();
					range.collapse(false);
					sel.addRange(range);
				}
			} else if (document.selection && document.selection.createRange) {
				range = document.selection.createRange();
				range.pasteHTML(text);
				range.select();
			}
		},

		imageWidget: function () {
			//Class for Widget Handling the upload of Files
			var _idSuffix = this.attr("id");
			var row = $('<div/>', {
				"class": "row"
			}).append($('<div/>', {
				id: "imgErrMsg_" + _idSuffix
			}));
			var container = $('<div/>', {
				'class': "tabbable tabs-left"
			});
			var navTabs = $('<ul/>', {
					class: "nav nav-tabs"
				})
				/*.append($('<li/>',
														{ class:"active"
													}).append($('<a/>',{
															"href":"#uploadImageBar_" + _idSuffix,
															"data-toggle":"tab"
														}).html("From Computer")
											))*/
				.append($('<li/>').append($('<a/>', {
					"href": "#imageFromLinkBar_" + _idSuffix,
					"data-toggle": "tab"
				}).html("From URL")));

			var tabContent = $("<div/>", {
				class: "tab-content"
			});
			var uploadImageBar = $("<div/>", {
				id: "uploadImageBar_" + _idSuffix,
				class: "tab-pane"
			});

			handleFileSelect = function (evt) {
				var files = evt.target.files; // FileList object
				var output = [];
				for (var i = 0, f; f == files[i]; i++) {
					//Loop thorugh all the files
					if (!f.type.match('image.*') || !f.name.match(/(?:gif|jpg|png|jpeg)$/)) { //Process only Images
						methods.showMessage.apply(this, ["imgErrMsg_" + _idSuffix, "Invalid file type"]);
						continue;
					}
					let reader = new FileReader();
					reader.onload = (function (imageFile) {
						return function (e) {
							//Render Thumnails
							var li = $('<li/>', {
								class: "col-xs-12 col-sm-6 col-md-3 col-lg-3"
							});
							var a = $('<a/>', {href: "javascript:void(0)",class: "thumbnail"}); // jshint ignore:line
							var image = $('<img/>', {
								src: e.target.result,
								title: escape(imageFile.name)
							}).appendTo(a).click(function () {
								$('#imageList_' + _idSuffix).data('current', $(this).attr('src'));
							});
							li.append(a).appendTo($('#imageList_' + _idSuffix));
						};
					})(f);
					reader.readAsDataURL(f);
				}
			};
			var chooseFromLocal = $('<input/>', {
				type: "file",
				class: "inline-form-control",
				multiple: "multiple"
			});
			chooseFromLocal.on('change', handleFileSelect);
			uploadImageBar.append(chooseFromLocal);
			var imageFromLinkBar = $("<div/>", {
				id: "imageFromLinkBar_" + _idSuffix,
				class: "tab-pane"
			});
			var getImageURL = $("<div/>", {
				class: "input-group"
			});
			var imageURL = $('<input/>', {
				type: "url",
				class: 'form-control',
				id: "imageURL_" + _idSuffix,
				placeholder: "Enter URL"
			}).appendTo(getImageURL);
			var getURL = $("<button/>", {
				class: "btn btn-success",
				type: "button"
			}).html("Go!").click(function () {
				var url = $('#imageURL_' + _idSuffix).val();
				if (url == '') {
					methods.showMessage.apply(this, ["imgErrMsg_" + _idSuffix, "Please enter image url"]);
					return false;
				}
				var li = $('<li/>', {
					class: "span6 col-xs-12 col-sm-6 col-md-3 col-lg-3"
				});
				var a = $('<a/>', {href: "javascript:void(0)",class: "thumbnail"}); // jshint ignore:line
				var image = $('<img/>', {
					src: url,
				}).error(function () {
					methods.showMessage.apply(this, ["imgErrMsg_" + _idSuffix, "Invalid image url"]);
					return false;
				}).load(function () {
					$(this).appendTo(a).click(function () {
						$('#imageList_' + _idSuffix).data('current', $(this).attr('src'));
					});
					li.append(a).appendTo($('#imageList_' + _idSuffix));
				});
			}).appendTo($("<span/>", {
				class: "input-group-btn form-control-button-right"
			}).appendTo(getImageURL));

			imageFromLinkBar.append(getImageURL);
			tabContent.append(uploadImageBar).append(imageFromLinkBar);
			container.append(navTabs).append(tabContent);

			var imageListContainer = $("<div/>", {
				'class': 'col-xs-12 col-sm-12 col-md-12 col-lg-12'
			});
			var imageList = $('<ul/>', {
				"class": "thumbnails padding-top list-unstyled",
				"id": 'imageList_' + _idSuffix
			}).appendTo(imageListContainer);
			row.append(container).append(imageListContainer);
			return row;
		},

		tableWidget: function (mode) {
			//Function to generate the table input form
			var idExtn = "_" + $(this).attr("id");
			if (typeof mode !== 'undefined') {
				idExtn = "_" + editorObj.attr("id") + "_Edt";
			}
			var tblCntr = $('<div/>', { //Outer Container Div
				class: "row-fluid"
			}).append($('<div/>', { //Err Message Div
				id: "tblErrMsg" + idExtn
			})).append($('<form/>', { //Form 
				id: "tblForm" + idExtn
			}).append($('<div/>', { //Inner Container Div
				class: "row"
			}).append($('<div/>', { //Left input Container Div
				id: "tblInputsLeft" + idExtn,
				class: "col-xs-12 col-sm-6 col-md-6 col-lg-6"
			}).append($('<label/>', {
				for: "tblRows" + idExtn,
				text: "Rows"
			})).append($('<input/>', {
				id: "tblRows" + idExtn,
				type: "text",
				class: "form-control form-control-width",
				value: 2
			})).append($('<label/>', {
				for: "tblColumns" + idExtn,
				text: "Columns"
			})).append($('<input/>', {
				id: "tblColumns" + idExtn,
				type: "text",
				class: "form-control form-control-width",
				value: 2
			})).append($('<label/>', {
				for: "tblWidth" + idExtn,
				text: "Width"
			})).append($('<input/>', {
				id: "tblWidth" + idExtn,
				type: "text",
				class: "form-control form-control-width",
				value: 400
			})).append($('<label/>', {
				for: "tblHeight" + idExtn,
				text: "Height"
			})).append($('<input/>', {
				id: "tblHeight" + idExtn,
				type: "text",
				class: "form-control form-control-width",
			}))).append($('<div/>', { //Right input Container Div
				id: "tblInputsRight" + idExtn,
				class: "col-xs-12 col-sm-6 col-md-6 col-lg-6"
			}).append($('<label/>', {
				for: "tblAlign" + idExtn,
				text: "Alignment"
			})).append($('<select/>', {
				id: "tblAlign" + idExtn,
				class: "form-control form-control-width"
			}).append($('<option/>', {
				text: "Choose",
				value: ""
			})).append($('<option/>', {
				text: "Left",
				value: "left"
			})).append($('<option/>', {
				text: "Center",
				value: "center"
			})).append($('<option/>', {
				text: "Right",
				value: "right"
			}))).append($('<label/>', {
				for: "tblBorder" + idExtn,
				text: "Border size"
			})).append($('<input/>', {
				id: "tblBorder" + idExtn,
				type: "text",
				class: "form-control form-control-width",
				value: 1
			})).append($('<label/>', {
				for: "tblCellspacing" + idExtn,
				text: "Cell spacing"
			})).append($('<input/>', {
				id: "tblCellspacing" + idExtn,
				type: "text",
				class: "form-control form-control-width",
				value: 1
			})).append($('<label/>', {
				for: "tblCellpadding" + idExtn,
				text: "Cell padding"
			})).append($('<input/>', {
				id: "tblCellpadding" + idExtn,
				type: "text",
				class: "form-control form-control-width",
				value: 1
			})))));
			return tblCntr;
		},

		imageAttributeWidget: function () {

			var edtTablecntr = $('<div/>', {
				class: "row-fluid"
			}).append($('<div/>', { //Err Message Div
				id: "imageErrMsg"
			})).append($('<input/>', {
				id: "imgAlt",
				type: "text",
				class: "form-control form-control-link ",
				placeholder: "Alt Text",
			})).append($('<input/>', {
				id: "imgTarget",
				class: "form-control form-control-link ",
				type: "text",
				placeholder: "Link Target"
			})).append($('<input/>', {
				id: "imgHidden",
				type: "hidden"
			}));

			return edtTablecntr;

		},

		getHTMLTable: function (tblRows, tblColumns, attributes) {
			//Function to generate html table. Supplied arguments: tablerows-no.of rows, no.of columns, table attributes.
			var tableElement = $('<table/>', {
				class: "table"
			});
			for (var i = 0; i < attributes.length; i++) {
				if (attributes[i].value != '') {
					if (attributes[i].attribute == "width" || attributes[i].attribute == "height")
						tableElement.css(attributes[i].attribute, attributes[i].value);
					else
						tableElement.attr(attributes[i].attribute, attributes[i].value);
				}
			}
			for (i = 1; i <= tblRows; i++) {
				var tblRow = $('<tr/>');
				for (var j = 1; j <= tblColumns; j++) {
					var tblColumn = $('<td/>').html('&nbsp;');
					tblColumn.appendTo(tblRow);
				}
				tblRow.appendTo(tableElement);
			}
			return tableElement;
		},

		init: function (options) {
			if ($(this).attr("id") === undefined || $(this).attr("id") === "") {
				$(this).attr("id", Date.now());
			}
			var fonts = {
				"Sans serif": "arial,helvetica,sans-serif",
				"Serif": "times new roman,serif",
				"Wide": "arial black,sans-serif",
				"Narrow": "arial narrow,sans-serif",
				"Comic Sans MS": "comic sans ms,sans-serif",
				"Courier New": "courier new,monospace",
				"Garamond": "garamond,serif",
				"Georgia": "georgia,serif",
				"Tahoma": "tahoma,sans-serif",
				"Trebuchet MS": "trebuchet ms,sans-serif",
				"Verdana": "verdana,sans-serif"
			};

			var styles = {
				"Heading 1": "<h1>",
				"Heading 2": "<h2>",
				"Heading 3": "<h3>",
				"Heading 4": "<h4>",
				"Heading 5": "<h5>",
				"Heading 6": "<h6>",
				"Paragraph": "<p>"
			};

			var fontsizes = {
				"Small": "2",
				"Normal": "3",
				"Medium": "4",
				"Large": "5",
				"Huge": "6"
			};

			var colors = [{
					name: 'Black',
					hex: '#000000'
				},
				{
					name: 'MediumBlack',
					hex: '#444444'
				},
				{
					name: 'LightBlack',
					hex: '#666666'
				},
				{
					name: 'DimBlack',
					hex: '#999999'
				},
				{
					name: 'Gray',
					hex: '#CCCCCC'
				},
				{
					name: 'DimGray',
					hex: '#EEEEEE'
				},
				{
					name: 'LightGray',
					hex: '#F3F3F3'
				},
				{
					name: 'White',
					hex: '#FFFFFF'
				},

				{
					name: 'libreak',
					hex: null
				},

				{
					name: 'Red',
					hex: '#FF0000'
				},
				{
					name: 'Orange',
					hex: '#FF9900'
				},
				{
					name: 'Yellow',
					hex: '#FFFF00'
				},
				{
					name: 'Lime',
					hex: '#00FF00'
				},
				{
					name: 'Cyan',
					hex: '#00FFFF'
				},
				{
					name: 'Blue',
					hex: '#0000FF'
				},
				{
					name: 'BlueViolet',
					hex: '#8A2BE2'
				},
				{
					name: 'Magenta',
					hex: '#FF00FF'
				},

				{
					name: 'libreak',
					hex: null
				},

				{
					name: 'LightPink',
					hex: '#FFB6C1'
				},
				{
					name: 'Bisque',
					hex: '#FCE5CD'
				},
				{
					name: 'BlanchedAlmond',
					hex: '#FFF2CC'
				},
				{
					name: 'LightLime',
					hex: '#D9EAD3'
				},
				{
					name: 'LightCyan',
					hex: '#D0E0E3'
				},
				{
					name: 'AliceBlue',
					hex: '#CFE2F3'
				},
				{
					name: 'Lavender',
					hex: '#D9D2E9'
				},
				{
					name: 'Thistle',
					hex: '#EAD1DC'
				},

				{
					name: 'LightCoral',
					hex: '#EA9999'
				},
				{
					name: 'Wheat',
					hex: '#F9CB9C'
				},
				{
					name: 'NavajoWhite',
					hex: '#FFE599'
				},
				{
					name: 'DarkSeaGreen',
					hex: '#B6D7A8'
				},
				{
					name: 'LightBlue',
					hex: '#A2C4C9'
				},
				{
					name: 'SkyBlue',
					hex: '#9FC5E8'
				},
				{
					name: 'LightPurple',
					hex: '#B4A7D6'
				},
				{
					name: 'PaleVioletRed',
					hex: '#D5A6BD'
				},

				{
					name: 'IndianRed',
					hex: '#E06666'
				},
				{
					name: 'LightSandyBrown',
					hex: '#F6B26B'
				},
				{
					name: 'Khaki',
					hex: '#FFD966'
				},
				{
					name: 'YellowGreen',
					hex: '#93C47D'
				},
				{
					name: 'CadetBlue',
					hex: '#76A5AF'
				},
				{
					name: 'DeepSkyBlue',
					hex: '#6FA8DC'
				},
				{
					name: 'MediumPurple',
					hex: '#8E7CC3'
				},
				{
					name: 'MediumVioletRed',
					hex: '#C27BA0'
				},

				{
					name: 'Crimson',
					hex: '#CC0000'
				},
				{
					name: 'SandyBrown',
					hex: '#E69138'
				},
				{
					name: 'Gold',
					hex: '#F1C232'
				},
				{
					name: 'MediumSeaGreen',
					hex: '#6AA84F'
				},
				{
					name: 'Teal',
					hex: '#45818E'
				},
				{
					name: 'SteelBlue',
					hex: '#3D85C6'
				},
				{
					name: 'SlateBlue',
					hex: '#674EA7'
				},
				{
					name: 'VioletRed',
					hex: '#A64D79'
				},

				{
					name: 'Brown',
					hex: '#990000'
				},
				{
					name: 'Chocolate',
					hex: '#B45F06'
				},
				{
					name: 'GoldenRod',
					hex: '#BF9000'
				},
				{
					name: 'Green',
					hex: '#38761D'
				},
				{
					name: 'SlateGray',
					hex: '#134F5C'
				},
				{
					name: 'RoyalBlue',
					hex: '#0B5394'
				},
				{
					name: 'Indigo',
					hex: '#351C75'
				},
				{
					name: 'Maroon',
					hex: '#741B47'
				},

				{
					name: 'DarkRed',
					hex: '#660000'
				},
				{
					name: 'SaddleBrown',
					hex: '#783F04'
				},
				{
					name: 'DarkGoldenRod',
					hex: '#7F6000'
				},
				{
					name: 'DarkGreen',
					hex: '#274E13'
				},
				{
					name: 'DarkSlateGray',
					hex: '#0C343D'
				},
				{
					name: 'Navy',
					hex: '#073763'
				},
				{
					name: 'MidnightBlue',
					hex: '#20124D'
				},
				{
					name: 'DarkMaroon',
					hex: '#4C1130'
				}
			];

			var specialchars = [{
					name: "Exclamation ",
					text: "!"
				},
				{
					name: "At",
					text: "@"
				},
				{
					name: "Hash",
					text: "#"
				},
				{
					name: "Percentage",
					text: "%"
				},
				{
					name: "Uppercase",
					text: "^"
				},
				{
					name: "Ampersand",
					text: "&"
				},
				{
					name: "Asterisk",
					text: "*"
				},
				{
					name: "OpenBracket",
					text: "("
				},
				{
					name: "CloseBracket",
					text: ")"
				},
				{
					name: "Underscore",
					text: "_"
				},
				{
					name: "Hiphen",
					text: "-"
				},
				{
					name: "Plus",
					text: "+"
				},
				{
					name: "Equalto",
					text: "="
				},
				{
					name: "OpenSquareBracket",
					text: "["
				},
				{
					name: "CloseSquareBracket",
					text: "]"
				},
				{
					name: "OpenCurly",
					text: "{"
				},
				{
					name: "CloseCurly",
					text: "}"
				},
				{
					name: "Pipe",
					text: "|"
				},
				{
					name: "Colon",
					text: ":"
				},
				{
					name: "Semicolon",
					text: ";"
				},
				{
					name: "Single quote",
					text: "&#39;"
				},
				{
					name: "Double quote",
					text: "&#34;"
				},
				{
					name: "Left single curly quote",
					text: "&lsquo;"
				},
				{
					name: "right single curly quote",
					text: "&rsquo;"
				},
				{
					name: "Forward-slash",
					text: "&#47;"
				},
				{
					name: "Back-slash",
					text: "&#92;"
				},
				{
					name: "LessThan",
					text: "<"
				},
				{
					name: "GreaterThan",
					text: ">"
				},
				{
					name: "QuestionMark",
					text: "?"
				},
				{
					name: "Tilda",
					text: "~"
				},
				{
					name: "Grave accent",
					text: "`"
				},
				{
					name: "Micron",
					text: "&micro;"
				},
				{
					name: "Paragraph sign",
					text: "&para;"
				},
				{
					name: "Plus/minus",
					text: "&plusmn;"
				},
				{
					name: "Trademark",
					text: "&trade;"
				},
				{
					name: "Copyright",
					text: "&copy;"
				},
				{
					name: "Registered",
					text: "&reg;"
				},
				{
					name: "Section",
					text: "&sect;"
				},
				{
					name: "right double angle quotes",
					text: "&#187;"
				},
				{
					name: "fraction one quarter",
					text: "&#188;"
				},
				{
					name: "fraction one half",
					text: "&#189;"
				},
				{
					name: "fraction three quarters",
					text: "&#190;"
				},
				{
					name: "Dollar",
					text: "$"
				},
				{
					name: "Euro",
					text: "&euro;"
				},
				{
					name: "Pound",
					text: "&pound;"
				},
				{
					name: "Yen",
					text: "&yen;"
				},
				{
					name: "Cent",
					text: "&#162;"
				},
				{
					name: "IndianRupee",
					text: "&#8377;"
				},
			];

			var menuItems = {
				'fonteffects': true,
				'texteffects': true,
				'aligneffects': true,
				'textformats': true,
				'actions': true,
				'insertoptions': true,
				'extraeffects': true,
				'advancedoptions': true,
				'screeneffects': true,

				'fonts': {
					"select": true,
					"default": "Font",
					"tooltip": "Fonts",
					"commandname": "fontName",
					"custom": null
				},

				'styles': {
					"select": true,
					"default": "Formatting",
					"tooltip": "Paragraph Format",
					"commandname": "formatBlock",
					"custom": null
				},

				'font_size': {
					"select": true,
					"default": "Font size",
					"tooltip": "Font Size",
					"commandname": "fontSize",
					"custom": null
				},

				'color': {
					"text": "A",
					"icon": "fa fa-font",
					"tooltip": "Text/Background Color",
					"commandname": null,
					"custom": function (button) {
						var editor = $(this);
						var flag = 0;
						var paletteCntr = $('<div/>', {
							id: "paletteCntr",
							class: "activeColour",
							css: {
								"display": "none",
								"width": "335px"
							}
						}).click(function (event) {
							event.stopPropagation();
						});
						var paletteDiv = $('<div/>', {
							id: "colorpellete"
						});
						var palette = $('<ul />', {
							id: "color_ui"
						}).append($('<li />').css({
							"width": "145px",
							"display": "Block",
							"height": "25px"
						}).html('<div>Text Color</div>'));
						var bgPalletteDiv = $('<div/>', {
							id: "bg_colorpellete"
						});
						let bgPallette = $('<ul />', {
							id: "bgcolor_ui"
						}).append($('<li />').css({
							"width": "145px",
							"display": "Block",
							"height": "25px"
						}).html('<div>Background Color</div>'));
						if (editor.data("colorBtn")) {
							flag = 1;
							editor.data("colorBtn", null);
						} else
							editor.data("colorBtn", 1);
						if (flag == 0) {
							for (let i = 0; i < colors.length; i++) {
								if (colors[i].hex != null) {
									palette.append($('<li />').css('background-color', colors[i].hex).mousedown(function (event) {
										event.preventDefault();
									}).click(function () {
										let hexcolor = methods.rgbToHex.apply(this, [$(this).css('background-color')]);
										methods.restoreSelection.apply(this);
										methods.setStyleWithCSS.apply(this);
										document.execCommand('forecolor', false, hexcolor);
										$('#paletteCntr').remove();

										editor.data("colorBtn", null);
									}));

									bgPallette.append($('<li />').css('background-color', colors[i].hex).mousedown(function (event) {
										event.preventDefault();
									}).click(function () {
										let hexcolor = methods.rgbToHex.apply(this, [$(this).css('background-color')]);
										methods.restoreSelection.apply(this);
										methods.setStyleWithCSS.apply(this);
										document.execCommand('backColor', false, hexcolor);
										$('#paletteCntr').remove();
										editor.data("colorBtn", null);
									}));
								} else {
									palette.append($('<li />').css({
										"width": "145px",
										"display": "Block",
										"height": "5px"
									}));
									bgPallette.append($('<li />').css({
										"width": "145px",
										"display": "Block",
										"height": "5px"
									}));
								}
							}
							palette.appendTo(paletteDiv);
							bgPallette.appendTo(bgPalletteDiv);
							paletteDiv.appendTo(paletteCntr);
							bgPalletteDiv.appendTo(paletteCntr);
							paletteCntr.insertAfter(button);
							$('#paletteCntr').slideDown('slow');
						} else
							$('#paletteCntr').remove();
					}
				},

				'bold': {
					"text": "B",
					"icon": "fa fa-bold",
					"tooltip": "Bold",
					"commandname": "bold",
					"custom": null
				},

				'italics': {
					"text": "I",
					"icon": "fa fa-italic",
					"tooltip": "Italics",
					"commandname": "italic",
					"custom": null
				},

				'underline': {
					"text": "U",
					"icon": "fa fa-underline",
					"tooltip": "Underline",
					"commandname": "underline",
					"custom": null
				},

				'strikeout': {
					"text": "Strikeout",
					"icon": "fa fa-strikethrough",
					"tooltip": "Strike Through",
					"commandname": "strikeThrough",
					"custom": null
				},

				'ol': {
					"text": "N",
					"icon": "fa fa-list-ol",
					"tooltip": "Insert/Remove Numbered List",
					"commandname": "insertorderedlist",
					"custom": null
				},

				'ul': {
					"text": "Bullet",
					"icon": "fa fa-list-ul",
					"tooltip": "Insert/Remove Bulleted List",
					"commandname": "insertunorderedlist",
					"custom": null
				},

				'undo': {
					"text": "undo",
					"icon": "fa fa-undo",
					"tooltip": "Undo",
					"commandname": "undo",
					"custom": null
				},

				'redo': {
					"text": "redo",
					"icon": "fa fa-repeat",
					"tooltip": "Redo",
					"commandname": "redo",
					"custom": null
				},

				'l_align': {
					"text": "leftalign",
					"icon": "fa fa-align-left",
					"tooltip": "Align Left",
					"commandname": "justifyleft",
					"custom": null
				},

				'r_align': {
					"text": "rightalign",
					"icon": "fa fa-align-right",
					"tooltip": "Align Right",
					"commandname": "justifyright",
					"custom": null
				},

				'c_align': {
					"text": "centeralign",
					"icon": "fa fa-align-center",
					"tooltip": "Align Center",
					"commandname": "justifycenter",
					"custom": null
				},

				'justify': {
					"text": "justify",
					"icon": "fa fa-align-justify",
					"tooltip": "Justify",
					"commandname": "justifyfull",
					"custom": null
				},

				'unlink': {
					"text": "Unlink",
					"icon": "fa fa-unlink",
					"tooltip": "Unlink",
					"commandname": "unlink",
					"custom": null
				},

				'insert_link': {
					"modal": true,
					"modalId": "InsertLink_" + $(this).attr("id"),
					"icon": "fa fa-link",
					"tooltip": "Insert Link",
					"modalHeader": "Insert Hyperlink",
					"modalBody": $('<div/>', {
						class: "form-group"
					}).append($('<div/>', {
						id: "errMsg_" + $(this).attr("id")
					})).append($('<input/>', {
						type: "text",
						id: "inputText_" + $(this).attr("id"),
						class: "form-control form-control-link ",
						placeholder: "Text to Display",
					})).append($('<input/>', {
						type: "text",
						id: "inputUrl_" + $(this).attr("id"),
						required: true,
						class: "form-control form-control-link",
						placeholder: "Enter URL"
					})),
					"beforeLoad": function () {
						editorObj = this;
						var _idSuffix = "_" + this.attr("id");
						$('#inputText' + _idSuffix);
						$('#inputUrl' + _idSuffix);
						$(".alert").alert("close");
						if ($(editorObj).data('currentRange') != '') {
							$('#inputText_' + _idSuffix).val($(editorObj).data('currentRange'));
						}
					},
					"onSave": function () {
						var urlPattern = /(http|ftp|https):\/\/[\w-]+(\.[\w-]+)+([\w.,@?^=%&amp;:\/~+#-]*[\w@?^=%&amp;\/~+#-])?/;
						var _idSuffix = "_" + editorObj.attr("id");
						var targetText = $('#inputText' + _idSuffix).val();
						var targetURL = $('#inputUrl' + _idSuffix).val();
						var range = $(editorObj).data('currentRange');
						if (targetURL == '') {
							methods.showMessage.apply(editorObj, ["errMsg", "Please enter url"]);
							return false;
						}
						if (!targetURL.match(urlPattern)) {
							methods.showMessage.apply(editorObj, ["errMsg", "Enter valid url"]);
							return false;
						}
						if (range == '' && targetText == '') {
							targetText = targetURL;
						}
						if (navigator.userAgent.match(/MSIE/i) || navigator.userAgent.match(/Windows NT.*Trident\//)) {
							var targetLink = '<a href="' + targetURL + '" target="_blank">' + targetText + '</a>';
							methods.restoreSelection.apply(editorObj, [targetLink, 'html']);
						} else {
							methods.restoreSelection.apply(editorObj, [targetText]);
							document.execCommand('createLink', false, targetURL);
						}
						$(editorObj).data("editor").find('a[href="' + targetURL + '"]').each(function () {
							$(this).attr("target", "_blank");
						});
						$(".alert").alert("close");
						$("#InsertLink" + _idSuffix).modal("hide");
						$(editorObj).data("editor").focus();
						return false;
					}
				},

				'insert_img': {
					"modal": true,
					"modalId": "InsertImage_" + $(this).attr("id"),
					"icon": "fa fa-picture-o",
					"tooltip": "Insert Image",
					"modalHeader": "Insert Image",
					"modalBody": methods.imageWidget.apply(this),
					"beforeLoad": function () {
						editorObj = this;
						var _idSuffix = editorObj.attr("id");
						$('#imageURL_' + _idSuffix).val("");
						$("#uploadImageBar_" + _idSuffix + " :input").val("");
						$('#imageList_' + _idSuffix).data('current', "");
					},
					"onSave": function () {
						var _idSuffix = "_" + editorObj.attr("id");
						methods.restoreSelection.apply(this);
						if ($('#imageList' + _idSuffix).data('current')) {
							if (navigator.userAgent.match(/MSIE/i) || navigator.userAgent.match(/Windows NT.*Trident\//)) {
								var imageStr = '<img src="' + $('#imageList' + _idSuffix).data('current') + '"/>';
								methods.restoreSelection.apply(this, [imageStr, 'html']);
							} else {
								document.execCommand('insertimage', false, $('#imageList' + _idSuffix).data('current'));
							}
						} else {
							methods.showMessage.apply(this, ["imgErrMsg" + _idSuffix, "Please select an image"]);
							return false;
						}
						$("#InsertImage" + _idSuffix).modal("hide");
						$(this).data("editor").focus();
					}
				},

				'insert_table': {
					"modal": true,
					"modalId": "InsertTable_" + $(this).attr("id"),
					"icon": "fa fa-table",
					"tooltip": "Insert Table",
					"modalHeader": "Insert Table",
					"modalBody": methods.tableWidget.apply(this),
					"beforeLoad": function () {
						editorObj = this;
						$('#tblForm_' + editorObj.attr("id")).each(function () {
							this.reset();
						});
					},
					"onSave": function () {
						_idSuffix = "_" + editorObj.attr("id");
						methods.restoreSelection.apply(this);
						var tblRows = $('#tblRows' + _idSuffix).val();
						var tblColumns = $('#tblColumns' + _idSuffix).val();
						var tblWidth = $('#tblWidth' + _idSuffix).val();
						var tblHeight = $('#tblHeight' + _idSuffix).val();
						var tblAlign = $('#tblAlign' + _idSuffix).val();
						var tblBorder = $('#tblBorder' + _idSuffix).val();
						var tblCellspacing = $('#tblCellspacing' + _idSuffix).val();
						var tblCellpadding = $('#tblCellpadding' + _idSuffix).val();
						var intReg = /^[0-9]+$/;
						var cssReg = /^auto$|^[+-]?[0-9]+\.?([0-9]+)?(px|em|ex|%|in|cm|mm|pt|pc)?$/ig;
						var numReg = /^[0-9]+\.?([0-9])?$/;

						if (!tblRows.match(intReg)) {
							methods.showMessage.apply(this, ["tblErrMsg", "Rows must be a positive number"]);
							return false;
						}
						if (!tblColumns.match(intReg)) {
							methods.showMessage.apply(this, ["tblErrMsg", "Columns must be a positive number"]);
							return false;
						}
						if (tblWidth != "" && !tblWidth.match(cssReg)) {
							methods.showMessage.apply(this, ["tblErrMsg", "Please enter positive number with or without a valid CSS measurement unit (px,em,ex,%,in,cm,mm,pt,pc)"]);
							return false;
						}
						if (tblHeight != "" && !tblHeight.match(cssReg)) {
							methods.showMessage.apply(this, ["tblErrMsg", "Please enter positive number with or without a valid CSS measurement unit (px,em,ex,%,in,cm,mm,pt,pc)"]);
							return false;
						}
						if (tblBorder != "" && !tblBorder.match(numReg)) {
							methods.showMessage.apply(this, ["tblErrMsg", "Border size must be a positive number"]);
							return false;
						}
						if (tblCellspacing != "" && !tblCellspacing.match(numReg)) {
							methods.showMessage.apply(this, ["tblErrMsg", "Cell spacing must be a positive number"]);
							return false;
						}
						if (tblCellpadding != "" && !tblCellpadding.match(numReg)) {
							methods.showMessage.apply(this, ["tblErrMsg", "Cell padding must be a positive number"]);
							return false;
						}

						var htmlTableCntr = $('<div/>');
						var tblAttributes = [{
								attribute: "align",
								value: tblAlign
							},
							{
								attribute: "border",
								value: tblBorder
							},
							{
								attribute: "cellspacing",
								value: tblCellspacing
							},
							{
								attribute: "cellpadding",
								value: tblCellpadding
							},
							{
								attribute: "width",
								value: tblWidth
							},
							{
								attribute: "height",
								value: tblHeight
							},
						];
						var htmlTable = methods.getHTMLTable.apply(this, [tblRows, tblColumns, tblAttributes]);
						htmlTable.appendTo(htmlTableCntr);
						if (navigator.userAgent.match(/MSIE/i) || navigator.userAgent.match(/Windows NT.*Trident\//))
							methods.restoreSelection.apply(this, [htmlTableCntr.html(), 'html']);
						else
							document.execCommand('insertHTML', false, htmlTableCntr.html());
						$("#InsertTable" + _idSuffix).modal("hide");
						$(this).data("editor").focus();
					}
				},

				'hr_line': {
					"text": "HR",
					"icon": "fa fa-minus",
					"tooltip": "Horizontal Rule",
					"commandname": "insertHorizontalRule",
					"custom": null
				},

				'block_quote': {
					"text": "Block Quote",
					"icon": "fa fa-quote-right",
					"tooltip": "Block Quote",
					"commandname": null,
					"custom": function () {
						methods.setStyleWithCSS.apply(this);
						if (navigator.userAgent.match(/MSIE/i) || navigator.userAgent.match(/Windows NT.*Trident\//)) {
							document.execCommand('indent', false, null);
						} else {
							document.execCommand('formatBlock', false, '<blockquote>');
						}
					}
				},

				'indent': {
					"text": "Indent",
					"icon": "fa fa-indent",
					"tooltip": "Increase Indent",
					"commandname": "indent",
					"custom": null
				},

				'outdent': {
					"text": "Outdent",
					"icon": "fa fa-outdent",
					"tooltip": "Decrease Indent",
					"commandname": "outdent",
					"custom": null
				},

				'print': {
					"text": "Print",
					"icon": "fa fa-print",
					"tooltip": "Print",
					"commandname": null,
					"custom": function () {
						oDoc = $(this).data("editor");
						var oPrntWin = window.open("", "_blank", "width=450,height=470,left=400,top=100,menubar=yes,toolbar=no,location=no,scrollbars=yes");
						oPrntWin.document.open();
						oPrntWin.document.write("<!doctype html><html><head><title>Print</title></head><body onload=\"print();\">" + oDoc.html() + "</body></html>");
						oPrntWin.document.close();
					}
				},

				'rm_format': {
					"text": "Remove format",
					"icon": "fa fa-eraser",
					"tooltip": "Remove Formatting",
					"commandname": "removeformat",
					"custom": null
				},

				'select_all': {
					"text": "Select all",
					"icon": "fa fa-file-text",
					"tooltip": "Select All",
					"commandname": null,
					"custom": function () {
						document.execCommand("selectall", null, null);
					}
				},

				'togglescreen': {
					"text": "Toggle Screen",
					"icon": "fa fa-arrows-alt",
					"tooltip": "Toggle Screen",
					"commandname": null,
					"custom": function (button, parameters) {
						$(this).data("editor").parent().toggleClass('fullscreen');
						var statusdBarHeight = 0;
						if ($(this).data("statusBar").length) {
							statusdBarHeight = $(this).data("statusBar").height();
						}
						if ($(this).data("editor").parent().hasClass('fullscreen'))
							$(this).data("editor").css({
								"height": $(this).data("editor").parent().height() - ($(this).data("menuBar").height() + statusdBarHeight) - 13
							});
						else
							$(this).data("editor").css({
								"height": ""
							});
					}
				},

				'splchars': {
					"text": "S",
					"icon": "fa fa-asterisk",
					"tooltip": "Insert Special Character",
					"commandname": null,
					"custom": function (button) {
						methods.restoreIESelection.apply(this);
						var flag = 0;
						var splCharDiv = $('<div/>', {
							id: "specialchar",
							class: "specialCntr",
							css: {
								"display": "none"
							}
						}).click(function (event) {
							event.stopPropagation();
						});
						var splCharUi = $('<ul />', {
							id: "special_ui"
						});
						var editor_Content = this;
						if ($(this).data("editor").data("splcharsBtn")) {
							flag = 1;
							$(this).data("editor").data("splcharsBtn", null);
						} else
							$(this).data("editor").data("splcharsBtn", 1);

						if (flag == 0) {
							for (let i = 0; i < specialchars.length; i++) {
								splCharUi.append($('<li />').html(specialchars[i].text).attr('title', specialchars[i].name).mousedown(function (event) {
									event.preventDefault();
								}).click(function (event) {
									if (navigator.userAgent.match(/MSIE/i) || navigator.userAgent.match(/Windows NT.*Trident\//)) {
										var specCharHtml = $(this).html();
										methods.insertTextAtSelection.apply(this, [specCharHtml, 'html']);
									} else {
										document.execCommand('insertHTML', false, $(this).html());
									}
									$('#specialchar').remove();
									$(editor_Content).data("editor").data("splcharsBtn", null);
								}));
							}
							splCharUi.prependTo(splCharDiv);
							splCharDiv.insertAfter(button);
							$('#specialchar').slideDown('slow');
						} else
							$('#specialchar').remove();
					}
				},

				'source': {
					"text": "Source",
					"icon": "fa fa-code",
					"tooltip": "Source",
					"commandname": null,
					"custom": function (button, params) {
						methods.getSource.apply(this, [button, params]);
					}
				},
				"params": {
					"obj": null
				},
			};

			var menuGroups = {
				'texteffects': ['bold', 'italics', 'underline', 'color'],
				'aligneffects': ['l_align', 'c_align', 'r_align', 'justify'],
				'textformats': ['indent', 'outdent', 'block_quote', 'ol', 'ul'],
				'fonteffects': ['fonts', 'styles', 'font_size'],
				'actions': ['undo', 'redo'],
				'insertoptions': ['insert_link', 'unlink', 'insert_img', 'insert_table'],
				'extraeffects': ['strikeout', 'hr_line', 'splchars'],
				'advancedoptions': ['print', 'rm_format', 'select_all', 'source'],
				'screeneffects': ['togglescreen']
			};

			var settings = $.extend({
				'texteffects': true,
				'aligneffects': true,
				'textformats': true,
				'fonteffects': true,
				'actions': true,
				'insertoptions': true,
				'extraeffects': true,
				'advancedoptions': true,
				'screeneffects': true,
				'bold': true,
				'italics': true,
				'underline': true,
				'ol': true,
				'ul': true,
				'undo': true,
				'redo': true,
				'l_align': true,
				'r_align': true,
				'c_align': true,
				'justify': true,
				'insert_link': true,
				'unlink': true,
				'insert_img': true,
				'hr_line': true,
				'block_quote': true,
				'source': true,
				'strikeout': true,
				'indent': true,
				'outdent': true,
				'fonts': fonts,
				'styles': styles,
				'print': true,
				'rm_format': true,
				'status_bar': true,
				'font_size': fontsizes,
				'color': colors,
				'splchars': specialchars,
				'insert_table': true,
				'select_all': true,
				'togglescreen': true
			}, options);

			var containerDiv = $("<div/>", {
				class: "row-fluid Editor-container"
			});
			var $this = $(this).hide();
			$this.after(containerDiv);
			var menuBar = $("<div/>", {
				id: "menuBarDiv_" + $(this).attr("id"),
				class: "row-fluid line-control-menu-bar"
			}).prependTo(containerDiv);
			var editor = $("<div/>", {
				class: "Editor-editor",
				css: {
					overflow: "auto"
				},
				contenteditable: "true"
			}).appendTo(containerDiv);
			var statusBar = $("<div/>", {
				id: "statusbar_" + $(this).attr("id"),
				class: "row-fluid line-control-status-bar",
				unselectable: "on",
			}).appendTo(containerDiv);
			$(this).data("menuBar", menuBar);
			$(this).data("editor", editor);
			$(this).data("statusBar", statusBar);
			var editor_Content = this;
			if (settings.status_bar) {
				editor.keyup(function (event) {
					var wordCount = methods.getWordCount.apply(editor_Content);
					var charCount = methods.getCharCount.apply(editor_Content);
					$(editor_Content).data("statusBar").html('<div class="label">' + 'Words : ' + wordCount + '</div>');
					$(editor_Content).data("statusBar").append('<div class="label">' + 'Characters : ' + charCount + '</div>');
				});
			}


			for (var item in menuItems) {
				if (!settings[item]) { //if the display is not set to true for the button in the settings.	       		
					if (settings[item] in menuGroups) {
						for (var each in menuGroups[item]) {
							settings[each] = false;
						}
					}
					continue;
				}
				if (item in menuGroups) {
					var group = $("<div/>", {
						class: "btn-group"
					});
					for (var index = 0; index < menuGroups[item].length; index++) {
						var value = menuGroups[item][index];
						if (settings[value]) {
							var menuItem = methods.createMenuItem.apply(this, [menuItems[value], settings[value], true]);
							group.append(menuItem);
						}
						settings[value] = false;
					}
					menuBar.append(group);
				} else {
					this.menuItem = methods.createMenuItem.apply(this, [menuItems[item], settings[item], true]);
					menuBar.append(this.menuItem);
				}
			}

			//For contextmenu	       	
			$(document.body).mousedown(function (event) {
				var target = $(event.target);
				//if (!target.parents().andSelf().is('#context-menu')) { // Clicked outside
				if (!target.parents().is('#context-menu')) { // Clicked outside

					$('#context-menu').remove();
				}
				//if (!target.parents().andSelf().is('#specialchar') && (target.closest('a').html()!='<i class="fa fa-asterisk"></i>')) { //Clicked outside
				if (!target.parents().is('#specialchar') && (target.closest('a').html() != '<i class="fa fa-asterisk"></i>')) { //Clicked outside

					if ($("#specialchar").is(':visible')) {
						$(editor_Content).data("editor").data("splcharsBtn", null);
						$('#specialchar').remove();
					}
				}
				//if (!target.parents().andSelf().is('#paletteCntr') && (target.closest('a').html()!='<i class="fa fa-font"></i>')) { //Clicked outside
				if (!target.parents().is('#paletteCntr') && (target.closest('a').html() != '<i class="fa fa-font"></i>')) { //Clicked outside
					if ($("#paletteCntr").is(':visible')) {
						$(editor_Content).data("editor").data("colorBtn", null);
						$('#paletteCntr').remove();
					}
				}
			});
			editor.bind("contextmenu", function (e) {
				if ($('#context-menu').length)
					$('#context-menu').remove();
				var cMenu = $('<div/>', {
					id: "context-menu"
				}).css({
					position: "absolute",
					top: e.pageY,
					left: e.pageX,
					"z-index": 9999
				}).click(function (event) {
					event.stopPropagation();
				});
				var cMenuUl = $('<ul/>', {
					class: "dropdown-menu on",
					"role": "menu"
				});
				e.preventDefault();
				if ($(e.target).is('a')) {
					methods.createLinkContext.apply(this, [e, cMenuUl]);
					cMenuUl.appendTo(cMenu);
					cMenu.appendTo('body');
				} else if ($(e.target).is('td') || $(e.target).is("th")) {
					methods.createTableContext.apply(this, [e, cMenuUl]);
					cMenuUl.appendTo(cMenu);
					cMenu.appendTo('body');
				} else if ($(e.target).is('img')) {

					methods.createImageContext.apply(this, [e, cMenuUl]);
					cMenuUl.appendTo(cMenu);
					cMenu.appendTo('body');
				}
			});
		},
		createLinkContext: function (event, cMenuUl) {
			var cMenuli = $('<li/>').append($('<a/>', {id: "rem_link","href": "javascript:void(0)","text": "RemoveLink" }).click(function (e) {return function () {$(e.target).contents().unwrap();$('#context-menu').remove();}; // jshint ignore:line
			}(event)));
			cMenuli.appendTo(cMenuUl);

		},

		createImageContext: function (event, cMenuUl) {
			var cModalId = "imgAttribute";
			var cModalHeader = "Image Attributes";
			var imgModalBody = methods.imageAttributeWidget.apply(this, ["edit"]);
			var onSave = function () {
				var urlPattern = /(http|ftp|https):\/\/[\w-]+(\.[\w-]+)+([\w.,@?^=%&amp;:\/~+#-]*[\w@?^=%&amp;\/~+#-])?/;
				var imageAlt = $('#imgAlt').val();
				var imageTarget = $('#imgTarget').val();
				if (imageAlt == "") {
					methods.showMessage.apply(this, ["imageErrMsg", "Please enter image alternative text"]);
					return false;
				}
				if (imageTarget != "" && !imageTarget.match(urlPattern)) {
					methods.showMessage.apply(this, ["imageErrMsg", "Please enter valid url"]);
					return false;
				}
				if ($("#imgHidden").val() != "") {
					var imgId = $("#imgHidden").val();
					$("#" + imgId).attr('alt', imageAlt);
					if (imageTarget != "") {
						if ($("#wrap_" + imgId).length)
							$("#wrap_" + imgId).attr("href", imageTarget);
						else
							$("#" + imgId).wrap($('<a/>', {
								id: "wrap_" + imgId,
								href: imageTarget,
								target: "_blank"
							}));
					} else {
						if ($("#wrap_" + imgId).length)
							$("#" + imgId).unwrap();
					}
				}
				$("#imgAttribute").modal("hide");
				editorObj.data("editor").focus();
			};
			methods.createModal.apply(this, [cModalId, cModalHeader, imgModalBody, onSave]);
			var modalTrigger = $('<a/>', {
				href: "#" + cModalId,
				"text": "Image Attributes",
				"data-toggle": "modal"
			}).click(function (e) {
				return function () {
					$('#context-menu').remove();
					var stamp = (new Date()).getTime();
					$('#imgAlt').val($(e.target).closest("img").attr("alt"));
					$('#imgTarget').val('');

					if (typeof $(e.target).closest("img").attr("id") !== "undefined") {
						var identifier = $(e.target).closest("img").attr("id");
						$('#imgHidden').val(identifier);
						if ($('#wrap_' + identifier).length)
							$('#imgTarget').val($('#wrap_' + identifier).attr("href"));
						else
							$('#imgTarget').val('');
					} else {
						$(e.target).closest("img").attr("id", "img_" + stamp);
						$('#imgHidden').val("img_" + stamp);
					}

				};
			}(event));
			cMenuUl.append($('<li/>').append(modalTrigger))
				.append($('<li/>').append($('<a/>', {
					text: "Remove Image"
				}).click(
					function (e) {
						return function () {
							$('#context-menu').remove();
							$(e.target).closest("img").remove();
						};
					}(event))));
		},

		createTableContext: function (event, cMenuUl) {
			var _idSuffix = "_" + editorObj.attr("id") + "_Edt";
			var modalId = "editProperties_" + editorObj.attr("id");
			$("#" + modalId).remove();
			var modalHeader = "Table Properties";
			var tblModalBody = methods.tableWidget.apply(this, ["edit"]);
			var onSave = function () {
				var tblWidthEdt = $('#tblWidth' + _idSuffix).val();
				var tblHeightEdt = $('#tblHeight' + _idSuffix).val();
				var tblBorderEdt = $('#tblBorder' + _idSuffix).val();
				var tblAlignEdt = $('#tblAlign' + _idSuffix).val();
				var tblCellspacingEdt = $('#tblCellspacing' + _idSuffix).val();
				var tblCellpaddingEdt = $('#tblCellpadding' + _idSuffix).val();
				var tblEdtCssReg = /^auto$|^[+-]?[0-9]+\.?([0-9]+)?(px|em|ex|%|in|cm|mm|pt|pc)?$/ig;
				var tblEdtNumReg = /^[0-9]+\.?([0-9])?$/;
				if (tblWidthEdt != "" && !tblWidthEdt.match(tblEdtCssReg)) {
					methods.showMessage.apply(this, ["tblErrMsgEdt", "Please enter positive number with or without a valid CSS measurement unit (px,em,ex,%,in,cm,mm,pt,pc)"]);
					return false;
				}
				if (tblHeightEdt != "" && !tblHeightEdt.match(tblEdtCssReg)) {
					methods.showMessage.apply(this, ["tblErrMsgEdt", "Please enter positive number with or without a valid CSS measurement unit (px,em,ex,%,in,cm,mm,pt,pc)"]);
					return false;
				}
				if (tblBorderEdt != "" && !tblBorderEdt.match(tblEdtNumReg)) {
					methods.showMessage.apply(this, ["tblErrMsgEdt", "Border size must be a positive number"]);
					return false;
				}
				if (tblCellspacingEdt != "" && !tblCellspacingEdt.match(tblEdtNumReg)) {
					methods.showMessage.apply(this, ["tblErrMsgEdt", "Cell spacing must be a positive number"]);
					return false;
				}
				if (tblCellpaddingEdt != "" && !tblCellpaddingEdt.match(tblEdtNumReg)) {
					methods.showMessage.apply(this, ["tblErrMsgEdt", "Cell padding must be a positive number"]);
					return false;
				}
				$(event.target).closest('table').css('width', tblWidthEdt);
				if (tblHeightEdt != "")
					$(event.target).closest('table').css('height', tblHeightEdt);
				$(event.target).closest('table').attr('align', tblAlignEdt);
				$(event.target).closest('table').attr('border', tblBorderEdt);
				$(event.target).closest('table').attr('cellspacing', tblCellspacingEdt);
				$(event.target).closest('table').attr('cellpadding', tblCellpaddingEdt);
				$("#" + modalId).modal("hide");
				editorObj.data("editor").focus();
			};
			methods.createModal.apply(this, [modalId, modalHeader, tblModalBody, onSave]);
			var modalTrigger = $('<a/>', {
				href: "#" + modalId,
				"text": "Table Properties",
				"data-toggle": "modal"
			}).click(function (e) {
				return function () {
					var _idSuffix = "_" + editorObj.attr("id") + "_Edt";
					$('#context-menu').remove();
					$('#tblRows' + _idSuffix).val($(e.target).closest('table').prop('rows').length);
					$('#tblColumns' + _idSuffix).val($(e.target).closest('table').find('tr')[0].cells.length);
					$('#tblRows' + _idSuffix).attr('disabled', 'disabled');
					$('#tblColumns' + _idSuffix).attr('disabled', 'disabled');
					$('#tblWidth' + _idSuffix).val($(e.target).closest('table').get(0).style.width);
					$('#tblHeight' + _idSuffix).val($(e.target).closest('table').get(0).style.height);
					$('#tblAlign' + _idSuffix).val($(e.target).closest('table').attr("align"));
					$('#tblBorder' + _idSuffix).val($(e.target).closest('table').attr("border"));
					$('#tblCellspacing' + _idSuffix).val($(e.target).closest('table').attr("cellspacing"));
					$('#tblCellpadding' + _idSuffix).val($(e.target).closest('table').attr("cellpadding"));


				};
			}(event));

			cMenuUl.append($('<li/>', {
					class: "dropdown-submenu",
					css: {
						display: "block"
					}
				})
				.append($('<a/>', {
					"tabindex": "-1",
					href: "javascript:void(0)",
					"text": "Row"
				}))
				.append($('<ul/>', {
						class: "dropdown-menu"
					})
					.append($('<li/>').append($('<a/>', {
						id: "tbl_addrow",
						"href": "javascript:void(0)",
						"text": "Add Row"
					}).click(function (e) {
						return function () {
							$("#context-menu").remove();
							var selectedRow = $(e.target).closest("tr");
							var newRow = $("<tr/>");
							selectedRow.children().each(function () {
								var newColumn = $("<" + $(this).prop("nodeName") + "/>").html("&nbsp;");
								newRow.append(newColumn);
							});
							selectedRow.after(newRow);
						};
					}(event))))
					.append($('<li/>').append($('<a/>', {
						text: "Remove Row"
					}).click(
						function (e) {
							return function () {
								$('#context-menu').remove();
								$(e.target).closest("tr").remove();
							};
						}(event))))
				)).append($('<li/>', {
					class: "dropdown-submenu",
					css: {
						display: "block"
					}
				})
				.append($('<a/>', {
					"tabindex": "-1",
					href: "javascript:void(0)",
					"text": "Column"
				}))
				.append($('<ul/>', {
						class: "dropdown-menu"
					})
					.append($('<li/>').append($('<a/>', {
						id: "tbl_addcolumn",
						"href": "javascript:void(0)",
						"text": "Add Column",
					}).click(function (e) {
						return function () {
							$('#context-menu').remove();
							var selectedCell = $(e.target);
							var columnIndex = selectedCell.siblings().addBack().index(selectedCell);
							selectedCell.closest("table").find("tr").each(function () {
								var cellInSelectedColumn = $(this).children(":eq(" + columnIndex + ")");
								var newCell = $("<" + cellInSelectedColumn.prop("nodeName") + "/>").html("&nbsp;");
								cellInSelectedColumn.after(newCell);
							});
						};
					}(event))))
					.append($('<li/>').append($('<a/>', {
						text: "Remove Column"
					}).click(
						function (e) {
							return function () {
								$('#context-menu').remove();
								var selectedCell = $(e.target);
								var columnIndex = selectedCell.siblings().addBack().index(selectedCell);
								selectedCell.closest("table").find("tr").each(function () {
									$(this).children(":eq(" + columnIndex + ")").remove();
								});
							};
						}(event))))
				));
			cMenuUl.append($('<li/>').append(modalTrigger))
				.append($('<li/>', {
					class: "divider"
				}))
				.append($('<li/>').append($('<a/>', {
					text: "Remove Table"
				}).click(
					function (e) {
						return function () {
							$('#context-menu').remove();
							$(e.target).closest("table").remove();
						};
					}(event))));

		},

		createModal: function (modalId, modalHeader, modalBody, onSave) {
			//Create a Modal for the button.		
			var modalTrigger = $('<a/>', {
				href: "#" + modalId,
				role: "button",
				class: "btn btn-default",
				"data-toggle": "modal"
			});
			var modalElement = $('<div/>', {
				id: modalId,
				class: "modal fade",
				tabindex: "-1",
				role: "dialog",
				"aria-labelledby": "h3_" + modalId,
				"aria-hidden": "true"
			}).append($('<div>', {
				class: "modal-dialog"
			}).append($('<div>', {
				class: "modal-content"
			}).append($('<div>', {
				class: "modal-header"
			}).append($('<button/>', {
				type: "button",
				class: "close",
				"data-dismiss": "modal",
				"aria-hidden": "true"
			}).html('x')).append($('<h3/>', {
				id: "h3_" + modalId
			}).html(modalHeader))).append($('<div>', {
				class: "modal-body"
			}).append(modalBody)).append($('<div>', {
				class: "modal-footer"
			}).append($('<button/>', {
				type: "button",
				class: "btn btn-default",
				"data-dismiss": "modal",
				"aria-hidden": "true"
			}).html('Cancel')).append($('<button/>', {
				type: "button",
				class: "btn btn-success",
			}).html('Done').mousedown(function (e) {
				e.preventDefault();
			}).click(function (obj) {
				return function () {
					onSave.apply(obj);
				};
			}(this))))));
			modalElement.appendTo("body");
			return modalTrigger;
		},

		createMenuItem: function (itemSettings, options, returnElement) {
			//Function to perform multiple actions.supplied arguments: itemsettings-list of buttons and button options, options: options for select input, returnelement: boolean.
			//1.Create Select Options using Bootstrap Dropdown.
			//2.Create modal dialog using bootstrap options
			//3.Create menubar buttons binded with corresponding event actions
			if(typeof returnElement !== 'undefined'){
				returnElement = false;
			}

			if (itemSettings.select) {
				var menuWrapElement = $("<div/>", {
					class: "btn-group"
				});
				var menuElement = $("<ul/>", {
					class: "dropdown-menu"
				});
				menuWrapElement.append($('<a/>', {
					class: "btn btn-default dropdown-toggle",
					"data-toggle": "dropdown",
					"href": "javascript:void(0)",
					"title": itemSettings.tooltip
				}).html(itemSettings["default"]).append($("<span/>", {
					class: "caret"
				})).mousedown(function (e) {
					e.preventDefault();
				}));
				$.each(options, function (i, v) {
					var option = $('<li/>');
					$("<a/>", {
						tabindex: "-1",
						href: "javascript:void(0)",
					}).html(i).appendTo(option);

					option.click(function () {
						$(this).parent().parent().data("value", v);
						$(this).parent().parent().trigger("change");
					});
					menuElement.append(option);
				});
				var action = "change";
			} else if (itemSettings.modal) {
				this.menuWrapElement = methods.createModal.apply(this, [itemSettings.modalId, itemSettings.modalHeader, itemSettings.modalBody, itemSettings.onSave]);
				let menuElement = $("<i/>");
				if (itemSettings.icon)
					menuElement.addClass(itemSettings.icon);
				else
					menuElement.html(itemSettings.text);
				this.menuWrapElement.append(menuElement);
				this.menuWrapElement.mousedown(function (obj, methods, beforeLoad) {
					return function (e) {
						e.preventDefault();
						methods.saveSelection.apply(obj);
						if (beforeLoad) {
							beforeLoad.apply(obj);
						}
					};
				}(this, methods, itemSettings.beforeLoad));
				this.menuWrapElement.attr('title', itemSettings.tooltip);
				return this.menuWrapElement;
			} else {
				this.menuWrapElement = $("<a/>", {
					href: 'javascript:void(0)',
					class: 'btn btn-default'
				});
				this.menuElement = $("<i/>");
				if (itemSettings.icon)
					this.menuElement.addClass(itemSettings.icon);
				else
					this.menuElement.html(itemSettings.text);
				this.action = "click";
			}
			if (itemSettings.custom) {
				this.menuWrapElement.bind(this.action, (function (obj, params) {
					return function () {
						methods.saveSelection.apply(obj);
						itemSettings.custom.apply(obj, [$(this), params]);
					};
				})(this, itemSettings.params));
			} else {
				this.menuWrapElement.data("commandName", itemSettings.commandname);
				this.menuWrapElement.data("editor", $(this).data("editor"));
				this.menuWrapElement.bind(this.action, function () {
					methods.setTextFormat.apply(this);
				});
			}
			this.menuWrapElement.attr('title', itemSettings.tooltip);
			this.menuWrapElement.css('cursor', 'pointer');
			this.menuWrapElement.append(this.menuElement);
			if (returnElement)
				return this.menuWrapElement;
			$(this).data("menuBar").append(this.menuWrapElement);
		},

		setTextFormat: function () {
			//Function to run the text formatting options using execCommand.
			methods.setStyleWithCSS.apply(this);
			document.execCommand($(this).data("commandName"), false, $(this).data("value") || null);
			$(this).data("editor").focus();
			return false;
		},

		getSource: function (button, params) {
			//Function to show the html source code to the editor and toggle the text display.
			var flag = 0;
			if (button.data('state')) {
				flag = 1;
				button.data('state', null);
			} else
				button.data('state', 1);
			$(this).data("source-mode", !flag);
			var editor = $(this).data('editor');
			var content;
			if (flag == 0) { //Convert text to HTML			
				content = document.createTextNode(editor.html());
				editor.empty();
				editor.attr('contenteditable', false);
				preElement = $("<pre/>", {
					contenteditable: true
				});
				preElement.append(content);
				editor.append(preElement);
				button.parent().siblings().hide();
				button.siblings().hide();
			} else {
				var html = editor.children().first().text();
				editor.html(html);
				editor.attr('contenteditable', true);
				button.parent().siblings().show();
				button.siblings().show();
			}
		},

		countWords: function (node) {
			//Function to count the number of words recursively as the text grows in the editor.
			var count = 0;
			var textNodes = node.contents().filter(function () {
				return (this.nodeType == 3);
			});
			for (var index = 0; index < textNodes.length; index++) {
				text = textNodes[index].textContent;
				text = text.replace(/[^-\w\s]/gi, ' ');
				text = $.trim(text);
				count = count + text.split(/\s+/).length;
			}
			var childNodes = node.children().each(function () {
				count = count + methods.countWords.apply(this, [$(this)]);
			});
			return count;
		},

		countChars: function (node) {
			//Function to count the number of characters recursively as the text grows in the editor.
			var count = 0;
			var textNodes = node.contents().filter(function () {
				return (this.nodeType == 3);
			});
			for (var index = 0; index < textNodes.length; index++) {
				text = textNodes[index].textContent;
				count = count + text.length;
			}
			var childNodes = node.children().each(function () {
				count = count + methods.countChars.apply(this, [$(this)]);
			});
			return count;
		},

		getWordCount: function () {
			//Function to return the word count of the text in the editor
			return methods.countWords.apply(this, [$(this).data("editor")]);
		},

		getCharCount: function () {
			//Function to return the character count of the text in the editor
			return methods.countChars.apply(this, [$(this).data("editor")]);
		},

		rgbToHex: function (rgb) {
			//Function to convert the rgb color codes into hexadecimal code
			rgb = rgb.match(/^rgb\((\d+),\s*(\d+),\s*(\d+)\)$/);
			return "#" +
				("0" + parseInt(rgb[1], 10).toString(16)).slice(-2) +
				("0" + parseInt(rgb[2], 10).toString(16)).slice(-2) +
				("0" + parseInt(rgb[3], 10).toString(16)).slice(-2);
		},

		showMessage: function (target, message) {
			//Function to show the error message. Supplied arguments:target-div id, message-message text to be displayed.
			var errorDiv = $('<div/>', {
				class: "alert alert-danger"
			}).append($('<button/>', {
				type: "button",
				class: "close",
				"data-dismiss": "alert",
				html: "x"
			})).append($('<span/>').html(message));
			errorDiv.appendTo($('#' + target));
			setTimeout(function () {
				$('.alert').alert('close');
			}, 3000);
		},

		getText: function () {
			//Function to get the source code.
			if (!$(this).data("source-mode"))
				return $(this).data("editor").html();
			else
				return $(this).data("editor").children().first().text();
		},

		setText: function (text) {
			//Function to set the source code
			if (!$(this).data("source-mode"))
				$(this).data("editor").html(text);
			else
				$(this).data("editor").children().first().text(text);
		},

		setStyleWithCSS: function () {
			if (navigator.userAgent.match(/MSIE/i)) { //for IE10
				try {
					Editor.execCommand("styleWithCSS", 0, false);
				} catch (e) {
					try {
						Editor.execCommand("useCSS", 0, true);
					} catch (e) {
						try {
							Editor.execCommand('styleWithCSS', false, false);
						} catch (e) {}
					}
				}
			} else {
				document.execCommand("styleWithCSS", null, true);
			}
		},

	};

	$.fn.Editor = function (method) {

		if (methods[method]) {
			return methods[method].apply(this, Array.prototype.slice.call(arguments, 1));
		} else if (typeof method === 'object' || !method) {
			return methods.init.apply(this, arguments);
		} else {
			$.error('Method ' + method + ' does not exist on jQuery.Editor');
		}
	};
})(jQuery);


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