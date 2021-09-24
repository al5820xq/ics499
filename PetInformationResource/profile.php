<?php
include "navbar.html";
include "user.php";

$currentUser = $_POST['username'];
$currentPassword = $_POST['password'];

$user = new User($currentUser, $currentPassword);
$user->isValid();
$user->toString();
?>