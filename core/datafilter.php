<?php
		include_once '/var/www/html/log.php';
		global $debugMode;
		$debugMode = true;

		class kalmanFilter {
			var $A = 1.1;
			var $B = 0;
			var $C = 1;
			var $R = 0.01;
			var $Q = 20;

			function filter($z, $u=0) {
				global $debugMode;
				static $x = null;
				static $cov = null;
				logToFile("kalman input: ", $z,  '<<<<<<<<');

				if ($this->x === null) {
					$this->x = (1 / $this->C) * $z;
		     		$this->cov = (1 / $this->C) * $this->Q * (1 / $this->C);
					if ($debugMode==true) {
						logToFile("initializing X: ", $this->x, '');
					}
				} else {
					if ($debugMode==true) {
						logToFile("TEST3: ", $z, $u);
					}
				    // Compute prediction
				    $this->predX = $this->predict($u);
				    $this->predCov = $this->uncertainty();
					if ($debugMode==true) {
						logToFile("kalman predictions: ", $this->predX, $this->predCov);
					}

				    // Kalman gain
				    $this->K = $this->predCov * $this->C * (1 / (($this->C * $this->predCov * $this->C) + $this->Q));
					if ($debugMode==true) {
						logToFile("kalman gain: ", $this->K, '');
					}

				     // Correction
				     $this->x = $this->predX + $this->K * ($this->z - ($this->C * $this->predX));
				     $this->cov = $this->predCov - ($this->K * $this->C * $this->predCov);
					if ($debugMode==true) {
				     	logToFile("kalman correction: ", $this->x, $this->cov);
					}
				}
				logToFile("kalman output: ", $this->x.$x, '>>>>>>>');
			    return $this->x;
			}

			//predict next value
			public function  predict($u, $x=0) {
	   			return ($this->A * $x) + ($this->B * $u);
			}

			//  Return uncertainty of filter
			public function uncertainty() {
				return (($this->A * $this->cov) * $this->A) + $this->R;
			 }
		}


