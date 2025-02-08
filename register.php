<?php
$host = "localhost";
$user = "root";
$password = "";
$dbname = "women_safety";
$conn = mysqli_connect("localhost","root","","women_safety");

// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

// Ensure the 'users' table has 'password_hash' instead of 'password'
$checkColumnQuery = "SHOW COLUMNS FROM users LIKE 'password_hash'";
$columnResult = mysqli_query($conn, $checkColumnQuery);

if (mysqli_num_rows($columnResult) == 0) {
  // If 'password_hash' column doesn't exist, add it
  $alterTableQuery = "ALTER TABLE users ADD COLUMN password_hash VARCHAR(255) NOT NULL";
  mysqli_query($conn, $alterTableQuery);
}

// Check if form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = mysqli_real_escape_string($conn, $_POST['username']);
  $email = mysqli_real_escape_string($conn, $_POST['email']);
  $password_hash = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password

  // Insert user data
  $sql = "INSERT INTO users (username, email, password_hash) VALUES ('$username', '$email', '$password_hash')";

  if (mysqli_query($conn, $sql)) {
      header("Location: success.html"); // Redirect on success
      exit();
  } else {
      echo "Error: " . $sql . "<br>" . mysqli_error($conn);
  }
}

// Close connection
mysqli_close($conn);
?>
