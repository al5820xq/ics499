<?php
include "header.html";
    include "pet.php";
?>
<?php
    require_once('mysqli_connect.php');
    $animal = $_POST["animal"];
    $name = $_POST["name"];
    $color = $_POST["color"];
    $insertQuery = "INSERT INTO testtable (petname, animaltype, color, identifier)
     VALUES (?, ?, ?, NULL)";
    $stmt = mysqli_prepare($dbc, $insertQuery);
    mysqli_stmt_bind_param($stmt, "sss", $name, $animal, $color);
    mysqli_stmt_execute($stmt);
    $affected_rows = mysqli_stmt_affected_rows($stmt);
    if($affected_rows == 1){
        echo 'Student Entered';
        mysqli_stmt_close($stmt);
        //mysqli_close($dbc);
    } else {
        echo 'Error Occurred';
        echo mysqli_error();
        mysqli_stmt_close($stmt);
        //mysqli_close($dbc);
    }

    
    if(1) {


    } else {
            echo "coul issue database query";
            
    }

    $pet1 = new Pet($animal, $name, $color);
    $pet2 = new Pet("Cat", "Garfield", "orange");
    echo($pet1->toString());
    echo($pet2->toString());
?>

<?php
    

     

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
            $row['petname'] . '</td><td align="left">' .  
            $row['animaltype'] . '</td><td align="left">' .  
            $row['color'] . '</td><td align="left">';

            echo '</tr>';
        }

        echo '</table>';
    } else {
        echo "coul issue database query";
        echo mysqli_error($dbc);
    }
    mysqli_close($dbc); 

    $user = "resource";
    $password = "petresource";

?>
