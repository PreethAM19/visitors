<?php
//store in db function then reset the input values
$author = 'Free';
include_once '../pw_xcon.php';
include_once 'utils.php';
$servername="localhost";
$username="imsdevuser";
$password="UjhGFTybCDSr";
$database="newimsiiithdev";
session_start();
require_once('../visitors/qrphp/qrlib.php');

$path = '../uploads/meghanaqr/';

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

	$last_record_id = null;

	$sub_time = date('H:i');

	$sub_date = date('d-m-y');

	$series_to_create_qr = null;


$conn = new mysqli($servername,$username,$password,$database);
if(!$conn){
	$err_at_submission = mysql_error();
	die();
}



// Visitor category
		if($_SESSION[$id]["category"]=="visitor"){

			$image_name = "";

			echo "from visitor category";



			if(file_exists('../uploads/meghanaimage/'.implode("_",$_SESSION[$id]).'.jpg')){

				$image_name = implode("_",$_SESSION[$id]).'.jpg';

			}

			$pattern = date("dmy")."iv________";

			// echo $pattern;
			// echo(strlen($pattern));
			$sql = "SELECT MAX(CAST((MID(visitorid, 9, 4))AS INTEGER)) AS lastid from visitors WHERE visitorid LIKE '".$pattern."'";

			$result = mysqli_query($conn,$sql);
			var_dump ($result);
			echo"<br>";
			echo '//////';
			echo"<br>";
		var_dump($result);
			echo"<br>";
			 echo "///////";
			echo"<br>";
			
			if($result){
				//echo "in result";
				$row = mysqli_fetch_assoc($result);

				// var_dump($row);

				if($row["lastid"]==Null){

					// as lastid in null then creating new id with same pattern and generate qr and insert

					$series_to_create_qr = date("dmy")."iv0001".date("Hi");

				// 	$new_id_on_that_day_for_that_category = date("d/y/m/")."iv/0001/".date("H/i");

				// $stmt = $conn->prepare("INSERT INTO visk_manag(visitor_id)values(?)");

				// 		   $stmt->bind_param("s", $new_id_on_that_day_for_that_category);

				// 		        $stmt->execute();

				// 		          $stmt->close();

				// 		         $conn->close();

				}else{

					$number_to_create_new_id_for_the_day = sprintf('%04s',strval($row["lastid"]+1));

					$len_val = strlen($number_to_create_new_id_for_the_day);

					sprintf('%04s',$number_to_create_new_id_for_the_day);

					$series_to_create_qr  = "".date("dmy")."iv".$number_to_create_new_id_for_the_day.date("Hi")."";

				}

			} 

			// echo $series_to_create_qr;

			$file_store_as=$path."qr".implode("_",$_SESSION[$id]).'.png';

			$qr_file_name = "qr".implode("_",$_SESSION[$id]).'.png';

			// echo $file_store_as;

			QRcode :: png($series_to_create_qr, $file_store_as,'H',4, 4);

			date_default_timezone_set("Asia/Calcutta");

	$ds['visitorname']   			=   	  	$_SESSION[$id]["name"];
   	$ds['mobile']   					=    	   	$_SESSION[$id]["phone_number"];
   	$ds['persons']   					=    		$_SESSION[$id]['no_of_people'];
   	$ds['visitorid']   					=     		$series_to_create_qr;
   	$ds['assignedname']   		=   	  	$_SESSION[$id]['point_of_contact'];
   	$ds['purpose']   					=    	  	$_SESSION[$id]['purpose'];
   	$ds['vehicle_type']   			=    	  	$_SESSION[$id]['vehicle_type'];
   	$ds['vehicleno']   				=    	  	$_SESSION[$id]['vehicle_number'];
	$ds['visitorcompany']		=			$_SESSION[$id]["campus_area_department"];
	$ds['visitdate']					=			$sub_date;
	$ds['totime']						=			$sub_time;
	$ds['category']					=			$_SESSION[$id]["category"];
	$ds['qrcode']						=          $qr_file_name;
	$ds['image']						=		$image_name;
	$ds['duration']			=$_SESSION['visiting_duration'][$_SESSION[$id]["category"]];
   	$ds['docstatus']   				=           "Active"; 
   	ds2insert($ds,"visitors");
	echo "<br><hr>";
	echo "<pre>";
	print_r($ds);
   	 echo " Thank you Successfully submitted your details..";
	
		/*	$stmt = $conn->prepare("INSERT INTO  visitor_management(

			visitor_id,//visitorid	

			name,	//visitorname

			phone_number,	//mobile

			no_of_people,//persons	

			department,	//designation

			person_to_meet,	//assignedname

			purpose,	//purpose

			vehicle_type,	//vehicle_type

			vehicle_no, //vehicleno

			image,

			entry_registered_time,

			entry_registered_date,

			

			  qr_image,

			  category,

			  allowed_duration)values(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");

			  $stmt->bind_param("ssiissssssssssi",

			  $series_to_create_qr, 

			  $_SESSION[$id]["name"],//name

			   $_SESSION[$id]["phone_number"],//phone num

			   $_SESSION[$id]["no_of_people"],//no_of_people

			   $_SESSION[$id]["campus_area_department"],//departmenrt

			   $_SESSION[$id]["point_of_contact"],//person to meet

			   $_SESSION[$id]["purpose"],

			   $_SESSION[$id]["vehicle_type"],

			   $_SESSION[$id]["vehicle_number"],

			   $image_name ,

			   $sub_time,

			   $sub_date,

				

			   //image name if exists

			   $qr_file_name,//qr saved 

			   $_SESSION[$id]["category"],//category

			   $_SESSION['visiting_duration'][$_SESSION[$id]["category"]]

			);

			$stmt->execute();

			$stmt->close();

			$conn->close();
*/

		}
		// Cab Category
		if($_SESSION[$id]["category"]=="cab"){

			$image_name = "";
			if(file_exists('../uploads/meghanaimage/'.implode("_",$_SESSION[$id]).'.jpg')){

				$image_name = implode("_",$_SESSION[$id]).'.jpg';

			}
			$pattern = date("dmy")."cv________";

			// echo $pattern;
			// echo(strlen($pattern));

			$sql = "SELECT MAX(CAST((MID(visitorid, 9, 4))AS INTEGER)) AS lastid from visitors WHERE visitorid LIKE '".$pattern."'";
			$result = mysqli_query($conn,$sql);

			// echo '//////';

			// var_dump($result);

			// echo "///////";
			if($result){

				// echo "in result";
				$row = mysqli_fetch_assoc($result);
				// var_dump($row);
				if($row["lastid"]==Null){
					// as lastid in null then creating new id with same pattern and generate qr and insert
					$series_to_create_qr = date("dmy")."cv0001".date("Hi");

				// 	$new_id_on_that_day_for_that_category = date("d/y/m/")."iv/0001/".date("H/i");

				// $stmt = $conn->prepare("INSERT INTO visk_manag(visitor_id)values(?)");

				// 		   $stmt->bind_param("s", $new_id_on_that_day_for_that_category);

				// 		        $stmt->execute();

				// 		          $stmt->close();

				// 		         $conn->close();

				}else{

					$number_to_create_new_id_for_the_day = sprintf('%04s',strval($row["lastid"]+1));

					$len_val = strlen($number_to_create_new_id_for_the_day);

					sprintf('%04s',$number_to_create_new_id_for_the_day);

					$series_to_create_qr  = "".date("dmy")."cv".$number_to_create_new_id_for_the_day."".date("Hi")."";

				}

			} 

			// echo $series_to_create_qr;

			$file_store_as=$path."qr".implode("_",$_SESSION[$id]).'.png';

			$qr_file_name = "qr".implode("_",$_SESSION[$id]).'.png';

			QRcode :: png($series_to_create_qr, $file_store_as,'H',4, 4);

			$name="";

			if($_SESSION[$id]["cab_service_name"]!="other"){

				$name=$_SESSION[$id]["cab_service_name"];

			}else{

				$name = $_SESSION[$id]["other_service_name"];

			}
	$ds['visitorname']   	=   	  	$name;
   	 $ds['visitorid']   		=         	$series_to_create_qr;
   	 $ds['purpose']   		=    	  	$_SESSION[$id]['purpose'];
   	 $ds['vehicle_type']  =    	  	$_SESSION[$id]['vehicle_type'];
   	 $ds['vehicleno']   		=    	  	$_SESSION[$id]['vehicle_number'];
   	 $ds['visitdate']			=			$sub_date;
	$ds['totime']				=			$sub_time;
	$ds['category']			=			$_SESSION[$id]["category"];
	 $ds['duration']		=$_SESSION['visiting_duration'][$_SESSION[$id]["category"]];
	 $ds['qrcode']				=          $qr_file_name;
	 $ds['image']   			    =    	  	$image_name;
   	 $ds['docstatus']   		    =           "Active";  
	  print_r($ds);
   	 ds2insert($ds,"visitors");
   	 echo " Thank you Successfully submitted your details.we will check your details soon and back to you..";



			/*$stmt = $conn->prepare("INSERT INTO  visitor_management(

				visitor_id,	

				name,		

				purpose,	

				vehicle_type,	

				vehicle_no,

				image,

				entry_registered_time,

				entry_registered_date,

				  qr_image,

				  category,

				  allowed_duration)values(?,?,?,?,?,?,?,?,?,?,?)");

				  $stmt->bind_param("ssssssssssi",

				  $series_to_create_qr,

				  $name,

				   $_SESSION[$id]["purpose"],

				   $_SESSION[$id]["vehicle_type"],

				   $_SESSION[$id]["vehicle_number"],

				   $image_name ,

				   $sub_time,

				   $sub_date,

				   $qr_file_name,//qr saved 

				   $_SESSION[$id]["category"],//category

				   $_SESSION['visiting_duration'][$_SESSION[$id]["category"]]

				);

				$stmt->execute();

				$stmt->close();

				$conn->close();

			



			
*/
		}
		if($_SESSION[$id]["category"]=="delivery"){

			$image_name = "";
			if(file_exists('../uploads/meghanaimage/'.implode("_",$_SESSION[$id]).'.jpg')){

				$image_name = implode("_",$_SESSION[$id]).'.jpg';

			}
			$pattern = date("dmy")."dv________";

			// echo $pattern;

			// echo(strlen($pattern));

			$sql = "SELECT MAX(CAST((MID(visitorid, 9, 4))AS INTEGER)) AS lastid from visitors WHERE visitorid LIKE '".$pattern."'";
			

			$result = mysqli_query($conn,$sql);

			// echo '//////';

			// var_dump($result);

			// echo "///////";

			

			if($result){

				// echo "in result";

				$row = mysqli_fetch_assoc($result);

				// var_dump($row);

				if($row["lastid"]==Null){

					// as lastid in null then creating new id with same pattern and generate qr and insert



					$series_to_create_qr = date("dmy")."dv0001".date("Hi");

					

				// 	$new_id_on_that_day_for_that_category = date("d/y/m/")."iv/0001/".date("H/i");

				// $stmt = $conn->prepare("INSERT INTO visk_manag(visitor_id)values(?)");

				// 		   $stmt->bind_param("s", $new_id_on_that_day_for_that_category);

				// 		        $stmt->execute();

				// 		          $stmt->close();

				// 		         $conn->close();

				}else{

					$number_to_create_new_id_for_the_day = sprintf('%04s',strval($row["lastid"]+1));

					$len_val = strlen($number_to_create_new_id_for_the_day);

					sprintf('%04s',$number_to_create_new_id_for_the_day);

					$series_to_create_qr  = "".date("dmy")."dv".$number_to_create_new_id_for_the_day.date("Hi")."";

				}

			} 

			// echo $series_to_create_qr;

			$file_store_as=$path."qr".implode("_",$_SESSION[$id]).'.png';

			$qr_file_name = "qr".implode("_",$_SESSION[$id]).'.png';

			QRcode :: png($series_to_create_qr, $file_store_as,'H',4, 4);
	
	$ds['visitorname']   				=   	  $_SESSION[$id]["name"];
   	 $ds['visitorid']   						=         $series_to_create_qr;
	  $ds['mobile']   						=    	   	$_SESSION[$id]["phone_number"];
   	 $ds['assignedname']   			=   	  $_SESSION[$id]['point_of_contact'];
   	 $ds['purpose']   					=    	  $_SESSION[$id]['purpose'];
   	 $ds['vehicle_type']   				=    	  $_SESSION[$id]['vehicle_type'];
   	 $ds['vehicleno']   					=    	  $_SESSION[$id]['vehicle_number'];
   	 $ds['image']   						=    	  $image_name;
	$ds['visitorcompany']			=			$_SESSION[$id]["campus_area_department"];
	  $ds['visitdate']						=			$sub_date;
	$ds['totime']							=			$sub_time;
	$ds['category']						=			$_SESSION[$id]["category"];
	 $ds['duration']            =$_SESSION['visiting_duration'][$_SESSION[$id]["category"]];
   	 $ds['docstatus']   					=           "Active";   
	 $ds['qrcode']							=          $qr_file_name;
	  print_r($ds);
   	 ds2insert($ds,"visitors");
   	 echo " Thank you Successfully submitted your details.we will check your details soon and back to you..";

			

			/*$stmt = $conn->prepare("INSERT INTO  visitor_management(

				visitor_id,	

				name,	

				phone_number,		

				department,	

				person_to_meet,	

				purpose,	

				vehicle_type,	

				vehicle_no,

				image,

				entry_registered_time,

				entry_registered_date,

				  

				  qr_image,

				  category,

				  allowed_duration)values(?,?,?,?,?,?,?,?,?,?,?,?,?,?)");

				  $stmt->bind_param("ssissssssssssi",

				  $series_to_create_qr, 

				  $_SESSION[$id]["name"],//name

				   $_SESSION[$id]["phone_number"],//phone num



				   $_SESSION[$id]["campus_area_department"],//departmenrt

				   $_SESSION[$id]["point_of_contact"],//person to meet

				   $_SESSION[$id]["category"],

				   $_SESSION[$id]["vehicle_type"],

				   $_SESSION[$id]["vehicle_number"],

				   $image_name ,

				   $sub_time,

				   $sub_date,

					

				  

				   $qr_file_name,

				   $_SESSION[$id]["category"],//category

				   $_SESSION['visiting_duration'][$_SESSION[$id]["category"]]

				);

				$stmt->execute();

				$stmt->close();

				$conn->close();*/

				}



		if($_SESSION[$id]["category"]=="other_services"){

			$image_name = "";



			if(file_exists('../uploads/meghanaimage/'.implode("_",$_SESSION[$id]).'.jpg')){

				$image_name = implode("_",$_SESSION[$id]).'.jpg';

			}



			$pattern = date("dmy")."ov________";

			// echo $pattern;

			// echo(strlen($pattern));

			$sql = "SELECT MAX(CAST((MID(visitorid, 9, 4))AS INTEGER)) AS lastid from visitors WHERE visitorid LIKE '".$pattern."'";
			

			$result = mysqli_query($conn,$sql);

			// echo '//////';

			// var_dump($result);

			// echo "///////";

			

			if($result){

				// echo "in result";

				$row = mysqli_fetch_assoc($result);

				// var_dump($row);

				if($row["lastid"]==Null){

					// as lastid in null then creating new id with same pattern and generate qr and insert



					$series_to_create_qr = date("dmy")."ov0001".date("Hi");

					

				// 	$new_id_on_that_day_for_that_category = date("d/y/m/")."iv/0001/".date("H/i");

				// $stmt = $conn->prepare("INSERT INTO visk_manag(visitor_id)values(?)");

				// 		   $stmt->bind_param("s", $new_id_on_that_day_for_that_category);

				// 		        $stmt->execute();

				// 		          $stmt->close();

				// 		         $conn->close();

				}else{

					$number_to_create_new_id_for_the_day = sprintf('%04s',strval($row["lastid"]+1));

					$len_val = strlen($number_to_create_new_id_for_the_day);

					sprintf('%04s',$number_to_create_new_id_for_the_day);

					$series_to_create_qr  = "".date("dmy")."ov".$number_to_create_new_id_for_the_day.date("Hi")."";

				}

			} 

			// echo $series_to_create_qr;

			$file_store_as=$path."qr".implode("_",$_SESSION[$id]).'.png';

			$qr_file_name = "qr".implode("_",$_SESSION[$id]).'.png';

			QRcode :: png($series_to_create_qr, $file_store_as,'H',4, 4);
			

	$ds['visitorname']   				=   	  $_SESSION[$id]["name"];
   	 $ds['mobile']   						=    	   $_SESSION[$id]["phone_number"];
   	 $ds['visitorid']   						=         $series_to_create_qr;
   	 $ds['vehicle_type']   				=    	  $_SESSION[$id]['vehicle_type'];
   	 $ds['vehicleno']   					=    	  $_SESSION[$id]['vehicle_number'];
   	 $ds['docstatus']   					=           "Active";  
	$ds['visitdate']						=			$sub_date;
	$ds['totime']							=			$sub_time;	 
	$ds['category']						=			$_SESSION[$id]["category"];
	 $ds['duration']=$_SESSION['visiting_duration'][$_SESSION[$id]["category"]];
	 $ds['qrcode']							=          $qr_file_name;
	 $ds['image']   						=    	  $image_name;
	 print_r($ds);
   	 ds2insert($ds,"visitors");
   	 echo " Thank you Successfully submitted your details.we will check your details soon and back to you..";
			

			/*$stmt = $conn->prepare("INSERT INTO  visitor_management(

				visitor_id,	

				name,	

				phone_number,	

				vehicle_type,	

				vehicle_no,

				image,

				entry_registered_time,

				entry_registered_date,

				  qr_image,

				  category,

				  allowed_duration)values(?,?,?,?,?,?,?,?,?,?,?)");

				  $stmt->bind_param("ssisssssssi",

				  $series_to_create_qr, 

				  $_SESSION[$id]["name"],

				   $_SESSION[$id]["phone_number"],				 

				   $_SESSION[$id]["vehicle_type"],

				   $_SESSION[$id]["vehicle_number"],

				   $image_name ,

				   $sub_time,

				   $sub_date,

				   //image name if exists

				   $qr_file_name,//qr saved 

				   $_SESSION[$id]["category"],//category

				   $_SESSION['visiting_duration'][$_SESSION[$id]["category"]]

				);

				$stmt->execute();

				$stmt->close();

				$conn->close();

				
*/
		}

unset($_SESSION[$id]);

		header('location:qr_code_after_submission.php?visitor_id='.$series_to_create_qr.'');
		//do not change visitor_id 

	
}


?>
