var QuoteResult
function GetQuotes(){
    $.ajax({
        type: "GET",
        url: "PHP/GetQuotes.php",
        dataType: 'json',
        cache:false
    }).done(
        function (resultaat) {
            console.log(resultaat)
            QuoteResult = resultaat;
            for (i = 0; i < resultaat.data.length; i++) {
                var quote = resultaat.data[i].Quote;
                var quote_short = quote.substring(0, 100);
                if(quote_short.indexOf('<br>') >= 0) {
                    var quote_short_zonder_enter = quote_short.substring(0, quote_short.indexOf('<br'));
                }else{var quote_short_zonder_enter = quote_short;}

                row='<tr><td>'+resultaat.data[i].id+'</td><td>'+quote_short_zonder_enter+'</td><td><button type="button" onclick="populateQuoteFields('+i+')" class="btn btn-primary" data-toggle="modal" data-target="#myModal">Edit</button></td></tr>';
                $("#QuoteTabel").append(row);
            }



            
        }).fail(function (response, statusText, xhr) {
            console.log("Fout : " + statusText);
        }).always(function () {
        })
}
function populateForNewQuoteRecord(){
    $('#Update_Button').hide();
    $('#Add_Button').show();
    $('#Q_Id').html("New Record");
    $('#Quote').html("");
    $('#Personage').html("");
    $('#Aflevering').val("");
    $('#QuotePic').val("../images/gallifreyan_black.png");
    $('#Picture').attr('src',"../images/gallifreyan_black.png");

}
function populateQuoteFields(item){
    const static=QuoteResult.data[item];
    var newObject = jQuery.extend(true, {}, QuoteResult.data[item]);
    $('#Update_Button').show();
    $('#Add_Button').hide();
    ItemToUpdate.Id = QuoteResult.data[item].id;
    ItemToUpdate.Old = [];
    ItemToUpdate.Old = static;
    ItemToUpdate.New = [];
    ItemToUpdate.New = newObject;
    ItemToUpdate.User=CurrentUser;
    ItemToUpdate.IP=CurrentIP

    $('#Q_Id').html("ID: " + QuoteResult.data[item].id);
    $('#Quote').html(QuoteResult.data[item].Quote);
    $('#Personage').html(QuoteResult.data[item].Personage);
    $('#Aflevering').val(QuoteResult.data[item].Aflevering);
    $('#QuotePic').val(QuoteResult.data[item].QuotePic);
    $('#Picture').attr('src', QuoteResult.data[item].QuotePic);
    console.log(ItemToUpdate);
    
}
function UpdateImage(){
    $('#Picture').attr('src', $('#QuotePic').val());
    
}
function UpdateQuote(){
    ItemToUpdate.New.Quote=$('#Quote').val();
    ItemToUpdate.New.Personage=$('#Personage').val();
    ItemToUpdate.New.Aflevering=$('#Aflevering').val();
    ItemToUpdate.New.QuotePic=$('#QuotePic').val();
    console.log(ItemToUpdate);
    //TODO: on succes maak een nieuwe Ajax call die de log opmaakt
    /*$.ajax({
        type: "POST",
        url: "https://www.doctorwhofans.be/Admin/PHP/UpdateQuote.php",
        dataType: 'json',
        crossDomain: true,
        data: ItemToUpdate.New
    }).done(function (resultaat) {
        Quote
        LogUpdate();
        GetQuotes();

    }).fail(function (response, statusText, xhr) { }).always(function () { });*/
}
function AddQuote(){
    var Quote = {};
    Quote.Quote = $('#Quote').val();
    Quote.Personage = $('#Personage').val();
    Quote.Aflevering = $('#Aflevering').val();
    Quote.QuotePic = $('#QuotePic').val();
    $.ajax({
        type: "POST",
        url: "PHP/AddQuote.php",
        dataType: 'json',
        data: Quote
    }).done(function (resultaat) {
        QuoteLogInput();
        console.log("done");
        GetQuotes();


    }).fail(function (response, statusText, xhr) { }).always(function () { });

}

function QuoteLogInput() {
    LogItem.User = CurrentUser;
    LogItem.IP = CurrentIP;

    $.ajax({
        type: "POST",
        url: "PHP/QuoteAddLog.php",
        dataType: 'json',
        data: LogItem
    }).done(function (resultaat) {

    }).fail(function (response, statusText, xhr) { }).always(function () { });

}