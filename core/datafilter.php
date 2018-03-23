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

			public function filter($z, $u=0) {
				$this->A = $A;
				$this->B = $B;
				$this->C = $C;
				$this->Q = $Q;
				$this->R = $R;
				$this->cov = NULL;
				$this->x = NULL;
				logToFile("kalman input: ", $z,  '<<<<<<<<');
				logToFile("TEST1: ", $this->x, $this->cov);

				if ($this->x == NULL) {
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
				logToFile("kalman output: ", $this->x, '>>>>>>>');
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


