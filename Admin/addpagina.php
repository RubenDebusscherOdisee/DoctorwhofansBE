<div>
    <h1>Voeg een pagina toe</h1>
    <script>
        $(document).ready(function() {
            GetPagesasselect();
        });

        
    </script>
    <form>
        <div style="width: 50%; float:left">
            <select id="selectie" size="27"></select>
            
        </div>
        <div style="width: 46%; float:right">
            <label for="Naam">Naam: </label>
            <input type="text" id="Naam" /><br>
            <label for="Pagina">Pagina: </label>
            <input type="text" id="Pagina" />
            <button role="button" onclick="VoegPaginaToe()" class="btn btn-primary">Voeg pagina toe</button>
        </div>
        
    </form>

</div>
<style scoped>
    input[type=text]{
        float: right;
    clear: both;
    margin-top: 2em;
    margin-right: 1em;
    } label{margin-top: 2em}
    .btn-primary{float: right;
    margin-top: 8em;
    margin-right: 6em;
    display: block;}
</style>