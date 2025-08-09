<?php

date_default_timezone_set("Asia/Calcutta");

$uid = uniqid();

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



       $sql = "SELECT * FROM visitors WHERE recordtype='Pre Booking' AND visitorname LIKE '".$_GET['name']."'and visitdate LIKE CURRENT_DATE()";

       $result = mysqli_query($conn,$sql);

       if($result){

        $row = mysqli_fetch_assoc($result);
		
		
        $_SESSION[$uid] = $row;
		
		echo "from table";
        //var_dump($row);

        // while($row = mysqli_fetch_assoc($result)){



         //};
		 }

		$email=$_SESSION[$uid]["email"];

         $name = $_SESSION[$uid]["visitorname"];	

         $phone_number = $_SESSION[$uid]["mobile"];

        // $no_of_people = $_SESSION[$uid]["persons"]	;

       //  $campus_area_department = $_SESSION[$uid]["visitorcompany"]	;
		 
		 if($_SESSION[$uid]["assignedname"]!=''){

         $wtm = $_SESSION[$uid]["assignedname"];	}
		 
		 else{
			 
		 $wtm = $_SESSION[$uid]["student_to_meet"];	 }

         $purpose = $_SESSION[$uid]["purpose"];

         $vehicle_type = $_SESSION[$uid]['vehicle_type'];	

         $vehicle_number = $_SESSION[$uid]['vehicleno'];

         $category =  "visitor";

       // $cab_service_name = $_SESSION[$uid]["name"];

        // $other_service_name = $_SESSION[$uid]["name"];



         //unset($_SESSION[$uid]);



         var_dump($_SESSION[$uid]);

       //  $_SESSION[$uid]["cab_service_name"] = $cab_service_name;

        // $_SESSION[$uid]["other_service_name"] =  $other_service_name;

            $_SESSION[$uid]["name"] = $name;

			$_SESSION[$uid]["phone_number"] = $phone_number;

          //  $_SESSION[$uid]["no_of_people"]= $no_of_people;

           // $_SESSION[$uid]["campus_area_department"]= $campus_area_department;

            $_SESSION[$uid]["whomToMeet"]= $wtm ;

            $_SESSION[$uid]["purpose"]= $purpose;

            $_SESSION[$uid]["vehicle_type"]= $vehicle_type;

            $_SESSION[$uid]["vehicle_number"] = $vehicle_number ;

            $_SESSION[$uid]['category']=$category;



            var_dump($_SESSION[$uid]); 

         echo "from get details";
		 
		  header('location:webcam.php?uid='.$uid); 
		 
 $sql = "UPDATE visitors SET recordtype = 'Booking Cleared' WHERE visitorname='".$_SESSION[$uid]["visitorname"]."' AND email='".$_SESSION[$uid]["email"]."' AND visitdate LIKE CURRENT_DATE()";
echo $sql;
mysqli_query($conn,$sql);
 
       //header('location:webcam.php?uid='.$uid); 

?>