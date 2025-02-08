
<?php
header('Content-Type: application/json'); // Set JSON header
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $phone = $_POST['phone'];

    $stmt = $conn->prepare("INSERT INTO emergency_contacts (name, phone) VALUES (?, ?)");
    $stmt->bind_param("ss", $name, $phone);

    if ($stmt->execute()) {
        echo "Contact saved!";
    } else {
        echo "Error saving contact!";
    }
}
?>
