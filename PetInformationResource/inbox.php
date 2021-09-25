<?php
include "navbar.html";
include "user.php";
session_start();
header('profile.php');

if(isset($_SESSION['user']) && $_SESSION['user']) {
    $user = unserialize($_SESSION['user']);
    $userID = $user->getID();
    require_once('mysqli_connect.php');
    $query = "SElECT pet_id, message_id, message FROM messages WHERE user_id=$userID";

    $response = @mysqli_query($dbc, $query);

    if($response) {
        echo '<table align="left"
        cellspacing="5" cellpadding="8">
        
        <tr><td align="left"><b>Pet</b></td>
        <td align="left"><b>Message ID</b></td>
        <td align="left"><b>Message</b></td>
        </tr>';

        while($row = mysqli_fetch_array($response)){
            echo '<tr><td align="left">' . 
            $row['pet_id'] . '</td><td align="left">' .  
            $row['message_id'] . '</td><td align="left">' .  
            $row['message'] . '</td><td align="left">';
            echo '</tr>';
        }

        echo '</table>';
    } else {
        echo "couldnt issue database query";
        echo mysqli_error($dbc);
    }
    mysqli_close($dbc); 
    echo('<h3><a href="profile.php"><b>Back To Profile</b></a></h3>');
} else {
    echo "<h3>You need to log in</h3>";
}


?>