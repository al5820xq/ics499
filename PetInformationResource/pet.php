<?php

class Pet {
    public static $numOfAnimal = 0;
    private $petNum;
    private $animal;
    private $name;
    private $color;
    private $petID;
    private $userID;
    private $chipID;
    private $media;
    private $weight;
    private $birthDate;
    private $gender;
    private $breed;

    function __construct($animal, $name, $color) {
        $this->animal = $animal;
        $this->name = $name;
        $this->color = $color;
        $this->petNum = Pet::$numOfAnimal;
        Pet::$numOfAnimal++;
    }

    function toString() {
        $output = "";
        $output .= "<hr>";
        $output .= "<h4>Animal Type: " . $this->animal . "</h4>";
        $output .= "<h5>Name: " . $this->name . "</h5>";
        $output .= "<h5>Color: " . $this->color . "</h5>";
        $output .= "<h5>ID: " . strval($this->petNum) . "</h5>";
        $output .= "<hr>";
        return $output;
    }
}




?>