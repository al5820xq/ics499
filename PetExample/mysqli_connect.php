<?php

DEFINE ('DB_USER', 'pineapple');
DEFINE ('DB_PASSWORD', 'password');
DEFINE ('DB_HOST', 'localhost');
DEFINE ('DB_NAME', 'test1');
//echo phpinfo();
$dbc = @mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) 
 or die('Could not connect to MySQL '. mysqli_connect_error());

?>