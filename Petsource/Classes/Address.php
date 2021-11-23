<?php
/**
 * Address is a class object that represents an address. This class contains a constructor
 * and accessor methods, along with methods that display the address in a more usable 
 * format.
 * 
 * @author Vincent Peterson
 */
class Address {
    
    private $streetAddress;
    private $zipcode;
    private $city;
    private $state;

    function __construct($streetAddress, $city, $zip, $state) {
        $this->streetAddress = $streetAddress;
        $this->zipcode = $zip;
        $this->city = $city;
        $this->state = $state;
    }

    function getStreetAddress() {
        return $this->streetAddress;
    }

    function getZipcode() {
        return $this->zipcode;
    }

    function getCity() {
        return $this->city;
    }

    function getState() {
        return $this->state;
    }

    /**
     * Returns a string containing a link to search the Address object on google maps.
     * 
     * @return string 
     */
    function getLink() {
        $output = 'https://www.google.com/maps/place/';
        for($index = 0; $index < strlen($this->streetAddress); $index++) {
            if($this->streetAddress[$index] == ' ') {
                $this->streetAddress[$index] = '+';
            }
        }
        $city = $this->city;
        for($index = 0; $index < strlen($this->city); $index++) {
            if($this->city[$index] == ' ') {
                $city = substr($this->city,0,$index) . '%20' . substr($this->city,$index + 1,strlen($this->city) - $index - 1);
            }
        }
        $output = $output . $this->streetAddress . ',+' . $city . ',+' . $this->state . '+' . $this->zipcode . '/';
        return $output;
    }

    /**
     * Returns a string containing the Address object in a more readable format.
     * 
     * @return string 
     */
    function toString() {
        return str_replace("+"," ",$this->streetAddress) . ' ' . $this->city . ' ' . $this->state . ' ' . $this->zipcode;
    }
}

?>