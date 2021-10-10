<?php

DEFINE ('DB_USER', 'pineapple');
DEFINE ('DB_PASSWORD', 'password');
DEFINE ('DB_HOST', 'localhost');
DEFINE ('DB_NAME', 'test1');

include_once("Address.php");
include_once("PetOwner.php");


class DBController {
    
    /*
    Returns a boolean value representing whether a user in the database has the provided username or 
    password.
        $username - a String that is the username of inquiry
        $password - a String that is the password of inquiry
        returns - boolean
    */
    static function isUser($username, $password) {
        $dbc = @mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) 
        or die('Could not connect to MySQL '. mysqli_connect_error());

        if ($username == "" || $password == "" || $username == "" || $password == "") {
            mysqli_close($dbc);
            return false;
        }

        $query = "SElECT user_id FROM user WHERE username='$username' AND password='$password'";

        $response = @mysqli_query($dbc, $query);

        if($response) {
            $row = mysqli_fetch_array($response);
            $userID = @$row['user_id'];
            
            if (!is_null($userID)) {
                $output = true;
            } else {
                $output = false;
            }
        } else {
            echo "couldnt issue database query";
            echo mysqli_error($dbc);
            $output = false;
        }

        mysqli_close($dbc);
        return $output;
    }

    /*
    Returns a PetOwner object representing a user in the database that has the provided username or 
    password.
        $username - a String that is the username
        $password - a String that is the password
        returns - PetOwner
    */
    static function getPetOwner($username, $password) {
        $dbc = @mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) 
        or die('Could not connect to MySQL '. mysqli_connect_error());
        $query = "SElECT user_id, firstname, lastname, username, password, email, 
        phone, address, zipcode, city, state FROM user WHERE username='$username' AND password='$password'";

        $response = @mysqli_query($dbc, $query);

        if($response) {
            $row = mysqli_fetch_array($response);
            $userID = @$row['user_id'];
            $firstName = @$row['firstname'];
            $lastName = @$row['lastname'];
            $email = @$row['email'];
            $phone = @$row['phone'];
            $address = @$row['address'];
            $zipcode = @$row['zipcode'];
            $city = @$row['city'];
            $state = @$row['state'];
        } else {
            echo "couldnt issue database query";
            echo mysqli_error($dbc);
        }
        $addressObject = new Address($address, $city, $zipcode, $state);
        $output = new PetOwner($userID, $username, $password, $firstName, $lastName, $email, $phone, $addressObject);
        mysqli_close($dbc);
        return $output;
    }

    static function getPet($petID) {

    }

    static function getPets($userID) {
        
    }

    static function getMailbox($userID) {
        
    }

    static function getAddress($userID) {
        
    }

    static function insertPetOwner($user) {
        
    }

    static function insertPet($animal) {
        
    }

    static function insertMessage($message) {
        
    }

    static function updatePetOwner($user) {
        
    }

    static function updatePet($pet, $username, $password) {
        
    }

    static function deletePet($petID, $username, $password) {
        
    }

    static function deletePetOwner($userID) {
        
    }

    static function deleteMessage($messageID) {
        
    }



    static function upimage($tmpname) {
        $dbc = @mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) 
        or die('Could not connect to MySQL '. mysqli_connect_error());
        $tmpname = addslashes($tmpname);
        $insertQuery = "UPDATE pets SET media = '$tmpname' WHERE pet_id=5";

        $response = @mysqli_query($dbc, $insertQuery);
        echo mysqli_error($dbc);
        mysqli_close($dbc);
    }

    static function pet5pic() {
        $dbc = @mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) 
        or die('Could not connect to MySQL '. mysqli_connect_error());

        $query = "SELECT media FROM pets WHERE pet_id=5";
        $response = @mysqli_query($dbc, $query);
        $row = mysqli_fetch_array($response);
        $picture = @$row['media'];
        $finalPicture = '<img src="data:image/jpeg;base64,' . base64_encode($picture) . '" >';
        echo($finalPicture);
        mysqli_close($dbc);
    }
}

?>