#!/usr/bin/php -q
<?php

	$db = mysql_connect("localhost","datalogger","datalogger") or die("DB Connect error");
	mysql_select_db("datalogger");

	$q = "SELECT temperature, humidity FROM datalogger where sensor = 8 ORDER BY date_time DESC LIMIT 1";
	$ds = mysql_query($q);
	$tempSensor=(int)mysql_fetch_object($ds)->temperature;
	$humSensor=(int)mysql_fetch_object($ds)->humidity;


	/* used to execute a python script
	 * $command = escapeshellcmd(' /usr/custom/test.py');
	 * $output = shell_exec($command);
	 * echo $output
	 */

	// grab weather information from openweathermap.org
	$city = "Chepo";
	$country = "PA"; // two digit country code

	$url = "http://api.openweathermap.org/data/2.5/weather?q=".$city.",".$country."&units=metric&cnt=7&lang=en";
	$json = file_get_contents($url);
	$data = json_decode($json,true);
	//get rmep in celcius
	echo($data['main']['temp']."<br>");


	//change threshold depening on time of day
	$tempThreshold;
	$tempNight = 24.5;  	// 24.5
	$tempDay = 28.5;		// 26.5
	$humMin = 70.0;
	$rainTime = 1; 			// time in seconds to rain
	$override = false;		// override temperature and rain every minute
	$pumpPrimer = false; 	// set this to true to build up rain system pressure
	$debugMode = true;

	$t = time();
	$curentTime = date('H:i');
	$morningTime = ('10:00');
	$eveningTime = ('22:00');
	$rainShedule = array('12:00', '18:00');
	$raintimeShedule = 10;


	echo("<script>console.log('PHP: ".$tempSensor."');</script>");
	echo("tempSensor: $tempSensor");
	echo("humSensor: $humSensor");
	echo $tempSensor;
	print "am i printing somewhere?";


	//set day or nighttime temp
	if (($curentTime < $morningTime) or ($curentTime > $eveningTime)) {
			$tempThreshold = $tempNight;
	} else {
		$tempThreshold = $tempDay;

		//trigger rain shedules
		if (in_array($curentTime, $rainShedule)) {
			letItRain($raintimeShedule);
		}

		//react to sensor temperatures
		if ($tempSensor > $tempThreshold or $override==true) {
			//adjust rain time depending how high the temp is above our limit
			$tempDelta = ($tempSensor - $tempThreshold);
			if ($tempDelta > 0) {
				$tempDelta = $tempDelta + $rainTime;
				letItRain($tempDelta);;
			} else {
				letItRain($rainTime);
			}
		}
		/*if (($humSensor < $humMin) or ($override == true)) {
			$humDelta = ($humMin - $humSensor);
				if ($humDelta>0) {
					$humDelta = $humDelta + $rainTime;
					letItRain($humDelta);
			} else {
				letItRain($rainTime);
			}
		}
		*/
		if ($pumpPrimer==true and $override==true) {
			$i = 0;
			while($i < 30) {
				letItRain($delta);
				$i++;
			}
		}
	}

	//rain function
	function letItRain($delta) {
		debug_to_console("let it rain");
		if ($debugMode==true) {
			debug_to_console(["let it rain: ", $delta]);
		}
		exec('/usr/local/bin/gpio mode 2 out');
		exec('/usr/local/bin/gpio write 2 0');
		sleep($delta);
		exec('/usr/local/bin/gpio write 2 1');

	}


	// Send debug code to the Javascript console
	function debug_to_console($data) {
		echo("<script>console.log('PHP: ".$data."');</script>");
	}

	mysql_query($q);
	mysql_close($db);

?>

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US" lang="en-US">
<head>
<title></title>
<script src="scripts/jquery-1.12.3.min.js"></script>
</head>
<body>
	<?php echo("<script>console.log('test');</script>"); ?>
</body>
</html>