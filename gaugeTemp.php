
	<!-- VIV 1 TEMP GAUGE -->
	<script type="text/javascript">
		google.load("visualization", "1", {packages:["gauge"]});
		google.setOnLoadCallback(drawChart);
		function drawChart() {

			var data = google.visualization.arrayToDataTable([
				['Label', 'Value'],
				['TEMP C', 
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
				greenFrom:20.0, greenTo: 28.5,
				minorTicks: 5
			};
			
			var chart = new google.visualization.Gauge(document.getElementById('temp_gauge_div'));
			
			chart.draw(data, options);
		}
	</script>