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

	<title>RasPiViv.com - Vivarium 1</title>

	<script src="scripts/jquery-1.12.3.min.js"></script>
	<script type="text/javascript" src="https://www.google.com/jsapi"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <link href="/css/normalize.css" rel="stylesheet"></link>
	<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css"></link>
<!--    	<link rel="stylesheet" href="http://bootswatch.com/cerulean/bootstrap.min.css"></link> -->
   	<link rel="stylesheet" href="http://getbootstrap.com/examples/cover/cover.css"></link>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css"></link>



<script type="text/javascript">
google.load('visualization', '1', {
  packages: ['corechart', 'controls']
});
google.setOnLoadCallback(drawChart);

function drawChart() {
	var graphData = {
		    "cols": [{
		      "id": "A",
		      "label": "Date Range",
		      "pattern": "",
		      "type": "date"
		    }, {
		      "id": "B",
		      "label": "Sessions",
		      "pattern": "",
		      "type": "number"
		    }],
		    "rows": [{
		      "c": [{
		        "v": "Date(2015,4,30)",
		        "f": "Saturday, May 30, 2015"
		      }, {
		        "v": "31"
		      }]
		    }, {
		      "c": [{
		        "v": "Date(2015,4,31)",
		        "f": "Sunday, May 31, 2015"
		      }, {
		        "v": "26"
		      }]
		    }, {
		      "c": [{
		        "v": "Date(2015,5,01)",
		        "f": "Monday, June 01, 2015"
		      }, {
		        "v": "148"
		      }]
		    }, {
		      "c": [{
		        "v": "Date(2015,5,02)",
		        "f": "Tuesday, June 02, 2015"
		      }, {
		        "v": "299"
		      }]
		    }, {
		      "c": [{
		        "v": "Date(2015,5,03)",
		        "f": "Wednesday, June 03, 2015"
		      }, {
		        "v": "285"
		      }]
		    }, {
		      "c": [{
		        "v": "Date(2015,5,04)",
		        "f": "Thursday, June 04, 2015"
		      }, {
		        "v": "273"
		      }]
		    }, {
		      "c": [{
		        "v": "Date(2015,5,05)",
		        "f": "Friday, June 05, 2015"
		      }, {
		        "v": "205"
		      }]
		    }, {
		      "c": [{
		        "v": "Date(2015,5,06)",
		        "f": "Saturday, June 06, 2015"
		      }, {
		        "v": "143"
		      }]
		    }, {
		      "c": [{
		        "v": "Date(2015,5,07)",
		        "f": "Sunday, June 07, 2015"
		      }, {
		        "v": "213"
		      }]
		    }, {
		      "c": [{
		        "v": "Date(2015,5,08)",
		        "f": "Monday, June 08, 2015"
		      }, {
		        "v": "314"
		      }]
		    }, {
		      "c": [{
		        "v": "Date(2015,5,09)",
		        "f": "Tuesday, June 09, 2015"
		      }, {
		        "v": "301"
		      }]
		    }, {
		      "c": [{
		        "v": "Date(2015,5,10)",
		        "f": "Wednesday, June 10, 2015"
		      }, {
		        "v": "287"
		      }]
		    }, {
		      "c": [{
		        "v": "Date(2015,5,11)",
		        "f": "Thursday, June 11, 2015"
		      }, {
		        "v": "274"
		      }]
		    }, {
		      "c": [{
		        "v": "Date(2015,5,12)",
		        "f": "Friday, June 12, 2015"
		      }, {
		        "v": "329"
		      }]
		    }, {
		      "c": [{
		        "v": "Date(2015,5,13)",
		        "f": "Saturday, June 13, 2015"
		      }, {
		        "v": "229"
		      }]
		    }, {
		      "c": [{
		        "v": "Date(2015,5,14)",
		        "f": "Sunday, June 14, 2015"
		      }, {
		        "v": "188"
		      }]
		    }, {
		      "c": [{
		        "v": "Date(2015,5,15)",
		        "f": "Monday, June 15, 2015"
		      }, {
		        "v": "304"
		      }]
		    }, {
		      "c": [{
		        "v": "Date(2015,5,16)",
		        "f": "Tuesday, June 16, 2015"
		      }, {
		        "v": "317"
		      }]
		    }, {
		      "c": [{
		        "v": "Date(2015,5,17)",
		        "f": "Wednesday, June 17, 2015"
		      }, {
		        "v": "211"
		      }]
		    }, {
		      "c": [{
		        "v": "Date(2015,5,18)",
		        "f": "Thursday, June 18, 2015"
		      }, {
		        "v": "288"
		      }]
		    }, {
		      "c": [{
		        "v": "Date(2015,5,19)",
		        "f": "Friday, June 19, 2015"
		      }, {
		        "v": "345"
		      }]
		    }, {
		      "c": [{
		        "v": "Date(2015,5,20)",
		        "f": "Saturday, June 20, 2015"
		      }, {
		        "v": "190"
		      }]
		    }, {
		      "c": [{
		        "v": "Date(2015,5,21)",
		        "f": "Sunday, June 21, 2015"
		      }, {
		        "v": "169"
		      }]
		    }, {
		      "c": [{
		        "v": "Date(2015,5,22)",
		        "f": "Monday, June 22, 2015"
		      }, {
		        "v": "454"
		      }]
		    }, {
		      "c": [{
		        "v": "Date(2015,5,23)",
		        "f": "Tuesday, June 23, 2015"
		      }, {
		        "v": "331"
		      }]
		    }, {
		      "c": [{
		        "v": "Date(2015,5,24)",
		        "f": "Wednesday, June 24, 2015"
		      }, {
		        "v": "325"
		      }]
		    }, {
		      "c": [{
		        "v": "Date(2015,5,25)",
		        "f": "Thursday, June 25, 2015"
		      }, {
		        "v": "371"
		      }]
		    }, {
		      "c": [{
		        "v": "Date(2015,5,26)",
		        "f": "Friday, June 26, 2015"
		      }, {
		        "v": "368"
		      }]
		    }, {
		      "c": [{
		        "v": "Date(2015,5,27)",
		        "f": "Saturday, June 27, 2015"
		      }, {
		        "v": "250"
		      }]
		    }, {
		      "c": [{
		        "v": "Date(2015,5,28)",
		        "f": "Sunday, June 28, 2015"
		      }, {
		        "v": "177"
		      }]
		    }, {
		      "c": [{
		        "v": "Date(2015,5,29)",
		        "f": "Monday, June 29, 2015"
		      }, {
		        "v": "371"
		      }]
		    }, {
		      "c": [{
		        "v": "Date(2015,5,30)",
		        "f": "Tuesday, June 30, 2015"
		      }, {
		        "v": "352"
		      }]
		    }]
		  }

  var options = {
    width: 900,
    height: 250,
    pointSize: 3,
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
      duration: 500,
      easing: 'out',
    }
  };

  data = new google.visualization.DataTable(graphData);

  var lineChart = new google.visualization.ChartWrapper({
    chartType: 'LineChart',
    containerId: 'linechart_div',
    options: options
  });

  // Create a date range slider
  var myDateSlider = new google.visualization.ControlWrapper({
    controlType: 'ChartRangeFilter',
    containerId: 'control_div',
    options: {
      filterColumnLabel: 'Date Range',
      width: 950,
      ui: {
        chartType: 'LineChart',
        chartOptions: {
          chartArea: {
            left: 5,
            width: '95%',
            height: 80
          },
          curveType: 'function',
        },
        state: {
          range: {
            start: "Date(2015, 4, 30)",
            end: "Date(2015, 5, 30)"
          }
        },
        // 1 day in milliseconds = 24 * 60 * 60 * 1000 = 86,400,000
        minRangeSize: 86400000
      }
    },
  });

  var dashboard = new google.visualization.Dashboard(document.getElementById('dashboard_div'));
  dashboard.bind(myDateSlider,lineChart);
  google.visualization.events.addListener(myDateSlider, 'statechange', function() {
    var state = myDateSlider.getState();
    console.log(state)
      // do something with state
  });
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

	<div class="container">

		<div class="row">
			<div class="col-xs-4">
				<div id="temp_gauge_div"></div>
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

		<div id="dashboard_div">
		  <table class="columns">
		    <tr>
		      <td>
		        <div id="linechart_div" style="width: 950px; height: 250px;"></div>
		      </td>
		    </tr>
		    <tr>
		      <td>
		        <div id="control_div" style="width: 930px; height: 50px;"></div>
		      </td>
		    </tr>
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

	    <?php include 'footer.php';?>
	</div>
</body>
</html>
