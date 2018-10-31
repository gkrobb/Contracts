<?php
//session_start();
require_once ('cms_fns.php');
require_once ('forms_fns.php');

page_header('Edit','main');

$id = $_POST['id'];
$field = $_POST['field'];

$conn = db_conn();
$sql = "SELECT ContractID,ContractingEntity,Vendor,ContractType,ContractTitle,ContractDescription,Department,EOC,ResponsiblePartyPri,ResponsiblePartySec,ResponsiblePartyTer,AdditionalReviewer1,AdditionalReviewer2,CONVERT(varchar(10),EffectiveDate,23) AS 'EffectiveDate',
		CONVERT(varchar(10),ExpirationDate,23) AS 'ExpirationDate',ContractStatus,AutoRenewal,AutoRenewalTerms,AutoRenewalTimes,AutoRenewalDeadline,ContractFileName,BAAFileName,COIFileName,ServiceEvaluationPeriod,ServiceEvaluationFileName,
		AddendumFileName,MemorandumOfUnderstandingFileName,PurchaseOrderFileName FROM ContractData WHERE ContractID = '".$id."'";
$result = sqlsrv_query($conn, $sql);
$row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);
?>
<h1 class="edithead"><span id="namehead"><?php echo $row['Vendor']; ?> - <?php echo $row['ContractTitle']; ?></span></h1>
<?php
if ($field == 1) {  //Contracting Entity
?>
<div class="topbar" id="editheader">
<div id="backform">
	<form action="editdetails.php" method="post" enctype="multipart/form-data">
	<input type="text" value="<?php echo $id; ?>" name="backid" class="hid" hidden>
	<input type="image" src="img/Back.png" name="backbutton" value="Back" onMouseOver="this.src='img/BackHO.png'" onMouseOut="this.src='img/Back.png'"/>
	</form>
	</div>
	<h1>edit contracting entity</h1>
	</div>
<table class="edits">

<tr>
<th>Old Contracting Entity</th>
<td><?php echo $row['ContractingEntity']; ?></td>
</tr>
<tr>
<th>New Contracting Entity</th>
<td>
<form method="post" action="editdetails.php" enctype="multipart/form-data" id="editform">
	<select title='Please select the Contracting Entity' name="ContractingEntity" required>															
		<option value="">(Contracting Entity...)</option>							
		<option value="Claxton-Hepburn">Claxton-Hepburn</option>							
		<option value="Claxton Medical PC">Claxton Medical PC</option>							
	</select>
	<input type="text" value="<?php echo $row['ContractID']; ?>" name="id" class="hid" hidden>
	<input type="text" value="1" name="field" class="hid" hidden>
	
</td>
</tr>
<tr>
<!-- <td class="updatebutton"><input type="submit" value="Update"></td> -->
<td class="updatebutton"><input type="image" src="img/Update.png" value="Submit"  onMouseOver="this.src='img/UpdateHO.png'" onMouseOut="this.src='img/Update.png'"/></td>
</form>
</tr>
<?php

}

if ($field == 2) {  //Vendor
?>
<div class="topbar" id="editheader">
<div id="backform">
	<form action="editdetails.php" method="post" enctype="multipart/form-data">
	<input type="text" value="<?php echo $id; ?>" name="backid" class="hid" hidden>
	<input type="image" src="img/Back.png" name="backbutton" value="Back" onMouseOver="this.src='img/BackHO.png'" onMouseOut="this.src='img/Back.png'"/>
	</form>
	</div>
	<h1>edit vendor</h1>
	</div>
<table class="edits">

<tr>
<th>Old Vendor</th>
<td><?php echo $row['Vendor']; ?></td>
</tr>
<tr>
<th>New Vendor</th>
<td>
<form method="post" action="editdetails.php" enctype="multipart/form-data" id="editform">
<input title='Enter a Vendor Name' type="text" name="Vendor" placeholder="Vendor Name" required />
<input type="text" value="<?php echo $row['ContractID']; ?>" name="id" class="hid" hidden>
<input type="text" value="2" name="field" class="hid" hidden>
</td>
</tr>
<tr>
<!-- <td class="updatebutton"><input type="submit" value="Update"></td> -->
<td class="updatebutton"><input type="image" src="img/Update.png" value="Submit"  onMouseOver="this.src='img/UpdateHO.png'" onMouseOut="this.src='img/Update.png'"/></td>
</form>
</tr>
<?php
}

if ($field == 3) {  //ContractType
?>
<div class="topbar" id="editheader">
<div id="backform">
	<form action="editdetails.php" method="post" enctype="multipart/form-data">
	<input type="text" value="<?php echo $id; ?>" name="backid" class="hid" hidden>
	<input type="image" src="img/Back.png" name="backbutton" value="Back" onMouseOver="this.src='img/BackHO.png'" onMouseOut="this.src='img/Back.png'"/>
	</form>
	</div>
	<h1>edit contract type</h1>
	</div>
<table class="edits">

<tr>
<th>Old Contract Type</th>
<td><?php echo $row['ContractType']; ?></td>
</tr>
<tr>
<th>New Contract Type</th>
<td>
<form method="post" action="editdetails.php" enctype="multipart/form-data" id="editform">
<select name="ContractType" title='Select a Contract Type' required>																			<!-- ContractType Dropdown -->
	<option value="">(Contract Type...)</option>
	<option value="Administrative Services Agreement">Administrative Services Agreement</option>
	<option value="Affiliation Agreement">Affiliation Agreement</option>
	<option value="Business Associate Agreement (Stand Alone)">Business Associate Agreement (Stand Alone)</option>
	<option value="Consulting Services Agreement">Consulting Services Agreement</option>
	<option value="Employment Agreement (Non-physician)">Employment Agreement (Non-physician)</option>
	<option value="Lease">Lease</option>
	<option value="Memorandum of Understanding">Memorandum of Understanding</option>
	<option value="Physician: Employment Agreement">Physician: Employment Agreement</option>
	<option value="Real Estate: Hospital as Landlord or Tenant">Real Estate: Hospital as Landlord or Tenant</option>
	<option value="Services (equipment) Maintenance Agreement">Services (equipment) Maintenance Agreement</option>
	<option value="Supervising Agreement: Physician Assistant  or Nurse Practitioner">Supervising Agreement: Physician Assistant  or Nurse Practitioner</option>
	<option value="Transfer Agreement">Transfer Agreement</option>
	<option value="Local Pricing Agreement">Local Pricing Agreement</option>
	<option value="Purchased Performed Services">Purchased Performed Services</option>
	<option value="Service (IT&S) Hardware/Software">Service (IT&S) Hardware/Software</option>
	<option value="Usage Agreement">Usage Agreement</option>
	<option value="Consignment">Consignment</option>
	<option value="Insurance Contract">Insurance Contract</option>
</select>
<input type="text" value="<?php echo $row['ContractID']; ?>" name="id" class="hid" hidden>
<input type="text" value="3" name="field" class="hid" hidden>
</td>
</tr>
<tr>
<!-- <td class="updatebutton"><input type="submit" value="Update"></td> -->
<td class="updatebutton"><input type="image" src="img/Update.png" value="Submit"  onMouseOver="this.src='img/UpdateHO.png'" onMouseOut="this.src='img/Update.png'"/></td>
</form>
</tr>
<?php
}

if ($field == 4) {  //ContractTitle
?>
<div class="topbar" id="editheader">
<div id="backform">
	<form action="editdetails.php" method="post" enctype="multipart/form-data">
	<input type="text" value="<?php echo $id; ?>" name="backid" class="hid" hidden>
	<input type="image" src="img/Back.png" name="backbutton" value="Back" onMouseOver="this.src='img/BackHO.png'" onMouseOut="this.src='img/Back.png'"/>
	</form>
	</div>
	<h1>edit contract title</h1>
	</div>
<table class="edits">

<tr>
<th>Old Title</th>
<td><?php echo $row['ContractTitle']; ?></td>
</tr>
<tr>
<th>New Title</th>
<td>
<form method="post" action="editdetails.php" enctype="multipart/form-data" id="editform">
<input title='Enter a Contract Title' type="text" name="ContractTitle" placeholder="Contract Title" required />
<input type="text" value="<?php echo $row['ContractID']; ?>" name="id" class="hid" hidden>
<input type="text" value="4" name="field" class="hid" hidden>
</td>
</tr>
<tr>
<!-- <td class="updatebutton"><input type="submit" value="Update"></td> -->
<td class="updatebutton"><input type="image" src="img/Update.png" value="Submit"  onMouseOver="this.src='img/UpdateHO.png'" onMouseOut="this.src='img/Update.png'"/></td>
</form>
</tr>
<?php
}

if ($field == 5) {  //ContractDescription
?>
<div class="topbar" id="editheader">
<div id="backform">
	<form action="editdetails.php" method="post" enctype="multipart/form-data">
	<input type="text" value="<?php echo $id; ?>" name="backid" class="hid" hidden>
	<input type="image" src="img/Back.png" name="backbutton" value="Back" onMouseOver="this.src='img/BackHO.png'" onMouseOut="this.src='img/Back.png'"/>
	</form>
	</div>
	<h1>edit contract description</h1>
	</div>
<table class="edits">

<tr>
<th>Old Contract Description</th>
<td><?php echo $row['ContractDescription']; ?></td>
</tr>
<tr>
<th>New Contract Description</th>
<td>
<form method="post" action="editdetails.php" enctype="multipart/form-data" id="editform">
<textarea name="ContractDescription" rows="3" cols="60"><?php echo $row['ContractDescription']; ?></textarea>
<input type="text" value="<?php echo $row['ContractID']; ?>" name="id" class="hid" hidden>
<input type="text" value="5" name="field" class="hid" hidden>
</td>
</tr>
<tr>
<!-- <td class="updatebutton"><input type="submit" value="Update"></td> -->
<td class="updatebutton"><input type="image" src="img/Update.png" value="Submit"  onMouseOver="this.src='img/UpdateHO.png'" onMouseOut="this.src='img/Update.png'"/></td>
</form>
</tr>
<?php
}

if ($field == 6) {  //Department
?>
<div class="topbar" id="editheader">
<div id="backform">
	<form action="editdetails.php" method="post" enctype="multipart/form-data">
	<input type="text" value="<?php echo $id; ?>" name="backid" class="hid" hidden>
	<input type="image" src="img/Back.png" name="backbutton" value="Back" onMouseOver="this.src='img/BackHO.png'" onMouseOut="this.src='img/Back.png'"/>
	</form>
	</div>
	<h1>edit department</h1>
	</div>
<table class="edits">

<tr>
<th>Old Department</th>
<td><?php echo $row['Department']; ?></td>
</tr>
<tr>
<th>New Department</th>
<td>
<form method="post" action="editdetails.php" enctype="multipart/form-data" id="editform">
<?php department_dropdown(); ?>
<input type="text" value="<?php echo $row['ContractID']; ?>" name="id" class="hid" hidden>
<input type="text" value="6" name="field" class="hid" hidden>
</td>
</tr>
<tr>
<!-- <td class="updatebutton"><input type="submit" value="Update"></td> -->
<td class="updatebutton"><input type="image" src="img/Update.png" value="Submit"  onMouseOver="this.src='img/UpdateHO.png'" onMouseOut="this.src='img/Update.png'"/></td>
</form>
</tr>
<?php
}

if ($field == 7) {  //ResponsiblePartyPri
?>
<div class="topbar" id="editheader">
<div id="backform">
	<form action="editdetails.php" method="post" enctype="multipart/form-data">
	<input type="text" value="<?php echo $id; ?>" name="backid" class="hid" hidden>
	<input type="image" src="img/Back.png" name="backbutton" value="Back" onMouseOver="this.src='img/BackHO.png'" onMouseOut="this.src='img/Back.png'"/>
	</form>
	</div>
	<h1>edit responsible party - primary</h1>
	</div>
<table class="edits">

<tr>
<th>Old Responsible Party (Primary)</th>
<td><?php echo $row['ResponsiblePartyPri']; ?></td>
</tr>
<tr>
<th>New Responsible Party (Primary)</th>
<td>
<form method="post" action="editdetails.php" enctype="multipart/form-data" id="editform">
<?php users_dropdown(ResponsiblePartyPri,Primary); ?>
<input type="text" value="<?php echo $row['ContractID']; ?>" name="id" class="hid" hidden>
<input type="text" value="7" name="field" class="hid" hidden>
</td>
</tr>
<tr>
<!-- <td class="updatebutton"><input type="submit" value="Update"></td> -->
<td class="updatebutton"><input type="image" src="img/Update.png" value="Submit"  onMouseOver="this.src='img/UpdateHO.png'" onMouseOut="this.src='img/Update.png'"/></td>
</form>
</tr>
<?php
}

if ($field == 8) {  //ResponsiblePartySec
?>
<div class="topbar" id="editheader">
<div id="backform">
	<form action="editdetails.php" method="post" enctype="multipart/form-data">
	<input type="text" value="<?php echo $id; ?>" name="backid" class="hid" hidden>
	<input type="image" src="img/Back.png" name="backbutton" value="Back" onMouseOver="this.src='img/BackHO.png'" onMouseOut="this.src='img/Back.png'"/>
	</form>
	</div>
	<h1>edit responsible party - secondary</h1>
	</div>
<table class="edits">

<tr>
<th>Old Responsible Party (Secondary)</th>
<td><?php echo $row['ResponsiblePartySec']; ?></td>
</tr>
<tr>
<th>New Responsible Party (Secondary)</th>
<td>
<form method="post" action="editdetails.php" enctype="multipart/form-data" id="editform">
<?php users_dropdown(ResponsiblePartySec,Secondary); ?>
<input type="text" value="<?php echo $row['ContractID']; ?>" name="id" class="hid" hidden>
<input type="text" value="8" name="field" class="hid" hidden>
</td>
</tr>
<tr>
<!-- <td class="updatebutton"><input type="submit" value="Update"></td> -->
<td class="updatebutton"><input type="image" src="img/Update.png" value="Submit"  onMouseOver="this.src='img/UpdateHO.png'" onMouseOut="this.src='img/Update.png'"/></td>
</form>
</tr>
<?php
}

if ($field == 9) {  //ResponsiblePartyTer
?>
<div class="topbar" id="editheader">
<div id="backform">
	<form action="editdetails.php" method="post" enctype="multipart/form-data">
	<input type="text" value="<?php echo $id; ?>" name="backid" class="hid" hidden>
	<input type="image" src="img/Back.png" name="backbutton" value="Back" onMouseOver="this.src='img/BackHO.png'" onMouseOut="this.src='img/Back.png'"/>
	</form>
	</div>
	<h1>edit responsible party - tertiary</h1>
	</div>
<table class="edits">

<tr>
<th>Old Responsible Party (Tertiary)</th>
<td><?php echo $row['ResponsiblePartyTer']; ?></td>
</tr>
<tr>
<th>New Responsible Party (Tertiary)</th>
<td>
<form method="post" action="editdetails.php" enctype="multipart/form-data" id="editform">
<?php users_dropdown(ResponsiblePartyTer,Tertiary); ?>
<input type="text" value="<?php echo $row['ContractID']; ?>" name="id" class="hid" hidden>
<input type="text" value="9" name="field" class="hid" hidden>
</td>
</tr>
<tr>
<!-- <td class="updatebutton"><input type="submit" value="Update"></td> -->
<td class="updatebutton"><input type="image" src="img/Update.png" value="Submit"  onMouseOver="this.src='img/UpdateHO.png'" onMouseOut="this.src='img/Update.png'"/></td>
</form>
</tr>
<?php
}

if ($field == 10) {  //EffectiveDate
?>
<div class="topbar" id="editheader">
<div id="backform">
	<form action="editdetails.php" method="post" enctype="multipart/form-data">
	<input type="text" value="<?php echo $id; ?>" name="backid" class="hid" hidden>
	<input type="image" src="img/Back.png" name="backbutton" value="Back" onMouseOver="this.src='img/BackHO.png'" onMouseOut="this.src='img/Back.png'"/>
	</form>
	</div>
	<h1>edit effective date</h1>
	</div>
<table class="edits">

<tr>
<th>Old Effective Date</th>
<td><?php echo $row['EffectiveDate']; ?></td>
</tr>
<tr>
<th>New Effective Date</th>
<td>
<form method="post" action="editdetails.php" enctype="multipart/form-data" id="editform">
<input type="text" name="EffectiveDate" placeholder="Effective Date..." class="datepicker" required>
<input type="text" value="<?php echo $row['ContractID']; ?>" name="id" class="hid" hidden>
<input type="text" value="10" name="field" class="hid" hidden>
</td>
</tr>
<tr>
<!-- <td class="updatebutton"><input type="submit" value="Update"></td> -->
<td class="updatebutton"><input type="image" src="img/Update.png" value="Submit"  onMouseOver="this.src='img/UpdateHO.png'" onMouseOut="this.src='img/Update.png'"/></td>
</form>
</tr>
<?php
}

if ($field == 11) {  //ExpirationDate
?>
<div class="topbar" id="editheader">
<div id="backform">
	<form action="editdetails.php" method="post" enctype="multipart/form-data">
	<input type="text" value="<?php echo $id; ?>" name="backid" class="hid" hidden>
	<input type="image" src="img/Back.png" name="backbutton" value="Back" onMouseOver="this.src='img/BackHO.png'" onMouseOut="this.src='img/Back.png'"/>
	</form>
	</div>
	<h1>edit expiration date</h1>
	</div>
<table class="edits">

<tr>
<th>Old Expiration Date</th>
<td><?php echo $row['ExpirationDate']; ?></td>
</tr>
<tr>
<th>New Expiration Date</th>
<td>
<form method="post" action="editdetails.php" enctype="multipart/form-data" id="editform">
<input type="text" name="ExpirationDate" placeholder="Expiration Date..." class="datepicker" required>
<input type="text" value="<?php echo $row['ContractID']; ?>" name="id" class="hid" hidden>
<input type="text" value="11" name="field" class="hid" hidden>
</td>
</tr>
<tr>
<!-- <td class="updatebutton"><input type="submit" value="Update"></td> -->
<td class="updatebutton"><input type="image" src="img/Update.png" value="Submit"  onMouseOver="this.src='img/UpdateHO.png'" onMouseOut="this.src='img/Update.png'"/></td>
</form>
</tr>
<?php
}

if ($field == 12) {  //ContractStatus
?>
<div class="topbar" id="editheader">
<div id="backform">
	<form action="editdetails.php" method="post" enctype="multipart/form-data">
	<input type="text" value="<?php echo $id; ?>" name="backid" class="hid" hidden>
	<input type="image" src="img/Back.png" name="backbutton" value="Back" onMouseOver="this.src='img/BackHO.png'" onMouseOut="this.src='img/Back.png'"/>
	</form>
	</div>
	<h1>edit contract status</h1>
	</div>
<table class="edits">

<tr>
<th>Old Contract Status</th>
<td><?php echo $row['ContractStatus']; ?></td>
</tr>
<tr>
<th>New Contract Status</th>
<td>
<form method="post" action="editdetails.php" enctype="multipart/form-data" id="editform">
<select name="ContractStatus" required>																											<!-- ContractStatus Dropdown -->
		<option value="">(Contract Status...)</option>								
		<option value="Active">Active</option>								
		<option value="Expired">Expired</option>								
		<option value="Inactive">Inactive</option>								
</select>
<input type="text" value="<?php echo $row['ContractID']; ?>" name="id" class="hid" hidden>
<input type="text" value="12" name="field" class="hid" hidden>
</td>
</tr>
<tr>
<!-- <td class="updatebutton"><input type="submit" value="Update"></td> -->
<td class="updatebutton"><input type="image" src="img/Update.png" value="Submit"  onMouseOver="this.src='img/UpdateHO.png'" onMouseOut="this.src='img/Update.png'"/></td>
</form>
</tr>
<?php
}

if ($field == 13) {  //AutoRenewal
?>
<div class="topbar" id="editheader">
<div id="backform">
	<form action="editdetails.php" method="post" enctype="multipart/form-data">
	<input type="text" value="<?php echo $id; ?>" name="backid" class="hid" hidden>
	<input type="image" src="img/Back.png" name="backbutton" value="Back" onMouseOver="this.src='img/BackHO.png'" onMouseOut="this.src='img/Back.png'"/>
	</form>
	</div>
	<h1>edit auto renewal</h1>
	</div>
<table class="edits">

<tr>
<th>Old Auto Renewal</th>
<td><?php echo $row['AutoRenewal']; ?></td>
</tr>
<tr>
<th>New AutoRenewal</th>
<td>
<form method="post" action="editdetails.php" enctype="multipart/form-data" id="editform">
<select name="AutoRenewal" required> 																											<!-- AutoRenewal Dropdown -->
		<option value="">(Auto Renewal...)</option>								
		<option value="Y">Yes</option>								
		<option value="N">No</option>								
</select>
<input type="text" value="<?php echo $row['ContractID']; ?>" name="id" class="hid" hidden>
<input type="text" value="13" name="field" class="hid" hidden>
</td>
</tr>
<tr>
<!-- <td class="updatebutton"><input type="submit" value="Update"></td> -->
<td class="updatebutton"><input type="image" src="img/Update.png" value="Submit"  onMouseOver="this.src='img/UpdateHO.png'" onMouseOut="this.src='img/Update.png'"/></td>
</form>
</tr>
<?php
}

if ($field == 14) {  //AutoRenewalTerms
?>
<div class="topbar" id="editheader">
<div id="backform">
	<form action="editdetails.php" method="post" enctype="multipart/form-data">
	<input type="text" value="<?php echo $id; ?>" name="backid" class="hid" hidden>
	<input type="image" src="img/Back.png" name="backbutton" value="Back" onMouseOver="this.src='img/BackHO.png'" onMouseOut="this.src='img/Back.png'"/>
	</form>
	</div>
	<h1>edit auto renewal terms</h1>
	</div>
<table class="edits">

<tr>
<th>Old Auto Renewal Terms</th>
<td><?php echo $row['AutoRenewalTerms']; ?></td>
</tr>
<tr>
<th>New Auto Renewal Terms</th>
<td>
<form method="post" action="editdetails.php" enctype="multipart/form-data" id="editform">
<select name="AutoRenewalTerms">																												<!-- AutoRenewalTerms Dropdown -->
		<option value="">(Auto Renewal Term - Months...)</option>
		<?php for ($i = 1; $i <= 12; $i++) { ?>
		<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
		<?php } ?>
</select>
<input type="text" value="<?php echo $row['ContractID']; ?>" name="id" class="hid" hidden>
<input type="text" value="14" name="field" class="hid" hidden>
</td>
</tr>
<tr>
<!-- <td class="updatebutton"><input type="submit" value="Update"></td> -->
<td class="updatebutton"><input type="image" src="img/Update.png" value="Submit"  onMouseOver="this.src='img/UpdateHO.png'" onMouseOut="this.src='img/Update.png'"/></td>
</form>
</tr>
<?php
}

if ($field == 15) {  //AutoRenewalTimes
?>
<div class="topbar" id="editheader">
<div id="backform">
	<form action="editdetails.php" method="post" enctype="multipart/form-data">
	<input type="text" value="<?php echo $id; ?>" name="backid" class="hid" hidden>
	<input type="image" src="img/Back.png" name="backbutton" value="Back" onMouseOver="this.src='img/BackHO.png'" onMouseOut="this.src='img/Back.png'"/>
	</form>
	</div>
	<h1>edit auto renewal times</h1>
	</div>
<table class="edits">

<tr>
<th>Old Auto Renewal Times</th>
<td><?php echo $row['AutoRenewalTimes']; ?></td>
</tr>
<tr>
<th>New Auto Renewal Times</th>
<td>
<form method="post" action="editdetails.php" enctype="multipart/form-data" id="editform">
<select name="AutoRenewalTimes">																												<!-- AutoRenewalTimes Dropdown -->
		<option value="">(Auto Renewal Times...)</option>
		<?php for ($i = 1; $i <= 99; $i++) { ?>
		<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
		<?php } ?>
</select>
<input type="text" value="<?php echo $row['ContractID']; ?>" name="id" class="hid" hidden>
<input type="text" value="15" name="field" class="hid" hidden>
</td>
</tr>
<tr>
<!-- <td class="updatebutton"><input type="submit" value="Update"></td> -->
<td class="updatebutton"><input type="image" src="img/Update.png" value="Submit"  onMouseOver="this.src='img/UpdateHO.png'" onMouseOut="this.src='img/Update.png'"/></td>
</form>
</tr>
<?php
}

if ($field == 16) {  //AdditionalReviewer1
?>
<div class="topbar" id="editheader">
<div id="backform">
	<form action="editdetails.php" method="post" enctype="multipart/form-data">
	<input type="text" value="<?php echo $id; ?>" name="backid" class="hid" hidden>
	<input type="image" src="img/Back.png" name="backbutton" value="Back" onMouseOver="this.src='img/BackHO.png'" onMouseOut="this.src='img/Back.png'"/>
	</form>
	</div>
	<h1>edit additional reviewer - 1</h1>
	</div>
<table class="edits">

<tr>
<th>Old Additional Reviewer - 1</th>
<td><?php echo $row['AdditionalReviewer1']; ?></td>
</tr>
<tr>
<th>New Additional Reviewer - 1</th>
<td>
<form method="post" action="editdetails.php" enctype="multipart/form-data" id="editform">
<?php add_review_users(AdditionalReviewer1); ?>
<input type="text" value="<?php echo $row['ContractID']; ?>" name="id" class="hid" hidden>
<input type="text" value="16" name="field" class="hid" hidden>
</td>
</tr>
<tr>
<!-- <td class="updatebutton"><input type="submit" value="Update"></td> -->
<td class="updatebutton"><input type="image" src="img/Update.png" value="Submit"  onMouseOver="this.src='img/UpdateHO.png'" onMouseOut="this.src='img/Update.png'"/></td>
</form>
</tr>
<?php
}

if ($field == 17) {  //AdditionalReviewer2
?>
<div class="topbar" id="editheader">
<div id="backform">
	<form action="editdetails.php" method="post" enctype="multipart/form-data">
	<input type="text" value="<?php echo $id; ?>" name="backid" class="hid" hidden>
	<input type="image" src="img/Back.png" name="backbutton" value="Back" onMouseOver="this.src='img/BackHO.png'" onMouseOut="this.src='img/Back.png'"/>
	</form>
	</div>
	<h1>edit additional reviewer - 2</h1>
	</div>
<table class="edits">

<tr>
<th>Old Additional Reviewer - 2</th>
<td><?php echo $row['AdditionalReviewer2']; ?></td>
</tr>
<tr>
<th>New Additional Reviewer - 2</th>
<td>
<form method="post" action="editdetails.php" enctype="multipart/form-data" id="editform">
<?php add_review_users(AdditionalReviewer2); ?>
<input type="text" value="<?php echo $row['ContractID']; ?>" name="id" class="hid" hidden>
<input type="text" value="17" name="field" class="hid" hidden>
</td>
</tr>
<tr>
<!-- <td class="updatebutton"><input type="submit" value="Update"></td> -->
<td class="updatebutton"><input type="image" src="img/Update.png" value="Submit"  onMouseOver="this.src='img/UpdateHO.png'" onMouseOut="this.src='img/Update.png'"/></td>
</form>
</tr>
<?php
}

if ($field == 18) {  //AutoRenewalDeadline
?>
<div class="topbar" id="editheader">
<div id="backform">
	<form action="editdetails.php" method="post" enctype="multipart/form-data">
	<input type="text" value="<?php echo $id; ?>" name="backid" class="hid" hidden>
	<input type="image" src="img/Back.png" name="backbutton" value="Back" onMouseOver="this.src='img/BackHO.png'" onMouseOut="this.src='img/Back.png'"/>
	</form>
	</div>
	<h1>edit auto renewal deadline</h1>
	</div>
<table class="edits">

<tr>
<th>Old Auto Renewal Deadline</th>
<td><?php echo $row['AutoRenewalDeadline']->format('Y-m-d'); ?></td>
</tr>
<tr>
<th>New Auto Renewal Deadline</th>
<td>
<form method="post" action="editdetails.php" enctype="multipart/form-data" id="editform">
<input type="text" name="AutoRenewalDeadline" placeholder="Auto Renewal Deadline..." class="datepicker" required>
<input type="text" value="<?php echo $row['ContractID']; ?>" name="id" class="hid" hidden>
<input type="text" value="18" name="field" class="hid" hidden>
</td>
</tr>
<tr>
<!-- <td class="updatebutton"><input type="submit" value="Update"></td> -->
<td class="updatebutton"><input type="image" src="img/Update.png" value="Submit"  onMouseOver="this.src='img/UpdateHO.png'" onMouseOut="this.src='img/Update.png'"/></td>
</form>
</tr>
<?php
}

if ($field == 19) {  //EOC
?>
<div class="topbar" id="editheader">
<div id="backform">
	<form action="editdetails.php" method="post" enctype="multipart/form-data">
	<input type="text" value="<?php echo $id; ?>" name="backid" class="hid" hidden>
	<input type="image" src="img/Back.png" name="backbutton" value="Back" onMouseOver="this.src='img/BackHO.png'" onMouseOut="this.src='img/Back.png'"/>
	</form>
	</div>
	<h1>edit eoc</h1>
	</div>
<table class="edits">

<tr>
<th>Old EOC</th>
<td><?php echo $row['EOC']; ?></td>
</tr>
<tr>
<th>New EOC</th>
<td>
<form method="post" action="editdetails.php" enctype="multipart/form-data" id="editform">
<input title='Enter an EOC' type="text" name="EOC" placeholder="EOC" maxlength="8" required />
<input type="text" value="<?php echo $row['ContractID']; ?>" name="id" class="hid" hidden>
<input type="text" value="19" name="field" class="hid" hidden>
</td>
</tr>
<tr>
<!-- <td class="updatebutton"><input type="submit" value="Update"></td> -->
<td class="updatebutton"><input type="image" src="img/Update.png" value="Submit"  onMouseOver="this.src='img/UpdateHO.png'" onMouseOut="this.src='img/Update.png'"/></td>
</form>
</tr>
<?php
}
?>

</table>
<?php
page_footer();
?>