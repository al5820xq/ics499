<?php
include "navbar.html";
include "user.php";
session_start();

if(isset($_SESSION['user']) && $_SESSION['user']) {
    $user = unserialize($_SESSION['user']);
} else {
    $currentUser = $_POST['username'];
    $currentPassword = $_POST['password'];

    $user = new User($currentUser, $currentPassword);
    $user->isValid();
}
?>

<script>document.write("Today is " + Date());</script>

<?php
$user->toString();

$serializedUser = serialize($user);

$_SESSION['user'] = $serializedUser;
header('petregister.php');
$userID = $user->getID();
require_once('mysqli_connect.php');
$query = "SElECT pet_id, name, animal, color, chip_id FROM pets WHERE user_id=$userID";

    $response = @mysqli_query($dbc, $query);

    if($response) {
        echo '<table align="left"
        cellspacing="5" cellpadding="8">
        
        <tr><td align="left"><b>Id</b></td>
        <td align="left"><b>name</b></td>
        <td align="left"><b>animal</b></td>
        <td align="left"><b>color</b></td>
        <td align="left"><b>Chip ID</b></td></tr>';

        while($row = mysqli_fetch_array($response)){
            echo '<tr><td align="left">' . 
            $row['pet_id'] . '</td><td align="left">' .  
            $row['name'] . '</td><td align="left">' .  
            $row['animal'] . '</td><td align="left">' .  
            $row['color'] . '</td><td align="left">' . 
            $row['chip_id'] . '</td><td align="left">';

            echo '</tr>';
        }

        echo '</table>';
    } else {
        echo "coul issue database query";
        echo mysqli_error($dbc);
    }
    mysqli_close($dbc); 

?>
<br>
<hr>
<h3><a href="petregister.php"><b>Register Pet</b></a></h3>

