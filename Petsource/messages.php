<?php
//header
include("Classes/Templates/loggedinheader.html");
//classes
include_once("Classes/Profile.php");
session_start();

// Store data in session variables
$username = $_SESSION["username"];                            
$password = $_SESSION["password"];
$profile = unserialize($_SESSION["profile"]);
if (DBController::isUser($username, $password)) {
    echo('<h1>Pet Messages</h1>');
    $profile->getMessages();
} else {
    echo('<h1>Not logged in</h1>');
    header("Location: login.php");
}
//footer
include("Classes/Templates/footer.html");
?>