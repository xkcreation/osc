<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "login";
$port = 3308;   // XAMPP default is 3306 - change if your MySQL uses 3306

$conn = mysqli_connect($servername, $username, $password, $database, $port);

if (!$conn) {
    die("Connection failed");
}
?>
