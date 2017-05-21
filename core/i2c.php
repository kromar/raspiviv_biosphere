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

	global $PCF8574, $pin_io, $statusActive;
	$statusActive = False;
	$PCF8574 = '0x27';

	$simulationActive = $argv[1];
	//$pin = $argv[2];
	//$pin_state = $argv[3];
	//$PCF8574 = $argv[4];
	$pin_io = array(0,0,0,0,0,0,0,0);

	simulateIO($simulationActive);

	//this fucntion sets the pins of the ic to 1 or 0
	function setICPins($pin, $pin_enabled) {
		global $PCF8574, $pin_io;
		$pin = $pin-1;
		//set a specific output
		if ($pin_enabled) {
			$pin_io[$pin] = $pin_enabled;
		}

		//convert to hex value from the binary array
		$binary = ($pin_io[0].$pin_io[1].$pin_io[2].$pin_io[3].$pin_io[4].$pin_io[5].$pin_io[6].$pin_io[7]);
		$hex = "0x".dechex(bindec($binary));
		echo "binary: ". $binary."\n";
		echo "hex:". $hex."\n";
		system("i2cset -y 1 $PCF8574 $hex");
	}


// this function simulates switching through all io pins of the ic chip
function simulateIO($simulationActive) {
	while ($simulationActive) {
		$mode = 0;
		$io_count = 8;
		// start enabling all pins
		if ($mode == 0) {
			for ($pin = 0; $pin < $io_count; $pin++)	 {
				setICPins($pin, 1);
				echo $pin."\n";
				$mode++;
				usleep(500000);
			 	}
			 	sleep(3);
			}
			//start disabling all pins
		if ($mode==$io_count) {
			for ($pin = $io_count; $pin > 0; $pin--) {
				setICPins($pin, 0);
				echo $pin."\n";
				$mode--;
				usleep(500000);
			 	}
			 	sleep(3);
			}
			echo "mode: ".$mode;
		}
	}
?>


