<?php
include "navbar.html";
?>
<body>
    <?php
    //echo file_get_contents("https://www.google.com/");
    ?>
<form action="animals.php" method="get">
    <h5>Search: </h5><input type="number" name="animal_id">
    <br>
    <input type="submit">
</form>

</body>