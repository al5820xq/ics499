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

    function deleteMessage($index) {
        //Database::deleteMessage($this->messages[$index]->getMessageID());
        \array_splice($this->messages, $index, 1);
        return true;
    }

    function deleteAllMessages() {
        $this->messages = array();
    }
}

?>