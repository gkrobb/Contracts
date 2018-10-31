<!-- FILE NOT USED - DATA IS POSTED TO fulldisplay.php -->
<?php
require_once ('cms_fns.php');

page_header();

///////////////////POSTED FORM DATA////////////////////////
$ContractingEntity = $_POST['ContractingEntity'];
$Vendor = $_POST['Vendor'];
$ContractType = $_POST['ContractType'];
$ContractTitle = $_POST['ContractTitle'];
$ContractDescription = $_POST['ContractDescription'];
$Department = $_POST['Department'];
$ResponsiblePartyPri = $_POST['ResponsiblePartyPri'];
$ResponsiblePartySec = $_POST['ResponsiblePartySec'];
$ResponsiblePartyTer = $_POST['ResponsiblePartyTer'];
$EffectiveDate = $_POST['EffectiveDate'];
$ExpirationDate = $_POST['ExpirationDate'];
$AnnualCost1 = $_POST['AnnualCost1'];
$AnnualCost2 = $_POST['AnnualCost2'];
$AnnualCost3 = $_POST['AnnualCost3'];
$ContractStatus = $_POST['ContractStatus'];
$AutoRenewal = $_POST['AutoRenewal'];
$AutoRenewalTerms = $_POST['AutoRenewalTerms'];
$AutoRenewalTimes = $_POST['AutoRenewalTimes'];
$ServiceEvaluationPeriod = $_POST['ServiceEvaluationPeriod'];

$confile = $_FILES['cmsfile']['name'][0];
$baafile = $_FILES['cmsfile']['name'][1];
$coifile = $_FILES['cmsfile']["name"][2];
$sevfile = $_FILES['cmsfile']['name'][3];
$admfile = $_FILES['cmsfile']['name'][4];
$moufile = $_FILES['cmsfile']['name'][5];
$pofile = $_FILES['cmsfile']['name'][6];
//////////////////END POSTED FORM DATA/////////////////////

if($ServiceEvaluationPeriod == 'Annual') {$interval = '1 year';} else {$interval = '6 months';}
$date = date_create($EffectiveDate);
date_add($date,date_interval_create_from_date_string($interval));
$NextServiceEvaluationDate = date_format($date,'Y-m-d');

/////////////////CREATE NEW FILE NAMES/////////////////////
$unqconfilename = uniqid('con_',TRUE);
$unqbaafilename = uniqid('baa_',TRUE);
$unqcoifilename = uniqid('coi_',TRUE);
$unqsevfilename = uniqid('sev_',TRUE);
$unqadmfilename = uniqid('adm_',TRUE);
$unqmoufilename = uniqid('mou_',TRUE);
$unqpofilename = uniqid('po_',TRUE);

$tempcon = explode(".",$confile);
$tempbaa = explode(".",$baafile);
$tempcoi = explode(".",$coifile);
$tempsev = explode(".",$sevfile);
$tempadm = explode(".",$admfile);
$tempmou = explode(".",$moufile);
$temppo = explode(".",$pofile);

$conext = end($tempcon);
$baaext = end($tempbaa);
$coiext = end($tempcoi);
$sevext = end($tempsev);
$admext = end($tempadm);
$mouext = end($tempmou);
$poext = end($temppo);

if ($_FILES['cmsfile']['name'][0]) {$newconfilename = $unqconfilename . '.' . $conext; } ELSE {$newconfilename = NULL;}
if ($_FILES['cmsfile']['name'][1]) {$newbaafilename = $unqbaafilename . '.' . $baaext; } ELSE {$newbaafilename = NULL;}
if ($_FILES['cmsfile']['name'][2]) {$newcoifilename = $unqcoifilename . '.' . $coiext; } ELSE {$newcoifilename = NULL;}
if ($_FILES['cmsfile']['name'][3]) {$newsevfilename = $unqsevfilename . '.' . $sevext; } ELSE {$newsevfilename = NULL;}
if ($_FILES['cmsfile']['name'][4]) {$newadmfilename = $unqadmfilename . '.' . $admext; } ELSE {$newadmfilename = NULL;}
if ($_FILES['cmsfile']['name'][5]) {$newmoufilename = $unqmoufilename . '.' . $mouext; } ELSE {$newmoufilename = NULL;}
if ($_FILES['cmsfile']['name'][6]) {$newpofilename = $unqpofilename . '.' . $poext; } ELSE {$newpofilename = NULL;}
////////////////END CREATE NEW FILE NAMES//////////////////

$newfilenames = array($newconfilename,$newbaafilename,$newcoifilename,$newsevfilename,$newadmfilename,$newmoufilename,$newpofilename);
$target_dir = 'uploads/';

$conn = db_conn();
$sql = "INSERT INTO ContractData (ContractingEntity,Vendor,ContractType,ContractTitle,ContractDescription,Department,ResponsiblePartyPri,ResponsiblePartySec,
								  ResponsiblePartyTer,EffectiveDate,ExpirationDate,AnnualCost1,AnnualCost2,AnnualCost3,ContractStatus,AutoRenewal,AutoRenewalTerms,AutoRenewalTimes,
								  ContractFileName,BAAFileName,COIFileName,ServiceEvaluationPeriod,ServiceEvaluationFileName,AddendumFileName,
								  MemorandumOfUnderstandingFileName,PurchaseOrderFileName,NextServiceEvaluationDate) 
		VALUES ('".$ContractingEntity."','".$Vendor."','".$ContractType."','".$ContractTitle."','".$ContractDescription."','".$Department."','".$ResponsiblePartyPri."',
		'".$ResponsiblePartySec."','".$ResponsiblePartyTer."','".$EffectiveDate."','".$ExpirationDate."','".$AnnualCost1."','".$AnnualCost2."','".$AnnualCost3."','".$ContractStatus."','".$AutoRenewal."',
		'".$AutoRenewalTerms."','".$AutoRenewalTimes."','".$newconfilename."','".$newbaafilename."','".$newcoifilename."','".$ServiceEvaluationPeriod."',
		'".$newsevfilename."','".$newadmfilename."','".$newmoufilename."','".$newpofilename."','".$NextServiceEvaluationDate."')";

if(sqlsrv_query($conn, $sql)){
	echo "<span class='success' id='added'>Records inserted successfully.</span>";
	
	foreach($_FILES['cmsfile']['name'] as $key => $name) {
		move_uploaded_file($_FILES['cmsfile']['tmp_name'][$key], $target_dir . $newfilenames[$key]);
	}
	// ADD output for which files were uploaded.
	} 	else{
		echo "<span class='notice'>ERROR: Not able to execute $sql.</span><br/> " . sqlsrv_errors($conn);
	}



page_footer();
?>