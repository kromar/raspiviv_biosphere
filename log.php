<?php
	function log_to_file($value0, $value1, $value2) {
		$megabytes = 2;
		$file = "/../../log/raspiviv.log";
		$mode = 0777;
		chmod(__DIR__.$file, $mode);
		$logfile = fopen(__DIR__.$file, "w+") or die("Unable to open file!");
		$size = filesize($logfile);
		$curentTime = date('H:i:s');

		if ($size < $megabytes * 1024 * 1000) {
			try {
				//fwrite($mylogfile, $curentTime . " size: " . $size ." file: " . __DIR__ . $file ."\n");
				fwrite($logfile, "<b> $curentTime  $value0  $value1  $value2 </b> \n");
				fclose($logfile);

			} catch (Exception $e) {
				echo 'Caught exception: ',  $e->getMessage(), "\n";
			}
		} else {
			fwrite($logfile, $curentTime . " reset file size \n");
			fclose($logfile);
		}
	}

function log_to_console($data) {
    if(is_array($data) || is_object($data))
	{
		echo("<script>console.log('PHP: ".json_encode($data)."');</script>");
	} else {
		echo("<script>console.log('PHP: ".$data."');</script>");
	}
}
?>