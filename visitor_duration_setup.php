<?php
if(isset($_POST["save_button"])){

  echo "post admitted";

  //var_dump($_POST);





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
    
     // echo "at individual visitor insertion";
	  
	  $sql = "UPDATE mast_lookup SET num2 = ".$_POST["ind_dur"]." WHERE lookcode LIKE 'Individual_Visitor' ";
	  
	   if(!$result = mysqli_query($conn,$sql)){

        die("query error problem".mysqli_error($conn));

    }
     
    
  };

  if(isset($_POST["cab_dur"])){
    
      //echo "at cab visitor insertion";
     // echo $_POST["cab_dur"];
	  
	  $sql = "UPDATE mast_lookup SET num2  = ".$_POST["cab_dur"]." WHERE lookcode LIKE 'Cab_Visitor' ";
	  
	   if(!$result = mysqli_query($conn,$sql)){

        die("query error problem".mysqli_error($conn));

    }


      
//       $stmt = $conn->prepare("INSERT INTO victor_durashan(category, duration) VALUES (?,?)");
// $stmt->bind_param("si", "cab", $_POST["cab_dur"]);

// $stmt->execute();
    
  };
  
  
  if(isset($_POST["del_dur"])){
   

      //echo "at delivery visitor insertion";
	  
	  
	  $sql = "UPDATE mast_lookup SET num2 = ".$_POST["del_dur"]."  WHERE lookcode LIKE 'Delivery_Visitor' ";
	  
	   if(!$result = mysqli_query($conn,$sql)){

	   die("query error problem".mysqli_error($conn));}


     
    

  };
  if(isset($_POST["oth_dur"])){
    

      //echo "at other visitor insertion";
	  
	  
	  
	   $sql = "UPDATE mast_lookup SET num2 = ".$_POST["oth_dur"]." WHERE lookcode LIKE 'Other_Visitors'";
	  
	   if(!$result = mysqli_query($conn,$sql)){

        die("query error problem".mysqli_error($conn));


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



echo "from visitor duration setup";



}
?>