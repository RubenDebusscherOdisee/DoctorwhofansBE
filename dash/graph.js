var Chart1col=[];
var md = new Remarkable({html: false,xhtmlOut: false,breaks: false,linkify: false,typographer: false,quotes: '“”‘’'});
window.onload = function () {
    buildpage();
}
function buildpage(){
    console.log('start');
    populateChart('Chart1', 'pie', "Aantal pagina's per aantal elementen", 'aantalPagPerNElem.php');
    createTable('Second', "Pagina's zonder titel","PagesWithoutTitle.php",'False');
    createTable('Third', "Populaire tijden","Populartimes.php",'False');
    createTable('Fourth', "Elementen per pagina","elementsperPage.php",'True');
    var d = new Date();
    var n = d.toLocaleTimeString();
    $('#update').html('<span class="glyphicon glyphicon-time"></span> Last update on: '+ n);
}
function populateChart(el, type, tit, ur) {
    $('#'+el).parent().prev().html(tit);
    var lab = [];
    var dat = [];
    var bgc=[]
    $.ajax({type: "GET",url: ur,dataType: 'json',cache: false})
    .done(
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
            var chart = new Chart(ctx, {type: type,data: {labels: lab,datasets: [{label: tit,backgroundColor: bgc,borderColor: bgc,data: dat}]},options: {}});
        }).fail(function (response, statusText, xhr) {}).always(function () {});
}
function createTable(el,tit,ur,pag) {
    $('#'+el).prev().html(tit);
    $('#'+el).html("");
    $.ajax({type: "GET",url: ur,dataType: 'json',cache: false})
    .done(function (resultaat) {
        generateDynamicTable(resultaat.data,el,pag);
        $('table').addClass("table table-striped");
    })
    .fail(function (response, statusText, xhr) {}).always(function () {});
}

function generateDynamicTable(myContacts,el,pag ){
		var noOfContacts = myContacts.length;
		if(noOfContacts>0){
			var table = document.createElement("table"); 
			var col = []; // define an empty array
			for (var i = 0; i < noOfContacts; i++) {
				for (var key in myContacts[i]) {
					if (col.indexOf(key) === -1) {
						col.push(key);
					}
				}
			}
			var tHead = document.createElement("thead");	
			var hRow = document.createElement("tr");
			for (var i = 0; i < col.length; i++) {
					var th = document.createElement("th");
					th.innerHTML = col[i];
					hRow.appendChild(th);
			}
			tHead.appendChild(hRow);
			table.appendChild(tHead);
			var tBody = document.createElement("tbody");	
			for (var i = 0; i < noOfContacts; i++) {			
                var bRow = document.createElement("tr"); // CREATE ROW FOR EACH RECORD .
                for (var j = 0; j < col.length; j++) {
                    var td = document.createElement("td");
                    td.innerHTML = myContacts[i][col[j]];
                    bRow.appendChild(td);
                }
                tBody.appendChild(bRow);
			}
			table.appendChild(tBody);				
			var divContainer = document.getElementById(el);
			divContainer.innerHTML = "";
			divContainer.appendChild(table);
        }
        if(pag=='True'){
            $('#'+el+'_Box').remove();
            $('#'+el).prepend("<div id='"+el+"_Box'></div>");
            paginator({
                table: document.getElementById(el).getElementsByTagName("table")[0],
                box:document.getElementById(el+'_Box'),
                rows_per_page: 50,
                box_mode:"list",
                page_options:[{text:"10",value:10},{text:"20",value:20},{text:"40",value:40},{text:"50",value:50},{text:"100",value:100},{text:"200",value:200},{text:"500",value:500}]
            }); 
        }   
	}