<?PHP
require_once("./include/membersite_config.php");

if(!$fgmembersite->CheckLogin())
{
    $fgmembersite->RedirectToURL("login.php");
    exit;
}
?>
<html>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US" lang="en-US">
<head>
<title>RasPiViv.com Settings</title>
<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap-theme.min.css">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
</head>
<body>
<div class="jumbotron">
<div class="container">
<?php include 'menu.php';?>
</div>
</div>
<div class="container">
<h3>RasPiViv V 2.1</h3>

<p>This is a free application designed by <a href="www.raspiviv.com">www.raspiviv.com</a> licenced for general public use and is <strong>not licensed for resale</strong>.</p>
<p>If you were charged for this software please <a href="http://www.raspiviv.com/contact">contact us</a> and let us know!</p>


<div class="container">
<a href="change-pwd.php" tooltip title="CHANGE PASSWORD" alt="CHANGE PASSWORD">
<span class="fa-stack fa-3x">
  <i class="fa fa-circle fa-stack-2x"></i>
  <i class="fa fa-key fa-stack-1x fa-inverse"></i>
</span>
</a>
<a href="logout.php" tooltip title="LOGOUT" alt="LOGOUT">
<span class="fa-stack fa-3x">
  <i class="fa fa-circle fa-stack-2x"></i>
  <i class="fa fa-sign-out fa-stack-1x fa-inverse"></i>
</span>
</a>
</div>
<div class="container"><hr>
<?php include 'footer.php';?>
</div>
</body>
</html>
