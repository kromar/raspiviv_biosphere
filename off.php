<?php
     system ( "gpio mode 0 out" );
     system ( "gpio write 0 1" );

     system ( "gpio mode 1 out" );
     system ( "gpio write 1 1" );
?>

<!-- led on -->

<?php
     system ( "gpio mode 4 out" );
     system ( "gpio write 4 1" );

?>
