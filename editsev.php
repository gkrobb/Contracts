<?php
require_once ('cms_fns.php');
require_once ('forms_fns.php');
page_header('Edit Service Evaluation Information','main');

$id = $_POST['id'];
$conn = db_conn();
$sql = "SELECT ContractID,Vendor,ContractTitle,ServiceEvaluationPeriod,LastServiceEvaluationDate,NextServiceEvaluationDate FROM ContractData WHERE ContractID = '".$id."'";
$result = sqlsrv_query($conn, $sql);
$row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);

$sevper = $row['ServiceEvaluationPeriod'];
if($row['LastServiceEvaluationDate'] == NULL){$lastsev = 'N/A';}else{$lastsev = $row['LastServiceEvaluationDate']->format('Y-m-d');}
if($row['NextServiceEvaluationDate'] == NULL){$nextsev = 'N/A';}else{$nextsev = $row['NextServiceEvaluationDate']->format('Y-m-d');}


?>
<h1 class="sevhead"><span id="namehead"><?php echo $row['Vendor']; ?> - <?php echo $row['ContractTitle']; ?></span></h1>

<div class="topbar" id="editsev">
		<div id="backform">
			<form action="fulldisplay.php" method="post" enctype="multipart/form-data">
				<input type="text" value="<?php echo $id; ?>" name="backid" class="hid" hidden>
				<input type="image" src="img/Back.png" name="backbutton" value="Back" onMouseOver="this.src='img/BackHO.png'" onMouseOut="this.src='img/Back.png'"/>
			</form>
		</div>
	<h1>edit service evaluation info</h1>
	</div>

<form action="fulldisplay.php" method="post" enctype="multipart/form-data">
<input type="text" value="1" name="updatesev" class="hid" hidden>
<input type="text" value="<?php echo $row['ContractID']; ?>" name="ContractID" class="hid" hidden>
<table class="editservice">

<tr>
	<td></td>
	<td><strong>Current Data</strong></td>
	<td id="centerhead"><strong>Enter New Service Evaluation Data below...</strong></td>
</tr>
<tr>
	<td><strong>Service Evaluation Period</strong></td>
	<td><?php echo $sevper; ?></td>
	<td>
		<select name="ServiceEvaluationPeriod">																								<!-- ServiceEvaluationPeriod dropdown -->
			<option value="">(Service Evaluation Frequency...)</option>
			<option value="Annual">Annually (non-clinical)</option>
			<option value="Biannual">Bi-Annual (clinical)</option>
		</select>
	</td>
</tr>
<tr>
	<td><strong>Last Evaluation Date</strong></td>
	<td><?php echo $lastsev; ?></td>  
	<td><input type="text" name="LastServiceEvaluationDate" placeholder="(Select New Date...)" class="datepicker" /></td>
</tr>
<tr>
	<td><strong>Next Evaluation Date</strong></td>
	<td><?php echo $nextsev; ?></td>
	<td><input type="text" name="NextServiceEvaluationDate" placeholder="(Select New Date...)" class="datepicker" /></td>
</tr>
<tr>
	<td></td>
	<td><div id="updatesev"><input type="image" src="img/Update.png" value="Update" onMouseOver="this.src='img/UpdateHO.png'" onMouseOut="this.src='img/Update.png'"/></div></td>
	<td></td>
</tr>
</table>
</form>

<?php
page_footer();
?>




