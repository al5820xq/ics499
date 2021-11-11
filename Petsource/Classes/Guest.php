<?php

include_once("DBController.php");

class Guest {
    public $pet;
    public $address;

    function __construct() {
    }

    function searchPet($searchID) {
        $this->pet = DBController::getPet($searchID);
        if (is_null($this->pet)) {
            return false;
        } else {
            $this->address = DBController::getAddress($this->pet->getUserID());
            return true;
        }
    }

    function sendMessage($message) {
        $messageObject = new Message(NULL, $this->pet->getUserID(), $this->pet->getPetID(), $message);
        return DBController::insertMessage($messageObject);
    }

    function getImg() {
        return $this->pet->imgsrc();
    }

    function toString() {
        $output = '<p>Hello, my name is ' . ucfirst(strtolower($this->pet->getName())) . ". I am a " 
        . strtolower($this->pet->getColor()) . " " . strtolower($this->pet->getAnimal())
        . '. I live at <a href="' . $this->address->getlink() . '">' . $this->address->toString() .
        '</a>. Please bring me home. </p>';
        return $output;
    }
}
?>