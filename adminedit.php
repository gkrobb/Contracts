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
$adminopt 	= $_POST['AdminOption'];


if($adminopt == 'AddUser'){  		//-------------------------------------------------ADD USER

	adm_add_user();
	
}elseif($adminopt == 'EditUser'){  	//-------------------------------------------------EDIT USER
	
	edit_user_form();
	
	
}elseif($adminopt == 'DelUser'){  	//-------------------------------------------------DELETE USER
	
	del_user_form();
	
	
}elseif($adminopt == 'AddDept'){  	//-------------------------------------------------ADD DEPARTMENT
	echo "<span class='success' id='added'>Add Department</span>";
	
	
}elseif($adminopt == 'EditDept'){  	//-------------------------------------------------EDIT DEPARTMENT
	echo "<span class='success' id='added'>Edit Department</span>";
	
	
}elseif($adminopt == 'DelDept'){  	//-------------------------------------------------DELETE DEPARTMENT
	echo "<span class='success' id='added'>Delete Department</span>";
	
	
}elseif($adminopt == 'DelCon'){  	//-------------------------------------------------DELETE CONTRACT
	echo "<span class='success' id='added'>Delete Contract</span>";
	
	
}else{
	echo "<span class='notice' id='added'>Failure</span>";
}






































page_footer();
?>