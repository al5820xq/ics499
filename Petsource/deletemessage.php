<?php
//classes
include_once("Classes/Profile.php");
session_start();
                            
// Store data in session variables
$username = $_SESSION["username"];                            
$password = $_SESSION["password"];
$profile = unserialize($_SESSION["profile"]);

if ($profile->isUser() && isset($_GET["mssgeid"])) {
    $profile->deleteMessage($_GET["mssgeid"]);
    header("Location: messages.php");
} else {
    echo('<h1>Not logged in</h1>');
    header("Location: login.php");
}
?>