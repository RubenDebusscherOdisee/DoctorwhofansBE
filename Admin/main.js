var P_Array=[];
var T_Array=[];
var PT_Array=[];
var K_Array=[];
var AZA_Array=[];
var LINK_ARRAY = [];var LINK_Short=[];var uniquelinks = [];var vals=[];var elements=[];var ids;

var CurrentUser;
var CurrentIP;
function CreateTable(){
    $('#AddContent').prepend('<table id="Content"></table>');
    $('#Content').append('<tr><td>ID</td><td>Pagina</td><td>Type Pagina</td><td>Type Item</td><td>Waarde</td><td>Taal</td><td>Klasse</td><td>Hoort bij welk record?</td></tr>');
}
function GetImagesWithOutAlt(){
    $.ajax({
		type: "POST",
		url: "PHP/GetImagesWithoutAlt.php",
		dataType: 'json'
	}).done(
		function(resultaat) {
		    if (resultaat.data.length==0){
		        AZA_Array.push("Geen afbeeldingen zonder tekst gevonden");
		    }else{
		        var i;
			    for (i = 0; i < resultaat.data.length; i += 1) {
			        AZA_Array.push(resultaat.data[i].A.A_ID);
                }
		    }
	
		}).fail(function(response, statusText, xhr) {
		console.log("Fout : " + statusText);
	}).always(function() {
		console.log("Content Opgehaald");
	});
}
//Voeg deze functie om de tel uit
function getNextId(){
        $.ajax({
		type: "POST",
		url: "PHP/GetID.php",
		dataType: 'json'	}).done(
		function(resultaat) {
			var i;
			var nextID;
			for (i = 0; i < resultaat.data.length; i += 1) {
			    nextID = resultaat.data[i].A_ID +=1;
	            $('#nextID').val(nextID);
				
			}
		}).fail(function(response, statusText, xhr) {
		console.log("Fout : " + statusText);
	}).always(function() {
		console.log("Content Opgehaald");
	})
    
}
function LogInput(){
    var LogItem={};
    LogItem.User=CurrentUser;
    LogItem.IP=CurrentIP;
    LogItem.Record=$('#nextID').val();
    
       $.ajax({
    		type: "POST",
    		url: "https://www.doctorwhofans.be/Admin/PHP/AddLog.php",
    		dataType: 'json',
    		data:LogItem
    	}).done(function(resultaat) {
    	    console.log("Log added");

    	}).fail(function(response, statusText, xhr) {
    	}).always(function() {
    	});
    
}
function AddContent(){
    var content={};
    event.preventDefault();
    content.Pagina=$('#PageToAdd').val();
    content.TypePagina=$('#TypePagina').val();
    content.Type =$('#Type').val();
    content.Waarde =$('#Waarde').val();
    content.Taal = $('#Taal').val();
    content.Klasse = $('#Klasse').val();
    content.IDHB = $('#IDHB').val();
    
    $.ajax({
    		type: "POST",
    		url: "https://www.doctorwhofans.be/Admin/PHP/AddContent.php",
    		dataType: 'json',
    		data:content
    	}).done(function(resultaat) {
    	    LogInput();
    	    GetContent();

    	}).fail(function(response, statusText, xhr) {
    	}).always(function() {
    	});
    
    

}
function GetListLinks(){
    $.ajax({
        type: "POST",
        url: "PHP/ListLinks.php",
        dataType: 'json'
    }).done(
        function(resultaat) {
            var i;
            for (i = 0; i < resultaat.data.length; i += 1) {
                $('#Links').append("<li>"+resultaat.data[i].A_Waarde+"</li>");
            }
    }).fail(function(response, statusText, xhr) {
        console.log("Fout : " + statusText);
    }).always(function() {
        console.log("Content Opgehaald");
        var links = document.getElementsByTagName("a");
        for(var i=0; i<links.length; i++) {
            if(links[i].text.includes("?")===false){
                LINK_ARRAY.push(links[i].href);
            }
            
        }
        for (var j = 0; j < LINK_ARRAY.length; j++){
            if(LINK_ARRAY[j].includes("?")===false && LINK_ARRAY[j].includes("doctorwhofans.be")===true && LINK_ARRAY[j].includes("API")===false){
                LINK_Short.push(LINK_ARRAY[j].substr(29, LINK_ARRAY[j].length-30));
            }
        }
        $.each(LINK_Short, function(i, el){
            if($.inArray(el, uniquelinks) === -1){
                uniquelinks.push(el);
            }
        });
        for (i = 0; i < uniquelinks.length; i++){
            $("#items").append("<li class='"+uniquelinks[i]+"'>"+uniquelinks[i]+"</li>");
            //Maak alle pagina's die voorkomen in content rood (dus een verwijzing van pagina a naar b, waar b de bewuste pagina is)
            //Item  First_Doctor wordt rood als ergens in de content naar deze pagina gelinkt wordt.
            //goal:alles rood
            $("#"+uniquelinks[i]).css('background-color','red');
        }
        $('#Links').remove();
        ids = $('.item').map(function(index) {
            // this callback function will be called once for each matching element
            return this.id; 
        });
        for (i = 0; i < ids.length; i++){
            //Maak alle links die ergens in de content voorkomen groen, de witte komen nog niet voor in de index van alle pagina's
            //Maak dus een pagina aan voor deze items
            //goal:alles groen
            //$("#items").append("<li class='"+uniquelinks[i]+"'>"+uniquelinks[i]+"</li>");
            $("."+ids[i]).css('display','none');
        }
    })
}






function GetPagesasselect(){
    $.ajax({
        type: "POST",
        url: "PHP/GetpagesAsselect.php",
        dataType: 'json'
    }).done(
        function(resultaat) {
            var i;
            for (i = 0; i < resultaat.data.length; i += 1) {
                $('#selectie').append("<option value="+resultaat.data[i].id+">"+resultaat.data[i].treeitem+"</option>");
            }
    }).fail(function(response, statusText, xhr) {
        console.log("Fout : " + statusText);
    }).always(function() {
    
    })
}
//Kijk elke seconde na of het aantal items hetzelfde is (uitbreiding: kijk na of de inhoud van het object hetzelfde is) zo nee, laat gebruiker weten dat er nieuwe content is en haal die op
function GetContent(){
    event.preventDefault();
    $('#Content').remove();
    CreateTable();
    var data={};
   data.Pagina=$('#Page').val();
    $.ajax({
		type: "POST",
		url: "PHP/Content.php",
		dataType: 'json',
		data:data
	}).done(
		function(resultaat) {
			var i;
			for (i = 0; i < resultaat.data.length; i += 1) {
			    var row="";
			    row+="<td class='IDItem'>"+resultaat.data[i].A_ID+"</td>";
			    row+="<td class='PageItem'>"+resultaat.data[i].A_Pagina+"</td>";
			    row+="<td class='PTItem'>"+resultaat.data[i].A_Pagina_Type+"</td>";
			    row+="<td class='TItem'>"+resultaat.data[i].A_Type+"</td>";
			    row+="<td class='WItem'><textarea disabled>"+resultaat.data[i].A_Waarde+"</textarea></td>";
			    row+="<td class='TAItem'>"+resultaat.data[i].A_Taal+"</td>";
			    row+="<td>"+resultaat.data[i].A_Klasse+"</td><td>"+resultaat.data[i].A_Hoort_Bij+"</td>";
			    if(resultaat.data[i].A_Actief==0){
			        $('#Content').append("<tr class='NONACTIEF'>"+row+"<tr>");
			    }else{
			        $('#Content').append("<tr>"+row+"<tr>");
			    }
				
				
			}
			
		}).fail(function(response, statusText, xhr) {
		console.log("Fout : " + statusText);
	}).always(function() {
		console.log("Content Opgehaald");
		CreateFields();
	    $("#PageToAdd").val($('#Page').val());
	})

    
}
function CreateFields(){
    $('#Content').append("<tr>  <td id='N_ID'></td>     <td id='N_Page'></td><td id='N_TP'></td><td id='N_TI'></td><td id='N_W'></td><td id='N_T'></td><td id='N_K'></td><td id='N_IDHB'></td><tr>");
	$('#N_ID').append('<form autocomplete="off"><div class="autocomplete"><input type="number" name="id" id="nextID" disabled></div></form>');
	$('#N_Page').append('<form autocomplete="off"><div class="autocomplete"><input type="text" name="PageToAdd" id="PageToAdd" disabled></div></form>');
	$('#N_TP').append('<form autocomplete="off"><div class="autocomplete"><input id="TypePagina" type="text" name="TypePagina" placeholder="Type Pagina"></div></form>');
	$('#N_TI').append('<form autocomplete="off"><div class="autocomplete"><input id="Type" type="text" name="Type" placeholder="Type"></div></form>');
	$('#N_W').append('<textarea id="Waarde"></textarea>');
	$('#N_T').append('<select id="Taal"><option value="null">null</option><option value="NL">NL</option><option value="ENG">ENG</option></select>');
	$('#N_K').append('<form autocomplete="off"><div class="autocomplete"><input id="Klasse" type="text" name="Klasse" placeholder="Klasse"></div></form>');
	$('#N_IDHB').append('<form autocomplete="off"><div class="autocomplete"><input id="IDHB" type="text" name="IDHB" placeholder="Id hoort bij (Alt of bijschrijft afbeelding)"></div></form>');
	autocomplete(document.getElementById("Type"), T_Array);
	autocomplete(document.getElementById("TypePagina"), PT_Array);
	autocomplete(document.getElementById("Klasse"), K_Array);
	autocomplete(document.getElementById("IDHB"), AZA_Array);
	getNextId();
}
function GetAllContent(){
        CreateTable();
    $.ajax({
		type: "GET",
		url: "PHP/All.php",
		dataType: 'json'
	}).done(
		function(resultaat) {
			var i;
			for (i = 0; i < resultaat.data.length; i += 1) {
			    var row="";
			    row+="<td class='IDItem'>"+resultaat.data[i].A_ID+"</td>";
			    row+="<td class='PageItem'>"+resultaat.data[i].A_Pagina+"</td>";
			    row+="<td class='PTItem'>"+resultaat.data[i].A_Pagina_Type+"</td>";
			    row+="<td class='TItem'>"+resultaat.data[i].A_Type+"</td>";
			    row+="<td class='WItem'><textarea disabled>"+resultaat.data[i].A_Waarde+"</textarea></td>";
			    row+="<td class='TAItem'>"+resultaat.data[i].A_Taal+"</td>";
			    row+="<td>"+resultaat.data[i].A_Klasse+"</td><td>"+resultaat.data[i].A_Hoort_Bij+"</td>";
				if(resultaat.data[i].A_Actief==0){
			        $('#Content').append("<tr class='NONACTIEF'>"+row+"<tr>");
			    }else{
			        $('#Content').append("<tr>"+row+"<tr>");
			    }	
				
			}
			CreateFields();
			//$("#PageToAdd").val(resultaat.data[resultaat.data.length].A_Pagina);
		}).fail(function(response, statusText, xhr) {
		console.log("Fout : " + statusText);
	}).always(function() {
		console.log("Content Opgehaald");
	});
}
function GetMissingpages(){
    $.ajax({
		type: "GET",
		url: "PHP/Titles.php",
		dataType: 'json'
	}).done(
		function(resultaat) {
			var i;
			for (i = 0; i < resultaat.data.length; i += 1) {
			    $("#"+resultaat.data[i].A_Pagina).css("background-color", "lightsteelblue");
				    
					
				
			}
		}).fail(function(response, statusText, xhr) {
		console.log("Fout : " + statusText);
	}).always(function() {
		console.log("Content Opgehaald");
	});
}
function GetPages(){
    $.ajax({
		type: "GET",
		url: "PHP/Pages.php",
		dataType: 'json'
	}).done(
		function(resultaat) {
			var i;
			for (i = 0; i < resultaat.data.length; i += 1) {
			    P_Array.push(resultaat.data[i].link);
				    
					
				
			}
		}).fail(function(response, statusText, xhr) {
		console.log("Fout : " + statusText);
	}).always(function() {
		console.log("Content Opgehaald");
	});
}
function GetPageTypes(){
    $.ajax({
		type: "GET",
		url: "PHP/PageTypes.php",
		dataType: 'json'
	}).done(
		function(resultaat) {
			var i;
			for (i = 0; i < resultaat.data.length; i += 1) {
			    PT_Array.push(resultaat.data[i].A_Pagina_Type);
				    
					
				
			}
		}).fail(function(response, statusText, xhr) {
		console.log("Fout : " + statusText);
	}).always(function() {
		console.log("Content Opgehaald");
	});
}
function GetKlasses(){
    $.ajax({
		type: "GET",
		url: "PHP/Klasses.php",
		dataType: 'json'
	}).done(
		function(resultaat) {
			var i;
			for (i = 0; i < resultaat.data.length; i += 1) {
			    K_Array.push(resultaat.data[i].A_Klasse);
				    
					
				
			}
		}).fail(function(response, statusText, xhr) {
		console.log("Fout : " + statusText);
	}).always(function() {
		console.log("Content Opgehaald");
	});
}
function GetTypes(){
    $.ajax({
		type: "GET",
		url: "PHP/Type.php",
		dataType: 'json'
	}).done(
		function(resultaat) {
			var i;
			for (i = 0; i < resultaat.data.length; i += 1) {
			    T_Array.push(resultaat.data[i].Type);
				    
					
				
			}
		}).fail(function(response, statusText, xhr) {
		console.log("Fout : " + statusText);
	}).always(function() {
		console.log("Content Opgehaald");
	});
}
function autocomplete(inp, arr) {
  /*the autocomplete function takes two arguments,
  the text field element and an array of possible autocompleted values:*/
  var currentFocus;
  /*execute a function when someone writes in the text field:*/
  inp.addEventListener("input", function(e) {
      var a, b, i, val = this.value;
      /*close any already open lists of autocompleted values*/
      closeAllLists();
      if (!val) { return false;}
      currentFocus = -1;
      /*create a DIV element that will contain the items (values):*/
      a = document.createElement("DIV");
      a.setAttribute("id", this.id + "autocomplete-list");
      a.setAttribute("class", "autocomplete-items");
      /*append the DIV element as a child of the autocomplete container:*/
      this.parentNode.appendChild(a);
      /*for each item in the array...*/
      for (i = 0; i < arr.length; i++) {
        /*check if the item starts with the same letters as the text field value:*/
        if (arr[i].substr(0, val.length).toUpperCase() == val.toUpperCase()) {
          /*create a DIV element for each matching element:*/
          b = document.createElement("DIV");
          /*make the matching letters bold:*/
          b.innerHTML = "<strong>" + arr[i].substr(0, val.length) + "</strong>";
          b.innerHTML += arr[i].substr(val.length);
          /*insert a input field that will hold the current array item's value:*/
          b.innerHTML += "<input type='hidden' value='" + arr[i] + "'>";
          /*execute a function when someone clicks on the item value (DIV element):*/
              b.addEventListener("click", function(e) {
              /*insert the value for the autocomplete text field:*/
              inp.value = this.getElementsByTagName("input")[0].value;
              /*close the list of autocompleted values,
              (or any other open lists of autocompleted values:*/
              closeAllLists();
          });
          a.appendChild(b);
        }
      }
  });
  /*execute a function presses a key on the keyboard:*/
  inp.addEventListener("keydown", function(e) {
      var x = document.getElementById(this.id + "autocomplete-list");
      if (x) x = x.getElementsByTagName("div");
      if (e.keyCode == 40) {
        /*If the arrow DOWN key is pressed,
        increase the currentFocus variable:*/
        currentFocus++;
        /*and and make the current item more visible:*/
        addActive(x);
      } else if (e.keyCode == 38) { //up
        /*If the arrow UP key is pressed,
        decrease the currentFocus variable:*/
        currentFocus--;
        /*and and make the current item more visible:*/
        addActive(x);
      } else if (e.keyCode == 13) {
        /*If the ENTER key is pressed, prevent the form from being submitted,*/
        e.preventDefault();
        if (currentFocus > -1) {
          /*and simulate a click on the "active" item:*/
          if (x) x[currentFocus].click();
        }
      }
  });
  function addActive(x) {
    /*a function to classify an item as "active":*/
    if (!x) return false;
    /*start by removing the "active" class on all items:*/
    removeActive(x);
    if (currentFocus >= x.length) currentFocus = 0;
    if (currentFocus < 0) currentFocus = (x.length - 1);
    /*add class "autocomplete-active":*/
    x[currentFocus].classList.add("autocomplete-active");
  }
  function removeActive(x) {
    /*a function to remove the "active" class from all autocomplete items:*/
    for (var i = 0; i < x.length; i++) {
      x[i].classList.remove("autocomplete-active");
    }
  }
  function closeAllLists(elmnt) {
    /*close all autocomplete lists in the document,
    except the one passed as an argument:*/
    var x = document.getElementsByClassName("autocomplete-items");
    for (var i = 0; i < x.length; i++) {
      if (elmnt != x[i] && elmnt != inp) {
      x[i].parentNode.removeChild(x[i]);
    }
  }
}
/*execute a function when someone clicks in the document:*/
document.addEventListener("click", function (e) {
    closeAllLists(e.target);
});
}

