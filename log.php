<?php
	function log_to_file($value0, $value1, $value2) {
		$megabytes = 2;
		$file = "../../log/raspiviv.log";
		$size = filesize(__DIR__.$file);
		$curentTime = date('H:i:s');
		if ($size < $megabytes * 1024 * 1000) {
			$mylogfile = fopen(__DIR__.$file, "a") or die("Unable to open file!");
			try {
				//fwrite($mylogfile, $curentTime . " size: " . $size ." file: " . __DIR__ . $file ."\n");
				fwrite($mylogfile, "<b> $curentTime  $value0  $value1  $value2 </b> \n");
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

function log_to_console($data) {
    if(is_array($data) || is_object($data))
	{
		echo("<script>console.log('PHP: ".json_encode($data)."');</script>");
	} else {
		echo("<script>console.log('PHP: ".$data."');</script>");
	}
}
?>