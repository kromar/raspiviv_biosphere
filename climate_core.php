<?php
	include_once 'log.php';
	$interval = 30;
	$somearg;
	$coreActive = false;
	$coreDebugMode = true;

	while (true) {
		if ($coreActive == false) {
			if ($coreDebugMode == true) {
				shell_exec("sudo watch -n 1 tail ../../log/raspiviv.log");
				shell_exec("sudo watch -n 10 tail ../../log/apache2/error.log");
			}
			else {
				logToFile("shell exec failed",'','');
			}
			$coreActive = true;
			logToFile("core initialized", $interval, $coreActive);

		} else {
			//for ($i = 0; $i < $max_clients; $i++)
			exec("php sensor.php $interval");
			exec("php cliamte_control.php $interval");	//use ajax so the user wont know the file is loaded
			if ($coreDebugMode == true) {
				logToFile("core interval", $interval, $coreActive);
			}
			sleep($interval);
		}
	}

	//nohup php myscript.php &		//this creates a service
	//use upstart to restart services that get killed http://upstart.ubuntu.com/
?>
