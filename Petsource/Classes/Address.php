<?php

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

    function getLink() {
        $output = 'https://www.google.com/maps/place/';
        for($index = 0; $index < strlen($this->streetAddress); $index++) {
            if($this->streetAddress[$index] == ' ') {
                $this->streetAddress[$index] = '+';
            }
        }
        for($index = 0; $index < strlen($this->city); $index++) {
            if($this->city[$index] == ' ') {
                $city = substr($this->city,0,$index) . '%20' . substr($this->city,$index + 1,strlen($this->city) - $index - 1);
            }
        }
        $output = $output . $this->streetAddress . ',+' . $this->city . ',+' . $this->state . '+' . $this->zipcode . '/';
        return $output;
    }

    function toString() {
        return $this->streetAddress . ' ' . $this->city . ' ' . $this->state . ' ' . $this->zipcode;
    }
}

?>