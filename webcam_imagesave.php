<?php

//session_start();

// $saving_name=implode("_",$_SESSION[$_GET['capture_name']]);

// $folderPath = '../../visitor_uploaded_images/';

// $image_parts = explode(";base64,", $_POST['image']);

// $image_type_aux = explode("image/", $image_parts[0]);

// $image_type = $image_type_aux[1];

// $image_base64 = base64_decode($image_parts[1]);

// $file = $folderPath.$saving_name.'.jpg';

// file_put_contents($file, $image_base64);

// echo json_encode(["Image uploaded successfully."]); 

// // unset($_SESSION['capture_name']); 
echo "from image save";
// ?>





<?php

session_start();

// Check if an image data URL is posted

if (isset($_POST['image'])) {
//echo 'from image save';
  //$saving_name=implode("_",$_SESSION[$_GET['capture_name']]);
$saving_name=$_SESSION[$_GET['capture_name']]['visitorid'];
  $folderPath = '../uploads/meghanaimage/';

  // Get the image data URL

  $dataURL = $_POST['image'];

  // Remove the header part of the data URL

  $dataURL = substr($dataURL, strpos($dataURL, ',') + 1);

  // Decode the base64 encoded data

  $data = base64_decode($dataURL);

  // Generate a file name for the image

  

  // Save the image data to a file in a folder called 'upload'

  $file = $folderPath.$saving_name.'.jpg';

  file_put_contents($file, $data);
  $_SESSION[$_GET['capture_name']]['image_name']=$saving_name.'.jpg';

  // Return the file name as a response 

}

?>









