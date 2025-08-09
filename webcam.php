
<?php //echo "from webcam package visitor management new";
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
// echo '<br/>';
// echo $data_in_ls_with_key;
// echo '<br/>';
$_SESSION[$data_in_ls_with_key] = $_SESSION["data_at_level_one_submit"];
unset($_SESSION["data_at_level_one_submit"]);}
// var_dump($_SESSION["data_at_level_one_submit"]);
 //var_dump($_SESSION[$data_in_ls_with_key]);
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
<link rel="stylesheet" href="../../css/webcam.css"><!--../css/webcam.css-->
    <title>Document</title>
</head>
<body>
<div class="container-fluid">
	
<!-- <div id="spinner" class="d-flex flex-column justify-content-center" style="height:100%;align-items:center;" ><div class="spinner-border text-primary " role="status">
  <span class="sr-only">Loading...</span>
</div></div> -->

  <div class="row w-100 justify-content-center">

  



	<div class="container_of_objects" style="border:2px solid red;">


  



	<!-- <form class="d-flex flex-row justify-content-cener" method="post" action="../../registration_form/?category=<?php //echo $_SESSION[$data_in_ls_with_key]['category']?>">
		<input  type="hidden" name="on_back_code_load" value=<?php //echo $data_in_ls_with_key;?>      >
		
		 <button  type="submit" name="back_trigger" value="Submit" >Back</button>
		</form> -->


	<div  class="capture_snap_container " ><!--camera container-->


	<div class="m-2 d-flex flex-column justify-content-center align-items-center" align="center"><!-- camera input-->
		<!-- <label>Capture live photo</label> -->


		
		<video id="video" width="320" height="240"></video>
		
		
		<input type="button" class="btn btn-info btn-round btn-file w-100 h-10 m-none" value="Take Snapshot" id="capture" onclick="capture()">	
	</div>
	<div  class="m-2 d-flex flex-column justify-content-center align-items-center" align="center">
		<!-- <label>The captured Image</label> -->
		<canvas id="canvas" width="320" height="240"></canvas>
		</div>
		
		</div><!--camera container-->
		<form method="post" action="submission.php" class="d-flex flex-row justify-content-center mt-5" >
		<input id="uniqueIDCap" type="hidden" name="code_to_create_saved_name" value=<?php echo $data_in_ls_with_key;?>     >
		<!-- <button type="submit" class="button" name='submission_trigger' onclick="submission()" >Submit</button>onclick="saveSnap()" -->
    <button class="button" name='submission_trigger' onclick="submission()" >Submit</button>
		</form>
  	</div>
  </div>
		</div>	

        <script>
let uniqId = (document.getElementById('uniqueIDCap')).value

let urltorender = 'webcam_imagesave.php?capture_name='.concat(uniqId)



// Check if the browser supports getUserMedia
if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
  // Define a function to request access to the camera
  function requestCamera() {
    // Define the video constraints
    var videoConstraints = {
      video: true
      
    };
    // Check if the device has a rear camera
    if (hasRearCamera) {
      // If yes, set the facingMode property to "environment"
      videoConstraints.video.facingMode = "environment";
    }
    // Request access to the camera using the video constraints
    navigator.mediaDevices.getUserMedia(videoConstraints)
      .then(function(stream) {
        // Display the video stream in a <video> element
        var video = document.getElementById('video');
        video.srcObject = stream;
        video.play();
      })
      .catch(function(err) {
        // Handle errors
        console.error(err);
      });
  }

  // Define a function to check how many cameras are available on the device
  function checkCameras() {
    // Get a list of the available video input devices
    navigator.mediaDevices.enumerateDevices()
      .then(function(devices) {
        // Filter out the devices that are not cameras
        let cameras = devices.filter(function(device) {
          return device.kind === "videoinput";
        });
        // Check how many cameras are present
        if (cameras.length > 1) {
          // If there are more than one camera, set a flag to indicate that the device has a rear camera
          hasRearCamera = true;
        } else {
          // If there is only one camera, set a flag to indicate that the device does not have a rear camera
          hasRearCamera = false;
        }
        // Call the requestCamera function to access the camera
        requestCamera();
      })
      .catch(function(err) {
        // Handle errors
        console.error(err);
      });
  }

  // Define a function to capture a snapshot of the video
  function capture() {
    // Get the canvas and video elements
    var canvas = document.getElementById('canvas');
    var video = document.getElementById('video');
    // Get the canvas context
    var context = canvas.getContext('2d');
    // Draw the video frame on the canvas
    context.drawImage(video, 0, 0, canvas.width, canvas.height);
    // Convert the canvas image to a data URL
    var dataURL = canvas.toDataURL('image/jpg');
    // Send the data URL to a PHP script using AJAX
    $.ajax({
      type: 'POST',
      url: urltorender,
      data: { image: dataURL },
      success: function(response) {
        // Handle success
        console.log(response);
      },
      error: function(err) {
        // Handle errors
        console.error(err);
      }
    });
  }


  function submission(){
    $.ajax({
      type: 'POST',
      url: 'submission.php',
      data: { submission_trigger: true },
      success: function(response) {
        // Handle success
        console.log(response);
      },
      error: function(err) {
        // Handle errors
        console.error(err);
      }
    });    
  }

  

  // Define a flag to indicate whether the device has a rear camera or not
  var hasRearCamera = false;

  // Call the checkCameras function when the page loads or when a devicechange event occurs
  window.addEventListener("load", checkCameras);
  navigator.mediaDevices.addEventListener("devicechange", checkCameras);
  checkCameras();
}



// to control back operation//
// window.addEventListener('popstate', function(event) {
//   console.log('Browser back button clicked!');
//   event.preventDefault();
//   $.ajax({
//       type: 'POST',
//       url: "../../registration_form/?category=".concat(<?php //echo $_SESSION[$data_in_ls_with_key]['category']?>);
//       data: { on_back_code_load: $data_in_ls_with_key },
//       success: function(response) {
//         // Handle success
//         console.log(response);
//       },
//       error: function(err) {
//         // Handle errors
//         console.error(err);
//       }
//     });
// });


// window.onpopstate = function () {
//     // Your custom code to execute on browser back button click
//     console.log("Back button clicked");
//     $.ajax({
//       type: 'POST',
//       url: "../../registration_form/?category=".concat(<?php //echo $_SESSION[$data_in_ls_with_key]['category']?>);
//       data: { on_back_code_load: $data_in_ls_with_key },
//       // success: function(response) {
//       //   // Handle success
//       //   console.log(response);
//       // },
//       // error: function(err) {
//       //   // Handle errors
//       //   console.error(err);
//       // }
//     });
// };

history.pushState({}, '');

</script>
</body>
</html>


<!--  for mobile devices many changes are required
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Camera Input</title>
</head>
<body>
    <video id="video" width="640" height="480" autoplay></video>
    <button id="snap">Snap Photo</button>
    <canvas id="canvas" width="640" height="480"></canvas>
    <script>
        const video = document.getElementById('video');
        const canvas = document.getElementById('canvas');
        const snap = document.getElementById('snap');
        const constraints = {
            audio: false,
            video: {
                facingMode: { exact: "environment" }
            }
        };
        async function init() {
            try {
                const stream = await navigator.mediaDevices.getUserMedia(constraints);
                handleSuccess(stream);
            } catch (e) {
                console.error(e);
            }
        }
        function handleSuccess(stream) {
            window.stream = stream;
            video.srcObject = stream;
        }
        snap.addEventListener('click', function() {
            canvas.getContext('2d').drawImage(video, 0, 0, canvas.width, canvas.height);
            const dataURL = canvas.toDataURL();
            const link = document.createElement('a');
            link.download = 'photo.png';
            link.href = dataURL;
            link.click();
        });
        init();
    </script>
</body>
</html>


 -->