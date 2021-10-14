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

    }

}

?>