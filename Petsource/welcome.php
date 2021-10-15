<?php
//header
include("Classes/Templates/header.html");
?>
<nav>
	<ul id="MenuItems">
		<li><a href="index.html">Home</a></li>
		<li><a href="logout.php">Logout</a></li>
		<li><a href="register.php">Register</a></li>
		<li><a href="">ChipID Search</a></li>
		<li><a href="">About</a></li>
	</ul>
</nav>
<?php
//classes
include_once("Classes/Profile.php");
session_start();
                            
// Store data in session variables
$username = $_SESSION["username"];                            
$password = $_SESSION["password"];
$login = new Profile();
if ($login->login($username, $password)) {

} else {
    echo('<h1>Not logged in</h1>');
    header("Location: login.php");
}
//footer
include("Classes/Templates/footer.html");
?>