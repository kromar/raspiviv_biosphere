<?php 
$humthreshold = 90.0; 


$db = mysql_connect("localhost","datalogger","datalogger") or die("DB Connect error"); 
mysql_select_db("datalogger"); 

$q = "SELECT humidity FROM datalogger where sensor = 8 ORDER BY date_time DESC LIMIT 1"; 
$ds = mysql_query($q); 
$hum=(int)mysql_fetch_object($ds)->humidity; 


if ($hum>$humthreshold) 
{ 
	$pwmNew=1; 
} 
if ($hum<=$humthreshold) 
{ 
	$pwmNew=0; 
} 


$s="/usr/local/bin/gpio write 5 $pwmNew "; 
exec($s); 

mysql_query($q); 
mysql_close($db); 
?> 
