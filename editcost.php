<?php
session_start();
require_once ('cms_fns.php');

page_header('Edit Contract Costs','main');
$id = $_POST['id'];
$conn = db_conn();
$sql = "SELECT ContractID,Vendor,ContractTitle,EffectiveDate,AnnualCost1,AnnualCost2,AnnualCost3,AnnualCost4,AnnualCost5,AnnualCost6,AnnualCost7,AnnualCost8,AnnualCost9,AnnualCost10 FROM ContractData WHERE ContractID = '".$id."'";
$result = sqlsrv_query($conn, $sql);
$row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);
?>
<h1 class="costhead"><span id="namehead"><?php echo $row['Vendor']; ?> - <?php echo $row['ContractTitle']; ?></span></h1>

<div class="topbar" id="costeditbar">
<div id="backform">
	<form action="fulldisplay.php" method="post" enctype="multipart/form-data">
	<input type="text" value="<?php echo $id; ?>" name="backid" class="hid" hidden>
	<input type="image" src="img/Back.png" name="backbutton" value="Back" onMouseOver="this.src='img/BackHO.png'" onMouseOut="this.src='img/Back.png'"/>
	</form>
	</div>
	<h1>edit cost info</h1>
</div>
<form method="post" action="fulldisplay.php" enctype="multipart/form-data" id="costform">
<input type="text" value="1" name="costedit" class="hid" hidden>
<input type="text" value="<?php echo $row['ContractID']; ?>" name="ContractID" class="hid" hidden>
<table class="costedit">
<tr>
<td><strong>Year</strong></td>
<td><strong>Current Value</strong></td>
<td><strong>New Value</strong></td>
</tr>
<tr>
<td><strong>1</strong></td>
<td><?php if($row['AnnualCost1'] > 0) {echo '$'.$row['AnnualCost1'];} else {echo 'N/A';} ?></td>
<td>
	<!-- <input type="text" value="1" name="field1" class="hid" hidden> -->
	<input title="Update Cost for Year 1" type="text" name="AnnualCost1" class="costfield"/>
</td>
</tr>
<tr>
<td><strong>2</strong></td>
<td><?php if($row['AnnualCost2'] > 0) {echo '$'.$row['AnnualCost2'];} else {echo 'N/A';} ?></td>
<td>
	<!-- <input type="text" value="2" name="field2" class="hid" hidden> -->
	<input title="Update Cost for Year 2" type="text" name="AnnualCost2" class="costfield"/>
</td>
</tr>
<tr>
<td><strong>3</strong></td>
<td><?php if($row['AnnualCost3'] > 0) {echo '$'.$row['AnnualCost3'];} else {echo 'N/A';} ?></td>
<td>
	<!-- <input type="text" value="3" name="field3" class="hid" hidden> -->
	<input title="Update Cost for Year 3" type="text" name="AnnualCost3" class="costfield"/>
</td>
</tr>
<tr>
<td><strong>4</strong></td>
<td><?php if($row['AnnualCost4'] > 0) {echo '$'.$row['AnnualCost4'];} else {echo 'N/A';} ?></td>
<td>
	<!-- <input type="text" value="4" name="field4" class="hid" hidden> -->
	<input title="Update Cost for Year 4" type="text" name="AnnualCost4" class="costfield"/>
</td>
</tr>
<tr>
<td><strong>5</strong></td>
<td><?php if($row['AnnualCost5'] > 0) {echo '$'.$row['AnnualCost5'];} else {echo 'N/A';} ?></td>
<td>
	<!-- <input type="text" value="5" name="field5" class="hid" hidden> -->
	<input title="Update Cost for Year 5" type="text" name="AnnualCost5" class="costfield"/>
</td>
</tr>
<tr>
<td><strong>6</strong></td>
<td><?php if($row['AnnualCost6'] > 0) {echo '$'.$row['AnnualCost6'];} else {echo 'N/A';} ?></td>
<td>
	<!-- <input type="text" value="6" name="field6" class="hid" hidden> -->
	<input title="Update Cost for Year 6" type="text" name="AnnualCost6" class="costfield"/>
</td>
</tr>
<tr>
<td><strong>7</strong></td>
<td><?php if($row['AnnualCost7'] > 0) {echo '$'.$row['AnnualCost7'];} else {echo 'N/A';} ?></td>
<td>
	<!-- <input type="text" value="7" name="field7" class="hid" hidden> -->
	<input title="Update Cost for Year 7" type="text" name="AnnualCost7" class="costfield"/>
</td>
</tr>
<tr>
<td><strong>8</strong></td>
<td><?php if($row['AnnualCost8'] > 0) {echo '$'.$row['AnnualCost8'];} else {echo 'N/A';} ?></td>
<td>
	<!-- <input type="text" value="8" name="field8" class="hid" hidden> -->
	<input title="Update Cost for Year 8" type="text" name="AnnualCost8" class="costfield"/>
</td>
</tr>
<tr>
<td><strong>9</strong></td>
<td><?php if($row['AnnualCost9'] > 0) {echo '$'.$row['AnnualCost9'];} else {echo 'N/A';} ?></td>
<td>
	<!-- <input type="text" value="9" name="field9" class="hid" hidden> -->
	<input title="Update Cost for Year 9" type="text" name="AnnualCost9" class="costfield"/>
</td>
</tr>
<tr>
<td><strong>10</strong></td>
<td><?php if($row['AnnualCost10'] > 0) {echo '$'.$row['AnnualCost10'];} else {echo 'N/A';} ?></td>
<td>
	<!-- <input type="text" value="10" name="field10" class="hid" hidden> -->
	<input title="Update Cost for Year 10" type="text" name="AnnualCost10" class="costfield"/>
</td>
</tr>
<tr>
<td></td>
<td class="updatecostbutton"><input type="image" src="img/Update.png" value="Submit"  onMouseOver="this.src='img/UpdateHO.png'" onMouseOut="this.src='img/Update.png'"/></td>
<td></td>
</tr>
</table>
</form>

