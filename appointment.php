<?php
// Include the Twilio SDK (only if you're using Composer)
require_once '/path/to/vendor/autoload.php'; // Adjust the path if using Composer

use Twilio\Rest\Client;

// Ensure the request is a POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Get form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $service = $_POST['service'];

    // Email notification
    $to = "korvah663@gmail.com";  // Replace with your salon's email
    $subject = "New Appointment Booked";
    $message = "A new appointment has been booked:\n\n";
    $message .= "Name: $name\n";
    $message .= "Email: $email\n";
    $message .= "Date: $date\n";
    $message .= "Time: $time\n";
    $message .= "Service: $service";

    $headers = "From: korvah663@gmail.com";  // Set a valid email address
    if (mail($to, $subject, $message, $headers)) {
        echo "Appointment booked successfully!";
    } else {
        echo "Error in booking the appointment.";
    }

    // WhatsApp notification using Twilio
    $sid = 'your_twilio_sid';  // Your Twilio SID
    $token = 'your_twilio_auth_token';  // Your Twilio Auth Token
    $from = 'whatsapp:+14155238886';  // Replace with your Twilio WhatsApp number
    $to = 'whatsapp:+905428879931';  // Your phone number in international format

    // Create the Twilio client
    $client = new Client($sid, $token);

    // Send the WhatsApp message
    $message = "New Appointment Booked:\n\n";
    $message .= "Name: $name\n";
    $message .= "Email: $email\n";
    $message .= "Date: $date\n";
    $message .= "Time: $time\n";
    $message .= "Service: $service";

    try {
        $client->messages->create(
            $to, // To phone number (WhatsApp)
            [
                'from' => $from,  // From Twilio WhatsApp number
                'body' => $message
            ]
        );
        echo "WhatsApp notification sent successfully!";
    } catch (Exception $e) {
        echo "Error sending WhatsApp message: " . $e->getMessage();
    }
}
?>
