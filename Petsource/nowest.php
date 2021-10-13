<?php
include_once("Classes/DBController.php");
include_once("Classes/PetOwner.php");
echo("<h1>there is only east</h1>");
$output = DBController::isUser(NULL,'');
$shoutput = $output ? 'true' : 'false';
echo($shoutput);
$output = DBController::isUser('example5','password');
$shoutput = $output ? 'true' : 'false';
echo($shoutput);
$output = DBController::isUser('exampl5','password');
$shoutput = $output ? 'true' : 'false';
echo($shoutput);
$owner = DBController::getPetOwner('example5','password');
$ouput = $owner->getUserID();
echo(strval($ouput));
DBController::pet5pic();
$pets = DBController::getPets(2);
foreach($pets as $pet) {
    echo $pet->toString();
}
$mailbox = DBController::getMailbox(3);
foreach($mailbox->messages as $message) {
    $string = $message->getMessage();
    echo "<p>$string</p>";
}
if (!DBController::isUser('dogcaptain', 'password')) {
    $address = new Address('9733 Avocet St NW', 'Coon Rapids', '55433', 'MN');
    $newUser = new PetOwner(NULL, 'dogcaptain', 'testpass3', 'Frank', 'Reynolds', 'johndoe@gmail.com', '612-632-6526', $address);
    DBController::insertPetOwner($newUser);
    $output = DBController::isUser('dogcaptain', 'testpass3');
    $shoutput = $output ? 'User registered' : 'User not registered';
    echo("<p>$shoutput</P>");
}
$pet = new Pet(5, NULL, 'Molly', '18007546784', NULL, 'Gray', 'Cat');
//DBController::insertPet($pet);
$message = new Message(NULL, 5, 8, "Holy moly I found your cat");
//DBController::insertMessage($message);
$address = new Address('9733 Avocet St NW', 'Coon Rapids', '55433', 'MN');
$updateUser = new PetOwner(5, 'dogcaptain', 'password', 'Frank', 'Reynolds', 'johndoe@gmail.com', '612-632-6526', $address);
//DBController::updatePetOwner($updateUser);
$pet = new Pet(5, 8, 'Molly', '18007546784', NULL, 'Black', 'DOG');
//DBController::updatePet($pet, 'dogcaptain', 'passwoord');
//DBController::deletePet(6, 'jfk','password');
//DBController::deletePetOwner(6);

?>