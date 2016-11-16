<?PHP
// require_once("./include/membersite_config.php");

// if(!$fgmembersite->CheckLogin())
// {
// $fgmembersite->RedirectToURL("login.php");
// exit;
// }
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US" lang="en-US">
<head>
<meta charset="utf-8"></meta>
<meta http-equiv="X-UA-Compatible" content="IE=edge"></meta>
<meta name="viewport" content="width=device-width, initial-scale=1"></meta>

<title>graph 2</title>

	<!--Load the AJAX API-->
	<script type="text/javascript"    src="https://www.gstatic.com/charts/loader.js"></script>
	<script src="scripts/jquery-3.1.1.min.js"></script>
	<script type="text/javascript"></script>
	<script type="text/javascript" src="https://www.google.com/jsapi"></script>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="css/sb-admin.css" rel="stylesheet">
    <!-- Morris Charts CSS -->
    <link href="css/plugins/morris.css" rel="stylesheet">
    <!-- Custom Fonts -->
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">




<div class="jumbotron">
    <div class="container">
				<?php include('menu.html');?>
			<h2>Sensor 1</h2>
			<?php include 'time.php';?>
		</div>
</div>


</body>

</html>
