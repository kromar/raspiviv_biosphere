<?php
	function logToFile($value) {
		$megabytes = 2;
		$path ='/var/log/raspiviv/';
		$file = "raspiviv.log";
		$size = filesize($path.$file);
		$curentTime = date('H:i:s');

		// create file and folder if they do not exist
		createFile($file);

		//reset file size if it grows to big
		if ($size < $megabytes * 1024 * 1000) {
			$mylogfile = fopen($path.$file, "a") or die("Unable to open file!"); 		// Open for writing only; place the file pointer at the end of the file. If the file does not exist, attempt to create it.
			fwrite($mylogfile, "<b> $curentTime  $value</b> \n");
			fclose($mylogfile);
		} else {
			$mylogfile = fopen($path.$file, "w") or die("Unable to open file!");
			fwrite($mylogfile, $curentTime . " reset file size \n");
			fclose($mylogfile);
		}
	}


	function createFile($file, $path ='/var/log/raspiviv/') {
		$curentTime = date('H:i:s');
		if (file_exists($path.$file)) {
			return;
		} else {
			mkdir($path, 0777, true);
			$mylogfile = fopen($path.$file, "w") or die("Unable to open file!");
			fwrite($mylogfile, $curentTime . " new file " . $file . " created\n");
			fclose($mylogfile);
			return;
		}
	}
?>