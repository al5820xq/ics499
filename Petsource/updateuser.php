<?php
// Include config file
include_once "Classes/Profile.php";
 
session_start();

// Store data in session variables
$username = $_SESSION["username"];                            
$password = $_SESSION["password"];
$profile = unserialize($_SESSION["profile"]);
if (DBController::isUser($username, $password)) {

} else {
    echo('<h1>Not logged in</h1>');
    header("Location: login.php");
}

// Define variables and initialize with empty values
$username = $profile->getPetOwner()->getUsername();
$firstname = $profile->getPetOwner()->getFirstName();
$lastname = $profile->getPetOwner()->getLastName();
$email = $profile->getPetOwner()->getEmail();
$address = $profile->getPetOwner()->getAddress()->getStreetAddress();
$city = $profile->getPetOwner()->getAddress()->getCity();
$zipcode = $profile->getPetOwner()->getAddress()->getZipcode();
$state = $profile->getPetOwner()->getAddress()->getState();
$phonenumber = $profile->getPetOwner()->getPhone();
$password = $profile->getPetOwner()->getPassword();
$confirm_password = $profile->getPetOwner()->getPassword();
$username_err = $firstname_err = $lastname_err = $email_err = $address_err = $city_err = $zipcode_err = $state_err = $phonenumber_err = $password_err = $confirm_password_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

    // Validate firstname
    if(empty(trim($_POST["firstname"]))){
        $firstname_err = "Please enter a first name.";     
    } elseif(strlen(trim($_POST["firstname"])) < 2){
        $firstname_err = "First name must have at least 2 characters.";
    } else{
        $firstname = trim($_POST["firstname"]);
    }

    // Validate lastname
    if(empty(trim($_POST["lastname"]))){
        $lastname_err = "Please enter a lastname.";     
    } elseif(strlen(trim($_POST["lastname"])) < 2){
        $lastname_err = "Last name must have atleast 2 characters.";
    } else{
        $lastname = trim($_POST["lastname"]);
    }

    // Validate email
    if(empty(trim($_POST["email"]))){
        $email_err = "Please enter an email.";     
    } elseif(strlen(trim($_POST["email"])) < 3 || !str_contains($_POST["email"], "@") || !str_contains($_POST["email"], ".")){
        $email_err = "Please enter a valid email address.";
    } else{
        $email = trim($_POST["email"]);
    }

    // Validate address
    if(empty(trim($_POST["address"]))){
        $address_err = "Please enter an address.";     
    } elseif(strlen(trim($_POST["address"])) < 6){
        $address_err = "Address must have at least 6 characters.";
    } else{
        $address = trim($_POST["address"]);
    }

    // Validate city
    if(empty(trim($_POST["city"]))){
        $city_err = "Please enter a city.";     
    } elseif(strlen(trim($_POST["city"])) < 3){
        $city_err = "City must have at least 3 characters.";
    } else{
        $city = trim($_POST["city"]);
    }

    // Validate zipcode
    if(empty(trim($_POST["zipcode"]))){
        $zipcode_err = "Please enter a zipcode.";     
    } elseif(strlen(trim(strval($_POST["zipcode"]))) != 5){
        $zipcode_err = "Zipcode must have 5 characters.";
    } else{
        $zipcode = trim(strval($_POST["zipcode"]));
    }

    // Validate state
    if(empty(trim($_POST["state"]))){
        $state_err = "Please enter a state.";     
    } elseif(strlen(trim($_POST["state"])) != 2){
        $state_err = "State must have 2 characters.";
    } else{
        $state = strtoupper(trim($_POST["state"]));
    }

    // Validate phonenumber
    if(empty(trim($_POST["phonenumber"]))){
        $phonenumber_err = "Please enter a password.";     
    } elseif(strlen(str_replace("-","",trim($_POST["phonenumber"]))) < 10){
        $phonenumber_err = "Phone number must have 10 or 11 digits.";
    } else{
        $phonenumber = str_replace("-","",trim($_POST["phonenumber"]));
    }
    
    // Validate password
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter a password.";     
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "Password must have atleast 6 characters.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm password.";     
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }
    
    // Check input errors before inserting in database
    if(empty($username_err) && empty($firstname_err) && empty($lastname_err) && empty($email_err) && empty($address_err) &&
        empty($city_err) && empty($zipcode_err) && empty($state_err) && empty($phonenumber_err) && empty($password_err) && 
        empty($confirm_password_err) && isset($_POST['submit'])){
        
        // Prepare an insert statement
        

        // Attempt to execute the prepared statement
        if($profile->updateUser($password, $firstname, $lastname, $email, $phonenumber, 
            $address, $city, $zipcode, $state)){
            // Redirect to welcome page
            $_SESSION["password"] = $password;
            header("location: welcome.php");
        } else{
            echo "Oops! Something went wrong. Please try again later.";
        }
    }
}
?>
 
<!DOCTYPE html>
<html lang="en">
    <?php
    include("Classes/Templates/loggedinheader.html");
    ?>


        <div class="small-container2">
            <div class="col-1"> 
                <h1 class="title">Update Information</h1>
                <p>Please update your contact information below.</p><br>
            </div>    
       
        </div>

    <div class="small-container2">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label>Username: </label>
                <p class=""><?php echo $username; ?></p>
            </div>
            <div class="form-group">
                <label>First Name</label>
                <input type="text" name="firstname" class="form-control <?php echo (!empty($firstname_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $firstname; ?>">
                <p class=""><?php echo $firstname_err; ?></p>
            </div>
            <div class="form-group">
                <label>Last Name</label>
                <input type="text" name="lastname" class="form-control <?php echo (!empty($lastname_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $lastname; ?>">
                <p class=""><?php echo $lastname_err; ?></p>
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="text" name="email" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $email; ?>">
                <p class=""><?php echo $email_err; ?></p>
            </div>
            <div class="form-group">
                <label>Street Address</label>
                <input type="text" name="address" class="form-control <?php echo (!empty($address_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $address; ?>">
                <p class=""><?php echo $address_err; ?></p>
            </div>
            <div class="form-group">
                <label>City</label>
                <input type="text" name="city" class="form-control <?php echo (!empty($city_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $city; ?>">
                <p class=""><?php echo $city_err; ?></p>
            </div>
            <div class="form-group">
                <label>Zip Code</label>
                <input type="text" name="zipcode" class="form-control <?php echo (!empty($zipcode_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $zipcode; ?>">
                <p class=""><?php echo $zipcode_err; ?></p>
            </div>
            <div class="form-group">
                <label>State</label>
                <input type="text" name="state" class="form-control <?php echo (!empty($state_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $state; ?>">
                <p class=""><?php echo $state_err; ?></p>
            </div>
            <div class="form-group">
                <label>Phone Number</label>
                <input type="text" name="phonenumber" class="form-control <?php echo (!empty($phonenumber_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $phonenumber; ?>">
                <p class=""><?php echo $phonenumber_err; ?></p>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $password; ?>">
                <p class=""><?php echo $password_err; ?></p>
            </div>
            <div class="form-group">
                <label>Confirm Password</label>
                <input type="password" name="confirm_password" class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $confirm_password; ?>">
                <p class=""><?php echo $confirm_password_err; ?></p>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit" name="submit">
                <input type="reset" class="btn btn-secondary ml-2" value="Reset">
            </div>
            <br>
        </form>
    </div>    

    <!--------- FOOTER --------->
	<?php
    include("Classes/Templates/footer.html");
    ?>
</html>