<?php
//header
include("Classes/Templates/loggedinheader.html");
//classes
include_once("Classes/Profile.php");
session_start();
                            
// Store data in session variables
$username = $_SESSION["username"];                            
$password = $_SESSION["password"];
$profile = unserialize($_SESSION["profile"]);

if ($profile->isUser() && isset($_GET["petid"])) {
    $pet = $profile->getPet($_GET["petid"]);
    if (is_null($pet)) {
        header("Location: login.php");
    } 
    // Define variables and initialize with empty values
    $name = $pet->getName();
    $animal = $pet->getAnimal();
    $color = $pet->getColor();
    $chipid = (is_null($pet->getChipID())) ? "" : $pet->getChipID();
    $filename = NULL;
    $name_err = $animal_err = $color_err = $chipid_err = $filename_err = "";
    // Processing form data when form is submitted
    if($_SERVER["REQUEST_METHOD"] == "POST"){
    
        // Check if name is empty
        if(empty(trim($_POST["name"]))){
            $name_err = "Please enter a name.";
        } else{
            $name = trim($_POST["name"]);
        }

        // Check if animal is empty
        if(empty(trim($_POST["animal"]))){
            $animal_err = "Please enter your animal.";
        } else{
            $animal = trim($_POST["animal"]);
        }

        // Check if color is empty
        if(empty(trim($_POST["color"]))){
            $color_err = "Please enter your pets color.";
        } else{
            $color = trim($_POST["color"]);
        }

        $chipid = trim($_POST["chipid"]);

        // Check if file is photo
        if (isset($_FILES['filename']) && !is_null($_FILES['filename']) && is_uploaded_file($_FILES['filename']['tmp_name'])) {
            $imgname = $_FILES['filename']['name'];
            switch($_FILES['filename']['type'])
            {
            case 'image/jpeg': $ext = 'jpg'; break;
            case 'image/gif': $ext = 'gif'; break;
            case 'image/png': $ext = 'png'; break;
            case 'image/tiff': $ext = 'tif'; break;
            default: $ext = ''; break;
            }
            if ($ext) {
                $filename = file_get_contents($_FILES['filename']['tmp_name']);
                $filename = addslashes($filename);
                //DBController::upimage($tmpname);
            /* $n = "image.$ext";
            move_uploaded_file($_FILES['filename']['tmp_name'], $n);
            echo "Uploaded image '$name' as '$n':<br>";
            echo "<img src='$n'>"; */
            } else {
                $filename_err = "'$imgname' is not an accepted image file";
            }
        } else {
                //$filename_err = "No image has been uploaded";
        } 

        // Validate credentials
        if(empty($name_err) && empty($animal_err) && empty($color_err) && empty($chipid_err) && empty($filename_err) && isset($_POST['submit'])){
            if (is_uploaded_file($_FILES['filename']['tmp_name'])) {
                if ($profile->updatePet($pet->getPetID(), $name, $animal, $color, $chipid, $filename)) {
                    header("Location: welcome.php");
                } else {
                    echo '<h1>Error updating pet</h1>';
                }
            } else {
                if ($profile->updatePet($pet->getPetID(), $name, $animal, $color, $chipid, addslashes($pet->getMedia()))) {
                    header("Location: welcome.php");
                } else {
                    echo '<h1>Error updating pet</h1>';
                }
            }
            
            
        }
    }

} else {
    echo('<h1>Not logged in</h1>');
    header("Location: login.php");
}
?>
<div class="small-container2">
            <div class="col-1"> 
                <h1 class="title">Update Pet</h1>
                <p>Please update your pet's information.</p><br>
            </div>    
       
        </div>

    <div class="small-container2">
        <?php 
        if(!empty($login_err)){
            echo '<div class="alert alert-danger">' . $login_err . '</div>';
        }        
        ?>

        <form action="updatepet.php?petid=<?php echo $_GET["petid"]; ?>" method="post" enctype='multipart/form-data'>
            <div class="form-group">
                <label>Pet Name</label>
                <input type="text" name="name" class="form-control <?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $name; ?>">
                <p class=""><?php echo $name_err; ?></p>
            </div>
            <div class="form-group">
                <label>Animal</label>
                <input type="text" name="animal" class="form-control <?php echo (!empty($animal_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $animal; ?>">
                <p class=""><?php echo $animal_err; ?></p>
            </div>
            <div class="form-group">
                <label>Color</label>
                <input type="text" name="color" class="form-control <?php echo (!empty($color_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $color; ?>">
                <p class=""><?php echo $color_err; ?></p>
            </div>
            <div class="form-group">
                <label>Chip ID (optional)</label>
                <input type="text" name="chipid" class="form-control <?php echo (!empty($chipid_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $chipid; ?>">
                <p class=""><?php echo $color_err; ?></p>
            </div>
            <div class="form-group">
                <label>New Picture</label>
                <input type="file" name="filename" class="form-control <?php echo (!empty($filename_err)) ? 'is-invalid' : ''; ?>">
                <p class=""><?php echo $filename_err; ?></p>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Update" name="submit">
            </div>
        </form>
    </div>
<?php
//footer
include("Classes/Templates/footer.html");
?>