"use strict";
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
}
function printContent(){
    addAcces();
    $('header').hide();
	$('nav').hide();
	$('footer').hide();
    $('.toegang').hide();
	$('.RemoveImages').hide();
	$('.path').hide();
	$('.taal_link').hide();
	$('.access fieldset').children().hide();
	$('#printClose').removeClass('hide');
	$('#printClose').show();
    $('.access').addClass("gefixeerd");



	setTimeout("window.print()", 200);
    
}

function Closeprint(){
    removeAccess();
    $('header').show();
	$('nav').show();
	$('footer').show();
    $('.toegang').show();
	$('.RemoveImages').show();
	$('.path').show();
	$('.taal_link').show();
	$('.access fieldset').children().show();
	$('#printClose').addClass('hide');
	$('#printClose').hide();
    $('.access').removeClass("gefixeerd");



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
