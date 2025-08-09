<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $mobile = $_POST['mobile'];
	$action = $_POST['action'];
    $response = [];

    // Define your API parameters
	if ($action == 'generate_otp') {
    $otp = rand(10000, 99999); 
	

    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => "https://2factor.in/API/V1/e56d511c-556e-11ef-8b60-0200cd936042/SMS/$mobile/$otp/test",
        CURLOPT_RETURNTRANSFER => true
       // CURLOPT_ENCODING => "",
        //CURLOPT_MAXREDIRS => 10,
      //  CURLOPT_TIMEOUT => 30,
       // CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
       // CURLOPT_CUSTOMREQUEST => "GET",
    ));

    $responseotp = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    
        //session_start();
        $_SESSION['otp'] = $otp;      // Save the OTP in the session for later verification
        $_SESSION['mobile'] = $mobile;
		$response['status'] = 'success';
        $response['message'] = 'OTP generated and sent!';		// Save the mobile number in the session
       // echo $response;
        //header("Location: verify.php"); // Redirect to the OTP verification page
    
	
//	$_SESSION['otp'] = $otp;
        // Send the OTP via SMS (you'll need an SMS gateway integration here)
        //$response['status'] = 'success';
       // $response['message'] = 'OTP generated and sent!';
		
}elseif ($action == 'verify_otp') {
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
