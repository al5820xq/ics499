<?php
include "navbar.html";
include "CSSStyles/style.php";
?>

<body>
<form action="signedup.php" method="post" class="messageForm">
    <h5 class="inputLabel">User Name: </h5><input type="text" name="username" class="inputBox">
    <h5 class="inputLabel">First Name: </h5><input type="text" name="fname" class="inputBox">
    <h5 class="inputLabel">Last Name: </h5><input type="text" name="lname" class="inputBox">
    <h5 class="inputLabel">Email: </h5><input type="text" name="email" class="inputBox">
    <h5 class="inputLabel">Street Address: </h5><input type="text" name="address" class="inputBox">
    <h5 class="inputLabel">City: </h5><input type="text" name="city" class="inputBox">
    <h5 class="inputLabel">Zip Code: </h5><input type="text" maxlength="5" name="zipcode" class="inputBox">
    <h5 class="inputLabel">State: </h5><input type="text" maxlength="2" name="state" class="inputBox">
    <h5 class="inputLabel">Phone Number: </h5><input type="text" maxlength="15" name="phone" class="inputBox">
    <h5 class="inputLabel">Password: </h5><input type="password" name="password" class="inputBox">
    <h5 class="inputLabel">Re-enter Password: </h5><input type="password" name="repassword" class="inputBox">
    <br>
    <input type="submit" class="submitButton">
</form>

</body>