<html>
    <head>
        <title>Administratorspanel</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
        <link rel="stylesheet" type="text/css" href="main.css">
        <!-- Latest compiled JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
        <meta name=viewport content="width=device-width, initial-scale=1.0"/>
        <script src="main.js"></script>
        <script src="Fields.js"></script>
        <script src="Quotes.js"></script>


        <script>
            CurrentUser = "<?php echo $_SERVER['REMOTE_USER'] ;?>";
            CurrentIP = "<?php echo $_SERVER['REMOTE_ADDR'] ;?>";
            $(document).ready(function(){
                getArrays();
                 
                });
        </script>
        

    </head>
    <body>
        <header>
            <img src="../images/gallifreyan_black.png" alt="Logo" class="logo"/>
            <h1 class="inline_titel">Admin Panel</h1>
        </header>
        <nav>
            <a href="index.php?menu=AddContent">Voeg content toe aan een pagina</a>
            <a href="index.php?menu=FullMap">Volledige map</a>
            <a href="index.php?menu=CheckPage">Kijk of pagina bestaat/Kijk of paina voorkomt in content</a>
            <a href="index.php?menu=Addpagina">Voeg een pagina toe</a>
            <a href="index.php?menu=Quotes">Manage Quotes</a>
            <a href="https://discord.gg/d7jBgTx">Join the discord server</a>
        </nav>
        <article>
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
                case 'Quotes':
                    require("Quotes.php");break;
                default:
                    require("FullMap.php");break;
            }
        ?>
        </article>   
    </body>
</html>