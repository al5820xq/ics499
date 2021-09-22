<?php
    include "header.html";
    include "pet.php";
?>
<body>
<form action="animals.php" method="post">
    <h5>Animal: </h5><input type="text" name="animal">
    <h5>Name: </h5><input type="text" name="name">
    <h5>Color: </h5><input type="text" name="color"> <br>
    <input type="submit">
</form>

</body>