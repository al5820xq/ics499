<?php

class Pet {
    private $animal;
    private $name;
    private $color;
    private $petID;
    private $userID;
    private $chipID;
    private $media;

    function __construct($userID, $petID, $name, $chipID, $media, $color, $animal) {
        $this->animal = $animal;
        $this->name = $name;
        $this->color = $color;
        $this->petID = $petID;
        $this->userID = $userID;
        $this->chipID = $chipID;
        $this->media = $media;
    }

    function getMedia() {
        return $this->media;
    }
    function toString() {
        $output = "";
        $output .= "<hr>";
        $output .= "<h4>Animal Type: " . $this->animal . "</h4>";
        $output .= "<h5>Name: " . $this->name . "</h5>";
        $output .= "<h5>Color: " . $this->color . "</h5>";
        $output .= "<h5>ID: " . strval($this->petID) . "</h5>";
        $output .= "<hr>";
        return $output;
    }
}




?>