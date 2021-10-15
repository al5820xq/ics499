<?php
//header
include("Classes/Templates/header.html");
//classes
include_once("Classes/Profile.php");

$username = 'jfk';
$password = 'password';
$login = new Profile();
if ($login->login($username, $password)) {

} else {
    echo('<h1>Not logged in</h1>');
    header("Location: login.php");
}
//footer
include("Classes/Templates/footer.html");
?>