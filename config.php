<?php
// define( 'WP_DEBUG', true );
// define( 'WP_DEBUG_DISPLAY', true );
@ini_set( 'display_errors', 1 );
    $host = "localhost";
    $user = "root";                     
    $pass = "";                                  
    $db = "test123";
    $port = 3306;
    $con = mysqli_connect($host, $user, $pass, $db, $port)or die(mysql_error());
?>  