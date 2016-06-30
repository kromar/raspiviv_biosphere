<?php
	function logToFile($string, $value, $reason) {
		$file = "/../debug.log";
		$size = filesize(__DIR__ ."/". $file);
		$curentTime = date('H:i:s');
		if ($size < 4096) {
			$mylogfile = fopen("../debug.log", "a") or die("Unable to open file!");
			try {
				fwrite($mylogfile, $curentTime . " size: " . $size ." file: " . __DIR__ . $file ."\n");
				fwrite($mylogfile, "<b> $curentTime $string : $value : $reason </b> \n");
				fclose($mylogfile);

			} catch (Exception $e) {
				echo 'Caught exception: ',  $e->getMessage(), "\n";
			}
		} else {
			$mylogfile = fopen(__DIR__ . $file, "w") or die("Unable to open file!");
			fwrite($mylogfile, $curentTime . " reset file size \n");
			fclose($mylogfile);
		}
	}
?>