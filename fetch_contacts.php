<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

include("db_connection.php");

$user_id = $_SESSION['user_id'];  // Get the user ID from the session

// Fetch emergency contacts for the logged-in user
$query = "SELECT * FROM emergency_contacts WHERE user_id = ?";
$stmt = $pdo->prepare($query);
$stmt->execute([$user_id]);
$contacts = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($contacts);
?>
