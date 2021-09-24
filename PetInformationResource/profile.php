<?php
include "navbar.html";
include "user.php";

$currentUser = $_POST['username'];
$currentPassword = $_POST['password'];

$user = new User($currentUser, $currentPassword);
$user->isValid();
?>
<script>document.write("Today is " + Date());</script>
<?php
$user->toString();

$serializedUser = serialize($user);
session_start();
$_SESSION['user'] = $serializedUser;
header('petregister.php');
?>

<h3><a href="petregister.php"><b>Register Pet</b></a></h3>

