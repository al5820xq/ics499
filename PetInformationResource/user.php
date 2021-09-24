<?php

class User {
    private $username;
    private $password;
    private $userID;
    private $firstName;
    private $lastName;
    private $email;
    private $phone;
    private $address;
    private $zipcode;
    private $city;
    private $state;

    function __construct($username, $password){
        $this->username = $username;
        $this->password = $password;
    }

    function getUser() {
        return $this->username;
    }

    function isValid() {
        require_once('mysqli_connect.php');
        $query = "SElECT user_id, firstname, lastname, username, password, email, 
        phone, address, zipcode, city, state FROM user WHERE username='$this->username' AND password='$this->password'";

        $response = @mysqli_query($dbc, $query);

        if($response) {
            $row = mysqli_fetch_array($response);
            $this->userID = $row['user_id'];
            $this->firstName = $row['firstname'];

        } else {
            echo "couldnt issue database query";
            echo mysqli_error($dbc);
        }
        mysqli_close($dbc);
    }
}

?>