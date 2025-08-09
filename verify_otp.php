<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $entered_otp = $_POST['otp'];
    $sent_otp = $_SESSION['otp']; // Retrieve the OTP from the session

    if ($entered_otp == $sent_otp) {
        echo "OTP Verified Successfully!";
        // Proceed with further actions, e.g., user registration or login
    } else {
        echo "Invalid OTP. Please try again.";
    }
	
	
}
?>
