document.addEventListener("DOMContentLoaded", function () {
    // SOS Button functionality
    document.getElementById("sosBtn").addEventListener("click", function () {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(sendSOS, showError, {
                enableHighAccuracy: true,
                timeout: 10000,
                maximumAge: 0
            });
        } else {
            alert("Geolocation is not supported by this browser.");
        }
    });
  
    function sendSOS(position) {
        const lat = position.coords.latitude;
        const lon = position.coords.longitude;
        alert(`🚨 SOS Sent! Location: ${lat}, ${lon}`);
    }
  
    function showError(error) {
        let errorMessage = "Unknown error occurred.";
        switch (error.code) {
            case error.PERMISSION_DENIED:
                errorMessage = "Location access denied. Please enable location permissions.";
                break;
            case error.POSITION_UNAVAILABLE:
                errorMessage = "Location information is unavailable.";
                break;
            case error.TIMEOUT:
                errorMessage = "Request timed out. Try again.";
                break;
        }
        alert(`Error getting location: ${errorMessage}`);
    }
  
    // Video Capture functionality
    const video = document.getElementById("video");
    let videoStream = null;
  
    document.getElementById("startVideo").addEventListener("click", async function () {
        try {
            videoStream = await navigator.mediaDevices.getUserMedia({ video: true });
            video.srcObject = videoStream;
            toggleButtons("startVideo", "stopVideo");
  
            // Show "Send Media" button when video starts
            let sendMediaBtn = document.getElementById("sendMedia");
            sendMediaBtn.classList.add("show");
            sendMediaBtn.style.display = "flex";
        } catch (err) {
            alert("Error accessing camera. Please check permissions.");
            console.error("Camera error:", err);
        }
    });
  
    document.getElementById("stopVideo").addEventListener("click", function () {
        if (videoStream) {
            videoStream.getTracks().forEach(track => track.stop());
            video.srcObject = null;
            videoStream = null;
            toggleButtons("stopVideo", "startVideo");
  
            // Hide "Send Media" button when video stops
            let sendMediaBtn = document.getElementById("sendMedia");
            sendMediaBtn.classList.remove("show");
            sendMediaBtn.style.display = "none";
        }
    });
  
    // Audio Recording functionality
    let mediaRecorder;
    let audioChunks = [];
    let audioStream = null;
  
    document.getElementById("startAudio").addEventListener("click", async function () {
        try {
            audioChunks = [];
            audioStream = await navigator.mediaDevices.getUserMedia({ audio: true });
            mediaRecorder = new MediaRecorder(audioStream);
            mediaRecorder.start();
            document.getElementById("audioStatus").innerText = "🎙️ Recording...";
  
            mediaRecorder.ondataavailable = event => {
                audioChunks.push(event.data);
            };
  
            toggleButtons("startAudio", "stopAudio");
        } catch (err) {
            alert("Error accessing microphone. Please check permissions.");
            console.error("Microphone error:", err);
        }
    });
  
    document.getElementById("stopAudio").addEventListener("click", function () {
        if (mediaRecorder) {
            mediaRecorder.stop();
            document.getElementById("audioStatus").innerText = "Recording Stopped";
  
            mediaRecorder.onstop = () => {
                const audioBlob = new Blob(audioChunks, { type: "audio/wav" });
                const audioUrl = URL.createObjectURL(audioBlob);
                const audioElement = document.createElement("audio");
                audioElement.src = audioUrl;
                audioElement.controls = true;
                document.body.appendChild(audioElement);
                audioChunks = [];
  
                // Stop audio stream
                if (audioStream) {
                    audioStream.getTracks().forEach(track => track.stop());
                    audioStream = null;
                }
            };
  
            toggleButtons("stopAudio", "startAudio");
        }
    });
  
    // Fetch and Display Emergency Contacts
    fetch("fetch_contacts.php")
        .then(response => response.json())
        .then(data => {
            let contactList = document.createElement("ul");
            data.forEach(contact => {
                let li = document.createElement("li");
                li.textContent = `${contact.contact_name} - ${contact.contact_phone}`;
                contactList.appendChild(li);
            });
            document.querySelector(".contact-section").appendChild(contactList);
        })
        .catch(error => console.error("Error fetching contacts:", error));
  
    // Utility function to toggle button visibility
    function toggleButtons(hideId, showId) {
        document.getElementById(hideId).style.display = "none";
        document.getElementById(showId).style.display = "inline-block";
    }
  });
  