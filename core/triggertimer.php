<?php
	include_once ('/var/www/html/log.php');
	global $temperature, $humidity, $debugMode;
	global $debugMode;
	$debugMode = true;

	//change pull for a given amount of time and then switch back to previous pull state
	function timerSensor($pin, $time, $inverted, $reason) {
		global $debugMode;
		$inverted;
		$high;
		$low;

		if ($inverted == true) {
			$high = 1;
			$low = 0;
		} else {
			$high = 0;
			$low = 1;
		}

		if ($time > 0) {
			exec('/usr/local/bin/gpio mode $pin out');
			exec('/usr/local/bin/gpio write $pin $low');
			sleep($time);
			exec('/usr/local/bin/gpio write $pin $high');
		} elseif ($time == 0) {
			exec('/usr/local/bin/gpio write $pin $high');
		}
		if ($debugMode == ture){
			logToFile("sensor timer" . $time."s" . $reason);
		}
	}

?>