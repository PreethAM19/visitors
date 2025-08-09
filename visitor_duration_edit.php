<?php 

//echo "from visiting_duration";
$servername="localhost";
$username="imsdevuser";
$password="UjhGFTybCDSr";
$database="newimsiiithdev";
$conn = new mysqli($servername,$username,$password,$database);
if(!$conn){
	$err_at_submission = mysql_error();
	die();
}

   //$sql = "SELECT * FROM visitors  ORDER BY S_no DESC LIMIT 1";
   $sql = "SELECT lookcode,lookname,num2 FROM mast_lookup WHERE lookcode IN ('Individual_Visitor','Other_Visitors','Delivery_Visitor','Cab_Visitor')";



// Execute the query

$result = mysqli_query($conn, $sql);
//$result = mysqli_query($conn, $sql);
//echo "*******";
//echo "<br/>";
//var_dump($result);
//echo "<br/>";
//echo "*******";

//echo '<br/>';
//echo "********//////////*********";
//echo "1.";
//echo '<br/>';
//var_dump($_POST);
//echo '<br/>';
//echo "********//////////*********";
//echo '<br/>';

// Check if there are any rows returned by the query

if (mysqli_num_rows($result) > 0) {

// Loop through each row and display the data

while ($row = mysqli_fetch_assoc($result)) {
	
	echo "<br/>";
		
		//var_dump($row);
echo "<br/>";

   

//$individual_visitor_visiting_duration = $row["individual_visitor_duration"] ;

//$cab_visitor_visiting_duration =  $row["cab_visitor_duration"];

//$delivery_visitor_visiting_duration =  $row["delivery_visitor_duration"];

//$other_sources_visitor_visiting_duration =  $row["other_visitor_duration"];
if($row['lookcode'] =='Individual_Visitor'){
$individual_visitor_visiting_duration = explode(".",$row["num2"])[0] ;}
if($row['lookcode'] =='Cab_Visitor'){
$cab_visitor_visiting_duration =   explode(".",$row["num2"])[0] ;}
if($row['lookcode'] =='Delivery_Visitor'){
$delivery_visitor_visiting_duration = explode(".",$row["num2"])[0] ;}
if($row['lookcode'] =='Other_Visitors'){
$other_sources_visitor_visiting_duration =  explode(".",$row["num2"])[0] ;}

}

} else {

//echo "No rows found";

$individual_visitor_visiting_duration =  30;

$cab_visitor_visiting_duration = 30 ;

$delivery_visitor_visiting_duration =  30;

$other_sources_visitor_visiting_duration =  30;

}
//






if(isset($_POST["save_button"])){
//if($_SERVER['REQUEST_METHOD'] == 'POST'){

  //echo "post admitted";

 //echo '<br/>';
//echo "********//////////*********";
//echo "2.on save button pressed" ;
//echo '<br/>';
//var_dump($_POST);
//echo '<br/>';
//echo "********//////////*********";
//echo '<br/>';





  //if(isset($_POST["ind_dur"])){
	  

   // $individual_visitor_visiting_duration =  $_POST["ind_dur"];

 // };



  //if(isset($_POST["cab_dur"])){

   // $cab_visitor_visiting_duration = $_POST["cab_dur"];



 // };

  //if(isset($_POST["del_dur"])){

    //$delivery_visitor_visiting_duration =  $_POST["del_dur"];



  //};

  //if(isset($_POST["oth_dur"])){

    //$other_sources_visitor_visiting_duration =  $_POST["oth_dur"];



 // }
 
 
 if(isset($_POST["ind_dur"])){
    if($individual_visitor_visiting_duration !=  $_POST["ind_dur"]){
     // echo "at individual visitor insertion";
	  
	  $sql = "UPDATE mast_lookup SET num2 = ".$_POST["ind_dur"]." WHERE lookcode LIKE 'Individual_Visitor' ";
	  
	   if(!$result = mysqli_query($conn,$sql)){

        die("query error problem".mysqli_error($conn));

    }
      $individual_visitor_visiting_duration =  $_POST["ind_dur"];
    }
  };

  if(isset($_POST["cab_dur"])){
    if($cab_visitor_visiting_duration != $_POST["cab_dur"]){

      //echo "at cab visitor insertion";
     // echo $_POST["cab_dur"];
	  
	  $sql = "UPDATE mast_lookup SET num2  = ".$_POST["cab_dur"]." WHERE lookcode LIKE 'Cab_Visitor' ";
	  
	   if(!$result = mysqli_query($conn,$sql)){

        die("query error problem".mysqli_error($conn));

    }

$cab_visitor_visiting_duration = $_POST["cab_dur"];
      
//       $stmt = $conn->prepare("INSERT INTO victor_durashan(category, duration) VALUES (?,?)");
// $stmt->bind_param("si", "cab", $_POST["cab_dur"]);

// $stmt->execute();
    }
  };
  
  
  if(isset($_POST["del_dur"])){
    if($delivery_visitor_visiting_duration !=  $_POST["del_dur"]){

      //echo "at delivery visitor insertion";
	  
	  
	  $sql = "UPDATE mast_lookup SET num2 = ".$_POST["del_dur"]."  WHERE lookcode LIKE 'Delivery_Visitor' ";
	  
	   if(!$result = mysqli_query($conn,$sql)){

	   die("query error problem".mysqli_error($conn));}

$delivery_visitor_visiting_duration =  $_POST["del_dur"];
     
    }

  };
  if(isset($_POST["oth_dur"])){
    if($other_sources_visitor_visiting_duration !=  $_POST["oth_dur"]){

      //echo "at other visitor insertion";
	  
	  
	  
	   $sql = "UPDATE mast_lookup SET num2 = ".$_POST["oth_dur"]." WHERE lookcode LIKE 'Other_Visitors'";
	  
	   if(!$result = mysqli_query($conn,$sql)){

        die("query error problem".mysqli_error($conn));


	   }
	   $other_sources_visitor_visiting_duration =  $_POST["oth_dur"];
    }

  }



  



  //$stmt = $conn->prepare("INSERT INTO visitor_duration (individual_visitor_duration, cab_visitor_duration, delivery_visitor_duration, other_visitor_duration ) VALUES (?, ?, ?, ?)");

//$stmt->bind_param("iiii", $individual_visitor_visiting_duration,$cab_visitor_visiting_duration, $delivery_visitor_visiting_duration,$other_sources_visitor_visiting_duration);



// Set parameters and execute statement







// $individual_visitor_visiting_duration =  $_POST["ind_dur"];

// $cab_visitor_visiting_duration = $_POST["cab_dur"] ;

// $delivery_visitor_visiting_duration =  $_POST["del_dur"];

// $other_sources_visitor_visiting_duration =  $_POST["oth_dur"];



//$stmt->execute();



//echo "New record created successfully";




unset($_POST);


 //echo '<br/>';
//echo "********//////////*********";
//echo "3.at end of save" ;
//echo '<br/>';
//var_dump($_POST);
//echo '<br/>';
//echo "********//////////*********";
//echo '<br/>';


}

/*$_SESSION['visiting_duration'] = [

"visitor"=> "+".$individual_visitor_visiting_duration." minutes",

"cab"=> "+".$cab_visitor_visiting_duration." minutes",

"delivery"=> "+".$delivery_visitor_visiting_duration." minutes",

"other_services"=>"+".$other_sources_visitor_visiting_duration." minutes"

];*/


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

  <title>Visitors Duration</title>

	<link rel="stylesheet" href='visitor_duration_edit.css'>

</head>

<body>





<h1>Visitors Duration</h1>





  <form class="table_container"  method="post" action="">

    <table>

      <tr>

        <th>Visitor ID</th>

        <th>Duration (in minutes)</th>

      </tr>

      <tr>

        

        <td>Individual Visitor</td>

        <td><p style="/*border:2px solid red;*/ width:100%; margin:0px " onclick="editDuration(this)"><?php echo $individual_visitor_visiting_duration?></p><input name="ind_dur" type="number" style="display:none; width:100% ;height:28px;font-size:14px; margin:0; padding:0;" value=<?php echo $individual_visitor_visiting_duration?>></td>

      </tr>

      <tr>

        

        <td>Cab Visitor</td>

        <td><p style="/*border:2px solid red;*/ width:100%; margin:0px " onclick="editDuration(this)"><?php echo $cab_visitor_visiting_duration?></p><input name="cab_dur" type="number" style="display:none; width:100% ;height:28px;font-size:14px; margin:0; padding:0;" value=<?php echo $cab_visitor_visiting_duration?>></td>

      </tr>

      <tr>

        

        <td>Delivery Visitor</td>

        <td ><p style="/*border:2px solid red;*/ width:100%; margin:0px " onclick="editDuration(this)"><?php echo $delivery_visitor_visiting_duration?></p><input name="del_dur" type="number" style="display:none; width:100% ;height:28px;font-size:14px; margin:0; padding:0;" value=<?php  echo $delivery_visitor_visiting_duration ?>></td>

      </tr>



      <tr>

        

        <td>Other Visitor</td>

        <td><p style="/*border:2px solid red;*/ width:100%; margin:0px " onclick="editDuration(this)"><?php echo $other_sources_visitor_visiting_duration?></p><input type="number" name="oth_dur" style="display:none; width:100% ;height:28px;font-size:14px; margin:0; padding:0;" value=<?php echo $other_sources_visitor_visiting_duration ?>></td>

      </tr>



      <tr>

    <!--<td colspan="3" style="text-align:center;"><button id="saveButton" value="true" class="save-button" name="save_button">Save</button></td>--><!-- name="save_button" onclick="saveTable()" -->
	
	<td colspan="3" style="text-align:center;"><input type="submit" name="save_button" class="save-button" value="Save"/></td>

  </tr>

    </table>

    </form>
<script>
//let saveButton = document.getElementById("saveButton")

/*function saveTable(){
//saveButton.name ="save_button"

saveButton.textContent = "Clicked"
$.ajax({

      type: 'POST',

      url: 'visitor_duration_setup.php',

      data: { save_button : true },

      success: function(response) {

        // Handle success

        console.log(response);

      },

      error: function(err) {

        // Handle errors

        console.error(err);

      }

    });


}*/


function editDuration(span) {

  var input = span.nextElementSibling;

  if (input.style.display === "none") {

    span.style.display = "none";

    input.style.display = "inline-block";

    input.value = span.innerHTML;

    input.focus();

    input.addEventListener("blur", function() {

      span.innerHTML = input.value;

      span.style.display = "inline-block";

      input.style.display = "none";

    });

  } else {

    span.innerHTML = input.value;

    span.style.display = "inline-block";

    input.style.display = "none";

  }

}

</script>





  

</body>

</html>



<!-- <!DOCTYPE html>

<html>

<head>

	<title>Visitors Duration</title>

	<link rel="stylesheet" href='../css/visitor_duration_config.css'>

		

</head>

<body>



<h1>Visitors Duration</h1>



<div class="table_container" >

  <form method="post" action="">

    <table>

      <tr>

        <th>Visitor ID</th>

        <th>Duration (in minutes)</th>

      </tr>

      <tr>

        

        <td>individual_visitor</td>

        <td><p style="/*border:2px solid red;*/ width:100%; margin:0px " onclick="editDuration(this)"><?php //echo $individual_visitor_visiting_duration?></p><input name="ind_dur" type="number" style="display:none; width:100% ;height:28px;font-size:14px; margin:0; padding:0;" value=<?php //echo $individual_visitor_visiting_duration?>></td>

      </tr>

      <tr>

        

        <td>Cab Visitor</td>

        <td><p style="/*border:2px solid red;*/ width:100%; margin:0px " onclick="editDuration(this)"><?php //echo $cab_visitor_visiting_duration?></p><input name="cab_dur" type="number" style="display:none; width:100% ;height:28px;font-size:14px; margin:0; padding:0;" value=<?php //echo $cab_visitor_visiting_duration?>></td>

      </tr>

      <tr>

        

        <td>Delivery Visitor</td>

        <td ><p style="/*border:2px solid red;*/ width:100%; margin:0px " onclick="editDuration(this)"><?php //echo $delivery_visitor_visiting_duration?></p><input name="del_dur" type="number" style="display:none; width:100% ;height:28px;font-size:14px; margin:0; padding:0;" value=<?php // echo $delivery_visitor_visiting_duration ?>></td>

      </tr>



      <tr>

        

        <td>Other Visitor</td>

        <td><p style="/*border:2px solid red;*/ width:100%; margin:0px " onclick="editDuration(this)"><?php //echo $other_sources_visitor_visiting_duration?></p><input type="number" name="oth_dur" style="display:none; width:100% ;height:28px;font-size:14px; margin:0; padding:0;" value=<?php //echo $other_sources_visitor_visiting_duration ?>></td>

      </tr>



      <tr>

    <td colspan="3" style="text-align:center;"><button onclick="saveTable()" class="save-button" name="save_button">Save</button></td>

  </tr>

    </table>

    </form>

</div>





<script>

function editDuration(span) {

  var input = span.nextElementSibling;

  if (input.style.display === "none") {

    span.style.display = "none";

    input.style.display = "inline-block";

    input.value = span.innerHTML;

    input.focus();

    input.addEventListener("blur", function() {

      span.innerHTML = input.value;

      span.style.display = "inline-block";

      input.style.display = "none";

    });

  } else {

    span.innerHTML = input.value;

    span.style.display = "inline-block";

    input.style.display = "none";

  }

}

</script>



</body>

</html> -->

