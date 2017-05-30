<?php
	include '/var/www/html/log.php';
	include '/var/www/html/core/config.php';

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

	global $PCF8574, $pin_io, $statusActive, $simulationActive;
	$statusActive = False;
	$PCF8574 = '0x27';



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
		global $PCF8574, $pin_io;
		$pin = $pin-1; 	//correction for physical pin vs array position
		//set a specific output
		if ($pin <= count($pin_io)){
			$pin_io[$pin] = $pin_enabled;
		} else {
			echo "value out of array range";
		}
		//convert to hex value from the binary array
		//$binary = ($pin_io[0].$pin_io[1].$pin_io[2].$pin_io[3].$pin_io[4].$pin_io[5].$pin_io[6].$pin_io[7]);
		$binary = implode("", $pin_io);
		echo "binary: ". $binary."\n";
		$hex = "0x".dechex(bindec($binary));
		echo "hex:". $hex."\n";
		system("i2cset -y 1 $PCF8574 $hex");
	}


simulateIO($_POST['action']);

// this function simulates switching through all io pins of the ic chip
function simulateIO($simulationActive) {
	$mode = 1;
	$io_count = 8;

	while ($simulationActive) {
		// start enabling all pins
		if ($mode == 1) {
			for ($pin = 1; $pin <= $io_count; $pin++)	 {
				setICPins($pin, 1);
				usleep(200000);
			 	}
			 	$mode = 0;
			 	sleep(1);
			}
			//start disabling all pins
		if ($mode== 0) {
			for ($pin = $io_count; $pin >= 1; $pin--) {
				setICPins($pin, 0);
				usleep(200000);
			 	}
			 	$mode = 1;
			 	sleep(3);
			}
		}
	}

?>


