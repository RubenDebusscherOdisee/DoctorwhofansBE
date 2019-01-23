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
        <h1>Voeg een pagina toe (uitgebreid)</h1>
        <a href="index.php?menu=AddContent">Voeg content toe aan een pagina</a>
        <a href="index.php?menu=FullMap">Volledige map</a>
        <a href="index.php?menu=CheckPage">Kijk of pagina bestaat/Kijk of paina voorkomt in content</a>
        <a href="index.php?menu=Addpagina">Voeg een pagina toe</a>
        <a href="https://discord.gg/d7jBgTx">Join the discord server</a>
        <?php
            switch($_GET['menu']){
                case 'AddContent':
                    require("Addpage.php");break;
                case 'FullMap':
                    require("FullMap.php");break;
                case 'CheckPage':
                    require("CheckIfPageExists.php");break;
                case 'Addpagina':
                    require("addpagina.php");break;
                default:
                    require("FullMap.php");break;
            }
        ?>
    </body>
</html>