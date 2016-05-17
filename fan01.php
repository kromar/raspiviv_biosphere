#!/usr/bin php
<?php

	$db = mysql_connect("localhost","datalogger","datalogger") or die("DB Connect error");
	mysql_select_db("datalogger");

	$qt = "SELECT temperature FROM datalogger where sensor = 8 ORDER BY date_time DESC LIMIT 1";
	$dt = mysql_query($qt);
	$tempSensor=(float)mysql_fetch_object($dt)->temperature;

	$qh = "SELECT humidity FROM datalogger where sensor = 8 ORDER BY date_time DESC LIMIT 1";
	$dh = mysql_query($qh);
	$humiditySensor=(float)mysql_fetch_object($dh)->humidity;


	//change threshold depening on time of day
	$tempThreshold;
	$tempNight = 24.5;  	// 24.5
	$tempDay = 28.5;		// 26.5

	$humidityThreshold;
	$humidityNight = 90.0;
	$humidityDay = 95.0;
	$windTime = 10;

	$t = time();
	$curentTime = date('H:i');
	$morningTime = ('10:00');
	$eveningTime = ('22:00');

	//set day or nighttime humidity
	if (($curentTime < $morningTime) or ($curentTime > $eveningTime))
		{
			$humidityThreshold = $humidityNight;
			$tempThreshold = $tempNight;
		}
		else
		{
			$humidityThreshold = $humidityDay;
			$tempThreshold = $tempDay;

			if ($tempSensor > $tempDay) {
				bringTheAir($windTime);
			}
		}


	//change power state of fan depending on current humidity
	if ($humiditySensor > $humidityThreshold) {
		//wind depending on how much humidity is over our limit
		$windTime = (60 / (100-$humidityThreshold)*($humiditySensor-$humidityThreshold));
		bringTheAir($windTime);
	}


	function bringTheAir($delta) {

		exec('/usr/local/bin/gpio mode 5 out');
		exec('/usr/local/bin/gpio write 5 1');

		//time till wind stops
		sleep ($delta);
		exec('/usr/local/bin/gpio mode 5 out');
		exec('/usr/local/bin/gpio write 5 0');
	}


	mysql_query($qt);
	mysql_query($qh);
	mysql_close($db);
?>
