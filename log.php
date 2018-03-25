<?php
	function logToFile($value0, $value1, $value2) {
		$megabytes = 2;
		$path ='/var/log/raspiviv/';
		$file = "raspiviv.log";

		if (file_exists($path.$file)) {
			$size = filesize($path.$file);
			$curentTime = date('H:i:s');

			//reset file size if it grows to big
			if ($size < $megabytes * 1024 * 1000) {
				$mylogfile = fopen($path.$file, "a") or die("Unable to open file!");
				try {
					//fwrite($mylogfile, $curentTime . " size: " . $size ." file: " . __DIR__ . $file ."\n");
					fwrite($mylogfile, "<b> $curentTime  $value0  $value1  $value2 </b> \n");
					fclose($mylogfile);

				} catch (Exception $e) {
					echo 'Caught exception: ',  $e->getMessage(), "\n";
				}
			} else {
				$mylogfile = fopen($path.$file, "w") or die("Unable to open file!");
				fwrite($mylogfile, $curentTime . " reset file size \n");
				fclose($mylogfile);
			}
		} else {
				mkdir($path, 0777, true);
		}
	}
?>