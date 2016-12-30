<?PHP
	require_once("./assets/php/membersite_config.php");

	if(!$fgmembersite->CheckLogin())
	{
	    $fgmembersite->RedirectToURL("login.php");
	    exit;
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US" lang="en-US">
<head>

	    <meta charset="utf-8">
	    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	    <meta name="viewport" content="width=device-width, initial-scale=1">

		<title>RasPiViv.com - Buttons</title>

    <!--Load the AJAX API-->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	<script type="text/javascript"></script>

<!--  load CSS -->
	<script type="text/javascript" src="https://www.google.com/jsapi"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link href="/css/normalize.css" rel="stylesheet">
	<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css">
   	<link rel="stylesheet" href="http://getbootstrap.com/examples/cover/cover.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css">
</head>

	<body>
		<div class="jumbotron">
			<div class="container">
				<?php include('menu.html');?>
			</div>
		</div>
		<div class="container">
		     <!-- On/Off button's picture -->
			 <?php
		 	 	 include_once "log.php";
				 //this php script generate the first page in function of the gpio's status
				 $status = array(0, 0, 0, 0, 0, 0, 0);
				 $pinmode = array(0,1,2,3);

				 $init = true;

				 //here we switch the pins for the first time after a reboot.
			 	 //since the pull state switches on mode change we need to do some special switching to avoid wrong states
				 for ($pin = 0; $pin < count($status); $pin++) {
				 	if ($init == true) {
				 		//switch after reboot
				 		logToFile("init", $init, '');
						if (in_array($pin, $pinmode)) {
							system("gpio mode $pin out");
							system("gpio write $pin 1");
						} else {
							system("gpio mode $pin out");
							system("gpio write $pin 0");
						}
				 		$init = false;
				 	} else {
				 		//do normal switching
				 		logToFile("init", $init, '');
						system("gpio mode $pin out");
						system("gpio write $pin $status[$pin]");
				 	}

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
		 <script src="assets/js/buttons_script.js"></script>
		 <div class="container">
			 <hr>
			 <?php include 'footer.php';?>
		</div>
	</body>
</html>
