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
            $this->inbox = DBController::getMailbox($userID);
            $this->displayProfile();
            return true;
        } else {
            return false;
        }
    }

    function displayProfile() {
        echo $this->petOwner->toString();
        echo'<h1>Pets</h1>';
        foreach($this->petList as $pet) {
            echo $pet->toString();
        }
    }

    function isUser() {
        return DBController::isUser($this->petOwner->getUsername(), $this->petOwner->getPassword());
    }

    function registerPet($name, $animal, $color, $chipID, $media) {
        $pet = new Pet($this->petOwner->getUserID(), NULL, $name, $chipID, $media, $color, $animal);
        return DBController::insertPet($pet);
    }

}

?>