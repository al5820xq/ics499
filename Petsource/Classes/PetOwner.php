<?php
include_once("Address.php");

class PetOwner {
    private $username;
    private $password;
    private $userID;
    private $firstName;
    private $lastName;
    private $email;
    private $phone;
    private $address;

    function __construct($userID, $username, $password, $firstName, $lastName, $email, $phone, $address){
        $this->userID = $userID;
        $this->username = $username;
        $this->password = $password;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->email = $email;
        $this->phone = $phone;
        $this->address = $address;
    }

    function getUsername() {
        return $this->username;
    }

    function getPassword() {
        return $this->password;
    }

    function getUserID() {
        return $this->userID;
    }

    function getFirstName() {
        return $this->firstName;
    }

    function getLastName() {
        return $this->lastName;
    }

    function getEmail() {
        return $this->email;
    }

    function getPhone() {
        return $this->phone;
    }

    function getAddress() {
        return $this->address;
    }

    function toString() {
        echo '<table align="center" cellspacing="5" cellpadding="8">';
        echo '<tr><td align="left"><b>Id: </b></td>';
        echo '<td align="left">'.$this->userID.'</td></tr>';
        echo '<tr><td align="left"><b>User Name: </b></td>';
        echo '<td align="left">'.$this->username.'</td></tr>';
        echo '<tr><td align="left"><b>First Name: </b></td>';
        echo '<td align="left">'.$this->firstName.'</td></tr>';
        echo '<tr><td align="left"><b>Last Name: </b></td>';
        echo '<td align="left">'.$this->lastName.'</td></tr>';
        echo '<tr><td align="left"><b>Email: </b></td>';
        echo '<td align="left">'.$this->email.'</td></tr>';
        echo '<tr><td align="left"><b>Phone Number: </b></td>';
        echo '<td align="left">'.$this->phone.'</td></tr>';
        echo '<tr><td align="left"><b>Address: </b></td>';
        echo '<td align="left">'.$this->address.'</td></tr>';
        echo '<tr><td align="left"><b>Zip Code: </b></td>';
        echo '<td align="left">'.$this->zipcode.'</td></tr>';
        echo '<tr><td align="left"><b>City: </b></td>';
        echo '<td align="left">'.$this->city.'</td></tr>';
        echo '<tr><td align="left"><b>State: </b></td>';
        echo '<td align="left">'.$this->state.'</td></tr>';
        echo '</table>';
    }
}

?>