<?PHP
	require_once("./include/membersite_config.php");

	if(!$fgmembersite->CheckLogin())
	{
	    $fgmembersite->RedirectToURL("login.php");
	    exit;
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US" lang="en-US">
<html>
	<head>
		<title>RasPiViv.com - Buttons</title>

		<script src="scripts/jquery-1.12.3.min.js"></script>
		<script type="text/javascript" src="https://www.google.com/jsapi"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

		<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css"></link>
	   	<link rel="stylesheet" href="http://bootswatch.com/cerulean/bootstrap.min.css"></link>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css"></link>
	</head>

	<body>
		<div class="jumbotron">
			<div class="container">
				<?php include 'menu.php';?>
			</div>
		</div>
		<div class="container">
		     <!-- On/Off button's picture -->
			 <?php
		 	 	 include_once "log.php";
				 //this php script generate the first page in function of the gpio's status
				 $status = array(0, 0, 1, 1, 0, 0, 0);

				 for ($pin = 0; $pin < count($status); $pin++) {
					//set the pin's mode to output and read them

				 	system("gpio mode $pin $status[$pin]");

					exec ("gpio read ".$pin, $status[$pin], $return );

					// if off
					if ($status[$pin][0] == 0 ) {
				 		logToFile("if off", $pin, $status[$pin][0]);
						//echo ("<img id='button_".$pin."' src='data/img/off/off_".$pin.".png' alt='off'/><br>");
						if ($pin == 0 or $pin == 1) {
							echo ("<img id='button_".$pin."' src='data/img/light_off.png' alt='off'/><br>");
						}
						if ($pin == 2 or $pin == 3) {
							echo ("<img id='button_".$pin."' src='data/img/rain_on.png' alt='on'/><br>");
						}
						if ($pin == 4) {
							echo ("<img id='button_".$pin."' src='data/img/moon_off.png' alt='off'/><br>");
						}
						if ($pin == 5 or $pin == 6) {
							echo ("<img id='button_".$pin."' src='data/img/air_off.png' alt='off'/><br>");
						}
					}
					//if on
					if ($status[$pin][0] == 1 ) {
				 		logToFile("if on", $pin, $status[$pin][0]);
						//echo ("<img id='button_".$pin."' src='data/img/on/on_".$pin.".png' alt='on'/><br>");
						if ($pin == 0 or $pin == 1) {
							echo ("<img id='button_".$pin."' src='data/img/light_on.png' alt='on'/><br>");
						}
						if ($pin == 2 or $pin == 3) {
							echo ("<img id='button_".$pin."' src='data/img/rain_off.png' alt='off'/><br>");
						}
						if ($pin == 4) {
							echo ("<img id='button_".$pin."' src='data/img/moon_on.png' alt='on'/><br>");
						}
						if ($pin == 5 or $pin == 6) {
							echo ("<img id='button_".$pin."' src='data/img/air_on.png' alt='on'/><br>");
						}
					}
				 }
			 ?>
		 </div>
		 <!-- javascript -->
		 <!-- <script src="buttons_script.js"></script> -->
		 <div class="container">
			 <hr>
			 <?php include 'footer.php';?>
		</div>
	</body>
</html>
