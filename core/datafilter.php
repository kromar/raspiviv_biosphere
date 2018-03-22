<?php
		include_once '/var/www/html/log.php';
		global $temperature, $humidity, $debugMode;
		$debugMode = true;

	function lowPassFilter($value, $iterations, $sensor) {
		global $debugMode;
		$average = 0.0;        // the running average
		$filterWeight = 0.9;   // weight of the current reading in the average
		$numReadings = 10; // number of readings per average
		$iterations = 3;
		$iterations = $iterations;


		function loop() {
		  	$sensorReading;

			  // take ten readings to get a reasonably good sample size
			  // before printing:
			  for ( $iterations = 0; $iterations < $numReadings; $iterations++) {
			  		$sensorReading = analogRead(A0);
			    	$average = $filterWeight * ($sensorReading) + (1 - $filterWeight ) * $average;
		  }
		  // print the result:
		  //Serial.println(sensorReading);
		  //  Serial.print(",");
		 // Serial.println(average);
		}
	}

	function kalmanFilter($z=0, $u=0, ) {
		global $debugMode;


		$R = 0.01;
		$Q = 20;
		$A = 1.1;
		$B = 0;
		$C = 1;
		logToFile("TEST1: ", $z, '>>>>>>>>');

		$R = $R; 	// noise power desirable
		$Q = $Q;   // noise power estimated
		$B = $B;
		$cov = $cov;
		$x = $x; 	 // estimated signal without noise

		if ($x == null) {
			$x = (1 / $C) * $z;
     		$cov = (1 / $C) * $Q * (1 / $C);
		} else {
			logToFile("TEST3: ", $z, $u);
		    // Compute prediction
		    $predX = $predict($u);
		    $predCov = $uncertainty();
			logToFile("TEST PREDICTIONS: ", $predX, $predCov);

		    // Kalman gain
		    $K = $predCov * $C * (1 / (($C * $predCov * $C) + $Q));
			logToFile("TEST GAIN: ", $K, '');

		     // Correction
		     $x = $predX + $K * ($z - ($C * $predX));
		     $cov = $predCov - ($K * $C * $predCov);
		     logToFile("TEST CORRECTION: ", $x, $cov);
			}
			logToFile("RETURN FILTERED: ", $x, '<<<<<<<<');
		    return $x;

		//predict next value
		function  predict($u = 0) {
			logToFile("TEST PREDICT: ", $u, $u);
   			return ($A * $x) + ($B * $u);
		}

		//  Return uncertainty of filter
		function uncertainty() {
			return (($A * $cov) * $A) + $R;
		 }

		//  Return the last filtered measurement
 		function lastMeasurement() {
    		return $x;
  		}

  		// Set measurement noise Q
  		function setMeasurementNoise($noise) {
    		$Q = $noise;
  		}

  		// Set the process noise R
	 	function setProcessNoise($noise) {
    		$R = $noise;
	 	}
	}



	function deltaFilter($value, $iterations, $sensor) {
		global $debugMode;
		//change the filtering so we compare our values to previous value in the database,
		// if it deviates by a certain delta then filter the value

		$deltaTemperature = 100;
		$deltaHumidity = 100;
		$filterMax = 100;
		$filterMin = 0;

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
		$sql = "SELECT * FROM datalogger where sensor = $sensor ORDER BY date_time DESC LIMIT 1";
		$result = mysqli_query($db, $sql);

		if (mysqli_num_rows($result) > 0) {
			while($row = mysqli_fetch_assoc($result)) {
				$tempSensor = $row["temperature"];
				$humiditySensor = $row["humidity"];

				// todo: when within 0-100 then continue
				if ($humiditySensor > $filterMin && $humiditySensor < $filterMax) {
					if ($debugMode==true) {
						logToFile("delta filtering value $iterations", $value, $iterations);
					}

					//check if sensor reading deviates by delta to the last sensor reading
					if ($iterations == 0) {	//humidity
						$diffHumidity = abs($humiditySensor - $value);
						echo $diffHumidity;

						if ($debugMode==true) {
							logToFile("humidity delta", $diffHumidity, "$humiditySensor -- $value");
						}

						if ($diffHumidity < $deltaHumidity) {
							return (true);
						} else {
							return (false);
						}
					}
				}

				//filter temperature within specified range
				if ($tempSensor > $filterMin && $tempSensor < $filterMax) {
					if ($iterations == 1) { //temperature
						$diffTemperature = abs($tempSensor - $value);

						if ($debugMode==true) {
							logToFile("temperature delta", $diffTemperature, "$tempSensor -- $value");
						}

						if ($diffTemperature < $deltaTemperature) {
							return (true);
						} else {
							return (false);
						}
					}
				}
				//else out of range
			}
		} else {
    		if ($debugMode==true) {
				logToFile("no db results", '', '');
				return (true);
			}
		}
		mysqli_close($db);
	}
?>
