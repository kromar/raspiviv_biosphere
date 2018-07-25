<?php

	function readSensor($sensor) {
		while (true) {
			$time = date('H:i:s');
			$output = array();
			//exec("sudo loldht $sensor", $output);
			$command = escapeshellarg('sudo loldht '. $sensor. ' | grep -o [0-9][0-9].[0-9][0-9]');
			echo "command: $command\n";
			//exec($command, $output);
			exec("sudo loldht $sensor | grep -o [0-9][0-9].[0-9][0-9] 2>&1", $output);
			$count = count($output);

			for ($i = 0; $i < $count; $i++) {
				$value = floatval($output[$i]);
				if ($value != 100 and $value > 0) {	//filter for realistic values
					$name;
					if ($i == 0) {
						$name = "humidity:";
					} elseif ($i == 1) {
						$name = "temperature:";
					}

					echo "$time  $sensor  $name " .$value."\n";	
					//sleep(1);
				} else {
					//echo "write this to file: $name $value\n";
				}
					
			}
			echo ".";
			//echo "\n";
			//return;
		}
	
	}

	readSensor(8);
	//readSensor(9);



?>