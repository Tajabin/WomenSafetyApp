<?php
$host = "localhost";
$user = "root";
$password = "";
$dbname = "women_safety";
$conn = mysqli_connect("localhost","root","","women_safety");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
