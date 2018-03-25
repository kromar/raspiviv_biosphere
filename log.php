<?php
	function logToFile($value) {
		$megabytes = 2;
		$path ='/var/log/raspiviv/';
		$file = "raspiviv.log";

		if (file_exists($path)) {
			if (file_exists($path.$file)) {
				$size = filesize($path.$file);
				$curentTime = date('H:i:s');
				//reset file size if it grows to big
				if ($size < $megabytes * 1024 * 1000) {
					$mylogfile = fopen($path.$file, "w") or die("Unable to open file!");
					fwrite($mylogfile, "<b> $curentTime  $value</b> \n");
					fclose($mylogfile);
				}
			} else {
				$mylogfile = fopen($path.$file, "w") or die("Unable to open file!");
				fwrite($mylogfile, $curentTime . " reset file size \n");
				fclose($mylogfile);
			}
		} else {
			mkdir($path, 0777, true);
			$mylogfile = fopen($path.$file, "w") or die("Unable to open file!");
			fwrite($mylogfile, $curentTime . " reset file size \n");
			fclose($mylogfile);
		}
	}
?>