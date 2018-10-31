<?php
session_start();
require_once ('cms_fns.php');
require_once ('forms_fns.php');

page_header('','main');

$costedit = $_POST['costedit'];
$fileedit = $_POST['fileedit'];
$updatefile = $_POST['updatefile'];
$uploadfile = $_POST['uploadfile'];
$updatesev = $_POST['updatesev'];
$new = $_POST['new'];
$delete = $_POST['delete'];
$filename = $_POST['filename']; //filename to be deleted from Archive

$coststrip = array("$",",","a","b","c","d","e","f","g","h","i","j","k","l","m","n","o","p","q","r","s","t","u","v","w","x","y","z",
"A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z",
"-","_","!","@","#","%","^","&","*","(",")","?","<",">","/");

if($delete == '1'){    //Delete file from Archive
	
	$conn = db_conn();
	$sql13 = "SELECT ArchiveID,ContractID,ArchivedFileName,DateArchived,FileType 
			FROM ContractFileArchive WHERE ArchivedFileName = '".$filename."'";
	$result13 = sqlsrv_query($conn,$sql13);
	$row13 = sqlsrv_fetch_array($result13, SQLSRV_FETCH_ASSOC);
	
	$id = $row13['ContractID'];
	$archiveID = $row13['ArchiveID'];
	$path = 'uploads/archived/';
	$fullpath = $path . $filename;
	
	$sql14 = "DELETE FROM ContractFileArchive WHERE ArchiveID = '".$archiveID."'";
	if(sqlsrv_query($conn,$sql14)){
		echo "<span class='success' id='added'>Record deleted successfully.</span>";
		unlink($fullpath);
		
		$conn2 = db_conn();
		$sql2 = "SELECT ContractID,ContractingEntity,Vendor,ContractType,ContractTitle,ContractDescription,Department,EOC,ResponsiblePartyPri,ResponsiblePartySec,
				  ResponsiblePartyTer,AdditionalReviewer1,AdditionalReviewer2,CONVERT(varchar(10),EffectiveDate,23) AS 'EffectiveDate',CONVERT(varchar(10),ExpirationDate,23) AS 'ExpirationDate',
				  AnnualCost1,AnnualCost2,AnnualCost3,AnnualCost4,AnnualCost5,AnnualCost6,AnnualCost7,AnnualCost8,AnnualCost9,AnnualCost10,ContractStatus,
				  AutoRenewal,AutoRenewalTerms,AutoRenewalTimes,CONVERT(varchar(10),AutoRenewalDeadline,23) AS 'AutoRenewalDeadline',ContractFileName,conUploadDate,BAAFileName,baaUploadDate,COIFileName,coiUploadDate,ServiceEvaluationPeriod,
				  ServiceEvaluationFileName,sevUploadDate,AddendumFileName,admUploadDate,MemorandumOfUnderstandingFileName,mouUploadDate,PurchaseOrderFileName,
				  poUploadDate,LastServiceEvaluationDate,NextServiceEvaluationDate 
				FROM ContractData WHERE ContractID = '".$id."'";
		$result = sqlsrv_query($conn2, $sql2);
		$row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);
		$costarray = array($row['AnnualCost1'],$row['AnnualCost2'],$row['AnnualCost3'],$row['AnnualCost4'],$row['AnnualCost5'],$row['AnnualCost6'],$row['AnnualCost7'],$row['AnnualCost8'],$row['AnnualCost9'],$row['AnnualCost10']);
		$totalcost = array_sum($costarray);
		
		$ContractingEntity 					= $row['ContractingEntity'];
		$Vendor 							= $row['Vendor'];
		$ContractType 						= $row['ContractType'];
		$ContractTitle						= $row['ContractTitle'];
		$ContractDescription 				= $row['ContractDescription'];
		$Department 						= $row['Department'];
		$EOC								= $row['EOC'];
		$ResponsiblePartyPri 				= $row['ResponsiblePartyPri'];
		$ResponsiblePartySec 				= $row['ResponsiblePartySec'];
		$ResponsiblePartyTer 				= $row['ResponsiblePartyTer'];
		$AdditionalReviewer1				= $row['AdditionalReviewer1'];
		$AdditionalReviewer2				= $row['AdditionalReviewer2'];
		$EffectiveDate 						= $row['EffectiveDate'];
		$ExpirationDate 					= $row['ExpirationDate'];
		$AnnualCost1						= $row['AnnualCost1'];
		$AnnualCost2                		= $row['AnnualCost2'];
		$AnnualCost3                		= $row['AnnualCost3'];
		$AnnualCost4                		= $row['AnnualCost4'];
		$AnnualCost5                		= $row['AnnualCost5'];
		$AnnualCost6                		= $row['AnnualCost6'];
		$AnnualCost7                		= $row['AnnualCost7'];
		$AnnualCost8                		= $row['AnnualCost8'];
		$AnnualCost9                		= $row['AnnualCost9'];
		$AnnualCost10               		= $row['AnnualCost10'];
		$ContractStatus 					= $row['ContractStatus'];
		$AutoRenewal 						= $row['AutoRenewal'];
		$AutoRenewalTerms 					= $row['AutoRenewalTerms'];
		$AutoRenewalTimes 					= $row['AutoRenewalTimes'];
		$AutoRenewalDeadline 				= $row['AutoRenewalDeadline'];
		$ServiceEvaluationPeriod 			= $row['ServiceEvaluationPeriod'];
		$ContractFileName					= $row['ContractFileName'];
		$conUploadDate						= $row['conUploadDate'];
		$BAAFileName                        = $row['BAAFileName'];
		$baaUploadDate						= $row['baaUploadDate'];
		$COIFileName                        = $row['COIFileName'];
		$coiUploadDate						= $row['coiUploadDate'];
		$ServiceEvaluationFileName          = $row['ServiceEvaluationFileName'];
		$sevUploadDate						= $row['sevUploadDate'];
		$AddendumFileName                   = $row['AddendumFileName'];
		$admUploadDate						= $row['admUploadDate'];
		$MemorandumOfUnderstandingFileName  = $row['MemorandumOfUnderstandingFileName'];
		$mouUploadDate						= $row['mouUploadDate'];
		$PurchaseOrderFileName	            = $row['PurchaseOrderFileName'];
		$poUploadDate						= $row['poUploadDate'];
		if($row['NextServiceEvaluationDate'] == NULL) {$NextServiceEvaluationDate = 'N/A';} else {$NextServiceEvaluationDate = $row['NextServiceEvaluationDate']->format('Y-m-d');}
		if($row['LastServiceEvaluationDate'] == NULL) {$LastServiceEvaluationDate = 'N/A';} else {$LastServiceEvaluationDate = $row['LastServiceEvaluationDate']->format('Y-m-d');}
		
	full_display();
		
		
	} else {
		"<span class='notice'>ERROR: Not able to delete file.</span><br/> " . sqlsrv_errors($conn);
	
		$conn2 = db_conn();
		$sql2 = "SELECT ContractID,ContractingEntity,Vendor,ContractType,ContractTitle,ContractDescription,Department,EOC,ResponsiblePartyPri,ResponsiblePartySec,
				  ResponsiblePartyTer,AdditionalReviewer1,AdditionalReviewer2,CONVERT(varchar(10),EffectiveDate,23) AS 'EffectiveDate',CONVERT(varchar(10),ExpirationDate,23) AS 'ExpirationDate',
				  AnnualCost1,AnnualCost2,AnnualCost3,AnnualCost4,AnnualCost5,AnnualCost6,AnnualCost7,AnnualCost8,AnnualCost9,AnnualCost10,ContractStatus,
				  AutoRenewal,AutoRenewalTerms,AutoRenewalTimes,CONVERT(varchar(10),AutoRenewalDeadline,23) AS 'AutoRenewalDeadline',ContractFileName,conUploadDate,BAAFileName,baaUploadDate,COIFileName,coiUploadDate,ServiceEvaluationPeriod,
				  ServiceEvaluationFileName,sevUploadDate,AddendumFileName,admUploadDate,MemorandumOfUnderstandingFileName,mouUploadDate,PurchaseOrderFileName,
				  poUploadDate,LastServiceEvaluationDate,NextServiceEvaluationDate 
				FROM ContractData WHERE ContractID = '".$id."'";
		$result = sqlsrv_query($conn2, $sql2);
		$row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);
		$costarray = array($row['AnnualCost1'],$row['AnnualCost2'],$row['AnnualCost3'],$row['AnnualCost4'],$row['AnnualCost5'],$row['AnnualCost6'],$row['AnnualCost7'],$row['AnnualCost8'],$row['AnnualCost9'],$row['AnnualCost10']);
		$totalcost = array_sum($costarray);
		
		$ContractingEntity 					= $row['ContractingEntity'];
		$Vendor 							= $row['Vendor'];
		$ContractType 						= $row['ContractType'];
		$ContractTitle						= $row['ContractTitle'];
		$ContractDescription 				= $row['ContractDescription'];
		$Department 						= $row['Department'];
		$EOC								= $row['EOC'];
		$ResponsiblePartyPri 				= $row['ResponsiblePartyPri'];
		$ResponsiblePartySec 				= $row['ResponsiblePartySec'];
		$ResponsiblePartyTer 				= $row['ResponsiblePartyTer'];
		$AdditionalReviewer1				= $row['AdditionalReviewer1'];
		$AdditionalReviewer2				= $row['AdditionalReviewer2'];
		$EffectiveDate 						= $row['EffectiveDate'];
		$ExpirationDate 					= $row['ExpirationDate'];
		$AnnualCost1						= $row['AnnualCost1'];
		$AnnualCost2                		= $row['AnnualCost2'];
		$AnnualCost3                		= $row['AnnualCost3'];
		$AnnualCost4                		= $row['AnnualCost4'];
		$AnnualCost5                		= $row['AnnualCost5'];
		$AnnualCost6                		= $row['AnnualCost6'];
		$AnnualCost7                		= $row['AnnualCost7'];
		$AnnualCost8                		= $row['AnnualCost8'];
		$AnnualCost9                		= $row['AnnualCost9'];
		$AnnualCost10               		= $row['AnnualCost10'];
		$ContractStatus 					= $row['ContractStatus'];
		$AutoRenewal 						= $row['AutoRenewal'];
		$AutoRenewalTerms 					= $row['AutoRenewalTerms'];
		$AutoRenewalTimes 					= $row['AutoRenewalTimes'];
		$AutoRenewalDeadline 				= $row['AutoRenewalDeadline'];
		$ServiceEvaluationPeriod 			= $row['ServiceEvaluationPeriod'];
		$ContractFileName					= $row['ContractFileName'];
		$conUploadDate						= $row['conUploadDate'];
		$BAAFileName                        = $row['BAAFileName'];
		$baaUploadDate						= $row['baaUploadDate'];
		$COIFileName                        = $row['COIFileName'];
		$coiUploadDate						= $row['coiUploadDate'];
		$ServiceEvaluationFileName          = $row['ServiceEvaluationFileName'];
		$sevUploadDate						= $row['sevUploadDate'];
		$AddendumFileName                   = $row['AddendumFileName'];
		$admUploadDate						= $row['admUploadDate'];
		$MemorandumOfUnderstandingFileName  = $row['MemorandumOfUnderstandingFileName'];
		$mouUploadDate						= $row['mouUploadDate'];
		$PurchaseOrderFileName	            = $row['PurchaseOrderFileName'];
		$poUploadDate						= $row['poUploadDate'];
		if($row['NextServiceEvaluationDate'] == NULL) {$NextServiceEvaluationDate = 'N/A';} else {$NextServiceEvaluationDate = $row['NextServiceEvaluationDate']->format('Y-m-d');}
		if($row['LastServiceEvaluationDate'] == NULL) {$LastServiceEvaluationDate = 'N/A';} else {$LastServiceEvaluationDate = $row['LastServiceEvaluationDate']->format('Y-m-d');}
		
	full_display();
	}
}elseif($new == '1'){   // IF New Contract entered
	 
	 ///////////////////POSTED FORM DATA////////////////////////
	$addContractingEntity 			= $_POST['ContractingEntity'];
	$addVendor 						= str_replace("'","''",$_POST['Vendor']);
	$addContractType 				= $_POST['ContractType'];
	$addContractTitle 				= str_replace("'","''",$_POST['ContractTitle']);
	$addContractDescription 		= str_replace("'","''",$_POST['ContractDescription']);
	$addDepartment 					= $_POST['Department'];
	$addEOC							= $_POST['EOC'];
	$addResponsiblePartyPri 		= $_POST['ResponsiblePartyPri'];
	$addResponsiblePartySec 		= $_POST['ResponsiblePartySec'];
	$addResponsiblePartyTer 		= $_POST['ResponsiblePartyTer'];
	$addAdditionalReviewer1 		= $_POST['AdditionalReviewer1'];
	$addAdditionalReviewer2 		= $_POST['AdditionalReviewer2'];
	$addEffectiveDate 				= $_POST['EffectiveDate'];
	$addExpirationDate 				= $_POST['ExpirationDate'];
	if($_POST['AnnualCost1'] == ''){$addAnnualCost1 = 0;}else{$addAnnualCost1 = str_replace($coststrip,"",$_POST['AnnualCost1']);}
	if($_POST['AnnualCost2'] == ''){$addAnnualCost2 = 0;}else{$addAnnualCost2 = str_replace($coststrip,"",$_POST['AnnualCost2']);}
	if($_POST['AnnualCost3'] == ''){$addAnnualCost3 = 0;}else{$addAnnualCost3 = str_replace($coststrip,"",$_POST['AnnualCost3']);}
	$addContractStatus 				= $_POST['ContractStatus'];
	$addAutoRenewal 				= $_POST['AutoRenewal'];
	$addAutoRenewalTerms 			= $_POST['AutoRenewalTerms'];
	$addAutoRenewalTimes 			= $_POST['AutoRenewalTimes'];
	$addAutoRenewalDeadline 		= $_POST['AutoRenewalDeadline'];
	$addServiceEvaluationPeriod 	= $_POST['ServiceEvaluationPeriod'];
	$addAnnualCost4 = 0;
	$addAnnualCost5 = 0;
	$addAnnualCost6 = 0;
	$addAnnualCost7 = 0;
	$addAnnualCost8 = 0;
	$addAnnualCost9 = 0;
	$addAnnualCost10 = 0;
	
	$confile = $_FILES['cmsfile']['name'][0];
	$baafile = $_FILES['cmsfile']['name'][1];
	$coifile = $_FILES['cmsfile']["name"][2];
	$sevfile = $_FILES['cmsfile']['name'][3];
	$admfile = $_FILES['cmsfile']['name'][4];
	$moufile = $_FILES['cmsfile']['name'][5];
	$pofile = $_FILES['cmsfile']['name'][6];
	//////////////////END POSTED FORM DATA/////////////////////
	
	$uploaddate = date('Y-m-d H:i:s');
	$initiallastsevdate = date('Y-m-d');
	if($addServiceEvaluationPeriod == 'Annual') {$interval = '1 year';} else {$interval = '6 months';}
	$date = date_create($addEffectiveDate);
	date_add($date,date_interval_create_from_date_string($interval));
	$addNextServiceEvaluationDate = date_format($date,'Y-m-d');
	
	/////////////////CREATE NEW FILE NAMES/////////////////////
	$unqconfilename = uniqid('con_',TRUE);
	$unqbaafilename = uniqid('baa_',TRUE);
	$unqcoifilename = uniqid('coi_',TRUE);
	$unqsevfilename = uniqid('sev_',TRUE);
	$unqadmfilename = uniqid('adm_',TRUE);
	$unqmoufilename = uniqid('mou_',TRUE);
	$unqpofilename = uniqid('po_',TRUE);
	
	$tempcon = explode('.',$confile);
	$tempbaa = explode('.',$baafile);
	$tempcoi = explode('.',$coifile);
	$tempsev = explode('.',$sevfile);
	$tempadm = explode('.',$admfile);
	$tempmou = explode('.',$moufile);
	$temppo  = explode('.',$pofile);
	
	$conext = end($tempcon);
	$baaext = end($tempbaa);
	$coiext = end($tempcoi);
	$sevext = end($tempsev);
	$admext = end($tempadm);
	$mouext = end($tempmou);
	$poext = end($temppo);
	
	if ($_FILES['cmsfile']['name'][0]) {$newconfilename = $unqconfilename . '.' . $conext; $addconUploadDate = $uploaddate; } ELSE {$newconfilename = NULL; $addconUploadDate = NULL;}
	if ($_FILES['cmsfile']['name'][1]) {$newbaafilename = $unqbaafilename . '.' . $baaext; $addbaaUploadDate = $uploaddate; } ELSE {$newbaafilename = NULL; $addbaaUploadDate = NULL;}
	if ($_FILES['cmsfile']['name'][2]) {$newcoifilename = $unqcoifilename . '.' . $coiext; $addcoiUploadDate = $uploaddate; } ELSE {$newcoifilename = NULL; $addcoiUploadDate = NULL;}
	if ($_FILES['cmsfile']['name'][3]) {$newsevfilename = $unqsevfilename . '.' . $sevext; $addsevUploadDate = $uploaddate; } ELSE {$newsevfilename = NULL; $addsevUploadDate = NULL;}
	if ($_FILES['cmsfile']['name'][4]) {$newadmfilename = $unqadmfilename . '.' . $admext; $addadmUploadDate = $uploaddate; } ELSE {$newadmfilename = NULL; $addadmUploadDate = NULL;}
	if ($_FILES['cmsfile']['name'][5]) {$newmoufilename = $unqmoufilename . '.' . $mouext; $addmouUploadDate = $uploaddate; } ELSE {$newmoufilename = NULL; $addmouUploadDate = NULL;}
	if ($_FILES['cmsfile']['name'][6]) {$newpofilename = $unqpofilename . '.' . $poext; $addpoUploadDate = $uploaddate; } ELSE {$newpofilename = NULL; $poUploadDate = NULL;}
	////////////////END CREATE NEW FILE NAMES//////////////////
	
	$newfilenames = array($newconfilename,$newbaafilename,$newcoifilename,$newsevfilename,$newadmfilename,$newmoufilename,$newpofilename);
	$target_dir = 'uploads/';
	
	$conn = db_conn();
	$sql12 = "INSERT INTO ContractData (ContractingEntity,Vendor,ContractType,ContractTitle,ContractDescription,Department,EOC,ResponsiblePartyPri,ResponsiblePartySec,
									ResponsiblePartyTer,AdditionalReviewer1,AdditionalReviewer2,EffectiveDate,ExpirationDate,AnnualCost1,AnnualCost2,AnnualCost3,AnnualCost4,AnnualCost5,AnnualCost6,AnnualCost7,AnnualCost8,AnnualCost9,AnnualCost10,ContractStatus,AutoRenewal,AutoRenewalTerms,AutoRenewalTimes,
									AutoRenewalDeadline,ContractFileName,conUploadDate,BAAFileName,baaUploadDate,COIFileName,coiUploadDate,ServiceEvaluationPeriod,ServiceEvaluationFileName,sevUploadDate,AddendumFileName,
									admUploadDate,MemorandumOfUnderstandingFileName,mouUploadDate,PurchaseOrderFileName,poUploadDate,LastServiceEvaluationDate,NextServiceEvaluationDate) 
			VALUES ('".$addContractingEntity."','".$addVendor."','".$addContractType."','".$addContractTitle."','".$addContractDescription."','".$addDepartment."','".$addEOC."','".$addResponsiblePartyPri."',
			'".$addResponsiblePartySec."','".$addResponsiblePartyTer."','".$addAdditionalReviewer1."','".$addAdditionalReviewer2."','".$addEffectiveDate."','".$addExpirationDate."','".$addAnnualCost1."','".$addAnnualCost2."','".$addAnnualCost3."','".$addAnnualCost4."',
			'".$addAnnualCost5."','".$addAnnualCost6."','".$addAnnualCost7."','".$addAnnualCost8."','".$addAnnualCost9."','".$addAnnualCost10."','".$addContractStatus."','".$addAutoRenewal."',
			'".$addAutoRenewalTerms."','".$addAutoRenewalTimes."','".$addAutoRenewalDeadline."','".$newconfilename."','".$addconUploadDate."','".$newbaafilename."','".$addbaaUploadDate."','".$newcoifilename."','".$addcoiUploadDate."','".$addServiceEvaluationPeriod."',
			'".$newsevfilename."','".$addsevUploadDate."','".$newadmfilename."','".$addadmUploadDate."','".$newmoufilename."','".$addmouUploadDate."','".$newpofilename."','".$addpoUploadDate."','".$initiallastsevdate."','".$addNextServiceEvaluationDate."')";
	
	if(sqlsrv_query($conn, $sql12)){
		echo "<span class='success' id='added'>Records inserted successfully.</span>";
		
		$sql11 = "SELECT ContractID,ContractingEntity,Vendor,ContractType,ContractTitle,ContractDescription,Department,EOC,ResponsiblePartyPri,ResponsiblePartySec,
				  ResponsiblePartyTer,AdditionalReviewer1,AdditionalReviewer2,CONVERT(varchar(10),EffectiveDate,23) AS 'EffectiveDate',CONVERT(varchar(10),ExpirationDate,23) AS 'ExpirationDate',
				  AnnualCost1,AnnualCost2,AnnualCost3,AnnualCost4,AnnualCost5,AnnualCost6,AnnualCost7,AnnualCost8,AnnualCost9,AnnualCost10,ContractStatus,
				  AutoRenewal,AutoRenewalTerms,AutoRenewalTimes,CONVERT(varchar(10),AutoRenewalDeadline,23) AS 'AutoRenewalDeadline',ContractFileName,conUploadDate,BAAFileName,baaUploadDate,COIFileName,coiUploadDate,ServiceEvaluationPeriod,
				  ServiceEvaluationFileName,sevUploadDate,AddendumFileName,admUploadDate,MemorandumOfUnderstandingFileName,mouUploadDate,PurchaseOrderFileName,
				  poUploadDate,LastServiceEvaluationDate,NextServiceEvaluationDate 
				  FROM ContractData WHERE ContractingEntity = '".$addContractingEntity."' AND Vendor = '".$addVendor."' AND ContractType = '".$addContractType."' 
				  AND ContractTitle = '".$addContractTitle."' AND Department = '".$addDepartment."'";
		$result11 							= sqlsrv_query($conn, $sql11);
		$row11 								= sqlsrv_fetch_array($result11, SQLSRV_FETCH_ASSOC);
		$costarray 							= array($row11['AnnualCost1'],$row11['AnnualCost2'],$row11['AnnualCost3'],$row11['AnnualCost4'],$row11['AnnualCost5'],$row11['AnnualCost6'],$row11['AnnualCost7'],$row11['AnnualCost8'],$row11['AnnualCost9'],$row11['AnnualCost10']);
		$totalcost 							= array_sum($costarray);
		$id 								= $row11['ContractID'];
		$ContractingEntity 					= $row11['ContractingEntity'];
		$Vendor 							= $row11['Vendor'];
		$ContractType 						= $row11['ContractType'];
		$ContractTitle						= $row11['ContractTitle'];
		$ContractDescription 				= $row11['ContractDescription'];
		$Department 						= $row11['Department'];
		$EOC 								= $row11['EOC'];
		$ResponsiblePartyPri 				= $row11['ResponsiblePartyPri'];
		$ResponsiblePartySec 				= $row11['ResponsiblePartySec'];
		$ResponsiblePartyTer 				= $row11['ResponsiblePartyTer'];
		$AdditionalReviewer1				= $row11['AdditionalReviewer1'];
		$AdditionalReviewer2				= $row11['AdditionalReviewer2'];
		$EffectiveDate 						= $row11['EffectiveDate'];
		$ExpirationDate 					= $row11['ExpirationDate'];
		$AnnualCost1						= $row11['AnnualCost1'];
		$AnnualCost2                		= $row11['AnnualCost2'];
		$AnnualCost3                		= $row11['AnnualCost3'];
		$AnnualCost4                		= $row11['AnnualCost4'];
		$AnnualCost5                		= $row11['AnnualCost5'];
		$AnnualCost6                		= $row11['AnnualCost6'];
		$AnnualCost7                		= $row11['AnnualCost7'];
		$AnnualCost8                		= $row11['AnnualCost8'];
		$AnnualCost9                		= $row11['AnnualCost9'];
		$AnnualCost10               		= $row11['AnnualCost10'];
		$ContractStatus 					= $row11['ContractStatus'];
		$AutoRenewal 						= $row11['AutoRenewal'];
		$AutoRenewalTerms 					= $row11['AutoRenewalTerms'];
		$AutoRenewalTimes 					= $row11['AutoRenewalTimes'];
		$AutoRenewalDeadline 				= $row11['AutoRenewalDeadline'];
		$ServiceEvaluationPeriod 			= $row11['ServiceEvaluationPeriod'];
		$ContractFileName					= $row11['ContractFileName'];
		$conUploadDate						= $row11['conUploadDate'];
		$BAAFileName                        = $row11['BAAFileName'];
		$baaUploadDate						= $row11['baaUploadDate'];
		$COIFileName                        = $row11['COIFileName'];
		$coiUploadDate						= $row11['coiUploadDate'];
		$ServiceEvaluationFileName          = $row11['ServiceEvaluationFileName'];
		$sevUploadDate						= $row11['sevUploadDate'];
		$AddendumFileName                   = $row11['AddendumFileName'];
		$admUploadDate						= $row11['admUploadDate'];
		$MemorandumOfUnderstandingFileName  = $row11['MemorandumOfUnderstandingFileName'];
		$mouUploadDate						= $row11['mouUploadDate'];
		$PurchaseOrderFileName	            = $row11['PurchaseOrderFileName'];
		$poUploadDate						= $row11['poUploadDate'];
		if($row11['LastServiceEvaluationDate'] == NULL) {$LastServiceEvaluationDate = 'N/A';} else {$LastServiceEvaluationDate = $row11['LastServiceEvaluationDate']->format('Y-m-d');}
		if($row11['NextServiceEvaluationDate'] == NULL) {$NextServiceEvaluationDate = 'N/A';} else {$NextServiceEvaluationDate = $row11['NextServiceEvaluationDate']->format('Y-m-d');}
		
	full_display();
		
		foreach($_FILES['cmsfile']['name'] as $key => $name) {
			move_uploaded_file($_FILES['cmsfile']['tmp_name'][$key], $target_dir . $newfilenames[$key]);
		}
		// ADD output for which files were uploaded.
		} 	else{
			echo "<span class='notice'>ERROR: Not able to execute $sql.</span><br/> " . sqlsrv_errors($conn);
		}
		
	} elseif(isset($_POST['backid'])) {     //If user clicked 'Back' button from any of the 'edit' pages
		$id = $_POST['backid'];
		$conn = db_conn();
		$sql = "SELECT ContractID,ContractingEntity,Vendor,ContractType,ContractTitle,ContractDescription,Department,EOC,ResponsiblePartyPri,ResponsiblePartySec,
				  ResponsiblePartyTer,AdditionalReviewer1,AdditionalReviewer2,CONVERT(varchar(10),EffectiveDate,23) AS 'EffectiveDate',CONVERT(varchar(10),ExpirationDate,23) AS 'ExpirationDate',
				  AnnualCost1,AnnualCost2,AnnualCost3,AnnualCost4,AnnualCost5,AnnualCost6,AnnualCost7,AnnualCost8,AnnualCost9,AnnualCost10,ContractStatus,
				  AutoRenewal,AutoRenewalTerms,AutoRenewalTimes,CONVERT(varchar(10),AutoRenewalDeadline,23) AS 'AutoRenewalDeadline',ContractFileName,conUploadDate,BAAFileName,baaUploadDate,COIFileName,coiUploadDate,ServiceEvaluationPeriod,
				  ServiceEvaluationFileName,sevUploadDate,AddendumFileName,admUploadDate,MemorandumOfUnderstandingFileName,mouUploadDate,PurchaseOrderFileName,
				  poUploadDate,LastServiceEvaluationDate,NextServiceEvaluationDate FROM ContractData WHERE ContractID = '".$id."'";
		$result = sqlsrv_query($conn, $sql);
		$row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);
		$costarray = array($row['AnnualCost1'],$row['AnnualCost2'],$row['AnnualCost3'],$row['AnnualCost4'],$row['AnnualCost5'],$row['AnnualCost6'],$row['AnnualCost7'],$row['AnnualCost8'],$row['AnnualCost9'],$row['AnnualCost10']);
		$totalcost = array_sum($costarray);
		$ContractingEntity 					= $row['ContractingEntity'];
		$Vendor 							= $row['Vendor'];
		$ContractType 						= $row['ContractType'];
		$ContractTitle						= $row['ContractTitle'];
		$ContractDescription 				= $row['ContractDescription'];
		$Department 						= $row['Department'];
		$EOC		 						= $row['EOC'];
		$ResponsiblePartyPri 				= $row['ResponsiblePartyPri'];
		$ResponsiblePartySec 				= $row['ResponsiblePartySec'];
		$ResponsiblePartyTer 				= $row['ResponsiblePartyTer'];
		$AdditionalReviewer1				= $row['AdditionalReviewer1'];
		$AdditionalReviewer2				= $row['AdditionalReviewer2'];
		$EffectiveDate 						= $row['EffectiveDate'];
		$ExpirationDate 					= $row['ExpirationDate'];
		$AnnualCost1						= $row['AnnualCost1'];
		$AnnualCost2                		= $row['AnnualCost2'];
		$AnnualCost3                		= $row['AnnualCost3'];
		$AnnualCost4                		= $row['AnnualCost4'];
		$AnnualCost5                		= $row['AnnualCost5'];
		$AnnualCost6                		= $row['AnnualCost6'];
		$AnnualCost7                		= $row['AnnualCost7'];
		$AnnualCost8                		= $row['AnnualCost8'];
		$AnnualCost9                		= $row['AnnualCost9'];
		$AnnualCost10               		= $row['AnnualCost10'];
		$ContractStatus 					= $row['ContractStatus'];
		$AutoRenewal 						= $row['AutoRenewal'];
		$AutoRenewalTerms 					= $row['AutoRenewalTerms'];
		$AutoRenewalTimes 					= $row['AutoRenewalTimes'];
		$AutoRenewalDeadline 				= $row['AutoRenewalDeadline'];
		$ServiceEvaluationPeriod 			= $row['ServiceEvaluationPeriod'];
		$ContractFileName					= $row['ContractFileName'];
		$conUploadDate						= $row['conUploadDate'];
		$BAAFileName                        = $row['BAAFileName'];
		$baaUploadDate						= $row['baaUploadDate'];
		$COIFileName                        = $row['COIFileName'];
		$coiUploadDate						= $row['coiUploadDate'];
		$ServiceEvaluationFileName          = $row['ServiceEvaluationFileName'];
		$sevUploadDate						= $row['sevUploadDate'];
		$AddendumFileName                   = $row['AddendumFileName'];
		$admUploadDate						= $row['admUploadDate'];
		$MemorandumOfUnderstandingFileName  = $row['MemorandumOfUnderstandingFileName'];
		$mouUploadDate						= $row['mouUploadDate'];
		$PurchaseOrderFileName	            = $row['PurchaseOrderFileName'];
		$poUploadDate						= $row['poUploadDate'];
		if($row['LastServiceEvaluationDate'] == NULL) {$LastServiceEvaluationDate = 'N/A';} else {$LastServiceEvaluationDate = $row['LastServiceEvaluationDate']->format('Y-m-d');}
		if($row['NextServiceEvaluationDate'] == NULL) {$NextServiceEvaluationDate = 'N/A';} else {$NextServiceEvaluationDate = $row['NextServiceEvaluationDate']->format('Y-m-d');}
		
	full_display();

} elseif($costedit == '1') { //if Cost Info is edited it returns here


	$id = $_POST['ContractID'];
		
	$conn = db_conn();
	$sqlCOST = "SELECT AnnualCost1,AnnualCost2,AnnualCost3,AnnualCost4,AnnualCost5,AnnualCost6,AnnualCost7,AnnualCost8,AnnualCost9,AnnualCost10 
				FROM ContractData WHERE ContractID = '".$id."'";
	$resultCOST = sqlsrv_query($conn, $sqlCOST);
	$rowCOST = sqlsrv_fetch_array($resultCOST, SQLSRV_FETCH_ASSOC);
	
	
	if($_POST['AnnualCost1'] == '') {$AnnualCost1 = $rowCOST['AnnualCost1'];} else {$AnnualCost1 = str_replace($coststrip,"",$_POST['AnnualCost1']);}
	if($_POST['AnnualCost2'] == '') {$AnnualCost2 = $rowCOST['AnnualCost2'];} else {$AnnualCost2 = str_replace($coststrip,"",$_POST['AnnualCost2']);}
	if($_POST['AnnualCost3'] == '') {$AnnualCost3 = $rowCOST['AnnualCost3'];} else {$AnnualCost3 = str_replace($coststrip,"",$_POST['AnnualCost3']);}
	if($_POST['AnnualCost4'] == '') {$AnnualCost4 = $rowCOST['AnnualCost4'];} else {$AnnualCost4 = str_replace($coststrip,"",$_POST['AnnualCost4']);}
	if($_POST['AnnualCost5'] == '') {$AnnualCost5 = $rowCOST['AnnualCost5'];} else {$AnnualCost5 = str_replace($coststrip,"",$_POST['AnnualCost5']);}
	if($_POST['AnnualCost6'] == '') {$AnnualCost6 = $rowCOST['AnnualCost6'];} else {$AnnualCost6 = str_replace($coststrip,"",$_POST['AnnualCost6']);}
	if($_POST['AnnualCost7'] == '') {$AnnualCost7 = $rowCOST['AnnualCost7'];} else {$AnnualCost7 = str_replace($coststrip,"",$_POST['AnnualCost7']);}
	if($_POST['AnnualCost8'] == '') {$AnnualCost8 = $rowCOST['AnnualCost8'];} else {$AnnualCost8 = str_replace($coststrip,"",$_POST['AnnualCost8']);}
	if($_POST['AnnualCost9'] == '') {$AnnualCost9 = $rowCOST['AnnualCost9'];} else {$AnnualCost9 = str_replace($coststrip,"",$_POST['AnnualCost9']);}
	if($_POST['AnnualCost10'] == '') {$AnnualCost10 = $rowCOST['AnnualCost10'];} else {$AnnualCost10 = str_replace($coststrip,"",$_POST['AnnualCost10']);}
	
	if(!is_numeric($AnnualCost1) || !is_numeric($AnnualCost2) || !is_numeric($AnnualCost3) || !is_numeric($AnnualCost4) || !is_numeric($AnnualCost5) || 
	   !is_numeric($AnnualCost6) || !is_numeric($AnnualCost7) || !is_numeric($AnnualCost8) || !is_numeric($AnnualCost9) || !is_numeric($AnnualCost10)) {
			
		$conn = db_conn();
		$sql = "SELECT ContractID,ContractingEntity,Vendor,ContractType,ContractTitle,ContractDescription,Department,EOC,ResponsiblePartyPri,ResponsiblePartySec,
				  ResponsiblePartyTer,AdditionalReviewer1,AdditionalReviewer2,CONVERT(varchar(10),EffectiveDate,23) AS 'EffectiveDate',CONVERT(varchar(10),ExpirationDate,23) AS 'ExpirationDate',
				  AnnualCost1,AnnualCost2,AnnualCost3,AnnualCost4,AnnualCost5,AnnualCost6,AnnualCost7,AnnualCost8,AnnualCost9,AnnualCost10,ContractStatus,
				  AutoRenewal,AutoRenewalTerms,AutoRenewalTimes,CONVERT(varchar(10),AutoRenewalDeadline,23) AS 'AutoRenewalDeadline',ContractFileName,conUploadDate,BAAFileName,baaUploadDate,COIFileName,coiUploadDate,ServiceEvaluationPeriod,
				  ServiceEvaluationFileName,sevUploadDate,AddendumFileName,admUploadDate,MemorandumOfUnderstandingFileName,mouUploadDate,PurchaseOrderFileName,
				  poUploadDate,LastServiceEvaluationDate,NextServiceEvaluationDate FROM ContractData WHERE ContractID = '".$id."'";
		$result = sqlsrv_query($conn, $sql);
		$row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);
		$costarray = array($row['AnnualCost1'],$row['AnnualCost2'],$row['AnnualCost3'],$row['AnnualCost4'],$row['AnnualCost5'],$row['AnnualCost6'],$row['AnnualCost7'],$row['AnnualCost8'],$row['AnnualCost9'],$row['AnnualCost10']);
		$totalcost = array_sum($costarray);
		
		$ContractingEntity 					= $row['ContractingEntity'];
		$Vendor 							= $row['Vendor'];
		$ContractType 						= $row['ContractType'];
		$ContractTitle						= $row['ContractTitle'];
		$ContractDescription 				= $row['ContractDescription'];
		$Department 						= $row['Department'];
		$EOC								= $row['EOC'];
		$ResponsiblePartyPri 				= $row['ResponsiblePartyPri'];
		$ResponsiblePartySec 				= $row['ResponsiblePartySec'];
		$ResponsiblePartyTer 				= $row['ResponsiblePartyTer'];
		$AdditionalReviewer1				= $row['AdditionalReviewer1'];
		$AdditionalReviewer2				= $row['AdditionalReviewer2'];
		$EffectiveDate 						= $row['EffectiveDate'];
		$ExpirationDate 					= $row['ExpirationDate'];
		$AnnualCost1						= $row['AnnualCost1'];
		$AnnualCost2                		= $row['AnnualCost2'];
		$AnnualCost3                		= $row['AnnualCost3'];
		$AnnualCost4                		= $row['AnnualCost4'];
		$AnnualCost5                		= $row['AnnualCost5'];
		$AnnualCost6                		= $row['AnnualCost6'];
		$AnnualCost7                		= $row['AnnualCost7'];
		$AnnualCost8                		= $row['AnnualCost8'];
		$AnnualCost9                		= $row['AnnualCost9'];
		$AnnualCost10               		= $row['AnnualCost10'];
		$ContractStatus 					= $row['ContractStatus'];
		$AutoRenewal 						= $row['AutoRenewal'];
		$AutoRenewalTerms 					= $row['AutoRenewalTerms'];
		$AutoRenewalTimes 					= $row['AutoRenewalTimes'];
		$AutoRenewalDeadline 				= $row['AutoRenewalDeadline'];
		$ServiceEvaluationPeriod 			= $row['ServiceEvaluationPeriod'];
		$ContractFileName					= $row['ContractFileName'];
		$conUploadDate						= $row['conUploadDate'];
		$BAAFileName                        = $row['BAAFileName'];
		$baaUploadDate						= $row['baaUploadDate'];
		$COIFileName                        = $row['COIFileName'];
		$coiUploadDate						= $row['coiUploadDate'];
		$ServiceEvaluationFileName          = $row['ServiceEvaluationFileName'];
		$sevUploadDate						= $row['sevUploadDate'];
		$AddendumFileName                   = $row['AddendumFileName'];
		$admUploadDate						= $row['admUploadDate'];
		$MemorandumOfUnderstandingFileName  = $row['MemorandumOfUnderstandingFileName'];
		$mouUploadDate						= $row['mouUploadDate'];
		$PurchaseOrderFileName	            = $row['PurchaseOrderFileName'];
		$poUploadDate						= $row['poUploadDate'];
		if($row['NextServiceEvaluationDate'] == NULL) {$NextServiceEvaluationDate = 'N/A';} else {$NextServiceEvaluationDate = $row['NextServiceEvaluationDate']->format('Y-m-d');}
		if($row['LastServiceEvaluationDate'] == NULL) {$LastServiceEvaluationDate = 'N/A';} else {$LastServiceEvaluationDate = $row['LastServiceEvaluationDate']->format('Y-m-d');}
		
	echo "<span class='notice' id='full'>Error: Only numeric values can be used in the Cost Info fields.  The database has not been updated.</span>";

	full_display();
			
	   } else {
	
	$sql2 = "UPDATE ContractData SET 
			AnnualCost1 = '".$AnnualCost1."', 
			AnnualCost2 = '".$AnnualCost2."',
			AnnualCost3 = '".$AnnualCost3."',
			AnnualCost4 = '".$AnnualCost4."',
			AnnualCost5 = '".$AnnualCost5."',
			AnnualCost6 = '".$AnnualCost6."',
			AnnualCost7 = '".$AnnualCost7."',
			AnnualCost8 = '".$AnnualCost8."',
			AnnualCost9 = '".$AnnualCost9."',
			AnnualCost10 = '".$AnnualCost10."'
			WHERE ContractID = '".$id."'";
	$result2 = sqlsrv_query($conn, $sql2);
	}
	
	if($result2) {
		
		$conn = db_conn();
		$sql = "SELECT ContractID,ContractingEntity,Vendor,ContractType,ContractTitle,ContractDescription,Department,EOC,ResponsiblePartyPri,ResponsiblePartySec,
				  ResponsiblePartyTer,AdditionalReviewer1,AdditionalReviewer2,CONVERT(varchar(10),EffectiveDate,23) AS 'EffectiveDate',CONVERT(varchar(10),ExpirationDate,23) AS 'ExpirationDate',
				  AnnualCost1,AnnualCost2,AnnualCost3,AnnualCost4,AnnualCost5,AnnualCost6,AnnualCost7,AnnualCost8,AnnualCost9,AnnualCost10,ContractStatus,
				  AutoRenewal,AutoRenewalTerms,AutoRenewalTimes,CONVERT(varchar(10),AutoRenewalDeadline,23) AS 'AutoRenewalDeadline',ContractFileName,conUploadDate,BAAFileName,baaUploadDate,COIFileName,coiUploadDate,ServiceEvaluationPeriod,
				  ServiceEvaluationFileName,sevUploadDate,AddendumFileName,admUploadDate,MemorandumOfUnderstandingFileName,mouUploadDate,PurchaseOrderFileName,
				  poUploadDate,LastServiceEvaluationDate,NextServiceEvaluationDate FROM ContractData WHERE ContractID = '".$id."'";
		$result = sqlsrv_query($conn, $sql);
		$row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);
		$costarray = array($row['AnnualCost1'],$row['AnnualCost2'],$row['AnnualCost3'],$row['AnnualCost4'],$row['AnnualCost5'],$row['AnnualCost6'],$row['AnnualCost7'],$row['AnnualCost8'],$row['AnnualCost9'],$row['AnnualCost10']);
		$totalcost = array_sum($costarray);
		
		$ContractingEntity 					= $row['ContractingEntity'];
		$Vendor 							= $row['Vendor'];
		$ContractType 						= $row['ContractType'];
		$ContractTitle						= $row['ContractTitle'];
		$ContractDescription 				= $row['ContractDescription'];
		$Department 						= $row['Department'];
		$EOC 								= $row['EOC'];
		$ResponsiblePartyPri 				= $row['ResponsiblePartyPri'];
		$ResponsiblePartySec 				= $row['ResponsiblePartySec'];
		$ResponsiblePartyTer 				= $row['ResponsiblePartyTer'];
		$AdditionalReviewer1				= $row['AdditionalReviewer1'];
		$AdditionalReviewer2				= $row['AdditionalReviewer2'];
		$EffectiveDate 						= $row['EffectiveDate'];
		$ExpirationDate 					= $row['ExpirationDate'];
		$AnnualCost1						= $row['AnnualCost1'];
		$AnnualCost2                		= $row['AnnualCost2'];
		$AnnualCost3                		= $row['AnnualCost3'];
		$AnnualCost4                		= $row['AnnualCost4'];
		$AnnualCost5                		= $row['AnnualCost5'];
		$AnnualCost6                		= $row['AnnualCost6'];
		$AnnualCost7                		= $row['AnnualCost7'];
		$AnnualCost8                		= $row['AnnualCost8'];
		$AnnualCost9                		= $row['AnnualCost9'];
		$AnnualCost10               		= $row['AnnualCost10'];
		$ContractStatus 					= $row['ContractStatus'];
		$AutoRenewal 						= $row['AutoRenewal'];
		$AutoRenewalTerms 					= $row['AutoRenewalTerms'];
		$AutoRenewalTimes 					= $row['AutoRenewalTimes'];
		$AutoRenewalDeadline 				= $row['AutoRenewalDeadline'];
		$ServiceEvaluationPeriod 			= $row['ServiceEvaluationPeriod'];
		$ContractFileName					= $row['ContractFileName'];
		$conUploadDate						= $row['conUploadDate'];
		$BAAFileName                        = $row['BAAFileName'];
		$baaUploadDate						= $row['baaUploadDate'];
		$COIFileName                        = $row['COIFileName'];
		$coiUploadDate						= $row['coiUploadDate'];
		$ServiceEvaluationFileName          = $row['ServiceEvaluationFileName'];
		$sevUploadDate						= $row['sevUploadDate'];
		$AddendumFileName                   = $row['AddendumFileName'];
		$admUploadDate						= $row['admUploadDate'];
		$MemorandumOfUnderstandingFileName  = $row['MemorandumOfUnderstandingFileName'];
		$mouUploadDate						= $row['mouUploadDate'];
		$PurchaseOrderFileName	            = $row['PurchaseOrderFileName'];
		$poUploadDate						= $row['poUploadDate'];
		if($row['NextServiceEvaluationDate'] == NULL) {$NextServiceEvaluationDate = 'N/A';} else {$NextServiceEvaluationDate = $row['NextServiceEvaluationDate']->format('Y-m-d');}
		if($row['LastServiceEvaluationDate'] == NULL) {$LastServiceEvaluationDate = 'N/A';} else {$LastServiceEvaluationDate = $row['LastServiceEvaluationDate']->format('Y-m-d');}
		
	echo "<span class='success' id='full'>The cost information has been updated successfully.</span>";

	full_display();
} 

} elseif($fileedit == '1') { //if File Info is edited it returns here
	
	$id = $_POST['ContractID'];
	$date = date('Y-m-d H:i:s');
	$confile = $_FILES['cmsfile']['name'][0];  //Contract
	$baafile = $_FILES['cmsfile']['name'][1];  //BAA
	$coifile = $_FILES["cmsfile"]['name'][2];  //COI
	$sevfile = $_FILES['cmsfile']['name'][3];  //ServiceEvaluation
	$admfile = $_FILES['cmsfile']['name'][4];  //Addendum
	$moufile = $_FILES['cmsfile']['name'][5];  //MemorandumOfUnderstanding
	$pofile = $_FILES['cmsfile']['name'][6];   //PurchaseOrder

	if($updatefile == '1') {   //if UPDATING existing files
		///////// GET EXISTING FILE NAMES /////////
		$conn3 = db_conn();
		$sql3 = "SELECT ContractID,ContractFileName,conUploadDate,BAAFileName,baaUploadDate,COIFileName,coiUploadDate,ServiceEvaluationFileName,sevUploadDate,
				 AddendumFileName,admUploadDate,MemorandumOfUnderstandingFileName,mouUploadDate,PurchaseOrderFileName,poUploadDate FROM ContractData WHERE ContractID = '".$id."'";
		$result3 = sqlsrv_query($conn3, $sql3);
		$row3 = sqlsrv_fetch_array($result3, SQLSRV_FETCH_ASSOC);
	
		$EXISTINGconfile = $row3['ContractFileName'];
		$EXISTINGbaafile = $row3['BAAFileName'];
		$EXISTINGcoifile = $row3['COIFileName'];
		$EXISTINGsevfile = $row3['ServiceEvaluationFileName'];
		$EXISTINGadmfile = $row3['AddendumFileName'];
		$EXISTINGmoufile = $row3['MemorandumOfUnderstandingFileName'];
		$EXISTINGpofile = $row3['PurchaseOrderFileName'];
		
		if($row3['conUploadDate'] == NULL){$EXISTINGconDate = NULL;}else{$EXISTINGconDate = $row3['conUploadDate']->format('Y-m-d H:i:s');}
		if($row3['baaUploadDate'] == NULL){$EXISTINGbaaDate = NULL;}else{$EXISTINGbaaDate = $row3['baaUploadDate']->format('Y-m-d H:i:s');}
		if($row3['coiUploadDate'] == NULL){$EXISTINGcoiDate = NULL;}else{$EXISTINGcoiDate = $row3['coiUploadDate']->format('Y-m-d H:i:s');}
		if($row3['sevUploadDate'] == NULL){$EXISTINGsevDate = NULL;}else{$EXISTINGsevDate = $row3['sevUploadDate']->format('Y-m-d H:i:s');}
		if($row3['admUploadDate'] == NULL){$EXISTINGadmDate = NULL;}else{$EXISTINGadmDate = $row3['admUploadDate']->format('Y-m-d H:i:s');}
		if($row3['mouUploadDate'] == NULL){$EXISTINGmouDate = NULL;}else{$EXISTINGmouDate = $row3['mouUploadDate']->format('Y-m-d H:i:s');}
		if($row3['poUploadDate'] == NULL){$EXISTINGpoDate = NULL;}  else{$EXISTINGpoDate = $row3['poUploadDate']->format('Y-m-d H:i:s');}
		
		///////// END GET EXISTING FILE NAMES AND UPLOAD DATES /////////
	
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
		
		if ($confile != '') {
			$conupdate = $date;
			$newconfilename = $unqconfilename . '.' . $conext; 
			rename('uploads/'.$EXISTINGconfile,'uploads/archived/'.$EXISTINGconfile);
			$sql4 = "INSERT INTO ContractFileArchive (ContractID,ArchivedFileName,DateArchived,FileType) VALUES ('".$id."','".$EXISTINGconfile."','".$date."','Contract')";
			$result4 = sqlsrv_query($conn3, $sql4);
			$row4 = sqlsrv_fetch_array($result4, SQLSRV_FETCH_ASSOC);
			} ELSE {
				$newconfilename = $EXISTINGconfile;
				$conupdate = $EXISTINGconDate;
			}
		if ($baafile != '') {
			$baaupdate = $date;
			$newbaafilename = $unqbaafilename . '.' . $baaext; 
			rename('uploads/'.$EXISTINGbaafile,'uploads/archived/'.$EXISTINGbaafile);
			$sql4 = "INSERT INTO ContractFileArchive (ContractID,ArchivedFileName,DateArchived,FileType) VALUES ('".$id."','".$EXISTINGbaafile."','".$date."','BAA')";
			$result4 = sqlsrv_query($conn3, $sql4);
			$row4 = sqlsrv_fetch_array($result4, SQLSRV_FETCH_ASSOC);
			} ELSE {
				$newbaafilename = $EXISTINGbaafile;
				$baaupdate = $EXISTINGbaaDate;
			}
		if ($coifile != '') {
			$coiupdate = $date;
			$newcoifilename = $unqcoifilename . '.' . $coiext; 
			rename('uploads/'.$EXISTINGcoifile,'uploads/archived/'.$EXISTINGcoifile);
			$sql4 = "INSERT INTO ContractFileArchive (ContractID,ArchivedFileName,DateArchived,FileType) VALUES ('".$id."','".$EXISTINGcoifile."','".$date."','COI')";
			$result4 = sqlsrv_query($conn3, $sql4);
			$row4 = sqlsrv_fetch_array($result4, SQLSRV_FETCH_ASSOC);
			} ELSE {
				$newcoifilename = $EXISTINGcoifile;
				$coiupdate = $EXISTINGcoiDate;
			}
		if ($sevfile != '') {
			$sevupdate = $date;
			$newsevfilename = $unqsevfilename . '.' . $sevext;
			rename('uploads/'.$EXISTINGsevfile,'uploads/archived/'.$EXISTINGsevfile);
			$sql4 = "INSERT INTO ContractFileArchive (ContractID,ArchivedFileName,DateArchived,FileType) VALUES ('".$id."','".$EXISTINGsevfile."','".$date."','Service Evaluation')";
			$result4 = sqlsrv_query($conn3, $sql4);
			$row4 = sqlsrv_fetch_array($result4, SQLSRV_FETCH_ASSOC);
			} ELSE {
				$newsevfilename = $EXISTINGsevfile;
				$sevupdate = $EXISTINGsevDate;
			}
		if ($admfile != '') {
			$admupdate = $date;
			$newadmfilename = $unqadmfilename . '.' . $admext;
			rename('uploads/'.$EXISTINGadmfile,'uploads/archived/'.$EXISTINGadmfile);
			$sql4 = "INSERT INTO ContractFileArchive (ContractID,ArchivedFileName,DateArchived,FileType) VALUES ('".$id."','".$EXISTINGadmfile."','".$date."','Addendum')";
			$result4 = sqlsrv_query($conn3, $sql4);
			$row4 = sqlsrv_fetch_array($result4, SQLSRV_FETCH_ASSOC);
			} ELSE {
				$newadmfilename = $EXISTINGadmfile;
				$admupdate = $EXISTINGadmDate;
			}
		if ($moufile != '') {
			$mouupdate = $date;
			$newmoufilename = $unqmoufilename . '.' . $mouext;
			rename('uploads/'.$EXISTINGmoufile,'uploads/archived/'.$EXISTINGmoufile);
			$sql4 = "INSERT INTO ContractFileArchive (ContractID,ArchivedFileName,DateArchived,FileType) VALUES ('".$id."','".$EXISTINGmoufile."','".$date."','Memorandum of Understanding')";
			$result4 = sqlsrv_query($conn3, $sql4);
			$row4 = sqlsrv_fetch_array($result4, SQLSRV_FETCH_ASSOC);
			} ELSE {
				$newmoufilename = $EXISTINGmoufile;
				$mouupdate = $EXISTINGmouDate;
			}
		if ($pofile != '') {
			$poupdate = $date;
			$newpofilename = $unqpofilename . '.' . $poext; 
			rename('uploads/'.$EXISTINGpofile,'uploads/archived/'.$EXISTINGpofile);
			$sql4 = "INSERT INTO ContractFileArchive (ContractID,ArchivedFileName,DateArchived,FileType) VALUES ('".$id."','".$EXISTINGpofile."','".$date."','Purchase Order')";
			$result4 = sqlsrv_query($conn3, $sql4);
			$row4 = sqlsrv_fetch_array($result4, SQLSRV_FETCH_ASSOC);
			} ELSE {
				$newpofilename = $EXISTINGpofile;
				$poupdate = $EXISTINGpoDate;
			}
		////////////////END CREATE NEW FILE NAMES//////////////////
		
		$newfilenames = array($newconfilename,$newbaafilename,$newcoifilename,$newsevfilename,$newadmfilename,$newmoufilename,$newpofilename);
		$target_dir = 'uploads/';
		
		$conn = db_conn();
		$sql = "UPDATE ContractData SET
				ContractFileName = '".$newconfilename."',
				conUploadDate = '".$conupdate."',
				BAAFileName = '".$newbaafilename."',
				baaUploadDate = '".$baaupdate."',
				COIFileName = '".$newcoifilename."',
				coiUploadDate = '".$coiupdate."',
				ServiceEvaluationFileName = '".$newsevfilename."',
				sevUploadDate = '".$sevupdate."',
				AddendumFileName = '".$newadmfilename."',
				admUploadDate = '".$admupdate."',
				MemorandumOfUnderstandingFileName = '".$newmoufilename."',
				mouUploadDate = '".$mouupdate."',
				PurchaseOrderFileName = '".$newpofilename."',
				poUploadDate = '".$poupdate."'
				WHERE ContractID = '".$id."'";
		
		if(sqlsrv_query($conn, $sql)){
			echo "<span class='success' id='full'>File(s) uploaded successfully. The database has been updated.</span>";
			
			foreach($_FILES['cmsfile']['name'] as $key => $name) {
				move_uploaded_file($_FILES['cmsfile']['tmp_name'][$key], $target_dir . $newfilenames[$key]);
				
			}
			// ADD output for which files were uploaded.
			} 	else{
				echo "<span class='notice' id='full'>ERROR: Not able to execute query.$sql</span> "; //. sqlsrv_errors($conn);
			}
		
		$conn2 = db_conn();
		$sql2 = "SELECT ContractID,ContractingEntity,Vendor,ContractType,ContractTitle,ContractDescription,Department,EOC,ResponsiblePartyPri,ResponsiblePartySec,
				  ResponsiblePartyTer,AdditionalReviewer1,AdditionalReviewer2,CONVERT(varchar(10),EffectiveDate,23) AS 'EffectiveDate',CONVERT(varchar(10),ExpirationDate,23) AS 'ExpirationDate',
				  AnnualCost1,AnnualCost2,AnnualCost3,AnnualCost4,AnnualCost5,AnnualCost6,AnnualCost7,AnnualCost8,AnnualCost9,AnnualCost10,ContractStatus,
				  AutoRenewal,AutoRenewalTerms,AutoRenewalTimes,CONVERT(varchar(10),AutoRenewalDeadline,23) AS 'AutoRenewalDeadline',ContractFileName,conUploadDate,BAAFileName,baaUploadDate,COIFileName,coiUploadDate,ServiceEvaluationPeriod,
				  ServiceEvaluationFileName,sevUploadDate,AddendumFileName,admUploadDate,MemorandumOfUnderstandingFileName,mouUploadDate,PurchaseOrderFileName,
				  poUploadDate,LastServiceEvaluationDate,NextServiceEvaluationDate 
				FROM ContractData WHERE ContractID = '".$id."'";
		$result = sqlsrv_query($conn2, $sql2);
		$row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);
		$costarray = array($row['AnnualCost1'],$row['AnnualCost2'],$row['AnnualCost3'],$row['AnnualCost4'],$row['AnnualCost5'],$row['AnnualCost6'],$row['AnnualCost7'],$row['AnnualCost8'],$row['AnnualCost9'],$row['AnnualCost10']);
		$totalcost = array_sum($costarray);
		
		$ContractingEntity 					= $row['ContractingEntity'];
		$Vendor 							= $row['Vendor'];
		$ContractType 						= $row['ContractType'];
		$ContractTitle						= $row['ContractTitle'];
		$ContractDescription 				= $row['ContractDescription'];
		$Department 						= $row['Department'];
		$EOC		 						= $row['EOC'];
		$ResponsiblePartyPri 				= $row['ResponsiblePartyPri'];
		$ResponsiblePartySec 				= $row['ResponsiblePartySec'];
		$ResponsiblePartyTer 				= $row['ResponsiblePartyTer'];
		$AdditionalReviewer1				= $row['AdditionalReviewer1'];
		$AdditionalReviewer2				= $row['AdditionalReviewer2'];
		$EffectiveDate 						= $row['EffectiveDate'];
		$ExpirationDate 					= $row['ExpirationDate'];
		$AnnualCost1						= $row['AnnualCost1'];
		$AnnualCost2                		= $row['AnnualCost2'];
		$AnnualCost3                		= $row['AnnualCost3'];
		$AnnualCost4                		= $row['AnnualCost4'];
		$AnnualCost5                		= $row['AnnualCost5'];
		$AnnualCost6                		= $row['AnnualCost6'];
		$AnnualCost7                		= $row['AnnualCost7'];
		$AnnualCost8                		= $row['AnnualCost8'];
		$AnnualCost9                		= $row['AnnualCost9'];
		$AnnualCost10               		= $row['AnnualCost10'];
		$ContractStatus 					= $row['ContractStatus'];
		$AutoRenewal 						= $row['AutoRenewal'];
		$AutoRenewalTerms 					= $row['AutoRenewalTerms'];
		$AutoRenewalTimes 					= $row['AutoRenewalTimes'];
		$AutoRenewalDeadline 				= $row['AutoRenewalDeadline'];
		$ServiceEvaluationPeriod 			= $row['ServiceEvaluationPeriod'];
		$ContractFileName					= $row['ContractFileName'];
		$conUploadDate						= $row['conUploadDate'];
		$BAAFileName                        = $row['BAAFileName'];
		$baaUploadDate						= $row['baaUploadDate'];
		$COIFileName                        = $row['COIFileName'];
		$coiUploadDate						= $row['coiUploadDate'];
		$ServiceEvaluationFileName          = $row['ServiceEvaluationFileName'];
		$sevUploadDate						= $row['sevUploadDate'];
		$AddendumFileName                   = $row['AddendumFileName'];
		$admUploadDate						= $row['admUploadDate'];
		$MemorandumOfUnderstandingFileName  = $row['MemorandumOfUnderstandingFileName'];
		$mouUploadDate						= $row['mouUploadDate'];
		$PurchaseOrderFileName	            = $row['PurchaseOrderFileName'];
		$poUploadDate						= $row['poUploadDate'];
		if($row['NextServiceEvaluationDate'] == NULL) {$NextServiceEvaluationDate = 'N/A';} else {$NextServiceEvaluationDate = $row['NextServiceEvaluationDate']->format('Y-m-d');}
		if($row['LastServiceEvaluationDate'] == NULL) {$LastServiceEvaluationDate = 'N/A';} else {$LastServiceEvaluationDate = $row['LastServiceEvaluationDate']->format('Y-m-d');}
		
		full_display();
				
	}
		
	
	if($uploadfile == '1') {    //if UPLOADING new files to empty spots
		$conn3 = db_conn();
		$sql3 = "SELECT ContractID,ContractFileName,conUploadDate,BAAFileName,baaUploadDate,COIFileName,coiUploadDate,ServiceEvaluationFileName,sevUploadDate,
				 AddendumFileName,admUploadDate,MemorandumOfUnderstandingFileName,mouUploadDate,PurchaseOrderFileName,poUploadDate FROM ContractData WHERE ContractID = '".$id."'";
		$result3 = sqlsrv_query($conn3, $sql3);
		$row3 = sqlsrv_fetch_array($result3, SQLSRV_FETCH_ASSOC);
	
		$EXISTINGconfile = $row3['ContractFileName'];
		$EXISTINGbaafile = $row3['BAAFileName'];
		$EXISTINGcoifile = $row3['COIFileName'];
		$EXISTINGsevfile = $row3['ServiceEvaluationFileName'];
		$EXISTINGadmfile = $row3['AddendumFileName'];
		$EXISTINGmoufile = $row3['MemorandumOfUnderstandingFileName'];
		$EXISTINGpofile = $row3['PurchaseOrderFileName'];
				
		if($row3['conUploadDate'] == NULL){$EXISTINGconDate = NULL;}else{$EXISTINGconDate = $row3['conUploadDate']->format('Y-m-d H:i:s');}
		if($row3['baaUploadDate'] == NULL){$EXISTINGbaaDate = NULL;}else{$EXISTINGbaaDate = $row3['baaUploadDate']->format('Y-m-d H:i:s');}
		if($row3['coiUploadDate'] == NULL){$EXISTINGcoiDate = NULL;}else{$EXISTINGcoiDate = $row3['coiUploadDate']->format('Y-m-d H:i:s');}
		if($row3['sevUploadDate'] == NULL){$EXISTINGsevDate = NULL;}else{$EXISTINGsevDate = $row3['sevUploadDate']->format('Y-m-d H:i:s');}
		if($row3['admUploadDate'] == NULL){$EXISTINGadmDate = NULL;}else{$EXISTINGadmDate = $row3['admUploadDate']->format('Y-m-d H:i:s');}
		if($row3['mouUploadDate'] == NULL){$EXISTINGmouDate = NULL;}else{$EXISTINGmouDate = $row3['mouUploadDate']->format('Y-m-d H:i:s');}
		if($row3['poUploadDate'] == NULL){$EXISTINGpoDate = NULL;}  else{$EXISTINGpoDate = $row3['poUploadDate']->format('Y-m-d H:i:s');}	
	
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
		
		if ($confile != '') {$newconfilename = $unqconfilename . '.' . $conext; $conupdate = $date;} ELSE {$newconfilename = $EXISTINGconfile; $conupdate = $EXISTINGconDate;}
		if ($baafile != '') {$newbaafilename = $unqbaafilename . '.' . $baaext; $baaupdate = $date; } ELSE {$newbaafilename = $EXISTINGbaafile; $baaupdate = $EXISTINGbaaDate;}
		if ($coifile != '') {$newcoifilename = $unqcoifilename . '.' . $coiext; $coiupdate = $date; } ELSE {$newcoifilename = $EXISTINGcoifile; $coiupdate = $EXISTINGcoiDate;}
		if ($sevfile != '') {$newsevfilename = $unqsevfilename . '.' . $sevext; $sevupdate = $date; } ELSE {$newsevfilename = $EXISTINGsevfile; $sevupdate = $EXISTINGsevDate;}
		if ($admfile != '') {$newadmfilename = $unqadmfilename . '.' . $admext; $admupdate = $date; } ELSE {$newadmfilename = $EXISTINGadmfile; $admupdate = $EXISTINGadmDate;}
		if ($moufile != '') {$newmoufilename = $unqmoufilename . '.' . $mouext; $mouupdate = $date; } ELSE {$newmoufilename = $EXISTINGmoufile; $mouupdate = $EXISTINGmouDate;}
		if ($pofile != '') {$newpofilename = $unqpofilename . '.' . $poext; $poupdate = $date; } ELSE {$newpofilename = $EXISTINGpofile; $poupdate = $EXISTINGpoDate;}
		////////////////END CREATE NEW FILE NAMES//////////////////
		
		$newfilenames = array($newconfilename,$newbaafilename,$newcoifilename,$newsevfilename,$newadmfilename,$newmoufilename,$newpofilename);
		$target_dir = 'uploads/';
		
		$conn = db_conn();
		$sql = "UPDATE ContractData SET
				ContractFileName = '".$newconfilename."',
				conUploadDate = '".$conupdate."',
				BAAFileName = '".$newbaafilename."',
				baaUploadDate = '".$baaupdate."',
				COIFileName = '".$newcoifilename."',
				coiUploadDate = '".$coiupdate."',
				ServiceEvaluationFileName = '".$newsevfilename."',
				sevUploadDate = '".$sevupdate."',
				AddendumFileName = '".$newadmfilename."',
				admUploadDate = '".$admupdate."',
				MemorandumOfUnderstandingFileName = '".$newmoufilename."',
				mouUploadDate = '".$mouupdate."',
				PurchaseOrderFileName = '".$newpofilename."',
				poUploadDate = '".$poupdate."'
				WHERE ContractID = '".$id."'";
		
		if(sqlsrv_query($conn, $sql)){
			echo "<span class='success' id='full'>File(s) uploaded successfully. The database has been updated.</span><br/>";
			
			foreach($_FILES['cmsfile']['name'] as $key => $name) {
				move_uploaded_file($_FILES['cmsfile']['tmp_name'][$key], $target_dir . $newfilenames[$key]);
			}
			// ADD output for which files were uploaded.
			} 	else{
				echo "<span class='notice' id='full'>ERROR: Not able to execute $sql.</span><br/> "; //. sqlsrv_errors($conn);
			}
		
		$conn2 = db_conn();
		$sql2 = "SELECT ContractID,ContractingEntity,Vendor,ContractType,ContractTitle,ContractDescription,Department,EOC,ResponsiblePartyPri,ResponsiblePartySec,
				  ResponsiblePartyTer,AdditionalReviewer1,AdditionalReviewer2,CONVERT(varchar(10),EffectiveDate,23) AS 'EffectiveDate',CONVERT(varchar(10),ExpirationDate,23) AS 'ExpirationDate',
				  AnnualCost1,AnnualCost2,AnnualCost3,AnnualCost4,AnnualCost5,AnnualCost6,AnnualCost7,AnnualCost8,AnnualCost9,AnnualCost10,ContractStatus,
				  AutoRenewal,AutoRenewalTerms,AutoRenewalTimes,CONVERT(varchar(10),AutoRenewalDeadline,23) AS 'AutoRenewalDeadline',ContractFileName,conUploadDate,BAAFileName,baaUploadDate,COIFileName,coiUploadDate,ServiceEvaluationPeriod,
				  ServiceEvaluationFileName,sevUploadDate,AddendumFileName,admUploadDate,MemorandumOfUnderstandingFileName,mouUploadDate,PurchaseOrderFileName,
				  poUploadDate,LastServiceEvaluationDate,NextServiceEvaluationDate
				FROM ContractData WHERE ContractID = '".$id."'";
		$result = sqlsrv_query($conn2, $sql2);
		$row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);
		$costarray = array($row['AnnualCost1'],$row['AnnualCost2'],$row['AnnualCost3'],$row['AnnualCost4'],$row['AnnualCost5'],$row['AnnualCost6'],$row['AnnualCost7'],$row['AnnualCost8'],$row['AnnualCost9'],$row['AnnualCost10']);
		$totalcost = array_sum($costarray);
		
		$ContractingEntity 					= $row['ContractingEntity'];
		$Vendor 							= $row['Vendor'];
		$ContractType 						= $row['ContractType'];
		$ContractTitle						= $row['ContractTitle'];
		$ContractDescription 				= $row['ContractDescription'];
		$Department 						= $row['Department'];
		$EOC		 						= $row['EOC'];
		$ResponsiblePartyPri 				= $row['ResponsiblePartyPri'];
		$ResponsiblePartySec 				= $row['ResponsiblePartySec'];
		$ResponsiblePartyTer 				= $row['ResponsiblePartyTer'];
		$AdditionalReviewer1				= $row['AdditionalReviewer1'];
		$AdditionalReviewer2				= $row['AdditionalReviewer2'];
		$EffectiveDate 						= $row['EffectiveDate'];
		$ExpirationDate 					= $row['ExpirationDate'];
		$AnnualCost1						= $row['AnnualCost1'];
		$AnnualCost2                		= $row['AnnualCost2'];
		$AnnualCost3                		= $row['AnnualCost3'];
		$AnnualCost4                		= $row['AnnualCost4'];
		$AnnualCost5                		= $row['AnnualCost5'];
		$AnnualCost6                		= $row['AnnualCost6'];
		$AnnualCost7                		= $row['AnnualCost7'];
		$AnnualCost8                		= $row['AnnualCost8'];
		$AnnualCost9                		= $row['AnnualCost9'];
		$AnnualCost10               		= $row['AnnualCost10'];
		$ContractStatus 					= $row['ContractStatus'];
		$AutoRenewal 						= $row['AutoRenewal'];
		$AutoRenewalTerms 					= $row['AutoRenewalTerms'];
		$AutoRenewalTimes 					= $row['AutoRenewalTimes'];
		$AutoRenewalDeadline 					= $row['AutoRenewalDeadline'];
		$ServiceEvaluationPeriod 			= $row['ServiceEvaluationPeriod'];
		$ContractFileName					= $row['ContractFileName'];
		$conUploadDate						= $row['conUploadDate'];
		$BAAFileName                        = $row['BAAFileName'];
		$baaUploadDate						= $row['baaUploadDate'];
		$COIFileName                        = $row['COIFileName'];
		$coiUploadDate						= $row['coiUploadDate'];
		$ServiceEvaluationFileName          = $row['ServiceEvaluationFileName'];
		$sevUploadDate						= $row['sevUploadDate'];
		$AddendumFileName                   = $row['AddendumFileName'];
		$admUploadDate						= $row['admUploadDate'];
		$MemorandumOfUnderstandingFileName  = $row['MemorandumOfUnderstandingFileName'];
		$mouUploadDate						= $row['mouUploadDate'];
		$PurchaseOrderFileName	            = $row['PurchaseOrderFileName'];
		$poUploadDate						= $row['poUploadDate'];
		if($row['NextServiceEvaluationDate'] == NULL) {$NextServiceEvaluationDate = 'N/A';} else {$NextServiceEvaluationDate = $row['NextServiceEvaluationDate']->format('Y-m-d');}
		if($row['LastServiceEvaluationDate'] == NULL) {$LastServiceEvaluationDate = 'N/A';} else {$LastServiceEvaluationDate = $row['LastServiceEvaluationDate']->format('Y-m-d');}
		
		full_display();
				
	}
} elseif($updatesev == '1') { //IF ServiceEvaluation is altered
	
	$id = $_POST['ContractID'];
	$ldate = $_POST['LastServiceEvaluationDate'];
	$ndate = $_POST['NextServiceEvaluationDate'];
	
	$lastdate = date_create($ldate);
	$nextdate = date_create($ndate);
	
	$lastsevdate = date_format($lastdate,'Y-m-d');
	$nextsevdate = date_format($nextdate,'Y-m-d');
	
	$conn = db_conn();
	$sql6 = "SELECT ContractID,ServiceEvaluationPeriod,LastServiceEvaluationDate,NextServiceEvaluationDate FROM ContractData WHERE ContractID = '".$id."'";
	$result6 = sqlsrv_query($conn, $sql6);
	$row6 = sqlsrv_fetch_array($result6, SQLSRV_FETCH_ASSOC);
	
	$EXISTINGsevper = $row6['ServiceEvaluationPeriod'];
	$EXISTINGlastsev = $row6['LastServiceEvaluationDate']->format('Y-m-d');
	$EXISTINGnextsev = $row6['NextServiceEvaluationDate']->format('Y-m-d');
		
	if($_POST['ServiceEvaluationPeriod'] == ''){$sevperiod = $EXISTINGsevper;} else {$sevperiod = $_POST['ServiceEvaluationPeriod'];}
	
	
	if($ndate != '' && $ldate != '' && ($nextsevdate > $lastsevdate)) {  //NEXT and LAST are BOTH SET and NEXT date is GREATER THAN LAST date
		
		$sql7 = "UPDATE ContractData SET ServiceEvaluationPeriod = '".$sevperiod."', LastServiceEvaluationDate = '".$lastsevdate."', NextServiceEvaluationDate = '".$nextsevdate."' WHERE ContractID = '".$id."'";
		//$result7 = sqlsrv_query($conn,$sql7);
		
		if(sqlsrv_query($conn,$sql7)){
			echo "<span class='success' id='full'>Service Evaluation Dates have been changed. The database has been updated.</span><br/>";
			} else{
				echo "<span class='notice' id='full'>ERROR: Not able to execute $sql.</span><br/> " . sqlsrv_errors($conn);
			}
			
		$conn2 = db_conn();
		$sql2 = "SELECT ContractID,ContractingEntity,Vendor,ContractType,ContractTitle,ContractDescription,Department,EOC,ResponsiblePartyPri,ResponsiblePartySec,
				  ResponsiblePartyTer,AdditionalReviewer1,AdditionalReviewer2,CONVERT(varchar(10),EffectiveDate,23) AS 'EffectiveDate',CONVERT(varchar(10),ExpirationDate,23) AS 'ExpirationDate',
				  AnnualCost1,AnnualCost2,AnnualCost3,AnnualCost4,AnnualCost5,AnnualCost6,AnnualCost7,AnnualCost8,AnnualCost9,AnnualCost10,ContractStatus,
				  AutoRenewal,AutoRenewalTerms,AutoRenewalTimes,CONVERT(varchar(10),AutoRenewalDeadline,23) AS 'AutoRenewalDeadline',ContractFileName,conUploadDate,BAAFileName,baaUploadDate,COIFileName,coiUploadDate,ServiceEvaluationPeriod,
				  ServiceEvaluationFileName,sevUploadDate,AddendumFileName,admUploadDate,MemorandumOfUnderstandingFileName,mouUploadDate,PurchaseOrderFileName,
				  poUploadDate,LastServiceEvaluationDate,NextServiceEvaluationDate 
				FROM ContractData WHERE ContractID = '".$id."'";
		$result = sqlsrv_query($conn2, $sql2);
		$row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);
		$costarray = array($row['AnnualCost1'],$row['AnnualCost2'],$row['AnnualCost3'],$row['AnnualCost4'],$row['AnnualCost5'],$row['AnnualCost6'],$row['AnnualCost7'],$row['AnnualCost8'],$row['AnnualCost9'],$row['AnnualCost10']);
		$totalcost = array_sum($costarray);
		
		$ContractingEntity 					= $row['ContractingEntity'];
		$Vendor 							= $row['Vendor'];
		$ContractType 						= $row['ContractType'];
		$ContractTitle						= $row['ContractTitle'];
		$ContractDescription 				= $row['ContractDescription'];
		$Department 						= $row['Department'];
		$EOC		 						= $row['EOC'];
		$ResponsiblePartyPri 				= $row['ResponsiblePartyPri'];
		$ResponsiblePartySec 				= $row['ResponsiblePartySec'];
		$ResponsiblePartyTer 				= $row['ResponsiblePartyTer'];
		$AdditionalReviewer1				= $row['AdditionalReviewer1'];
		$AdditionalReviewer2				= $row['AdditionalReviewer2'];
		$EffectiveDate 						= $row['EffectiveDate'];
		$ExpirationDate 					= $row['ExpirationDate'];
		$AnnualCost1						= $row['AnnualCost1'];
		$AnnualCost2                		= $row['AnnualCost2'];
		$AnnualCost3                		= $row['AnnualCost3'];
		$AnnualCost4                		= $row['AnnualCost4'];
		$AnnualCost5                		= $row['AnnualCost5'];
		$AnnualCost6                		= $row['AnnualCost6'];
		$AnnualCost7                		= $row['AnnualCost7'];
		$AnnualCost8                		= $row['AnnualCost8'];
		$AnnualCost9                		= $row['AnnualCost9'];
		$AnnualCost10               		= $row['AnnualCost10'];
		$ContractStatus 					= $row['ContractStatus'];
		$AutoRenewal 						= $row['AutoRenewal'];
		$AutoRenewalTerms 					= $row['AutoRenewalTerms'];
		$AutoRenewalTimes 					= $row['AutoRenewalTimes'];
		$AutoRenewalDeadline 				= $row['AutoRenewalDeadline'];
		$ServiceEvaluationPeriod 			= $row['ServiceEvaluationPeriod'];
		$ContractFileName					= $row['ContractFileName'];
		$conUploadDate						= $row['conUploadDate'];
		$BAAFileName                        = $row['BAAFileName'];
		$baaUploadDate						= $row['baaUploadDate'];
		$COIFileName                        = $row['COIFileName'];
		$coiUploadDate						= $row['coiUploadDate'];
		$ServiceEvaluationFileName          = $row['ServiceEvaluationFileName'];
		$sevUploadDate						= $row['sevUploadDate'];
		$AddendumFileName                   = $row['AddendumFileName'];
		$admUploadDate						= $row['admUploadDate'];
		$MemorandumOfUnderstandingFileName  = $row['MemorandumOfUnderstandingFileName'];
		$mouUploadDate						= $row['mouUploadDate'];
		$PurchaseOrderFileName	            = $row['PurchaseOrderFileName'];
		$poUploadDate						= $row['poUploadDate'];
		if($row['NextServiceEvaluationDate'] == NULL) {$NextServiceEvaluationDate = 'N/A';} else {$NextServiceEvaluationDate = $row['NextServiceEvaluationDate']->format('Y-m-d');}
		if($row['LastServiceEvaluationDate'] == NULL) {$LastServiceEvaluationDate = 'N/A';} else {$LastServiceEvaluationDate = $row['LastServiceEvaluationDate']->format('Y-m-d');}
		
		full_display();
		
	} elseif($ndate == '' && $ldate != '') {  //NEXT IS NOT SET and LAST IS SET
		
		if($sevperiod == 'Annual') {$interval = '1 year';} else {$interval = '6 months';}
		$date = date_create($lastsevdate);
		date_add($date,date_interval_create_from_date_string($interval));
		$nextdate2 = date_format($date,'Y-m-d');
		
		$sql8 = "UPDATE ContractData SET ServiceEvaluationPeriod = '".$sevperiod."', LastServiceEvaluationDate = '".$lastsevdate."', NextServiceEvaluationDate = '".$nextdate2."' WHERE ContractID = '".$id."'";
		
		if(sqlsrv_query($conn,$sql8)){
			echo "<span class='success' id='full'>Service Evaluation Dates have been changed. The database has been updated.</span>";
			
			} else{
				echo "<span class='notice' id='full'>ERROR: Not able to execute $sql.</span><br/> " . sqlsrv_errors($conn);
			}
		$conn2 = db_conn();
		$sql2 = "SELECT ContractID,ContractingEntity,Vendor,ContractType,ContractTitle,ContractDescription,Department,EOC,ResponsiblePartyPri,ResponsiblePartySec,
				  ResponsiblePartyTer,AdditionalReviewer1,AdditionalReviewer2,CONVERT(varchar(10),EffectiveDate,23) AS 'EffectiveDate',CONVERT(varchar(10),ExpirationDate,23) AS 'ExpirationDate',
				  AnnualCost1,AnnualCost2,AnnualCost3,AnnualCost4,AnnualCost5,AnnualCost6,AnnualCost7,AnnualCost8,AnnualCost9,AnnualCost10,ContractStatus,
				  AutoRenewal,AutoRenewalTerms,AutoRenewalTimes,CONVERT(varchar(10),AutoRenewalDeadline,23) AS 'AutoRenewalDeadline',ContractFileName,conUploadDate,BAAFileName,baaUploadDate,COIFileName,coiUploadDate,ServiceEvaluationPeriod,
				  ServiceEvaluationFileName,sevUploadDate,AddendumFileName,admUploadDate,MemorandumOfUnderstandingFileName,mouUploadDate,PurchaseOrderFileName,
				  poUploadDate,LastServiceEvaluationDate,NextServiceEvaluationDate 
				FROM ContractData WHERE ContractID = '".$id."'";
		$result = sqlsrv_query($conn2, $sql2);
		$row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);
		$costarray = array($row['AnnualCost1'],$row['AnnualCost2'],$row['AnnualCost3'],$row['AnnualCost4'],$row['AnnualCost5'],$row['AnnualCost6'],$row['AnnualCost7'],$row['AnnualCost8'],$row['AnnualCost9'],$row['AnnualCost10']);
		$totalcost = array_sum($costarray);
		
		$ContractingEntity 					= $row['ContractingEntity'];
		$Vendor 							= $row['Vendor'];
		$ContractType 						= $row['ContractType'];
		$ContractTitle						= $row['ContractTitle'];
		$ContractDescription 				= $row['ContractDescription'];
		$Department 						= $row['Department'];
		$EOC		 						= $row['EOC'];
		$ResponsiblePartyPri 				= $row['ResponsiblePartyPri'];
		$ResponsiblePartySec 				= $row['ResponsiblePartySec'];
		$ResponsiblePartyTer 				= $row['ResponsiblePartyTer'];
		$AdditionalReviewer1				= $row['AdditionalReviewer1'];
		$AdditionalReviewer2				= $row['AdditionalReviewer2'];
		$EffectiveDate 						= $row['EffectiveDate'];
		$ExpirationDate 					= $row['ExpirationDate'];
		$AnnualCost1						= $row['AnnualCost1'];
		$AnnualCost2                		= $row['AnnualCost2'];
		$AnnualCost3                		= $row['AnnualCost3'];
		$AnnualCost4                		= $row['AnnualCost4'];
		$AnnualCost5                		= $row['AnnualCost5'];
		$AnnualCost6                		= $row['AnnualCost6'];
		$AnnualCost7                		= $row['AnnualCost7'];
		$AnnualCost8                		= $row['AnnualCost8'];
		$AnnualCost9                		= $row['AnnualCost9'];
		$AnnualCost10               		= $row['AnnualCost10'];
		$ContractStatus 					= $row['ContractStatus'];
		$AutoRenewal 						= $row['AutoRenewal'];
		$AutoRenewalTerms 					= $row['AutoRenewalTerms'];
		$AutoRenewalTimes 					= $row['AutoRenewalTimes'];
		$AutoRenewalDeadline 				= $row['AutoRenewalDeadline'];
		$ServiceEvaluationPeriod 			= $row['ServiceEvaluationPeriod'];
		$ContractFileName					= $row['ContractFileName'];
		$conUploadDate						= $row['conUploadDate'];
		$BAAFileName                        = $row['BAAFileName'];
		$baaUploadDate						= $row['baaUploadDate'];
		$COIFileName                        = $row['COIFileName'];
		$coiUploadDate						= $row['coiUploadDate'];
		$ServiceEvaluationFileName          = $row['ServiceEvaluationFileName'];
		$sevUploadDate						= $row['sevUploadDate'];
		$AddendumFileName                   = $row['AddendumFileName'];
		$admUploadDate						= $row['admUploadDate'];
		$MemorandumOfUnderstandingFileName  = $row['MemorandumOfUnderstandingFileName'];
		$mouUploadDate						= $row['mouUploadDate'];
		$PurchaseOrderFileName	            = $row['PurchaseOrderFileName'];
		$poUploadDate						= $row['poUploadDate'];
		if($row['NextServiceEvaluationDate'] == NULL) {$NextServiceEvaluationDate = 'N/A';} else {$NextServiceEvaluationDate = $row['NextServiceEvaluationDate']->format('Y-m-d');}
		if($row['LastServiceEvaluationDate'] == NULL) {$LastServiceEvaluationDate = 'N/A';} else {$LastServiceEvaluationDate = $row['LastServiceEvaluationDate']->format('Y-m-d');}
		
		full_display();
		
		
	} elseif($ndate != '' && $ldate == '' && ($nextsevdate >= $EXISTINGlastsev)) {  //LAST IS NOT SET and NEXT IS SET and NEXT date is GREATER THAN the EXISTING LAST date
		
		$sql9 = "UPDATE ContractData SET ServiceEvaluationPeriod = '".$sevperiod."', LastServiceEvaluationDate = '".$EXISTINGlastsev."', NextServiceEvaluationDate = '".$nextsevdate."' WHERE ContractID = '".$id."'";
		
		if(sqlsrv_query($conn,$sql9)){
			echo "<span class='notice' id='full'><strong>Note: You did not change the Last Service Evaluation Date.</strong> Next Service Evaluation Date has been changed. The database has been updated.</span>";
			} else{
				echo "<span class='notice' id='full'>ERROR: Not able to execute $sql.</span><br/> " . sqlsrv_errors($conn);
			}
		
		$conn2 = db_conn();
		$sql2 = "SELECT ContractID,ContractingEntity,Vendor,ContractType,ContractTitle,ContractDescription,Department,EOC,ResponsiblePartyPri,ResponsiblePartySec,
				  ResponsiblePartyTer,AdditionalReviewer1,AdditionalReviewer2,CONVERT(varchar(10),EffectiveDate,23) AS 'EffectiveDate',CONVERT(varchar(10),ExpirationDate,23) AS 'ExpirationDate',
				  AnnualCost1,AnnualCost2,AnnualCost3,AnnualCost4,AnnualCost5,AnnualCost6,AnnualCost7,AnnualCost8,AnnualCost9,AnnualCost10,ContractStatus,
				  AutoRenewal,AutoRenewalTerms,AutoRenewalTimes,CONVERT(varchar(10),AutoRenewalDeadline,23) AS 'AutoRenewalDeadline',ContractFileName,conUploadDate,BAAFileName,baaUploadDate,COIFileName,coiUploadDate,ServiceEvaluationPeriod,
				  ServiceEvaluationFileName,sevUploadDate,AddendumFileName,admUploadDate,MemorandumOfUnderstandingFileName,mouUploadDate,PurchaseOrderFileName,
				  poUploadDate,LastServiceEvaluationDate,NextServiceEvaluationDate 
				FROM ContractData WHERE ContractID = '".$id."'";
		$result = sqlsrv_query($conn2, $sql2);
		$row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);
		$costarray = array($row['AnnualCost1'],$row['AnnualCost2'],$row['AnnualCost3'],$row['AnnualCost4'],$row['AnnualCost5'],$row['AnnualCost6'],$row['AnnualCost7'],$row['AnnualCost8'],$row['AnnualCost9'],$row['AnnualCost10']);
		$totalcost = array_sum($costarray);
		
		$ContractingEntity 					= $row['ContractingEntity'];
		$Vendor 							= $row['Vendor'];
		$ContractType 						= $row['ContractType'];
		$ContractTitle						= $row['ContractTitle'];
		$ContractDescription 				= $row['ContractDescription'];
		$Department 						= $row['Department'];
		$EOC		 						= $row['EOC'];
		$ResponsiblePartyPri 				= $row['ResponsiblePartyPri'];
		$ResponsiblePartySec 				= $row['ResponsiblePartySec'];
		$ResponsiblePartyTer 				= $row['ResponsiblePartyTer'];
		$AdditionalReviewer1				= $row['AdditionalReviewer1'];
		$AdditionalReviewer2				= $row['AdditionalReviewer2'];
		$EffectiveDate 						= $row['EffectiveDate'];
		$ExpirationDate 					= $row['ExpirationDate'];
		$AnnualCost1						= $row['AnnualCost1'];
		$AnnualCost2                		= $row['AnnualCost2'];
		$AnnualCost3                		= $row['AnnualCost3'];
		$AnnualCost4                		= $row['AnnualCost4'];
		$AnnualCost5                		= $row['AnnualCost5'];
		$AnnualCost6                		= $row['AnnualCost6'];
		$AnnualCost7                		= $row['AnnualCost7'];
		$AnnualCost8                		= $row['AnnualCost8'];
		$AnnualCost9                		= $row['AnnualCost9'];
		$AnnualCost10               		= $row['AnnualCost10'];
		$ContractStatus 					= $row['ContractStatus'];
		$AutoRenewal 						= $row['AutoRenewal'];
		$AutoRenewalTerms 					= $row['AutoRenewalTerms'];
		$AutoRenewalTimes 					= $row['AutoRenewalTimes'];
		$AutoRenewalDeadline 				= $row['AutoRenewalDeadline'];
		$ServiceEvaluationPeriod 			= $row['ServiceEvaluationPeriod'];
		$ContractFileName					= $row['ContractFileName'];
		$conUploadDate						= $row['conUploadDate'];
		$BAAFileName                        = $row['BAAFileName'];
		$baaUploadDate						= $row['baaUploadDate'];
		$COIFileName                        = $row['COIFileName'];
		$coiUploadDate						= $row['coiUploadDate'];
		$ServiceEvaluationFileName          = $row['ServiceEvaluationFileName'];
		$sevUploadDate						= $row['sevUploadDate'];
		$AddendumFileName                   = $row['AddendumFileName'];
		$admUploadDate						= $row['admUploadDate'];
		$MemorandumOfUnderstandingFileName  = $row['MemorandumOfUnderstandingFileName'];
		$mouUploadDate						= $row['mouUploadDate'];
		$PurchaseOrderFileName	            = $row['PurchaseOrderFileName'];
		$poUploadDate						= $row['poUploadDate'];
		if($row['NextServiceEvaluationDate'] == NULL) {$NextServiceEvaluationDate = 'N/A';} else {$NextServiceEvaluationDate = $row['NextServiceEvaluationDate']->format('Y-m-d');}
		if($row['LastServiceEvaluationDate'] == NULL) {$LastServiceEvaluationDate = 'N/A';} else {$LastServiceEvaluationDate = $row['LastServiceEvaluationDate']->format('Y-m-d');}
		
		full_display();
	
	} elseif(($ndate != '' && $ldate != '' && ($nextsevdate < $lastsevdate)) || ($ndate != '' && $ldate == '' && ($nextsevdate < $EXISTINGlastsev))) {
		
		echo "<span class='notice' id='full'>Note: Last Service Evaluation Date cannot be greater than the Next Service Evaluation Date. The database has NOT been updated.</span>";
		
		$conn2 = db_conn();
		$sql2 = "SELECT ContractID,ContractingEntity,Vendor,ContractType,ContractTitle,ContractDescription,Department,EOC,ResponsiblePartyPri,ResponsiblePartySec,
				  ResponsiblePartyTer,AdditionalReviewer1,AdditionalReviewer2,CONVERT(varchar(10),EffectiveDate,23) AS 'EffectiveDate',CONVERT(varchar(10),ExpirationDate,23) AS 'ExpirationDate',
				  AnnualCost1,AnnualCost2,AnnualCost3,AnnualCost4,AnnualCost5,AnnualCost6,AnnualCost7,AnnualCost8,AnnualCost9,AnnualCost10,ContractStatus,
				  AutoRenewal,AutoRenewalTerms,AutoRenewalTimes,CONVERT(varchar(10),AutoRenewalDeadline,23) AS 'AutoRenewalDeadline',ContractFileName,conUploadDate,BAAFileName,baaUploadDate,COIFileName,coiUploadDate,ServiceEvaluationPeriod,
				  ServiceEvaluationFileName,sevUploadDate,AddendumFileName,admUploadDate,MemorandumOfUnderstandingFileName,mouUploadDate,PurchaseOrderFileName,
				  poUploadDate,LastServiceEvaluationDate,NextServiceEvaluationDate 
				FROM ContractData WHERE ContractID = '".$id."'";
		$result = sqlsrv_query($conn2, $sql2);
		$row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);
		$costarray = array($row['AnnualCost1'],$row['AnnualCost2'],$row['AnnualCost3'],$row['AnnualCost4'],$row['AnnualCost5'],$row['AnnualCost6'],$row['AnnualCost7'],$row['AnnualCost8'],$row['AnnualCost9'],$row['AnnualCost10']);
		$totalcost = array_sum($costarray);
		
		$ContractingEntity 					= $row['ContractingEntity'];
		$Vendor 							= $row['Vendor'];
		$ContractType 						= $row['ContractType'];
		$ContractTitle						= $row['ContractTitle'];
		$ContractDescription 				= $row['ContractDescription'];
		$Department 						= $row['Department'];
		$EOC		 						= $row['EOC'];
		$ResponsiblePartyPri 				= $row['ResponsiblePartyPri'];
		$ResponsiblePartySec 				= $row['ResponsiblePartySec'];
		$ResponsiblePartyTer 				= $row['ResponsiblePartyTer'];
		$AdditionalReviewer1				= $row['AdditionalReviewer1'];
		$AdditionalReviewer2				= $row['AdditionalReviewer2'];
		$EffectiveDate 						= $row['EffectiveDate'];
		$ExpirationDate 					= $row['ExpirationDate'];
		$AnnualCost1						= $row['AnnualCost1'];
		$AnnualCost2                		= $row['AnnualCost2'];
		$AnnualCost3                		= $row['AnnualCost3'];
		$AnnualCost4                		= $row['AnnualCost4'];
		$AnnualCost5                		= $row['AnnualCost5'];
		$AnnualCost6                		= $row['AnnualCost6'];
		$AnnualCost7                		= $row['AnnualCost7'];
		$AnnualCost8                		= $row['AnnualCost8'];
		$AnnualCost9                		= $row['AnnualCost9'];
		$AnnualCost10               		= $row['AnnualCost10'];
		$ContractStatus 					= $row['ContractStatus'];
		$AutoRenewal 						= $row['AutoRenewal'];
		$AutoRenewalTerms 					= $row['AutoRenewalTerms'];
		$AutoRenewalTimes 					= $row['AutoRenewalTimes'];
		$AutoRenewalDeadline 					= $row['AutoRenewalDeadline'];
		$ServiceEvaluationPeriod 			= $row['ServiceEvaluationPeriod'];
		$ContractFileName					= $row['ContractFileName'];
		$conUploadDate						= $row['conUploadDate'];
		$BAAFileName                        = $row['BAAFileName'];
		$baaUploadDate						= $row['baaUploadDate'];
		$COIFileName                        = $row['COIFileName'];
		$coiUploadDate						= $row['coiUploadDate'];
		$ServiceEvaluationFileName          = $row['ServiceEvaluationFileName'];
		$sevUploadDate						= $row['sevUploadDate'];
		$AddendumFileName                   = $row['AddendumFileName'];
		$admUploadDate						= $row['admUploadDate'];
		$MemorandumOfUnderstandingFileName  = $row['MemorandumOfUnderstandingFileName'];
		$mouUploadDate						= $row['mouUploadDate'];
		$PurchaseOrderFileName	            = $row['PurchaseOrderFileName'];
		$poUploadDate						= $row['poUploadDate'];
		if($row['LastServiceEvaluationDate'] == NULL) {$LastServiceEvaluationDate = 'N/A';} else {$LastServiceEvaluationDate = $row['LastServiceEvaluationDate']->format('Y-m-d');}
		if($row['NextServiceEvaluationDate'] == NULL) {$NextServiceEvaluationDate = 'N/A';} else {$NextServiceEvaluationDate = $row['NextServiceEvaluationDate']->format('Y-m-d');}
		
		
		full_display();
	
	} elseif($ldate == '' && $ndate == '' && ($sevperiod != $EXISTINGsevper)) {  //LAST and NEXT ARE BOTH NOT SET, and Sev.Period has been changed
		
		$sql10 = "UPDATE ContractData SET ServiceEvaluationPeriod = '".$sevperiod."' WHERE ContractID = '".$id."'";
		
		if(sqlsrv_query($conn,$sql10)){
			echo "<span class='success' id='full'>Service Evaluation Period has been updated in the database.</span>";
			} else{
				echo "<span class='notice' id='full'>ERROR: Not able to execute $sql.</span><br/> " . sqlsrv_errors($conn);
			}
		
		$conn2 = db_conn();
		$sql2 = "SELECT ContractID,ContractingEntity,Vendor,ContractType,ContractTitle,ContractDescription,Department,EOC,ResponsiblePartyPri,ResponsiblePartySec,
				  ResponsiblePartyTer,AdditionalReviewer1,AdditionalReviewer2,CONVERT(varchar(10),EffectiveDate,23) AS 'EffectiveDate',CONVERT(varchar(10),ExpirationDate,23) AS 'ExpirationDate',
				  AnnualCost1,AnnualCost2,AnnualCost3,AnnualCost4,AnnualCost5,AnnualCost6,AnnualCost7,AnnualCost8,AnnualCost9,AnnualCost10,ContractStatus,
				  AutoRenewal,AutoRenewalTerms,AutoRenewalTimes,CONVERT(varchar(10),AutoRenewalDeadline,23) AS 'AutoRenewalDeadline',ContractFileName,conUploadDate,BAAFileName,baaUploadDate,COIFileName,coiUploadDate,ServiceEvaluationPeriod,
				  ServiceEvaluationFileName,sevUploadDate,AddendumFileName,admUploadDate,MemorandumOfUnderstandingFileName,mouUploadDate,PurchaseOrderFileName,
				  poUploadDate,LastServiceEvaluationDate,NextServiceEvaluationDate 
				FROM ContractData WHERE ContractID = '".$id."'";
		$result = sqlsrv_query($conn2, $sql2);
		$row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);
		$costarray = array($row['AnnualCost1'],$row['AnnualCost2'],$row['AnnualCost3'],$row['AnnualCost4'],$row['AnnualCost5'],$row['AnnualCost6'],$row['AnnualCost7'],$row['AnnualCost8'],$row['AnnualCost9'],$row['AnnualCost10']);
		$totalcost = array_sum($costarray);
		
		$ContractingEntity 					= $row['ContractingEntity'];
		$Vendor 							= $row['Vendor'];
		$ContractType 						= $row['ContractType'];
		$ContractTitle						= $row['ContractTitle'];
		$ContractDescription 				= $row['ContractDescription'];
		$Department 						= $row['Department'];
		$EOC 								= $row['EOC'];
		$ResponsiblePartyPri 				= $row['ResponsiblePartyPri'];
		$ResponsiblePartySec 				= $row['ResponsiblePartySec'];
		$ResponsiblePartyTer 				= $row['ResponsiblePartyTer'];
		$AdditionalReviewer1				= $row['AdditionalReviewer1'];
		$AdditionalReviewer2				= $row['AdditionalReviewer2'];
		$EffectiveDate 						= $row['EffectiveDate'];
		$ExpirationDate 					= $row['ExpirationDate'];
		$AnnualCost1						= $row['AnnualCost1'];
		$AnnualCost2                		= $row['AnnualCost2'];
		$AnnualCost3                		= $row['AnnualCost3'];
		$AnnualCost4                		= $row['AnnualCost4'];
		$AnnualCost5                		= $row['AnnualCost5'];
		$AnnualCost6                		= $row['AnnualCost6'];
		$AnnualCost7                		= $row['AnnualCost7'];
		$AnnualCost8                		= $row['AnnualCost8'];
		$AnnualCost9                		= $row['AnnualCost9'];
		$AnnualCost10               		= $row['AnnualCost10'];
		$ContractStatus 					= $row['ContractStatus'];
		$AutoRenewal 						= $row['AutoRenewal'];
		$AutoRenewalTerms 					= $row['AutoRenewalTerms'];
		$AutoRenewalTimes 					= $row['AutoRenewalTimes'];
		$AutoRenewalDeadline 					= $row['AutoRenewalDeadline'];
		$ServiceEvaluationPeriod 			= $row['ServiceEvaluationPeriod'];
		$ContractFileName					= $row['ContractFileName'];
		$conUploadDate						= $row['conUploadDate'];
		$BAAFileName                        = $row['BAAFileName'];
		$baaUploadDate						= $row['baaUploadDate'];
		$COIFileName                        = $row['COIFileName'];
		$coiUploadDate						= $row['coiUploadDate'];
		$ServiceEvaluationFileName          = $row['ServiceEvaluationFileName'];
		$sevUploadDate						= $row['sevUploadDate'];
		$AddendumFileName                   = $row['AddendumFileName'];
		$admUploadDate						= $row['admUploadDate'];
		$MemorandumOfUnderstandingFileName  = $row['MemorandumOfUnderstandingFileName'];
		$mouUploadDate						= $row['mouUploadDate'];
		$PurchaseOrderFileName	            = $row['PurchaseOrderFileName'];
		$poUploadDate						= $row['poUploadDate'];
		if($row['NextServiceEvaluationDate'] == NULL) {$NextServiceEvaluationDate = 'N/A';} else {$NextServiceEvaluationDate = $row['NextServiceEvaluationDate']->format('Y-m-d');}
		if($row['LastServiceEvaluationDate'] == NULL) {$LastServiceEvaluationDate = 'N/A';} else {$LastServiceEvaluationDate = $row['LastServiceEvaluationDate']->format('Y-m-d');}
		
		full_display();
			
	} else {
		$conn2 = db_conn();
		$sql2 = "SELECT ContractID,ContractingEntity,Vendor,ContractType,ContractTitle,ContractDescription,Department,EOC,ResponsiblePartyPri,ResponsiblePartySec,
				  ResponsiblePartyTer,AdditionalReviewer1,AdditionalReviewer2,CONVERT(varchar(10),EffectiveDate,23) AS 'EffectiveDate',CONVERT(varchar(10),ExpirationDate,23) AS 'ExpirationDate',
				  AnnualCost1,AnnualCost2,AnnualCost3,AnnualCost4,AnnualCost5,AnnualCost6,AnnualCost7,AnnualCost8,AnnualCost9,AnnualCost10,ContractStatus,
				  AutoRenewal,AutoRenewalTerms,AutoRenewalTimes,CONVERT(varchar(10),AutoRenewalDeadline,23) AS 'AutoRenewalDeadline',ContractFileName,conUploadDate,BAAFileName,baaUploadDate,COIFileName,coiUploadDate,ServiceEvaluationPeriod,
				  ServiceEvaluationFileName,sevUploadDate,AddendumFileName,admUploadDate,MemorandumOfUnderstandingFileName,mouUploadDate,PurchaseOrderFileName,
				  poUploadDate,LastServiceEvaluationDate,NextServiceEvaluationDate 
				FROM ContractData WHERE ContractID = '".$id."'";
		$result = sqlsrv_query($conn2, $sql2);
		$row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);
		$costarray = array($row['AnnualCost1'],$row['AnnualCost2'],$row['AnnualCost3'],$row['AnnualCost4'],$row['AnnualCost5'],$row['AnnualCost6'],$row['AnnualCost7'],$row['AnnualCost8'],$row['AnnualCost9'],$row['AnnualCost10']);
		$totalcost = array_sum($costarray);
		
		$ContractingEntity 					= $row['ContractingEntity'];
		$Vendor 							= $row['Vendor'];
		$ContractType 						= $row['ContractType'];
		$ContractTitle						= $row['ContractTitle'];
		$ContractDescription 				= $row['ContractDescription'];
		$Department 						= $row['Department'];
		$EOC 								= $row['EOC'];
		$ResponsiblePartyPri 				= $row['ResponsiblePartyPri'];
		$ResponsiblePartySec 				= $row['ResponsiblePartySec'];
		$ResponsiblePartyTer 				= $row['ResponsiblePartyTer'];
		$AdditionalReviewer1				= $row['AdditionalReviewer1'];
		$AdditionalReviewer2				= $row['AdditionalReviewer2'];
		$EffectiveDate 						= $row['EffectiveDate'];
		$ExpirationDate 					= $row['ExpirationDate'];
		$AnnualCost1						= $row['AnnualCost1'];
		$AnnualCost2                		= $row['AnnualCost2'];
		$AnnualCost3                		= $row['AnnualCost3'];
		$AnnualCost4                		= $row['AnnualCost4'];
		$AnnualCost5                		= $row['AnnualCost5'];
		$AnnualCost6                		= $row['AnnualCost6'];
		$AnnualCost7                		= $row['AnnualCost7'];
		$AnnualCost8                		= $row['AnnualCost8'];
		$AnnualCost9                		= $row['AnnualCost9'];
		$AnnualCost10               		= $row['AnnualCost10'];
		$ContractStatus 					= $row['ContractStatus'];
		$AutoRenewal 						= $row['AutoRenewal'];
		$AutoRenewalTerms 					= $row['AutoRenewalTerms'];
		$AutoRenewalTimes 					= $row['AutoRenewalTimes'];
		$AutoRenewalDeadline 					= $row['AutoRenewalDeadline'];
		$ServiceEvaluationPeriod 			= $row['ServiceEvaluationPeriod'];
		$ContractFileName					= $row['ContractFileName'];
		$conUploadDate						= $row['conUploadDate'];
		$BAAFileName                        = $row['BAAFileName'];
		$baaUploadDate						= $row['baaUploadDate'];
		$COIFileName                        = $row['COIFileName'];
		$coiUploadDate						= $row['coiUploadDate'];
		$ServiceEvaluationFileName          = $row['ServiceEvaluationFileName'];
		$sevUploadDate						= $row['sevUploadDate'];
		$AddendumFileName                   = $row['AddendumFileName'];
		$admUploadDate						= $row['admUploadDate'];
		$MemorandumOfUnderstandingFileName  = $row['MemorandumOfUnderstandingFileName'];
		$mouUploadDate						= $row['mouUploadDate'];
		$PurchaseOrderFileName	            = $row['PurchaseOrderFileName'];
		$poUploadDate						= $row['poUploadDate'];
		if($row['NextServiceEvaluationDate'] == NULL) {$NextServiceEvaluationDate = 'N/A';} else {$NextServiceEvaluationDate = $row['NextServiceEvaluationDate']->format('Y-m-d');}
		if($row['LastServiceEvaluationDate'] == NULL) {$LastServiceEvaluationDate = 'N/A';} else {$LastServiceEvaluationDate = $row['LastServiceEvaluationDate']->format('Y-m-d');}
		
		full_display();
	}

} else { 							//if opening page for the first time
		$id = $_POST['selected'];
		
		$conn = db_conn();
		$sql = "SELECT ContractID,ContractingEntity,Vendor,ContractType,ContractTitle,ContractDescription,Department,EOC,ResponsiblePartyPri,ResponsiblePartySec,
				  ResponsiblePartyTer,AdditionalReviewer1,AdditionalReviewer2,CONVERT(varchar(10),EffectiveDate,23) AS 'EffectiveDate',CONVERT(varchar(10),ExpirationDate,23) AS 'ExpirationDate',
				  AnnualCost1,AnnualCost2,AnnualCost3,AnnualCost4,AnnualCost5,AnnualCost6,AnnualCost7,AnnualCost8,AnnualCost9,AnnualCost10,ContractStatus,
				  AutoRenewal,AutoRenewalTerms,AutoRenewalTimes,CONVERT(varchar(10),AutoRenewalDeadline,23) AS 'AutoRenewalDeadline',ContractFileName,conUploadDate,BAAFileName,baaUploadDate,COIFileName,coiUploadDate,ServiceEvaluationPeriod,
				  ServiceEvaluationFileName,sevUploadDate,AddendumFileName,admUploadDate,MemorandumOfUnderstandingFileName,mouUploadDate,PurchaseOrderFileName,
				  poUploadDate,LastServiceEvaluationDate,NextServiceEvaluationDate 
				FROM ContractData WHERE ContractID = '".$id."'";
		$result = sqlsrv_query($conn, $sql);
		$row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);
		$costarray = array($row['AnnualCost1'],$row['AnnualCost2'],$row['AnnualCost3'],$row['AnnualCost4'],$row['AnnualCost5'],$row['AnnualCost6'],$row['AnnualCost7'],$row['AnnualCost8'],$row['AnnualCost9'],$row['AnnualCost10']);
		$totalcost = array_sum($costarray);
		
		$ContractingEntity 					= $row['ContractingEntity'];
		$Vendor 							= $row['Vendor'];
		$ContractType 						= $row['ContractType'];
		$ContractTitle						= $row['ContractTitle'];
		$ContractDescription 				= $row['ContractDescription'];
		$Department 						= $row['Department'];
		$EOC 								= $row['EOC'];
		$ResponsiblePartyPri 				= $row['ResponsiblePartyPri'];
		$ResponsiblePartySec 				= $row['ResponsiblePartySec'];
		$ResponsiblePartyTer 				= $row['ResponsiblePartyTer'];
		$AdditionalReviewer1				= $row['AdditionalReviewer1'];
		$AdditionalReviewer2				= $row['AdditionalReviewer2'];
		$EffectiveDate 						= $row['EffectiveDate'];
		$ExpirationDate 					= $row['ExpirationDate'];
		$AnnualCost1						= $row['AnnualCost1'];
		$AnnualCost2                		= $row['AnnualCost2'];
		$AnnualCost3                		= $row['AnnualCost3'];
		$AnnualCost4                		= $row['AnnualCost4'];
		$AnnualCost5                		= $row['AnnualCost5'];
		$AnnualCost6                		= $row['AnnualCost6'];
		$AnnualCost7                		= $row['AnnualCost7'];
		$AnnualCost8                		= $row['AnnualCost8'];
		$AnnualCost9                		= $row['AnnualCost9'];
		$AnnualCost10               		= $row['AnnualCost10'];
		$ContractStatus 					= $row['ContractStatus'];
		$AutoRenewal 						= $row['AutoRenewal'];
		$AutoRenewalTerms 					= $row['AutoRenewalTerms'];
		$AutoRenewalTimes 					= $row['AutoRenewalTimes'];
		$AutoRenewalDeadline 				= $row['AutoRenewalDeadline'];
		$ServiceEvaluationPeriod 			= $row['ServiceEvaluationPeriod'];
		$ContractFileName					= $row['ContractFileName'];
		$conUploadDate						= $row['conUploadDate'];
		$BAAFileName                        = $row['BAAFileName'];
		$baaUploadDate						= $row['baaUploadDate'];
		$COIFileName                        = $row['COIFileName'];
		$coiUploadDate						= $row['coiUploadDate'];
		$ServiceEvaluationFileName          = $row['ServiceEvaluationFileName'];
		$sevUploadDate						= $row['sevUploadDate'];
		$AddendumFileName                   = $row['AddendumFileName'];
		$admUploadDate						= $row['admUploadDate'];
		$MemorandumOfUnderstandingFileName  = $row['MemorandumOfUnderstandingFileName'];
		$mouUploadDate						= $row['mouUploadDate'];
		$PurchaseOrderFileName	            = $row['PurchaseOrderFileName'];
		$poUploadDate						= $row['poUploadDate'];
		if($row['NextServiceEvaluationDate'] == NULL) {$NextServiceEvaluationDate = 'N/A';} else {$NextServiceEvaluationDate = $row['NextServiceEvaluationDate']->format('Y-m-d');}
		if($row['LastServiceEvaluationDate'] == NULL) {$LastServiceEvaluationDate = 'N/A';} else {$LastServiceEvaluationDate = $row['LastServiceEvaluationDate']->format('Y-m-d');}
		
		
	full_display();
} 

page_footer();
?>