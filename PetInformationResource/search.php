<?php
include "navbar.html";
include "CSSStyles/style.php";
?>
<body>
    <?php
    //echo file_get_contents("https://www.google.com/");
    ?>
<form action="animals.php" method="get" class="messageForm">
    <h5 class="inputLabel">Search: </h5><input type="number" name="animal_id" class="inputBox">
    <br>
    <input type="submit" class="submitButton">
</form>

</body>