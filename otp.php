<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = $_POST['action'];
    $response = [];

    if ($action == 'generate_otp') {
        $otp = 123;
        $_SESSION['otp'] = $otp;
        // Send the OTP via SMS (you'll need an SMS gateway integration here)
        $response['status'] = 'success';
        $response['message'] = 'OTP generated and sent!';
    } elseif ($action == 'verify_otp') {
        $inputOtp = $_POST['otp'];
        if ($inputOtp == $_SESSION['otp']) {
            $response['status'] = 'success';
            $response['message'] = 'OTP verified!';
        } else {
            $response['status'] = 'error';
            $response['message'] = 'Invalid OTP!';
        }
    }

    echo json_encode($response);
}
?>
