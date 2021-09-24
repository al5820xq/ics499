<?php
include "user.php";

$currentUser = $_POST['username'];
$currentPassword = $_POST['password'];

$user = new User($currentUser, $currentPassword);
$user->isValid();
?>