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
  <link rel="stylesheet" type="text/css" href="opmaak.css" />

  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css" />

  <!-- jQuery library -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

  <!-- Latest compiled JavaScript -->
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>

  <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
  <script src="https://cdn.jsdelivr.net/remarkable/1.7.1/remarkable.min.js"></script>
  <script src="paginator.js"></script>

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
        <a class="navbar-brand" href="#"><?php echo $_SESSION["user"]; ?></a>
        
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
          <li><a href="#" id="update"></a></li>
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
        <div class="col-6 col-md-9">
          <div class="panel panel-default">
            <div class="panel-heading" data-toggle="collapse" data-target="#Fourth">
              Panel Heading
            </div>

            <div class="panel-body collapse in" id="Fourth"></div>
          </div>
        </div>
        <div class="col-6 col-md-3">
          <div class="panel panel-default">
            <div class="panel-heading" data-toggle="collapse" data-target="#Third">
              Panel Heading
            </div>
            <div class="panel-body collapse in" id="Third">
              <table id="tab2" class="table table-striped"></table>
            </div>
          </div>
        </div>
      </div>
      
    </div>
    <div id="menu2" class="tab-pane fade">
      
    </div>
  </div>
</body>

</html>