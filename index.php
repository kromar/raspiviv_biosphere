<HTML>
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
<title>RasPiViv.com - Home</title>
<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>

	<!-- ROOM TEMP GAUGE -->
	<script type="text/javascript">
		google.load("visualization", "1", {packages:["gauge"]});
		google.setOnLoadCallback(drawChart);
		function drawChart() {

			var data = google.visualization.arrayToDataTable([
				['Label', 'Value'],
				['BASE TMP',
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

						$sql = "SELECT temperature FROM datalogger where sensor = 7 ORDER BY date_time DESC LIMIT 1";
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
				
				['BASE HUM',
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

						$sql = "SELECT humidity FROM datalogger where sensor = 7 ORDER BY date_time DESC LIMIT 1";
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
				minorTicks: 5
			};

			var chart = new google.visualization.Gauge(document.getElementById('roomtemp_div'));
			
			chart.draw(data, options);
		}
	</script>

	<!-- ROOM HUM GAUGE -->
    <script type="text/javascript">
		google.load("visualization", "1", {packages:["gauge"]});
		google.setOnLoadCallback(drawChart);
		function drawChart() {
			
			var data = google.visualization.arrayToDataTable([
				['Label', 'Value'],
				['BASE HUM',
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

						$sql = "SELECT humidity FROM datalogger where sensor = 7 ORDER BY date_time DESC LIMIT 1";
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
				width: 200, height: 200,
				minorTicks: 5
			};

			var chart = new google.visualization.Gauge(document.getElementById('roomhum_div'));
			
			chart.draw(data, options);
		}
    </script>

<!-- VIV 1 TEMP GAUGE -->
    <script type="text/javascript">
		google.load("visualization", "1", {packages:["gauge"]});
		google.setOnLoadCallback(drawChart);
		function drawChart() {

			var data = google.visualization.arrayToDataTable([
				['Label', 'Value'],
				['1 TMP',
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
				width: 200, height: 200,
				greenFrom:20, greenTo: 26,
				minorTicks: 5
			};

			var chart = new google.visualization.Gauge(document.getElementById('viv1temp_div'));

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
				['1 HUM',
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
			  width: 200, height: 200,
			  greenFrom:70, greenTo: 90,
			  minorTicks: 5
			};

			var chart = new google.visualization.Gauge(document.getElementById('viv1hum_div'));

			chart.draw(data, options);
		}
    </script>


	<!-- TANK 1 HISTORY TEMP GRAPH -->
	<script type="text/javascript"
		src="https://www.google.com/jsapi?autoload={
			'modules':[{
			'name':'visualization',
			'version':'1',
			'packages':['corechart']
		}]
	}"></script>

	<script type="text/javascript">
		google.setOnLoadCallback(drawChart);
		function drawChart() {
			var data = google.visualization.arrayToDataTable([
			['TIME', 'TEMP', ],
				<?php
					$db = mysql_connect("localhost","datalogger","datalogger") or die("DB Connect error");
					mysql_select_db("datalogger");

					$q=   "select * from history ";
					$q=$q."where sensor = 8 ";
					$q=$q."order by date_time desc ";
					$q=$q."limit 24";
					$ds=mysql_query($q);

					while($r = mysql_fetch_object($ds))
					{
						echo "['".$r->date_time."', ";
						echo " ".$r->temperature." ],";

					}
				?>
			]);

			var options = {
				title: 'TEMP (C) 24 HR',
				curveType: 'function',
				legend: { position: 'none' },
				hAxis: { textPosition: 'none', direction: '-1' },
			};

			var chart = new google.visualization.LineChart(document.getElementById('tank1tempgraph_div'));

			chart.draw(data, options);
		}
	</script>
	

	<!-- TANK 1 HISTORY HUM GRAPH -->
	<script type="text/javascript"
		src="https://www.google.com/jsapi?autoload={
			'modules':[{
			'name':'visualization',
			'version':'1',
			'packages':['corechart']
		}]
	}"></script>

	<script type="text/javascript">
		google.setOnLoadCallback(drawChart);
		function drawChart() {
			var data = google.visualization.arrayToDataTable([
				['TIME', 'HUMIDITY', ],
				<?php
					$db = mysql_connect("localhost","datalogger","datalogger") or die("DB Connect error");
					mysql_select_db("datalogger");

					$q=   "select * from history ";
					$q=$q."where sensor = 8 ";
					$q=$q."order by date_time desc ";
					$q=$q."limit 24";
					$ds=mysql_query($q);

					while($r = mysql_fetch_object($ds))
					{
						echo "['".$r->date_time."', ";
						echo " ".$r->humidity." ],";

					}
				?>
			]);

			var options = {
				title: 'HUMIDITY (%) 24 HR',
				curveType: 'function',
				legend: { position: 'none' },
				hAxis: { textPosition: 'none', direction: '-1' },
			};

			var chart = new google.visualization.LineChart(document.getElementById('tank1humgraph_div'));

			chart.draw(data, options);
			options['pagingSymbols'] = {prev: 'prev', next: 'next'}; options['pagingButtonsConfiguration'] = 'auto';
		}
    </script>


	
	
	<!-- BASE HISTORY TEMP GRAPH -->
	<script type="text/javascript"
		src="https://www.google.com/jsapi?autoload={
			'modules':[{
			'name':'visualization',
			'version':'1',
			'packages':['corechart']
		}]
	}"></script>

	<script type="text/javascript">
		google.setOnLoadCallback(drawChart);
		function drawChart() {
			var data = google.visualization.arrayToDataTable([
				['TIME', 'TEMP', ],
					<?php
						$db = mysql_connect("localhost","datalogger","datalogger") or die("DB Connect error");
						mysql_select_db("datalogger");

						$q=   "select * from history ";
						$q=$q."where sensor = 8 ";
						$q=$q."order by date_time desc ";
						$q=$q."limit 24";
						$ds=mysql_query($q);

						while($r = mysql_fetch_object($ds))
						{
							echo "['".$r->date_time."', ";
							echo " ".$r->temperature." ],";

						}
					?>
				]);

			var options = {
				title: 'TEMP (C) 24 HR',
				curveType: 'function',
				legend: { position: 'none' },
				hAxis: { textPosition: 'none', direction: '-1' },
			};

			var chart = new google.visualization.LineChart(document.getElementById('roomtempgraph_div'));

			chart.draw(data, options);
		}
	</script>
	

	<!-- BASE HISTORY HUM GRAPH -->
	<script type="text/javascript"
		src="https://www.google.com/jsapi?autoload={
			'modules':[{
			'name':'visualization',
			'version':'1',
			'packages':['corechart']
		}]
	}"></script>

	<script type="text/javascript">
		google.setOnLoadCallback(drawChart);
		function drawChart() {
			var data = google.visualization.arrayToDataTable([
				['TIME', 'HUMIDITY', ],
				<?php
					$db = mysql_connect("localhost","datalogger","datalogger") or die("DB Connect error");
					mysql_select_db("datalogger");

					$q=   "select * from history ";
					$q=$q."where sensor = 8 ";
					$q=$q."order by date_time desc ";
					$q=$q."limit 24";
					$ds=mysql_query($q);

					while($r = mysql_fetch_object($ds))
					{
						echo "['".$r->date_time."', ";
						echo " ".$r->humidity." ],";

					}
				?>
			]);

			var options = {
				title: 'HUMIDITY (%) 24 HR',
				curveType: 'function',
				legend: { position: 'none' },
				hAxis: { textPosition: 'none', direction: '-1' },
			};

			var chart = new google.visualization.LineChart(document.getElementById('roomhumgraph_div'));

			chart.draw(data, options);
			options['pagingSymbols'] = {prev: 'prev', next: 'next'}; options['pagingButtonsConfiguration'] = 'auto';
		}
		
	</script>


</head>
	<body>
		<div class="jumbotron">
			<div class="container">
				<?php include 'menu.php';?>
				<h3>Base Conditions</h3>
				<?php include 'time.php';?>
			</div>
		</div>
		
		<div class="container">
					<a href="/" title="BASE" alt="BASE">
						<span class="fa-stack fa-2x">
							<i class="fa fa-circle fa-stack-2x"></i>
							<strong class="fa-stack-1x fa-stack-text fa-inverse">B</strong>
						</span>
					</a>
			<div class="row">
				<div class="col-sm-3">
					<div id="roomtemp_div" style="width: auto; height: auto;"></div>
				</div>
				<div class="col-sm-9">
					<div id="roomtempgraph_div" style="width: auto; height: auto;"></div>
				</div>
			</div>	
				
				
			<div class="row">
				<div class="col-sm-3">
					<div id="roomhum_div" style="width: auto; height: auto;"></div>
				</div>
				<div class="col-sm-9">
					 <div id="roomhumgraph_div" style="width: auto; height: auto;"></div>
				</div>
			</div>
			</div>
		</div>
				
		<hr>	
		
		<div class="container">		
			<a href="/graph01.php" title="VIV 1" alt="VIV 1">
				<span class="fa-stack fa-2x">
				  <i class="fa fa-circle fa-stack-2x"></i>
				  <strong class="fa-stack-1x fa-stack-text fa-inverse">1</strong>
				</span>
			</a>
			
			<div class="row">
				<div class="col-sm-3">
					<div id="viv1temp_div" style="width: auto; height: auto;"></div>
				</div>
				<div class="col-sm-9">
					<div id="tank1tempgraph_div" style="width: auto; height: auto;"></div>
				</div>
			</div>	
				
				
			<div class="row">
				<div class="col-sm-3">
					<div id="viv1hum_div" style="width: auto; height: auto;"></div>
				</div>
				<div class="col-sm-9">
					 <div id="tank1humgraph_div" style="width: auto; height: auto;"></div>
				</div>
			</div>
			</div>
		</div>
		
		<hr>
		
		
		<!--  combined graph -->
		<div class="container">		
			<a href="/graph03.php" title="VIV 1" alt="VIV 1">
				<span class="fa-stack fa-2x">
				  <i class="fa fa-circle fa-stack-2x"></i>
				  <strong class="fa-stack-1x fa-stack-text fa-inverse">1</strong>
				</span>
			</a>
			
			<div class="row">
				<div class="col-sm-3">
					<div id="viv1temp_div" style="width: auto; height: auto;"></div>
				</div>
				<div class="col-sm-9">
					<div id="tank1tempgraph_div" style="width: auto; height: auto;"></div>
				</div>
			</div>	
				
				
			<div class="row">
				<div class="col-sm-3">
					<div id="viv1hum_div" style="width: auto; height: auto;"></div>
				</div>
				<div class="col-sm-9">
					 <div id="tank1humgraph_div" style="width: auto; height: auto;"></div>
				</div>
			</div>
			</div>
		</div>
		
		<hr>
		
		
		<div class="container">	
			<?php include 'footer.php';?>
		</div>
	</BODY>
</HTML>

