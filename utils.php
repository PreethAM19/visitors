<?php
	// The main utility having all controls...
	
	include('Mail.php');
	session_start(); 
	
	function ds2insert($ds,$table,$bypassError=0,$addtype=''){ //  creates a insert sql for given dataset
		if($addtype=="rawinsert") $id= $ds['id']; //For PW_insertdata // ***  Improvements 78777
		if($addtype=="")$id = GetAutoID($table); // ***  Improvements 78777
		if($_REQUEST['rkey']!="") $rkey = $_REQUEST['rkey']; //assigning randome key from email form...
		$rkey = rand('10000000','99999999');//For random key
		if($ds['rkey']!="") $rkey = $ds['rkey']; 
		$ds['id']        = $id;
        $ds['createdby'] = $_SESSION['userid'];
        $ds['updatedby'] = $_SESSION['userid'];
        $ds['createdat'] = date('Y-m-d H:i:s');
        $ds['updatedat'] = date('Y-m-d H:i:s');
        $ds['tenent'] 	 = $_SESSION['tenent'];
        if($_SESSION['company']!='')$ds['company']   = $_SESSION['company'];
        if($table!='pw_sequencer') $ds['sequencer'] = $id;
        $ds['rkey']   	 = $rkey;
		insert_dataPS($_SESSION['conn'], $ds, $table);
        $_SESSION['enc_user_uploadedfile2']='';$_SESSION['user_uploadedfile2']="";
			
    }
	function removeLastNcharacters($str1,$chars)  { return substr($str1,0,(strlen($str1)-$chars)); }
	function GetAutoID($table){
        //PW_execute("LOCK TABLES pw_lookups ");
		if($_SESSION['tenent']=='') $_SESSION['tenent']='PLUM9';
        // $sql   = "SELECT * FROM pw_lookups WHERE looktype='Sequence' and lookcode='".$table."' and tenent='".$_SESSION['tenent']."'";
		// $ds    = getValueFor($sql);
		$sql   = "SELECT * FROM pw_lookups WHERE looktype='Sequence' and lookcode=? and tenent=?";
		$ds    = getValueForPS($sql,"ss",$table,$_SESSION['tenent']);
        $lastno = $ds['lookname']+1;
		if($lastno<100000000) $lastno=1000000001;
        $squpdateSQL  = "UPDATE pw_lookups SET lookname='".$lastno."' WHERE looktype='Sequence' and lookcode='".$table."' and tenent='".$_SESSION['tenent']."'";
        PW_execute($squpdateSQL);
        $_SESSION['user_LatestautoId'] = $lastno ;
        $_SESSION['user_LatestTable'] = $table ;
		$concat = 0;
        return ($lastno);
    }
	function insert_dataPS($mysqli, $array, $table_name) {
		$placeholders = array_fill(0, count($array), '?');
		$keys   = array(); 
		$values = array();
		foreach($array as $k => $v) {
			$keys[] = $k;
			$values[] = !empty($v) ? $v : null;
		}
		$query = "insert into $table_name ".
				'('.implode(', ', $keys).') values '.
				'('.implode(', ', $placeholders).'); ';
		$stmt = $mysqli->prepare($query);
		if($stmt){  //  valid statement
			$params = array(); 
			foreach ($array as &$value) { 
			  $params[] = &$value;
			}
			$types  = array(str_repeat('s', count($params))); 
			$values = array_merge($types, $params); 
			call_user_func_array(array($stmt, 'bind_param'), $values); 
			if($stmt->execute()){ // ***  Improvements 78777
			}else{ // ***  Improvements 78777
				//printf("Error: %s.\n", $stmt->error);
				$errmsg=$stmt->error; // ***  Improvements 78777
				//echo $errmsg;
				PW_showError2("9833",array($query,$types,$values,$errmsg)); // ***  Improvements 78777
			} // ***  Improvements 78777
		}else{  //  statement error
			echo "Ps-In: 7888 (".$mysqli->error.")";
		}
	}	
	
	function getValueForPS($sql,$formats,$val1,$val2="",$val3="",$val4=""){
		$connPS=$_SESSION['conn'];
		$stmt = $connPS->prepare($sql);
		$BindError = 0;
		// echo $stmt."<br>";
		if($stmt){
			if(strlen($formats)==1){
				$stmt->bind_param($formats, $val1);
			}elseif(strlen($formats)==2){
				$stmt->bind_param($formats, $val1,$val2);
			}elseif(strlen($formats)==3){
				$stmt->bind_param($formats, $val1,$val2,$val3);
			}elseif(strlen($formats)==4){
				$stmt->bind_param($formats, $val1,$val2,$val3,$val4);
			}
		}else{
			$BindError = 1;
		}
		//if($BindError==1) showInvalidOperation(243,"GVPSP:Invalid Operation<br>".$sql);
		$stmt->execute();
		if($stmt->error){
			$err = $stmt->error;
			//showInvalidOperation(244,"GVPS:Invalid Operation<br>".$err);		
		}
		

		$stmt->store_result();
		$Result = get_resultPS($stmt);
		$temp=$Result[$stmt->num_rows-1];
		$recs= count($temp);
		if($recs==1){
			$k=key($temp);
			return $temp[$k];
		}
		return $temp;
	}
	
	function get_resultPS( $Statement ) {
		$RESULT = array();
		$Statement->store_result();
		for ( $i = 0; $i < $Statement->num_rows; $i++ ) {
			$Metadata = $Statement->result_metadata();
			$PARAMS = array();
			while ( $Field = $Metadata->fetch_field() ) {
				$PARAMS[] = &$RESULT[ $i ][ $Field->name ];
			}
			call_user_func_array( array( $Statement, 'bind_result' ), $PARAMS );
			$Statement->fetch();
		}
		return $RESULT;
	}
	
	
	function sendMailIiit($from,$to,$subject,$message,$cc="",$Bcc=""){
		ini_set("include_path",".:/usr/share/pear/");
		include_once ("/usr/share/pear/mime.php");
		$recipients['To'] = $to;
		$recipients['Cc'] = $cc;
		//$subject="[IMSProdInst]-".$subject;
		$headers['From']    = $from;
		// $headers .= "Cc: ".$cc."\r\n";
        // $headers .= "Bcc: ".$Bcc."\r\n";
		$headers['Bcc']      = $Bcc;
		$headers['Cc']      = $cc;
		$headers['To']      = $to;
		$headers['Subject'] = $subject;
		// $headers['Cc'] = $from;
		$params['host'] = 'neelgiri.iiit.ac.in';
		$headers['MIME-Version']  = '1.0';
		$headers['Content-type']  = 'text/html';
		$headers['charset']  = 'iso-8859-1';
		
		// Create the mail object using the Mail::factory method
		$mail_object =& Mail::factory('smtp', $params) or print "Can create mail factory";
		$val=$mail_object->send($recipients, $headers, $message) or print "Cannot send mail";
		return $val;
	}
	
?>