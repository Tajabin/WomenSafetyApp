<?php
$host = "";
$user = "";
$password = "";
$dbname = "women_safety";
$conn = mysqli_connect("","","","");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
