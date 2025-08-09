<?php 
$author = 'Free';
include_once '../pw_xcon.php';
include_once 'utils.php'; 
require_once('../visitors/qrphp/qrlib.php');
date_default_timezone_set("Asia/Kolkata");
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

$data_in_ls_with_key = null;

if(isset($_SESSION["data_at_level_one_submit"])){
	$data_in_ls_with_key= $_SESSION["data_at_level_one_submit"]['data_key_input'];
	$_SESSION[$data_in_ls_with_key] = $_SESSION["data_at_level_one_submit"];
	unset($_SESSION["data_at_level_one_submit"]);
}

if(isset($_GET['uid'])){
	$data_in_ls_with_key = $_GET['uid'];	
}

$path='../uploads/meghanaqr/';
$categoryabb="" ;

if($_SESSION[$data_in_ls_with_key]["category"]=="visitor"){
  $categoryabb="iv";
}
if($_SESSION[$data_in_ls_with_key]["category"]=="cab"){
  $categoryabb="cv";
}
if($_SESSION[$data_in_ls_with_key]["category"]=="delivery"){
  $categoryabb="dv";
}
if($_SESSION[$data_in_ls_with_key]["category"]=="other_services"){
  $categoryabb="ov";
}

$pattern = date("dmy")."".$categoryabb."____________";
$sql = "SELECT MAX(CAST((MID(visitorid, 9, 4))AS INTEGER)) AS lastid from visitors WHERE visitorid LIKE '".$pattern."'";

$result = mysqli_query($conn,$sql);

if($result){
	$row = mysqli_fetch_assoc($result);
	$series_to_create_qr="";
	if($row["lastid"]==Null){
		$series_to_create_qr = date("dmy")."".$categoryabb."0001".date("His").rand(10, 99);
	}else{
		$number_to_create_new_id_for_the_day = sprintf('%04s',strval($row["lastid"]+1));
		$series_to_create_qr  = date("dmy").$categoryabb.$number_to_create_new_id_for_the_day.date("His").rand(10, 99);
	}
}

$_SESSION[$data_in_ls_with_key]["visitorid"]= $series_to_create_qr;
$qr_file_name = "qr".$series_to_create_qr.'.png';
$file_store_as=$path.$qr_file_name;
QRcode :: png('https://ims-dev.iiit.ac.in/visitors/qr_code_after_submission.php?visitor_id='.$series_to_create_qr, $file_store_as,'H',4, 4);
$_SESSION[$data_in_ls_with_key]["qrfilename"] = $qr_file_name;
$_SESSION[$data_in_ls_with_key]["image_name"] = "";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" ></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.24/webcam.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
    <link rel="stylesheet" href="webcam.css"><!--../css/webcam.css-->
    <title>Document</title>
</head>
<body>
	<form method="post" action="submission.php" class="d-flex flex-row justify-content-center mt-5" id="autoSubmitForm">
		<input id="uniqueIDCap" type="hidden" name="code_to_create_saved_name" value=<?php echo $data_in_ls_with_key;?>>
		<button type="submit" class="button" name='submission_trigger' id="autoSubmitButton">Submit</button>
	</form>
	
	
    <script>
        window.addEventListener('load', function() {
            document.getElementById('autoSubmitButton').click();
        });

        window.addEventListener('popstate', function(event) {
            <?php $_SESSION['back_trigger_webcam_page'] = $data_in_ls_with_key ?>
        });
    </script>
</body>
</html>
