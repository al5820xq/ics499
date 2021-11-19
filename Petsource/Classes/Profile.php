<?php

include_once("DBController.php");

/**
 * Profile is a class object that contains all the information a user needs and methods 
 * to perform desired actions for the user.
 * 
 * @author Vincent Peterson
 */
class Profile {
    private $petOwner;
    private $petList;
    private $inbox;

    function __construct() {
        $petList = array();
    }

    /**
     * This method takes in a username and password as parameters. The method checks if 
     * there is a user in the database with the specified username and password. If there is,
     * then the method proceeds to initialize the $petOwner and $petList with the appropriate 
     * information and display the profile.
     * 
     * @param string $username the username of the user
     * @param string $password the password of the user
     * @return boolean representing whether a user exists with specified username and password.
     */
    function login($username, $password) {
        if (DBController::isUser($username, $password)) {
            $this->petOwner = DBController::getPetOwner($username, $password);
            $userID = $this->petOwner->getUserID();
            $this->petList = DBController::getPets($userID);
            $this->displayProfile();
            return true;
        } else {
            return false;
        }
    }

    /**
     * Displays the Profile object as presentable html
     */
    function displayProfile() {
        echo $this->petOwner->toString();
        echo'<h1>Pets</h1>';
        $petIndex = 0;
        foreach($this->petList as $pet) {
            $pet->displayPet();
            $petIndex++;
        }
        if ($petIndex == 0) {
            echo'<p>No pets</p>';
        }
    }

    /**
     * Verifies if the PetOwner currently in the Profile object is a valid user.
     * 
     * @return boolean represents if the PetOwner currently in the Profile object is a valid user
     */
    function isUser() {
        return DBController::isUser($this->petOwner->getUsername(), $this->petOwner->getPassword());
    }

    /**
     * Adds a pet belonging to the current PetOwner to the database.
     * 
     * @param string $name the name of the pet
     * @param string $animal the type of animal that the pet is
     * @param string $color the color of the pet
     * @param string $chipID of the pet
     * @param string $media a picture of the pet
     * @return boolean representing whether the pet was successfully registered
     */
    function registerPet($name, $animal, $color, $chipID, $media) {
        $pet = new Pet($this->petOwner->getUserID(), NULL, $name, $chipID, $media, $color, $animal, NULL);
        return DBController::insertPet($pet);
    }

    /**
     * Adds a PetOwner to the database.
     * 
     * @param string $username the username of the pet owner
     * @param string $password the password of the pet owner
     * @param string $firstname the first name of the pet owner
     * @param string $lastname the last name of the pet owner
     * @param string $email the email of the pet owner
     * @param string $phonenumber the phone number of the pet owner
     * @param string $address the address of the pet owner
     * @param string $city the city of the pet owner
     * @param string $zipcode the zipcode of the pet owner
     * @param string $state the state of the pet owner
     * @return boolean representing whether the PetOwner was successfully added
     */
    function registerUser($username, $password, $firstname, $lastname, $email, $phonenumber, 
                            $address, $city, $zipcode, $state) {
        // Prepare an insert statement
        $addressObject = new Address($address, $city, $zipcode, $state);
        $petOwner = new PetOwner(NULL, $username, $password, $firstname, $lastname, $email, $phonenumber, $addressObject);
        return DBController::insertPetOwner($petOwner);
    }

    /**
     * Updates the current PetOwner's information to the database.
     * 
     * @param string $password the password of the pet owner
     * @param string $firstname the first name of the pet owner
     * @param string $lastname the last name of the pet owner
     * @param string $email the email of the pet owner
     * @param string $phonenumber the phone number of the pet owner
     * @param string $address the address of the pet owner
     * @param string $city the city of the pet owner
     * @param string $zipcode the zipcode of the pet owner
     * @param string $state the state of the pet owner
     * @return boolean representing whether the PetOwner was successfully updated
     */
    function updateUser($password, $firstname, $lastname, $email, $phonenumber, 
                            $address, $city, $zipcode, $state) {
        // Prepare an update statement
        $addressObject = new Address($address, $city, $zipcode, $state);
        $petOwner = new PetOwner($this->petOwner->getUserID(), $this->petOwner->getUsername(), $password, $firstname, $lastname, $email, $phonenumber, $addressObject);
        return DBController::updatePetOwner($petOwner);
    }

    /**
     * Updates a pets information belonging to the current PetOwner to the database.
     * 
     * @param int $petID the petID of the pet to be updated
     * @param string $name the name of the pet
     * @param string $animal the type of animal that the pet is
     * @param string $color the color of the pet
     * @param string $chipID of the pet
     * @param string $media a picture of the pet
     * @return boolean representing whether the pet was successfully updated
     */
    function updatePet($petID, $name, $animal, $color, $chipID, $media) {
        $pet = new Pet($this->petOwner->getUserID(), $petID, $name, $chipID, $media, $color, $animal, NULL);
        return DBController::updatePet($pet, $this->petOwner->getUsername(), $this->petOwner->getPassword());
    }

    /**
     * This method assigns a Mailbox object to the $inbox field with every message in the database 
     * that is intended for the current PetOwner. Then displays every message in HTML format.
     */
    function getMessages() {
        $this->inbox = DBController::getMailbox($this->petOwner->getUserID());
        foreach($this->inbox->messages as $message) {
            $messageID = $message->getMessageID();
            $name = $this->petName($message->getPetID());
            $messageString = $message->getMessage();
            include("Classes/Templates/messagedisplay.php");
        }
    }

    /**
     * This method deletes a Message object from the user's Mailbox and from the database.
     * 
     * @param int $messageID the message ID of the message to be deleted
     */
    function deleteMessage($messageID) {
        $this->inbox->deleteMessage(intval($messageID));
    }

    /**
     * This method deletes a Pet object from the database.
     * 
     * @param int $petID the pet ID of the pet to be deleted
     */
    function deletePet($petID) {
        DBController::deletePet($petID, $this->petOwner->getUsername(), $this->petOwner->getPassword());
    }

    /**
     * Retrieves the name of the specified petID if the Pet object is in the $petList list
     * otherwise returns an empty string.
     * 
     * @param int $petID the pet ID of the desired name
     * @return string the name 
     */
    function petName($petID) {
        foreach($this->petList as $pet) {
            if ($pet->getPetID() == $petID) {
                return $pet->getName();
            }
        }
        return "";
    }

    /**
     * Returns the Pet object of a specified pet ID from the $petList List otherwise returns NULL.
     * 
     * @param int $petID the pet ID of the desired Pet
     * @return Pet with the petID
     */
    function getPet($petID) {
        foreach($this->petList as $pet) {
            if ($pet->getPetID() == $petID) {
                return $pet;
            }
        }
        return NULL;
    }

    function getPetOwner() {
        return $this->petOwner;
    }

}

?>