<?php
		include_once '/var/www/html/log.php';
		global $temperature, $humidity, $debugMode;
		$debugMode = true;





	function lowPassFilter($value, $iterations, $sensor) {

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


	class kalmanFilter {

		public $R = 1;
		public $Q = 1;
		public $A = 1;
		public $B = 0;
		public $C = 1;

		// Filter a new value
		function filter($z, $u=0) {

			logToFile("TEST1: ", $z, $u);

			$this->R = $R; 	// noise power desirable
			$this->Q = $Q;   // noise power estimated
			$this->B = $B;
			$this->cov = null;
			$this->x = null; 	 // estimated signal without noise

			if ($x == null) {
				logToFile("TEST2: ", $z, $u);
      			$x = (1 / $C) * $z;
     			$cov = (1 / $C) * $Q * (1 / $C);
				logToFile("TEST2 OUTPUT: ", $x, $cov);

			} else {
				logToFile("TEST3: ", $z, $u);
			    // Compute prediction
			    $predX = $this->predict($u);
			    $predCov = $this->uncertainty();
				logToFile("TEST PREDICTIONS: ", $predX, $predCov);

			    // Kalman gain
			    $K = $predCov * $this->C * (1 / (($this->C * $predCov * $this->C) + $this->Q));
				logToFile("TEST GAIN: ", $K, '');

			     // Correction
			     $x = $predX + $K * ($z - ($this->C * $predX));
			     $cov = $predCov - ($K * $this->C * $predCov);
			     logToFile("TEST CORRECTION: ", $this->x, $this->cov);
				}

				logToFile("TEST RETURN: ", $this->x, '');
			    return $this->x;
			}

			//predict next value
			function  predict($u = 0) {
				logToFile("TEST PREDICT: ", $u, $u);
    			return ($this->A * $this->x) + ($this->B * $u);
			}

			 //  Return uncertainty of filter
			 function uncertainty() {
			    return (($this->A * $this->cov) * $this->A) + $this->R;
			  }

			//  Return the last filtered measurement
 			function lastMeasurement() {
    			return $this->x;
  			}

  			// Set measurement noise Q
  			function setMeasurementNoise($noise) {
    			$this->Q = $noise;
  			}

  			// Set the process noise R
	 		function setProcessNoise($noise) {
    			$this->R = $noise;
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
