<?php
include "navbar.html";
include "user.php";
require_once('mysqli_connect.php');


session_start();
if(isset($_SESSION['user']) && $_SESSION['user']) {
    $user = unserialize($_SESSION['user']);
    header('petregistered.php');

    $petname = $_POST["petname"];
    $animal = $_POST["animal"];
    $color = $_POST["color"];
    $chipID = $_POST["chipid"];
    $userID = $user->getID();

$insertQuery = "INSERT INTO pets (pet_id, user_id, name, chip_id, media, color, 
animal) VALUES (NULL, ?, ?, ?, NULL, ?, ?)";
$stmt = mysqli_prepare($dbc, $insertQuery);
mysqli_stmt_bind_param($stmt, "isiss", $userID, $petname, $chipID, $color, $animal);
mysqli_stmt_execute($stmt);
$affected_rows = mysqli_stmt_affected_rows($stmt);
if($affected_rows == 1){
    echo 'Pet Entered';
    mysqli_stmt_close($stmt);
        //mysqli_close($dbc);
} else {
    echo 'Error Occurred';
    echo mysqli_error($dbc);
    mysqli_stmt_close($stmt);
        //mysqli_close($dbc);
}

}
?>