<?php

class Pet {
    public static $numOfAnimal = 0;
    private $id;
    private $animal;
    private $name;
    private $weight;
    private $color;
    private $birthDate;
    private $gender;
    private $breed;

    function __construct($animal, $name, $color) {
        $this->animal = $animal;
        $this->name = $name;
        $this->color = $color;
        $this->id = Pet::$numOfAnimal;
        Pet::$numOfAnimal++;
    }

    function toString() {
        $output = "";
        $output .= "<hr>";
        $output .= "<h4>Animal Type: " . $this->animal . "</h4>";
        $output .= "<h5>Name: " . $this->name . "</h5>";
        $output .= "<h5>Color: " . $this->color . "</h5>";
        $output .= "<h5>ID: " . strval($this->id) . "</h5>";
        $output .= "<hr>";
        return $output;
    }
}




?>