<?php
require_once ('cms_fns.php');
require_once ('forms_fns.php');
require_once ('admin_fns.php');

page_header('Admin - Edit/Delete User','main');
$conn = db_conn();
$id = $_POST['Name'];
$action = $_POST['action'];

if($action == 'edit'){


$sql = "SELECT UserID, Name, ClaxtonUsername, Superuser, ResponsiblePartyList,AdminUser
		FROM ContractUsers WHERE UserID = '".$id."'";
$result = sqlsrv_query($conn,$sql);
$row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);

$fullname			= $row['Name'];
$claxtonusername	= $row['ClaxtonUsername'];	
$superuser			= $row['Superuser'];
$rpl				= $row['ResponsiblePartyList'];
$administrator		= $row['AdminUser'];

$fname = trim(end(explode(',',$fullname)));
$lname = current(explode (',',$fullname));

adm_edit_user();

} elseif($action == 'delete'){
	
	$sql 				= "SELECT UserID, Name, ClaxtonUsername FROM ContractUsers WHERE UserID = '".$id."'";
	$result 			= sqlsrv_query($conn,$sql);
	$row 				= sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);
	$id 				= $row['UserID'];
	$name 				= $row['Name'];
	$claxtonusername 	= $row['ClaxtonUsername'];
	
	$sql2 = "SELECT ContractID,Vendor,ContractType,ContractTitle,Department FROM ContractData 
												 WHERE ((ResponsiblePartyPri = '".$name."') OR
														(ResponsiblePartySec = '".$name."') OR
														(ResponsiblePartyTer = '".$name."') OR
														(AdditionalReviewer1 = '".$name."') OR
														(AdditionalReviewer2 = '".$name."'))";
	$result2 = sqlsrv_query($conn,$sql2,array(),array("Scrollable" => 'static'));
	$count = sqlsrv_num_rows($result2);
	
	if($count < 1){ //USER IS NOT ATTACHED TO ANY EXISTING CONTRACTS
?>
		<div class="topbar" id="adminbar">
			<h1>delete user</h1>
		</div>
		<form method="post" action="admin.php" enctype="multipart/form-data" id="admineditform"> 
		<input type="text" name="userid" value="<?php echo $id; ?>" hidden />
		<input type="text" name="deleteuser" value="1" hidden />
		<table class="deluser">
			<tr>
				<td colspan="2">Are you sure you want to delete <strong><?php echo $name; ?></strong> from the Contract System?</td>
			</tr>
			<tr>
				<td><input type="submit" name="delbutton" value="Yes" /></td>
				<td><input type="submit" name="delbutton" value="No" /></td>
			</tr>
		</table>
		</form>
<?php	
	}else{  //CANNOT DELETE IF USER IS STILL ATTACHED TO A CONTRACT, DISPLAY CONTRACTS WITH USER
?>
		<div class="topbar" id="userconlist">
			<h1>user contracts</h1>
		</div>
		<table class="userconlist_table">
		<tr>
			<td colspan="4">
				<strong>User cannot be deleted because they are associated with the following contracts:</strong>
			</td>
		</tr>
		<tr>
			<th>Vendor</th>
			<th>Contract Title</th>
			<th>Contract Type</th>
			<th>Department</th>
		</tr>
<?php
		while ($row2 = sqlsrv_fetch_array($result2, SQLSRV_FETCH_ASSOC)){
			echo '<tr>';
			echo '<td>'.($row2['Vendor']).'</td>';
			echo '<td>'.($row2['ContractTitle']).'</td>';
			echo '<td>'.($row2['ContractType']).'</td>';
			echo '<td>'.($row2['Department']).'</td>';
			echo '</tr>';
		}
?>
		</table>
		<br/>
		<a href="admin.php" id="back">Back to Admin Menu</a>
<?php
	}
	
}


?>