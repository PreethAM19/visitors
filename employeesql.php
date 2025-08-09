<?php

$servername="localhost";
$username="imsdevuser";
$password="UjhGFTybCDSr";
$database="newimsiiithdev";



$conn = new mysqli($servername,$username,$password,$database);
if(!$conn){
	$err_at_submission = mysql_error();
	die();
}

$sql="select entitycode,entityname,userid from pw_entity where entitytype='EMPLOYEE' and status='Active' and hremptype<>'' order by hremptype,entityname";

//$sql="select entityname from pw_entity where entitytype='EMPLOYEE' and status='Active' and hremptype<>'' order by hremptype,entityname";
 $wtmoptions['iiith'] = [];
 $wtmoptions['cie'] = ["cie emoployee 1", "cie employee 2", "cie emoployee 3", "cie employee 4"];
 $wtmoptions['fsq']=["flat no: 1","flat no: 2","flat no: 3","flat no: 4","flat no: 5","flat no: 6"];
$result = mysqli_query($conn,$sql);
if (mysqli_num_rows($result) > 0) {

    // Loop through each row and display the data

while ($row = mysqli_fetch_assoc($result)) {
	echo "<br/>";		
		var_dump($row);
echo "<br/>";
//echo "<br/>";
//echo $row['entityname'];
//echo "<br/>";

array_push($wtmoptions['iiith'],$row['entityname']);
//echo "<br/>";
//var_dump($wtmoptions['iiith']);

	
	
}}

$sqlnew = "SELECT entitycode, entityname, userid FROM pw_entity WHERE entitytype='EMPLOYEE' AND status='Active' AND hremptype<>'' ORDER BY hremptype, entityname";
$wtm = [];
$result = mysqli_query($conn, $sqlnew);
if (mysqli_num_rows($result) > 0) {
    // Loop through each row and store the entityname in the array
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<br/>";
        var_dump($row);
        echo "<br/>";
        array_push($wtm, $row['entityname']);
    }
}
		


?>