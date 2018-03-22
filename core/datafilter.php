<?php
		include_once '/var/www/html/log.php';
		$debugMode = true;

		global $temperature, $humidity, $debugMode;
		global $debugMode, $x,$B,$A,$R,$C,$cov,$Q;
		function kalmanFilter($z=0, $u=0) {
			$R = 0.01; 	 // noise power desirable
			$Q = 20;  	// noise power estimated
			$A = 1.1;
			$B = 0;
			$C = 1;
			if ($debugMode==true) {
				logToFile("TEST1: ", $z, '>>>>>>>>');
			}

			$R = $R;
			$Q = $Q;
			$B = $B;
			$cov = $cov;
			$x = $x; 	 // estimated signal without noise

			if ($x == null) {
				$x = (1 / $C) * $z;
	     		$cov = (1 / $C) * $Q * (1 / $C);
				if ($debugMode==true) {
					logToFile("initializing X: ", $x, '');
				}
			} else {
				if ($debugMode==true) {
					logToFile("TEST3: ", $z, $u);
				}
			    // Compute prediction
			    $predX = predict($u);
			    $predCov = uncertainty();
				if ($debugMode==true) {
					logToFile("TEST PREDICTIONS: ", $predX, $predCov);
				}

			    // Kalman gain
			    $K = $predCov * $C * (1 / (($C * $predCov * $C) + $Q));
				if ($debugMode==true) {
					logToFile("TEST GAIN: ", $K, '');
				}

			     // Correction
			     $x = $predX + $K * ($z - ($C * $predX));
			     $cov = $predCov - ($K * $C * $predCov);
				if ($debugMode==true) {
			     	logToFile("TEST CORRECTION: ", $x, $cov);
				}
			}
			logToFile("RETURN FILTERED: ", $x, '<<<<<<<<');
		    return $x;

			//predict next value
			function  predict($u) {
				global $A, $x,$B;
	   			return ($A * $x) + ($B * $u);
			}

			//  Return uncertainty of filter
			function uncertainty() {
				global $A, $cov,$A,$R;
				return (($A * $cov) * $A) + $R;
			 }
		}
