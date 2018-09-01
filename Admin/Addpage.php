<div>
    <script>
        CurrentUser = "<?php echo $_SERVER['REMOTE_USER'] ;?>";
        CurrentIP = "<?php echo $_SERVER['REMOTE_ADDR'] ;?>";
        $(document).ready(function(){
            //GetPages();
            GetPageTypes();
            GetTypes();
            GetKlasses();
            GetImagesWithOutAlt();
            GetAllContent();
        });
    </script>
    <h2 id="Add">Voeg content toe aan een pagina</h2>
    <form autocomplete="off" style="float:right;margin-top:-3em;">
        <div class="autocomplete" style="width:300px;">
            <input id="Page" type="text" name="Page" placeholder="Page" style="width:100%">
        </div>
        <button role="button" onclick="GetContent()">Vraag de Items op</button>
    </form>
    <div id="AddContent">
        <form style="margin-top:7em">
            <button role="button" onclick="AddContent()" style="display: block; margin: 0 auto;width:20%">Voeg content toe</button>
        </form>
    </div>
    <script>
        autocomplete(document.getElementById("Page"), P_Array);
    </script>
</div>