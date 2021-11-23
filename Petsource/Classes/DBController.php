<?php
/**
 * A class developed to provide a simplified approach to accessing and manipulating 
 * the Petsource database.
 * 
 * @author Vincent Peterson
 */

DEFINE ('DB_USER', 'pineapple');
DEFINE ('DB_PASSWORD', 'password');
DEFINE ('DB_HOST', 'aa4qvl0qtmmc2w.c208q0xtdwxa.us-east-2.rds.amazonaws.com');
DEFINE ('DB_NAME', 'ebdb');
DEFINE ('DB_PORT', '3306');

include_once("Address.php");
include_once("PetOwner.php");
include_once("Pet.php");
include_once("Message.php");
include_once("Mailbox.php");

/**
 * Randomly generates a string of length ten and returns it.
 * 
 * @return string - randomly generated string. 
 */
function generateID() {
    $characters = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789_";
    $charLength = strlen($characters) - 1;
    $output = "";
    for ($index = 0; $index < 10; $index++) {
        $output .= $characters[rand(0,$charLength)];
    }
    return $output;
}

class DBController {
    
    /**
     * Returns a boolean value representing whether a user in the database has the provided username or 
     *   password.
     *  @param string $username - a String that is the username of inquiry
     *  @param string $password - a String that is the password of inquiry
     *  @return boolean
     */
    static function isUser($username, $password) {
        $dbc = @mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME, DB_PORT) 
        or die('Could not connect to MySQL '. mysqli_connect_error());
        if ($username == "" || $password == "" || $username == "" || $password == "") {
            mysqli_close($dbc);
            return false;
        }
        $query = "SElECT user_id FROM user WHERE BINARY username='$username' AND BINARY password='$password'";
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

    /**
     * This method returns a boolean value that represents whether the specified username
     * exists in the database.
     * 
     * @param string $username - the specified username
     * @return boolean - if it exists in the database
     */
    static function isUsername($username) {
        $dbc = @mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME, DB_PORT) 
        or die('Could not connect to MySQL '. mysqli_connect_error());
        if ($username == "" || is_null($username)) {
            mysqli_close($dbc);
            return false;
        }
        $query = "SElECT user_id FROM user WHERE BINARY username='$username'";
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

    /**
     * Returns a PetOwner object representing a user in the database that has the provided username and 
     * password.
     * 
     * @param string $username - a String that is the username
     * @param string $password - a String that is the password
     * @return PetOwner
     */
    static function getPetOwner($username, $password) {
        $dbc = @mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME, DB_PORT) 
        or die('Could not connect to MySQL '. mysqli_connect_error());
        $query = "SElECT user_id, firstname, lastname, username, password, email, 
        phone, address, zipcode, city, state FROM user WHERE BINARY username='$username' AND BINARY password='$password'";
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

    /**
     * Returns a Pet object with the specified search ID or NULL if no pet has the 
     * specified search ID.
     * 
     * @param string $searchID - the specified search ID
     * @return Pet
     */
    static function getPet($searchID) {
        $dbc = @mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME, DB_PORT) 
        or die('Could not connect to MySQL '. mysqli_connect_error());
        $query = "SElECT * FROM pets WHERE BINARY search_id='$searchID'";

        $response = @mysqli_query($dbc, $query);

        if($response) {
            $row = mysqli_fetch_array($response);
            $petID = @$row['pet_id'];
            $userID = @$row['user_id'];
            $name = @$row['name'];
            $chipID = @$row['chip_id'];
            $media = @$row['media'];
            $color = @$row['color'];
            $animal = @$row['animal'];
            if (is_null($userID)) {
                $output = NULL;
            } else {
                $output = new Pet($userID, $petID, $name, $chipID, $media, $color, $animal, $searchID);
            }
            
        } else {
            echo "couldnt issue database query";
            echo mysqli_error($dbc);
            $output = NULL;
        }
        
        mysqli_close($dbc);
        return $output;

    }

    /**
     * Returns a Pet object with the specified pet ID or NULL if no pet has the 
     * specified pet ID.
     * 
     * @param int $petID - the specified pet ID
     * @return Pet
     */
    static function getPetByID($petID) {
        $dbc = @mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME, DB_PORT) 
        or die('Could not connect to MySQL '. mysqli_connect_error());
        $query = "SElECT * FROM pets WHERE pet_id='$petID'";
        $response = @mysqli_query($dbc, $query);
        if($response) {
            $row = mysqli_fetch_array($response);
            $searchID = @$row['search_id'];
            $userID = @$row['user_id'];
            $name = @$row['name'];
            $chipID = @$row['chip_id'];
            $media = @$row['media'];
            $color = @$row['color'];
            $animal = @$row['animal'];
            if (is_null($userID)) {
                $output = NULL;
            } else {
                $output = new Pet($userID, $petID, $name, $chipID, $media, $color, $animal, $searchID);
            }
        } else {
            echo "couldnt issue database query";
            echo mysqli_error($dbc);
            $output = NULL;
        }
        mysqli_close($dbc);
        return $output;
    }

    /**
     * Returns a list of Pet objects with a specified user ID.
     * 
     * @param int $userID - the specified user ID.
     * @return Pet[]
     */
    static function getPets($userID) {
        $output = array();
        $dbc = @mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME, DB_PORT) 
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
                $searchID = @$row['search_id'];
                $pet = new Pet($userID, $petID, $name, $chipID, $media, $color, $animal, $searchID);
                $output[] = $pet;
            }  
        } else {
            echo "couldnt issue database query";
            echo mysqli_error($dbc);
        }
        mysqli_close($dbc);
        return $output;
    }

    /**
     * Returns a Mailbox object with every Message in the database for the specified user ID.
     * 
     * @param int $userID - the specified user ID
     * @return Mailbox
     */
    static function getMailbox($userID) {
        $output = new Mailbox($userID);
        $dbc = @mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME, DB_PORT) 
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

    /**
     * Returns an Address object for a specified user ID from the database.
     * 
     * @param int $userID - the specified user ID
     * @return Address 
     */
    static function getAddress($userID) {
        $dbc = @mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME, DB_PORT) 
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

    /**
     * Inserts a PetOwner object into the database.
     * 
     * @param PetOwner $user - the PetOwner to be added to the database
     * @return boolean - representing whether the PetOwner was inserted into the database
     */
    static function insertPetOwner($user) {
        $dbc = @mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME, DB_PORT) 
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

    /**
     * Inserts a Pet object into the database.
     * 
     * @param Pet $animal - the Pet to be added to the database
     * @return boolean - representing whether the Pet was inserted into the database
     */
    static function insertPet($animal) {
        $dbc = @mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME, DB_PORT) 
        or die('Could not connect to MySQL '. mysqli_connect_error());
        $species = $animal->getAnimal();
        $name = $animal->getName();
        $color = $animal->getColor();
        $userID = $animal->getUserID();
        $chipID = $animal->getChipID();
        $media = $animal->getMedia();
        $searchID = DBController::newPetID();
        if (is_null($media)) {
            $media = "NULL";
        } else {
            $media = "'$media'";
        }
        $insertQuery = "INSERT INTO pets (pet_id, user_id, name, animal, color, chip_id, media, search_id) 
        VALUES (NULL, ?, ?, ?, ?, ?, $media, ?)";
        $stmt = mysqli_prepare($dbc, $insertQuery);
        mysqli_stmt_bind_param($stmt, "isssss", $userID, $name, $species, $color, $chipID, $searchID);
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

    /**
     * Inserts a Message object into the database.
     * 
     * @param Message $message - the Message to be added to the database
     * @return boolean - representing whether the Message was inserted into the database
     */
    static function insertMessage($message) {
        $dbc = @mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME, DB_PORT) 
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
            //echo 'Message Entered';
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

    /**
     * Updates a PetOwner's information in the database with the PetOwner that has the same 
     * user ID.
     * 
     * @param PetOwner $user - a PetOwner's object with the updated information
     * @return boolean - representing whether the PetOwner was updated in the database
     */
    static function updatePetOwner($user) {
        $dbc = @mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME, DB_PORT) 
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

    /**
     * Updates a Pet's information in the database with the Pet that has the same 
     * pet ID if the username and password specified belongs to the PetOwner.
     * 
     * @param Pet $pet - a Pet object with the updated information
     * @param string $username - the specified username 
     * @param string $password - the specified password
     * @return boolean - representing whether the Pet was updated in the database
     */
    static function updatePet($pet, $username, $password) {
        $dbc = @mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME, DB_PORT) 
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
        $query1 = "SElECT user_id FROM user WHERE BINARY username='$username' AND BINARY password='$password'";
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
            if (is_null($media) || $media == ""){
                $media = "NULL";
            } else {
                $media = "'$media'";
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

    /**
     * Deletes a Pet from the database with the specified 
     * pet ID, if the username and password specified belongs to the PetOwner.
     * 
     * @param int $petID - a specified pet ID
     * @param string $username - the specified username 
     * @param string $password - the specified password
     * @return boolean - representing whether the Pet was deleted from the database
     */
    static function deletePet($petID, $username, $password) {
        $dbc = @mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME, DB_PORT) 
        or die('Could not connect to MySQL '. mysqli_connect_error());
        $validation1 = DBController::isUser($username, $password);
        $validation2 = false;
        $query1 = "SElECT user_id FROM user WHERE BINARY username='$username' AND BINARY password='$password'";
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
            $deleteQuery = "DELETE FROM pets WHERE pet_id=$petID";
            if (mysqli_query($dbc, $deleteQuery)) {
                echo "Pet deleted successfully";
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

    /**
     * Deletes a PetOwner from the database with the specified user ID.
     * 
     * @param int $userID - a specified user ID
     * @return boolean - representing whether the PetOwner was deleted from the database
     */
    static function deletePetOwner($userID) {
        $dbc = @mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME, DB_PORT) 
        or die('Could not connect to MySQL '. mysqli_connect_error());
        $deleteQuery = "DELETE FROM user WHERE user_id=$userID";
        if (mysqli_query($dbc, $deleteQuery)) {
            echo "User deleted successfully";
            $output = true;
        } else {
            echo "Error updating record: " . mysqli_error($dbc);
            $output = false;
        }
        mysqli_close($dbc);
        return $output;
    }

    /**
     * Deletes a Message from the database with the specified message ID.
     * 
     * @param int $messageID - a specified message ID
     * @return boolean - representing whether the Message was deleted from the database
     */
    static function deleteMessage($messageID) {
        $dbc = @mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME, DB_PORT) 
        or die('Could not connect to MySQL '. mysqli_connect_error());
        $deleteQuery = "DELETE FROM messages WHERE message_id=$messageID";
        if (mysqli_query($dbc, $deleteQuery)) {
            echo "Message deleted successfully";
            $output = true;
        } else {
            echo "Error updating record: " . mysqli_error($dbc);
            $output = false;
        }
        mysqli_close($dbc);
        return $output;
    }

    /**
     * Returns the largest pet ID in the database.
     * 
     * @return int - the largest pet ID in the database.
     */
    static function maxPetID() {
        $output = 0;
        $dbc = @mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME, DB_PORT) 
        or die('Could not connect to MySQL '. mysqli_connect_error());
        $query = "SElECT MAX(pet_id) AS largest_id FROM pets";
        $response = @mysqli_query($dbc, $query);
        if($response) {
            while ($row = mysqli_fetch_array($response)) {
                $output = @$row['largest_id'];
            }  
        } else {
            echo "couldnt issue database query";
            echo mysqli_error($dbc);
        }
        mysqli_close($dbc);
        return $output;
    }

    /**
     * Returns a boolean value representing whether a pet exists within the database with the specified 
     * search ID. Is case sensitive.
     * 
     * @return boolean - representing whether a pet exists within the database with the specified 
     *                  search ID
     */
    static function isPet($searchID) {
        $dbc = @mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME, DB_PORT) 
        or die('Could not connect to MySQL '. mysqli_connect_error());
        if ($searchID == "" || is_null($searchID)) {
            mysqli_close($dbc);
            return false;
        }
        $query = "SElECT pet_id FROM pets WHERE BINARY search_id='$searchID'";
        $response = @mysqli_query($dbc, $query);
        if($response) {
            $row = mysqli_fetch_array($response);
            $petID = @$row['pet_id'];
            
            if (!is_null($petID)) {
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

    /**
     * Returns a randomly generated search ID that does not already exist in the database.
     * 
     * @return string - the newly generated unique search ID
     */
    static function newPetID() {
        $output = "";
        do {
            $output = generateID();
        } while (DBController::isPet($output));
        return $output;
    }

}

?>