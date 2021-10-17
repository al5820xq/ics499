<?php
// Initialize the session
session_start();
 
// Include config file
require_once "Classes/Guest.php";
require_once "Classes/Templates/style.php";
 
// Define variables and initialize with empty values
$petid = "";
$petid_err = "";
$foundPet = false;
 
// Processing form data when form is submitted
//$_SERVER["REQUEST_METHOD"] == "GET"
if(isset($_GET["petid"])){
 
    // Check if petid is empty
    if(empty(trim($_GET["petid"]))){
        $petid_err = "Please enter a pet id.";
    } else{
        $petid = trim($_GET["petid"]);
    }
    
    // Validate credentials
    if(empty($petid_err)){
        $guest = new Guest();
        $foundPet = $guest->searchPet($petid);
        if($foundPet){
            echo $guest->toString();
        } else{
            $petid_err = "invalid pet id.";
                
        }
    }
}
?>
 
 <!DOCTYPE html>
<html lang="en">
<?php
include("Classes/Templates/header.html");

if (!$foundPet) {
    include("Classes/Templates/searchform.php");
}


    //<!--------- FOOTER --------->
    include("Classes/Templates/footer.html");
    ?>
</html>