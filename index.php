<?php

date_default_timezone_set("Asia/Calcutta");
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

 //$conn = new mysqli('localhost',"root","","visitors_database_iiith");

   // if(!$conn){

       //$err_at_submission = "Cannot connect to Database";

       //die(); 

      // }

?>
<html>

<head>

	<title>Visitor Management</title>

<meta name="viewport" content="width=device-width, initial-scale=1">



<link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:ital@1&display=swap" rel="stylesheet">



<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">



<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>



<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>

<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>

<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>



<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">





<link rel="stylesheet" href="new_home_1.css">


</head>



<body>

    



<nav class="vm_nav_styl" ><!--style="position:sticky;top:0;z-index:99999; background:whitesmoke;display:flex;flex-direction:row"-->



    <div class="vm_nav_logo_cont" ><!--style="text-align:center; border:2px solid red;"-->

      <a href="#"><img src="images/logo.png" class="logo"></a>

    </div>

    

    <div class="vm_nav_hed_cont" id="myNavbar"> <!--class="collapse navbar-collapse"--><!--style="width:100%; border:2px solid red;"-->

      <h1 class="vm_nav_hed" >Visitor Management</h1><!--style="font-size: 30px; font-family: 'Josefin Sans', sans-serif; color:rgb(7, 27, 85)"-->

    </div>

<!--Added by Preetham-1/14/24-->
    <div class="navbar-buttons">



        <!-- <a href='#' class="navbar-button" onclick="signIn()"><?php echo "this"; ?></button>  -->

        <?php  if($_SESSION["username"]!=''){

        

        echo"<a href='#' class='navbar-button'>WELCOME ".$_SESSION["username"]."</a>



        <a href='visitor_report.php'class='navbar-button'>View Summary</a>

        <a href='visitor_logout.php'class='navbar-button'>Logout</a>";}



        else{

        echo"<a href='visitor_login.php' class='navbar-button'>Sign In</a>



        <a href='visitor_report.php'class='navbar-button'>View Summary</a>";



        }



        ?>

        <!-- <a href='visitor_login.php' class="navbar-button" onclick="signIn()">Sign In</button>



        <a href='report_display.php'class="navbar-button" onclick="viewSummary()">View Summary</button> -->



    </div>


</nav>

<div class ="container-fluid">

    <div class="row">

      <div class="vm-vndows-cont-cont"> 

      <div class="vm-page-two-vndows-cont">
	   <!--added for mobile app--><br>
	  <br>
	  <br>
	  <br>

        <div class="vm-cat-cards-cont-cont">      

 <!--added for mobile app--><br>
	  <br>
	  <br>
	  <br>

        <a href="form.php?category=visitor" class="vm-cat-card-cont">

        <!--<div class="vm-cat-card-cont">-->



       

       <div class="w-100 h-100">

        <img src="images/visitors.png" class="vm-cat-img">

        <p>Visitors</p>

        </div>

        



       <!--</div>-->

       <!--/a>

       <a href="form.php?category=cab" class="vm-cat-card-cont"-->

       <!--<div class="vm-cat-card-cont">-->



       

       <!--div class="w-100 h-100" >

        <img src="images/cabs.png" class="vm-cat-img">

        <p>Cabs</p>

        </div-->

        

        

       <!--</div>-->

       </a>

       <!--a href="form.php?category=delivery" class="vm-cat-card-cont">

       <!--<div class="vm-cat-card-cont">-->



       

       <!--div class="w-100 h-100" >

        <img src="images/delivery.png" class="vm-cat-img">

        <p>Delivery</p>

         </div>

        



       <!--</div>-->

       <!--/a>



       <a href="form.php?category=other_services" class="vm-cat-card-cont"-->

       <!--<div class="vm-cat-card-cont">-->



       

       <!--div class="w-100 h-100" >

        <img src="images/others.png" class="vm-cat-img">

        <p>Other Resources</p>

         </div-->

         



       <!--</div>-->

       </a>

      </div>
	  <!--added for mobile app--><br>
	  <br>
	  <br>
	  <br>


      <?php

  $search_q = "";

 if(isset($_POST["search_req"])){

  $search_q = $_POST["search_content"];  

 }

 if(isset($_SESSION['search_content_on_exit_action'])){

  $search_q = $_SESSION['search_content_on_exit_action'];

  unset($_SESSION['search_content_on_exit_action']);

 }


if(isset($_POST["yet_to_visit"])){

 $_SESSION['yet_to_visit']=true;

}

if(isset($_POST["todesvisits"])){

  unset($_SESSION['yet_to_visit']);

 

}

 ?>

      <div class="vm-ryt-vndo">  

        <div class="vm-ryt-vndo-hdr">

          <form method="POST" action="">

      <button id="yetTovisit" type="submit" name="yet_to_visit"  class="btn-hover">

      Visitors Yet to Visit

</button>

</form>

<form method="POST" action="">

      <button id="todesvisits" type="submit" name="todesvisits"  class="btn-hover">

      Today's Visitors

</button>

</form>

</div><!-- should place in div for better styling if needed class="vm-ryt-vndo-hdr"-->

      <form method="post"  class="vm-ryt-vndo-hdr">

   <div class="vm-search-bar-cont">

      <input type="text" id="searchInputBar" name="search_content" class="vm-search-term" value="<?php echo $search_q?>" placeholder="Give any of the detail like name, phone etc">

     <a href="index.php" id="searchExitButton" class="vm-search-exit-button">

     <i class="fa fa-times" aria-hidden="true"></i>

    </a>

      <button id="searchButton" type="submit" name="search_req" class="searchButton">

        <i class="fa fa-search"></i>

     </button>

   </div>

</form> 



<!-- <form method="get"  class="vm-ryt-vndo-hdr">

   <div class="vm-search-bar-cont">

      <input type="text" id="searchInputBar" name="search_content" class="vm-search-term" value="<?php //echo $search_q?>" placeholder="Give any of the detail like name, phone etc">



      <a href="index.php" id="searchExitButton" class="exitButton">

     <i class="fa fa-times" aria-hidden="true"></i>

    </a>

      <button id="searchButton" type="submit" class="searchButton">

        <i class="fa fa-search"></i>

     </button>

     

   </div>

</form>  -->



<?php

require_once('configure.php');

// Set the end time for each card

$end_times = array("visitor"=>strtotime($_SESSION['visiting_duration']["visitor"]),"cab"=>strtotime($_SESSION['visiting_duration']["cab"]),"delivery"=>strtotime($_SESSION['visiting_duration']["delivery"]),"other_services"=>strtotime($_SESSION['visiting_duration']["other_services"])

);

//echo "********";
//echo "ent times";

 //echo '<br/>';

 //var_dump($end_times);

 //echo '<br/>';

 //echo "********";

?>





<div class="vm-vctrs-prfyl-list-cont-cont" >

 

  

<div  class="vm-vctrs-prfyl-list-cont <?php if(isset($_SESSION['yet_to_visit'])){echo "fixTableHead";}?>" >



<?php





if(!isset($_SESSION['yet_to_visit'])){



$count = 0;

$conn = new mysqli($servername,$username,$password,$database);
if(!$conn){
	$err_at_submission = mysql_error();
	die();
}



$sql= "SELECT * FROM visitors WHERE (category IN ('visitor','cab','delivery', 'other_services')) AND (exitdate IS NULL AND exittime IS NULL) AND (persons LIKE '%".$search_q."%' OR visitorname LIKE '%".$search_q."%' OR mobile LIKE '%".$search_q."%' OR visitdate LIKE '%".$search_q."%' OR totime LIKE '%".$search_q."%' OR category LIKE '%".$search_q."%' OR assignedname LIKE '%".$search_q."%' OR visitorcompany LIKE '%".$search_q."%' OR purpose LIKE '%".$search_q."%' OR vehicle_type LIKE '%".$search_q."%' OR vehicleno LIKE '%".$search_q."%') ORDER BY Id DESC";

//echo $sql;
// the above sql  is not being executed with the current db ******** comment after db created in ims ***********

$result = mysqli_query($conn,$sql);
//e/cho 

//var_dump($result);

if($result){


while($row = mysqli_fetch_assoc($result)){

    $visitor_number = $row['persons'];

    $name = $row['visitorname'];

    $phone_number =  $row["mobile" ];

    $intime = $row['totime'];
	

    $category = $row['category'];

    $poc = $row["assignedname"];

  $poc_place =  $row[ "visitorcompany"];

    $purpose =  $row["purpose"];

    $vehicle_details_view = "";

    $vehicle_type = $row["vehicle_type"];

    $vehicle_number = $row["vehicleno"];

    if($vehicle_type==Null && $vehicle_number==Null){

      $vehicle_details_view = "";

    }else{

      $vehicle_details_view =

'<p class=".vm-vctr-detal-vhkl-aspct" >Veh No. </p>

<p class="vm-vctr-detal-vhkl-val">'.$vehicle_number.'-'.$vehicle_type.'</p>';

    }

    $image='images/no_image_available.jpg';

    if($row['image']!=Null){ 

      $image = "../uploads/meghanaimage/".$row['image'];

     //$image='images/no_image_available.jpg';



    }



    $to_show_no_of_people="";

    $phone_number_details= "<p class='vm-vctr-detal-phno-aspct' >Ph No.: </p>

    <p class='vm-vctr-detal-phmo-val' >".$phone_number."</p>";

    if($category =="cab"){

      $phone_number_details = "";

    }





    $to_meet="<p class='vm-vctr-detal-poc-aspct' >to meet: </p>

    <p class='vm-vctr-detal-poc-val' >".$poc."</p>";

    if($category=="cab" || $category=="other_services" ){

      $to_meet = "";

    }
	$purpose_chunk = "<p class='vm-vctr-detal-purp'>Purpose: </p>
<p class='vm-vctr-detal-purp-val'>".$purpose."</p>";
if($category =="other_services"){
  $purpose_chunk = "";

}

    // $row["created_date_time"];

    

    

 // include('search.php');

$datetime_input = $row["visitdate"] . " " . $intime;
$date_string = DateTime::createFromFormat('Y-m-d H:i', $datetime_input);

if ($date_string === false) {
    // Debug output
    echo "Invalid datetime input: " . htmlspecialchars($datetime_input);
} else {
    // Optional: Convert to your expected display format (e.g., d-m-y H:i)
    $formatted_display = $date_string->format('d-m-y H:i'); // For display
    echo "Formatted for display: " . $formatted_display;

    // For internal use or DB storage
    $date_result = $date_string->format('Y-m-d H:i:s');
    $interval = (new DateTime())->diff($date_string);
}

//modified

//$date_string = (DateTime::createFromFormat('d-m-Y', $row["visitdate"]));

//$date_result = $date_string->format('d-m-Y H:i');

//$interval = ((((new DateTime())->diff($date_result))));


// echo $date_result;

// echo '<br/>';

// var_dump(DateTime::createFromFormat('d-m-y H:i', $row["entry_registered_date"]." ".$intime)[]);



$in_minutes_difference = ($interval->days * 24 * 60) + ($interval->h * 60) + $interval->i;



// echo $in_minutes_difference;

// echo '<br/>';



//include('search.php');

//echo $end_times[$row['category']];

//$time_remaining = $end_times[$row['category']] - time();





// "+".$row['allowed_duration']." minutes"



//$time_remaining = strtotime("+".$row['duration']." minutes") - time();
$time_remaining = strtotime($row['duration']) - time();

// strtotime($row['allowed_duration'])

// echo "time remaining";

// echo '<br/>';



// echo $row['allowed_duration'];

// echo '<br/>';

// echo $time_remaining;



echo

"<div class='vm-vctr-prfyl-cont'>

<!--img class='vm-vctr-cap-img' src='".$image."'/-->

<div  class= 'vm-vctr-prfyl-detal-cont'>





<div class='vm-vctr-detal-pat-von' >



<div class='vm-vctr-detal-tym'>

<p class='vm-vctr-detal-aspct' >In at </p>

<p class='vm-vctr-detal-date' >".date("h:i a", strtotime($intime))."</p>

</div>



<div class='vm-vctr-detal-cat'>

<p class='vm-vctr-detal-aspct'>Cat.: </p>

<p class='vm-vctr-detal-cat-val' >".ucwords($category)."</p>

</div>

</div>



<div class='vm-vctr-detal-detals-cont-cont' >

<div  class='vm-vctr-detal-name-cont'>



<p class='vm-vctr-detal-name-acpct'>Name: </p>

<p class='vm-vctr-detal-name-val'>".$name."</p>



</div>



<div class='vm-vctr-detal-poc-cont' >



<!--<p class='vm-vctr-detal-poc-aspct' >to meet: </p>

<p class='vm-vctr-detal-poc-val' >".$poc."</p>-->

".$to_meet."

</div>



<div class='vm-vctr-detal-purp-cont' >
".$purpose_chunk."


<!--<p class='vm-vctr-detal-purp'>Purpose: </p>

<p class='vm-vctr-detal-purp-val'>".$purpose."</p>-->



</div>

</div>

<a href='qr_code_after_submission.php?visitor_id=" .$row['visitorid']."'><img style='height:40px;width:40px;' src='../uploads/meghanaqr/".$row["qrcode"]."'/></a>





<div class='vm-vctr-detal-visid-cont-cont'>

<div class='vm-vctr-detal-visid-cont' >

<!-- <p class='vm-vctr-detal-vis-id-aspct' >no. of people </p>

<p class='vm-vctr-detal-vis-id-val' >".$visitor_number."</p>-->

".$to_show_no_of_people."



</div>

</div>





<div class='vm-vctr-detal-phno-cont' >

<!--<p class='vm-vctr-detal-phno-aspct' >Ph No.: </p>

<p class='vm-vctr-detal-phmo-val' >".$phone_number."</p>-->

".$phone_number_details."

</div>



<div class='vm-vctr-detal-vhkl-cont'>".$vehicle_details_view."  



</div>



<!--<a href='out_time_update.php?id=" .$row['persons']."&search_content=".$search_q."&' class='btn-hover color-9'>Exit</a>-->



<form method='post' action = 'out_time_update.php' class='vm-vctr-exit-btn-cont' >

<input type='hidden' value=".$row['visitorid']." name='id'/>

<input type='hidden' value='".$search_q."' name='search_content' />   

<button id='countdown" . $row['visitorid'] . "'  type='submit' class='vm-vctr-detal-exit-btn'>

Exit

</button>

<script>



let countdown" . $row['visitorid'] . " = document.getElementById('countdown" . $row['visitorid'] . "');





countdown" . $row['visitorid'] .".style.backgroundImage = 'linear-gradient(to right, #0ba360, #3cba92, #30dd8a, #2bb673)';





var time_remaining" . $row['visitorid'] . " = parseInt(" . $time_remaining .")

// console.log('this');

// console.log (time_remaining" . $row['visitorid'] . " * 1000)

// console.log('=');

// console.log(" . $time_remaining * 1000 . ")

// console.log ((time_remaining" . $row['visitorid'] . "/2) * 1000)

// console.log('=');

// console.log( ". ($time_remaining / 2 ) * 1000 .")



var countDownDate" . $row['visitorid'] . " = new Date('".$date_result."').getTime() + time_remaining" . $row['visitorid'] . " * 1000;





var halftime" . $row['visitorid'] . " =  (time_remaining" . $row['visitorid'] . "/2) * 1000 ;

        var x" . $row['visitorid'] . " = setInterval(function() {

            var now" . $row['visitorid'] . " = new Date().getTime();

            var distance" . $row['visitorid'] . " = countDownDate" . $row['visitorid'] . " - now" . $row['visitorid'] . ";

            

            var minutes" . $row['visitorid'] . " = Math.floor((distance" . $row['visitorid'] . " % (1000 * 60 * 60)) / (1000 * 60));

            var seconds" . $row['visitorid'] . " = Math.floor((distance" . $row['visitorid'] . " % (1000 * 60)) / 1000);

            document.getElementById('countdown" . $row['visitorid'] . "').innerHTML = minutes" . $row['visitorid'] . " + 'm ' + seconds" . $row['visitorid'] . " + 's ';



           // console.log(distance" . $row['visitorid'] ." / 60000 );



            if (distance" . $row['visitorid'] . " < halftime" . $row['visitorid'] . ") {

              countdown" . $row['visitorid'] .".style.backgroundImage = 'linear-gradient(to right, #e8581f, #ff9a44, #ef9d43, #e77b16)';

              countdown" . $row['visitorid'] .".style.color = 'green';

              // countdown" . $row['visitorid'] . ".innerHTML = 'Time Exceeded';

              

          }

          if (distance" . $row['visitorid'] . " < 0) {

            clearInterval(x" . $row['visitorid'] . ");



            

            countdown" . $row['visitorid'] .".style.backgroundImage = 'linear-gradient(to right, #eb3941, #f15e64, #e14e53, #e2373f)';

            countdown" . $row['visitorid'] .".style.color = 'maroon';

            countdown" . $row['visitorid'] . ".innerHTML = 'Time Exceeded';

            

        }

        }, 1000);</script>\n

    



</form> 

</div>

</div>

"  ; 



}

}

}else{

 echo '<!--<div class="fixTableHead">-->

 <table>

 <thead>

 <tr>

   <th scope="col"><p>Sl.No.</p></th>

   <th scope="col"><p>Name</p></th>

   <th scope="col"><p>Phone No.</p></th>

   <!--<th scope="col"><p>Button</p></th>-->

   <!--<th scope="col"><p>In Time</p></th>-->

   <!--<th scope="col"><p>Out Time</p></th>-->

 </tr>

</thead>

<tbody>';

// record type 

    $count = 1;

//$sql = "SELECT visitorname, mobile FROM visitors WHERE (recordtype LIKE 'Pre Booking' ) and (visitorname LIKE '%".$search_q."%' OR mobile LIKE '%".$search_q."%')";

$sql = "SELECT visitorname, mobile FROM visitors WHERE (recordtype LIKE 'Pre Booking' ) and (visitorname LIKE '%".$search_q."%' OR mobile LIKE '%".$search_q."%')and  visitdate LIKE CURRENT_DATE()";

$result = mysqli_query($conn,$sql);

if($result){

  // $row = mysqli_fetch_assoc($result);

  while($row = mysqli_fetch_assoc($result)){



    $name = $row['visitorname'];

    $phone_number =  $row["mobile" ];

echo

'<tr>

<th scope="row">'.$count.'</th>

<td><a href="details_preplanned_visitor.php?name='.$name.'"><p style="width:150px; word-wrap:break-word;">'.$name.'</p></a></td>

<td><p style="width:150px; word-wrap:break-word;">'.$phone_number.'</p></td>

<!--<td><p style="width:200px; word-wrap:break-word;"></p></td>-->

<!--<td><p style="width:200px; word-wrap:break-word;text-align:center;"></p></td>-->

<!--<td><div style="width:200px; word-wrap:break-word;text-align:center;"><button>Form</button></div></td>-->

</tr>';

         $count=$count+1;

        }

}

echo '</tbody>

        

</table>

<!--</div>-->'; 

}

// }

?>

</div>

</div>
      </div>

      </div>

      </div>

<?php 

?>

      </div>

 </div>

</div>

</div>

</div>

<script type = "text/javascript">

  let searchExitButton = document.getElementById('searchExitButton');

  let searchInputBar = document.getElementById('searchInputBar');

  let yetTovisit = document.getElementById('yetTovisit');

  let todesvisits = document.getElementById('todesvisits');



  <?php if(isset($_SESSION['yet_to_visit'])){?>



  yetTovisit.classList.add("color-9");

  todesvisits.classList.remove("color-9");

  

 <?php ;}else{?>yetTovisit.classList.remove("color-9");

 todesvisits.classList.add("color-9");

 <?php 

}?>

  searchExitButton.classList.add("hide")



  // searchInputBar.addEventListener('change',function(){

  //   console.log("change occured")

  //   console.log(searchInputBar.value)



  <?php if($search_q==""){?>

    searchExitButton.classList.add("hide")

  <?php }else{?>searchExitButton.classList.remove("hide")<?php }?>

// })



searchExitButton.addEventListener('click',function(){

  searchInputBar.value="";

})

// let count = 0;



// $(document).ready(function(){

//   setInterval(function(){

//     $("#to_refresh_for_timer_indication_on_regular_intervals").load(location.href+" #to_refresh_for_timer_indication_on_regular_intervals");

   





// count = count +1

// console.log(count);

//   },20000)

// })

</script>

</body>

</html>