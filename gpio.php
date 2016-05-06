<!-- This page is requested by the JavaScript, it updates the pin's status and then print it -->
<?php
//Getting and using values
if (isset ($_GET["pin"]) && isset($_GET["status"]) ) {
	$pin = strip_tags($_GET["pin"]);
	$status = strip_tags($_GET["status"]);
	//Testing if values are numbers
	if ( (is_numeric($pin)) && (is_numeric($status)) && ($pin <= 7) && ($pin >= 0) && ($status == "0") || ($status == "1") ) {
		//set the gpio's mode to output		
		system("gpio mode ".$pin." out");
		//set the gpio to high/low
		if ($status == "0" ) { $status = "1"; }
		else if ($status == "1" ) { $status = "0"; }
		system("gpio write ".$pin." ".$status );
		//reading pin's status
		exec ("gpio read ".$pin, $status, $return );
		//printing it
		echo ( $status[0] );
	}
	else { echo ("fail"); }
} //print fail if cannot use values
else { echo ("fail"); }
?>