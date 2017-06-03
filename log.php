<?php
	function log_to_file($data) {
		$megabytes = 2;
		$file = "/logs/raspiviv.txt";
		$logfile = fopen(__DIR__.$file, "a+") or die("Unable to open file!");
		$size = filesize(__DIR__.$file) or die("Unable to get file size!");
		$curentTime = date('H:i:s');

		if ($size < $megabytes * 1024 * 1000) {
			try {
				//fwrite($mylogfile, $curentTime . " size: " . $size ." file: " . __DIR__ . $file ."\n");
				//fwrite($logfile, "<b> $curentTime  $value0  $value1  $value2 </b> \n");
				//fclose($logfile);
				  if(is_array($data) || is_object($data)) {
						fwrite($logfile, "<b> $curentTime  json_encode($data) </b> \n");
				  } else {
						fwrite($logfile, "<b> $curentTime  $data</b> \n");
				  }
					fclose($logfile);

			} catch (Exception $e) {
				echo 'Caught exception: ',  $e->getMessage(), "\n";
			}
		} else {
			$logfile = fopen(__DIR__ . $file, "w") or die("Unable to open file!");
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