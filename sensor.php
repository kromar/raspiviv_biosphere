<?php
	//write sensor values to sql database every update interval
	function readSensor($sensor)
	{
		$output = array();
		$return_var = 0;
		$i=1;
		exec('sudo /usr/local/bin/loldht '.$sensor, $output, $return_var);
	  	while (substr($output[$i],0,1)!="H")
		{
                $i++;
		}
		$humid=substr($output[$i],11,5);
	        $temp=substr($output[$i],33,5);
	        	$db = mysql_connect("localhost","datalogger","datalogger") or die("DB Connect error");
		mysql_select_db("datalogger");
		$q = "INSERT INTO datalogger VALUES (now(), $sensor, '$temp', '$humid',0)";
		mysql_query($q);
		mysql_close($db);
		return;
	}

	readSensor(8);
	readSensor(9);


	//change pull for a given amount of time and then switch back to previous pull state
	include_once 'log.php';
	function timerSensor($pin, $time, $inverted, $reason) {
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
			logToFile("sensor timer", $time."s", $reason);
			exec('/usr/local/bin/gpio write $pin $high');
		} elseif ($time == 0) {
			logToFile("sensor timer", $time."s", $reason);
			exec('/usr/local/bin/gpio write $pin $high');
		}
	}
?>

