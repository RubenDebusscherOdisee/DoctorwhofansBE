<?php
session_start();

if ($_SESSION["user"] == "") {
  header("Location: welcome.php");
}
?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8" />
  <title>Welcome to DWF BE Dashboard</title>
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
  <link rel="stylesheet" type="text/css" href="opmaak.css" />

  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css" />

  <!-- jQuery library -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

  <!-- Latest compiled JavaScript -->
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>

  <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
  <script src="https://cdn.jsdelivr.net/remarkable/1.7.1/remarkable.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.3.1.min.js" 
        integrity="sha384-tsQFqpEReu7ZLhBV2VZlAu7zcOV+rXbYlF2cqB8txI/8aZajjp4Bqd+V6D5IgvKT" 
        crossorigin="anonymous">
</script>
<script src="fancyTable.min.js"></script>

  <script type="text/javascript" src="graph.js"></script>
</head>

<body>
  <nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container-fluid">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <span class="navbar-brand"><?php echo $_SESSION["user"]; ?></span>
        
      </div>
      <div class="collapse navbar-collapse" id="myNavbar">
        <ul class="nav navbar-nav nav-tabs">
          <li class="active"><a data-toggle="tab" href="#home">Home</a></li>
          <li><a data-toggle="tab" href="#menu1">Menu</a></li>
          <li><a data-toggle="tab" href="#menu2">Menu</a></li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
          <li>
            <a href="#" onClick="buildpage();"><span class="glyphicon glyphicon-refresh"></span> Refresh</a>
          </li>
          <li><span id="update"></span></li>
          <li>
            <a href="logout.php"><span class="glyphicon glyphicon-log-in"></span> Log out</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  

  <div class="tab-content">
    <div id="home" class="tab-pane fade in active">
      <div class="row">
        <div class="col-6 col-md-8">
          <div class="panel panel-default">
            <div class="panel-heading" data-toggle="collapse" data-target="#First">
              Panel Heading
            </div>
            <div class="panel-body collapse in" id="First">
              <canvas id="Chart1"></canvas>
              <div id="chartjs-tooltip"></div>
            </div>
          </div>
        </div>
        <div class="col-6 col-md-4">
          <div class="panel panel-default">
            <div class="panel-heading" data-toggle="collapse" data-target="#Second">
              Panel Heading
            </div>

            <div class="panel-body collapse in" id="Second">
              <table id="tab1" class="table  table-striped"></table>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div id="menu1" class="tab-pane fade">
      <div class='row'>
        <div class="col-6 col-md-4">
          <div class="panel panel-default">
            <div class="panel-heading" data-toggle="collapse" data-target="#Fourth">
              Panel Heading
            </div>

            <div class="panel-body collapse in" id="Fourth"></div>
          </div>
        </div>
        <div class="col-6 col-md-4">
          <div class="panel panel-default">
            <div class="panel-heading" data-toggle="collapse" data-target="#Third">
              Panel Heading
            </div>
            <div class="panel-body collapse in" id="Third">
              <table id="tab2" class="table table-striped"></table>
            </div>
          </div>
        </div>
        <div class="col-6 col-md-4">
          <div class="panel panel-default">
            <div class="panel-heading" data-toggle="collapse" data-target="#Eighth">
              Panel Heading
            </div>

            <div class="panel-body collapse in" id="Eighth"></div>
          </div>
        </div>
      </div>
      <div class='row'>
        <div class="col-6 col-md-6">
          <div class="panel panel-default">
            <div class="panel-heading" data-toggle="collapse" data-target="#Seventh">
              Panel Heading
            </div>

            <div class="panel-body collapse in" id="Seventh"></div>
          </div>
        </div>
        <div class="col-6 col-md-6">
          <div class="panel panel-default">
            <div class="panel-heading" data-toggle="collapse" data-target="#Sixth">
              Panel Heading
            </div>
            <div class="panel-body collapse in" id="Sixth">
              <table id="tab3" class="table table-striped"></table>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div id="menu2" class="tab-pane fade">
    <div class='row'>
        <div class="col-6 col-md-3">
          <div class="panel panel-default">
            <div class="panel-heading" data-toggle="collapse" data-target="#Fifth">
              Onbestaande pagina's
            </div>

            <div class="panel-body collapse in" id="Fifth">
            <ul id=Links></ul>
              <ol id=items></ol>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>

</html>