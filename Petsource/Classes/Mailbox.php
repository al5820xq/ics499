<?php

class Mailbox {
    private $userID;
    public $messages;
    private $count;

    function __construct($userID) {
        $this->userID = $userID;
        $this->messages = array();
        $this->count = 0;
    }

    function addMessage($message) {
        $this->messages[] = $message;
        $this->count++;
    }

    function deleteMessage($messageID) {
        for ($index = 0; $index < $this->count; $index++) {
            if ($this->messages[$index]->getMessageID() == $messageID) {
                DBController::deleteMessage($messageID);
                unset($this->messages[$index]);
                //array_splice($this->messages, $index, 1);
                $this->count--;
                return true;
            }
        }
        return false;
    }

    function deleteAllMessages() {
        $this->messages = array();
    }
}

?>