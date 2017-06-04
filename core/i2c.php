<?php
	include '/var/www/html/log.php';
	include '/var/www/html/core/config.php';

	//system("gpio mode $pin out");
	//system("gpio write $pin $status[$pin]");
	//exec ("gpio read ".$pin, $status[$pin], $return );

	$PCF8574 = '0x27';
	global $PCF8574, $io_array;
	$simulationActive = False;

	// TODO: validate // sanitize // save to db // blah blah // do something with params

	//$pin = $argv[2];
	//$pin_state = $argv[3];
	//$PCF8574 = $argv[4];
	//$simulationActive = $argv[1];

	//set all pins to high or low
	function reset_IO_Pins($state) {
		global $io_array;
		//only create if it doesnt exist, otherwise only modify
		if ($state == 'high') {
			$io_array = array(1,1,1,1,1,1,1,1);
		} elseif ($state == 'low') {
			$io_array = array(0,0,0,0,0,0,0,0);
		}
			log_to_file("RESET array:". implode("",$io_array));
	}


	function get_IO_Pins() {
		global $PCF8574, $io_array;
		$output = exec("i2cget -y 1 $PCF8574");
		//remove 0x from $output and convert to binary array
		$hex = ltrim($output, "0x");
		$binary = decbin(hexdec($hex));
		//set return as our array
		$io_array = str_split($binary);
		log_to_file("GET $hex $binary");
		return $io_array;
	}

	//this fucntion sets the pins of the ic to 1 or 0
	function set_IO_Pins($pin, $pin_status) {
		log_to_file("set_IO_Pins for pin: $pin");
		get_IO_Pins();
		global $PCF8574, $io_array;

		//correction for physical pin vs array position
		$pin = $pin-1;

		//set a specific output
		if ($pin <= count($io_array)){
			$io_array[$pin] = $pin_status;
			//convert to hex value from the binary array
			$binary = implode("", $io_array);
			$hex = "0x".dechex(bindec($binary));
			log_to_file("SET $hex $binary");
			log_to_file("i2cset -y 1 $PCF8574 $hex \n");
			exec("i2cset -y 1 $PCF8574 $hex");
			//do we need to get the new io_array here and set as global?
		} else {
			log_to_file("value out of array range");
		}
	}



	// since the count is always from pin 0, all the pins get reset at first.
	// so figure out why pins get reset, this means our array gets reset, lets keep it!


	if(isset($_POST['action']) && !empty($_POST['action'])) {
		simulateIO($_POST['action']);
	}

	// this function simulates switching through all io pins of the ic chip
	function simulateIO($simulationActive) {
		log_to_file("------starting IO simulation---------");
		log_to_file($simulationActive);

		$direction = 1;		 //1=up; 0=down
		$io_count = 8;

		global $io_array;
		$temp_array = $io_array;
		$sim_array = reset_IO_Pins('low');
		$io_array = $sim_array;

		while ($simulationActive) {
			$simulationActive = $simulationActive;
			log_to_file(var_dump($simulationActive));
			if (!$simulationActive) {
				break;
			} else {
				// start enabling all pins
				if ($direction == 1) {
					for ($pin = 1; $pin <= $io_count; $pin++)	 {
						set_IO_Pins($pin, 1);
						usleep(200000);
				 	}
				 	$direction = 0;
				 	sleep(3);
				}
				//start disabling all pins
				if ($direction== 0) {
					for ($pin = $io_count; $pin >= 1; $pin--) {
						set_IO_Pins($pin, 0);
						usleep(200000);
				 	}
				 	$direction = 1;
				 	sleep(3);
				}
			}
			sleep(5);
		}
			//TODO: make a copy of the original array and restore its state once simualation is finished

		//restor original IO state after running simulation
		$io_array = $temp_array;
	}


?>


