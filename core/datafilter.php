<?php
		include_once '/var/www/html/log.php';
		global $debugMode;
		$debugMode = true;


		class deltaFilter {
			// we combpare the current mesured value with the lasst one and
			// 	see how big the delta value is to decide wether we got a vaalid measurement or not
			private $delta;
			private $last;		//our last recorded value
			static $test;

			function __construct() {
				$this->delta = null;
				$this->last = null;
				self::$test = 0;

			}

			public function filter($value, $d=10) {
				global $debugMode;
				self::$test = self::$test+1;
				logToFile("deltafilter test " . self::$test . '----------------');
				//lets calculate the delta between measurred points
				if ($this->last === null) {
					$this->last = $value;
					logToFile("deltafilter initializing last " . $this->last . '----------------');
					return $this->last;
				} else {
					$this->delta = abs($d / sqrt(pow($value, 2) - pow($this->last, 2)));
					logToFile("new delta ". $this->delta . '+++++++++++');
					$this->last = $value;
					logToFile("deltafilter updating last ". $this->last . '+++++++++++');
					return $this->delta;
				}
			}
		}




		class kalmanFilter {
			var $A = 1.1;
			var $B = 0;
			var $C = 1;
			var $R = 0.01;
			var $Q = 20;
			private  $x = null;
			private  $cov = null;

			public function filter($z, $u=0) {
				global $debugMode;
				$debugMode = false;
				logToFile("kalman input: ", $z,  '<<<<<<<<');

				if ($this->x === null) {
					$this->x = (1 / $this->C) * $z;
		     		$this->cov = (1 / $this->C) * $this->Q * (1 / $this->C);
					if ($debugMode==true) {
						logToFile("initializing X: ", $this->x,'');
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
			public function  predict($u) {
	   			return ($this->A * $this->x) + ($this->B * $u);
			}

			//  Return uncertainty of filter
			public function uncertainty() {
				return (($this->A * $this->cov) * $this->A) + $this->R;
			 }
		}


