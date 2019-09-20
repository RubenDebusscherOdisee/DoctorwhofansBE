<div>
    <script>
        
        $(document).ready(function () {
            //getArrays();
            GetAllContent();
        });
    </script>
    <h2 id="Add">Voeg content toe aan een pagina</h2>
    <form autocomplete="off" style="float:right;margin-top:-3em;">
        <div class="autocomplete" style="width:300px;">
            <select id="LANG">
                <option val=NL>NL</option>
                <option val=ENG>ENG</option>
            </select>
            <input id="Page" type="text" name="Page" placeholder="Page" style="width:100%">
            
        </div>
        <button role="button" class="btn btn-primary" onclick="GetContent()">Vraag de Items op</button>
        <button type="button" class="btn btn-primary" data-toggle="modal" onclick="populateForNewRecord()" data-target="#myModal">
            Add new
        </button>
    </form>
    <div id="AddContent">

    </div>

    <div class="modal" id="myModal">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Edit or add an item</h4>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <span id="A_ID"></span>
                    <form autocomplete="off">
                        <div class="autocomplete">
                            <label for="A_Pagina">Pagina: </label>
                            <input id="A_Pagina" type="text" name="A_Pagina">
                            <label for="A_Pagina_Type">Pagina type: </label>
                            <select id="A_Pagina_Type"></select>
                            <label for="A_Type">Type item: </label>
                            <input type=text id="A_Type"/>
                            <label for="A_Taal">Taal: </label>
                            <select id="A_Taal"></select>
                            
                        </div>
                    
                        <div class="autocomplete">
                            <label for="A_Actief">Actief: </label>
                            <select id="A_Actief"></select>
                            <label for="A_Level">Level: </label>
                            <input id="A_Level" type="number" name="A_Level">
                            <label for="A_Klasse">Klasse: </label>
                            <input id="A_Klasse" type="text" name="A_Klasse">
                            <label for="A_Hoort_Bij">Hoort bij: </label>
                            <select id="A_Hoort_Bij"></select>
                        </div>
                        <textarea id="A_Waarde"></textarea>
                    </form>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" id="Add_Button" class="btn btn-success" data-dismiss="modal" onclick="AddContent()">Add new Item</button>
                    <button type="button" id="Update_Button" class="btn btn-success" data-dismiss="modal" onclick="UpdateRecord()">Update Item</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>

            </div>
        </div>
    </div>

</div>
<script>
    autocomplete(document.getElementById("Page"), Pagina_Array);
    autocomplete(document.getElementById("A_Pagina"), Pagina_Array);
    autocomplete(document.getElementById("A_Klasse"), Klassen_Array);
    autocomplete(document.getElementById("A_Type"), Types_Array);




</script>
</div>