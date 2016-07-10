<?php
	include_once 'log.php';
	var_dump($argv); //variables from climate_core.php
	//write sensor values to sql database every update interval
	function readSensor($sensor)
	{
		$interval = $argv;
		$output = array();
		$return_var = 0;
		$i=1;
		exec('sudo /usr/local/bin/loldht '.$sensor, $output, $return_var);
	  	while (substr($output[$i],0,1)!="H") {
			//logToFile("loldht output", $output[$i], $i);
            $i++;
            sleep($interval);
		}
			$humid=substr($output[$i],11,5);
			logToFile("loldht humid", $humid, $i);
	        $temp=substr($output[$i],33,5);
			logToFile("loldht temp", $temp, $i);

			//sudo /opt/lol_dht22/loldht 7 | grep -i "humidity" | cut -d ' ' -f3
			//sudo /opt/lol_dht22/loldht 7 | grep -i "temperature" | cut -d ' ' -f7

			/*

			#!/bin/sh

			case $1 in
			config)
			cat <<'EOM'
			graph_title relative Luftfeuchtigkeit
			graph_vlabel humidity
			humidity.label r. F. %
			EOM
			exit 0;;
			esac

			printf "humidity.value "
			/opt/lol_dht22/loldht 7 | grep -i "humidity" | cut -d ' ' -f3
			//=====================================

			#!/bin/sh

			case $1 in
			config)
			cat <<'EOM'
			graph_title Temperatur
			graph_vlabel temperature
			temperature.label °C
			EOM
			exit 0;;
			esac

			printf "temperature.value "
			/opt/lol_dht22/loldht 7 | grep -i "temperature" | cut -d ' ' -f7
			//=========================================

			//*/

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
	/*
	function timerSensor($pin, $time, $inverted, $reason) {
		include_once 'log.php';
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
	//*/
?>

