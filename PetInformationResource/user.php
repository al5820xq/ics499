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

    function getID() {
        return $this->userID;
    }

    function isValid() {
        $output = false;
        //require_once('mysqli_connect.php');
        @require('mysqli_connect.php');
        $query = "SElECT user_id, firstname, lastname, username, password, email, 
        phone, address, zipcode, city, state FROM user WHERE username='$this->username' AND password='$this->password'";

        $response = @mysqli_query($dbc, $query);

        if($response) {
            $row = mysqli_fetch_array($response);
            $this->userID = @$row['user_id'];
            $this->firstName = @$row['firstname'];
            $this->lastName = @$row['lastname'];
            $this->email = @$row['email'];
            $this->phone = @$row['phone'];
            $this->address = @$row['address'];
            $this->zipcode = @$row['zipcode'];
            $this->city = @$row['city'];
            $this->state = @$row['state'];
            if (!is_null($this->userID)) {
                $output = true;
            } else {
                $output = false;
            }
        } else {
            echo "couldnt issue database query";
            echo mysqli_error($dbc);
            $output = false;
        }
        //mysqli_close($dbc);
        return $output;
    }

    function verify() {
        $output = false;
        //require_once('mysqli_connect.php');
        @require('mysqli_connect.php');
        $query = "SElECT user_id FROM user WHERE username='$this->username' AND password='$this->password'";

        $response = @mysqli_query($dbc, $query);

        if($response) {
            $row = mysqli_fetch_array($response);
            $databaseID = $row['user_id'];
            if ($this->userID == $databaseID && !is_null($databaseID)) {
                return true;
            } else {
                return false;
            }
        } else {
            echo "couldnt issue database query";
            echo mysqli_error($dbc);
            $output = false;
        }
        //mysqli_close($dbc);
        return $output;
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