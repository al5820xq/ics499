<?php
include "navbar.html";
include "user.php";
include "CSSStyles/style.php";

session_start();
if(isset($_SESSION['user']) && $_SESSION['user']) {
    $user = unserialize($_SESSION['user']);
    //header('petregistered.php');
    echo '
    <form action="petregistered.php" method="post" class="messageForm">
    <h5 class="inputLabel">Pet Name: </h5><input type="text" name="petname" class="inputBox">
    <h5 class="inputLabel">Animal: </h5><input type="text" name="animal" class="inputBox">
    <h5 class="inputLabel">Color: </h5><input type="text" name="color" class="inputBox">
    <h5 class="inputLabel">Chip ID: </h5><input type="number" maxlength="15" name="chipid" class="inputBox">
    <br><input type="submit" class="submitButton">
    </form>
    ';
}
?>