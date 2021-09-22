<?php
    include "header.html";
    include "pet.php";

    /* require_once('mysqli_connect.php');

    $query = "SElECT identifier, petname, animaltype, color FROM testtable";

    $response = @mysqli_query($dbc, $query);

    if($response) {
        echo '<table align="left"
        cellspacing="5" cellpadding="8">
        
        <tr><td align="left"><b>Id</b></td>
        <td align="left"><b>name</b></td>
        <td align="left"><b>animal</b></td>
        <td align="left"><b>color</b></td></tr>';

        while($row = mysqli_fetch_array($response)){
            echo '<tr><td align="left">' . 
            $row['identifier'] . '</td><td align="left">' .  
            $row['name'] . '</td><td align="left">' .  
            $row['animal'] . '</td><td align="left">' .  
            $row['color'] . '</td><td align="left">';

            echo '</tr>';
        }

        echo '</table>';
    } else {
        echo "coul issue database query";
        echo mysqli_error($dbc);
    }
    mysqli_close($dbc); */

    $user = "resource";
    $password = "petresource";

?>

<?php
    $animal = $_POST["animal"];
    $name = $_POST["name"];
    $color = $_POST["color"];
    $pet1 = new Pet($animal, $name, $color);
    $pet2 = new Pet("Cat", "Garfield", "orange");
    echo($pet1->toString());
    echo($pet2->toString());
?>