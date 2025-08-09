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





		//if($_SESSION[$id]["point_of_contact"]!="*Other"){

		//	$pocname=$_SESSION[$id]["point_of_contact"];

		//}else{

		//	$pocname = $_SESSION[$id]["other_name"];

		//}

    $ds['visitorname']   			=   	  	$_SESSION[$id]["name"];
	//added
	//$ds['roomno']                   =           $_SESSION[$id]["other_room"];
   	$ds['mobile']   					=    	   	$_SESSION[$id]["phone_number"];
	$ds['sf_mobile']						=			$_SESSION[$id]["sf_phone_number"];
   	//$ds['persons']   					=    		$_SESSION[$id]['no_of_people'];
   	$ds['visitorid']   					=     		$_SESSION[$id]["visitorid"];
  	$ds['assignedname']   		=   	  	$_SESSION[$id]['whomToMeet'];
	//$ds['student_campus_address']   					= $_SESSION[$id]['other_address'];
   	$ds['purpose']   					=    	  	$_SESSION[$id]['purpose'];
   	$ds['vehicle_type']   			=    	  	$_SESSION[$id]['vehicle_type'];
   	$ds['vehicleno']   				=    	  	$_SESSION[$id]['vehicle_number'];
	//$ds['visitorcompany']		=			$_SESSION[$id]["campus_area_department"];
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
	 
	 //adding for email address from pw_entity
	 //$userid="preetham19.raj@gmail.com";
	 $sql="select userid from pw_entity where entitytype='EMPLOYEE' and status='Active'  and entityname ='".$ds['assignedname']."' and hremptype<>'' order by hremptype,entityname"; 
	 //$result = mysql_query($sql, $connection);
	 
	 $emailDS=getValueForPS($sql);

	//	if (mysql_num_rows($result) > 0) {
	//		$row = mysql_fetch_assoc($result);
	//		$userid = $row['userid'];
	//	    echo "User ID: " . $userid;
	//	}
	
			$visitorId = $ds['visitorid']; // Assuming this is generated earlier

		// Generate approval and denial links
		$approveLink = "https://ims-dev.iiit.ac.in/visitors/approve.php?visitorid={$visitorId}&status=approve";
		$denyLink = "https://ims-dev.iiit.ac.in/visitors/deny.php?visitorid={$visitorId}&status=deny";
	 
	 
	//adding email notification fro faculty/students
		$str = "<div style='width:300px;border: 1px solid #eee;border-top-color: rgb(238, 238, 238);border-top-style: solid;border-top-width: 1px;border-right-color: rgb(238, 238, 238);
    					border-right-style: solid;border-right-width: 1px;border-bottom-color: rgb(238, 238, 238);border-bottom-style: solid;border-bottom-width: 1px;
    					border-left-color: rgb(238, 238, 238);border-left-style: solid;border-left-width: 1px;margin-left:150px;margin-top:10px;'>
					<div style='padding:30px;'>
						<center><span style='font-size: 25px;font-family: 'Open Sans', sans-serif;'>Visitor Details</span><br><br>
						</center>
						<hr>
						<p>Date    : ".$ds['visitdate']."</p>
						<p>Time    : ".$ds['totime']."</p>
						<p>Name    : ".$ds['visitorname']."</p>
						<p>To Meet : ".$ds['assignedname']."</p>
					</div>
					<center><p> This VMS notification is to alert you of the following individual/visitor who has made an entry for meeting with you and is currently on the way inside the campus. </p>
									<br> <a href='{$approveLink}'>Approve</a> | <a href='{$denyLink}'>Deny</a><center>
				</div>";
	
	
		$from= "noreply@iiit.ac.in";
		//$to=$recds['email'];
		$to="preetham19.raj@gmail.com";
		$to = $emailDS;
		$sub="Visitor Entry Notification - ".$ds['visitorname'] ;
		$msg=$str;
		
		sendMailIiit($from,$to,$sub,$msg);

            
     }


     if($_SESSION[$id]["category"]=="cab"){


            $name="";


            if($_SESSION[$id]["cab_service_name"]!="other"){
                $name=$_SESSION[$id]["cab_service_name"];
            }else{
                $name = $_SESSION[$id]["other_service_name"];
            }
			
			//Added
			
				 	//	$pocname="";





		//if($_SESSION[$id]["point_of_contact"]!="*Other"){

			//$pocname=$_SESSION[$id]["point_of_contact"];

		//}else{

		//	$pocname = $_SESSION[$id]["other_name"];

		//}
        
       $ds['visitorname']   	=   	  	$name;
	   //added
	  // $ds['roomno']                   =           $_SESSION[$id]["other_room"];
   	 $ds['visitorid']   		=         	$_SESSION[$id]["visitorid"];
   	 $ds['purpose']   		=    	  	$_SESSION[$id]['purpose'];
   	 $ds['vehicle_type']  =    	  	$_SESSION[$id]['vehicle_type'];
   	 $ds['vehicleno']   		=    	  	$_SESSION[$id]['vehicle_number'];
   	 $ds['visitdate']			=			$sub_date;
	$ds['totime']				=			$sub_time;
	$ds['category']			=			$_SESSION[$id]["category"];
	//$ds['assignedname']   		=   	  	$pocname;
	//$ds['student_campus_address']   					= $_SESSION[$id]['other_address'];
	//$ds['visitorcompany']		=			$_SESSION[$id]["campus_area_department"];
	 $ds['duration']		=$_SESSION['visiting_duration'][$_SESSION[$id]["category"]];
	 $ds['qrcode']				=         $_SESSION[$id]['qrfilename'] ;
	 $ds['image']   			    =    	  	$_SESSION[$id]['image_name'];
   	 $ds['docstatus']   		    =           "Active";  
	  print_r($ds);
   	 ds2insert($ds,"visitors");
   	 echo " Thank you Successfully submitted your details.we will check your details soon and get back to you..";
                            

     }



            if($_SESSION[$id]["category"]=="delivery"){
				
				//Added
								 	//	$pocname="";





		//if($_SESSION[$id]["point_of_contact"]!="*Other"){

		//	$pocname=$_SESSION[$id]["point_of_contact"];

	//	}else{

		//	$pocname = $_SESSION[$id]["other_name"];

		//}


     $ds['visitorname']   				=   	  $_SESSION[$id]["name"];
	 //added on 01/30 by preetham
	// $ds['roomno']                   =           $_SESSION[$id]["other_room"];
	 $ds['service_delivery']            =          $_SESSION[$id]["del_service"];
   	 $ds['visitorid']   						=         $_SESSION[$id]["visitorid"];
	  $ds['mobile']   						=    	   	$_SESSION[$id]["phone_number"];
	 // $ds['assignedname']   		=   	  	$pocname;
	//$ds['student_campus_address']   					= $_SESSION[$id]['other_address'];
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
   	 echo " Thank you Successfully submitted your details.we will check your details soon and get back to you..";


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
   	 echo " Thank you Successfully submitted your details.we will check your details soon and get back to you..";
			


            }


            
            header('Location: index.php');
			
			unset($_SESSION[$id]);



}

