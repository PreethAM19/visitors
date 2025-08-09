<?php

include("controller.php");

// $start_timer = false;

if(isset($_GET["category"])){

    $category = $_GET["category"];

 };

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

     <link rel="stylesheet" href="visitor_entry_form.css">

     <title><?php echo  ucwords(str_replace("_"," ",$category));?> Entry Form</title>

 </head>  

 <body>

 <div class="container-fluid">

     <?php require_once 'top_logo_title_header.php';

     

     ?>    

     <div class="row">

         <div class="col-12 ">

             <div class="form-container">

             <form method="post"  action= "<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" enctype="multipart/form-data" > <!--<?php // echo htmlspecialchars($_SERVER["PHP_SELF"]);?>-->

                 <h1 class="form-header"><?php echo  ucwords(str_replace("_"," ",$category));?> Entry Registration</h1>

                 <p class="success-message"><?php echo $submission_status?></p>

                 <p class="failed-message"><?php echo $err_at_submission?></p>

                 <div class="d-flex flex-row justify-content-between" >

 

                 <input type="hidden" value="<?php echo $data_in_ls_with_key?>" id="dataKeyInput" name="data_key_input"/>

                 <!-- <div class="mb-3 input-box">

                     <label for="regisDate">Date</label>

                     <input type="date" class="input-text-field " id="regisDate" name="regis_date" value="<?php echo date("Y-m-d")?>"/>

                 </div>

                     <div class="mb-3 input-box" >

                     <label for="regisTime">Time</label>

                     <input type="time" class="input-text-field " id="regisTime" name="regis_time" value='<?php date_default_timezone_set("Asia/Kolkata") ;echo date("H:i");?>' min="14:20" readonly="readonly"/>

                     </div> -->

 



               <?php  if($category==$category_constants["cab"]){?>

                 <div id="cabPickDropChecks">

                 <p>Select Pick or Drop</p>

                 <div class="mb-3">

                     <input type="radio" name="purpose" id="pick"  value="pick" class="radio" <?php if($purpose=="pick"){ echo 'checked';}else{echo "";};?> />

                     <label for="pick">Pick</label>

                     <input type="radio" name="purpose" id="drop" value="drop" class="ml-2 radio" <?php if($purpose=="drop"){ echo 'checked';}else{echo "";}; ?>/>

                     <label for="drop">Drop</label>

                     <br/>

                     <p id="pickOrDropErrMsg" class="error-message"><?php echo $pick_or_drop_err_msg ?></p>

                 </div>

                 

                 </div>

                 <?php ;}; ?>

                 

                 </div> 

                 

                 

                 <div id="cabServiceSelector">

                 <label>Service Name</label>

                 <select id="serviceNameSelect" class="select-field mb-3" name="cab_service_name" >

                     <option value="uber"  <?php if($cab_service_name == "uber"){ echo 'selected';}else{echo "";} ?>>Uber</option >

                     <option value="ola" <?php if($cab_service_name == "ola"){ echo 'selected';}else{echo "";} ?>>Ola</option>

                     <option value="rapido" <?php if($cab_service_name == "rapido"){ echo 'selected';}else{echo "";} ?>>Rapido</option>

                     <option value = "other" <?php if($cab_service_name == "other") {echo 'selected'; }else{echo "";}?>>Other</option> 

                 </select>

                 </div>

 

                 <div class="mb-3 input-box hide" id="otherServiceNameContainer">

                     <label for="otherServiceName">Other Service Name</label>

                     <input type="text" class="input-text-field " placeholder="Enter Name" id="otherServiceName" name="other_service_name" value='<?php echo $other_service_name?>'/>

                     <p id="otherServiceNameErrMsg" class="error-message"><?php echo $other_service_name_err_msg; ?></p>

                 </div>

 

                 <div class="mb-3 input-box" id="nameContainer">

                     <label for="name"><?php if($category==$category_constants["visitor"]||$category==$category_constants["delivery"]){echo 'Name';}else{echo 'Service Name';};?></label>

                     <input type="text" class="input-text-field " placeholder="Enter Name" id="name" name="name" value='<?php echo $name ?>'/>

                     <p id="nameErrMsg" class="error-message"><?php echo $name_err_msg; ?></p>

                 </div>
				 
				 <!--Added on 01/30 by Preetham-->
				 
				  <?php  if($category==$category_constants["delivery"]){?>

                    <div class="mb-3 input-box" id="delServContainer">

                     <label for="delService">Service Type</label>

                     <!-- <input type="text" class="input-text-field " placeholder="Enter Name" id="delService" name="del_service" value='<?php echo $del_service ?>'/> -->
                     <select id="delService" class="select-field mb-3" name="del_service" placeholder="Type of Delivery">
                    </select>


                    <!-- <option value="Amazon"  <?php if($del_service == "Amazon"){ echo 'selected';}else{echo "";} ?>>Amazon</option >
 -->

                     </div> 


                    <?php ;}; ?>

 

 <?php if(($category==$category_constants["visitor"])||($category==$category_constants["delivery"])||($category==$category_constants["other_services"])){?>

                 <div class="mb-3 input-box">

                     <label for="phoneNumber">Mobile Number</label>

                     <input type="text" class="input-text-field " id="phoneNumber" placeholder="Mobile Number" name="phone_number" value='<?php echo $phone_number ?>'/>

                     <p id="phoneNumberErrMsg" name="phone_number_err_msg" class="error-message"><?php echo $phone_number_err_msg; ?></p><!--phone_number_err_msg-->

                 </div>

                 <?php ;}; ?>

 

 

                 <?php if($category==$category_constants["visitor"]){?>

 

                 <!-- </div>       -->

                 <div id="noOfPeopleCont">

                 <label>No. of People</label>

                 <select id="noOfPeople" class="select-field mb-3" name="no_of_people" style="width:70px;" >

                     <option value="1"  <?php if($no_of_people == "1"){ echo 'selected';}else{echo "";} ?>>1</option >

                     <option value="2" <?php if($no_of_people == "2"){ echo 'selected';}else{echo "";} ?>>2</option>

                     <option value="3" <?php if($no_of_people == "3"){ echo 'selected';}else{echo "";} ?>>3</option>

                     <option value = "4" <?php if($no_of_people == "4") {echo 'selected'; }else{echo "";}?>>4</option> 

                     <option value = "5" <?php if($no_of_people == "5") {echo 'selected'; }else{echo "";}?>>5</option> 

                     <option value = "6" <?php if($no_of_people == "6") {echo 'selected'; }else{echo "";}?>>6</option> 

                 </select>

                 </div>

                 <?php ;}?>

 

                 <!-- <?php // if($category==$category_constants["visitor"]){echo '<div class="mb-3 input-box">

                     // <label for="ComingFrom">Coming From</label>

                     // <input type="text" class="input-text-field" id="ComingFrom" name="coming_from" placeholder="Coming From"  value='.$coming_from.'>

                     // <p id="ComingFromErrMsg" name="coming_from_err_msg" class="error-message">'.$coming_from_err_msg.'</p>

                 // </div>';}; ?> -->

 <!-- important -->

 

 <?php if(($category!=$category_constants["visitor"])||($category!=$category_constants["delivery"])||($category!=$category_constants["cab"])){?>                        

 <div id="chosingDepartment">  

                <p>Select the campus area department</p>

                <div class="mb-3">

                    <input type="radio" name="campus_area_department" id="iiith"  value="iiith" class="radio" <?php if($campus_area_department=="iiith"){ echo 'checked';}else{echo "";};?> />

                    <label for="iiith">IIITH</label>

                    <input type="radio" name="campus_area_department" id="cie" value="cie" class="ml-2 radio" <?php if($campus_area_department=="cie"){ echo 'checked';}else{echo "";}; ?>/>

                    <label for="cie">CIE</label>

                   <input type="radio" name="campus_area_department" id="fsq" value="fsq" class="ml-2 radio" <?php if($campus_area_department=="fsq"){ echo 'checked';}else{echo "";}; ?>/>

                    <label for="fsq">FSQ</label>

                </div>

                </div> 

                <?php ;};?>  

 

 

                 <!-- important -->

                <?php if(($category==$category_constants["visitor"])||($category==$category_constants["delivery"])||($category==$category_constants["cab"])){?>

                 <div class="mb-3 input-box">

                     <label for="PointofContact">Whom to Meet</label>

                     <select type="text" class="input-text-field" id="PointofContact" name="point_of_contact" placeholder="Person to Meet"  value='<?php echo $point_of_contact ?>'></select>

                     <p id="PointofContactErrMsg" name="point_of_contact_err_msg" class="error-message"><?php echo $point_of_contact_err_msg?></p>

                 </div>
				 
				 <!-- Added by Preetham -1/14/23 -->
				 
				                 <div class="mb-3 input-box hide" id="otherNameContainer">



                     <label for="otherName">Other</label>



                     <input type="text" class="input-text-field " placeholder="Enter Name" id="otherName" name="other_name" value='<?php echo $other_name;?>'/>



                     <p id="otherNameErrMsg" class="error-message"><?php echo $other_name_err_msg; ?></p>



                 </div>



                 <!--<div class="mb-3 input-box hide" id="otherAddressContainer">



                     <label for="otherAddress">Student/Faculty Address</label>-->

<!-- here-->

                     <!--<input type="text" class="input-text-field " placeholder="Enter Address" id="otherAddress" name="other_address" value='<?php echo $other_address;?>'/>-->
	

<!-- here-->	
					 
				<!--	<select id="otherAddress" class="select-field mb-3" name="other_address" placeholder="Enter Location">-->
				
<!-- here-->	

					<!--changed on 1/30 by Preetham-->

                    <!-- <option value="Palash Nivas"  <?php if($other_address == "Palash Nivas"){ echo 'selected';}else{echo "";} ?>>Palash	Nivas</option >



                     <option value="Palash Block D"  <?php if($other_address == "Palash Block D"){ echo 'selected';}else{echo "";} ?>>Palash Block D</option >
					 

                     <option value="Palash Block E"  <?php if($other_address == "Palash Block E"){ echo 'selected';}else{echo "";} ?>>Palash Block E</option >
					 

                     <option value="Kadamba Nivas"  <?php if($other_address == "Kadamba Nivas"){ echo 'selected';}else{echo "";} ?>>Kadamba Nivas</option >
					 

                     <option value="Parijaat Nivas"  <?php if($other_address == "Parijaat Nivas"){ echo 'selected';}else{echo "";} ?>>Parijaat Nivas</option >
					 

                     <option value="Bakul Nivas"  <?php if($other_address == "Bakul Nivas"){ echo 'selected';}else{echo "";} ?>>Bakul Nivas</option >
					 

                     <option value="Nilgiri Block"  <?php if($other_address == "Nilgiri Block"){ echo 'selected';}else{echo "";} ?>>Nilgiri Block</option >
					 

                     <option value="Vindhya Block"  <?php if($other_address == "Vindhya Block"){ echo 'selected';}else{echo "";} ?>>Vindhya Block</option >
					 

                     <option value="Admin Block"  <?php if($other_address == "Admin Block"){ echo 'selected';}else{echo "";} ?>>Admin Block</option >
					 

                     <option value="Ananda Nivas"  <?php if($other_address == "Ananda Nivas"){ echo 'selected';}else{echo "";} ?>>Ananda Nivas</option >
					 

                     <option value="Budha Nivas"  <?php if($other_address == "Budha Nivas"){ echo 'selected';}else{echo "";} ?>>Budha Nivas</option >
					 

                     <option value="North Mess/South Mess"  <?php if($other_address == "North Mess/South Mess"){ echo 'selected';}else{echo "";} ?>>North Mess/South Mess</option >
					 

                     <option value="Kadamba Mess"  <?php if($other_address == "Kadamba Mess"){ echo 'selected';}else{echo "";} ?>>Kadamba Mess</option >
					 

                     <option value="Data Center"  <?php if($other_address == "Data Center"){ echo 'selected';}else{echo "";} ?>>Data Center</option >
					 

                     <option value="Faculty Quarters"  <?php if($other_address == "Faculty Quarters"){ echo 'selected';}else{echo "";} ?>>Faculty Quarters</option >-->





<!--here-->

            <!--   </select>
					 



                     <p id="otherAddressErrMsg" class="error-message"><?php echo $other_address_err_msg; ?></p>



                 </div>-->
				 
				 
                 <div id="otherAddressContainer" style="display: flex; flex-wrap: wrap; justify-content:between;">

                 <div  class="mb-3 input-box w-50">
                     <label for="otherAddress">Student/Faculty Address</label>



                     <!--<input type="text" class="input-text-field " placeholder="Enter Address" id="otherAddress" name="other_address" value='<?php echo $other_address;?>'/>-->
					 
					 
					<select id="otherAddress" class="select-field mb-3" name="other_address" ></select>
					 



                     <p id="otherAddressErrMsg" class="error-message"><?php echo $other_address_err_msg; ?></p>

                     </div>

                    <div class="mb-3 input-box w-50">

                    <label for="otherRoomNo">Room/Flat No.</label>

                     <input type="text" class="input-text-field " placeholder="Enter Room no" id="otherRoomNo" name="other_room" value='<?php echo $other_room;?>'/>



                 </div>



                

                 </div>
				 





                 <?php ;}; ?>



                 

 

                 <?php //if($category== "visitor"){?>

                 <!-- <div class="mb-3 input-box">

                     <label for="DepartmentToApproach"><?php if($category==$category_constants["visitor"]){echo 'Meeting Person Department/Campus Area ';}else {echo 'Service Acquirer Department/Campus Area';};?> </label>

                     <input type="text" class="input-text-field" id="DepartmentToApproach" name="department_to_approach"  placeholder="Department" value='<?php echo $department_to_approach ?>'/>

                     <p id="DepartmentFromErrMsg" name="department_err_msg" class="error-message"><?php echo $department_err_msg ?></p>

                 </div><?php //;}?> -->

 

                 

                 <?php  if($category==$category_constants["visitor"]||$category==$category_constants["other_services"]){?>



                 <div class="mb-3 input-box">



                     <label for="purpose">Purpose</label>



                     <input type="text" class="input-text-field" id="purpose" name="purpose" placeholder="Enter Purpose of your visit"  value='<?php echo $purpose ?>'  >



                     <p id="purposeErrMsg" name="purpose_err_msg" class="error-message"><?php echo $purpose_err_msg ?></p>



                 </div><?php ;}; ?>



                 

                 <?php  if($category==$category_constants["other_services"]){?>



                 <div class="mb-3 input-box">



                     <label for="vendor">Vendor</label>



                     <input type="text" class="input-text-field" id="vendor" name="vendor" placeholder="Enter Vendor of your visit"  value='<?php echo $vendor ?>'  >



                     <p id="vendorErrMsg" name="vendor_err_msg" class="error-message"><?php echo $vendor_err_msg ?></p>



                 </div><?php ;}; ?>

 

                 <!-- <?php //  if($category==$category_constants["cab"]){?>

                 <div id="cabPickDropChecks">

                 <p>Select Pick or Drop</p>

                 <div class="mb-3">

                     <input type="radio" name="purpose" id="pick"  value="pick" class="radio" <?php if($purpose=="pick"){ echo 'checked';}else{echo "";};?> />

                     <label for="pick">Pick</label>

                     <input type="radio" name="purpose" id="drop" value="drop" class="ml-2 radio" <?php if($purpose=="drop"){ echo 'checked';}else{echo "";}; ?>/>

                     <label for="drop">Drop</label>

                 </div>

                 </div>

                 <?php // ;}; ?> -->

 

                 <div>

                 <div id="vehicleStatusAskContainer">

                 <p>In by Any Vehicle ?</p>

                 <div class="mb-3">

                     <input type="radio" name="vehicle_status" id="vehicleStatusYes"  value="true" class="radio" <?php if(isset($vehicle_status) && $vehicle_status == "false"){ echo '';}else{echo "checked";};?> />

                     <label for="vehicleStatusYes">Yes</label>

                     <input type="radio" name="vehicle_status" id="vehicleStatusNo" value="false" class="ml-2 radio" <?php if(isset($vehicle_status) && $vehicle_status == "true"){ echo '';}else{echo "checked";} ?>/>

                     <label for="vehicleStatusNo">No</label>

                 </div>

                 </div>

                 <div id="vehicleDetailsContainer">

                 <div class="mb-3 input-box">

                     <label for="vehicleType">Vehicle Type</label>

                     <select type="text" class="input-text-field" id="vehicleType" name="vehicle_type" placeholder="Car/Bike etc.."  <?php if(isset($vehicle_status) && $vehicle_status == "false"){ echo 'true';}?>   value='<?php echo $vehicle_type ?>'></select>

                     <p id="vehicleTypeErrMsg" name="vehicle_type_err_msg" class="error-message"><?php echo $vehicle_type_err_msg?></p>

                 </div>                

                 <div class="mb-3 input-box" >

                     <label for="vehicleNumber">Vehicle Number</label>

                     <input type="text" class="input-text-field" id="vehicleNumber" name="vehicle_number" placeholder="Vehicle Number"  <?php if(isset($vehicle_status) && $vehicle_status == "false"){ echo 'true';}?>  value='<?php echo $vehicle_number ?>'/>

                     <p id="vehicleNumberErrMsg" name="vehicle_number_err_msg" class="error-message"><?php echo $vehicle_number_err_msg?></p>

                 </div>

                 </div>

                 </div>

                 <!-- <button onClick="Mywindow=window.open('../webcam_package/webcam_view/index.php?', 'MyWindow',width=600, height=600); return false;" class="image_capture_button mr-5">Take Photo <img src="../images/6373895.png" class="w-10 h-100"/></button>  -->

 <!--                 

 

                 <div class="mb-3 input-box" >

                     <label for="visitorImageFile">Image</label>

                     <input type="file" class="input-text-field" id="visitorImageFile" name="uploaded_file_array"  value='<?php // echo $uploaded_file_array ?>' accept="image/*,.jpg,.jpeg,.png"/>

                     <p id="visitorImageErrMsg" name="visitor_image_err_msg" class="error-message"><?php //echo $visitor_image_err_msg?></p>

                 </div> -->

                 <input type="hidden" name="category" value='<?php echo $category?>'>

                 <!-- <button type="submit" class="btn btn-primary">Submit</button> -->

                 <input type="submit" name="next_on_page_one" class="button" value="Next" />

             </form>

 

 </div>
 
 <!-- Added 0n 1/30 by Preetham-->
 
 <!-- Include Selectize.js and its CSS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.14.0/css/selectize.bootstrap3.min.css">
   
    <script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.14.0/js/standalone/selectize.min.js"></script>

             <script type="text/javascript">

                 let name = document.getElementById("name");

                 let nameErrMsg = document.getElementById("nameErrMsg")

                 let phoneNumber = document.getElementById("phoneNumber")

                 let phoneNumberErrMsg = document.getElementById("phoneNumberErrMsg")

                 // let ComingFrom = document.getElementById("ComingFrom")

                 // let ComingFromErrMsg = document.getElementById("ComingFromErrMsg")

                 let PointofContact = document.getElementById("PointofContact")

                 let PointofContactErrMsg= document.getElementById("PointofContactErrMsg")

                 //let DepartmentToApproach = document.getElementById("DepartmentToApproach")

                 //let DepartmentFromErrMsg= document.getElementById("DepartmentFromErrMsg")

                 let adhaarNumberCardContainer = document.getElementById("adhaarNumberCardContainer")

                 let voterIdNumberContainer = document.getElementById("voterIdNumberContainer")

                 let panNumberContainer = document.getElementById("panNumberContainer")

                 let drivingLicenseContainer = document.getElementById("drivingLicenseContainer")

                 let vehicleStatusYes = document.getElementById("vehicleStatusYes")

                 let vehicleStatusNo = document.getElementById("vehicleStatusNo")

                 let vehicleType = document.getElementById("vehicleType")

                 let vehicleTypeErrMsg = document.getElementById("vehicleTypeErrMsg")

                 let vehicleNumber = document.getElementById("vehicleNumber")

                 let vehicleNumberErrMsg = document.getElementById("vehicleNumberErrMsg")

                 // let visitorImageFile = document.getElementById("visitorImageFile");

                 // let visitorImageErrMsg = document.getElementById("visitorImageErrMsg")

                 //let regisDate = document.getElementById("regisDate");

                 let nameContainer = document.getElementById("nameContainer");
				 
				 //Added on 01/30 by preetham
				 
				let delServContainer = document.getElementById("delServContainer")

                 let delService = document.getElementById("delService")

                 let cabServiceSelector = document.getElementById("cabServiceSelector")

                 let serviceNameSelect = document.getElementById("serviceNameSelect")

                 //let regisTime = document.getElementById("regisTime");

                 let vehicleDetailsContainer = document.getElementById("vehicleDetailsContainer")

                 let vehicleStatusAskContainer = document.getElementById("vehicleStatusAskContainer")

                 let video = document.getElementById('imageCaptureVideoElement');

                 let showImageElement = document.getElementById("showImageElement")

                 let imageClickedStatus = document.getElementById("imageClickedStatus")

                 let otherServiceNameContainer = document.getElementById("otherServiceNameContainer")

                 let otherServiceName = document.getElementById("otherServiceName")
				 //Added
				 
				 let otherNameContainer = document.getElementById("otherNameContainer")



                 let otherName = document.getElementById("otherName")



                 let otherAddressContainer = document.getElementById("otherAddressContainer")



                 let otherAddress = document.getElementById("otherAddress")

                 let purpose = document.getElementById("purpose")

                 let purposeErrMsg = document.getElementById("purposeErrMsg")
				 
				 let vendor = document.getElementById("vendor")

                 let vendorErrMsg = document.getElementById("vendorErrMsg")
				 
				 //Added on 01/30- Preetham
				 
				 let otherRoomNo = document.getElementById("otherRoomNo")

                 let iiith = document.getElementById('iiith');

                 let cie = document.getElementById('cie');

                 let fsq = document.getElementById('fsq');

                 let dataKeyInput = document.getElementById("dataKeyInput")

                 let noOfPeople = document.getElementById('noOfPeople');





                // console.log(noOfPeople.value);

               



				vehiclenames = ["Two Wheeler","Three/Four Wheeler","Van","Heavy vehicles"] 

               // vehiclenames = ["Auto Rickshaw","Bike","Car","Motorcycle","Limousine","Van","Minivan","Delivery Van","Trailer","Caravan","Minibus","Truck","Lorry","Tow Truck","Tractor","Bulldozer","Crane","Police Car","Ambulance","School Bus","Fire Engine","Concrete Mixer Truck / Cement Mixer Truck","Dumper Truck","Scooty","Bike / Motorcycle"]

                vehiclenames.sort();





            <?php
/*			if($category==$category_constants["visitor"]){?>

                vehiclenames = ["Auto Rickshaw","Bike","Car","Motorcycle","Scooter","Bike / Motorcycle"];

                <?php }?>

                <?php if($category==$category_constants["cab"]){?>

                    vehiclenames = ["Auto Rickshaw","Bike","Car","Motorcycle","Scooter","Bike / Motorcycle"];

                    <?php }?>



                    <?php if($category==$category_constants["delivery"]){?>

                        vehiclenames = ["Auto Rickshaw","Bike","Car","Motorcycle","Scooter","Bike / Motorcycle"];

                        <?php }?>



                        <?php if($category==$category_constants["other_services"]){?>

                            vehiclenames = ["Auto Rickshaw","Bike","Car","Motorcycle","Scooter","Limousine","Van","Minivan","Delivery Van","Trailer","Caravan","Minibus","Truck","Lorry","Tow Truck","Tractor","Bulldozer","Crane","Police Car","Ambulance","School Bus","Fire Engine","Concrete Mixer Truck / Cement Mixer Truck","Dumper Truck","Scooty","Bike / Motorcycle"];

                            <?php }*/?>





                 console.log(dataKeyInput.value)



                 let countForFirstChoiceSelection = 0;



                 creatingWtmOptions=(each)=>{

                    let option = document.createElement("option");

                    option.text = each;

                    option.value=each;

                    console.log(each);

                    

                    PointofContact.add(option);

                 }





                



               



            <?php if(($category==$category_constants['visitor'])||($category==$category_constants['delivery'])||($category==$category_constants["cab"])){?>



                <?php if($campus_area_department=="cie"){?>

                        while(PointofContact.hasChildNodes()){

                        PointofContact.removeChild(PointofContact.firstChild)

                    }

                    for (let each of ('<?php echo implode(",",$wtmoptions['cie'])?>'.split(",")).sort()){

                        creatingWtmOptions(each)

                        if(each=='<?php echo $point_of_contact?>'){

                            PointofContact.value=each;

                        }

                    }

                        <?php }?>







                 <?php if($campus_area_department=="iiith"){?>

                    while(PointofContact.hasChildNodes()){

                        PointofContact.removeChild(PointofContact.firstChild)

                    }

                    for (let each of ('<?php echo implode(",",$wtmoptions['iiith'])?>'.split(",")).sort()){

                        creatingWtmOptions(each)

                        if(each=='<?php echo $point_of_contact?>'){

                            PointofContact.value=each;

                        }

                    }

                    <?php }?>

                        <?php if($campus_area_department=="fsq"){?>

                        while(PointofContact.hasChildNodes()){

                        PointofContact.removeChild(PointofContact.firstChild)

                    }

                    for (let each of ('<?php echo implode(",",$wtmoptions['fsq'])?>'.split(",")).sort()){

                        creatingWtmOptions(each)

                        if(each=='<?php echo $point_of_contact?>'){

                            PointofContact.value=each;

                        }

                    }

                        <?php }?>



                    <?php ;};?>





                 for (let each of vehiclenames){

                    let option = document.createElement("option");

                    option.text = each;

                    option.value=each;

                    vehicleType.add(option)



                   if(each ==  "<?php echo $vehicle_type?>"){

                    vehicleType.value=each                                        

                 }

                 }



                 <?php if(($category==$category_constants["visitor"])||($category==$category_constants["delivery"])||($category==$category_constants["cab"])){?>                        



                 iiith.addEventListener('change',function(event){

                    if(iiith.value=="iiith"){

                    while(PointofContact.hasChildNodes()){

                        PointofContact.removeChild(PointofContact.firstChild)

                    }

                    for (let each of ('<?php echo implode(",",$wtmoptions['iiith'])?>'.split(",")).sort()){

                        creatingWtmOptions(each)

                        if(each=='<?php echo $point_of_contact?>'){

                            PointofContact.value=each;

                        }

                    }}

                })



                cie.addEventListener('change',function(event){

                    if(cie.value=="cie"){

                    while(PointofContact.hasChildNodes()){

                        PointofContact.removeChild(PointofContact.firstChild)

                    }



                    for (let each of ('<?php echo implode(",",$wtmoptions['cie'])?>'.split(",")).sort()){

                        creatingWtmOptions(each)

                    }

                }

                   

                })

                fsq.addEventListener('change',function(event){

                    if(fsq.value=="fsq"){

                    while(PointofContact.hasChildNodes()){

                        PointofContact.removeChild(PointofContact.firstChild)

                    }

                    for (let each of ('<?php echo implode(",",$wtmoptions['fsq'])?>'.split(",")).sort()){

                        creatingWtmOptions(each)

                    }}



                })



                <?php ;};?>





 

                 <?php if($category==$category_constants["visitor"]||$category==$category_constants["other_services"]){?>

                 purpose.addEventListener("keypress",function(){

                     purposeErrMsg.textContent = ""

                     if(event.key=="Enter"){

                     alert("please press submit to submit the form")

                     event.preventDefault()

                    }

                 })

 

                 purpose.addEventListener("blur",function(){

                     if(purpose.value==""){

                         purposeErrMsg.textContent = "Please give your purpose"

                     }else{

                         purposeErrMsg.textContent = ""

                     }

                 })

                 <?php ;};?>
				 



                 <?php if($category==$category_constants["other_services"]){?>



                 vendor.addEventListener("keypress",function(){



                     vendorErrMsg.textContent = ""



                     if(event.key=="Enter"){



                     alert("please press submit to submit the form")



                     event.preventDefault()



                    }



                 })



 



                 vendor.addEventListener("blur",function(){



                     if(vendor.value==""){



                         vendorErrMsg.textContent = "Please provide vendor details"



                     }else{



                         vendorErrMsg.textContent = ""



                     }



                 })



                 <?php ;};?>

 

               

               

             <?php if($category==$category_constants['cab']){?>

                 cabServiceSelector.classList.remove("hide")

                 nameContainer.classList.add("hide")

                 // name.value=serviceNameSelect.value

                 <?php  }else{?>

                 cabServiceSelector.classList.add("hide")

                 nameContainer.classList.remove("hide")

                 <?php };?>

 

 

                 serviceNameSelect.addEventListener("change",function()

                 {  console.log("change occured")

                     

                     if(serviceNameSelect.value=="other"){

                     //show name field

                     otherServiceNameContainer.classList.remove("hide")

                 }else{

                     // name.value=serviceNameSelect.value

                     otherServiceNameContainer.classList.add("hide")

                 }

             })

                 

 

                 <?php if($category!=$category_constants['cab']){?>

                     nameContainer.classList.remove("hide")

                     cabServiceSelector.classList.add("hide")

                     <?php  }else{?>

                         nameContainer.classList.add("hide")

                         <?php };?>

 

                 if(serviceNameSelect.value == "other"){

                     otherServiceNameContainer.classList.remove("hide") 

                     

 

                 }else{otherServiceNameContainer.classList.add("hide")}

 

                 otherServiceName.addEventListener('change',function(){

                     console.log("other service change occured")

                 })

 

 

 

             //     let showCurrentTime  // ******initialization do not erase******        

             //     function startClock(){

             //      showCurrentTime = setInterval(()=>{

             //         var currentDateAndTime = (new Date())

             //         regisTime.value =((currentDateAndTime.toLocaleTimeString()).slice(0,-3))

                                       

             //         console.log( regisTime.value)

                     

             //         if ((currentDateAndTime.toLocaleTimeString()).slice(0,-3) == "00:00"){

             //             month = '' + (currentDateAndTime.getMonth() + 1),

             //             day = '' + currentDateAndTime.getDate(),

             //             year = currentDateAndTime.getFullYear()

             //             if (month.length < 2) {

             //              month = '0' + month;}

             //                 if (day.length < 2){

             //                        day = '0' + day;}

             //         regisDate.value = (year+"-"+month+"-"+day)

             //         }

             //     },1000);

             // }

 

             // startClock()

 

 

             // function stopClock(){

             //     clearInterval(showCurrentTime)

             // }

             //     function getRequiredDateFormat(currentDateAndTime){

             //     month = '' + (currentDateAndTime.getMonth() + 1),

             //             day = '' + currentDateAndTime.getDate(),

             //             year = currentDateAndTime.getFullYear()

             //             if (month.length < 2) {

             //              month = '0' + month;}

             //             if (day.length < 2){

             //             day = '0' + day;}

             //         return year+"-"+month+"-"+day

             //         }

 

             //     // todayDate = year+"-"+month+"-"+day

             //     todayDate = getRequiredDateFormat(new Date())

                

 

             //     regisDate.setAttribute("min",todayDate)

 

 

             //     let max_date = new Date()

             //     max_date.setDate(max_date.getDate()+90)

 

                 

             //     regisDate.setAttribute("max",max_date)

 

             //     max_date = getRequiredDateFormat(max_date)

 

             //     regisDate.setAttribute("max",max_date)

                 

                

             //     regisDate.addEventListener("change",function(){

             //         if(regisDate.value == ""){

             //             regisDate.value = getRequiredDateFormat(new Date())

             //         }

             //         stopClock()

             //         regisTime.removeAttribute("readonly","readonly")

             //         if(regisDate.value == getRequiredDateFormat(new Date()) ){

             //             startClock()

             //             regisTime.setAttribute("readonly","readonly")

             //         }

             //     })

 

                 

 

 

             //     regisTime.addEventListener("change", function(){

             //         console.log("changing time")

                     

             //         if(regisDate.value!=getRequiredDateFormat(new Date())){

             //             stopClock()

             //         }else if(regisDate.value==getRequiredDateFormat(new Date())){

             //             console.log("today date")

             //             console.log((regisTime.value).split(":"))

             //             console.log()                        

             //         }

                     

             //     })





             //*************************************************************************************************************** */

                 

                //  function generate_remove_error_message(event){

                //      let errorElement

                //      let errorMessage

                //      switch(event.target.id){

                //          case("ComingFrom"):

                //          errorElement = ComingFromErrMsg

                //          errorMessage = "Please Refer Your Place/Organization Coming From"

                //          break;

                //         //  case("DepartmentToApproach"):

                         

                //         //  errorElement = DepartmentFromErrMsg

                //         //  errorMessage ="Please Enter Which department meeting person/reference belongs to"

                //         //  break;

                //         //  

                //          default:null;

                //      }

                //      if(event.target.value==="" && event.type==="blur"){

                //          errorMessageOnErrorElementEmptyBlur(errorElement, errorMessage)}

                //  }

                //*************************************************************************************************************** */                             

                 function validFirstLastName(name){

                     let regex = RegExp( /^[a-zA-Z]+([.]?( )?[a-zA-Z])+$/)

                     return regex.test(name)

                 }

                 

                 name.addEventListener("blur",function(){

                     if(name.value==""){

                        //let errorText = `Please enter ${<?php  //if($category==$category_constants["visitor"]){?> "your Name"<?php //  ;}else{?>"the service name"<?php //};?>}`

                        <?php  if($category==$category_constants["visitor"]||$category==$category_constants["delivery"]){?>

                         nameErrMsg.textContent="Please enter your Name"

                         <?php  ;}else{?>

                             nameErrMsg.textContent="Please enter the Service Name"

 

                             <?php }?>

                     }else if(!validFirstLastName(name.value)){

                         nameErrMsg.textContent="Enter a Valid Name eliminate any excessive spaces or any other special characters in the name"

                     }else{

                         nameErrMsg.textContent = ""

                     }

                 })

                       

                 function isValidPhoneNumber(number){

                     let regex = new RegExp(/^[6-9]{1}[0-9]{9}$/)

                         return (regex.test(number));

                 }

                 <?php if(($category==$category_constants["visitor"])||($category==$category_constants["delivery"])||($category==$category_constants["other_services"])){?>

                 phoneNumber.addEventListener("blur",function(){

                     if(phoneNumber.value==""){

                         phoneNumberErrMsg.textContent="Please give your Phone Number"

                     }

                     else if(!isValidPhoneNumber(phoneNumber.value)){

                         phoneNumberErrMsg.textContent="Please Enter a Valid Mobile Number"

                         }

                     else{

                         phoneNumberErrMsg.textContent = ""

                     }

                 })

                 <?php ;};?>

 

                 <?php //if($category == $category_constants["visitor"]){?>

                //  DepartmentToApproach.addEventListener("blur",function(){

                //      if(DepartmentToApproach.value==""){

                //          DepartmentFromErrMsg.textContent = "Please Enter Which department person to meet belongs to"

                //      }else{

                //          DepartmentFromErrMsg.textContent = ""

                //      }

                //  })<?php //;};?>

 

 

 

                //  PointofContact.addEventListener("blur",function(){

                //      if(PointofContact.value==""){

                //          PointofContactErrMsg.textContent="Please Enter your Person to Meet at Institute"

                //      }else if(!validFirstLastName(PointofContact.value)){

                //          PointofContactErrMsg.textContent="Enter a Valid Name eliminate any excessive spaces or any other special characters in the name"

                //      }else{

                //          PointofContactErrMsg.textContent = ""

                //      }

                //  })

                 // blur event added to all the text fields in form end

 

                 

                 name.addEventListener("keypress",function(event){ 

                     nameErrMsg.textContent = "";                    

 

                    if((event.keyCode>64&&event.keyCode<91)||(event.keyCode>96&&event.keyCode<123)||(event.keyCode==32)||(event.keyCode==46)) {

                     

                     name.value = event.target.value

                     nameErrMsg.textContent = ""

                    }else{

                     event.preventDefault()                   

                     nameErrMsg.textContent = "Please Enter a Valid Name";}

                 

                    if(event.key=="Enter"){

                     alert("please press submit to submit the form")

                    }

                 });

 

                 <?php if(($category==$category_constants["visitor"])||($category==$category_constants["delivery"])||($category==$category_constants["other_services"])){?>

                         

                 phoneNumber.addEventListener("keypress",function(event){

                     phoneNumberErrMsg.textContent = "";

                     

                      if(event.keyCode>47 && event.keyCode<58){

                         phoneNumberErrMsg.textContent = ""                         

                         phoneNumber.value = event.target.value

                     }else{  

                         event.preventDefault()                                            

                         phoneNumberErrMsg.textContent = "Enter a valid Phone Number"}

                     

                     if(phoneNumber.value.length>=10){

                         event.preventDefault()

                         phoneNumberErrMsg.textContent = "Can Enter Only 10 digits"                        

                     }

                     if(event.key=="Enter"){

                     alert("please press submit to submit the form")

                    }

                 })<?php ;};?>

 

 

            //  PointofContact.addEventListener("keypress",function(){

            //      PointofContactErrMsg.textContent = ""; 

 

            //      if((event.keyCode>64&&event.keyCode<91)||(event.keyCode>96&&event.keyCode<123)||(event.keyCode==32)||(event.keyCode==46)) {

            //      PointofContact.value = event.target.value

            //      PointofContactErrMsg.textContent = ""

            //      }else{

            //       event.preventDefault()                   

            //       PointofContactErrMsg.textContent = "Please Enter a Valid Name";

            //      }

            //      if(event.key=="Enter"){

            //      alert("please press submit to submit the form")

            //      event.preventDefault()

            //      }

            //      })

                 <?php //if($category == $category_constants["visitor"]){?>

                //  DepartmentToApproach.addEventListener("keypress",function(){

                //      DepartmentFromErrMsg.textContent=""

                //      if(event.key=="Enter"){

                //      alert("please press submit to submit the form")

                //      event.preventDefault()

                //     }

                //  })<?php //;};?>

 

 

 

                 vehicleNumber.addEventListener("blur",function(){

                     if(vehicleNumber.value==""){

                         vehicleNumberErrMsg.textContent="Please Enter the Vehicle Reg. No."}

                     else if(!isValidVehicleNumberPlate(vehicleNumber.value)){

                         vehicleNumberErrMsg.textContent = "Please Enter Valid Vehicle Number"

                     }else{

                         vehicleNumberErrMsg.textContent=""

                     }

                     

                 })

                 function isValidVehicleNumberPlate(NUMBERPLATE) {

                     let regex = new RegExp(/^[A-Za-z]{2}[\s]?[0-9]{1,2}(?:[\s]?[A-Za-z]+)?(?:[\s]?[a-zA-Z]*)?[\s]?[0-9]{4}$/); 

                         if (NUMBERPLATE == null) {

                             return false;

                         }

                         if (regex.test(NUMBERPLATE) == true) {

                             return true;

                         }

                         else {

                             return false;

                         }

                     }

                     vehicleNumber.addEventListener("keypress",function(){

                 if((event.keyCode>64&&event.keyCode<91)||(event.keyCode>96&&event.keyCode<123)||(event.keyCode==32)||(event.keyCode>47 && event.keyCode<58)) {                    

                     vehicleNumber.value = event.target.value

                     vehicleNumberErrMsg.textContent = ""

                    }else{

                     event.preventDefault()                   

                     vehicleNumber.textContent = "Please Enter a Valid information";

                    }                

                 if(event.key=="Enter"){

                     alert("please press submit to submit the form")

                     event.preventDefault()

                    }

             })

 

             <?php if($category==$category_constants["cab"]){?>

                     vehicleStatusYes.checked = true

                     vehicleStatusAskContainer.classList.add("hide")

 

                     otherServiceName.addEventListener("keypress",function(){

                         if(event.key=="Enter"){

                     alert("please press submit to submit the form")

                     event.preventDefault()

                    }

 

                     })

                     <?php ;};?>

 
<!--Added by Preetham 1/14/24-->
<?php if($category!==$category_constants["other_services"]){?>





                     PointofContact.addEventListener("change",function()



                 {  console.log("change occured")



                     



                     if(PointofContact.value=="*Other"){



                     //show name field



                     otherNameContainer.classList.remove("hide")



                 }else{



                     // name.value=serviceNameSelect.value



                     otherNameContainer.classList.add("hide")



                 }



             })





                        if(PointofContact.value == "*Other"){



                            otherNameContainer.classList.remove("hide") 



                            



        



                        }else{otherNameContainer.classList.add("hide")}



        



                        otherName.addEventListener("change",function(){



                            console.log("change occured")



                        })





                                    <?php if($category==$category_constants["cab"]){?>



                            vehicleStatusYes.checked = true



                            vehicleStatusAskContainer.classList.add("hide")



        



                            otherName.addEventListener("keypress",function(){



                                if(event.key=="Enter"){



                            alert("please press submit to submit the form")



                            event.preventDefault()



                            }



        



                            })



                            <?php ;};?>      





                        //////////////////////////////////  



        

                            PointofContact.addEventListener("change",function()



                        {  console.log("change occured")



                            



                            if(PointofContact.value=="*Other"){



                            //show name field



                            otherAddressContainer.classList.remove("hide")



                        }else{



                            // name.value=serviceNameSelect.value



                            otherAddressContainer.classList.add("hide")



                        }



                    })





                        if(PointofContact.value == "*Other"){



                            otherAddressContainer.classList.remove("hide") 



                            



        



                        }else{otherAddressContainer.classList.add("hide")}



        



                        otherAddress.addEventListener("change",function(){



                            console.log("change occured")



                        })





                                    <?php if($category==$category_constants["cab"]){?>



                            vehicleStatusYes.checked = true



                            vehicleStatusAskContainer.classList.add("hide")



        



                            otherAddress.addEventListener("keypress",function(){



                                if(event.key=="Enter"){



                            alert("please press submit to submit the form")



                            event.preventDefault()



                            }



        



                            })



                            <?php ;};?>



                    // <?php ;};?>
 

                 

             if(vehicleStatusYes.checked == true){

              vehicleType.removeAttribute("disabled","")

              vehicleNumber.removeAttribute("disabled","")

            vehicleDetailsContainer.classList.remove("hide")}

            if(vehicleStatusNo.checked == true){

             vehicleType.setAttribute("disabled","")

             vehicleNumber.setAttribute("disabled","")

             vehicleDetailsContainer.classList.add("hide")

            }

            

                 vehicleStatusNo.addEventListener("click",function(event){

                     vehicleDetailsContainer.classList.add("hide")

                     vehicleType.setAttribute("disabled","")

                     vehicleNumber.setAttribute("disabled","")

                     vehicleTypeErrMsg.textContent=""

                     vehicleNumberErrMsg.textContent = ""

                 })

                 vehicleStatusYes.addEventListener("click",function(event){

                    vehicleDetailsContainer.classList.remove("hide")

 

                     vehicleType.removeAttribute("disabled","")

                     vehicleNumber.removeAttribute("disabled","")

                 })

                 vehicleType.addEventListener("blur",function(){

                     if(vehicleType.value==""){

                         vehicleTypeErrMsg.textContent = "Please Enter the Vehicle Type ex:Car/Bike etc.,"

                     }else {

                         vehicleTypeErrMsg.textContent=""

                     }

                 })

                 vehicleType.addEventListener("keypress",function(event){ 

                     vehicleTypeErrMsg.textContent = ""; 

                    if(event.key=="Enter"){

                     alert("please press submit to submit the form")

                     event.preventDefault()

                    }

                 });
				 
window.history.pushState(null, '', document.URL);

console.log(document.URL);



window.addEventListener('popstate', function(event) {

  window.location.href = "https://ims-dev.iiit.ac.in/visitors/index.php"

});


<!--Added on 1/30 by Preetham-->
		//selectize.js

var $otherAddressSelectize = $('#otherAddress').selectize({
        create: true,
        sortField: 'text',
        openOnFocus: true, // Open the dropdown on input focus
        onChange: function(value) {	
            // Update the variable on change
            $other_address = value;
        }
    });

    var otherAddressOptions = [
        'Palash Nivas',
        'Palash Block D',
        'Palash Block E',
        'Kadamba Nivas',
        'Parijaat Nivas',
        'Parijaat Block A',
        'Parijaat Block B',
        'Parijaat Block C',
        'Bakul Nivas',
        'Nilgiri Block',
        'Vindhya Block',
        'Vindhya A2',
        'Vindhya A4',
        'Vindhya A6',
        'Vindhya C2',
        'Vindhya C4',
        'Vindhya C6',
        'Vindhya Canteen',
        'Himalaya Block D',
        'Admin Block',
        'Ananda Nivas',
		'Ananda Nivas Block A',
		'Ananda Nivas Block B',
		'Ananda Nivas Block C',
        'Budha Nivas',
		'Budha Nivas Block A',
		'Budha Nivas Block B',
		'Budha Nivas Block C',
        'North Mess/South Mess',
        'Kadamba Mess',
        'Data Center',
        'Old Faculty Quarters',
        'New Faculty Quarters',
		'New Faculty Quarters Block A',
		'New Faculty Quarters Block B',
		'New Faculty Quarters Block C',
		'New Faculty Quarters Block D',
		'New Faculty Quarters Block E'
    ];

    var otherAddressSelectize = $otherAddressSelectize[0].selectize;
    for (var i = 0; i < otherAddressOptions.length; i++) {
        otherAddressSelectize.addOption({value: otherAddressOptions[i], text: otherAddressOptions[i]});
    }
	
	
	//selectize.js

var $delServiceSelectize = $('#delService').selectize({
        create: false,
        sortField: 'text',
        openOnFocus: true, // Open the dropdown on input focus
        onChange: function(value) {
            // Update the variable on change
            $del_service = value;
        }
    });

    var delServiceOptions = [
        'Zomato',
        'Swiggy',
        'Rebel Food',
        'Eat Club',
        'Dominos',
        'Pizza Hut',
        'KFC',
        'Box8',
        'Dunzo InstaMart',
        'Zipto',
        'Milk Delivery',
        'Amazon',
        'Flipkart',
        'Blue Dart',
        'MARK Express Courier',
        'Maruthi Courier',
        'E com Express',
        'Delivery.com',
        'Myntra',
        'Shadow Fax',
        'JioMart',
        'Big Basket',
        'Sneha Chicken Delivery',
        'Fth Chicken Delivery',
        'Licious',
        'Food Panda',
        'Faasos',
        'Supr',
        'Zepto',
        'Pickily',
        'EatFit',
        'BlinkIt',
        'FedEx',
        'XpressBees',
        'Porter',
        'Gati'
    ];

    var delServiceSelectize = $delServiceSelectize[0].selectize;
    for (var i = 0; i < delServiceOptions.length; i++) {
        delServiceSelectize.addOption({value: delServiceOptions[i], text: delServiceOptions[i]});
    }




                </script>

</body>

</html>