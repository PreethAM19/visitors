<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $mobile = $_POST['mobile'];
    $numPeople = $_POST['numPeople'];
    $whomToMeet = $_POST['whomToMeet'];
    $address = $_POST['address'];
    $purpose = $_POST['purpose'];
    $vehicle = $_POST['vehicle'];
    $vehicleNo = $_POST['vehicleNo'];

    // Save the form data to your database here

    $response = ['status' => 'success', 'message' => 'Form submitted successfully!'];
    echo json_encode($response);
}
?>
