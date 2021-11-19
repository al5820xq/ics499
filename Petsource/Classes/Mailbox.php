<?php
/**
 * Mailbox is a data collection object that contains Message objects. This class contains a constructor
 * and methods that help manipulate the Message objects.
 * 
 * @author Vincent Peterson
 */

class Mailbox {
    private $userID;
    public $messages;
    private $count;

    function __construct($userID) {
        $this->userID = $userID;
        $this->messages = array();
        $this->count = 0;
    }

    /**
     * Adds a Message object to the Mailbox.
     * 
     * @param Message $message the message to be added to the Mailbox
     */
    function addMessage($message) {
        $this->messages[] = $message;
        $this->count++;
    }

    /**
     * Deletes a Message object with a specified ID from the database and data collection.
     * 
     * @param int $messageID the id of the message to be deleted
     * @return boolean representing whether the message was deleted
     */
    function deleteMessage($messageID) {
        for ($index = 0; $index < $this->count; $index++) {
            if ($this->messages[$index]->getMessageID() == $messageID) {
                DBController::deleteMessage($messageID);
                unset($this->messages[$index]);
                $this->count--;
                return true;
            }
        }
        return false;
    }

    /**
     * Deletes all Message objects from the Mailbox but not from database.
     */
    function deleteAllMessages() {
        $this->messages = array();
    }
}

?>