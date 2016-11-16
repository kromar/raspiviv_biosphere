<?PHP
require_once("./include/membersite_config.php");

if(!$fgmembersite->CheckLogin())
{
    $fgmembersite->RedirectToURL("login.php");
    exit;
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US" lang="en-US">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

	<title>RasPiViv.com - Vivarium 2</title>

	<script src="scripts/jquery-1.12.3.min.js"></script>
	<script type="text/javascript" src="https://www.google.com/jsapi"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

	<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css"></link>
   	<link rel="stylesheet" href="http://bootswatch.com/cerulean/bootstrap.min.css"></link>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css"></link>

<!-- VIV 1 TEMP GAUGE -->

    <script type="text/javascript">
      google.load("visualization", "1", {packages:["gauge"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {

        var data = google.visualization.arrayToDataTable([
          ['Label', 'Value'],
          ['TEMP C', <?php
$servername = "localhost";
$username = "datalogger";
$password = "datalogger";
$dbname = "datalogger";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql = "SELECT temperature FROM datalogger where sensor = 9 ORDER BY date_time DESC LIMIT 1";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while($row = mysqli_fetch_assoc($result)) {
        echo $row["temperature"];
    }
} else {
    echo "0 results";
}

mysqli_close($conn);
?>

],

        ]);

        var options = {
          width: 400, height: 200,
          redFrom: 26.6, redTo: 100,
          yellowFrom:20, yellowTo: 25.5,
          minorTicks: 5
        };

        var chart = new google.visualization.Gauge(document.getElementById('charttemp_div'));

        chart.draw(data, options);


      }
    </script>

<!-- VIV 1 HUM GAUGE -->
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["gauge"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {

        var data = google.visualization.arrayToDataTable([
          ['Label', 'Value'],
          ['HUM %', <?php
$servername = "localhost";
$username = "datalogger";
$password = "datalogger";
$dbname = "datalogger";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql = "SELECT humidity FROM datalogger where sensor = 9 ORDER BY date_time DESC LIMIT 1";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while($row = mysqli_fetch_assoc($result)) {
        echo $row["humidity"];
    }
} else {
    echo "0 results";
}

mysqli_close($conn);
?> ],

        ]);

        var options = {
          width: 400, height: 200,
          redFrom: 0, redTo: 80,
          yellowFrom:80, yellowTo: 100,
          minorTicks: 5
        };

        var chart = new google.visualization.Gauge(document.getElementById('charthum_div'));

        chart.draw(data, options);


      }
    </script>
<!-- VIV 1 HUM GRAPH -->
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['TIME', 'HUMIDITY', ],
			<?php
				$db = mysqli_connect("localhost","datalogger","datalogger") or die("DB Connect error");
				mysqli_select_db("datalogger");

				$q=   "select * from datalogger ";
				$q=$q."where sensor = 9 ";
				$q=$q."order by date_time desc ";
				$q=$q."limit 60";
				$ds=mysqli_query($db, $q);

				while($r = mysqli_fetch_object($ds))
				{
					echo "['".$r->date_time."', ";
					echo " ".$r->humidity." ],";

				}
			?>
        ]);







	        var options = {
	        	      width: 400,
	        	      height: 240,
	        	      animation: {
	        	        duration: 1000,
	        	        easing: 'in'
	        	      },
	        	      hAxis: {viewWindow: {min:0, max:5}}
	        	    };

        	    var chart = new google.visualization.SteppedAreaChart(
        	        document.getElementById('visualization'));

        	    var data = new google.visualization.DataTable();
        	    data.addColumn('string', 'x');
        	    data.addColumn('number', 'y');

        	    var MAX = 10;
        	    for (var i = 0; i < MAX; ++i) {
        	      data.addRow([i.toString(), Math.floor(Math.random() * 100)]);
        	    }
        	    var prevButton = document.getElementById('b1');
        	    var nextButton = document.getElementById('b2');
        	    var changeZoomButton = document.getElementById('b3');

        	    function drawChart() {
        	      // Disabling the button while the chart is drawing.
        	      prevButton.disabled = true;
        	      nextButton.disabled = true;
        	      changeZoomButton.disabled = true;
        	      google.visualization.events.addListener(chart, 'ready',
        	          function() {
        	            prevButton.disabled = options.hAxis.viewWindow.min <= 0;
        	            nextButton.disabled = options.hAxis.viewWindow.max >= MAX;
        	            changeZoomButton.disabled = false;
        	          });
        	      chart.draw(data, options);
        	    }

        	    prevButton.onclick = function() {
        	      options.hAxis.viewWindow.min -= 1;
        	      options.hAxis.viewWindow.max -= 1;
        	      drawChart();
        	    }
        	    nextButton.onclick = function() {
        	      options.hAxis.viewWindow.min += 1;
        	      options.hAxis.viewWindow.max += 1;
        	      drawChart();
        	    }
        	    var zoomed = false;
        	    changeZoomButton.onclick = function() {
        	      if (zoomed) {
        	        options.hAxis.viewWindow.min = 0;
        	        options.hAxis.viewWindow.max = 5;
        	      } else {
        	        options.hAxis.viewWindow.min = 0;
        	        options.hAxis.viewWindow.max = MAX;
        	      }
        	      zoomed = !zoomed;
        	      drawChart();
        	    }
        	    drawChart();











	var options = {
	title: 'HUMIDITY LAST HOUR',
	curveType: 'function',
	legend: { position: 'none' },
	hAxis: { textPosition: 'none', direction: '-1' },
        };

        var chart = new google.visualization.LineChart(document.getElementById('chart_div'));

        chart.draw(data, options);
      }
    </script>

<!-- VIV 1 TEMP GRAPH -->

    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['TIME', 'TEMP', ],
			<?php
				$db = mysqli_connect("localhost","datalogger","datalogger") or die("DB Connect error");
				mysqli_select_db("datalogger");

				$q=   "select * from datalogger ";
				$q=$q."where sensor = 9 ";
				$q=$q."order by date_time desc ";
				$q=$q."limit 60";
				$ds=mysqli_query($db, $q);

				while($r = mysqli_fetch_object($ds))
				{
					echo "['".$r->date_time."', ";
					echo " ".$r->temperature." ],";

				}
			?>
        ]);

	var options = {
	title: 'TEMP LAST HOUR',
	curveType: 'function',
	legend: { position: 'none' },
	hAxis: { textPosition: 'none', direction: '-1' },
        };

        var chart = new google.visualization.LineChart(document.getElementById('chart2_div'));

        chart.draw(data, options);
      }
    </script>
</head>
<body>
<div class="jumbotron">
<div class="container">
				<?php include('menu.html');?>
<h2>2</h2>


<?php include 'time.php';?>
</div>
</div>
<div class="container">
<h3>CURRENT CONDITIONS</h3>
  <div class="row">
    <div class="col-sm-3">
    <div id="charttemp_div" style="width: 200px; height: 200px;"></div>
    </div>
    <div class="col-sm-3">
    <div id="charthum_div" style="width: 200px; height: 200px;"></div>
    </div>
    </div>
<hr>
    </div>
<div class="container">
    <div id="chart2_div" style="width: auto; height: 500px;"></div>
    <div id="chart_div" style="width: auot; height: 500px;"></div><hr>
    <?php include 'footer.php';?>
</div>
</body>
</html>




