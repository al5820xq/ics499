<?php
include "navbar.html";
include "user.php";
require_once('mysqli_connect.php');


session_start();
if(isset($_SESSION['userID']) && $_SESSION['userID'] && isset($_SESSION['petID']) && $_SESSION['petID']) {
    $userID = unserialize($_SESSION['userID']);
    $petID = unserialize($_SESSION['petID']);
    $message = $_POST["message"];

$insertQuery = "INSERT INTO messages (message_id, pet_id, user_id, message) VALUES (NULL, ?, ?, ?)";
$stmt = mysqli_prepare($dbc, $insertQuery);
mysqli_stmt_bind_param($stmt, "iis", $petID, $userID, $message);
mysqli_stmt_execute($stmt);
$affected_rows = mysqli_stmt_affected_rows($stmt);
if($affected_rows == 1){
    echo 'Message Sent';
    mysqli_stmt_close($stmt);
        //mysqli_close($dbc);
} else {
    echo 'Error Occurred';
    echo mysqli_error($dbc);
    mysqli_stmt_close($stmt);
        //mysqli_close($dbc);
}
mysqli_close($dbc);
}
?>