<?php
function admin_dropdown(){
?>
	<select name="AdminOption" required>																						
		<option value="">(Select an option...)</option>								
		<optgroup label="CMS Users">
			<option value="AddUser">Add User</option>								
			<option value="EditUser">Edit User</option>								
			<option value="DelUser">Delete User</option>
		</optgroup>
		<optgroup label="CMS Departments">
			<option value="AddDept">Add Department</option>								
			<option value="EditDept">Edit Department</option>								
			<option value="DelDept">Delete Department</option>	
		</optgroup>
		<optgroup label="Contracts">
			<option value="DelCon">Delete Contract</option>
		</optgroup>
	</select>

<?php
}
function admin_form(){
	?>
	<div class="topbar" id="adminbar">
			<h1>administrator options</h1>
		</div>

		<form method="post" action="adminedit.php" enctype="multipart/form-data" id="admineditform">
		<table class="adminedit">
			<tr>
				<td><?php admin_dropdown();  ?></td>
			</tr>	
		</table>		
		<div class="adminbutton"><input type="image" value="Submit" src="img/submitbtn.png" onMouseOver="this.src='img/submitbtnHO.png'" onMouseOut="this.src='img/submitbtn.png'"/></div>
	
		</form>	
<?php
}

function adm_add_user(){
?>	
	<div class="topbar" id="adm_add_user">
		<h1>add user</h1>
	</div>
	<form method="post" action="admin.php" enctype="multipart/form-data" id="adm_add_user_form">
	<input type="text" name="adduser" value="1" hidden />
	<table class="adm_add_user_tbl">
	
	<tr>
		<td><strong>First Name:</strong></td>
		<td><input type="text" title="Enter First Name" placeholder="First Name..." name="FirstName" required /></td>
	</tr>
	<tr>
		<td><strong>Last Name:</strong></td>
		<td><input type="text" title="Enter Last Name" placeholder="Last Name..." name="LastName" required /></td>
	</tr>
	<tr>
		<td><strong>Claxton Username</strong></td>
		<td><input type="text" title="Enter Claxton Username" placeholder="Username..." name="ClaxtonUsername" required /></td>
	</tr>
	<tr>
		<td><strong>Superuser?</strong><br/>(Can view ALL contracts)</td>
		<td>&nbsp&nbsp&nbsp <input type="radio" name="Superuser" value="Y">Yes<br/>&nbsp&nbsp&nbsp <input type="radio" name="Superuser" value="N">No</td>
	</tr>
		<tr>
		<td><strong>Responsible Party List?</strong><br/>(Display in Responsible Party list)</td>
		<td>&nbsp&nbsp&nbsp <input type="radio" name="RPL" value="Y">Yes<br/>&nbsp&nbsp&nbsp <input type="radio" name="RPL" value="N">No</td>
	</tr>
		<tr>
		<td><strong>Administrator?</strong><br/>(Access to Admin menu)</td>
		<td>&nbsp&nbsp&nbsp <input type="radio" name="Administrator" value="Y">Yes<br/>&nbsp&nbsp&nbsp <input type="radio" name="Administrator" value="N">No</td>
	</tr>
	</table>
	<div class="adm_add_user_btn"><input type="image" value="Submit" src="img/submitbtn.png" onMouseOver="this.src='img/submitbtnHO.png'" onMouseOut="this.src='img/submitbtn.png'"/></div>
	</form>
<?php
}

function adm_user_dropdown(){
	$conn = db_conn();
	$sql = "SELECT DISTINCT UserID, Name FROM ContractUsers ORDER BY Name";
	$result = sqlsrv_query($conn, $sql);
	$opt2 = "<select name='Name' required><option value=''/>(Select User...)</option>";
	while($row = sqlsrv_fetch_array($result,SQLSRV_FETCH_ASSOC)) {
	$opt2 .= "<option value='".$row['UserID']."'>".$row['Name']."</option>";
	}
	$opt2 .= "</select>";
	
	echo $opt2;
}

function edit_user_form(){
?>
		<div class="topbar" id="adminbar">
			<h1>select user to edit</h1>
		</div>

		<form method="post" action="useredit.php" enctype="multipart/form-data" id="admineditform">
		<input type="text" value="edit" name="action" hidden />
		<table class="adminedit">
			<tr>
				<td><?php adm_user_dropdown();  ?></td>
			</tr>	
		</table>		
		<div class="adminbutton"><input type="image" value="Submit" src="img/submitbtn.png" onMouseOver="this.src='img/submitbtnHO.png'" onMouseOut="this.src='img/submitbtn.png'"/></div>
	
		</form>	
<?php
}

function adm_edit_user(){
	global $id,$fname,$lname,$claxtonusername,$superuser,$rpl,$administrator;
?>
	<div class="topbar" id="adm_edit_user">
		<h1>edit user</h1>
	</div>
	<form method="post" action="admin.php" enctype="multipart/form-data" id="adm_edit_user_form">
	<input type="text" name="edituser" value="1" hidden />
	<input type="text" name="userid" value="<?php echo $id; ?>" hidden />
	<table class="adm_edit_user_tbl">
	<tr>
	<td></td>
	<td><strong>Current Info</strong></td>
	<td id="centerhead"><strong>Enter New User Info below...</strong></td>
	</tr>
	<tr>
		<td><strong>First Name</strong></td>
		<td><?php echo $fname; ?></td>
		<td><input type="text" placeholder="Update First Name..." name="newFirstName"></td>
	</tr>
	<tr>
		<td><strong>Last Name</strong></td>
		<td><?php echo $lname; ?></td>
		<td><input type="text" placeholder="Update Last Name..." name="newLastName"></td>
	</tr>
	<tr>
		<td><strong>Claxton Username</strong></td>
		<td><?php echo $claxtonusername; ?></td>  
		<td><input type="text" name="newClaxtonUsername" placeholder="Update Username..." /></td>
	</tr>
	<tr>
		<td><strong>Superuser</strong></td>
		<td><?php echo $superuser; ?></td>
		<td>&nbsp&nbsp&nbsp <input type="radio" name="newSuperuser" value="Y">Yes<br/>&nbsp&nbsp&nbsp <input type="radio" name="newSuperuser" value="N">No</td>
	</tr>
	<tr>
		<td><strong>Responsible Party List</strong></td>
		<td><?php echo $rpl; ?></td>
		<td>&nbsp&nbsp&nbsp <input type="radio" name="newRPL" value="Y">Yes<br/>&nbsp&nbsp&nbsp <input type="radio" name="newRPL" value="N">No</td>
	</tr>
	<tr>
		<td><strong>Administrator</strong></td>
		<td><?php echo $administrator; ?></td>
		<td>&nbsp&nbsp&nbsp <input type="radio" name="newAdministrator" value="Y">Yes<br/>&nbsp&nbsp&nbsp <input type="radio" name="newAdministrator" value="N">No</td>
	</tr>
	<tr>
		<td></td>
		<td><div id="updatesev"><input type="image" src="img/Update.png" value="Update" onMouseOver="this.src='img/UpdateHO.png'" onMouseOut="this.src='img/Update.png'"/></div></td>
		<td></td>
	</tr>
	
	
	</table>
	</form>
<?php	
}

function del_user_form(){
?>
		<div class="topbar" id="adminbar">
			<h1>select user to delete</h1>
		</div>

		<form method="post" action="useredit.php" enctype="multipart/form-data" id="admineditform">
		<input type="text" value="delete" name="action" hidden />
		<table class="adminedit">
			<tr>
				<td><?php adm_user_dropdown();  ?></td>
			</tr>	
		</table>		
		<div class="adminbutton"><input type="image" value="Submit" src="img/submitbtn.png" onMouseOver="this.src='img/submitbtnHO.png'" onMouseOut="this.src='img/submitbtn.png'"/></div>
	
		</form>	
<?php
}




?>