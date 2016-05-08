<script type="text/javascript" src="www.google.com/jsapi"></script>
<!-- VIV 1 TEMP GRAPH -->

<script type="text/javascript">
google.load("visualization", "1", {packages:["corechart"]});
google.setOnLoadCallback(drawChart);
function drawChart() {
	var data = google.visualization.arrayToDataTable([
	,
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
		title: 'Temp/hum',
		curveType: 'function',
		backgroundColor: 'lightgreen',
		colors: {'#ff0000', '#0000ff'},
		legend: { position: 'bottum' },
		series: {
		0: {targetAxisIndex: 0},
		1: {targetAxisIndex: 1}
	},
	vAxes: {
		// Adds titles to each axis.
		0: {title: 'TEMP (Celsius)'},
		1: {title: 'HUMIDITY (%)'}
	},
	hAxis: { textPosition: 'none', direction: '-1' },
	};
	var chart = new google.visualization.SteppedAreaChart(document.getElementById('chart2_div'));
	
	chart.draw(data, options);
	}
</script>