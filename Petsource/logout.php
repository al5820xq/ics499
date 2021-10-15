<?php
session_start();
                            
// Store data in session variables
$_SESSION["loggedin"] = false;
//$_SESSION["id"] = $id;
$_SESSION["username"] = NULL;                            
$_SESSION["password"] = NULL;
// Redirect user to welcome page
header("location: login.php");
?>