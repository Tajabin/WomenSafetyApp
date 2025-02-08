<?php
// Get the raw POST data
$data = json_decode(file_get_contents('php://input'), true);

// Check if data exists and contains the required fields
if (isset($data['lat']) && isset($data['lon']) && isset($data['phone'])) {
    $latitude = $data['lat'];
    $longitude = $data['lon'];
    $phone = $data['phone'];

    // Create a message with the latitude and longitude
    $message = "🚨 SOS Alert! \nLocation: https://www.google.com/maps?q={$latitude},{$longitude}";

    // WhatsApp API URL
    $whatsappUrl = "https://wa.me/{$phone}?text=" . urlencode($message);

    // Respond with a success status and the WhatsApp link
    echo json_encode([
        'status' => 'success',
        'whatsappLink' => $whatsappUrl
    ]);
} else {
    // Respond with an error if required data is missing
    echo json_encode([
        'status' => 'error',
        'message' => 'Missing required parameters (lat, lon, phone).'
    ]);
}
?>
