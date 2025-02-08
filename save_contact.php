<?php
include 'db.php';

$message = "";
$status = ""; // "success" or "error"

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $contact_name = $_POST['name'];
    $contact_phone = $_POST['phone'];
    $user_id = 1; // Change this dynamically based on logged-in user

    $sql = "INSERT INTO emergency_contacts (user_id, contact_name, contact_phone) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iss", $user_id, $contact_name, $contact_phone);
    
    if ($stmt->execute()) {
        $message = "✅ Contact saved successfully!";
        $status = "success";
    } else {
        $message = "❌ Error: " . $conn->error;
        $status = "error";
    }
    header("refresh:2; url=index.php"); // Redirect after 2 seconds
            

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Emergency Contact</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .message-box {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            width: 300px;
            display: none;
        }
        .success {
            border-left: 5px solid #28a745;
            color: #28a745;
        }
        .error {
            border-left: 5px solid #dc3545;
            color: #dc3545;
        }
        .close-btn {
            background: #dc3545;
            color: white;
            border: none;
            padding: 8px 16px;
            cursor: pointer;
            font-size: 16px;
            border-radius: 5px;
            margin-top: 10px;
        }
        .close-btn:hover {
            background: #b52b35;
        }
    </style>
</head>
<body>

<div class="message-box <?php echo $status; ?>" id="messageBox">
    <p><?php echo $message; ?></p>
    <button class="close-btn" onclick="closeMessage()">Close</button>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        var box = document.getElementById("messageBox");
        if (box.innerText.trim() !== "") {
            box.style.display = "block";
        }
    });

    function closeMessage() {
        document.getElementById("messageBox").style.display = "none";
    }
</script>

</body>
</html>
