<head>
        <link rel="stylesheet" href="CSSStyles\style.css">
</head>
<style>
    .messageBox {
        width: 80%;
        height: 150px;
        padding: 12px 20px;
        box-sizing: border-box;
        border: 2px solid #ccc;
        border-radius: 8px;
        background-color: #f8f8f8;
        font-size: 16px;
        resize: none;
    }
    .messageForm {
        width: 80%;
        height: 150px;
        padding: 12px 20px;
        text-align: center;
    }
</style>
<?php
include "navbar.html";
$animalID = $_GET['animal_id'];
require_once('mysqli_connect.php');
        $query = "SElECT user_id, name, color, animal FROM pets WHERE pet_id='$animalID'";

        $response = @mysqli_query($dbc, $query);

        if($response) {
            $row = mysqli_fetch_array($response);
            $userID = $row['user_id'];
            $name = $row['name'];
            $color = $row['color'];
            $animal = $row['animal'];

            $query = "SElECT address, city, state, zipcode FROM user WHERE user_id='$userID'";

            $response = @mysqli_query($dbc, $query);

            if($response) {
            $row = mysqli_fetch_array($response);
            $address = $row['address'];
            $city = $row['city'];
            $state = $row['state'];
            $zipcode = $row['zipcode'];
                session_start();
                $serializedUserID = serialize($userID);
                $_SESSION['userID'] = $serializedUserID;
                $serializedPetID = serialize($animalID);
                $_SESSION['petID'] = $serializedPetID;

                header('sent.php');
            $output = true;
            } else {
            echo "couldnt find owner";
            echo mysqli_error($dbc);
            $output = false;
            }

            $output = true;
        } else {
            echo "couldnt issue database query";
            echo mysqli_error($dbc);
            $output = false;
        }
        mysqli_close($dbc);
    if($output) {
        include 'googlemaplink.php';
        $linkAddress = addressLink($address, $city, $zipcode, $state);
        echo '<p>Hello, my name is ' . ucfirst(strtolower($name)) . ". I am a " . strtolower($color) . " " . strtolower($animal)
         . '. I live at <a href="' . $linkAddress . '">' . $address . ' ' . $city . ' ' . $state . ' ' . $zipcode .
         '</a>. Please bring me home. </p>';
        echo '
        <form action="sent.php" class="messageForm" method="post">
        <h5>Send message to owner? </h5>
        <textarea class="messageBox" name="message">Dear owner, </textarea>
        <br>
        <input type="submit" value="Send">
        </form>
        ';
    }
?>