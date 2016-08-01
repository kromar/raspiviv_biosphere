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

	<title>RasPiViv.com - Vivarium 1</title>

	<script src="scripts/jquery-1.12.3.min.js"></script>
	<script type="text/javascript" src="https://www.google.com/jsapi"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

	<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css"></link>
   	<link rel="stylesheet" href="http://bootswatch.com/superhero/bootstrap.min.css"></link>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css"></link>



	<!--
	<script type="text/javascript">
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
	      gauge.draw(gaugeData, gaugeOptions);
	    }

	</script>
	-->

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
	<!-- GRAPH short-->
	<!-- ============================ -->
	<script type="text/javascript">
	google.load("visualization", "1", {packages:["corechart"]});
	google.setOnLoadCallback(drawChart);

	var myVar;
	function myFunction() {
	    myVar = setTimeout(drawChart, 10000);
	}

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
				$sql = "SELECT * FROM datalogger where sensor = 8 ORDER BY date_time DESC LIMIT 10";
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
		var max = 1440;
		var options = {
			animation: {
				duration: 1000,
				easing: 'out'},

			legend: {
				position: 'top' },
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
				color: 'black'},
			backgroundColor: {
				stroke: 'black',
				fill: 'white',
				strokeSize: 1},
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

	    var prevButton = document.getElementById('b1');
	    var nextButton = document.getElementById('b2');

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



		chart.draw(data, options);


	    setTimeout(function() {
	        data.setValue(0, 1);
	        chart.draw(data, options);
	    }, 3000);


		}
	</script>


	<!-- ============================ -->
	<!-- GRAPH LONG-->
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

		setTimeout(function() {
        	chart.draw(data, options);
	    }, 10000);

		}
	</script>

	<div class="jumbotron">
		<div class="container">
			<?php include 'menu.php';?>
			<h2>Sensor 1</h2>
			<?php include 'time.php';?>
		</div>

	<nav class="navbar navbar-default">	</nav>


	</div>

	<div class="container">

		<div class="row">
			<div class="col-xs-4">
				<div id="temp_gauge_div"></div>
			    <div id="hum_gauge_div"></div>

			    <form>
				  min: 	<input type="number" name="nighthumidity" value="90">
				  		<br>
				  max:	<input type="number" name="dayhumidity" value="95">
				  		<br>
				  		<br>
				  min: 	<input type="number" name="nighttemperature" value="24">
				  		<br>
				  max:	<input type="number" name="nighttemperature" value="30">
				  		<br>
				  		<br>

				  <input type="submit" value="test">
				</form>
			</div>
			<div class="col-xs-8">
    			<div id="chart_short_div"></div>
    			<div id="chart_long_div"></div>
			</div>

	    	<!--
	    	<div id="test_gauge_div"></div>
	    	<input type="button" value="Go Faster" onclick="changeTemp(1)" />
	  		<input type="button" value="Slow down" onclick="changeTemp(-1)" />
			-->

		</div>
	</div>

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

	    <?php include 'footer.php';?>
	</div>
</body>
</html>
