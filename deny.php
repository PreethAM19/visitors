<?php
$author = 'Free';
include_once '../pw_xcon.php';
include_once 'utils.php';
date_default_timezone_set('Asia/Kolkata');
session_start();



$servername="localhost";
$username="imsdevuser";
$password="UjhGFTybCDSr";
$database="newimsiiithdev";


$conn = new mysqli($servername,$username,$password,$database);
if(!$conn){
	$err_at_submission = mysql_error();
	die();
}


if (isset($_GET['visitorid']) && isset($_GET['status'])) {
    $visitorId = $_GET['visitorid'];
    $status = $_GET['status'];

    // Update the status in the database
    $sql = "UPDATE visitors SET hoststatus = ? WHERE visitorid = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $status, $visitorId);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo "Visitor entry denied successfully.";
    } else {
        echo "Error denying visitor entry.";
    }
    $stmt->close();
}

$conn->close();
?>