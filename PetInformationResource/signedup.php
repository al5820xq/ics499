<?php
include "navbar.html";
require_once('mysqli_connect.php');

require_once('mysqli_connect.php');
$username = $_POST["username"];
$fname = $_POST["fname"];
$lname = $_POST["lname"];
$email = $_POST["email"];
$address = $_POST["address"];
$city = $_POST["city"];
$zipcode = $_POST["zipcode"];
$state = $_POST["state"];
$phone = $_POST["phone"];
$password = $_POST["password"];
$repassword = $_POST["repassword"];
$insertQuery = "INSERT INTO user (user_id, firstname, lastname, username, password, email, 
phone, address, zipcode, city, state) VALUES (NULL, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = mysqli_prepare($dbc, $insertQuery);
mysqli_stmt_bind_param($stmt, "sssssssiss", $fname, $lname, $username, $password, $email,
$phone, $address, $zipcode, $city, $state);
mysqli_stmt_execute($stmt);
$affected_rows = mysqli_stmt_affected_rows($stmt);
if($affected_rows == 1){
    echo 'User Entered';
    mysqli_stmt_close($stmt);
        //mysqli_close($dbc);
} else {
    echo 'Error Occurred';
    echo mysqli_error($dbc);
    mysqli_stmt_close($stmt);
        //mysqli_close($dbc);
}
?>