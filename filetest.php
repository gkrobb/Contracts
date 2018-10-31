<?php
require_once ('cms_fns.php');

function new_filename() {
$newname = uniqid('cn_');
$conn = db_conn();
$sql = "SELECT * FROM contracts WHERE ContractFileName = '".$newname."'";
$stmt = sqlsrv_query($conn,$sql);
$rows = sqlsrv_num_rows($stmt);
if ($rows > 0) {
	echo "File name already exists.  Please upload again.";
} else {
	//echo "This is a valid filename";
	return $newname;
}
}

new_filename();

print_r($newname);
//echo new_filename();
?>