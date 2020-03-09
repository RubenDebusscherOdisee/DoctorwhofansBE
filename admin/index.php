<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>CMS</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="">
        <link rel="manifest" href="manifest.json">
        <meta name="theme-color" content="#000090"/>
        <link rel="apple-touch-icon" href="images/logo/apple-icon.png">
        <script>
            if ('serviceWorker' in navigator) {
                window.addEventListener('load', function() {
                    navigator.serviceWorker.register('/sw.js').then(function(registration) {
                    // Registration was successful
                    //console.log('ServiceWorker registration successful with scope: ', registration.scope);
                    }, function(err) {
                    // registration failed :(
                    console.error('ServiceWorker registration failed: ', err);
                    });
                });
            }
        </script>

    </head>
    <body>
        <main>
            <a href="https://admin.doctorwhofans.be/main/index.php">Main</a>
            <a href="https://admin.doctorwhofans.be/API/index.php">API</a>


        </main>
        
    </body>
</html>