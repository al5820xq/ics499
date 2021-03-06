<?php
/**
 * Pet is a class object that represents a pet. This class contains a constructor
 * and accessor methods, along with methods that display the Pet object in a more usable 
 * format.
 * 
 * @author Vincent Peterson
 */
class Pet {
    private $animal;
    private $name;
    private $color;
    private $petID;
    private $userID;
    private $chipID;
    private $media;
    private $searchID;

    function __construct($userID, $petID, $name, $chipID, $media, $color, $animal, $searchID) {
        $this->animal = $animal;
        $this->name = $name;
        $this->color = $color;
        $this->petID = $petID;
        $this->userID = $userID;
        $this->chipID = $chipID;
        $this->media = $media;
        $this->searchID = $searchID;
    }

    function getAnimal() {
        return $this->animal;
    }

    function getName() {
        return $this->name;
    }

    function getColor() {
        return $this->color;
    }

    function getPetID() {
        return $this->petID;
    }

    function getUserID() {
        return $this->userID;
    }

    function getChipID() {
        return $this->chipID;
    }

    function getMedia() {
        return $this->media;
    }

    function getSearchID() {
        return $this->searchID;
    }

    /**
     * Returns the source string of the pet's image if one exists, otherwise returns the source 
     * string for the default pet picture.
     * 
     * @return string the source image string.
     */
    function imgsrc() {
        $output = '';
        if (is_null($this->media)) {
            $output = "Classes/Templates/images/defaultpet.png";
        } else {
            $output = 'data:image/jpeg;base64,' . base64_encode($this->media);
        }
        return $output;
    }

    /**
     * Returns the source string of the pet's QR code.
     * 
     * @return string the source QR code string.
     */
    function qrsrc() {
        $output = "https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=https://www.petsource.app/search.php?petid=".$this->getSearchID()."&choe=UTF-8";
        return $output;
    }

    /**
     * Displays the Pet object as html format.
     */
    function displayPet() {
        include("Classes/Templates/petprofile.php");
    }

    /**
     * Displays the Pet object as html in a string.
     * 
     * @return string containing html code
     */
    function toString() {
        $output = "";
        $output .= "<hr>";
        $output .= "<h4>Animal Type: " . $this->animal . "</h4>";
        $output .= "<h5>Name: " . $this->name . "</h5>";
        $output .= "<h5>Color: " . $this->color . "</h5>";
        $output .= "<h5>ID: " . strval($this->petID) . "</h5>";
        $output .= '<img src="' . $this->imgsrc() . '">';
        $output .= "<hr>";
        return $output;
    }
}




?>