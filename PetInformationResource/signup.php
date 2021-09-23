<?php
include "navbar.html";
?>

<body>
<form action="profile.php" method="post">
    <h5>User Name: </h5><input type="text" name="username">
    <h5>Email: </h5><input type="text" name="email">
    <h5>Street Address: </h5><input type="text" name="address">
    <h5>City: </h5><input type="text" name="city">
    <h5>Zip Code: </h5><input type="text" maxlength="5" name="zipcode">
    <h5>State: </h5><input type="text" maxlength="2" name="state">
    <h5>Password: </h5><input type="password" name="password">
    <h5>Re-enter Password: </h5><input type="password" name="repassword">
    <br>
    <input type="submit">
</form>

</body>