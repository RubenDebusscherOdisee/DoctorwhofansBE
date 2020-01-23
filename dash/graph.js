var Chart1col=[];
var LINK_ARRAY = [];
var LINK_Short = [];
var uniquelinks = [];
var classes = [];
var md = new Remarkable({html: false,xhtmlOut: false,breaks: false,linkify: false,typographer: false,quotes: '“”‘’'});
window.onload = function () {
    buildpage();
}
function buildpage(){
    var d = new Date();
    var n = d.toLocaleTimeString();
    $('#update').html('<span class="glyphicon glyphicon-time"></span> Updating.....Last update on: '+ n);
    LINK_ARRAY = [];
    LINK_Short = [];
    uniquelinks = [];
    classes = [];
    console.log('start');
    populateChart('Chart1', 'pie', "Aantal pagina's per aantal elementen", 'aantalPagPerNElem.php');
    createTable('Second', "Pagina's zonder titel","PagesWithoutTitle.php",'False');
    createTable('Third', "Populaire tijden","Populartimes.php",'False');
    createTable('Fourth', "Elementen per pagina (rode rijen hebben een reference op een andere pagina)","elementsperPage.php",'True');


}
function highlightDate(){

    var weekdays = new Array("Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday")
    var day = new Date().getDay();
    $('#Third .'+weekdays[day]).css("backgroundColor","lightgreen");


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
            if(el=="Fourth"){
                for (var i = 1; i < col.length; i++) {
					var th = document.createElement("th");
					th.innerHTML = col[i];
					hRow.appendChild(th);
			}
            }else{
                for (var i = 0; i < col.length; i++) {
					var th = document.createElement("th");
					th.innerHTML = col[i];
					hRow.appendChild(th);
			}
            }
			
			tHead.appendChild(hRow);
			table.appendChild(tHead);
			var tBody = document.createElement("tbody");	
			for (var i = 0; i < noOfContacts; i++) {			
                var bRow = document.createElement("tr"); // CREATE ROW FOR EACH RECORD .
                if(el=="Fourth"){
                    for (var j = 1; j < col.length; j++) {
                        var td = document.createElement("td");
                        td.innerHTML = myContacts[i][col[j]];
    
                        bRow.appendChild(td);
                    }
                    
                    classes.push(myContacts[i][col[0]]);
                    bRow.className=myContacts[i][col[0]];
                    if(myContacts[i][col[3]]=="0"||myContacts[i][col[3]]==0){
                        bRow.classList.add("EMPTYPAGE");
                    }
                }else if(el=="Third"){
                    bRow.className=myContacts[i][col[0]];
                    for (var j = 0; j < col.length; j++) {
                        var td = document.createElement("td");
                        td.innerHTML = myContacts[i][col[j]];
    
                        bRow.appendChild(td);
                    }
                }else{
                    for (var j = 0; j < col.length; j++) {
                        var td = document.createElement("td");
                        td.innerHTML = myContacts[i][col[j]];
    
                        bRow.appendChild(td);
                    }
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
                rows_per_page: 10,
                box_mode:"list",
                page_options:[{text:"10",value:10},{text:"20",value:20},{text:"40",value:40},{text:"50",value:50},{text:"100",value:100},{text:"200",value:200},{text:"500",value:500},{text:"1000",value:1000}]
            }); 
        }
        GetListLinks();
        highlightDate();

   
    }
    
function GetListLinks() {
    //haal de voltallige content op
    $('#items').empty();
    $.ajax({
        type: "POST",
        url: "PHP/ListLinks.php",
        dataType: 'json',
        cache:false
    }).done(
        function (resultaat) {
            var i;
            //voeg alle content toe aan een tijdelijk element
            for (i = 0; i < resultaat.data.length; i += 1) {
                $('#Links').append("<li>" + resultaat.data[i].A_Waarde + "</li>");
            }
            //maak een object aan met alle hyperlinks
            var sourceelem = document.getElementById("Links");
            var links = sourceelem.getElementsByTagName("a");
            //loop hierdoor en voeg de juiste links toe aan neen nieuwe array dmv hun pathname
            for (var i = 0; i < links.length; i++) {
                if (links[i].pathname.includes("?") == false && links[i].pathname.includes("@") ==false && links[i].pathname.includes("/API")==false && links[i].pathname.includes("#")==false && links[i].pathname.includes(".php")==false) {
                    //verwijder de slashes van de pathname
                    LINK_ARRAY.push(links[i].pathname.split('/').join(''));
                }

            }
            //loop door het object en voeg het element toe aan een nieuwe array als dit nog niet eerder voorkwam in deze laatste
            $.each(LINK_ARRAY, function (i, elem) {
                if ($.inArray(elem, uniquelinks) === -1) {
                    uniquelinks.push(elem);
                }
            });
            
            for (var z = 0; z < uniquelinks.length; z++) {
                $("." + uniquelinks[z]).css('background-color', 'lightcoral');
            }
            
            $('#Links').empty();
            getBrokenLinks()
        }).fail(function (response, statusText, xhr) {
            console.log("Fout : " + statusText);
        }).always(function () {

            
            
            
        })
}


function resolveAfter2Seconds() {

    return new Promise(resolve => {
    setTimeout(function() {
        $("#items").empty();
        for(var i= 0;i<uniquelinks.length;i++){
            var index = classes.indexOf(uniquelinks[i]);
            if(index < 0){
                $("#items").append("<li>"+uniquelinks[i]+"</li>");
            }
        };
        if($('#items').is(':empty')){
            $("#items").append("<li>Je bent helemaal mee</li>");
        }
        resolve("slow");
        console.log("slow promise is done");
        var d = new Date();
        var n = d.toLocaleTimeString();
        $('#update').html('<span class="glyphicon glyphicon-time"></span> Last update on: '+ n);

    }, 8000)
    });
}
  
async function getBrokenLinks() {
    const result = await resolveAfter2Seconds();
    console.log(result);
}
  
