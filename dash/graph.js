var Chart1col=[];
var LINK_ARRAY = [];
var LINK_Short = [];
var uniquelinks = [];
var classes = [];
var bgc=[
    "#63b598", "#ce7d78", "#ea9e70", "#a48a9e", "#c6e1e8", "#648177" ,"#0d5ac1" ,
    "#f205e6" ,"#1c0365" ,"#14a9ad" ,"#4ca2f9" ,"#a4e43f" ,"#d298e2" ,"#6119d0",
    "#d2737d" ,"#c0a43c" ,"#f2510e" ,"#651be6" ,"#79806e" ,"#61da5e" ,"#cd2f00" ,
    "#9348af" ,"#01ac53" ,"#c5a4fb" ,"#996635","#b11573" ,"#4bb473" ,"#75d89e" ,
    "#2f3f94" ,"#2f7b99" ,"#da967d" ,"#34891f" ,"#b0d87b" ,"#ca4751" ,"#7e50a8" ,
    "#c4d647" ,"#e0eeb8" ,"#11dec1" ,"#289812" ,"#566ca0" ,"#ffdbe1" ,"#2f1179" ,
    "#935b6d" ,"#916988" ,"#513d98" ,"#aead3a", "#9e6d71", "#4b5bdc", "#0cd36d",
    "#250662", "#cb5bea", "#228916", "#ac3e1b", "#df514a", "#539397", "#880977",
    "#f697c1", "#ba96ce", "#679c9d", "#c6c42c", "#5d2c52", "#48b41b", "#e1cf3b",
    "#5be4f0", "#57c4d8", "#a4d17a", "#225b8", "#be608b", "#96b00c", "#088baf",
    "#f158bf", "#e145ba", "#ee91e3", "#05d371", "#5426e0", "#4834d0", "#802234",
    "#6749e8", "#0971f0", "#8fb413", "#b2b4f0", "#c3c89d", "#c9a941", "#41d158",
    "#fb21a3", "#51aed9", "#5bb32d", "#807fb", "#21538e", "#89d534", "#d36647",
    "#7fb411", "#0023b8", "#3b8c2a", "#986b53", "#f50422", "#983f7a", "#ea24a3",
    "#79352c", "#521250", "#c79ed2", "#d6dd92", "#e33e52", "#b2be57", "#fa06ec",
    "#1bb699", "#6b2e5f", "#64820f", "#1c271", "#21538e", "#89d534", "#d36647",
    "#7fb411", "#0023b8", "#3b8c2a", "#986b53", "#f50422", "#983f7a", "#ea24a3",
    "#79352c", "#521250", "#c79ed2", "#d6dd92", "#e33e52", "#b2be57", "#fa06ec",
    "#1bb699", "#6b2e5f", "#64820f", "#1c271", "#9cb64a", "#996c48", "#9ab9b7",
    "#06e052", "#e3a481", "#0eb621", "#fc458e", "#b2db15", "#aa226d", "#792ed8",
    "#73872a", "#520d3a", "#cefcb8", "#a5b3d9", "#7d1d85", "#c4fd57", "#f1ae16",
    "#8fe22a", "#ef6e3c", "#243eeb", "#1dc18", "#dd93fd", "#3f8473", "#e7dbce",
    "#421f79", "#7a3d93", "#635f6d", "#93f2d7", "#9b5c2a", "#15b9ee", "#0f5997",
    "#409188", "#911e20", "#1350ce", "#10e5b1", "#fff4d7", "#cb2582", "#ce00be",
    "#32d5d6", "#17232", "#608572", "#c79bc2", "#00f87c", "#77772a", "#6995ba",
    "#fc6b57", "#f07815", "#8fd883", "#060e27", "#96e591", "#21d52e", "#d00043",
    "#b47162", "#1ec227", "#4f0f6f", "#1d1d58", "#947002", "#bde052", "#e08c56",
    "#28fcfd", "#bb09b", "#36486a", "#d02e29", "#1ae6db", "#3e464c", "#a84a8f",
    "#911e7e", "#3f16d9", "#0f525f", "#ac7c0a", "#b4c086", "#c9d730", "#30cc49",
    "#3d6751", "#fb4c03", "#640fc1", "#62c03e", "#d3493a", "#88aa0b", "#406df9",
    "#615af0", "#4be47", "#2a3434", "#4a543f", "#79bca0", "#a8b8d4", "#00efd4",
    "#7ad236", "#7260d8", "#1deaa7", "#06f43a", "#823c59", "#e3d94c", "#dc1c06",
    "#f53b2a", "#b46238", "#2dfff6", "#a82b89", "#1a8011", "#436a9f", "#1a806a",
    "#4cf09d", "#c188a2", "#67eb4b", "#b308d3", "#fc7e41", "#af3101", "#ff065",
    "#71b1f4", "#a2f8a5", "#e23dd0", "#d3486d", "#00f7f9", "#474893", "#3cec35",
    "#1c65cb", "#5d1d0c", "#2d7d2a", "#ff3420", "#5cdd87", "#a259a4", "#e4ac44",
    "#1bede6", "#8798a4", "#d7790f", "#b2c24f", "#de73c2", "#d70a9c", "#25b67",
    "#88e9b8", "#c2b0e2", "#86e98f", "#ae90e2", "#1a806b", "#436a9e", "#0ec0ff",
    "#f812b3", "#b17fc9", "#8d6c2f", "#d3277a", "#2ca1ae", "#9685eb", "#8a96c6",
    "#dba2e6", "#76fc1b", "#608fa4", "#20f6ba", "#07d7f6", "#dce77a", "#77ecca"];
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
    createTable('Eighth', "Populaire tijden (oude versie)","Populartimes_old.php",'False');
    createTable('Fourth', "Elementen per pagina (rode rijen hebben een reference op een andere pagina)","elementsperPage.php",'True');
    createTable('Seventh','Talen per pagina','langarrayperpage.php','True');
    createTable('Sixth','Types per pagina','typearrayperpage.php','True');



}


function highlightDate(){

    var weekdays = new Array("Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday")
    var day = new Date().getDay();
    $('#Third .'+weekdays[day]).css("backgroundColor","lightgreen");
    $('#Sixth .'+weekdays[day]).css("backgroundColor","lightgreen");



}
function populateChart(el, type, tit, ur) {
    $('#'+el).parent().prev().html(tit);
    var lab = [];
    var dat = [];
    
    $.ajax({type: "GET",url: ur,dataType: 'json',cache: false})
    .done(
        function (resultaat) {
            for (i = 0; i < resultaat.data.length; i += 1) {
                lab.push(resultaat.data[i].Aantal_elem);
                dat.push(resultaat.data[i].Aantal_Pag);
       
            }
            var ctx = document.getElementById(el).getContext('2d');
            var chart = new Chart(ctx, {type: type,data: {labels: lab,datasets: [{label: tit,backgroundColor: bgc,borderColor: bgc,data: dat}]},options: {}});
        }).fail(function (response, statusText, xhr) {}).always(function () {});
}
function createTable(el,tit,ur,pag) {
    $('#'+el).prev().html(tit);
    $('#'+el).html("");
    $.ajax({type: "GET",url: ur,dataType: 'json',cache: false})
    .done(function (resultaat) {
        if(resultaat.data =="No rows"){
            document.getElementById(el).innerHTML="<p>Je bent helemaal mee</p>";

            
        }else{
            generateDynamicTable(resultaat.data,el,pag);
            $('table').addClass("table table-striped");
        }
        
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
                }else if(el=="Third" || el=="Sixth"){
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
            //plaats hier de paginator
            $('#'+el + ' table').fancyTable({
                sortColumn:0,// column number for initial sorting
                sortOrder:'asc',
                sortable: true,
                pagination: true, // default: false
                searchable: true,
                globalSearch: true,
                pagClosest: 3,
                perPage: 20,
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
                if (links[i].href.includes("doctorwhofans")===true && links[i].pathname.includes("?") == false && links[i].pathname.includes("@") ==false && links[i].pathname.includes("/API")==false && links[i].pathname.includes("#")==false && links[i].pathname.includes(".php")==false) {
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
            $("#items").append("Je bent helemaal mee");
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
  
