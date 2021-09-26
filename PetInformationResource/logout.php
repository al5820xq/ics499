<?php
include "navbar.html";
include "user.php";

session_start();
$_SESSION['user'] = NULL;

?>
<h3>You have been logged out</h3>