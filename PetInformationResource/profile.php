<?php
include "navbar.html";
include "user.php";
include "CSSStyles/style.php";
require_once('mysqli_connect.php');

session_start();

//if(isset($_SESSION['user']) && $_SESSION['user']) {
if(isset($_POST['username']) && $_POST['password']) {

    $currentUser = $_POST['username'];
    $currentPassword = $_POST['password'];

    $user = new User($currentUser, $currentPassword);
    $signedIn = $user->initialize();
} else {
    $user = unserialize($_SESSION['user']);
    $signedIn = $user->verify();
}
?>

<script>document.write("Today is " + Date());</script>

<?php
if ($signedIn) {
$user->toString();
//require('mysqli_connect.php');
$serializedUser = serialize($user);

$_SESSION['user'] = $serializedUser;
// header('inbox.php');
// header('petregister.php');
$userID = $user->getID();

//Pet table builder. Looks for pets that have user id.
$query = "SElECT pet_id, name, animal, color, chip_id FROM pets WHERE user_id=$userID";
    $response = @mysqli_query($dbc, $query);
    if($response && !is_null($response)) {
        echo '<div><table align="left"
        cellspacing="5" cellpadding="8">
        <tr><td align="left"><b>Id</b></td>
        <td align="left"><b>name</b></td>
        <td align="left"><b>animal</b></td>
        <td align="left"><b>color</b></td>
        <td align="left"><b>Chip ID</b></td>
        <td align="left"><b>QR Code</b></td></tr>';

        while($row = mysqli_fetch_array($response)){
            $petID = $row['pet_id'];
            echo '<tr><td align="left">' . 
            $petID . '</td><td align="left">' .  
            $row['name'] . '</td><td align="left">' .  
            $row['animal'] . '</td><td align="left">' .  
            $row['color'] . '</td><td align="left">' . 
            $row['chip_id'] . '</td><td align="left">' . 
            '<img src="https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=http://localhost/ics499/PetInformationResource/animals.php?animal_id='.$petID.'%2F&choe=UTF-8"></td>';
            echo '</tr>';
        }
        echo '</table></div>';
    } else {
        echo "couldnt issue database query";
        echo mysqli_error($dbc);
    }

    echo '
    <br>
    <hr>
    <h3><a href="petregister.php"><b>Register Pet</b></a></h3>
    <h3><a href="inbox.php"><b>See Messages</b></a></h3>
    <h3><a href="logout.php"><b>Log Out</b></a></h3>
    ';
} else {
    echo '<form action="profile.php" method="post" class="messageForm">
    <h5 class="inputLabel">Invalid Username or Password</h5>
    <h5 class="inputLabel">User Name: </h5><input type="text" class="inputBox" name="username" >
    <h5 class="inputLabel">Password: </h5><input type="password" class="inputBox" name="password"> <br>
    <input type="submit" class="submitButton">
    </form>';
}

    mysqli_close($dbc); 

?>


