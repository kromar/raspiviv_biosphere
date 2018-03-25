<?php
	function logToFile($value0, $value1, $value2) {
		$megabytes = 2;
		//$file = "/../../log/raspiviv.log";
		$path ='/var/log/raspiviv/';
		$file = $path."raspiviv.log";

		if (file_exists($file)) {
			//TODO: this crashes when file is not present.... we first neeed to create the log files and folder before we can use them
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
			}

		} else {
				$mylogfile = fopen($path . $file, "w") or die("Unable to open file!");
				mkdir($path, 0777, true);
				fwrite($mylogfile, $curentTime . " reset file size \n");
				fclose($mylogfile);
			}
	}
?>