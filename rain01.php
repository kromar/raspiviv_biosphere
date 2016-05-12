<?php

	$db = mysql_connect("localhost","datalogger","datalogger") or die("DB Connect error");
	mysql_select_db("datalogger");

	$q = "SELECT temperature FROM datalogger where sensor = 8 ORDER BY date_time DESC LIMIT 1";
	$ds = mysql_query($q);
	$tempSensor=(int)mysql_fetch_object($ds)->temperature;


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
	echo $data['main']['temp']."<br>";


	//change threshold depening on time of day
	$tempThreshold;
	$tempNight = 24.5;  //24.5
	$tempDay = 20.5;	//26.5
	$override = true;
	$rainTime = 1; //time in seconds to rain

	$t = time();
	$curentTime = date('H:i');
	$morningTime = ('10:00');
	$eveningTime = ('24:00');
	$rainShedule = array('12:00', '23:40');
	$raintimeShedule = 10;


	//set day or nighttime temp
	if (($curentTime < $morningTime) or ($curentTime > $eveningTime)) {
			$tempThreshold = $tempNight;
	} elseif (($curentTime == $rainShedule[0]) or ($curentTime == $rainShedule[1])) {
		letItRain($raintimeShedule, 0);
	} else {
		$tempThreshold = $tempDay;
		//react to sensor temperatures
		if (($tempSensor > $tempThreshold) or ($override == true)) {
			//adjust rain time depending how high the temp is above our limit
			$tempDelta = ($tempSensor - $tempThreshold);
			if ($tempDelta > 0) {
				$tempDelta = $tempDelta + $rainTime;
				letItRain($tempDelta);
			} else {
				letItRain($rainTime);
			}				
		}
	}

	//rain function
	function letItRain($delta) {
		exec('/usr/local/bin/gpio mode 2 out');
		
		$i = 0;
		while($i < 20) {
		exec('/usr/local/bin/gpio write 2 1');
		sleep($delta);	
		exec('/usr/local/bin/gpio write 2 0');	
		$i++;		
		sleep($delta);	
		}
			
	}

	mysql_query($q);
	mysql_close($db);

?>


