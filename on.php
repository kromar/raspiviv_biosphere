<?php
     system ( "gpio mode 0 out" );
     system ( "gpio write 0 0" );

     system ( "gpio mode 1 out" );
     system ( "gpio write 1 0" );
?>

<!-- led off -->

<?php
     system ( "gpio mode 4 out" );
     system ( "gpio write 4 0" );

?>
