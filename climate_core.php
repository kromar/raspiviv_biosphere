<?php
	include_once 'log.php';
	$interval = 30;
	$somearg;
	$coreActive = false;

	if ($coreActive == false) {
		$coreActive = true;
		logToFile("core activated", '', '');
		continue;
	} else {
		while (true) {
			//for ($i = 0; $i < $max_clients; $i++)
			//exec("php sensor.php");
			//exec("php cliamte_control.php $somearg");	//use ajax so the user wont know the file is loaded
			logToFile("core interval", $interval, $somearg);
			sleep($interval);
		}

	}

	//nohup php myscript.php &		//this creates a service
	//use upstart to restart services that get killed http://upstart.ubuntu.com/
?>
