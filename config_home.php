<?php 

// give the time in minutes ie if for 1 hr 60 minutes or 2 hr 120 minutes only give number like example below;

// $individual_visitor_visiting_duration =  6; //for six minutes;

// $cab_visitor_visiting_duration =  6; //for six minutes

// $delivery_visitor_visiting_duration =  6; //for six minutes

// $other_sources_visitor_visiting_duration =  6; //for six minutes

$conn = new mysqli('localhost',"root","","visitors_database_iiith");

    if(!$conn){

       $err_at_submission = "Cannot connect to Database";

       die(); 

       }

       $sql = "SELECT * FROM visitor_duration ORDER BY S_no DESC LIMIT 1";



// Execute the query

$result = mysqli_query($conn, $sql);



// Check if there are any rows returned by the query

if (mysqli_num_rows($result) > 0) {

    // Loop through each row and display the data

    while ($row = mysqli_fetch_assoc($result)) {

        

$individual_visitor_visiting_duration = $row["individual_visitor_duration"] ;

$cab_visitor_visiting_duration =  $row["cab_visitor_duration"];

$delivery_visitor_visiting_duration =  $row["delivery_visitor_duration"];

$other_sources_visitor_visiting_duration =  $row["other_visitor_duration"];

    }

} else {

    echo "No rows found";

    $individual_visitor_visiting_duration =  30;

$cab_visitor_visiting_duration = 30 ;

$delivery_visitor_visiting_duration =  30;

$other_sources_visitor_visiting_duration =  30;

}



// Close the connection



////******Note : Here only values can be edited should not change any other thing strictly and compulsory Must have a value********** */



?>





















































































































<!-- should not scroll down or edit under here -->

<?php

// session_start();



$default_durations = 30;

// echo $individual_visitor_visiting_duration;

// echo '<br/>';

// echo $cab_visitor_visiting_duration;

// echo '<br/>';

// echo $delivery_visitor_visiting_duration;

// echo '<br/>';

// echo $other_sources_visitor_visiting_duration;

// echo '<br/>';

try{

    $individual_visitor_visiting_duration = $individual_visitor_visiting_duration;

    $cab_visitor_visiting_duration = $cab_visitor_visiting_duration;

    $delivery_visitor_visiting_duration = $delivery_visitor_visiting_duration;

$other_sources_visitor_visiting_duration = $other_sources_visitor_visiting_duration;



}finally{

    isset ($individual_visitor_visiting_duration) || $individual_visitor_visiting_duration=$default_durations;

    isset ($cab_visitor_visiting_duration) || $cab_visitor_visiting_duration=$default_durations;

    isset ($delivery_visitor_visiting_duration) || $delivery_visitor_visiting_duration=$default_durations;

    isset ($other_sources_visitor_visiting_duration) || $other_sources_visitor_visiting_duration=$default_durations;



}

$_SESSION['visiting_duration'] = [

"visitor"=> "+".$individual_visitor_visiting_duration." minutes",

"cab"=> "+".$cab_visitor_visiting_duration." minutes",

"delivery"=> "+".$delivery_visitor_visiting_duration." minutes",

"other_services"=>"+".$other_sources_visitor_visiting_duration." minutes"

];

// var_dump($_SESSION['visiting_duration']);

?>
