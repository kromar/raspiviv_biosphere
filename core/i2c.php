<?php
	include '/var/www/html/log.php';
	include '/var/www/html/core/config.php';

	log_to_file("i2c executing");

	//dec to hex
		//dechex(x)
	//hex to dec
		//shexdex(x)
	//i2cdetect -y 1
	//i2cdump -y 0x..
	//i2cset -y 1 0x27 0x..
	//system("gpio mode $pin out");
	//system("gpio write $pin $status[$pin]");
	//exec ("gpio read ".$pin, $status[$pin], $return );

	$PCF8574 = '0x27';
	global $PCF8574, $pin_io;
	$simulationActive = False;

	// TODO: validate // sanitize // save to db // blah blah // do something with params

	//$pin = $argv[2];
	//$pin_state = $argv[3];
	//$PCF8574 = $argv[4];
	//$simulationActive = $argv[1];
	//get argument from ajax request
	// TODO: you can do isset check before
	//if(isset($_POST['action']) && !empty($_POST['action'])) {

	reset_IO_Pins();
	function reset_IO_Pins() {
		//only create if it doesnt exist, otherwise only modify
		if (!$pin_io) {
			$pin_io = array(0,0,0,0,0,0,0,0);
			log_to_file("RESET array:". implode("",$pin_io));
		} else {
			$pin_io=$pin_io;
			log_to_file("keeping array:". implode("",$pin_io));
		}
		return $pin_io;
	}

	get_IO_Pins();
	function get_IO_Pins() {
		exec("i2cget -y 1 $PCF8574", $output, $return_var);
		//$return = implode(" ", $return);
		log_to_file("GET $return $output \n");
	}

	//this fucntion sets the pins of the ic to 1 or 0
	function setICPins($pin, $pin_status) {
		global $PCF8574, $pin_io;

		log_to_file("running function setICPins");
		log_to_file($pin);
		$pin = $pin-1; 	//correction for physical pin vs array position

		//set a specific output
		if ($pin <= count($pin_io)){
			$pin_io[$pin] = $pin_status;
			//convert to hex value from the binary array
			//$binary = ($pin_io[0].$pin_io[1].$pin_io[2].$pin_io[3].$pin_io[4].$pin_io[5].$pin_io[6].$pin_io[7]);
			$binary = implode("", $pin_io);
			log_to_file("implode binary $binary");
			$hex = "0x".dechex(bindec($binary));
			//echo "binary: ". $binary."\n";
			//echo "hex:". $hex."\n";
			log_to_file("$pin i2cset -y 1 $PCF8574 $hex");
			exec("i2cset -y 1 '0x27' $hex");
		} else {
			log_to_file("value out of array range");
		}
	}



	// since the count is always from pin 0, all the pins get reset at first.
	// so figure out why pins get reset, this means our array gets reset, lets keep it!

	simulateIO();

	// this function simulates switching through all io pins of the ic chip
	function simulateIO() {
		$simulationActive = $_POST['action'];
		log_to_file($simulationActive);
		$direction = 1;		 //1=up; 0=down
		$io_count = 8;

		// while ($simulationActive == true) {

			// start enabling all pins
			if ($direction == 1) {
				for ($pin = 1; $pin <= $io_count; $pin++)	 {
					log_to_file("counting up: $pin");
					setICPins($pin, 1);
					//exec(usleep(200000));
		 			exec(sleep(1));
			 	}
			 	$direction = 0;
			 	exec(sleep(3));
			}

			//start disabling all pins
			elseif ($direction== 0) {
				for ($pin = $io_count; $pin >= 1; $pin--) {
				log_to_file("counting down: $pin");
					setICPins($pin, 0);
					//exec(usleep(200000));
			 		exec(sleep(1));
			 	}
			 	$direction = 1;
			 	exec(sleep(3));
			}
		//}

			//TODO: make a copy of the original array and restore its state once simualation is finished

	}


?>


