/**!
+-------------------------------------------------------------------------------+
|	Extension for the phpBB3 Forum Software package:	Page Scrolling			|
+-------------------------------------------------------------------------------+
|	Version:	1.4.0															|
|	Charset:	utf-8 without BOM												|
|	Date:		2018-08-14 10:00:00												|
|	License:	GNU General Public License, version 2 (GPL-2.0)					|
|	Homepage:	https://github.com/PWG-Extension/pagescrolling					|
|	Email:																		|
|	Author:		© Alexander Kadnikov [Predator]									|
+-------------------------------------------------------------------------------+
|	© «PWG», 2004-2018. All Rights Reserved.									|
+-------------------------------------------------------------------------------+
*/

	$(function()
	{
		if ($(window).scrollTop() >= "230")
			$("#ToTop").fadeIn("slow");
		$(window).scroll(function() {
			if ($(window).scrollTop() <= "230") $("#ToTop").fadeOut("slow")
			else $("#ToTop").fadeIn("slow");
		});

		if ($(window).scrollTop() <= $(document).height()-"999")
			$("#ToBottom").fadeIn("slow");

		$(window).scroll(function() {
			if ($(window).scrollTop() >= $(document).height()-"999") $("#ToBottom").fadeOut("slow")
			else $("#ToBottom").fadeIn("slow");
		});

		$("#ToTop").click(function() { $("html,body").animate({scrollTop:0},"700") })
		$("#ToBottom").click(function() { $("html,body").animate({scrollTop:$(document).height()},"700") })
	});
