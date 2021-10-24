<?php

include_once("DBController.php");

class Profile {
    private $petOwner;
    private $petList;
    private $inbox;

    function __construct() {
        $petList = array();
    }

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

    function displayProfile() {
        echo $this->petOwner->toString();
        echo'<h1>Pets</h1>';
        $petIndex = 0;
        foreach($this->petList as $pet) {
            $pet->displayPet();
            $petIndex++;
        }
    }

    function isUser() {
        return DBController::isUser($this->petOwner->getUsername(), $this->petOwner->getPassword());
    }

    function registerPet($name, $animal, $color, $chipID, $media) {
        $pet = new Pet($this->petOwner->getUserID(), NULL, $name, $chipID, $media, $color, $animal);
        return DBController::insertPet($pet);
    }

    function registerUser($username, $password, $firstname, $lastname, $email, $phonenumber, 
                            $address, $city, $zipcode, $state) {
        // Prepare an insert statement
        $addressObject = new Address($address, $city, $zipcode, $state);
        $petOwner = new PetOwner(NULL, $username, $password, $firstname, $lastname, $email, $phonenumber, $addressObject);
        return DBController::insertPetOwner($petOwner);
    }

    function updateUser($password, $firstname, $lastname, $email, $phonenumber, 
                            $address, $city, $zipcode, $state) {
        // Prepare an update statement
        $addressObject = new Address($address, $city, $zipcode, $state);
        $petOwner = new PetOwner($this->petOwner->getUserID(), $this->petOwner->getUsername(), $password, $firstname, $lastname, $email, $phonenumber, $addressObject);
        return DBController::updatePetOwner($petOwner);
    }

    function updatePet($petID, $name, $animal, $color, $chipID, $media) {
        $pet = new Pet($this->petOwner->getUserID(), $petID, $name, $chipID, $media, $color, $animal);
        return DBController::updatePet($pet, $this->petOwner->getUsername(), $this->petOwner->getPassword());
    }

    function getMessages() {
        $this->inbox = DBController::getMailbox($this->petOwner->getUserID());
        foreach($this->inbox->messages as $message) {
            $messageID = $message->getMessageID();
            $name = $this->petName($message->getPetID());
            $messageString = $message->getMessage();
            include("Classes/Templates/messagedisplay.php");
        }
    }

    function deleteMessage($messageID) {
        $this->inbox->deleteMessage(intval($messageID));
    }

    function petName($petID) {
        foreach($this->petList as $pet) {
            if ($pet->getPetID() == $petID) {
                return $pet->getName();
            }
        }
        return "";
    }

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