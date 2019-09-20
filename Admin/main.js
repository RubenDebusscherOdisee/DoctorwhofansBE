
var LINK_ARRAY = [];
var LINK_Short = [];
var uniquelinks = [];
var vals = [];
var elements = [];
var ids;
var CurrentUser;
var CurrentIP;
var result = [];
var LogItem = {};
var Id =0;

/**
 * @todo allow users to add new values to the records
 * @body allow users to make for example a new page type and notify someone with access to the files over discord in order to add this to the handling file.
 */

function addNewItem(){}


function CreateTable() {
    $('#AddContent').prepend('<div class="table-responsive"><table class="table" id="Content"></table></div>');
    $('#Content').append('<tr><th>ID</th><th>Waarde</th><th>Actie</th></tr>');
}


//Voeg deze functie om de tel uit
function getNextId() {
    $.ajax({
        type: "POST",
        url: "PHP/GetID.php",
        dataType: 'json'
    }).done(
        function (resultaat) {
             Id= resultaat.data[0].A_ID; 
        }).fail(function (response, statusText, xhr) {
            console.log("Fout : " + statusText);
        }).always(function () {
        })

}





function LogInput() {
    LogItem.User = CurrentUser;
    LogItem.IP = CurrentIP;
    LogItem.Record = Id+1;

    $.ajax({
        type: "POST",
        url: "https://www.doctorwhofans.be/Admin/PHP/Content/Add/AddContentLog.php",
        dataType: 'json',
        data: LogItem
    }).done(function (resultaat) {

    }).fail(function (response, statusText, xhr) { }).always(function () { });

}

function VoegPaginaToe() {
    event.preventDefault();
    var content = {}
    content.parent = $('#selectie').val();
    content.Naam = $('#Naam').val();
    content.pagina = $('#Pagina').val();
    $.ajax({
        type: "POST",
        url: "PHP/Voegpaginatoe.php",
        dataType: 'json',
        data: content,
        crossDomain: true
    }).done(
        function (resultaat) {
            //update de parent

        }).fail(function (response, statusText, xhr) {
            console.log("Fout : " + statusText);
        }).always(function () {

        })
    $.ajax({
        type: "POST",
        url: "PHP/UpdateParent.php",
        dataType: 'json',
        data: content,
        crossDomain: true
    }).done(
        function (resultaat) {
            //haal de items op
        }).fail(function (response, statusText, xhr) {
            console.log("Fout : " + statusText);
        }).always(function () {

        })
    $("#selectie").empty();
    GetPagesasselect();
    $('input').val('');
}

function AddContent() {
    var content = {};
    event.preventDefault();
    content.Pagina = $('#A_Pagina').val();
    content.TypePagina = $('#A_Pagina_Type').val();
    content.Type = $('#A_Type').val();
    content.Waarde = $('#A_Waarde').val();
    content.Taal = $('#A_Taal').val();
    content.Level = $('#A_Level').val();
    content.Klasse = $('#A_Klasse').val();
    content.IDHB = $('#A_Hoort_Bij').val();
    content.Actief=$('#A_Actief').val();
    if(CurrentUser!='Admin' && content.Actief==1){
        content.Actief=2;
    }

    $.ajax({
        type: "POST",
        url: "https://www.doctorwhofans.be/Admin/PHP/Content/Add/AddContent.php",
        dataType: 'json',
        data: content
    }).done(function (resultaat) {
        LogInput();
        GetContent();

    }).fail(function (response, statusText, xhr) { }).always(function () { });



}

function GetListLinks() {
    $.ajax({
        type: "POST",
        url: "PHP/ListLinks.php",
        dataType: 'json'
    }).done(
        function (resultaat) {
            var i;
            for (i = 0; i < resultaat.data.length; i += 1) {
                $('#Links').append("<li>" + resultaat.data[i].A_Waarde + "</li>");
            }
        }).fail(function (response, statusText, xhr) {
            console.log("Fout : " + statusText);
        }).always(function () {

            var links = document.getElementsByTagName("a");
            for (var i = 0; i < links.length; i++) {
                if (links[i].text.includes("?") === false) {
                    LINK_ARRAY.push(links[i].href);
                }

            }
            for (var j = 0; j < LINK_ARRAY.length; j++) {
                if (LINK_ARRAY[j].includes("?") === false && LINK_ARRAY[j].includes("doctorwhofans.be") === true && LINK_ARRAY[j].includes("API") === false && LINK_ARRAY[j].includes("Admin") === false && LINK_ARRAY[j].includes("mailto") === false) {
                    LINK_Short.push(LINK_ARRAY[j].substr(29, LINK_ARRAY[j].length - 30));
                }
            }
            $.each(LINK_Short, function (i, el) {
                if ($.inArray(el, uniquelinks) === -1) {
                    uniquelinks.push(el);
                }
            });
            for (i = 0; i < uniquelinks.length; i++) {
                $("#items").append("<li class='" + uniquelinks[i] + "'>" + uniquelinks[i] + "</li>");
                //Maak alle pagina's die voorkomen in content rood (dus een verwijzing van pagina a naar b, waar b de bewuste pagina is)
                //Item  First_Doctor wordt rood als ergens in de content naar deze pagina gelinkt wordt.
                //goal:alles rood
                $("#" + uniquelinks[i]).css('background-color', 'red');
            }
            $('#Links').remove();
            ids = $('.item').map(function (index) {
                // this callback function will be called once for each matching element
                return this.id;
            });
            for (i = 0; i < ids.length; i++) {
                //Maak alle links die ergens in de content voorkomen groen, de witte komen nog niet voor in de index van alle pagina's
                //Maak dus een pagina aan voor deze items
                //goal:alles groen
                //$("#items").append("<li class='"+uniquelinks[i]+"'>"+uniquelinks[i]+"</li>");
                $("." + ids[i]).css('display', 'none');
            }
        })
}

function GetPagesasselect() {
    $.ajax({
        type: "POST",
        url: "PHP/GetpagesAsselect.php",
        dataType: 'json',
        cache: false
    }).done(
        function (resultaat) {
            var i;
            for (i = 0; i < resultaat.data.length; i += 1) {
                $('#selectie').append("<option value=" + resultaat.data[i].id + ">" + resultaat.data[i].treeitem + "(" + resultaat.data[i].link + ")</option>");
            }
        }).fail(function (response, statusText, xhr) {
            console.log("Fout : " + statusText);
        }).always(function () {

        })
}
function GetContent() {
    event.preventDefault();
    $('#Content').remove();
    CreateTable();
    var data = {};

    data.Pagina = $('#Page').val();
    if ($('#Page').val()==""){
        data.Pagina=$('#A_Pagina').val();
    }else if($('#A_Pagina').val()==""&& $('#Page').val()==""){
        GetAllContent();
        return;
    }
    data.LANG=$('#LANG').val()
    $.ajax({
        type: "POST",
        url: "PHP/Content/Get/Content.php",
        dataType: 'json',
        data: data
    }).done(
        function (resultaat) {
            populateTable(resultaat);

        }).fail(function (response, statusText, xhr) {
            console.log("Fout : " + statusText);
        }).always(function () {
            //CreateFields();
            //$("#PageToAdd").val($('#Page').val());
        })
}


function populateTable(resultaat) {
    result = resultaat;
    var i;
    for (i = 0; i < resultaat.data.length; i += 1) {
        var row = "";
        row += "<td class='IDItem'>" + resultaat.data[i].A_ID + "</td>";
        row += "<td class='WItem'><textarea disabled>" + resultaat.data[i].A_Waarde + "</textarea></td>";
        row += '<td><button type="button" onclick="populateFields('+i+')" class="btn btn-primary" data-toggle="modal" data-target="#myModal">Edit</button></td>';
        if (resultaat.data[i].A_Actief == 0) {
            $('#Content').append("<tr class='NONACTIEF'>" + row + "<tr>");
        } else {
            $('#Content').append("<tr>" + row + "<tr>");
        }
    }
}
function GetAllContent() {
    CreateTable();
    $.ajax({
        type: "GET",
        url: "PHP/Content/Get/All.php",
        dataType: 'json'
    }).done(function (resultaat) {
        populateTable(resultaat);

    }).fail(function (response, statusText, xhr) {
        console.log("Fout : " + statusText);
    }).always(function () {

    });
}

function GetMissingpages() {
    $.ajax({
        type: "GET",
        url: "PHP/Titles.php",
        dataType: 'json',
        cache: false
    }).done(
        function (resultaat) {
            var i;
            for (i = 0; i < resultaat.data.length; i += 1) {
                $("#" + resultaat.data[i].link).css("background-color", "lightsteelblue");



            }
        }).fail(function (response, statusText, xhr) {
            console.log("Fout : " + statusText);
        }).always(function () {

        });
}
function autocomplete(inp, arr) {
    var currentFocus;
    /*execute a function when someone writes in the text field:*/
    inp.addEventListener("input", function (e) {
        var a, b, i, val = this.value;
        /*close any already open lists of autocompleted values*/
        closeAllLists();
        if (!val) { return false; }
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
                b.addEventListener("click", function (e) {
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
    inp.addEventListener("keydown", function (e) {
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
    document.addEventListener("click", function (e) {
        closeAllLists(e.target);
    });
}