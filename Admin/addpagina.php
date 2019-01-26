<div>
    <h1>Voeg een pagina toe</h1>
    <script>
        $(document).ready(function() {
            GetPagesasselect();
        });

        
    </script>
    <form>
        <select id="selectie" size="10"></select>
        <label for="Naam">Naam: </label>
        <input type="text" id="Naam" />
        <label for="Pagina">Pagina: </label>
        <input type="text" id="Pagina" />
        <button role="button" onclick="VoegPaginaToe()" style="display: block; margin: 0 auto;width:20%">Voeg pagina toe</button>
    </form>

</div>