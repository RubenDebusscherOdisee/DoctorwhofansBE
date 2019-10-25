var Chart1col=[];
var md = new Remarkable({
    html: false, // Enable HTML tags in source
    xhtmlOut: false, // Use '/' to close single tags (<br />)
    breaks: false, // Convert '\n' in paragraphs into <br>
    linkify: false, // Autoconvert URL-like text to links

    // Enable some language-neutral replacement + quotes beautification
    typographer: false,

    // Double + single quotes replacement pairs, when typographer enabled,
    // and smartquotes on. Set doubles to '«»' for Russian, '„“' for German.
    quotes: '“”‘’'
});
window.onload = function () {

    /**
     * OPBOUW CHART 1 : Aantal pagina's per aantal elementen
     */
    buildpage();
    


}


window.setInterval(function(){
       /// call your function here
    buildpage();
    
}, 60000);


function buildpage(){
    console.log('start');
    populateChart('Chart1', 'pie', "Aantal pagina's per aantal elementen", 'aantalPagPerNElem.php');
    var header= ["Id","Titel","Pagina"];
    createTable('tab1', "Pagina's zonder titel","PagesWithoutTitle.php",header);
    var d = new Date();
    var n = d.toLocaleTimeString();
    $('#update').html('<span class="glyphicon glyphicon-time"></span> Last update on: '+ n);
}
function populateChart(el, type, tit, ur) {
    $('#'+el).parent().prev().html(tit);
    var lab = [];
    var dat = [];
    var bgc=[]
    $.ajax({
        type: "GET",
        url: ur,
        dataType: 'json',
        cache: false
    }).done(
        function (resultaat) {
            for (i = 0; i < resultaat.data.length; i += 1) {
                lab.push(resultaat.data[i].Aantal_elem);
                dat.push(resultaat.data[i].Aantal_Pag);
                if(Chart1col.length <1){
                    bgc.push('rgb(' + (Math.floor(Math.random() * 256)) + ',' + (Math.floor(Math.random() * 256)) + ',' + (Math.floor(Math.random() * 256)) + ')')
                }
                
            }
            if(Chart1col.length <1){Chart1col=bgc;}else{bgc=Chart1col;}
            var ctx = document.getElementById(el).getContext('2d');
            var chart = new Chart(ctx, {
                // The type of chart we want to create
                type: type,

                // The data for our dataset
                data: {
                    labels: lab,
                    datasets: [{
                        label: tit,
                        backgroundColor: bgc,
                        borderColor: bgc,
                        data: dat
                    }]
                },

                // Configuration options go here
                options: {}
            });

        }).fail(function (response, statusText, xhr) {}).always(function () {});


}
function createTable(el,tit,ur,header) {
    $('#'+el).parent().prev().html(tit);
    $('#'+el).html("");
    $('#'+el).html("<thead class='thead-dark'><tr></tr></thead><tbody></tbody>")
    for(var i=0;i<header.length;i++){
        $('#'+el+" thead tr").append("<th scope='col'>"+header[i]+"</th>")
    }
    $.ajax({
        type: "GET",
        url: ur,
        dataType: 'json',
        cache: false
    })
    .done(function (resultaat) {
            for (i = 0; i < resultaat.data.length; i += 1) {
                $('#'+el+" tbody").append("<tr><th scope='row'>"+resultaat.data[i].id+"</th><td>"+resultaat.data[i].topic+"</td><td>"+resultaat.data[i].link+"</td></tr>");
            }

        })
    .fail(function (response, statusText, xhr) {}).always(function () {});

}