<?php
$servername="localhost";
$username="imsdevuser";
$password="UjhGFTybCDSr";
$database="newimsiiithdev";


$qrimage = null;

$conn = new mysqli($servername,$username,$password,$database);
if(!$conn){
	$err_at_submission = mysql_error();
	die();
}


 //echo $_GET['visitor_id'];



   $sql = "SELECT  * FROM visitors WHERE visitorid = '".$_GET['visitor_id']."'";

   $result = mysqli_query($conn,$sql);

   if($result){

    $row = mysqli_fetch_assoc($result);

    // var_dump($row);

    $name = $row["visitorname"];
	
	$date = $row["visitdate"];
	
	$mobile = $row["mobile"];
	
	$tomeet = $row["assignedname"];
	
	$entrytime = $row["totime"];

    $qrimage = $row["qrcode"];

   }

   

?>







<!DOCTYPE html>

<html lang="en">

<head>

<link rel="shortcut icon" type="x-icon" href="../images/IIIT-H_logo.webp"/>

     <meta charset="UTF-8">

     <meta name="viewport" content="width=device-width, initial-scale=1.0">

     <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:ital@1&display=swap" rel="stylesheet">

     <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">

     <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>

     <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>

     <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>

     <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>

     <link rel="stylesheet" href="qrpage.css">

     <title>QR page</title>

</head>

<body>

    <div class=container>

        <!--div  class="sub-container"><img class="qr-image-at-print" src='../uploads/meghanaqr/<?php echo $qrimage?>'/><button class="btn btn-primary w-100 fs-1" onclick="print_redirect()">Print QR</button></div-->
		 <div class="container mt-5">
        <div class="row">
            <div class="col-md-4 text-center">
                <img src="../uploads/meghanaqr/<?php echo $qrimage; ?>" alt="QR Code" class="img-fluid" style="max-width: 100%;">
            </div>
            <div class="col-md-8">
                <h4>Visitor Details</h4>
                <p><strong>Name:</strong> <?php echo $name; ?></p>
                <p><strong>Date:</strong> <?php echo $date; ?></p>
                <p><strong>Mobile:</strong> <?php echo $mobile; ?></p>
                <p><strong>To Meet:</strong> <?php echo $tomeet; ?></p>
                <p><strong>Entry Time:</strong> <?php echo $entrytime; ?></p>
            </div>
        </div>
    </div>
		<button class="btn btn-primary w-100 fs-1" onclick="print_redirect()">Print & Exit</button>

    </div>

<script>
console.log('checking')
  //let qr_image = document.getElementById("qr_image")
function print_redirect(){
  //window.print();
  window.print();
  var win = window.open("", '_self');
  win.focus();
  
  setTimeout(function() {
    win.close();
    window.location.href = "https://ims-dev.iiit.ac.in/visitors/index.php";
  }, 1000);
  
}


// to control back operation///

window.history.pushState(null, '', document.URL);

//console.log(document.URL);



window.addEventListener('popstate', function(event) {
	event.preventDefault()

  window.location.href = "https://ims-dev.iiit.ac.in/visitors/index.php";

});


//window.onpopstate=function(){
	//window.location.href = "https://ims-dev.iiit.ac.in/visitors/index.php";
	
//}
</script>

</body>

</html>