<?php
/**
 * Guest is a class object that contains all the methods and fields required for the 
 * guests functionality. The Guest user does not sign into the system.
 * 
 * @author Vincent Peterson
 */

include_once("DBController.php");

class Guest {
    public $pet;
    public $address;

    function __construct() {
    }

    /**
     * Searches the database with a search ID and assigns the Pet and Address objects correlating 
     * to the search ID to the $pet and $address field. Returns a boolean value representing whether or not 
     * the search ID exists within the database.
     * 
     * @param string $searchID - the search ID to be searched
     * @return boolean value representing whether or not the search ID exists within the database.
     */
    function searchPet($searchID) {
        $this->pet = DBController::getPet($searchID);
        if (is_null($this->pet)) {
            return false;
        } else {
            $this->address = DBController::getAddress($this->pet->getUserID());
            return true;
        }
    }

    /**
     * Adds a Message object to the database with a specified message.
     * 
     * @param string $message - the specified message to enter into the database.
     * @return boolean representing whether the message was added to the database.
     */
    function sendMessage($message) {
        $messageObject = new Message(NULL, $this->pet->getUserID(), $this->pet->getPetID(), $message);
        return DBController::insertMessage($messageObject);
    }

    /**
     * Returns the source string of the currently stored $pet image.
     * 
     * @return string - the source string of the currently stored $pet image
     */
    function getImg() {
        return $this->pet->imgsrc();
    }

    /**
     * Returns a string message of the combined $pet and $address information.
     * 
     * @return string - message of the combined $pet and $address information
     */
    function toString() {
        $output = '<p>Hello, my name is ' . ucfirst(strtolower($this->pet->getName())) . ". I am a " 
        . strtolower($this->pet->getColor()) . " " . strtolower($this->pet->getAnimal())
        . '. I live at <a href="' . $this->address->getlink() . '">' . $this->address->toString() .
        '</a>. Please bring me home. </p>';
        return $output;
    }
}
?>