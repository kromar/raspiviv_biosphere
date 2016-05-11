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
<title>RasPiViv.com - Vivarium 2</title>
	<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap-theme.min.css">
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="https://www.google.com/jsapi"></script>


	<!-- ============================ -->
	<!-- VIV 1 TEMP GAUGE -->
	<!-- ============================ -->
	<script type="text/javascript">
		google.load("visualization", "1", {packages:["gauge"]});
		google.setOnLoadCallback(drawChart);
		function drawChart() {

			var data = google.visualization.arrayToDataTable([
				['Label', 'Value'],
				['C',
					<?php
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

						$sql = "SELECT temperature FROM datalogger where sensor = 8 ORDER BY date_time DESC LIMIT 1";
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
				width: 200,
				height: 200,
	          	yellowFrom:18.0,
	          	yellowTo: 21.0,
				greenFrom:21.0,
				greenTo: 26.5,
	          	redFrom: 26.5,
	          	redTo: 30.0,
		        redColor: '#FF9900',
				minorTicks: 5,
				min: 15,
				max: 35,
			};

			var chart = new google.visualization.Gauge(document.getElementById('temp_gauge_div'));

			chart.draw(data, options);
		}
	</script>


	<!-- ============================ -->
	<!-- VIV 1 HUM GAUGE -->
	<!-- ============================ -->
	<script type="text/javascript">
		  google.load("visualization", "1", {packages:["gauge"]});
		  google.setOnLoadCallback(drawChart);
		  function drawChart() {
			var data = google.visualization.arrayToDataTable([
			  ['Label', 'Value'],
			  ['%',
					<?php
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

						$sql = "SELECT humidity FROM datalogger where sensor = 8 ORDER BY date_time DESC LIMIT 1";
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
					?>
				],

			]);

			var options = {
				width: 200,
				height: 200,
				yellowFrom: 65,
				yellowTo: 75,
				greenFrom:75,
				greenTo: 95,
	          	redFrom:95,
	          	redTo: 100,
		        redColor: '#FF9900',
				minorTicks: 5,
				min: 50,
				max: 100,
			};

			var chart = new google.visualization.Gauge(document.getElementById('hum_gauge_div'));

			chart.draw(data, options);
		  }
	</script>


	<!-- ============================ -->
	<!-- TEMP-HUM GRAPH-->
	<!-- ============================ -->
	<script type="text/javascript">
	google.load("visualization", "1", {packages:["corechart"]});
	google.setOnLoadCallback(drawChart);
	function drawChart() {
		var data = google.visualization.arrayToDataTable([
		  	['TIME', 'TEMP', 'HUMIDITY' ],
			<?php
				$db = mysql_connect ( "localhost", "datalogger", "datalogger" ) or die ( "DB Connect error" );
				mysql_select_db ( "datalogger" );

				$q = "select * from datalogger ";
				$q = $q . "where sensor = 8 ";
				$q = $q . "order by date_time desc ";
				$q = $q . "limit 10";
				$ds = mysql_query ( $q );

				while ( $r = mysql_fetch_object ( $ds ) ) {
					echo "['" . $r->date_time . "', ";
					echo " " . $r->temperature . " ,";
					echo " " . $r->humidity . " ],";
					}
			?>
		]);

		var options = {
			legend: { position: 'top' },
			curveType: 'function',
			crosshair: { orientation: 'vertical'},
			backgroundColor: {stroke: 'black', fill: 'white', strokeSize: 1},
	        height: 400,
			series: {
				0: {color: 'red', targetAxisIndex: 0},
				1: {color: 'blue', targetAxisIndex: 1},
		},

		vAxes: {
			// Adds titles to each axis.
			0: {title: 'Temperature (C)'},
			1: {title: 'Humidity (%)'},
		},

		hAxis: {
			textPosition: 'none',
			direction: '-1' },
		};

		var chart = new google.visualization.LineChart(document.getElementById('chart_short_div'));

		chart.draw(data, options);
		}
	</script>

	<!-- ============================ -->
	<!-- TEMP-HUM GRAPH LONG-->
	<!-- ============================ -->
	<script type="text/javascript">
	google.load("visualization", "1", {packages:["corechart"]});
	google.setOnLoadCallback(drawChart);
	function drawChart() {
		var data = google.visualization.arrayToDataTable([
		  	['TIME', 'TEMP', 'HUMIDITY' ],
			<?php
				$db = mysql_connect ( "localhost", "datalogger", "datalogger" ) or die ( "DB Connect error" );
				mysql_select_db ( "datalogger" );

				$q = "select * from datalogger ";
				$q = $q . "where sensor = 8 ";
				$q = $q . "order by date_time desc ";
				$q = $q . "limit 240";
				$ds = mysql_query ( $q );

				while ( $r = mysql_fetch_object ( $ds ) ) {
					echo "['" . $r->date_time . "', ";
					echo " " . $r->temperature . " ,";
					echo " " . $r->humidity . " ],";
					}
			?>
		]);

		var options = {
			legend: { position: 'none' },
			curveType: 'function',
			crosshair: {trigger: 'selection' , orientation: 'vertical', color: 'black'},
			backgroundColor: {stroke: 'black', fill: 'white', strokeSize: 1},
	        height: 400,
			series: {
				0: {color: 'red', targetAxisIndex: 0},
				1: {color: 'blue', targetAxisIndex: 1},
		},

		vAxes: {
			// Adds titles to each axis.
			0: {title: 'Temperature (C)'},
			1: {title: 'Humidity (%)'},
		},

		hAxis: {
			textPosition: 'none',
			direction: '-1' },
		};

		var chart = new google.visualization.LineChart(document.getElementById('chart_long_div'));

		chart.draw(data, options);
		}
	</script>
</head>


<!-- ============================ -->
<!-- DRAW PAGE BODY -->
<!-- ============================ -->
<body>
	<div class="jumbotron">
		<div class="container">
			<?php include 'menu.php';?>
			<h2>Sensor 1</h2>
			<?php include 'time.php';?>
		</div>
	</div>

	<div class="container">
		<div class="row">
			<div class="col-xs-3">
				<div id="temp_gauge_div"></div>
			    <div id="hum_gauge_div"></div>
			</div>
			<div class="col-xs-9">
    			<div id="chart_short_div"></div>
    			<div id="chart_long_div"></div>
			</div>
		</div>

	    <hr>
	    <?php include 'footer.php';?>
	</div>
</body>
</html>
