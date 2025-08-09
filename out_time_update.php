<?php 

// $search_q = '';

// if(isset($_GET["search_content"])){

//    $search_q = $_GET["search_content"];

//  };
$servername="localhost";
$username="imsdevuser";
$password="UjhGFTybCDSr";
$database="newimsiiithdev";

session_start();

$_SESSION['search_content_on_exit_action'] = $_POST["search_content"];

 

var_dump($_POST);



date_default_timezone_set("Asia/Calcutta");

$conn = new mysqli($servername,$username,$password,$database);
if(!$conn){
	$err_at_submission = mysql_error();
	die();
}
else{

    //$sql = "UPDATE visitor_entry_details_table SET exit_registered_date='".date('d-m-y')."',exit_registered_time='".date('H:i')."' WHERE visitor_entry_id=".$_GET["id"];

    $sql = "UPDATE visitors SET exitdate='".date('d-m-y')."',exittime='".date('H:i')."' WHERE visitorid='".$_POST["id"]."'";
	echo $sql;

    if(!$result = mysqli_query($conn,$sql)){

        die("query error problem".mysqli_error($conn));

    }else{

        

        unset($_POST['id']);

        //header('Location: index.php?search_content='.$_GET["search_content"].'');

        header('Location: index.php');

        //search_content='.$_POST["search_content"].''

    }

    }

        

?>