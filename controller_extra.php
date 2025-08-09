<?php

//getting the required form data from the back end or server

//$wtmoptions['iiith'] = [];

//$wtmoptions['cie'] = [];

//$wtmoptions['fsq']=[];

date_default_timezone_set("Asia/Calcutta");

session_start();

 /*$conn = new mysqli('localhost',"root","","visitors_database_iiith");

    if(!$conn){

       $err_at_submission = "Cannot connect to Database";

       die(); 

       }

$sql = "SELECT visitor_name, visitor_entry_id, mobile_number FROM visitor_entry_details_table";

$result = mysqli_query($conn,$sql);

if($result){

    while($row = mysqli_fetch_assoc($result)){

        array_push($wtmoptions['iiith'],$row['visitor_name']);

        array_push($wtmoptions['cie'],$row['mobile_number']);

        array_push($wtmoptions['fsq'],$row['visitor_entry_id']);

    }

//echo "controller is working";

   //  var_dump($wtmoptions);



    $_SESSION['department_options'] = $wtmoptions;

    

   }*/
  $servername="localhost";
$username="imsdevuser";
$password="UjhGFTybCDSr";
$database="newimsiiithdev";



$conn = new mysqli($servername,$username,$password,$database);
if(!$conn){
	$err_at_submission = mysql_error();
	die();
}

//$sql="select entitycode,entityname,userid from pw_entity where entitytype='EMPLOYEE' and status='Active' and hremptype<>'' order by hremptype,entityname";

$sql="select entityname from pw_entity where entitytype='EMPLOYEE' and status='Active' and hremptype<>'' order by hremptype,entityname"; 
   
/*$wtmoptions['iiith'] = ['Arjun','Krishna', 'Shiva', 'Ram', 'Narayan', 'Piyush','Arjuna' ];

$wtmoptions['cie'] = ['Hariom', 'Karan', 'Pavan', 'Aditya', 'Vihaan', 'Sai', 'Pranav', 'Dhruv', 'Rithvik' ];

$wtmoptions['fsq']=['Loft Life','The Contemporary Chambers','The Urban Haven','The Industrial Residence','The Modern Loft','The Elevated Abode',' Urban Retreat.'];*/

$wtmoptions['iiith'] = ["*Other"];
 $wtmoptions['cie'] = ["*Other","cie emoployee 1", "cie employee 2", "cie emoployee 3", "cie employee 4"];
 $wtmoptions['fsq']=["*Other","flat no: 1","flat no: 2","flat no: 3","flat no: 4","flat no: 5","flat no: 6"];
 $result = mysqli_query($conn,$sql);
if (mysqli_num_rows($result) > 0) {

    // Loop through each row and display the data

while ($row = mysqli_fetch_assoc($result)) {
	//echo "<br/>";		
		//var_dump($row);
//echo "<br/>";
//echo "<br/>";
//echo $row['entityname'];
//echo "<br/>";

array_push($wtmoptions['iiith'],$row['entityname']);
//echo "<br/>";
//var_dump($wtmoptions['iiith']);
}

//echo "controller is working";

   //  var_dump($wtmoptions);



    $_SESSION['department_options'] = $wtmoptions;
    

   }







// var_dump($_POST);



//initiating variables to take the values from globals or on any operation and assign to the fields





$data_in_ls_with_key = null;



$category_constants = ["visitor"=>"visitor","cab"=>"cab","delivery"=>"delivery","other_services"=>"other_services"];

$name = $phone_number  = $point_of_contact =  $vehicle_status =  $vehicle_type = $vehicle_number =$image_path_to_save = $cab_service_name= $other_service_name=$other_name=$other_address=$otherAddressSelectize=$del_service=$other_room=$delServiceSelectize=$image_file_name="";

$name_err_msg = $last_name_err_msg=$phone_number_err_msg=$point_of_contact_err_msg=$department_err_msg=$vehicle_type_err_msg=$vehicle_number_err_msg=$visitor_image_err_msg=$other_service_name_err_msg=$other_address_err_msg=$other_name_err_msg="";

$image_uploaded_status = false;

$to_store_data_in_db = ["name"=>"","phone_number"=>"","point_of_contact"=>"","vehicle_type"=>"","vehicle_number"=>"","purpose"=>""]; //"department_to_approach"=>"",

$submission_status = "";

$err_at_submission = "";

 $category = "";
 
 $vendor= "";

 $purpose = "";

 $purpose_err_msg="";

 $campus_area_department = "iiith";

 $no_of_people="";

 $pick_or_drop_err_msg = "";

 $no_of_people = "";

 //$department_to_approach = "";



 //  $coming_from_err_msg = $coming_from = ""

// $to_store_data_in_db["coming_from"] = ""





//if(isset($_POST['back_trigger'])){ // send the ls key on reload from the other modules
if(isset($_SESSION['back_trigger_webcam_page'])){
   //echo "codeload";

   //var_dump($_SESSION[$_POST['on_back_code_load']]['name']);

  // $data_in_ls_with_key = $_POST['on_back_code_load'];// code is coming in post from back post method  
$data_in_ls_with_key = $_SESSION['back_trigger_webcam_page'];
unset($_SESSION['back_trigger_webcam_page']);
   

   //var_dump($_SESSION[$data_in_ls_with_key]);

   $category = $_SESSION[$data_in_ls_with_key]["category"];

   $cab_service_name = $_SESSION[$data_in_ls_with_key]["cab_service_name"];

   $other_service_name = $_SESSION[$data_in_ls_with_key]["other_service_name"];

   $name=$_SESSION[$data_in_ls_with_key]["name"];



    if(($category==$category_constants["visitor"])||($category==$category_constants["delivery"])||($category==$category_constants["other_services"])){

     $phone_number=($_SESSION[$data_in_ls_with_key]["phone_number"]);

   }

   if($category==$category_constants["visitor"]){

   $no_of_people = $_SESSION[$data_in_ls_with_key]["no_of_people"];}

   if(($category==$category_constants['visitor'])||($category==$category_constants['delivery'])||($category==$category_constants['cab'])){

   $campus_area_department = $_SESSION[$data_in_ls_with_key]["campus_area_department"];

}  



    //  if($category==$category_constants['visitor']){

    //  $coming_from=($_SESSION[$data_in_ls_with_key]["coming_from"]);}

    if(($category==$category_constants['visitor'])||($category==$category_constants['delivery'])||($category==$category_constants['cab'])){

     $point_of_contact=($_SESSION[$data_in_ls_with_key]["point_of_contact"]);}

   //   if($_SESSION[$_POST['on_back_code_load']]["category"]==$category_constants["visitor"]){

   //   $department_to_approach=($_SESSION[$_POST['on_back_code_load']]["department_to_approach"]);}else{

   //     $department_to_approach = "Null";

   //   }  

      $vehicle_status=($_SESSION[$data_in_ls_with_key]["vehicle_status"]);

     if($vehicle_status=="true"){

           $vehicle_type=($_SESSION[$data_in_ls_with_key]["vehicle_type"]);

           $vehicle_number=($_SESSION[$data_in_ls_with_key]["vehicle_number"]);}

     else{

      $_SESSION[$data_in_ls_with_key]["vehicle_type"]="";

      $_SESSION[$data_in_ls_with_key]["vehicle_number"] = "";

          $vehicle_type = "";

          $vehicle_number = "";

     };



     if($category==$category_constants['visitor']){

      $purpose = $_SESSION[$data_in_ls_with_key]["purpose"];



      // echo '<br/>';

     

      // echo '<br/>';

      // echo $purpose;

      // echo '<br/>';

      

      // echo '<br/>';

      // $pick_or_drop_err_msg = "Please Select Pick Or Drop to Submit";

      

     }else if($category==$category_constants['cab']){

      //enter pick or drop status

      if(isset($_SESSION[$data_in_ls_with_key]["purpose"])){

      $purpose = $_SESSION[$data_in_ls_with_key]["purpose"];

      $pick_or_drop_err_msg = "";

      $to_store_data_in_db["purpose"] = $_SESSION[$data_in_ls_with_key]["purpose"];

   }else{

         $pick_or_drop_err_msg = "Please Select Pick Or Drop to Submit";

      }

     }else if($category==$category_constants['delivery']){

      $purpose = "delivery";

      $to_store_data_in_db["purpose"] = "delivery";

     }



   //   unset($_SESSION['on_back_and_codeload']);

   //   echo $campus_area_department;

   //   echo $no_of_people;

   //   echo $point_of_contact;



   //var_dump($_SESSION);

}else{

  // echo 'new created';

   // $_SESSION['creatin_and_destroy_id'] = uniqid();

   // $data_in_ls_with_key = $_SESSION['creatin_and_destroy_id'];

   $data_in_ls_with_key =  uniqid();

   // unset($_SESSION['creatin_and_destroy_id']);

}





if(isset($_POST["next_on_page_one"])){

    date_default_timezone_set("Asia/Calcutta");

 // $to_store_data_in_db["date_time_created"] = date('d-m-y h:i:s');

 //   echo $_POST["regis_date"] ;

 //   echo $_POST["regis_time"];

 //var_dump($_POST);

    $category = $_POST["category"];

    $cab_service_name = $_POST["cab_service_name"];

    $other_service_name = $_POST["other_service_name"];   

    $name=$_POST["name"];



    if(($category==$category_constants["visitor"])||($category==$category_constants["delivery"])||($category==$category_constants["other_services"])){

     $phone_number=($_POST["phone_number"]);}

    //  if($category==$category_constants['visitor']){

    //  $coming_from=($_POST["coming_from"]);}

    if($category==$category_constants["visitor"]){

      $no_of_people = $_POST["no_of_people"];}

      if(($category==$category_constants['visitor'])||($category==$category_constants['delivery'])){

      $campus_area_department = $_POST["campus_area_department"];

   }



   if(($category==$category_constants['visitor'])||($category==$category_constants['delivery'])||($category==$category_constants['cab'])){

     $point_of_contact=($_POST["point_of_contact"]);}

     else{

      $point_of_contact = "Null";



     }

   //   if($_POST["category"]==$category_constants["visitor"]){

   //   $department_to_approach=($_POST["department_to_approach"]);}else{

   //     $department_to_approach = "Null";

   //   } 

     $vehicle_status=($_POST["vehicle_status"]);

     if($vehicle_status=="true"){

           $vehicle_type=($_POST["vehicle_type"]);

           $vehicle_number=($_POST["vehicle_number"]);}

     else{

          $_POST["vehicle_type"]="";

          $_POST["vehicle_number"] = "";

          $vehicle_type = "";

          $vehicle_number = "";

     };



     if($category==$category_constants['visitor']){

      $purpose = $_POST["purpose"];



      // echo '<br/>';

   

      // echo '<br/>';

      // echo $purpose;

      // echo '<br/>';

     

      // echo '<br/>';

      

      

     }else if($category==$category_constants['cab']){

      //enter pick or drop status

      if(isset($_POST["purpose"])){

      $purpose = $_POST["purpose"];

      $pick_or_drop_err_msg = "";

      $to_store_data_in_db["purpose"] = $_POST["purpose"];

   }else{

         $pick_or_drop_err_msg = "Please Select Pick Or Drop to Submit";

      }

      

     }else if($category==$category_constants['delivery']){

      $purpose = "delivery";

      $to_store_data_in_db["purpose"] = "delivery";

     }else{

      $to_store_data_in_db["purpose"] = "Null";



     }







     if(empty($name)){

       $name_err_msg = "cannot submit without your  name";   

   }else{

     $name = test_input($name);

     if(!preg_match("/^[a-zA-Z]+([.]?( )?[a-zA-Z])+$/", $name)){       

        $name_err_msg = "Please enter a valid name to submit form";

     }else{

        $to_store_data_in_db["name"]=$name;

        $name_err_msg="";

     }

   }

     if($category==$category_constants["cab"]){

       if($cab_service_name!="other"){

          $to_store_data_in_db["name"]=$cab_service_name;

       }else{

          $to_store_data_in_db["name"]=$other_service_name;

          if(empty($other_service_name)){

             $other_service_name_err_msg = "cannot submit without your service name ";   

         }else{

          $other_service_name = test_input($other_service_name);

           

           if(!preg_match("/^[a-zA-Z]+([.]?( )?[a-zA-Z])+$/", $other_service_name)){       

             $other_service_name_err_msg = "Please enter a valid name to submit form";

           }else{

              $to_store_data_in_db["name"]=$other_service_name;

              $other_service_name_err_msg="";

           }

         }

          

       }

     }



     if(($category==$category_constants["visitor"])||($category==$category_constants["delivery"])||($category==$category_constants["other_services"])){

 if(empty($phone_number)){

    $phone_number_err_msg = "cannot submit without your mobile name";   

 }else{

  $phone_number = test_input($phone_number);

  

  if(!preg_match("/^[6-9]{1}[0-9]{9}$/", $phone_number)){       

     $phone_number_err_msg = "Please enter a valid mobile number to submit form";

  }else{

    $to_store_data_in_db["phone_number"]=$phone_number;

    $phone_number_err_msg="";

  }

 }}else{

   $to_store_data_in_db["phone_number"]="Null";

 }

 // if($category==$category_constants['visitor']){

 

 // if(empty($coming_from)){

 //    $coming_from_err_msg = "cannot submit without your place or reference of coming";   

 // }else{

 //    $coming_from = test_input($coming_from);

 //    $to_store_data_in_db["coming_from"]=$coming_from;

 //    $coming_from_err_msg = "";

 // }

 

 // }else if($category!=$category_constants["other_services"]){

 //    $to_store_data_in_db["coming_from"] = $name;

 

 // }else{

 //    $to_store_data_in_db["coming_from"] = $category;

 // }





//  if(empty($point_of_contact)){

//     $point_of_contact_err_msg = "cannot submit without knowing your point of contact in campus";   

//  }else{

//     $point_of_contact_err_msg = "";

//     $point_of_contact = test_input($point_of_contact);

  

//   if(!preg_match("/^[A-Za-z]+([.]?( )?[A-Za-z])+$/", $point_of_contact)){       

//     $point_of_contact_err_msg = "Please enter a valid name to submit form";

//   }else{

    $to_store_data_in_db["point_of_contact"]=$point_of_contact;

//     $point_of_contact_err_msg = "";

//  }

//  }





//  if($_POST["category"]==$category_constants["visitor"]){

//  if(empty($department_to_approach)){

//     $department_err_msg = "cannot submit without knowing your point of contacts working department in campus";   

//  }else{

//     $department_err_msg = "";

//     $department_to_approach = test_input($department_to_approach);

//     $to_store_data_in_db["department_to_approach"]=$department_to_approach;

//  }}else{

//     $to_store_data_in_db["department_to_approach"]= "Null";

//  }

 if($vehicle_status=="true"){

    if(empty($vehicle_type)){

       $vehicle_type_err_msg = "cannot submit without the type of vehicle your are by";   

    }else{

       $vehicle_type_err_msg = "";

    }

    if(empty($vehicle_number)){

       $vehicle_number_err_msg = "cannot submit without vehicle number";   

    }else{

       $vehicle_number= test_input($vehicle_number);

     

     if(!preg_match("/^[A-Za-z]{2}[\s]?[0-9]{1,2}(?:[\s]?[A-Za-z]+)?(?:[\s]?[a-zA-Z]*)?[\s]?[0-9]{4}$/", $vehicle_number)){      

       $vehicle_number_err_msg = "Please enter a valid vehicle number to submit";

     }else{

       $to_store_data_in_db["vehicle_number"]=$vehicle_number;

       $to_store_data_in_db["vehicle_type"]=$vehicle_type;

       $vehicle_number_err_msg = "";

       $vehicle_type_err_msg = "";

     }

    } 

 }else{

    $to_store_data_in_db["vehicle_number"]="Null";

    $to_store_data_in_db["vehicle_type"]="Null";   

 };







 if($category==$category_constants['visitor']){



   if(empty($purpose)){

      $purpose_err_msg = "cannot submit without knowing your purpose of coming";   

  }else{

    $purpose = test_input($purpose);

    $to_store_data_in_db["purpose"]=$purpose;

    $purpose_err_msg="";

    }

  }



// submission or next level for cab



//   if($category==$category_constants['cab']){

//    if($to_store_data_in_db["name"]!="" &&

//    $to_store_data_in_db["vehicle_type"]!="" &&  

//   $to_store_data_in_db["vehicle_number"]!=""&& 

//   $to_store_data_in_db["purpose"]!="" ){

//    $_SESSION["data_at_level_one_submit"] = $_POST;

//    header('Location:../webcam_package/webcam_view/index.php');



//   }



//   }







 

 

 

  if($to_store_data_in_db["name"]!="" &&

  $to_store_data_in_db["phone_number"]!="" && 

  

 //  $to_store_data_in_db["coming_from"]!="" && 

  $to_store_data_in_db["point_of_contact"]!="" && 

//   $to_store_data_in_db["department_to_approach"]!="" && 

  $to_store_data_in_db["vehicle_type"]!="" &&  

  $to_store_data_in_db["vehicle_number"]!=""&&  

  $to_store_data_in_db["purpose"]!="") {



  $_SESSION["data_at_level_one_submit"] = $_POST;

//   echo "submission processed";



  header('Location:webcam.php');



  

  











//    // echo '<br/>';

//    //    echo "*/*/*/*/*";



//    //    echo "at data storage";

//    //    echo '<br/>';

//    //    echo $to_store_data_in_db["purpose"];

//    //    echo '<br/>';

//    //    echo "/*/*/*/*/*";

//    //    echo '<br/>';





 

//     //saving assets into the server

//     $uploaded_file_new_name_to_save = "name_".(str_replace(" ","_",$to_store_data_in_db["name"]))."_phno_".$to_store_data_in_db["phone_number"]."_vehicle_no_".$to_store_data_in_db["vehicle_number"]."_at_".date('d_m_y_h_i_s').".jpg";//strstr($uploaded_file_name,".");

//     $image_path_to_save = '../visitor_uploaded_images/'.$uploaded_file_new_name_to_save;

//    //   echo '<br/>';

//    //   echo "from submit";

//    //   echo '<br/>';

//    //   echo $_SESSION['uniq_capture_name'];

//    //   echo '<br/>';



     

 

//     if(file_exists("../temporary_images_save/".$_SESSION["uniq_capture_name"].'.jpg')){

//       rename("../temporary_images_save/".$_SESSION["uniq_capture_name"].'.jpg',$image_path_to_save); 

//       //save file to the server and take the path to db 

//       //die("file saved from die");

//     }else{

//       //else path is null

//       //die("file not saved from die") ; 

//       $uploaded_file_new_name_to_save = "Null";    

//     }

   

    

//    //store in db function then reset the input values

//   date_default_timezone_set('Asia/Kolkata');

//     $conn = new mysqli('localhost',"root","","visitors_database_iiith");

//     if($conn->connect_error){

//        $err_at_submission = "Cannot connect to Database";

//        die(); 

//        }else{

//        $stmt = $conn->prepare("INSERT INTO  visitor_entry_details_table_new(

//        visitor_name,

//        mobile_number,

//        entry_registered_date,

//        entry_registered_time,

//        visitor_category,  

//        -- coming_from,

//        point_of_contact, 

//        poc_meet_at,

//        purpose, 

//        vehicle_type, 

//        vehicle_number,

//        image_stored_as)values(?,?,?,?,?,?,?,?,?,?,?)");

//        $stmt->bind_param("sisssssssss",

//        $to_store_data_in_db["name"],

//        $to_store_data_in_db["phone_number"],

//        date('d-m-y'),

//        date('H:i'),

//        $_POST["category"],

//        // $to_store_data_in_db["coming_from"],       

//        $to_store_data_in_db["point_of_contact"],

//        $to_store_data_in_db["department_to_approach"],

//        $to_store_data_in_db["purpose"],

//        $to_store_data_in_db["vehicle_type"],

//        $to_store_data_in_db["vehicle_number"],

//        $uploaded_file_new_name_to_save

//     );

//        $stmt->execute();

       

//        $stmt->close();

//        $conn->close();} 

       

//     //values reset because of successful submit

//     /////**************values to reset to initial state***************/////////////

//    //  $to_store_data_in_db = [];

//    //  $name= $phone_number = $point_of_contact = $department_to_approach =  $vehicle_type = $vehicle_number ="";

//    //  $vehicle_status = "false";

//    //  $category = $_POST["category"];

//    //  $image_path_to_save = "";

//    //  $name_err_msg =$phone_number_err_msg=$adhaar_num_err_message=$point_of_contact_err_msg=$department_err_msg=$vehicle_type_err_msg=$vehicle_number_err_msg=$adhaar_err_msg=$voter_id_err_msg=$pan_err_msg=$driving_license_err_msg="";

//      // $coming_from = $coming_from_err_msg= ""

//    //   unset($_POST);

//    //$_SESSION=[];

//    header('Location: ../registration_form?category='.$category);

//    $submission_status = "visitor registered Successfully";

  

  }

 

 

 }

 

  function test_input($data){

     $data = trim($data);

     $data = htmlspecialchars($data);

     return $data;

  };

 

 ?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Document</title>
</head>
<body>
   <script>
window.history.pushState(null, '', document.URL);

console.log(document.URL);



window.addEventListener('popstate', function(event) {

  window.location.href = "https://ims-dev.iiit.ac.in/visitors/index.php"

});
</script>
</body>
</html>











