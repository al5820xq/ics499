<?php
// Initialize the session
session_start();
 
// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: welcome.php");
    exit;
}
 
// Include config file
require_once "Classes/DBController.php";
 
// Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = $login_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Check if username is empty
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter username.";
    } else{
        $username = trim($_POST["username"]);
    }
    
    // Check if password is empty
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate credentials
    if(empty($username_err) && empty($password_err)){
    
        if(DBController::isUser($username, $password)){
            // Bind variables to the prepared statement as parameters
                // Password is correct, so start a new session
                session_start();
                            
                // Store data in session variables
                $_SESSION["loggedin"] = true;
                //$_SESSION["id"] = $id;
                $_SESSION["username"] = $username;                            
                $_SESSION["password"] = $password;
                // Redirect user to welcome page
                header("location: welcome.php");
        } else{
                $login_err = "Invalid username or password.";
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

        <div class="small-container2">
            <div class="col-1"> 
                <h1 class="title">Login</h1>
                <p>Please fill in your credentials to login.</p><br>
            </div>    
       
        </div>

    <div class="small-container2">
        <?php 
        if(!empty($login_err)){
            echo '<div class="alert alert-danger">' . $login_err . '</div>';
        }        
        ?>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
                <p class=""><?php echo $username_err; ?></p>
            </div>    
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>">
                <p class=""><?php echo $password_err; ?></p>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Login">
            </div>
            <p>Don't have an account? <a href="register.php">Sign up now</a>.</p><br>
        </form>
    </div>

    <!--------- FOOTER --------->
	<?php
    include("Classes/Templates/footer.html");
    ?>
</html>