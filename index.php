<?php 
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

// Include the database connection file
include("db.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Women Safety App</title>
    <link rel="stylesheet" href="style.css">
    <script src="script.js" defer></script>
</head>
<body>
    <div class="container">
        <h4>Women Safety App</h4>
        
        <!-- SOS Button -->
        <section class="sos-section">
            <button id="sosBtn" class="btn emergency-btn">🚨 SOS Emergency</button>
            <p id="status" class="status">Press the button to send an SOS alert.</p>
        </section>

        <!-- Video Stream for Capturing Image -->
        <section class="video-section">
            <h5>Chill, I got you!</h5>
            <video id="video" autoplay></video>
            <div class="btn-group">
                <button id="startVideo" class="btn">Start Video</button>
                <button id="stopVideo" class="btn" style="display:none;">Stop Video</button>
            </div>
        </section>
        
        <!-- Audio Recording -->
        <section class="audio-section">
            <h5>Relax</h5>
            <p id="audioStatus" class="status">Audio Recording: Not Started</p>
            <div class="btn-group">
                <button id="startAudio" class="btn">🎙️ Start Audio</button>
                <button id="stopAudio" class="btn" style="display:none;">Stop Audio</button>
            </div>
        </section>

        <section class="media-section">
    <h6>Send Media</h6>
    
    <!-- File Selection -->
    <input type="file" id="mediaInput" accept="video/*,audio/*">
    
    <!-- Media Preview -->
    <div id="previewContainer" style="
    display: none;
    position: relative;
    width: 100%;
    max-width: 500px;
    margin: auto;
    background: rgba(0, 0, 0, 0.8);
    padding: 10px;
    border-radius: 8px;
    text-align: center;
">
    <video id="videoPreview" controls style="width: 100%;"></video>
    <audio id="audioPreview" controls style="width: 100%;"></audio>

    <!-- Close Button -->
    <button id="closePreview" style="
        position: absolute;
        top: 10px;
        right: 10px;
        background: red;
        color: white;
        border: none;
        padding: 5px 10px;
        cursor: pointer;
        font-size: 16px;
        border-radius: 50%;
        z-index: 9999;
    ">
        ✖
    </button>
</div>

    

    <!-- Select Contacts -->
    <label for="contacts">Send To:</label>
    <select id="contacts">
        <option value="contact1">01xxxxxxxxx</option>
        <option value="contact2">01xxxxxxxxx</option>
        <option value="contact3">01xxxxxxxxx</option>
    </select>

    <!-- Send Button -->
    <button id="sendMedia" class="btn send-media-btn" style="display:none;">Send Video & Audio</button>
</section>

<script>
    const mediaInput = document.getElementById("mediaInput");
    const videoPreview = document.getElementById("videoPreview");
    const audioPreview = document.getElementById("audioPreview");
    const sendMedia = document.getElementById("sendMedia");

    mediaInput.addEventListener("change", function () {
        const file = mediaInput.files[0];
        if (file) {
            const url = URL.createObjectURL(file);
            
            if (file.type.startsWith("video")) {
                videoPreview.src = url;
                videoPreview.style.display = "block";
                audioPreview.style.display = "none";
            } else if (file.type.startsWith("audio")) {
                audioPreview.src = url;
                audioPreview.style.display = "block";
                videoPreview.style.display = "none";
            }

            sendMedia.style.display = "block";
        }
    });

    sendMedia.addEventListener("click", function () {
        const selectedContact = document.getElementById("contacts").value;
        const file = mediaInput.files[0];

        if (file && selectedContact) {
            alert(`Sending ${file.name} to ${selectedContact}...`);
            // Add logic to send the file via backend/API
        }
    });
</script>

  
        <!-- Emergency Contact Form -->
        <section class="contact-section">
            <h5>Emergency Contacts</h5>
            <form id="contactForm" action="save_contact.php" method="POST">
                <label for="name">Contact Name:</label>
                <input type="text" id="name" name="name" placeholder="Enter name" required>
            
                <label for="phone">Phone Number:</label>
                <input type="tel" id="phone" name="phone" placeholder="Enter phone number" required>
            
                <button type="submit" class="btn">Save Contact</button>
            </form>
            
         
        </section>

        <!-- Incident Reporting -->
        <section class="incident-section">
            <h5>Report an Incident</h5>
            <form action="report.php" method="POST">
                <label for="incident">Describe the incident:</label>
                <textarea id="incident" name="incident" placeholder="Write here..." required></textarea>
                <button type="submit">Submit Report</button>
            </form>
        </section>
    </div>

    <!-- <script>
        // Fetch and display emergency contacts from the database
        document.addEventListener("DOMContentLoaded", function () {
            fetch("fetch_contacts.php")
                .then(response => response.json())
                .then(data => {
                    let contactList = document.getElementById("contactList");
                    data.forEach(contact => {
                        let contactCard = document.createElement("div");
                        contactCard.classList.add("contact-card");

                        contactCard.innerHTML = `
                            <p>Name: ${contact.contact_name}</p>
                            <p>Phone: ${contact.contact_phone}</p>
                            <button onclick="makeCall('${contact.contact_phone}')">Call</button>
                        `;
                        contactList.appendChild(contactCard);
                    });
                })
                .catch(error => {
                    console.error("Error fetching contacts:", error);
                });
        });

        // Function to make a call (using tel: link)
        function makeCall(phoneNumber) {
            window.location.href = `tel:${phoneNumber}`;
        }
    </script> -->
</body>
</html>
