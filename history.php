<?php 
	function delOld(){
		$db = mysql_connect("localhost","datalogger","datalogger") or die("DB Connect error");
		mysql_select_db("datalogger");
		$q="delete from datalogger"; 
		mysql_query($q);
		mysql_close($db); 
		return 0;
	}

	function hist($sensor){ 
		$db = mysql_connect("localhost","datalogger","datalogger") or die("DB Connect error"); 
		mysql_select_db("datalogger"); 
		for ($i=0;$i<=23;$i++) 
		{ 
			$q=   "insert into history ( "; 
			$q=$q."select date_add(curdate(),interval $i hour),'$sensor', round(avg(temperature),2),round(avg(humidity),2) "; 
			$q=$q."from datalogger "; 
			$q=$q."where sensor = '$sensor' "; 
			$q=$q."and date_time >=date_add(curdate(),interval $i hour) ";$ii=$i+1; 
			$q=$q."and date_time < date_add(curdate(),interval $ii hour) "; 
			$q=$q.") "; 
			mysql_query($q); 
		} 
		mysql_close($db); 
		return 0; 
	} 
	hist(8); 
	hist(9);
	delOld();
?>

