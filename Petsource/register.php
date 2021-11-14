<?php
include("Classes/Templates/style.php");
// Include config file
include_once "Classes/Profile.php";
 
// Define variables and initialize with empty values
$username = $firstname = $lastname = $email = $address = $city = $zipcode = $state = $phonenumber = $password = $confirm_password = "";
$username_err = $firstname_err = $lastname_err = $email_err = $address_err = $city_err = $zipcode_err = $state_err = $phonenumber_err = $password_err = $confirm_password_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate username
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter a username.";
    } elseif(!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST["username"]))){
        $username_err = "Username can only contain letters, numbers, and underscores.";
    } else{
        $param_username = trim($_POST["username"]);
        $boolean = DBController::isUsername($param_username);
        if($boolean){
            $username_err = "This username is already taken.";
        } else{
            $username = trim($_POST["username"]);
        }
    }

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
        $phonenumber_err = "Please enter a phone number.";     
    } elseif(strlen(str_replace("-","",trim($_POST["phonenumber"]))) < 10){
        $phonenumber_err = "Phone number must have 10 or 11 digits.";
    } else{
        $phonenumber = str_replace("-","",trim($_POST["phonenumber"]));
    }
    
    // Validate password
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter a password.";     
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "Password must have at least 6 characters.";
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
        empty($confirm_password_err)){
        
        // Prepare an insert statement
        $profile = new Profile();

        // Attempt to execute the prepared statement
        if($profile->registerUser($username, $password, $firstname, $lastname, $email, $phonenumber, 
            $address, $city, $zipcode, $state)){
            // Redirect to login page
            header("location: login.php");
        } else{
            echo "Oops! Something went wrong. Please try again later.";
        }
    }
}
?>
 
<!DOCTYPE html>
<html lang="en">
    <?php
    include("Classes/Templates/header.html");
    ?>
    <?php
    include("Classes/functions.html");
    ?>
    <script type="text/javascript">
        function validateInputs() {
            document.getElementById('firstname_err').textContent = validateFirstName(document.getElementById('firstname').value, 
                                                                                document.getElementById('firstname_err').textContent);

            document.getElementById('lastname_err').textContent = validateLastName(document.getElementById('lastname').value, 
                                                                                document.getElementById('lastname_err').textContent);

            document.getElementById('email_err').textContent = validateEmail(document.getElementById('email').value, 
                                                                                document.getElementById('email_err').textContent);

            //document.getElementById('username_err').textContent = validateUsername(document.getElementById('username').value, 
            //                                                                    document.getElementById('username_err').textContent);  

            document.getElementById('address_err').textContent = validateAddress(document.getElementById('address').value, 
                                                                                document.getElementById('address_err').textContent);

            document.getElementById('city_err').textContent = validateCity(document.getElementById('city').value, 
                                                                                document.getElementById('city_err').textContent);

            document.getElementById('zipcode_err').textContent = validateZipcode(document.getElementById('zipcode').value, 
                                                                                document.getElementById('zipcode_err').textContent);

            document.getElementById('state_err').textContent = validateState(document.getElementById('state').value, 
                                                                                document.getElementById('state_err').textContent);

            document.getElementById('phonenumber_err').textContent = validatePhoneNumber(document.getElementById('phonenumber').value, 
                                                                                document.getElementById('phonenumber_err').textContent);       
                                                                                
            document.getElementById('password_err').textContent = validatePassword(document.getElementById('password').value, 
                                                                                document.getElementById('password_err').textContent);   

            document.getElementById('confirm_password_err').textContent = validateConfirmPassword(document.getElementById('password').value, 
                                                                                document.getElementById('password_err').textContent,
                                                                                document.getElementById('confirm_password').value, 
                                                                                document.getElementById('confirm_password_err').textContent);                                                                       
        }
        setInterval(validateInputs, 5);

        
    </script>

        <div class="small-container2">
            <div class="col-1"> 
                <h1 class="title">Sign Up</h1>
                <p>Please fill the form below to create an account.</p><br>
            </div>    
       
        </div>

    <div class="small-container2">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" id="username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
                <p id="username_err" class="input_error"><?php echo $username_err; ?></p>
            </div>
            <div class="form-group">
                <label>First Name</label>
                <input type="text" name="firstname" id="firstname" class="form-control <?php echo (!empty($firstname_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $firstname; ?>">
                <p id="firstname_err" class="input_error"><?php echo $firstname_err; ?></p>
            </div>
            <div class="form-group">
                <label>Last Name</label>
                <input type="text" name="lastname" id="lastname" class="form-control <?php echo (!empty($lastname_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $lastname; ?>">
                <p id="lastname_err" class="input_error"><?php echo $lastname_err; ?></p>
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="text" name="email" id="email" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $email; ?>">
                <p id="email_err" class="input_error"><?php echo $email_err; ?></p>
            </div>
            <div class="form-group">
                <label>Street Address</label>
                <input type="text" name="address" id="address" class="form-control <?php echo (!empty($address_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $address; ?>">
                <p id="address_err" class="input_error"><?php echo $address_err; ?></p>
            </div>
            <div class="form-group">
                <label>City</label>
                <input type="text" name="city" id="city" class="form-control <?php echo (!empty($city_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $city; ?>">
                <p id="city_err" class="input_error"><?php echo $city_err; ?></p>
            </div>
            <div class="form-group">
                <label>Zip Code</label>
                <input type="text" name="zipcode" id="zipcode" class="form-control <?php echo (!empty($zipcode_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $zipcode; ?>">
                <p id="zipcode_err" class="input_error"><?php echo $zipcode_err; ?></p>
            </div>
            <div class="form-group">
                <label>State</label>
                <input type="text" name="state" id="state" class="form-control <?php echo (!empty($state_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $state; ?>">
                <p id="state_err" class="input_error"><?php echo $state_err; ?></p>
            </div>
            <div class="form-group">
                <label>Phone Number</label>
                <input type="text" name="phonenumber" id="phonenumber" class="form-control <?php echo (!empty($phonenumber_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $phonenumber; ?>">
                <p id="phonenumber_err" class="input_error"><?php echo $phonenumber_err; ?></p>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" id="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $password; ?>">
                <p id="password_err" class="input_error"><?php echo $password_err; ?></p>
            </div>
            <div class="form-group">
                <label>Confirm Password</label>
                <input type="password" name="confirm_password" id="confirm_password" class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $confirm_password; ?>">
                <p id="confirm_password_err" class="input_error"><?php echo $confirm_password_err; ?></p>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                <input type="reset" class="btn btn-secondary ml-2" value="Reset">
            </div>
            <p>Already have an account? <a href="login.php">Login here</a>.</p><br>
        </form>
    </div>    

    <!--------- FOOTER --------->
	<?php
    include("Classes/Templates/footer.html");
    ?>
</html>
