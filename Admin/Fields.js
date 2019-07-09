var Pagina_Array = [];
var Types_Array = [];
var Pagina_Types_Array = [];
var Klassen_Array = [];
var Talen_Array = [];
var Afbeeldingen_Zonder_Alt_Array = [];
var Actief_Array = [];
var ItemToUpdate={};
var Update=[];
var LogItem2 = {};

function getArrays() {
    GetPages();
    GetPageTypes();
    GetTypes();
    GetTalen();
    GetStatus();
    GetKlasses();
    GetImagesWithOutAlt();

}

function removeprevious(){
    $( "option" ).each(function( index ) {
        $("option").removeAttr("selected");
      });
}
function populateFields(item) {
    const static=result.data[item];
    var newObject = jQuery.extend(true, {}, result.data[item]);
    $('#Update_Button').show();
    $('#Add_Button').hide();
    ItemToUpdate.Id = result.data[item].A_ID;
    ItemToUpdate.Old = [];
    ItemToUpdate.Old = static;
    ItemToUpdate.New = [];
    ItemToUpdate.New = newObject;
    ItemToUpdate.User=CurrentUser;
    ItemToUpdate.IP=CurrentIP
    removeprevious();
    $('#A_ID').html("ID: " + result.data[item].A_ID);
    $("#A_Pagina").val(result.data[item].A_Pagina);
    //$("#A_Pagina_Type").val(result.data[item].A_Pagina_Type);
    $('#A_Pagina_Type option[value="' + result.data[item].A_Pagina_Type + '"]').attr('selected', 'selected');
    $('#A_Type option[value="' + result.data[item].A_Type + '"]').attr('selected', 'selected');
    $('#A_Taal option[value="' + result.data[item].A_Taal + '"]').attr('selected', 'selected');
    $('#A_Actief option[value="' + result.data[item].A_Actief + '"]').attr('selected', 'selected');
    $("#A_Waarde").val(result.data[item].A_Waarde);
    $("#A_Klasse").val(result.data[item].A_Klasse);
    $("#A_Level").val(result.data[item].A_Level);
    $("#A_Hoort_Bij").empty();
    GetImagesWithOutAlt();
    $("#A_Hoort_Bij").append("<option value=" + result.data[item].A_Hoort_Bij + ">" + result.data[item].A_Hoort_Bij + "</option>")
    $('#A_Hoort_Bij option[value="' + result.data[item].A_Hoort_Bij + '"]').attr('selected', 'selected');
    
}

function UpdateRecord(){
    ItemToUpdate.New.A_Pagina=$('#A_Pagina').val();
    ItemToUpdate.New.A_Pagina_Type=$('#A_Pagina_Type').val();
    ItemToUpdate.New.A_Type=$('#A_Type').val();
    ItemToUpdate.New.A_Taal=$('#A_Taal').val();
    ItemToUpdate.New.A_Waarde=$('#A_Waarde').val();
    ItemToUpdate.New.A_Actief=$('#A_Actief').val();
    if(CurrentUser!='Admin' && ItemToUpdate.New.A_Actief!=0){
        ItemToUpdate.New.A_Actief=2;
    }
    ItemToUpdate.New.A_Level=$('#A_Level').val();
    ItemToUpdate.New.A_Klasse=$('#A_Klasse').val();
    ItemToUpdate.New.A_Hoort_Bij=$('#A_Hoort_Bij').val();
    //TODO: on succes maak een nieuwe Ajax call die de log opmaakt
    $.ajax({
        type: "POST",
        url: "https://www.doctorwhofans.be/Admin/PHP/UpdateContent.php",
        dataType: 'json',
        crossDomain: true,
        data: ItemToUpdate.New
    }).done(function (resultaat) {
        LogUpdate();
        GetContent();

    }).fail(function (response, statusText, xhr) { }).always(function () { });

}

function LogUpdate(){
    
    LogItem2.User = CurrentUser;
    LogItem2.IP = CurrentIP;
    LogItem2.Record = ItemToUpdate.Id;
    LogItem2.Old=ItemToUpdate.Old;
    LogItem2.New=ItemToUpdate.New
    console.log(LogItem2);


    $.ajax({
        type: "POST",
        url: "https://www.doctorwhofans.be/Admin/PHP/LogUpdate.php",
        dataType: 'json',
        data: LogItem2
    }).done(function (resultaat) {

    }).fail(function (response, statusText, xhr) { }).always(function () { });

}

function populateForNewRecord() {
    id=getNextId();
    $('#Add_Button').show();
    $('#Update_Button').hide();
    removeprevious();
    $("#A_Hoort_Bij").empty();
    GetImagesWithOutAlt();
    $('#A_ID').html("ID: New record");
    $("#A_Pagina").val($("#Page").val());
    $("#A_Pagina_Type").val("");
    $("#A_Type").val("");
    $("#A_Taal").val("");
    $("#A_Actief").val("");
    $("#A_Waarde").val("");
    $("#A_Level").val("1");
    $("#A_Klasse").val("");

}

function GetPages() {
    $.ajax({
        type: "GET",
        url: "PHP/Pages.php",
        dataType: 'json'
    }).done(
        function (resultaat) {
            var i;
            for (i = 0; i < resultaat.data.length; i += 1) {
                Pagina_Array.push(resultaat.data[i].link);
            }
        }).fail(function (response, statusText, xhr) {
        console.log("Fout : " + statusText);
    }).always(function () {
    });
}

function GetPageTypes() {
    $.ajax({
        type: "GET",
        url: "PHP/PageTypes.php",
        dataType: 'json'
    }).done(
        function (resultaat) {
            var i;
            for (i = 0; i < resultaat.data.length; i += 1) {
                Pagina_Types_Array.push(resultaat.data[i].A_Pagina_Type);
                $("#A_Pagina_Type").append("<option value=" + resultaat.data[i].A_Pagina_Type + ">" + resultaat.data[i].A_Pagina_Type + "</option>")
            }
        }).fail(function (response, statusText, xhr) {
        console.log("Fout : " + statusText);
    }).always(function () {
    });
}

function GetTypes() {
    $.ajax({
        type: "GET",
        url: "PHP/Type.php",
        dataType: 'json'
    }).done(
        function (resultaat) {
            var i;
            for (i = 0; i < resultaat.data.length; i += 1) {
                Types_Array.push(resultaat.data[i].Type);
                $("#A_Type").append("<option value=" + resultaat.data[i].Type + ">" + resultaat.data[i].Type + "</option>")

            }
        }).fail(function (response, statusText, xhr) {
        console.log("Fout : " + statusText);
    }).always(function () {
    });
}

function GetTalen() {
    $.ajax({
        type: "GET",
        url: "PHP/Talen.php",
        dataType: 'json'
    }).done(
        function (resultaat) {
            var i;
            for (i = 0; i < resultaat.data.length; i += 1) {
                Talen_Array.push(resultaat.data[i].A_Taal);
                $("#A_Taal").append("<option value=" + resultaat.data[i].A_Taal + ">" + resultaat.data[i].A_Taal + "</option>")

            }
        }).fail(function (response, statusText, xhr) {
        console.log("Fout : " + statusText);
    }).always(function () {
    });
}

function GetStatus() {
    $.ajax({
        type: "GET",
        url: "PHP/Status.php",
        dataType: 'json'
    }).done(
        function (resultaat) {
            var i;
            for (i = 0; i < resultaat.data.length; i += 1) {
                Actief_Array.push(resultaat.data[i].A_Actief);
                $("#A_Actief").append("<option value=" + resultaat.data[i].A_Actief + ">" + resultaat.data[i].A_Actief + "</option>")

            }
        }).fail(function (response, statusText, xhr) {
        console.log("Fout : " + statusText);
    }).always(function () {
    });
}

function GetKlasses() {
    $.ajax({
        type: "GET",
        url: "PHP/Klasses.php",
        dataType: 'json'
    }).done(
        function (resultaat) {
            var i;
            for (i = 0; i < resultaat.data.length; i += 1) {
                Klassen_Array.push(resultaat.data[i].A_Klasse);
            }
        }).fail(function (response, statusText, xhr) {
        console.log("Fout : " + statusText);
    }).always(function () {
    });
}

function GetImagesWithOutAlt() {
    $.ajax({
        type: "POST",
        url: "PHP/GetImagesWithoutAlt.php",
        dataType: 'json'
    }).done(
        function (resultaat) {

        var i;
        for (i = 0; i < resultaat.data.length; i += 1) {
            //Afbeeldingen_Zonder_Alt_Array.push(resultaat.data[i].id1);
            $("#A_Hoort_Bij").append("<option value=" + resultaat.data[i].id1 + ">" + resultaat.data[i].id1 + " "+resultaat.data[i].Pagina+"</option>")

        }


        }).always(function () {
        $("#A_Hoort_Bij").append("<option value=''></option>")
    });
}