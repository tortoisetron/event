<?php
// define( 'WP_DEBUG', true );
// define( 'WP_DEBUG_DISPLAY', true );
@ini_set( 'display_errors', 1 );
    $host = "127.0.0.1";
    $user = "root";                     
    $pass = "";                                  
    $db = "event";
    $port = 3306;
    $con = mysqli_connect($host, $user, $pass, $db, $port)or die(mysql_error());
?>  
