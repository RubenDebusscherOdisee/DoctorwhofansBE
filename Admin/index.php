<html>
    <head>
        <title>Administratorspanel</title>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
        <link rel="stylesheet" type="text/css" href="main.css">
        <meta name=viewport content="width=device-width, initial-scale=1.0"/>
        <script src="main.js"></script>
        <script>
            $(document).ready(function(){
                 GetPages();
                 
                });
        </script>
        

    </head>
    <body>
        <?php
            echo $_SERVER['REMOTE_USER'] 
        ?>
        <h1>Welcome administrator</h1>
        <h2>Voeg een pagina toe (uitgebreid)</h2>
        <a href="Addpage.php"><h2>Voeg content toe aan een pagina</h2></a>
        <a href="FullMap.php"><h2>Volledige map</h2></a>
        <a href="https://www.doctorwhofans.be"><h2>Terug naar de site</h2></a>

    </body>
</html>