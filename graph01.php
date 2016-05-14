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
	<script src="scripts/jquery-1.12.3.min.js"></script>
	<script type="text/javascript" src="https://www.google.com/jsapi"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

	<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
   	<link rel="stylesheet" href="http://bootswatch.com/cerulean/bootstrap.min.css"></script>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css">



	<script type="text/javascript">
		//*
		google.load('visualization',  "1", {'packages':['gauge']});
	    google.setOnLoadCallback(drawGauge);
	    var gaugeOptions = {
				width: 4*180,
				height: 1*180,
				min: 0,
				max: 280,
				yellowFrom: 200,
				yellowTo: 250,
	    	    redFrom: 250,
	    	    redTo: 280,
	    	    minorTicks: 5};
	    var gauge;

	    function drawGauge() {
	      gaugeData = new google.visualization.DataTable();
	      gaugeData.addColumn('number', 'Engine');
	      gaugeData.addColumn('number', 'Torpedo');
	      gaugeData.addColumn('number', 'test1');
	      gaugeData.addColumn('number', 'test2');
	      gaugeData.addRows(1);
	      gaugeData.setCell(0, 0, 120);
	      gaugeData.setCell(0, 1, 80);
	      gaugeData.setCell(0, 2, 80);
	      gaugeData.setCell(0, 3, 80);

	      gauge = new google.visualization.Gauge(document.getElementById('test_gauge_div'));
	      gauge.draw(gaugeData, gaugeOptions);
	    }

	    function changeTemp(dir) {
	      gaugeData.setValue(0, 0, gaugeData.getValue(0, 0) + dir * 25);
	      gaugeData.setValue(0, 1, gaugeData.getValue(0, 1) + dir * 20);
	      gaugeData.setValue(0, 2, gaugeData.getValue(0, 1) + dir * 20);
	      gaugeData.setValue(0, 3, gaugeData.getValue(0, 1) + dir * 20);
	      gauge.draw(gaugeData, gaugeOptions);
	      console.log("test debug");
	    }



	    //*/

	</script>



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
			crosshair: {trigger: 'both' , orientation: 'vertical', color: 'black'},
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
			crosshair: {trigger: 'both' , orientation: 'vertical', color: 'grey'},
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
    	<div id="test_gauge_div"></div>
    	<input type="button" value="Go Faster" onclick="changeTemp(1)" />
  		<input type="button" value="Slow down" onclick="changeTemp(-1)" />

		<div class="row">
			<div class="col-xs-4">
				<div id="temp_gauge_div"></div>
			    <div id="hum_gauge_div"></div>
			</div>
			<div class="col-xs-8">
    			<div id="chart_short_div"></div>
    			<div id="chart_long_div"></div>
			</div>


		</div>

	    <hr>

	     <?php echo("<script>console.log('debug');</script>"); ?>
	     <?php
	      // grap weather information from openweathermap.org
			$city = "Chepo";
			$country = "PA"; // two digit country code
			$lat =-79.1;
			$lon = 9.17;
			$url = "http://api.openweathermap.org/data/2.5/weather?q=".$city.",".$country."&units=metric&cnt=6&lang=en";
			$json = file_get_contents($url);
			$data = json_decode($json,true);
			//get humidity
			$wd = ($data['main']['humidity']);
			//$wd = $city;
			echo("<script>console.log('$wd');</script>");
		?>

	    <?php include 'footer.php';?>
	</div>
</body>
</html>
