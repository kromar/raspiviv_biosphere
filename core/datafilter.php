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

	function kalmanFilter($z=0, $u=0) {
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
