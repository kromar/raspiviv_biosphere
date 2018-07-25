<?php

	function readSensor($sensor) {
		while (true) {
			$time = date('H:i:s');
			$output = array();
			//exec("sudo loldht $sensor", $output);
			exec("sudo loldht $sensor | grep -i 'humidity' | cut -d ' ' -f3", $output);
			exec("sudo loldht $sensor | grep -i 'temperature' | cut -d ' ' -f7", $output);
			$count = count($output);
			//echo "count: $count \n";

			for ($i = 0; $i < $count; $i++) {
				$value = floatval($output[$i]);
				if ($value > 100) {
					echo "$time  $sensor $i " .$value."\n";				
					//echo "humid: " .gettype($output[1])."\n";
					//echo "temp: " .$output[2]."\n";
					//sleep(1);
				}
			}
			//echo "\n";
		}
	
	}

	readSensor(8);
	//readSensor(9);



?>