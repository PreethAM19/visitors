<?php


 $db_host="localhost";

 $db_user="imsdevuser";

 $db_password="UjhGFTybCDSr";

 $db_name="newimsiiithdev";

$conn = new mysqli($db_host, $db_user, $db_password, $db_name);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>