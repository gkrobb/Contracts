<?php
////////////////////////SERVER VARIABLES///////////////////////////////
$server = 'CH-CONTRACTS\SQLEXPRESS';
$db = 'Contracts';
$superusers = array('CLAXTON\ROBBG','CLAXTON\NELSONP','CLAXTON\WOODSKS','CLAXTON\COLBURNJL','CLAXTON\GIJANTOC','CLAXTON\TIERNANK','CLAXTON\FERRISD','CLAXTON\WRAYN','CLAXTON\IMPAGLIAA');
///////////////////////////////////////////////////////////////////////
function page_header($title,$bodyid){
	
?>
<!DOCTYPE html>

<html>
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=Edge">
	<title><?php echo $title; ?></title>
	<link rel="stylesheet" href="cms.css" />
	<link rel="stylesheet" href="admin.css" />
	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
	<link rel="shortcut icon" href="favicon.ico" />
	<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	<script>
		$( function() {
		$( ".datepicker" ).datepicker({autoclose: true});
		} );
	</script>
</head>

<body id="<?php echo $bodyid; ?>">
<div id="header">
<img src="img/CHCMSBanner.png" class="banner" usemap="#bannermap">

<map name="bannermap">
	<area shape="rect" coords="40,18,490,85" alt="Banner" href="./">
</map>

	<div id="links">
		<table border='0' cellpadding='5'>
			<tr>
				<td><a href="existing.php" title="Existing"><img src="img/BTNexcon.png" alt="Existing Contracts" onMouseOver="this.src='img/BTNexconHO.png'" onMouseOut="this.src='img/BTNexcon.png'"></a></td>
				<td><a href="http://datarepo1/Reports/Pages/Folder.aspx?ItemPath=%2fCHMC+Contracts&ViewMode=List" target="_blank" title="Reports"><img src="img/BTNreports.png" alt="Reports" onMouseOver="this.src='img/BTNreportsHO.png'" onMouseOut="this.src='img/BTNreports.png'"></a></td>
				<td><a href="new.php" title="Enter a New Contract"><img src="img/BTNnwcon.png" alt="Add New Contract" onMouseOver="this.src='img/BTNnwconHO.png'" onMouseOut="this.src='img/BTNnwcon.png'"></a></td>
				<td><a href="./" title="Home"><img src="img/Homebtn.png" alt="Home" onMouseOver="this.src='img/HomebtnHO.png'" onMouseOut="this.src='img/Homebtn.png'"></a></td>
				<td><a href="help.php" target="_blank" title="Help!"><img src="img/QM.png" alt="Home" onMouseOver="this.src='img/QMHO.png'" onMouseOut="this.src='img/QM.png'"></a></td>
				<td><a href="admin.php" title="Admin"><img src="img/BTNAdmin.png" alt="Admin" onMouseOver="this.src='img/BTNAdminHO.png'" onMouseOut="this.src='img/BTNAdmin.png'"></a></td>
			</tr>
		</table>
	</div>

</div>

<?php
}

function page_footer(){
?>
</body>
</html>
<?php
}

function db_conn() {
	global $server, $db;
	$serverName = $server;
	$connectionInfo = array('Database'=>$db);
	$conn = sqlsrv_connect( $serverName, $connectionInfo);

if( !$conn ) {
     echo "Connection could not be established.<br />";
     die( print_r( sqlsrv_errors(), true));
}else{
     return $conn;
}
}

/* Random Filename Generators for each of the 7 possible files that can be uploaded */
/* Returns a new file name prefixed with a code indicating the type of file that it is */
/* Also checks the database first to make sure the name doesnt exist, which is should not, but just in case it will fail */
function new_Contract_filename() {
$newname = uniqid('con_',TRUE);
$conn = db_conn();
$sql = "SELECT * FROM ContractData WHERE ContractFileName = '".$newname."'";
$stmt = sqlsrv_query($conn,$sql);
$rows = sqlsrv_num_rows($stmt);
if ($rows > 0) {
	echo "File name already exists.  Please upload again.";
} else {
	//echo "This is a valid filename";
	return $newname;
}
}

function new_BAA_filename() {
$newname = uniqid('baa_',TRUE);
$conn = db_conn();
$sql = "SELECT * FROM ContractData WHERE BAAFileName = '".$newname."'";
$stmt = sqlsrv_query($conn,$sql);
$rows = sqlsrv_num_rows($stmt);
if ($rows > 0) {
	echo "File name already exists.  Please upload again.";
} else {
	//echo "This is a valid filename";
	return $newname;
}
}

function new_COI_filename() {
$newname = uniqid('coi_',TRUE);
$conn = db_conn();
$sql = "SELECT * FROM ContractData WHERE COIFileName = '".$newname."'";
$stmt = sqlsrv_query($conn,$sql);
$rows = sqlsrv_num_rows($stmt);
if ($rows > 0) {
	echo "File name already exists.  Please upload again.";
} else {
	//echo "This is a valid filename";
	return $newname;
}
}

function new_ServiceEvaluation_filename() {
$newname = uniqid('sev_',TRUE);
$conn = db_conn();
$sql = "SELECT * FROM ContractData WHERE ServiceEvaluationFileName = '".$newname."'";
$stmt = sqlsrv_query($conn,$sql);
$rows = sqlsrv_num_rows($stmt);
if ($rows > 0) {
	echo "File name already exists.  Please upload again.";
} else {
	//echo "This is a valid filename";
	return $newname;
}
}

function new_Addendum_filename() {
$newname = uniqid('add_',TRUE);
$conn = db_conn();
$sql = "SELECT * FROM ContractData WHERE AddendumFileName = '".$newname."'";
$stmt = sqlsrv_query($conn,$sql);
$rows = sqlsrv_num_rows($stmt);
if ($rows > 0) {
	echo "File name already exists.  Please upload again.";
} else {
	//echo "This is a valid filename";
	return $newname;
}
}

function new_MOU_filename() {
$newname = uniqid('mou_',TRUE);
$conn = db_conn();
$sql = "SELECT * FROM ContractData WHERE MemorandumOfUnderstandingFileName = '".$newname."'";
$stmt = sqlsrv_query($conn,$sql);
$rows = sqlsrv_num_rows($stmt);
if ($rows > 0) {
	echo "File name already exists.  Please upload again.";
} else {
	//echo "This is a valid filename";
	return $newname;
}
}

function new_PurchaseOrder_filename() {
$newname = uniqid('po_',TRUE);
$conn = db_conn();
$sql = "SELECT * FROM ContractData WHERE PurchaseOrderFileName = '".$newname."'";
$stmt = sqlsrv_query($conn,$sql);
$rows = sqlsrv_num_rows($stmt);
if ($rows > 0) {
	echo "File name already exists.  Please upload again.";
} else {
	//echo "This is a valid filename";
	return $newname;
}
}


?>


	
