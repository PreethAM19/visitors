<?php
$author = 'Free';
include_once '../pw_xcon.php';
include_once 'utils.php';
date_default_timezone_set('Asia/Kolkata');
session_start();

//require_once('../../phpqrcode/qrlib.php');




//$path = '../../qr_image_files/';

echo $_POST["code_to_create_saved_name"];
$id = null;
if(isset($_POST["code_to_create_saved_name"])){
    $id = $_POST["code_to_create_saved_name"];
}
if(isset($_GET['uid'])){
    $id=$_GET['uid'];

}




var_dump($_SESSION[$id]);


if(isset($_POST['submission_trigger'])){
     //echo "posting";
    $sub_time = date('H:i');
    $sub_date = date('d-m-y');

    
//store in db function then reset the input values 
$servername="localhost";
$username="imsdevuser";
$password="UjhGFTybCDSr";
$database="newimsiiithdev";



$conn = new mysqli($servername,$username,$password,$database);
if(!$conn){
	$err_at_submission = mysql_error();
	die();
}


     if($_SESSION[$id]["category"]=="visitor"){
		 
		 //Added by PR 1/14/24
		 		$pocname="";





		if($_SESSION[$id]["point_of_contact"]!="*Other"){

			$pocname=$_SESSION[$id]["point_of_contact"];

		}else{

			$pocname = $_SESSION[$id]["other_name"];

		}

    $ds['visitorname']   			=   	  	$_SESSION[$id]["name"];
	//added
	$ds['roomno']                   =           $_SESSION[$id]["other_room"];
   	$ds['mobile']   					=    	   	$_SESSION[$id]["phone_number"];
   	$ds['persons']   					=    		$_SESSION[$id]['no_of_people'];
   	$ds['visitorid']   					=     		$_SESSION[$id]["visitorid"];
   	$ds['assignedname']   		=   	  	$pocname;//$_SESSION[$id]['point_of_contact'];
	$ds['student_campus_address']   					= $_SESSION[$id]['other_address'];
   	$ds['purpose']   					=    	  	$_SESSION[$id]['purpose'];
   	$ds['vehicle_type']   			=    	  	$_SESSION[$id]['vehicle_type'];
   	$ds['vehicleno']   				=    	  	$_SESSION[$id]['vehicle_number'];
	$ds['visitorcompany']		=			$_SESSION[$id]["campus_area_department"];
	$ds['visitdate']					=			$sub_date;
	$ds['totime']						=			$sub_time;
	$ds['category']					=			$_SESSION[$id]["category"];
	$ds['qrcode']						=         $_SESSION[$id]['qrfilename'] ;
	$ds['image']						=		$_SESSION[$id]['image_name'];
	$ds['duration']			=$_SESSION['visiting_duration'][$_SESSION[$id]["category"]];
   	$ds['docstatus']   				=           "Active"; 
   	ds2insert($ds,"visitors");
	echo "<br><hr>";
	echo "<pre>";
	print_r($ds);
   	 echo " Thank you Successfully submitted your details..";
            
     }


     if($_SESSION[$id]["category"]=="cab"){


            $name="";


            if($_SESSION[$id]["cab_service_name"]!="other"){
                $name=$_SESSION[$id]["cab_service_name"];
            }else{
                $name = $_SESSION[$id]["other_service_name"];
            }
			
			//Added
			
				 		$pocname="";





		if($_SESSION[$id]["point_of_contact"]!="*Other"){

			$pocname=$_SESSION[$id]["point_of_contact"];

		}else{

			$pocname = $_SESSION[$id]["other_name"];

		}
        
       $ds['visitorname']   	=   	  	$name;
	   //added
	   $ds['roomno']                   =           $_SESSION[$id]["other_room"];
   	 $ds['visitorid']   		=         	$_SESSION[$id]["visitorid"];
   	 $ds['purpose']   		=    	  	$_SESSION[$id]['purpose'];
   	 $ds['vehicle_type']  =    	  	$_SESSION[$id]['vehicle_type'];
   	 $ds['vehicleno']   		=    	  	$_SESSION[$id]['vehicle_number'];
   	 $ds['visitdate']			=			$sub_date;
	$ds['totime']				=			$sub_time;
	$ds['category']			=			$_SESSION[$id]["category"];
	$ds['assignedname']   		=   	  	$pocname;
	$ds['student_campus_address']   					= $_SESSION[$id]['other_address'];
	$ds['visitorcompany']		=			$_SESSION[$id]["campus_area_department"];
	 $ds['duration']		=$_SESSION['visiting_duration'][$_SESSION[$id]["category"]];
	 $ds['qrcode']				=         $_SESSION[$id]['qrfilename'] ;
	 $ds['image']   			    =    	  	$_SESSION[$id]['image_name'];
   	 $ds['docstatus']   		    =           "Active";  
	  print_r($ds);
   	 ds2insert($ds,"visitors");
   	 echo " Thank you Successfully submitted your details.we will check your details soon and back to you..";
                            

     }



            if($_SESSION[$id]["category"]=="delivery"){
				
				//Added
								 		$pocname="";





		if($_SESSION[$id]["point_of_contact"]!="*Other"){

			$pocname=$_SESSION[$id]["point_of_contact"];

		}else{

			$pocname = $_SESSION[$id]["other_name"];

		}


     $ds['visitorname']   				=   	  $_SESSION[$id]["name"];
	 //added on 01/30 by preetham
	 $ds['roomno']                   =           $_SESSION[$id]["other_room"];
	 $ds['service_delivery']            =          $_SESSION[$id]["del_service"];
   	 $ds['visitorid']   						=         $_SESSION[$id]["visitorid"];
	  $ds['mobile']   						=    	   	$_SESSION[$id]["phone_number"];
	  $ds['assignedname']   		=   	  	$pocname;
	$ds['student_campus_address']   					= $_SESSION[$id]['other_address'];
//   	 $ds['assignedname']   			=   	  $_SESSION[$id]['point_of_contact'];
   	 $ds['purpose']   					=    	  'delivery';//$_SESSION[$id]['purpose'];
   	 $ds['vehicle_type']   				=    	  $_SESSION[$id]['vehicle_type'];
   	 $ds['vehicleno']   					=    	  $_SESSION[$id]['vehicle_number'];
   	 $ds['image']   						=    	 $_SESSION[$id]['image_name'];
	$ds['visitorcompany']			=			$_SESSION[$id]["campus_area_department"];
	  $ds['visitdate']						=			$sub_date;
	$ds['totime']							=			$sub_time;
	$ds['category']						=			$_SESSION[$id]["category"];
	 $ds['duration']            =$_SESSION['visiting_duration'][$_SESSION[$id]["category"]];
   	 $ds['docstatus']   					=           "Active";   
	 $ds['qrcode']							=           $_SESSION[$id]['qrfilename'] ;
	  print_r($ds);
   	 ds2insert($ds,"visitors");
   	 echo " Thank you Successfully submitted your details.we will check your details soon and back to you..";


            }



            if($_SESSION[$id]["category"]=="other_services"){


     $ds['visitorname']   				=   	  $_SESSION[$id]["name"];
   	 $ds['mobile']   						=    	   $_SESSION[$id]["phone_number"];
   	 $ds['visitorid']   						=         $_SESSION[$id]["visitorid"];
   	 $ds['vehicle_type']   				=    	  $_SESSION[$id]['vehicle_type'];
   	 $ds['vehicleno']   					=    	  $_SESSION[$id]['vehicle_number'];
	 $ds['purpose']   					=    	  	$_SESSION[$id]['purpose'];
	 $ds['vendor']   					=    	  	$_SESSION[$id]['vendor'];
   	 $ds['docstatus']   					=           "Active";  
	$ds['visitdate']						=			$sub_date;
	$ds['totime']							=			$sub_time;	 
	$ds['category']						=			$_SESSION[$id]["category"];
	 $ds['duration']=$_SESSION['visiting_duration'][$_SESSION[$id]["category"]];
	 $ds['qrcode']							=         $_SESSION[$id]['qrfilename'] ;
	 $ds['image']   						=    	   $_SESSION[$id]['image_name'];
	 print_r($ds);
   	 ds2insert($ds,"visitors");
   	 echo " Thank you Successfully submitted your details.we will check your details soon and back to you..";
			


            }


            
            header('location:qr_code_after_submission.php?visitor_id='.$_SESSION[$id]["visitorid"].'');
			
			unset($_SESSION[$id]);



}

