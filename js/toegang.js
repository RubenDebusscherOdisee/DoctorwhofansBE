"use strict";
var siz;
function addAcces(){
    
        event.preventdefault;

            $('.link').addClass('toegankelijk')
            //$('*').addClass('toegankelijk');
            //$('body').addClass('toegankelijk');
            $('footer').addClass('toegankelijk').contents().addClass('toegankelijk');
            $('.col-6').addClass('toegankelijk').contents().addClass('toegankelijk');
            $('.link').addClass('toegankelijk');
            $('.setting').addClass('toegankelijk');
            $('#toegang').addClass('hide');
            $('#toegangRemove').removeClass('hide');
            $('*').addClass('toegankelijk');
        
    }
    
function removeAccess(){
    $('.link').removeClass('toegankelijk')
            //$('*').addClass('toegankelijk');
            //$('body').addClass('toegankelijk');
            $('footer').removeClass('toegankelijk').contents().removeClass('toegankelijk');
            $('.col-6').removeClass('toegankelijk').contents().removeClass('toegankelijk');
            $('.link').removeClass('toegankelijk');
            $('.setting').removeClass('toegankelijk');
             $('#toegang').removeClass('hide');
            $('#toegangRemove').addClass('hide');
            $('*').removeClass('toegankelijk');
            
}

window.addEventListener("afterprint", Closeprint);

function Closeprint(){
  $('nav').show();
  $('.path').show();
  $('.access').show();
  $('footer').show();
  $('.back-to-top').show();
  $('#WikiDetails').css("max-width","21%");
  $('#WikiDetails').css("width","21%");
  $('#WikiDetails').css("margin-top","-5em");
  $('#Inhoud').css("width","max-content");
  $('body').removeClass('print');


}

$("BODY")[0].onbeforeprint = function() {printContent()};
function printContent(){
  $('nav').hide();
  $('.path').hide();
  $('.access').hide();
  $('footer').hide();
  $('.back-to-top').hide();
  $('#WikiDetails').css("max-width","100%");

  $('#WikiDetails').css("width","100%");
  $('#WikiDetails').css("margin-top","1em");
  $('#Inhoud').css("width","100%");
  $('body').addClass('print');





}


function RemoveImg(){
    $('img').hide();
    $('#RestoreImages').removeClass('hide');
    $('#RemoveImages').addClass('hide');
}
function RestoreImg(){
    $('img').show();
    $('#RestoreImages').addClass('hide');
    $('#RemoveImages').removeClass('hide');
}
$(function() {
    $("#increase").click(function() {
      siz = parseInt($('#size').text());
      siz+=1;
      $('#size').text(siz);
      setCookie("size",siz,30);
      $(".col-6,.col-6 div,.under,footer").find("p,span,li,h1,h2,h3,h4,h5,h6,a,div").each(function() {
        var size = parseInt($(this).css("font-size"));
        size = size + 1 + "px";
        $(this).css({
          'font-size': size
        });
      });
    });

  });
  $(function() {
    $("#decrease").click(function() {
      siz = parseInt($('#size').text());
      siz-=1;
      $('#size').text(siz);
      setCookie("size",siz,30);
      $(".col-6,.col-6 div,.under,footer").find("p,span,li,h1,h2,h3,h4,h5,h6,a,div").each(function() {
        var size = parseInt($(this).css("font-size"));
        size = size - 1 + "px";
        $(this).css({
          'font-size': size
        });
      });
    });
  });

  

  