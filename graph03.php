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

	
	<!-- temp-hum graph-->
	
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
			$q = $q . "limit 360";
			$ds = mysql_query ( $q );
			
			while ( $r = mysql_fetch_object ( $ds ) ) {
				echo "['" . $r->date_time . "', ";
				echo " " . $r->temperature . " ,";
				echo " " . $r->humidity . " ],";
				}
		?>
		]);
	
		var options = {
			title: 'Temperature - Humidity',
			curveType: 'none',
			backgroundColor: {stroke: 'black', fill: 'white', strokeSize: 1},
			legend: { position: 'bottom' },
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
		
		var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
		
		chart.draw(data, options);
		}
	</script>
	


</head>
<body>
	<div class="jumbotron">
		<div class="container">
			<?php include 'menu.php';?>
			<h2>Sensor 3</h2>			
			<?php include 'time.php';?>
		</div>
	</div>
	
	<div class="container">
	    <div id="chart_div" style="width: auto; height: 600;"></div>
	    <hr>
	    <?php include 'footer.php';?>
	</div>
</body>
</html>
