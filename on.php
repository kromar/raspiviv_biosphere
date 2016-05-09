<!-- is this the rain system? -->
<?php
     system ( "gpio mode 3 out" );
     system ( "gpio write 3 0" );

     system ( "gpio mode 3 out" );
     system ( "gpio write 3 0" );
?>

<!-- led off -->
<?php
     system ( "gpio mode 4 out" );
     system ( "gpio write 4 0" );

?>
