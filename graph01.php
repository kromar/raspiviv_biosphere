 <?PHP
// 	require_once("./include/membersite_config.php");

// 	if(!$fgmembersite->CheckLogin())
// 	{
// 	    $fgmembersite->RedirectToURL("login.php");
// 	    exit;
// 	}
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US" lang="en-US">
<head>
    <meta charset="utf-8"></meta>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"></meta>
    <meta name="viewport" content="width=device-width, initial-scale=1"></meta>

	<title>RasPiViv.com - Vivarium 1</title>

    <!--Load the AJAX API-->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
	<script src="scripts/jquery-3.1.1.min.js"></script>
	<script type="text/javascript"></script>

<!--  load CSS -->
	<script type="text/javascript" src="https://www.google.com/jsapi"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link href="/css/normalize.css" rel="stylesheet"></link>
	<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css"></link>
   	<link rel="stylesheet" href="http://getbootstrap.com/examples/cover/cover.css"></link>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css"></link>
	<script src="//cdnjs.cloudflare.com/ajax/libs/dygraph/1.1.1/dygraph-combined.js"></script>


<!-- MAP VIEW -->
<script type="text/javascript">
      google.charts.load('current', {'packages': ['table', 'map', 'corechart']});
      google.charts.setOnLoadCallback(initialize);

      function initialize() {
        // The URL of the spreadsheet to source data from.
        var query = new google.visualization.Query(
            'https://spreadsheets.google.com/pub?key=pCQbetd-CptF0r8qmCOlZGg');
        query.send(draw);
      }

      function draw(response) {
        if (response.isError()) {
          alert('Error in query');
        }

        var ticketsData = response.getDataTable();
        var chart = new google.visualization.ColumnChart(
            document.getElementById('chart_div'));
        chart.draw(ticketsData, {'isStacked': true, 'legend': 'bottom',
            'vAxis': {'title': 'Number of tickets'}});

        var geoData = google.visualization.arrayToDataTable([
          ['Lat', 'Lon', 'Name', 'Food?'],
          [51.5072, -0.1275, 'Cinematics London', true],
          [48.8567, 2.3508, 'Cinematics Paris', true],
          [55.7500, 37.6167, 'Cinematics Moscow', false]]);

        var geoView = new google.visualization.DataView(geoData);
        geoView.setColumns([0, 1]);

        var table =
            new google.visualization.Table(document.getElementById('table_div'));
        table.draw(geoData, {showRowNumber: false, width: '100%', height: '100%'});

        var map =
            new google.visualization.Map(document.getElementById('map_div'));
        map.draw(geoView, {showTip: true});

        // Set a 'select' event listener for the table.
        // When the table is selected, we set the selection on the map.
        google.visualization.events.addListener(table, 'select',
            function() {
              map.setSelection(table.getSelection());
            });

        // Set a 'select' event listener for the map.
        // When the map is selected, we set the selection on the table.
        google.visualization.events.addListener(map, 'select',
            function() {
              table.setSelection(map.getSelection());
            });
      }
    </script>

<!-- DASHBOARD VIEW -->
<script type="text/javascript" async>
	google.load('visualization', '1', {	  packages: ['corechart', 'controls'] });
	google.setOnLoadCallback(drawDashboard);

	function drawDashboard() {
	  var graphData = new google.visualization.DataTable();
		graphData.addColumn('date', 'TIME'); //
		graphData.addColumn('number', 'TEMP');
		//graphData.addColumn('number', 'HUM');
		graphData.addRows(
			<?php
				$servername = "localhost";
				$username = "datalogger";
				$password = "datalogger";
				$dbname = "datalogger";
				$datenuebergabe = array();
				$history = 3;
				//(string) $row -> date_time,
				// Try this fix: new Date((dateArr2[i]).replace(/-/g, '/')). For Safari new Date("2015-12-27 23:51:21") is invalid date but new Date("2015/12/27 23:51:21") is valid

				// Create connection
				$db = mysqli_connect($servername, $username, $password, $dbname);
				// Check connection
				if (!$db) {
					die("Connection failed: " . mysqli_connect_error());
				}
				$sql = "SELECT * FROM datalogger where sensor = 8 ORDER BY date_time DESC LIMIT $history";
				$result = mysqli_query($db, $sql);

				if (mysqli_num_rows($result) > 0) {
					while($row = mysqli_fetch_object($result)) {
						$datenuebergabe[] = [
								[new Date(2015, 0, 1), 5],  [new Date(2015, 0, 2), 7],  [new Date(2015, 0, 3), 3],
								[new Date(2015, 0, 4), 1],  [new Date(2015, 0, 5), 3],  [new Date(2015, 0, 6), 4],
								[new Date(2015, 0, 7), 3],  [new Date(2015, 0, 8), 4],  [new Date(2015, 0, 9), 2],
								[new Date(2015, 0, 10), 5], [new Date(2015, 0, 11), 8], [new Date(2015, 0, 12), 6],
								[new Date(2015, 0, 13), 3], [new Date(2015, 0, 14), 3], [new Date(2015, 0, 15), 5],
								[new Date(2015, 0, 16), 7], [new Date(2015, 0, 17), 6], [new Date(2015, 0, 18), 6],
								[new Date(2015, 0, 19), 3], [new Date(2015, 0, 20), 1], [new Date(2015, 0, 21), 2],
								[new Date(2015, 0, 22), 4], [new Date(2015, 0, 23), 6], [new Date(2015, 0, 24), 5],
								[new Date(2015, 0, 25), 9], [new Date(2015, 0, 26), 4], [new Date(2015, 0, 27), 9],
								[new Date(2015, 0, 28), 8], [new Date(2015, 0, 29), 6], [new Date(2015, 0, 30), 4],
								[new Date(2015, 0, 31), 6], [new Date(2015, 1, 1), 7],  [new Date(2015, 1, 2), 9]

								//new Date(2015, 12, 27, 23, 51, 21),
								//(float) $row -> temperature,
								//(float) $row -> humidity,
							];
					}
				} else {
					echo "0 results";
				}
				mysqli_close($db);
				echo  json_encode($datenuebergabe);
			?>
		);

	  });

		  var options = {
		    height: 400,
		    pointSize: 6,
		    chartArea: {
		      'width': '100%',
		      'height': '80%'
		    },
		    dataOpacity: 0.3,
		    focusTarget: 'category',
		    legend: {
		      position: 'top'
		    },
		    hAxis: {
		      gridlines: {
		        color: 'none'
		      },
		      //textPosition: textPosition,
		      textPosition: 'bottom',
		      format: 'MMM dd',
		      slantedText: false
		    },
		    animation: {
		      duration: 1000,
		      easing: 'out',
		    }
	  };

	data = new google.visualization.DataTable(graphData);

	//create dashboard
  	var dashboard = new google.visualization.Dashboard(
  		  	document.getElementById('dashboard_div'));

  // Create a date range slider
  var myDateSlider = new google.visualization.ControlWrapper({
    controlType: 'ChartRangeFilter',
    containerId: 'control_div',
    options: {
    	filterColumnLabel: 'TIME'
    }
  });

  //create line chart
  var lineChart = new google.visualization.ChartWrapper({
	    chartType: 'LineChart',
	    containerId: 'linechart_div'

	  });

	//Establish dependencies, declaring that 'filter' drives 'lineChart',
  // so that the  chart will only display entries that are let through
  // given the chosen slider range.
  dashboard.bind(myDateSlider, lineChart);
  console.log(data);
	//draw the dashboard
  dashboard.draw(data);
  }
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

	<!--
	<nav class="navbar navbar-default">	</nav>
 	-->

	</div>

<!-- 	MAP -->
<table align="center">
      <tr valign="top">
        <td style="width: 50%;">
          <div id="map_div"</div>
        </td>
        <td style="width: 50%;">
          <div id="table_div"></div>
        </td>
      </tr>
      <tr>
        <td colSpan=2>
          <div id="chart_div" style="align: center; width: 700px; height: 300px;"></div>
        </td>
      </tr>
    </table>

	<!-- 	DASHBOARD -->
		<div id="dashboard_div">
		  <table class="columns">
		    <tr>
		      <td>
		        <div id="linechart_div" style="width: 950px; height: 250px;"></div>
		      </td>
		    </tr>
		    <tr>
		      <td>
		        <div id="control_div" style="width: 950px; height: 50px;"></div>
		      </td>
		    </tr>
		  </table>
		</div>

	<!-- 	DYGRAPH -->
	<div class="container">
			<table class="row">
				<div id="graphdiv3"></div>
					<script type="text/javascript">
					  	g3 = new Dygraph(
					    document.getElementById("graphdiv3"),
					    "data/temperatures.csv",
					    {
					      rollPeriod: 7,
					      showRoller: true
					    }
					  );

					  </script>

				<div id="temp_gauge_div"></div>
				<div id="chart_short_div"></div>
			    <div id="hum_gauge_div"></div>

			    <!--
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
				 -->

			</div>
				<div class="row">
	    			<div id="chart_long_div"></div>
				</div>

	    	<!--
	    	<div id="test_gauge_div"></div>
	    	<input type="button" value="Go Faster" onclick="changeTemp(1)" />
	  		<input type="button" value="Slow down" onclick="changeTemp(-1)" />
			-->

		</table>
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

		</div>
	    <?php include 'footer.php';?>
</body>
</html>
