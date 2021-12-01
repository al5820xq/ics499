<?php
include("Classes/Templates/style.php");
//classes

use Dompdf\Dompdf;

include_once("Classes/Profile.php");
require_once('dompdf/autoload.inc.php');
use Dompdf\Options;
session_start();

$username = $_SESSION["username"];                            
$password = $_SESSION["password"];
$profile = unserialize($_SESSION["profile"]);
if (DBController::isUser($username, $password) && isset($_GET["petid"])) {
    $pet = $profile->getPet($_GET["petid"]);
    if (is_null($pet)) {
        header("Location: login.php");
    } else {
        include("Classes/Templates/loggedinheader.html");
        $animal = ucfirst(strtolower($pet->getAnimal()));
        $name = ucfirst(strtolower($pet->getName()));
        $color = ucfirst(strtolower($pet->getColor()));
        $location = $profile->getPetOwner()->getAddress()->getCity() . ", " . $profile->getPetOwner()->getAddress()->getState();
        $phone = $profile->getPetOwner()->getPhone();
        $email = $profile->getPetOwner()->getEmail();
        include("Classes/Templates/posterform.php");
        include("Classes/Templates/footer.html");
    }
} else {
    echo('<h1>Not logged in</h1>');
    header("Location: login.php");
}
?>