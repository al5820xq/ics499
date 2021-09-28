<?php
include "navbar.html";
include "CSSStyles/style.php";
?>

<body>
<form action="profile.php" method="post" class="messageForm">
    <h5 class="inputLabel">User Name: </h5><input type="text" class="inputBox" name="username" >
    <h5 class="inputLabel">Password: </h5><input type="password" class="inputBox" name="password"> <br>
    <input type="submit" class="submitButton">
</form>

</body>