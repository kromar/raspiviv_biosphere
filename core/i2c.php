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

	$io_count = 8;
	$pin_mode = 0;
	$statusActive = False;
	$PCF8574 = '0x27';

	$pin = $argv[1];
	$pin_state = $argv[2];


	convert($pin, $pin_state);

	function convert($pin, $pin_state)
	{
		$pin = $pin-1;

		$PCF8574 = '0x27';
		$pin_io = array(0,0,0,0,0,0,0,0);


		// now we want to convert the array to a hex output to write status

		//set a specific output
		if ($pin_state)
		{
			$pin_io[$pin] = $pin_state;
		}

		//echo our hex value from the binary array
		$binary = ($pin_io[0].$pin_io[1].$pin_io[2].$pin_io[3].$pin_io[4].$pin_io[5].$pin_io[6].$pin_io[7]);
		$binary_pack = pack('H*', $binary);
		$hex = "0x".dechex(bindec($binary));

		echo "binary: ". $binary."\n";
		echo "hex:". $hex."\n";
		system("i2cset -y 1 $PCF8574 $hex");

	}



	while ($statusActive)
	{

		$mode = 0;
		echo date('h:i:s'). " || ".$PCF8574. "\n";
		system("i2cset -y 1 $PCF8574 0x00");
		sleep(3);
		system("i2cset -y 1 $PCF8574 0xF0");
		sleep(3);
		system("i2cset -y 1 $PCF8574 0x0F");
		sleep(3);
		system("i2cset -y 1 $PCF8574 0xFF");



		for ($pin = 0; $pin < $io_count; $pin++)
		 {
				//system("gpio mode $pin out");
				//system("gpio write $pin $status[$pin]");
				echo "pin: 0x0".dechex($pin)."\n";
				//system("i2cset -y 1 $PCF8574 0x0".dechex($pin));
				$mode = $mode + 2;
				usleep(200000);
		 	}
		 	sleep(3);

			//exec ("gpio read ".$pin, $status[$pin], $return );
	}
?>


