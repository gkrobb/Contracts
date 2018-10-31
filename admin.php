<?php
require_once ('cms_fns.php');
require_once ('forms_fns.php');
require_once ('admin_fns.php');

page_header('Admin','main');

/////IDENTIFY USER/////
$user = strtoupper($_SERVER['LOGON_USER']);
$conn = db_conn();
$sql = "SELECT ClaxtonUsername FROM ContractUsers WHERE AdminUser = 'Y'";
$result	= sqlsrv_query($conn,$sql);
$authusers = array();
while($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)){
	array_push($authusers,$row['ClaxtonUsername']);
}
/////END IDENTIFY USER/////

$adduser 	= $_POST['adduser'];
$edituser	= $_POST['edituser'];
$deleteuser	= $_POST['deleteuser'];
$adddept	= $_POST['adddept'];
$editdept	= $_POST['editdept'];
$deletedept	= $_POST['deletedept'];
$deletecon	= $_POST['deletecon'];






if(in_array($user,$authusers)){                  //////////////////////////////////////User HAS access - ALL Content goes here

	if($adduser == '1'){ ////////// ADD NEW USER
		
		$firstname			= $_POST['FirstName'];
		$lastname			= $_POST['LastName'];
		$claxtonusername	= strtoupper($_POST['ClaxtonUsername']);
		$username			= "CLAXTON\\".$claxtonusername;
		$superuser 			= $_POST['Superuser'];
		$rpl 				= $_POST['RPL'];
		$administrator 		= $_POST['Administrator'];
		$fullname			= $lastname.", ".$firstname;
		
		//echo "<span class='success' id='added'>$fullname</span>";
		
		$sql3 = "SELECT * FROM ContractUsers WHERE ClaxtonUsername = '".$username."'";
		$exists = sqlsrv_query($conn,$sql3,array(),array("Scrollable" => 'static'));
		$count = sqlsrv_num_rows($exists);
		if($count > 0){
			echo "<span class='notice' id='adminnotice'>The Claxton Username <strong>".$username."</strong> already exists in the database.</span><br/>";
			admin_form();
			
		}else{
		
		$sql2 = "INSERT INTO ContractUsers (Name,ClaxtonUsername,Superuser,ResponsiblePartyList,AdminUser) VALUES ('".$fullname."','".$username."','".$superuser."','".$rpl."','".$administrator."')";
		if(sqlsrv_query($conn,$sql2)){
			echo "<span class='success' id='added'>$firstname $lastname has been added to the system.</span><br/>";
			admin_form();
		}else{
			echo "<span class='notice' id='adminnotice'>Could not add user to the database. $sql2</span>". sqlsrv_errors($conn)."<br/>";
			admin_form();
		}
		}
		
	}elseif($edituser == '1'){
		
		$id 				= $_POST['userid'];
		$newFirstName 		= $_POST['newFirstName'];
		$newLastName 		= $_POST['newLastName'];
		$newFullName 		= $newLastName.", ".$newFirstName;
		$newClaxtonUsername	= strtoupper($_POST['newClaxtonUsername']);
		$newUsername		= "CLAXTON\\".$newClaxtonUsername;
		$newSuperuser		= $_POST['newSuperuser'];
		$newRPL				= $_POST['newRPL'];
		$newAdministrator	= $_POST['newAdministrator'];
		
		$sql = "SELECT UserID, Name, ClaxtonUsername, Superuser, ResponsiblePartyList,AdminUser
		FROM ContractUsers WHERE UserID = '".$id."'";
		$result = sqlsrv_query($conn,$sql);
		$row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);

		$fullname			= $row['Name'];
		$oldfname			= trim(end(explode(',',$fullname)));
		$oldlname			= current(explode(',',$fullname));
		$claxtonusername	= $row['ClaxtonUsername'];	
		$superuser			= $row['Superuser'];
		$rpl				= $row['ResponsiblePartyList'];
		$administrator		= $row['AdminUser'];
		
		if($newFirstName == '' && $newLastName == ''){$updateName = $fullname;}
		elseif($newFirstName == '' && $newLastName != ''){$updateName = $newLastName.", ".$oldfname;}
		elseif($newFirstName != '' && $newLastName == ''){$updateName = $oldlname.", ".$newFirstName;}
		elseif($newFirstName != '' && $newLastName != ''){$updateName = $newFullName;}
		
		if($newClaxtonUsername == ''){$updateClaxtonUsername = $claxtonusername;}else{$updateClaxtonUsername = $newUsername;}
		
		if($newSuperuser == ''){$updateSuperuser = $superuser;}else{$updateSuperuser = $newSuperuser;}
		
		if($newRPL == ''){$updateRPL = $rpl;}else{$updateRPL = $newRPL;}
		
		if($newAdministrator == ''){$updateAdministrator = $administrator;}else{$updateAdministrator = $newAdministrator;}
		
		$sql2 = "UPDATE ContractUsers SET Name = '".$updateName."',ClaxtonUsername = '".$updateClaxtonUsername."',Superuser = '".$updateSuperuser."',ResponsiblePartyList = '".$updateRPL."',AdminUser = '".$updateAdministrator."' WHERE UserID = '".$id."'";
		
		$updatecontractdatasql1 = "UPDATE ContractData SET ResponsiblePartyPri = '".$updateName."' WHERE ResponsiblePartyPri = '".$fullname."';";
		$updatecontractdatasql2 = "UPDATE ContractData SET ResponsiblePartySec = '".$updateName."' WHERE ResponsiblePartySec = '".$fullname."';"; 
		$updatecontractdatasql3 = "UPDATE ContractData SET ResponsiblePartyTer = '".$updateName."' WHERE ResponsiblePartyTer = '".$fullname."';"; 
		$updatecontractdatasql4 = "UPDATE ContractData SET AdditionalReviewer1 = '".$updateName."' WHERE AdditionalReviewer1 = '".$fullname."';"; 
		$updatecontractdatasql5 = "UPDATE ContractData SET AdditionalReviewer2 = '".$updateName."' WHERE AdditionalReviewer2 = '".$fullname."';"; 
		
		
		if(sqlsrv_query($conn,$sql2)){
			
			$updatecd1 = sqlsrv_query($conn,$updatecontractdatasql1);
			$updatecd2 = sqlsrv_query($conn,$updatecontractdatasql2);
			$updatecd3 = sqlsrv_query($conn,$updatecontractdatasql3);
			$updatecd4 = sqlsrv_query($conn,$updatecontractdatasql4);
			$updatecd5 = sqlsrv_query($conn,$updatecontractdatasql5);
			
			echo "<span class='success' id='added'>Record has been updated successfully.</span><br/>";
			admin_form();
		}else{
			echo "<span class='notice' id='adminnotice'>Could not update user record.</span><br/>";
			admin_form();
		}
		
		
	}elseif($deleteuser == '1'){
		
		$id 		= $_POST['userid'];
		$delbutton 	= $_POST['delbutton'];
		
		if($delbutton == 'No'){
			echo "<span class='notice' id='adminnotice'>User cancelled action. No records deleted.</span><br/>";
			admin_form();
			
		}elseif($delbutton == 'Yes'){
			
			$sqldel = "DELETE FROM ContractUsers WHERE UserID = '".$id."'";
			$result = sqlsrv_query($conn,$sqldel);
			echo "<span class='success' id='added'>Record has been deleted successfully.</span><br/>";
			admin_form();
			
		}
		
		
		
		
	}elseif($adddept == '1'){
	
	}elseif($editdept == '1'){
		
	}elseif($deletedept == '1'){
		
	}elseif($deletecon == '1'){
	
	}else{      //VISITING PAGE FOR FIRST TIME
		admin_form();
	}

?>	


	
<?php	
}else {                           ////////////////////////////////User does NOT have access
	echo "<span class='notice' id='adminnotice'>You do not have access to this area. For assistance please contact the helpdesk.</span>";
}


page_footer();
?>