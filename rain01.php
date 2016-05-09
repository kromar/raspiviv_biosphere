<?php 

$db = mysql_connect("localhost","datalogger","datalogger") or die("DB Connect error"); 
mysql_select_db("datalogger"); 

$q = "SELECT temperature FROM datalogger where sensor = 8 ORDER BY date_time DESC LIMIT 1"; 
$ds = mysql_query($q); 
$tempSensor=(int)mysql_fetch_object($ds)->temperature; 


/* used to execute a python script
 * $command = escapeshellcmd(' /usr/custom/test.py');
 * $output = shell_exec($command);
 * echo $output
 */

// grab weather information from openweathermap.org
$city = "Chepo";
$country = "PA"; // two digit country code

$url = "http://api.openweathermap.org/data/2.5/weather?q=".$city.",".$country."&units=metric&cnt=7&lang=en";
$json = file_get_contents($url);
$data = json_decode($json,true);
//get rmep in celcius
echo $data['main']['temp']."<br>";


//change threshold depening on time of day
$tempThreshold;
$tempNight = 24.0;
$tempDay = 24.0;

$t = time();
$curentTime = date('H:i');
$morningTime = ('08:00');
$eveningTime = ('22:00');

if (($curentTime < $morningTime) or ($curentTime > $eveningTime))
{
	$tempThreshold = $tempNight;
}
else
{
	$tempThreshold = $tempDay;
}



//change power state of fan depending on current temperature
if ($tempSensor > $tempThreshold)
{
	$pwmNew=0;
}
if ($tempSensor <= $tempThreshold)
{
	$pwmNew=1;
}


$s="/usr/local/bin/gpio write 2 $pwmNew ";
exec($s);

mysql_query($q);
mysql_close($db);
?>


