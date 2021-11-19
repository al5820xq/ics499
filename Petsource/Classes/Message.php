<?php
/**
 * Message is a class object that represents a message. This class contains a constructor
 * and accessor methods.
 * 
 * @author Vincent Peterson
 */
class Message {
    private $messageID;
    private $userID;
    private $petID;
    private $message;

    function __construct($messageID, $userID, $petID, $message) {
        $this->messageID = $messageID;
        $this->userID = $userID;
        $this->petID = $petID;
        $this->message = $message;
    }

    function getMessageID() {
        return $this->messageID;
    }

    function getPetID() {
        return $this->petID;
    }

    function getUserID() {
        return $this->userID;
    }

    function getMessage() {
        return $this->message;
    }
}

?>