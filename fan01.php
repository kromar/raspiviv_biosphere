<?php 

$db = mysql_connect("localhost","datalogger","datalogger") or die("DB Connect error"); 
mysql_select_db("datalogger"); 

$q = "SELECT humidity FROM datalogger where sensor = 8 ORDER BY date_time DESC LIMIT 1"; 
$ds = mysql_query($q); 
$humiditySensor=(int)mysql_fetch_object($ds)->humidity; 


/* used to execute a python script
 * $command = escapeshellcmd(' /usr/custom/test.py');
* $output = shell_exec($command);
* echo $output
*/

// grap weather information from openweathermap.org
$city = "Chepo";
$country = "PA"; // two digit country code

$url = "http://api.openweathermap.org/data/2.5/weather?q=".$city.",".$country."&units=metric&cnt=7&lang=en";
$json = file_get_contents($url);
$data = json_decode($json,true);
//get rmep in celcius
echo $data['main']['temp']."<br>";
//get humidity
echo $data['main']['humidity']."<br>";


//change threshold depening on time of day
$humidityThreshold;
$humidityNight = 95.0;
$humidityDay = 90.0;

$t = time();
$curentTime = date('H:i');
$morningTime = ('08:00');
$eveningTime = ('22:00');

if (($curentTime < $morningTime) or ($curentTime > $eveningTime))
{
	$humidityThreshold = $humidityNight;
}	
else
{
	$humidityThreshold = $humidityDay;
} 


//change power state of fan depending on current humidity
if ($humiditySensor > $humidityThreshold) 
{ 
	$pwmNew=1; 
} 
if ($humiditySensor <= $humidityThreshold) 
{ 
	$pwmNew=0; 
} 


$s="/usr/local/bin/gpio write 5 $pwmNew "; 
exec($s); 

mysql_query($q); 
mysql_close($db); 
?> 
