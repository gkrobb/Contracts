<!-- THIS FILE IS NOT BEING USED, THIS DATA GETS POSTED TO editdetails.php -->>
<?php

require_once ('cms_fns.php');
require_once ('forms_fns.php');
session_start();
page_header();

$id = $_SESSION['id'];

if ($_POST['field'] <= 15) {

if ($_POST['ContractingEntity']) {$newvalue = $_POST['ContractingEntity'];}
if ($_POST['Vendor']) {$newvalue = $_POST['Vendor'];}
if ($_POST['ContractType']) {$newvalue = $_POST['ContractType'];}
if ($_POST['ContractDescription']) {$newvalue = $_POST['ContractDescription'];}
if ($_POST['Department']) {$newvalue = $_POST['Department'];}
if ($_POST['ResponsiblePartyPri']) {$newvalue = $_POST['ResponsiblePartyPri'];}
if ($_POST['ResponsiblePartySec']) {$newvalue = $_POST['ResponsiblePartySec'];}
if ($_POST['ResponsiblePartyTer']) {$newvalue = $_POST['ResponsiblePartyTer'];}
if ($_POST['EffectiveDate']) {$newvalue = $_POST['EffectiveDate'];}
if ($_POST['ExpirationDate']) {$newvalue = $_POST['ExpirationDate'];}
if ($_POST['ContractStatus']) {$newvalue = $_POST['ContractStatus'];}
if ($_POST['AutoRenewal']) {$newvalue = $_POST['AutoRenewal'];}
if ($_POST['AutoRenewalTerms']) {$newvalue = $_POST['AutoRenewalTerms'];}
if ($_POST['AutoRenewalTimes']) {$newvalue = $_POST['AutoRenewalTimes'];}
if ($_POST['ServiceEvaluationPeriod']) {$newvalue = $_POST['ServiceEvaluationPeriod'];}


if ($_POST['field'] == 1) {$column = 'ContractingEntity';}
if ($_POST['field'] == 2) {$column = 'Vendor';}
if ($_POST['field'] == 3) {$column = 'ContractType';}
if ($_POST['field'] == 4) {$column = 'ContractDescription';}
if ($_POST['field'] == 5) {$column = 'Department';}
if ($_POST['field'] == 6) {$column = 'ResponsiblePartyPri';}
if ($_POST['field'] == 7) {$column = 'ResponsiblePartySec';}
if ($_POST['field'] == 8) {$column = 'ResponsiblePartyTer';}
if ($_POST['field'] == 9) {$column = 'EffectiveDate';}
if ($_POST['field'] == 10) {$column = 'ExpirationDate';}
if ($_POST['field'] == 11) {$column = 'ContractStatus';}
if ($_POST['field'] == 12) {$column = 'AutoRenewal';}
if ($_POST['field'] == 13) {$column = 'AutoRenewalTerms';}
if ($_POST['field'] == 14) {$column = 'AutoRenewalTimes';}
if ($_POST['field'] == 15) {$column = 'ServiceEvaluationPeriod';}

$conn = db_conn();
$sql = "UPDATE ContractData SET ".$column."='".$newvalue."'WHERE ContractID = '".$id."'";
$result = sqlsrv_query($conn, $sql);

if ($result) {
	echo $column.' has been updated successfully.';
	full_edit_form();
} else {
	echo $column.' was not updated.';
}
}
page_footer();
?>