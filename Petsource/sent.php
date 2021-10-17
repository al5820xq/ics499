<?php
require_once "Classes/Guest.php";
include("Classes/Templates/header.html");
// Processing form data when form is submitted
session_start();
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $guest = unserialize($_SESSION["guest"]);
    // Validate credentials
    if(!is_null($guest) && isset($_POST['message'])){
    
        if($guest->sendMessage($_POST['message'])){
            echo '<p>Message sent!</p>';
        } else{
            echo "<p>Oops! Something went wrong. Please try again later.</p>";
        }
    }
}
$_SESSION["guest"] = NULL;
include("Classes/Templates/footer.html");
?>