function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays*24*60*60*1000));
    var expires = "expires="+ d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

function getCookie(cname) {
    var name = cname + "=";
    var decodedCookie = decodeURIComponent(document.cookie);
    var ca = decodedCookie.split(';');
    for(var i = 0; i <ca.length; i++) {
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
    if (lang != "") {
    } else {
      setCookie("lang", "nl", 30);

    }
    
    
    
  }

  function renderpage(taal,menu){
      
    
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
        companionsophalen(taal, menu, id)
    }
    contentophalen(taal, menu);
  }


  function getSizesfromCookie(){
    $('#size').text(getCookie("size"));
    $(".col-6,.under,footer").children().each(function() {
      var size = parseInt($(this).css("font-size"));
      size = size + parseInt(getCookie("size")) + "px";
      $(this).css({
        'font-size': size
      });
    });
  }

  function rerenderpage(taal,menu){
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
        companionsophalen(taal, menu, id)
    }
    contentophalen(taal, menu);
  }

  function changelang(taal){
    $('.col-6, .under, .path').fadeOut(800);
    setCookie("lang", taal, 30);
    $('.col-6, .under, .path').empty();
    $('#overlay_background, #overlay').hide();
    rerenderpage(getCookie("lang"),menu)
    $('.col-6, .under, .path').fadeIn();

    
  }

