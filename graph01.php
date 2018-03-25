 <?PHP
// 	require_once("./assets/php/membersite_config.php");

// 	if(!$fgmembersite->CheckLogin())
// 	{
// 	    $fgmembersite->RedirectToURL("login.php");
// 	    exit;
// 	}
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US" lang="en-US">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

	<title>RasPiViv.com - Vivarium 1</title>

    <!--Load the AJAX API-->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	<script type="text/javascript"></script>

<!--  load CSS -->
	<script type="text/javascript" src="https://www.google.com/jsapi"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css">
<!--    	<link rel="stylesheet" href="http://getbootstrap.com/examples/cover/cover.css"> -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css">
	<script src="//cdnjs.cloudflare.com/ajax/libs/dygraph/1.1.1/dygraph-combined.js"></script>
</head>

<body>


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
						$db = mysqli_connect($servername, $username, $password, $dbname);
						// Check connection
						if (!$db) {
							die("Connection failed: " . mysqli_connect_error());
						}
						$sql = "SELECT temperature FROM datalogger where sensor = 8 ORDER BY date_time DESC LIMIT 1";
						$result = mysqli_query($db, $sql);

						if (mysqli_num_rows($result) > 0) {
							// output data of each row
							while($row = mysqli_fetch_assoc($result)) {
								echo $row["temperature"];
							}
						} else {
							echo "0 results";
						}
						//mysqli_close($db);
					?>
				],
			]);

			var options = {
				width: 280,
				height: 280,
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
						$db = mysqli_connect($servername, $username, $password, $dbname);
						// Check connection
						if (!$db) {
							die("Connection failed: " . mysqli_connect_error());
						}
						$sql = "SELECT humidity FROM datalogger where sensor = 8 ORDER BY date_time DESC LIMIT 1";
						$result = mysqli_query($db, $sql);

						if (mysqli_num_rows($result) > 0) {
							// output data of each row
							while($row = mysqli_fetch_assoc($result)) {
								echo $row["humidity"];
							}
						} else {
							echo "0 results";
						}

						//mysqli_close($db);
					?>
				],

			]);

			var options = {
				width: 280,
				height: 280,
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
				$servername = "localhost";
				$username = "datalogger";
				$password = "datalogger";
				$dbname = "datalogger";

				// Create connection
				$db = mysqli_connect($servername, $username, $password, $dbname);
				// Check connection
				if (!$db) {
					die("Connection failed: " . mysqli_connect_error());
				}
				$sql = "SELECT * FROM $dbname where sensor = 8 ORDER BY date_time DESC LIMIT 10";
				$result = mysqli_query($db, $sql);

				if (mysqli_num_rows($result) > 0) {
					while($row = mysqli_fetch_object($result)) {
					echo "['" . $row->date_time . "', ";
					echo " " . $row->temperature . " ,";
					echo " " . $row->humidity . " ],";
					}
				} else {
					echo "0 results";
				}
				mysqli_close($db);
			?>
		]);

		var options = {
			animation: {
				duration: 1000,
				easing: 'out'
			},

			legend: {
				position: 'top'
			},
			point: {
				visible: true,
				//fill-color: #000000,
				},
			pointSize: 6,
			pointShape: 'circle',
			curveType: 'function',
			crosshair: {
				trigger: 'both' ,
				orientation: 'vertical',
				color: 'white'},
			backgroundColor: {
				stroke: 'white',
				fill: 'grey',
				strokeSize: 1},
	        height: 300,
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


	    setTimeout(function() {
	        data.setValue(0, 1);
	        chart.draw(data, options);
	    }, 3000);

	    var myVar;
		function myFunction() {
		    myVar = setTimeout(drawChart, 10000);
		}

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
				$servername = "localhost";
				$username = "datalogger";
				$password = "datalogger";
				$dbname = "datalogger";

				// Create connection
				$db = mysqli_connect($servername, $username, $password, $dbname);
				// Check connection
				if (!$db) {
					die("Connection failed: " . mysqli_connect_error());
				}
				$sql = "SELECT * FROM datalogger where sensor = 8 ORDER BY date_time DESC LIMIT 1400";
				$result = mysqli_query($db, $sql);

				if (mysqli_num_rows($result) > 0) {
					while($row = mysqli_fetch_object($result)) {
					echo "['" . $row->date_time . "', ";
					echo " " . $row->temperature . " ,";
					echo " " . $row->humidity . " ],";

					}
				} else {
					echo "0 results";
				}
				mysqli_close($db);

			?>
		]);

		var options = {
			legend: { position: 'none' },
			curveType: 'function',
			crosshair: {trigger: 'both' , orientation: 'vertical', color: 'grey'},
			backgroundColor: {stroke: 'black', fill: 'white', strokeSize: 1},
	        height: 300,
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

		setTimeout(function() {
        	chart.draw(data, options);
	    }, 10000);

		}
	</script>

	<div class="jumbotron">
		<div class="container">
				<?php include('menu.html');?>
			<h2>Sensor 1</h2>
			<?php include 'time.php';?>
		</div>

	<!--
	<nav class="navbar navbar-default">	</nav>
 	-->

	</div>



		<!-- 	DASHBOARD -->
		<div id="dashboard_div">
		  <div id="line_div"><!-- Line chart renders here --></div>
		  <div id="control_div"><!-- Controls renders here --></div>
		</div>

		<!-- GAUGE -->

        <div id="gauges">
            <div class="container-fluid">
		        <div id="temp_gauge_div"></div>
		        <div id="hum_gauge_div"></div>
            </div>
        </div>
		<!-- CHARTS -->
		<div id="chart_short_div"></div>
    	<div id="chart_long_div"></div>


	    <hr>
	    <div class="container">
	     <?php
	   	  	// http://99webtools.com/blog/get-weather-information-using-php/
	      	// grap weather information from openweathermap.org
			$city = "Chepo";
			$country = "PA"; // two digit country code
			/*
	      	$apikey = "2383e44c43c21e8c8d2c1537b54db3b0";
			$request="http://api.openweathermap.org/data/2.5/weather?APPID=".$apikey."&q=".$city.",".$country."&units=metric&cnt=7&lang=en";
			$data = file_get_contents($url);
			$response = json_decode(file_get_contents($url),true);

			//get humidity
			$remoteTemperature = $response['main']['temp'];
			$remoteHumidity = $response['main']['humidity '];
			$remoteWinnd = $response['wind']['speed'];


			var_dump("<script>console.log('$response');</script>", true);

			$curentTime = date('H:i');
			$morningTime = '10:00';
			$eveningTime = '22:00';

			$remoteTime = $response['dt']['sunrise'];
			$remoteSunrise = $response['sys']['sunrise'];
			$remoteSunset = $response['sys']['sunset'];
			$sun = 1463354956;


			$remoteTime = convertTime($remoteTime, 'unix');
			$remoteSunrise = convertTime($remoteSunrise, 'unix');
			$remoteSunset = convertTime($remoteSunset, 'unix');

			function convertTime($time, $mode) {
				if ($mode == 'unix') {
					$gmtime = date("H:i", $time);
					return $gmtime;
				}
				if ($mode == 'gmt') {
					$unixtime = date("H:i", $time);
					return $unixtime;
				}
			}

			if ($remoteSunset < $remoteSunrise) {
				$remoteSunset = $remoteSunset + 24;
			}
			$remoteDayLenght = $remoteSunset - $remoteSunrise;

			var_dump("<script>console.log('$remoteDayLenght');</script>", true);
			//*/

			/*
			 {"coord":{"lon":-79.1,"lat":9.17},
			"weather":[{"id":500,"main":"Rain","description":"light rain","icon":"10n"}],
			"base":"cmc stations",
			"main":{"temp":25.55, "pressure":1012.67,"humidity":100,
					"temp_min":25.55, "temp_max":25.55,	"sea_level":1021.67, "grnd_level":1012.67},
			"wind":{"speed":1.71, "deg":339.004},
			"rain":{"3h":0.97},
			"clouds":{"all":92},
			"dt":1463300886, "sys":{"message":0.0086, "country":"PA", "sunrise":1463309782, "sunset":1463354956},
			"id":3712505, "name":"Chepo","cod":200}
			//*/
		?>

		</div>
	    <?php include 'footer.php';?>
</body>
</html>
