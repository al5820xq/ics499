<?php
include "navbar.html";
include "user.php";

session_start();
if(isset($_SESSION['user']) && $_SESSION['user']) {
    $user = unserialize($_SESSION['user']);
    //header('petregistered.php');
    echo '
    <form action="petregistered.php" method="post">
    <h5>Pet Name: </h5><input type="text" name="petname">
    <h5>Animal: </h5><input type="text" name="animal">
    <h5>Color: </h5><input type="text" name="color">
    <h5>Chip ID: </h5><input type="number" maxlength="15" name="chipid">
    <input type="submit">
    </form>
    ';
}
?>