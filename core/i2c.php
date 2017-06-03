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
	global $PCF8574, $pin_io, $simulationActive;
	$simulationActive = False;

	// TODO: validate // sanitize // save to db // blah blah // do something with params

	//$pin = $argv[2];
	//$pin_state = $argv[3];
	//$PCF8574 = $argv[4];
	$pin_io = array(0,0,0,0,0,0,0,0);
	//$simulationActive = $argv[1];
	//get argument from ajax request
	// TODO: you can do isset check before
	//if(isset($_POST['action']) && !empty($_POST['action'])) {


	//this fucntion sets the pins of the ic to 1 or 0
	function setICPins($pin, $pin_enabled) {

		log_to_file("running function setICPins");

		global $PCF8574, $pin_io;
		$pin = $pin-1; 	//correction for physical pin vs array position
		//set a specific output
		if ($pin <= count($pin_io)){
			$pin_io[$pin] = $pin_enabled;
		} else {
			log_to_file("value out of array range");
		}
		//convert to hex value from the binary array
		//$binary = ($pin_io[0].$pin_io[1].$pin_io[2].$pin_io[3].$pin_io[4].$pin_io[5].$pin_io[6].$pin_io[7]);
		$binary = implode("", $pin_io);
		$hex = "0x".dechex(bindec($binary));
		//echo "binary: ". $binary."\n";
		//echo "hex:". $hex."\n";
		log_to_file("$pin i2cset -y 1 $PCF8574 $hex");
		exec("i2cset -y 1 '0x27' $hex"); //or die(log_to_file("i2c failed"));
	}


	$simulationActive = $_POST['action'];

	simulateIO($simulationActive);
	// this function simulates switching through all io pins of the ic chip
	function simulateIO($simulationActive) {
		$mode = 1;
		$io_count = 8;
		log_to_file($simulationActive);
		//while ($simulationActive == True) {
			// start enabling all pins
			if ($mode == 1) {
				for ($pin = 1; $pin <= $io_count; $pin++)	 {
					setICPins($pin, 1);
					exec(usleep(200000));
			 	}
			 	$mode = 0;
			 	exec(sleep(1));
			}
			//start disabling all pins
			elseif ($mode== 0) {
				for ($pin = $io_count; $pin >= 1; $pin--) {
					setICPins($pin, 0);
					exec(usleep(200000));
			 	}
			 	$mode = 1;
			 	exec(sleep(3));
			}
		//}
	}


?>


