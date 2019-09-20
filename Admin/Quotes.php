<h2>Manage Quotes</h2>
<script>
    
    $(document).ready(function () {
        
        GetQuotes();
    });
</script>
<button type="button" class="btn btn-primary" data-toggle="modal" onclick="populateForNewQuoteRecord()" data-target="#myModal">
        Add new
    </button>
<table id="QuoteTabel">
    <tr>
        <th>ID</th>
        <th>Quote</th>
        <th>Acties</th>
    </tr>
</table>


<div class="modal" id="myModal">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Edit or add an item</h4>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <span id="Q_Id"></span>
                    <form autocomplete="off">
                        <div class="autocomplete">
                            <label for="Quote">Quote:</label>
                            <textarea id="Quote" name="Quote"></textarea>
                        </div>
                        <div class="autocomplete">
                            <label for="Personage">Personage:</label>
                            <textarea id="Personage" name="Personage"></textarea>
                            <label for="Aflevering">Aflevering:</label>
                            <input type="text" id="Aflevering" name="Aflevering">
                            <label for="QuotePic">Afbeelding:</label>
                            <input type="text" id="QuotePic" name="QuotePic">
                            <button type="button" id="Update_Image" class="btn btn-warning"  onclick="UpdateImage()">Update Image</button>
                        </div>
                        <div class="autocomplete">
                            <img src="../images/gallifreyan_black.png" id="Picture"/>
                        </div>
                        
                    </form>
                    
                    </form>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" id="Add_Button" class="btn btn-success" data-dismiss="modal" onclick="AddQuote()">Add new Item</button>
                    <button type="button" id="Update_Button" class="btn btn-success" data-dismiss="modal" onclick="UpdateQuote()">Update Item</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </button>

            </div>
        </div>
    </div>
<style>
    #QuoteTabel{width:100%}
    td{min-width: 6em;}
    #Personage{width: 17em;
    vertical-align: text-top;}
    #Picture{max-width: 40%;
    float: right;}
</style>