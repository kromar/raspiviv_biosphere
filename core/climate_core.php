<?php
	include_once '/var/www/html/log.php';
	$interval = 60;
	$somearg;
	$coreActive = false;
	$debugMode = false;

	while (true) {
		if ($coreActive == false) {
			if ($debugMode == true) {
				shell_exec("watch -n 1 tail ../../log/raspiviv.log");
				shell_exec("watch -n 10 tail ../../log/apache2/error.log");
			}
			else {
				if ($debugMode==true) {
					logToFile("shell exec failed");
				}
			}
			$coreActive = true;
			if ($debugMode==true) {
				logToFile("core initialized". $interval . $coreActive);
			}

		} else {
			//for ($i = 0; $i < $max_clients; $i++)
			//$escaped_command = escapeshellcmd("php /home/pi/sensor.php");
			//logToFile("escapecommand" . $escaped_command);
			//exec("php /home/pi/sensor.php");
			//exec("php cliamte_control.php $interval");	//use ajax so the user wont know the file is loaded
			if ($debugMode == true) {
				logToFile("core interval" . $interval . $coreActive);
			}
			sleep($interval);
		}
	}


	//nohup php myscript.php &		//this creates a service
	//use upstart to restart services that get killed http://upstart.ubuntu.com/
?>
