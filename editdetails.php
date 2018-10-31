<?php
session_start();
require_once ('cms_fns.php');
require_once ('forms_fns.php');
page_header('Edit Contract Details','main');

$id = $_POST['id'];
$field = $_POST['field'];






if (isset($_POST['backid'])) {
	
	$id = $_POST['backid'];
	$conn = db_conn();
	$sql = "SELECT ContractID,ContractingEntity,Vendor,ContractType,ContractTitle,ContractDescription,Department,EOC,ResponsiblePartyPri,ResponsiblePartySec,ResponsiblePartyTer,AdditionalReviewer1,AdditionalReviewer2,CONVERT(varchar(10),EffectiveDate,23) AS 'EffectiveDate',
			CONVERT(varchar(10),ExpirationDate,23) AS 'ExpirationDate',AnnualCost1,AnnualCost2,AnnualCost3,AnnualCost4,AnnualCost5,AnnualCost6,AnnualCost7,AnnualCost8,AnnualCost9,AnnualCost10,ContractStatus,AutoRenewal,AutoRenewalTerms,AutoRenewalTimes,CONVERT(varchar(10),AutoRenewalDeadline,23) AS 'AutoRenewalDeadline'
			FROM ContractData WHERE ContractID = '".$id."'";
	$result = sqlsrv_query($conn, $sql);
	$row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);
	
	$ContractingEntity 			= $row['ContractingEntity'];
	$Vendor 					= $row['Vendor'];
	$ContractType 				= $row['ContractType'];
	$ContractTitle				= $row['ContractTitle'];
	$ContractDescription 		= $row['ContractDescription'];
	$Department 				= $row['Department'];
	$EOC						= $row['EOC'];
	$ResponsiblePartyPri 		= $row['ResponsiblePartyPri'];
	$ResponsiblePartySec 		= $row['ResponsiblePartySec'];
	$ResponsiblePartyTer 		= $row['ResponsiblePartyTer'];
	$AdditionalReviewer1		= $row['AdditionalReviewer1'];
	$AdditionalReviewer2		= $row['AdditionalReviewer2'];
	$EffectiveDate 				= $row['EffectiveDate'];
	$ExpirationDate 			= $row['ExpirationDate'];
	$ContractStatus 			= $row['ContractStatus'];
	$AutoRenewal 				= $row['AutoRenewal'];
	$AutoRenewalTerms 			= $row['AutoRenewalTerms'];
	$AutoRenewalTimes 			= $row['AutoRenewalTimes'];
	$AutoRenewalDeadline 		= $row['AutoRenewalDeadline'];
	
	full_edit_form();
}else {



if ($field >= 1 AND $field <= 19) {

if ($_POST['ContractingEntity']) {$newvalue = $_POST['ContractingEntity'];}
if ($_POST['Vendor']) {$newvalue = $_POST['Vendor'];}
if ($_POST['ContractType']) {$newvalue = $_POST['ContractType'];}
if ($_POST['ContractTitle']) {$newvalue = $_POST['ContractTitle'];}
if ($_POST['ContractDescription']) {$newvalue = $_POST['ContractDescription'];}
if ($_POST['Department']) {$newvalue = $_POST['Department'];}
if ($_POST['EOC']){$newvalue = $_POST['EOC'];}
if ($_POST['ResponsiblePartyPri']) {$newvalue = $_POST['ResponsiblePartyPri'];}
if ($_POST['ResponsiblePartySec']) {$newvalue = $_POST['ResponsiblePartySec'];}
if ($_POST['ResponsiblePartyTer']) {$newvalue = $_POST['ResponsiblePartyTer'];}
if ($_POST['AdditionalReviewer1']) {$newvalue = $_POST['AdditionalReviewer1'];}
if ($_POST['AdditionalReviewer2']) {$newvalue = $_POST['AdditionalReviewer2'];}
if ($_POST['EffectiveDate']) {$newvalue = $_POST['EffectiveDate'];}
if ($_POST['ExpirationDate']) {$newvalue = $_POST['ExpirationDate'];}
if ($_POST['ContractStatus']) {$newvalue = $_POST['ContractStatus'];}
if ($_POST['AutoRenewal']) {$newvalue = $_POST['AutoRenewal'];}
if ($_POST['AutoRenewalTerms']) {$newvalue = $_POST['AutoRenewalTerms'];}
if ($_POST['AutoRenewalTimes']) {$newvalue = $_POST['AutoRenewalTimes'];}
if ($_POST['AutoRenewalDeadline']) {$newvalue = $_POST['AutoRenewalDeadline'];}



if ($_POST['field'] == 1)  {$columnName = 'ContractingEntity'; $column = 'Contracting Entity';}
if ($_POST['field'] == 2)  {$columnName = 'Vendor'; $column = 'Vendor';}
if ($_POST['field'] == 3)  {$columnName = 'ContractType'; $column = 'Contract Type';}
if ($_POST['field'] == 4)  {$columnName = 'ContractTitle'; $column = 'Contract Title';}
if ($_POST['field'] == 5)  {$columnName = 'ContractDescription'; $column = 'Contract Description';}
if ($_POST['field'] == 6)  {$columnName = 'Department'; $column = 'Department';}
if ($_POST['field'] == 7)  {$columnName = 'ResponsiblePartyPri'; $column = 'Primary Responsible Party';}
if ($_POST['field'] == 8)  {$columnName = 'ResponsiblePartySec'; $column = 'Secondary Responsible Party';}
if ($_POST['field'] == 9)  {$columnName = 'ResponsiblePartyTer'; $column = 'Tertiary Responsible Party';}
if ($_POST['field'] == 10) {$columnName = 'EffectiveDate'; $column = 'Effective Date';}
if ($_POST['field'] == 11) {$columnName = 'ExpirationDate'; $column = 'Expiration Date';}
if ($_POST['field'] == 12) {$columnName = 'ContractStatus'; $column = 'Contract Status';}
if ($_POST['field'] == 13) {$columnName = 'AutoRenewal'; $column = 'Auto Renewal';}
if ($_POST['field'] == 14) {$columnName = 'AutoRenewalTerms'; $column = 'Auto Renewal Terms';}
if ($_POST['field'] == 15) {$columnName = 'AutoRenewalTimes'; $column = 'Auto Renewal Times';}
if ($_POST['field'] == 16) {$columnName = 'AdditionalReviewer1'; $column = 'Additional Reviewer - 1';}
if ($_POST['field'] == 17) {$columnName = 'AdditionalReviewer2'; $column = 'Additional Reviewer - 2';}
if ($_POST['field'] == 18) {$columnName = 'AutoRenewalDeadline'; $column = 'Auto Renewal Deadline';}
if ($_POST['field'] == 19) {$columnName = 'EOC'; $column = 'EOC';}

$conn2 = db_conn();
$sql2 = "UPDATE ContractData SET ".$columnName."='".$newvalue."'WHERE ContractID = '".$id."'";
$result2 = sqlsrv_query($conn2, $sql2);

	if ($result2) {
		echo '<span class="success" id="details">'.$column.' has been updated successfully.</span>';
		
		$conn = db_conn();
		$sql = "SELECT ContractID,ContractingEntity,Vendor,ContractType,ContractTitle,ContractDescription,Department,EOC,ResponsiblePartyPri,ResponsiblePartySec,ResponsiblePartyTer,AdditionalReviewer1,AdditionalReviewer2,CONVERT(varchar(10)
		,EffectiveDate,23) AS 'EffectiveDate',CONVERT(varchar(10),ExpirationDate,23) AS 'ExpirationDate',AnnualCost1,AnnualCost2,AnnualCost3,AnnualCost4,AnnualCost5,AnnualCost6,AnnualCost7,AnnualCost8
		,AnnualCost9,AnnualCost10,ContractStatus,AutoRenewal,AutoRenewalTerms,AutoRenewalTimes,CONVERT(varchar(10),AutoRenewalDeadline,23) AS 'AutoRenewalDeadline' FROM ContractData WHERE ContractID = '".$id."'";
		$result = sqlsrv_query($conn, $sql);
		$row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);
		
		$ContractingEntity 			= $row['ContractingEntity'];
		$Vendor 					= $row['Vendor'];
		$ContractType 				= $row['ContractType'];
		$ContractTitle				= $row['ContractTitle'];
		$ContractDescription 		= $row['ContractDescription'];
		$Department 				= $row['Department'];
		$EOC						= $row['EOC'];
		$ResponsiblePartyPri 		= $row['ResponsiblePartyPri'];
		$ResponsiblePartySec 		= $row['ResponsiblePartySec'];
		$ResponsiblePartyTer 		= $row['ResponsiblePartyTer'];
		$AdditionalReviewer1		= $row['AdditionalReviewer1'];
		$AdditionalReviewer2		= $row['AdditionalReviewer2'];
		$EffectiveDate 				= $row['EffectiveDate'];
		$ExpirationDate 			= $row['ExpirationDate'];
		$ContractStatus 			= $row['ContractStatus'];
		$AutoRenewal 				= $row['AutoRenewal'];
		$AutoRenewalTerms 			= $row['AutoRenewalTerms'];
		$AutoRenewalTimes 			= $row['AutoRenewalTimes'];
		$AutoRenewalDeadline 		= $row['AutoRenewalDeadline'];
		
		full_edit_form();
	} else {
		echo '<span class="notice" id="dets">'.$column.' was not updated.</span>';
		
		$conn = db_conn();
		$sql = "SELECT ContractID,ContractingEntity,Vendor,ContractType,ContractTitle,ContractDescription,Department,EOC,ResponsiblePartyPri,ResponsiblePartySec,ResponsiblePartyTer,AdditionalReviewer1,AdditionalReviewer2,CONVERT(varchar(10)
		,EffectiveDate,23) AS 'EffectiveDate',CONVERT(varchar(10),ExpirationDate,23) AS 'ExpirationDate',AnnualCost1,AnnualCost2,AnnualCost3,AnnualCost4,AnnualCost5,AnnualCost6,AnnualCost7,AnnualCost8
		,AnnualCost9,AnnualCost10,ContractStatus,AutoRenewal,AutoRenewalTerms,AutoRenewalTimes,CONVERT(varchar(10),AutoRenewalDeadline,23) AS 'AutoRenewalDeadline' FROM ContractData WHERE ContractID = '".$id."'";
		$result = sqlsrv_query($conn, $sql);
		$row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);
		
		$ContractingEntity 			= $row['ContractingEntity'];
		$Vendor 					= $row['Vendor'];
		$ContractType 				= $row['ContractType'];
		$ContractTitle				= $row['ContractTitle'];
		$ContractDescription 		= $row['ContractDescription'];
		$Department 				= $row['Department'];
		$EOC						= $row['EOC'];
		$ResponsiblePartyPri 		= $row['ResponsiblePartyPri'];
		$ResponsiblePartySec 		= $row['ResponsiblePartySec'];
		$ResponsiblePartyTer 		= $row['ResponsiblePartyTer'];
		$AdditionalReviewer1		= $row['AdditionalReviewer1'];
		$AdditionalReviewer2		= $row['AdditionalReviewer2'];
		$EffectiveDate 				= $row['EffectiveDate'];
		$ExpirationDate 			= $row['ExpirationDate'];
		$ContractStatus 			= $row['ContractStatus'];
		$AutoRenewal 				= $row['AutoRenewal'];
		$AutoRenewalTerms 			= $row['AutoRenewalTerms'];
		$AutoRenewalTimes 			= $row['AutoRenewalTimes'];
		$AutoRenewalDeadline 		= $row['AutoRenewalDeadline'];
		
		full_edit_form();
		}
} else {
	$conn = db_conn();
	$sql = "SELECT ContractID,ContractingEntity,Vendor,ContractType,ContractTitle,ContractDescription,Department,EOC,ResponsiblePartyPri,ResponsiblePartySec,ResponsiblePartyTer,AdditionalReviewer1,AdditionalReviewer2,CONVERT(varchar(10),EffectiveDate,23) AS 'EffectiveDate',
			CONVERT(varchar(10),ExpirationDate,23) AS 'ExpirationDate',AnnualCost1,AnnualCost2,AnnualCost3,AnnualCost4,AnnualCost5,AnnualCost6,AnnualCost7,AnnualCost8,AnnualCost9,AnnualCost10,ContractStatus,AutoRenewal,AutoRenewalTerms,AutoRenewalTimes,CONVERT(varchar(10),AutoRenewalDeadline,23) AS 'AutoRenewalDeadline'
			FROM ContractData WHERE ContractID = '".$id."'";
	$result = sqlsrv_query($conn, $sql);
	$row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);
	
	
	$ContractingEntity 			= $row['ContractingEntity'];
	$Vendor 					= $row['Vendor'];
	$ContractType 				= $row['ContractType'];
	$ContractTitle				= $row['ContractTitle'];
	$ContractDescription 		= $row['ContractDescription'];
	$Department 				= $row['Department'];
	$EOC						= $row['EOC'];
	$ResponsiblePartyPri 		= $row['ResponsiblePartyPri'];
	$ResponsiblePartySec 		= $row['ResponsiblePartySec'];
	$ResponsiblePartyTer 		= $row['ResponsiblePartyTer'];
	$AdditionalReviewer1		= $row['AdditionalReviewer1'];
	$AdditionalReviewer2		= $row['AdditionalReviewer2'];
	$EffectiveDate 				= $row['EffectiveDate'];
	$ExpirationDate 			= $row['ExpirationDate'];
	$ContractStatus 			= $row['ContractStatus'];
	$AutoRenewal 				= $row['AutoRenewal'];
	$AutoRenewalTerms 			= $row['AutoRenewalTerms'];
	$AutoRenewalTimes 			= $row['AutoRenewalTimes'];
	$AutoRenewalDeadline 		= $row['AutoRenewalDeadline'];
	
	full_edit_form();
}
}

?>




<?php
page_footer();
?>