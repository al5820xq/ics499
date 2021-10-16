<?php
//header
include("Classes/Templates/loggedinheader.html");
//classes
include_once("Classes/Profile.php");
session_start();
                            
// Store data in session variables
$username = $_SESSION["username"];                            
$password = $_SESSION["password"];
$login = new Profile();
if ($login->login($username, $password)) {

} else {
    echo('<h1>Not logged in</h1>');
    header("Location: login.php");
}
//footer
include("Classes/Templates/footer.html");
?>