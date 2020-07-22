<?php
$servername = "127.0.0.1:3306";
$username = "root";
$password = "";
$dbname = "Logbook";

$conn = new mysqli($servername, $username, $password, $dbname);

if($conn->connect_error) {
	die("<li><img src='images/red.png'/ alt='Connection failed: ". $conn->connect_error . "'/></li>");
}
else {
	echo "<li><img src='images/green.png'/></li>";
}
?>