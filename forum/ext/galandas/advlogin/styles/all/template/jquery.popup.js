/**
* 	Javascript made in Forumactif
* 	
***/

/**
* 	Impostare il cookie
**/
function my_getcookie(name)
{
	cname=name+'=';
	cpos=document.cookie.indexOf(cname);
	
	if(cpos!=-1)
	{
		cstart=cpos+cname.length;
		cend=document.cookie.indexOf(";",cstart);
		
		if(cend==-1)
		{
			cend=document.cookie.length;
		}
		
		return unescape(document.cookie.substring(cstart,cend));
	}
	
	return null;
}

/**
* 	Impostare il cookie
**/
function my_setcookie(name,value,days)
{
	if (days) {
		var date = new Date();
		date.setTime(date.getTime()+(days*365*24*60*60*1000));
		var expires = "; expires="+date.toGMTString();
	}
	else var expires = "";
	document.cookie = name+"="+value+expires+"; path=/";
}

function runLogInPopUp()
{
	var logInPopUpOffsetTop=parseInt($('#login_popup').css('top'));
	
	$('#login_popup').css('top',(logInPopUpOffsetTop+($(document).scrollTop()+logInPopUpTop-logInPopUpOffsetTop)/8)+'px');
	
	if(my_getcookie('login_popup_closed')!='1') 
	{ 
		setTimeout('runLogInPopUp()',8);
	}
}

function resize(event)
{
	var x,y;
	var minHeight=150;
	
	if(document.all)
	{
		x=window.event.clientX+document.body.scrollLeft;
		y=window.event.clientY+document.body.scrollTop;
	}
	else
	{
		x=event.clientX+window.scrollX;
		y=event.clientY+window.scrollY;
	}
	
	if(divHeight+y-mouseY<minHeight)
	{
		elem.style.height=minHeight+"px";
	}
	else
	{	
		elem.style.height=(divHeight+y-mouseY)+"px";
	}
	
	if(document.all)
	{
		window.event.cancelBubble=true;
		window.event.returnValue=false;
	}
	else 
	{ 
		event.preventDefault();
	}
}

function stopResize(event)
{
	if(document.all)
	{
		document.detachEvent("onmousemove",resize);
		document.detachEvent("onmouseup",stopResize);
	}
	else
	{
		document.removeEventListener("mousemove",resize,true);
		document.removeEventListener("mouseup",stopResize,true);
	}
}

$(function() 
{ 
	if(my_getcookie('login_popup_closed')!='1' && $('#login_popup').length > 0) 
	{
		logInPopUpLeft=Math.round(($(window).width()-logInPopUpWidth-16)/2);
		logInPopUpTop=Math.round(($(window).height()-logInPopUpHeight-16)/3);
		
		$('#login_popup').css({left:logInPopUpLeft+'px',top:logInPopUpTop+'px',width:logInPopUpWidth+'px',height:logInPopUpHeight+'px'});
		
		if(logInBackgroundClass) 
		{
			$('#login_popup_background').addClass(logInBackgroundClass).css('padding',0);
		}
		
		var logInBackgroundPadding=parseInt($('#login_popup_background').css('padding-top')||$('#login_popup').css('padding-top'))*2;
		
		$('#login_popup_background').css({width:(logInPopUpWidth-logInBackgroundPadding)+'px',height:(logInPopUpHeight-logInBackgroundPadding)+'px'});
		$('#login_popup_iframe').css('display','none');
		$('#login_popup_content').css('display','block');
		
		$('#login_popup_close').click(function()
		{
			my_setcookie('login_popup_closed','1',true);
			$('#login_popup').fadeOut('normal');
			return false;
		});
		
		$('#login_popup').fadeIn('slow');
		
		runLogInPopUp();
	}
});
