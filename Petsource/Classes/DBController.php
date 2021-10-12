<?php

DEFINE ('DB_USER', 'pineapple');
DEFINE ('DB_PASSWORD', 'password');
DEFINE ('DB_HOST', 'localhost');
DEFINE ('DB_NAME', 'test1');

include_once("Address.php");
include_once("PetOwner.php");
include_once("Pet.php");
include_once("Message.php");
include_once("Mailbox.php");


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
        $dbc = @mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) 
        or die('Could not connect to MySQL '. mysqli_connect_error());
        $query = "SElECT * FROM pets WHERE pet_id=$petID";

        $response = @mysqli_query($dbc, $query);

        if($response) {
            $row = mysqli_fetch_array($response);
            $userID = @$row['user_id'];
            $name = @$row['name'];
            $chipID = @$row['chip_id'];
            $media = @$row['media'];
            $color = @$row['color'];
            $animal = @$row['animal'];
        } else {
            echo "couldnt issue database query";
            echo mysqli_error($dbc);
        }
        $output = new Pet($userID, $petID, $name, $chipID, $media, $color, $animal);
        mysqli_close($dbc);
        return $output;

    }

    static function getPets($userID) {
        $output = array();
        $dbc = @mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) 
        or die('Could not connect to MySQL '. mysqli_connect_error());
        $query = "SElECT * FROM pets WHERE user_id=$userID";

        $response = @mysqli_query($dbc, $query);

        if($response) {
            while ($row = mysqli_fetch_array($response)) {
                $petID = @$row['pet_id'];
                $name = @$row['name'];
                $chipID = @$row['chip_id'];
                $media = @$row['media'];
                $color = @$row['color'];
                $animal = @$row['animal'];
                $pet = new Pet($userID, $petID, $name, $chipID, $media, $color, $animal);
                $output[] = $pet;
            }  
        } else {
            echo "couldnt issue database query";
            echo mysqli_error($dbc);
        }
        mysqli_close($dbc);
        return $output;
    }

    static function getMailbox($userID) {
        $output = new Mailbox($userID);
        $dbc = @mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) 
        or die('Could not connect to MySQL '. mysqli_connect_error());
        $query = "SElECT * FROM messages WHERE user_id=$userID";

        $response = @mysqli_query($dbc, $query);

        if($response) {
            while ($row = mysqli_fetch_array($response)) {
                $messageID = @$row['message_id'];
                $message = @$row['message'];
                $petID = @$row['pet_id'];
                $messageObject = new Message($messageID, $userID, $petID, $message);
                $output->addMessage($messageObject);
            }  
        } else {
            echo "couldnt issue database query";
            echo mysqli_error($dbc);
        }
        mysqli_close($dbc);
        return $output;
    }

    static function getAddress($userID) {
        $dbc = @mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) 
        or die('Could not connect to MySQL '. mysqli_connect_error());
        $query = "SElECT address, zipcode, city, state FROM user WHERE user_id=$userID";

        $response = @mysqli_query($dbc, $query);

        if($response) {
            $row = mysqli_fetch_array($response);
            $address = @$row['address'];
            $zipcode = @$row['zipcode'];
            $city = @$row['city'];
            $state = @$row['state'];
        } else {
            echo "couldnt issue database query";
            echo mysqli_error($dbc);
        }
        $output = new Address($address, $city, $zipcode, $state);
        mysqli_close($dbc);
        return $output;
    }

    static function insertPetOwner($user) {
        $dbc = @mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) 
        or die('Could not connect to MySQL '. mysqli_connect_error());
        $username = $user->getUsername();
        $fname = $user->getFirstName();
        $lname = $user->getLastName();
        $email = $user->getEmail();
        $address = $user->getAddress()->getStreetAddress();
        $city = $user->getAddress()->getCity();
        $zipcode = $user->getAddress()->getZipcode();
        $state = $user->getAddress()->getState();
        $phone = $user->getPhone();
        $password = $user->getPassword();
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
            $output = true;
        } else {
            echo 'Error Occurred';
            echo mysqli_error($dbc);
            mysqli_stmt_close($stmt);
            $output = false;
        }
        mysqli_close($dbc);
        return $output;
    }

    static function insertPet($animal) {
        $dbc = @mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) 
        or die('Could not connect to MySQL '. mysqli_connect_error());
        $species = $animal->getAnimal();
        $name = $animal->getName();
        $color = $animal->getColor();
        $userID = $animal->getUserID();
        $chipID = $animal->getChipID();
        $media = $animal->getMedia();
        $insertQuery = "INSERT INTO pets (pet_id, user_id, name, animal, color, chip_id, media) 
        VALUES (NULL, ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($dbc, $insertQuery);
        mysqli_stmt_bind_param($stmt, "issssb", $userID, $name, $species, $color, $chipID, $media);
        mysqli_stmt_execute($stmt);
        $affected_rows = mysqli_stmt_affected_rows($stmt);
        if($affected_rows == 1){
            echo 'Pet Entered';
            mysqli_stmt_close($stmt);
            $output = true;
        } else {
            echo 'Error Occurred';
            echo mysqli_error($dbc);
            mysqli_stmt_close($stmt);
            $output = false;
        }
        mysqli_close($dbc);
        return $output;
    }

    static function insertMessage($message) {
        $dbc = @mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) 
        or die('Could not connect to MySQL '. mysqli_connect_error());
        $petID = $message->getPetID();
        $userID = $message->getUserID();
        $messageString = $message->getMessage();
        $insertQuery = "INSERT INTO messages (message_id, pet_id, user_id, message) 
        VALUES (NULL, ?, ?, ?)";
        $stmt = mysqli_prepare($dbc, $insertQuery);
        mysqli_stmt_bind_param($stmt, "iis", $petID, $userID, $messageString);
        mysqli_stmt_execute($stmt);
        $affected_rows = mysqli_stmt_affected_rows($stmt);
        if($affected_rows == 1){
            echo 'Message Entered';
            mysqli_stmt_close($stmt);
            $output = true;
        } else {
            echo 'Error Occurred';
            echo mysqli_error($dbc);
            mysqli_stmt_close($stmt);
            $output = false;
        }
        mysqli_close($dbc);
        return $output;
    }

    static function updatePetOwner($user) {
        $dbc = @mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) 
        or die('Could not connect to MySQL '. mysqli_connect_error());
        $userID = $user->getUserID();
        $username = $user->getUsername();
        $fname = $user->getFirstName();
        $lname = $user->getLastName();
        $email = $user->getEmail();
        $address = $user->getAddress()->getStreetAddress();
        $city = $user->getAddress()->getCity();
        $zipcode = $user->getAddress()->getZipcode();
        $state = $user->getAddress()->getState();
        $phone = $user->getPhone();
        $password = $user->getPassword();
        $insertQuery = "UPDATE user SET firstname='$fname', lastname='$lname', username='$username', password='$password', email='$email', 
        phone='$phone', address='$address', zipcode=$zipcode, city='$city', state='$state' WHERE user_id=$userID";
        if (mysqli_query($dbc, $insertQuery)) {
            echo "Record updated successfully";
            $output = true;
        } else {
            echo "Error updating record: " . mysqli_error($dbc);
            $output = false;
        }
        mysqli_close($dbc);
        return $output;
    }

    static function updatePet($pet, $username, $password) {
        $dbc = @mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) 
        or die('Could not connect to MySQL '. mysqli_connect_error());
        $species = $pet->getAnimal();
        $name = $pet->getName();
        $color = $pet->getColor();
        $userID = $pet->getUserID();
        $chipID = $pet->getChipID();
        $media = $pet->getMedia();
        $petID = $pet->getPetID();

        $validation1 = DBController::isUser($username, $password);
        $validation2 = false;
        $query1 = "SElECT user_id FROM user WHERE username='$username' AND password='$password'";

        $response = @mysqli_query($dbc, $query1);

        if($response) {
            $row = mysqli_fetch_array($response);
            $userIDClaim = @$row['user_id'];
            $query2 = "SElECT user_id FROM pets WHERE pet_id=$petID";
            $response = @mysqli_query($dbc, $query2);
            if($response) {
                $row = mysqli_fetch_array($response);
                $userIDActual = @$row['user_id'];
                $validation2 = $userIDClaim == $userIDActual;
            } else {
                echo "couldnt issue database query";
                echo mysqli_error($dbc);
            }
        } else {
            echo "couldnt issue database query";
            echo mysqli_error($dbc);
        }
       
        if($validation1 && $validation2) {
            if (is_null($media)){
                $media = "NULL";
            }
            $insertQuery = "UPDATE pets SET user_id=$userID, name='$name', animal='$species',
                color='$color', chip_id='$chipID', media=$media WHERE pet_id=$petID";
            if (mysqli_query($dbc, $insertQuery)) {
                echo "Record updated successfully";
                $output = true;
            } else {
                echo "Error updating record: " . mysqli_error($dbc);
                $output = false;
            }
        } else {
            echo "Error updating record: Invalid pet owner";
            $output = false;
        }
        
        mysqli_close($dbc);
        return $output;

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
        /* $dbc = @mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) 
        or die('Could not connect to MySQL '. mysqli_connect_error());

        $query = "SELECT media FROM pets WHERE pet_id=5";
        $response = @mysqli_query($dbc, $query);
        $row = mysqli_fetch_array($response);
        $picture = @$row['media']; */
        $pet = DBController::getPet(5);
        $picture = $pet->getMedia();
        $finalPicture = '<img src="data:image/jpeg;base64,' . base64_encode($picture) . '" >';
        echo($finalPicture);
        //mysqli_close($dbc);
    }
}

?>