<?php

class User {
    private $username;
    private $password;

    function __construct($username, $password){
        $this->username = $username;
        $this->password = $password;
    }

    function getUser() {
        return $this->username;
    }

    function isValid() {
        require_once('mysqli_connect.php');
        
    }
}

?>