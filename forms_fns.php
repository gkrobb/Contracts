<?php
 
 function vend_dept_search() {
	global $user,$superusers;
	$conn = db_conn();
	$sql = "SELECT DISTINCT 
				cd.Vendor 
			FROM ContractData AS cd
			LEFT JOIN ContractUsers AS cu1 ON cd.ResponsiblePartyPri=cu1.Name
			LEFT JOIN ContractUsers AS cu2 ON cd.ResponsiblePartySec=cu2.Name
			LEFT JOIN ContractUsers AS cu3 ON cd.ResponsiblePartyTer=cu3.Name
			LEFT JOIN ContractUsers AS cu4 ON cd.AdditionalReviewer1=cu4.Name
			LEFT JOIN ContractUsers AS cu5 ON cd.AdditionalReviewer2=cu5.Name
			WHERE ((cu1.ClaxtonUsername = '".$user."') OR (cu2.ClaxtonUsername = '".$user."') OR (cu3.ClaxtonUsername = '".$user."') OR (cu4.ClaxtonUsername = '".$user."') OR (cu5.ClaxtonUsername = '".$user."')
			OR ('".$user."' IN (SELECT ClaxtonUsername FROM ContractUsers WHERE Superuser = 'Y')))
			AND cd.ContractStatus = 'Active'";
	$result = sqlsrv_query($conn, $sql);
		
	$opt = "<select name='Vendor' required><option value=''/>(Vendor...)</option>";
	while($row = sqlsrv_fetch_array($result,SQLSRV_FETCH_ASSOC)) {
	$opt .= "<option value='".$row['Vendor']."'>".$row['Vendor']."</option>";
	}
	$opt .= "</select>";
?>	 
<!--
	<div class="topbar" id="vendorsearch">
	<h1>vendor search</h1>
	</div>
-->
	<form method="post" action="results.php" enctype="multipart/form-data" id="vendform">
	<table class="search">
	<tbody>
	<tr>
		<td class="searchtitle"><strong>Vendor:</strong></td>
		<td><?php echo $opt ?></td>
	</tr>
	
	</tbody>
	</table>
	<div class="searchbutton"><input type="image" value="Submit" src="img/submitbtn.png" onMouseOver="this.src='img/submitbtnHO.png'" onMouseOut="this.src='img/submitbtn.png'"/></div>
	</form>
	
	
<?php
 }
  function department_dropdown() {
	
	$conn = db_conn();
	$sql = "SELECT DepartmentNumber,DepartmentName FROM ContractDepartments ORDER BY DepartmentNumber";
	
	$result = sqlsrv_query($conn, $sql);
		
	$opt2 = "<select name='Department' required><option value=''>(Department...)</option>";
	while($row = sqlsrv_fetch_array($result,SQLSRV_FETCH_ASSOC)) {
	$opt2 .= "<option value='".$row['DepartmentName']."'>".$row['DepartmentNumber']." - ".$row['DepartmentName']."</option>";
	}
	$opt2 .= "</select>";
	
	echo $opt2;
 }
 
 function department_search() {
	global $user,$superusers;
	$conn = db_conn();
	$sql = "SELECT DISTINCT 
				cd.Department 
			FROM ContractData AS cd
			LEFT JOIN ContractUsers AS cu1 ON cd.ResponsiblePartyPri=cu1.Name
			LEFT JOIN ContractUsers AS cu2 ON cd.ResponsiblePartySec=cu2.Name
			LEFT JOIN ContractUsers AS cu3 ON cd.ResponsiblePartyTer=cu3.Name
			LEFT JOIN ContractUsers AS cu4 ON cd.AdditionalReviewer1=cu4.Name
			LEFT JOIN ContractUsers AS cu5 ON cd.AdditionalReviewer2=cu5.Name
			WHERE ((cu1.ClaxtonUsername = '".$user."') OR (cu2.ClaxtonUsername = '".$user."') OR (cu3.ClaxtonUsername = '".$user."') OR (cu4.ClaxtonUsername = '".$user."') OR (cu5.ClaxtonUsername = '".$user."')
			OR ('".$user."' IN (SELECT ClaxtonUsername FROM ContractUsers WHERE Superuser = 'Y')))
			AND cd.ContractStatus = 'Active'";
			
	
	$result = sqlsrv_query($conn, $sql);
		
	$opt2 = "<select name='Department' required><option value=''/>(Department...)</option>";
	while($row = sqlsrv_fetch_array($result,SQLSRV_FETCH_ASSOC)) {
	$opt2 .= "<option value='".$row['Department']."'>".$row['Department']."</option>";
	}
	$opt2 .= "</select>";
	
?>
<!--
	<div class="topbar" id="deptsearch">
	<h1>department search</h1>
	</div>
-->	
<form method="post" action="results.php" enctype="multipart/form-data" id="deptform">
	<table class="search">
	<tbody>
	<tr>
		<td class="searchtitle"><strong>Department:</strong></td>
		<td><?php echo $opt2 ?></td>
	</tr>
	</tbody>
	</table>
	<div class="searchbutton"><input type="image" value="Submit" src="img/submitbtn.png" onMouseOver="this.src='img/submitbtnHO.png'" onMouseOut="this.src='img/submitbtn.png'"/></div>
	</form>
<?php
 }
 
 function users_dropdown($name,$order) {
	
	if($order == 'Primary' ||$order == 'Secondary'){$req = 'required';}else{$req = '';}
	$conn = db_conn();
	$sql = "SELECT Name FROM ContractUsers WHERE ResponsiblePartyList = 'Y' ORDER BY Name";
	
	$result = sqlsrv_query($conn, $sql);
		
	$opt = "<select name='".$name."' ".$req."><option value=''>(Responsible Party - '".$order."'...)</option>";
	while($row = sqlsrv_fetch_array($result,SQLSRV_FETCH_ASSOC)) {
	$opt .= "<option value='".$row['Name']."'>".$row['Name']."</option>";
	}
	$opt .= "</select>";
	
	echo $opt;
 }
 
 function add_review_users($name) {
	$conn = db_conn();
	$sql = "SELECT Name FROM ContractUsers WHERE ResponsiblePartyList = 'Y' ORDER BY Name";
	
	$result = sqlsrv_query($conn, $sql);
		
	$opt = "<select name='".$name."'><option value=''>(Additional Reviewer...)</option>";
	while($row = sqlsrv_fetch_array($result,SQLSRV_FETCH_ASSOC)) {
	$opt .= "<option value='".$row['Name']."'>".$row['Name']."</option>";
	}
	$opt .= "</select>";
	
	echo $opt;
	 
 }
 
 function result_view(){
?>
	 <div id="results">
	 <form method="post" action="results.php" enctype="multipart/form-data">
	 <table class="resultstable">
	 <tr>
	 <th>Contract ID</th>
	 <th>Vendor</th>
	 <th>Contract Description</th>
	 <th>Department</th>
	 <th>Expiration Date</th>
	 <th></th>
	 </tr>
	 <tr>
	 
	 </table>
	 </form>
	 </div>
	 
<?php
 }
 
function new_contract_table_form() {
?>

<div class="topbar" id="addnew"><h1>+ new contract</h1></div>
<form method="post" action="fulldisplay.php" enctype="multipart/form-data" id="inputform">
<input type="text" name="new" value="1" class="hid" hidden />
<table id="inputtable">
<tr>
	<td><strong>Contracting Entity:</strong></td>
	<td>
	<select title='Please select the Contracting Entity' name="ContractingEntity" required>															<!-- ContractingEntity Dropdown -->
		<option value="">(Contracting Entity...)</option>							
		<option value="Claxton-Hepburn">Claxton-Hepburn</option>							
		<option value="Claxton Medical PC">Claxton Medical PC</option>							
	</select>
	<span class="required">* required</span>
	</td>
	
</tr>
<tr>
	<td><strong>Vendor:</strong></td>
	<td>
	<input title='Enter a Vendor Name' type="text" name="Vendor" placeholder="(Vendor Name...)" required />
	<span class="required">* required</span>
	</td>
</tr>
<tr>
	<td><strong>Contract Type:</strong></td>
	<td>
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
	</select>
	<span class="required">* required</span>
	</td>
</tr>

<tr>
	<td><strong>Contract Title</strong></td>
	<td>
	<input title='Enter a Title for the Contract' type="text" name="ContractTitle" placeholder="(Contract Title...)" required />
	<span class="required">* required</span>
	</td>
</tr>

<tr>
	<td><strong>Contract Description:</strong></td>
	<td>
	<textarea name="ContractDescription" rows="3" cols="60" placeholder="(Contract Description...)"></textarea>
	</td>
</tr>
<tr>
	<td><strong>Department:</strong></td>
	<td>
	<?php department_dropdown(); ?>
	<span class="required">* required</span>
	</td>
</tr>
<tr>
	<td><strong>EOC (Expense Object Code)</strong></td>
	<td><input type="text" title="Enter an EOC" name="EOC" placeholder="(EOC...)" maxlength="8"></td>
</tr>
<tr>
	<td><strong>Responsible Party - Primary</strong></td>
	<td>
	<?php users_dropdown(ResponsiblePartyPri,Primary); ?>
	<span class="required">* required</span>
	</td>
</tr>
<tr>
	<td><strong>Responsible Party - Secondary</strong></td>
	<td>
	<?php users_dropdown(ResponsiblePartySec,Secondary); ?>
	<span class="required">* required</span>
	</td>
</tr>
<tr>
	<td><strong>Responsible Party - Tertiary</strong></td>
	<td>
	<?php users_dropdown(ResponsiblePartyTer,Tertiary); ?>
	</td>
</tr>

<tr>
	<td><strong>Additional Reviewer</strong></td>
	<td>
	<?php add_review_users(AdditionalReviewer1); ?>
	</td>
</tr>
<tr>
	<td><strong>Additional Reviewer</strong></td>
	<td>
	<?php add_review_users(AdditionalReviewer2); ?>
	</td>
</tr>

<tr>
	<td><strong>Effective Date:</strong></td>
	<td>
	<input type="text" name="EffectiveDate" placeholder="(Effective Date...)" class="datepicker" required>
	<span class="required">* required</span>
	</td>
</tr>
<tr>
	<td><strong>Expiration Date:</strong></td>
	<td>
	<input type="text" name="ExpirationDate" placeholder="(Expiration Date...)" class="datepicker" required>
	<span class="required">* required</span>
	</td>
</tr>
<tr>
	<td><strong>Annual Cost - Year 1:</strong></td>
	<td>
	<input type="text" name="AnnualCost1" placeholder="(Annual Cost - Year 1...)" />
	</td>
</tr>
<tr>
	<td><strong>Annual Cost - Year 2:</strong></td>
	<td>
	<input type="text" name="AnnualCost2" placeholder="(Annual Cost - Year 2...)" />
	</td>
</tr>
<tr>
	<td><strong>Annual Cost - Year 3:</strong></td>
	<td>
	<input type="text" name="AnnualCost3" placeholder="(Annual Cost - Year 3...)" />
	</td>
</tr>
<tr>
	<td><strong>Contract Status:</strong></td>
	<td>
	<select name="ContractStatus" required>																											<!-- ContractStatus Dropdown -->
		<option value="">(Contract Status...)</option>								
		<option value="Active">Active</option>								
		<option value="Expired">Expired</option>								
		<option value="Archived">Archived</option>								
	</select>
	<span class="required">* required</span>
	</td>
</tr>
<tr>
	<td><strong>Auto Renewal:</strong></td>
	<td>
	<select name="AutoRenewal" required> 																											<!-- AutoRenewal Dropdown -->
		<option value="">(Auto Renewal...)</option>								
		<option value="Y">Yes</option>								
		<option value="N">No</option>								
	</select>
	<span class="required">* required</span>
	</td>
</tr>
<tr>
	<td><strong>Auto Renewal Terms (Months):</strong></td>
	<td>
	<select name="AutoRenewalTerms">																												<!-- AutoRenewalTerms Dropdown -->
		<option value="">(Auto Renewal Term - Months...)</option>
		<?php for ($i = 1; $i <= 12; $i++) { ?>
		<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
		<?php } ?>
	</select>
	</td>
</tr>
<tr>
	<td><strong>Auto Renewal Times:</strong></td>
	<td>
	<select name="AutoRenewalTimes">																												<!-- AutoRenewalTimes Dropdown -->
		<option value="">(Auto Renewal Times...)</option>
		<?php for ($i = 1; $i <= 99; $i++) { ?>
		<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
		<?php } ?>
	</select>
	</td>
</tr>

<tr>
	<td><strong>Auto Renewal Deadline:</strong></td>
	<td>
	<input type="text" name="AutoRenewalDeadline" placeholder="(Auto Renewal Deadline...)" class="datepicker">
	</td>
</tr>

<tr>
	<td><strong>Select a Contract to upload:</strong></td>
	<td>
	<input type="file" name="cmsfile[]" />
	</td>
</tr>
<tr>
	<td><strong>Select a BAA to upload:</strong></td>
	<td>
	<input type="file" name="cmsfile[]" />
	</td>
</tr>
<tr>
	<td><strong>Select a COI to upload:</strong></td>
	<td>
	<input type="file" name="cmsfile[]" />
	</td>
</tr>
<tr>
	<td><strong>Service Evaluation Period:</strong></td>
	<td>
	<select name="ServiceEvaluationPeriod" required>																								<!-- ServiceEvaluationPeriod dropdown -->
		<option value="">(Service Evaluation Frequency...)</option>
		<option value="Annual">Annually (non-clinical)</option>
		<option value="Biannual">Bi-Annual (clinical)</option>
	</select>
	<span class="required">* required</span>
	</td>
</tr>
<tr>
	<td><strong>Select a Service Evaluation to upload:</strong></td>
	<td>
	<input type="file" name="cmsfile[]" />
	</td>
</tr>
<tr>
	<td><strong>Select a Addendum to upload:</strong></td>
	<td>
	<input type="file" name="cmsfile[]" />
	</td>
</tr>
<tr>
	<td><strong>Select a Memorandum of Understanding to upload:</strong></td>
	<td>
	<input type="file" name="cmsfile[]" />
	</td>
</tr>
<tr>
	<td><strong>Select a Purchase Order to upload:</strong></td>
	<td>
	<input type="file" name="cmsfile[]" />
	</td>
</tr>

</table>
<div class="inputsubmit"><input type="image" src="img/submitbtn.png" value="Submit"  onMouseOver="this.src='img/submitbtnHO.png'" onMouseOut="this.src='img/submitbtn.png'"/></div>
</form>

<?php
}

function full_edit_form() {
	global 	$id,$ContractingEntity,$Vendor,$ContractType,$ContractTitle,$ContractDescription,$Department,$EOC
			,$ResponsiblePartyPri,$ResponsiblePartySec,$ResponsiblePartyTer,$AdditionalReviewer1,$AdditionalReviewer2,$EffectiveDate
			,$ExpirationDate,$ContractStatus,$AutoRenewal,$AutoRenewalTerms,$AutoRenewalTimes,$AutoRenewalDeadline,$ServiceEvaluationPeriod;
?>
<div class="topbar" id="conedit">
	<div id="backform">
	<form action="fulldisplay.php" method="post" enctype="multipart/form-data">
	<input type="text" value="<?php echo $id; ?>" name="backid" class="hid" hidden>
	<input type="image" src="img/Back.png" name="backbutton" value="Back" onMouseOver="this.src='img/BackHO.png'" onMouseOut="this.src='img/Back.png'"/>
	</form>
	</div>
	<h1>edit contract details</h1>
</div>

<table class="fulledit" cellspacing="10">
<tr>
<td>
<form method="post" action="edit.php" enctype="multipart/form-data">
<input type="text" value="<?php echo $id; ?>" name="id" class="hid" hidden>
<input type="text" value="1" name="field" class="hid" hidden>
<input type="image" src='img/PencilTrans.png' alt="Edit Contracting Entity" onMouseOver="this.src='img/PencilTransHO.png'" onMouseOut="this.src='img/PencilTrans.png'">
</form>
</td>
<td style="width:25%"><strong>Contracting Entity:</strong></td>
<td class="detail"  style="width:66%"><?php echo $ContractingEntity; ?></td>

</tr>

<tr>
<td>
<form method="post" action="edit.php" enctype="multipart/form-data">
<input type="text" value="<?php echo $id; ?>" name="id" class="hid" hidden>
<input type="text" value="2" name="field" class="hid" hidden>
<input type="image" src='img/PencilTrans.png' alt="Edit Vendor" onMouseOver="this.src='img/PencilTransHO.png'" onMouseOut="this.src='img/PencilTrans.png'">
</form>
</td>
<td><strong>Vendor:</strong></td>
<td class="detail"><?php echo $Vendor; ?></td>

</tr>

<tr>
<td>
<form method="post" action="edit.php" enctype="multipart/form-data">
<input type="text" value="<?php echo $id; ?>" name="id" class="hid" hidden>
<input type="text" value="3" name="field" class="hid" hidden>
<input type="image" src='img/PencilTrans.png' alt="Edit Contract Type" onMouseOver="this.src='img/PencilTransHO.png'" onMouseOut="this.src='img/PencilTrans.png'">
</form>
</td>
<td><strong>Contract Type:</strong></td>
<td class="detail"><?php echo $ContractType; ?></td>

</tr>

<tr>
<td>
<form method="post" action="edit.php" enctype="multipart/form-data">
<input type="text" value="<?php echo $id; ?>" name="id" class="hid" hidden>
<input type="text" value="4" name="field" class="hid" hidden>
<input type="image" src='img/PencilTrans.png' alt="Edit Contract Title" onMouseOver="this.src='img/PencilTransHO.png'" onMouseOut="this.src='img/PencilTrans.png'">
</form>
</td>
<td><strong>Contract Title:</strong></td>
<td class="detail"><?php echo $ContractTitle; ?></td>

</tr>

<tr>
<td>
<form method="post" action="edit.php" enctype="multipart/form-data">
<input type="text" value="<?php echo $id; ?>" name="id" class="hid" hidden>
<input type="text" value="5" name="field" class="hid" hidden>
<input type="image" src='img/PencilTrans.png' alt="Edit Contract Description" onMouseOver="this.src='img/PencilTransHO.png'" onMouseOut="this.src='img/PencilTrans.png'">
</form>
</td>
<td><strong>Contract Description:</strong></td>
<td class="detail"><?php echo $ContractDescription; ?></td>

</tr>

<tr>
<td>
<form method="post" action="edit.php" enctype="multipart/form-data">
<input type="text" value="<?php echo $id; ?>" name="id" class="hid" hidden>
<input type="text" value="6" name="field" class="hid" hidden>
<input type="image" src='img/PencilTrans.png' alt="Edit Department" onMouseOver="this.src='img/PencilTransHO.png'" onMouseOut="this.src='img/PencilTrans.png'">
</form>
</td>
<td><strong>Department:</strong></td>
<td class="detail"><?php echo $Department; ?></td>

</tr>

<tr>
<td>
<form method="post" action="edit.php" enctype="multipart/form-data">
<input type="text" value="<?php echo $id; ?>" name="id" class="hid" hidden>
<input type="text" value="19" name="field" class="hid" hidden>
<input type="image" src='img/PencilTrans.png' alt="Edit Department" onMouseOver="this.src='img/PencilTransHO.png'" onMouseOut="this.src='img/PencilTrans.png'">
</form>
</td>
<td><strong>EOC:</strong></td>
<td class="detail"><?php echo $EOC; ?></td>

</tr>

<tr>
<td>
<form method="post" action="edit.php" enctype="multipart/form-data">
<input type="text" value="<?php echo $id; ?>" name="id" class="hid" hidden>
<input type="text" value="7" name="field" class="hid" hidden>
<input type="image" src='img/PencilTrans.png' alt="Edit Responsible Party (Primary)" onMouseOver="this.src='img/PencilTransHO.png'" onMouseOut="this.src='img/PencilTrans.png'">
</form>
</td>
<td><strong>Responsible Party (Primary):</strong></td>
<td class="detail"><?php echo $ResponsiblePartyPri; ?></td>

</tr>

<tr>
<td>
<form method="post" action="edit.php" enctype="multipart/form-data">
<input type="text" value="<?php echo $id; ?>" name="id" class="hid" hidden>
<input type="text" value="8" name="field" class="hid" hidden>
<input type="image" src='img/PencilTrans.png' alt="Edit Responsible Party (Secondary)" onMouseOver="this.src='img/PencilTransHO.png'" onMouseOut="this.src='img/PencilTrans.png'">
</form>
</td>
<td><strong>Responsible Party (Secondary):</strong></td>
<td class="detail"><?php echo $ResponsiblePartySec; ?></td>

</tr>

<tr>
<td>
<form method="post" action="edit.php" enctype="multipart/form-data">
<input type="text" value="<?php echo $id; ?>" name="id" class="hid" hidden>
<input type="text" value="9" name="field" class="hid" hidden>
<input type="image" src='img/PencilTrans.png' alt="Edit Responsible Party (Tertiary)" onMouseOver="this.src='img/PencilTransHO.png'" onMouseOut="this.src='img/PencilTrans.png'">
</form>
</td>
<td><strong>Responsible Party (Tertiary):</strong></td>
<td class="detail"><?php echo $ResponsiblePartyTer; ?></td>

</tr>

<tr>
<td>
<form method="post" action="edit.php" enctype="multipart/form-data">
<input type="text" value="<?php echo $id; ?>" name="id" class="hid" hidden>
<input type="text" value="16" name="field" class="hid" hidden>
<input type="image" src='img/PencilTrans.png' alt="Edit Additional Reviewer - 1" onMouseOver="this.src='img/PencilTransHO.png'" onMouseOut="this.src='img/PencilTrans.png'">
</form>
</td>
<td><strong>Additional Reviewer - 1:</strong></td>
<td class="detail"><?php echo $AdditionalReviewer1; ?></td>

</tr>

<tr>
<td>
<form method="post" action="edit.php" enctype="multipart/form-data">
<input type="text" value="<?php echo $id; ?>" name="id" class="hid" hidden>
<input type="text" value="17" name="field" class="hid" hidden>
<input type="image" src='img/PencilTrans.png' alt="Edit Additional Reviewer - 2" onMouseOver="this.src='img/PencilTransHO.png'" onMouseOut="this.src='img/PencilTrans.png'">
</form>
</td>
<td><strong>Additional Reviewer - 2:</strong></td>
<td class="detail"><?php echo $AdditionalReviewer2; ?></td>

</tr>

<tr>
<td>
<form method="post" action="edit.php" enctype="multipart/form-data">
<input type="text" value="<?php echo $id; ?>" name="id" class="hid" hidden>
<input type="text" value="10" name="field" class="hid" hidden>
<input type="image" src='img/PencilTrans.png' alt="Edit Effective Date" onMouseOver="this.src='img/PencilTransHO.png'" onMouseOut="this.src='img/PencilTrans.png'">
</form>
</td>
<td><strong>Effective Date:</strong></td>
<td class="detail"><?php echo $EffectiveDate; ?></td>

</tr>

<tr>
<td>
<form method="post" action="edit.php" enctype="multipart/form-data">
<input type="text" value="<?php echo $id; ?>" name="id" class="hid" hidden>
<input type="text" value="11" name="field" class="hid" hidden>
<input type="image" src='img/PencilTrans.png' alt="Edit Expiration Date" onMouseOver="this.src='img/PencilTransHO.png'" onMouseOut="this.src='img/PencilTrans.png'">
</form>
</td>
<td><strong>Expiration Date:</strong></td>
<td class="detail"><?php echo $ExpirationDate; ?></td>

</tr>

<tr>
<td>
<form method="post" action="edit.php" enctype="multipart/form-data">
<input type="text" value="<?php echo $id; ?>" name="id" class="hid" hidden>
<input type="text" value="12" name="field" class="hid" hidden>
<input type="image" src='img/PencilTrans.png' alt="Edit Contract Status" onMouseOver="this.src='img/PencilTransHO.png'" onMouseOut="this.src='img/PencilTrans.png'">
</form>
</td>
<td><strong>Contract Status:</strong></td>
<td class="detail"><?php echo $ContractStatus; ?></td>

</tr>

<tr>
<td>
<form method="post" action="edit.php" enctype="multipart/form-data">
<input type="text" value="<?php echo $id; ?>" name="id" class="hid" hidden>
<input type="text" value="13" name="field" class="hid" hidden>
<input type="image" src='img/PencilTrans.png' alt="Edit Auto Renewal" onMouseOver="this.src='img/PencilTransHO.png'" onMouseOut="this.src='img/PencilTrans.png'">
</form>
</td>
<td><strong>Auto Renewal:</strong></td>
<td class="detail"><?php echo $AutoRenewal; ?></td>

</tr>
<?php
	if ($AutoRenewal == 'N'){
		exit;
	}else {
?>

<tr>
<td>
<form method="post" action="edit.php" enctype="multipart/form-data">
<input type="text" value="<?php echo $id; ?>" name="id" class="hid" hidden>
<input type="text" value="14" name="field" class="hid" hidden>
<input type="image" src='img/PencilTrans.png' alt="Edit Auto Renewal Terms" onMouseOver="this.src='img/PencilTransHO.png'" onMouseOut="this.src='img/PencilTrans.png'">
</form>
</td>
<td><strong>Auto Renewal Terms (Months):</strong></td>
<td class="detail"><?php echo $AutoRenewalTerms; ?></td>

</tr>

<tr>
<td>
<form method="post" action="edit.php" enctype="multipart/form-data">
<input type="text" value="<?php echo $id; ?>" name="id" class="hid" hidden>
<input type="text" value="15" name="field" class="hid" hidden>
<input type="image" src='img/PencilTrans.png' alt="Edit Auto Renewal Times" onMouseOver="this.src='img/PencilTransHO.png'" onMouseOut="this.src='img/PencilTrans.png'">
</form>
</td>
<td><strong>Auto Renewal Times:</strong></td>
<td class="detail"><?php echo $AutoRenewalTimes; ?></td>

</tr>

<tr>
<td>
<form method="post" action="edit.php" enctype="multipart/form-data">
<input type="text" value="<?php echo $id; ?>" name="id" class="hid" hidden>
<input type="text" value="18" name="field" class="hid" hidden>
<input type="image" src='img/PencilTrans.png' alt="Edit Auto Renewal Deadline Date" onMouseOver="this.src='img/PencilTransHO.png'" onMouseOut="this.src='img/PencilTrans.png'">
</form>
</td>
<td><strong>Auto Renewal Deadline:</strong></td>
<td class="detail"><?php echo $AutoRenewalDeadline; ?></td>

</tr>
<?php
	}
?>

</table>   <!-- END OF FULL EDIT -->
<?php
}

function full_display() {
	
	global 	$totalcost,$id,$ContractingEntity,$Vendor,$ContractType,$ContractTitle,$ContractDescription,$Department,$EOC
			,$ResponsiblePartyPri,$ResponsiblePartySec,$ResponsiblePartyTer,$AdditionalReviewer1,$AdditionalReviewer2,$EffectiveDate
			,$ExpirationDate,$AnnualCost1,$AnnualCost2,$AnnualCost3,$AnnualCost4,$AnnualCost5,$AnnualCost6,$AnnualCost7
			,$AnnualCost8,$AnnualCost9,$AnnualCost10,$ContractStatus,$AutoRenewal,$AutoRenewalTerms,$AutoRenewalTimes,$AutoRenewalDeadline,$ServiceEvaluationPeriod
			,$ContractFileName,$conUploadDate,$BAAFileName,$baaUploadDate,$COIFileName,$coiUploadDate,$ServiceEvaluationFileName,$sevUploadDate
			,$AddendumFileName,$admUploadDate,$MemorandumOfUnderstandingFileName,$mouUploadDate
			,$PurchaseOrderFileName,$poUploadDate,$LastServiceEvaluationDate,$NextServiceEvaluationDate;

?>
	
<div class="displayview">

<div class="topbar" id="condetails">
	<div id="backform">
	<form action="editdetails.php" method="post" enctype="multipart/form-data">
	<input type="text" value="<?php echo $id; ?>" name="id" class="hid" hidden>
	<input type="image" src="img/BTNEdit.png" name="backbutton" value="Back" onMouseOver="this.src='img/BTNEditHO.png'" onMouseOut="this.src='img/BTNEdit.png'"/>
	</form>
	</div>
	<h1>contract details</h1>
</div>

<table class="full" cellspacing="10">
<tr>
<td class="left-title"><strong>Contracting Entity:</strong></td>
<td class="detail"><?php echo $ContractingEntity; ?></td>

</tr>

<tr>
<td><strong>Vendor:</strong></td>
<td class="detail"><?php echo $Vendor; ?></td>

</tr>

<tr>
<td><strong>Contract Type:</strong></td>
<td class="detail"><?php echo $ContractType; ?></td>

</tr>

<tr>
	<td><strong>Contract Title:</strong></td>
	<td class="detail"><?php echo $ContractTitle; ?></td>
</tr>

<tr>
<td><strong>Contract Description:</strong></td>
<td class="detail"><?php echo $ContractDescription; ?></td>

</tr>

<tr>
<td><strong>Department:</strong></td>
<td class="detail"><?php echo $Department; ?></td>

</tr>

<tr>
<td><strong>EOC:</strong></td>
<td class="detail"><?php echo $EOC; ?></td>

</tr>

<tr>
<td><strong>Responsible Party (Primary):</strong></td>
<td class="detail"><?php echo $ResponsiblePartyPri; ?></td>

</tr>

<tr>
<td><strong>Responsible Party (Secondary):</strong></td>
<td class="detail"><?php echo $ResponsiblePartySec; ?></td>

</tr>

<tr>
<td><strong>Responsible Party (Tertiary):</strong></td>
<td class="detail"><?php echo $ResponsiblePartyTer; ?></td>

</tr>

<tr>
<td><strong>Additional Reviewer - 1:</strong></td>
<td class="detail"><?php echo $AdditionalReviewer1; ?></td>

</tr>

<tr>
<td><strong>Additional Reviewer - 2:</strong></td>
<td class="detail"><?php echo $AdditionalReviewer2; ?></td>

</tr>

<tr>
<td><strong>Effective Date:</strong></td>
<td class="detail"><?php echo $EffectiveDate; ?></td>

</tr>

<tr>
<td><strong>Expiration Date:</strong></td>
<td class="detail"><?php echo $ExpirationDate; ?></td>

</tr>

<tr>
<td><strong>Contract Status:</strong></td>
<td class="detail"><?php echo $ContractStatus; ?></td>

</tr>

<tr>
<td><strong>Auto Renewal:</strong></td>
<td class="detail"><?php echo $AutoRenewal; ?></td>

</tr>

<tr>
<td><strong>Auto Renewal Terms (Months):</strong></td>
<td class="detail"><?php echo $AutoRenewalTerms; ?></td>

</tr>

<tr>
<td><strong>Auto Renewal Times:</strong></td>
<td class="detail"><?php echo $AutoRenewalTimes; ?></td>

</tr>

<tr>
<td><strong>Auto Renewal Deadline:</strong></td>
<td class="detail"><?php echo $AutoRenewalDeadline; ?></td>

</tr>

</table>

<!-- END DETAILS -->

<!--BEGIN FILE DETAILS -->

<div class="topbar" id="filedetails">
<div id="backform">
	<form action="editfile.php" method="post" enctype="multipart/form-data">
	<input type="text" value="<?php echo $id; ?>" name="id" class="hid" hidden>
	<input type="image" src="img/BTNEdit.png" name="backbutton" value="Back" onMouseOver="this.src='img/BTNEditHO.png'" onMouseOut="this.src='img/BTNEdit.png'"/>
	</form>
	</div>
	<h1>files</h1>
</div>
<?php
if ($ContractFileName == '' && $BAAFileName == '' && $COIFileName == '' && $ServiceEvaluationFileName == '' && $AddendumFileName == '' && $MemorandumOfUnderstandingFileName == '' && $PurchaseOrderFileName == ''){
?>
<table class="nofiles">
		<tr>
			<td>No File Information Available</td>
		</tr>
	</table>
<?php
} else {
?>
<table class="files">

<?php
if ($ContractFileName) {
	if($conUploadDate == NULL){$condate = NULL; }else{$condate = $conUploadDate->format('Y-m-d H:i:s');}
?>
	<tr>	
	<td><a href="uploads/<?php echo $ContractFileName; ?>" target="_blank"><img src="img/MFGTrans.png" alt="View Contract" onMouseOver="this.src='img/MFGTransHO.png'" onMouseOut="this.src='img/MFGTrans.png'"></a></td>
	<td title="Uploaded: <?php echo $condate; ?>"><strong>Contract</strong></td>
	</tr>
<?php
}
if ($BAAFileName) {
	if($baaUploadDate == NULL){$baadate = NULL; }else{$baadate = $baaUploadDate->format('Y-m-d H:i:s');}
?>
	<tr>
	<td><a href="uploads/<?php echo $BAAFileName; ?>" target="_blank"><img src="img/MFGTrans.png" alt="View Contract" onMouseOver="this.src='img/MFGTransHO.png'" onMouseOut="this.src='img/MFGTrans.png'"></a></td>
	<td title="Uploaded: <?php echo $baadate; ?>"><strong>BAA</strong></td>
	</tr>
<?php
}
if ($COIFileName) {
	if($coiUploadDate == NULL){$coidate = NULL; }else{$coidate = $coiUploadDate->format('Y-m-d H:i:s');}
?>
	<tr>
	<td><a href="uploads/<?php echo $COIFileName; ?>" target="_blank"><img src="img/MFGTrans.png" alt="View Contract" onMouseOver="this.src='img/MFGTransHO.png'" onMouseOut="this.src='img/MFGTrans.png'"></a></td>
	<td title="Uploaded: <?php echo $coidate; ?>"><strong>COI</strong></td>
	</tr>
<?php
}
if ($ServiceEvaluationFileName) {
	if($sevUploadDate == NULL){$sevdate = NULL; }else{$sevdate = $sevUploadDate->format('Y-m-d H:i:s');}
?>
	<tr>
	<td><a href="uploads/<?php echo $ServiceEvaluationFileName; ?>" target="_blank"><img src="img/MFGTrans.png" alt="View Contract" onMouseOver="this.src='img/MFGTransHO.png'" onMouseOut="this.src='img/MFGTrans.png'"></a></td>
	<td title="Uploaded: <?php echo $sevdate; ?>"><strong>Service Evaluation</strong></td>
	</tr>
<?php
}
if ($AddendumFileName) {
	if($admUploadDate == NULL){$admdate = NULL; }else{$admdate = $admUploadDate->format('Y-m-d H:i:s');}
?>
	<tr>
	<td><a href="uploads/<?php echo $AddendumFileName; ?>" target="_blank"><img src="img/MFGTrans.png" alt="View Contract" onMouseOver="this.src='img/MFGTransHO.png'" onMouseOut="this.src='img/MFGTrans.png'"></a></td>
	<td title="Uploaded: <?php echo $admdate; ?>"><strong>Addendum</strong></td>
	</tr>
<?php
}
if ($MemorandumOfUnderstandingFileName) {
	if($mouUploadDate == NULL){$moudate = NULL; }else{$moudate = $mouUploadDate->format('Y-m-d H:i:s');}
?>
	<tr>
	<td><a href="uploads/<?php echo $MemorandumOfUnderstandingFileName; ?>" target="_blank"><img src="img/MFGTrans.png" alt="View Contract" onMouseOver="this.src='img/MFGTransHO.png'" onMouseOut="this.src='img/MFGTrans.png'"></a></td>
	<td title="Uploaded: <?php echo $moudate; ?>"><strong>Memorandum of Understanding</strong></td>
	</tr>
<?php
}
if ($PurchaseOrderFileName) {
	if($poUploadDate == NULL){$podate = NULL; }else{$podate = $poUploadDate->format('Y-m-d H:i:s');}
?>
	<tr>
	<td><a href="uploads/<?php echo $PurchaseOrderFileName; ?>" target="_blank"><img src="img/MFGTrans.png" alt="View Contract" onMouseOver="this.src='img/MFGTransHO.png'" onMouseOut="this.src='img/MFGTrans.png'"></a></td>
	<td title="Uploaded: <?php echo $podate; ?>"><strong>Purchase Order</strong></td>
	</tr>
<?php
}
?>
</table>
<?php
}
?>
<!-- END FILE DETAILS -->

<!-- START ARCHIVE SECTION -->
<div class="topbar" id="archfiles">

	<div id="archform">
	<form action="archive.php" method="post" enctype="multipart/form-data">
	<input type="text" value="<?php echo $id; ?>" name="id" class="hid" hidden>
	<input type="image" src="img/BTNArchivedFiles.png" name="archbutton" value="Back" onMouseOver="this.src='img/BTNArchivedFilesHOV.png'" onMouseOut="this.src='img/BTNArchivedFiles.png'"/>
	</form>
	</div>
	
</div>

<!-- END ARCHIVE SECTION -->

<!-- BEGIN COST DETAILS -->
<div class="topbar" id="costdetails">
	<div id="backform">
	<form action="editcost.php" method="post" enctype="multipart/form-data">
	<input type="text" value="<?php echo $id; ?>" name="id" class="hid" hidden>
	<input type="image" src="img/BTNEdit.png" name="backbutton" value="Back" onMouseOver="this.src='img/BTNEditHO.png'" onMouseOut="this.src='img/BTNEdit.png'"/>
	</form>
	</div>
	<h1>cost info</h1>
</div>
<?php 
if($totalcost == 0) {
?>
	<table class="cost">
		<tr>
			<td>No Cost Information Available</td>
		</tr>
	</table>
<?php
} else {
?>	
<table class="cost">
<tr>
	<td><strong>Year 01:</strong></td>
	<td><?php if($AnnualCost1) {echo '$'.$AnnualCost1;} else {echo 'N/A';} ?></td>
</tr>
<tr>
	<td><strong>Year 02:</strong></td>
	<td><?php if($AnnualCost2) {echo '$'.$AnnualCost2;} else {echo 'N/A';} ?></td>
</tr>
<tr>
	<td><strong>Year 03:</strong></td>
	<td><?php if($AnnualCost3) {echo '$'.$AnnualCost3;} else {echo 'N/A';} ?></td>
</tr>
<tr>
	<td><strong>Year 04:</strong></td>
	<td><?php if($AnnualCost4) {echo '$'.$AnnualCost4;} else {echo 'N/A';} ?></td>
</tr>
<tr>
	<td><strong>Year 05:</strong></td>
	<td><?php if($AnnualCost5) {echo '$'.$AnnualCost5;} else {echo 'N/A';} ?></td>
</tr>
<tr>
	<td><strong>Year 06:</strong></td>
	<td><?php if($AnnualCost6) {echo '$'.$AnnualCost6;} else {echo 'N/A';} ?></td>
</tr>
<tr>
	<td><strong>Year 07:</strong></td>
	<td><?php if($AnnualCost7) {echo '$'.$AnnualCost7;} else {echo 'N/A';} ?></td>
</tr>
<tr>
	<td><strong>Year 08:</strong></td>
	<td><?php if($AnnualCost8) {echo '$'.$AnnualCost8;} else {echo 'N/A';} ?></td>
</tr>
<tr>
	<td><strong>Year 09:</strong></td>
	<td><?php if($AnnualCost9) {echo '$'.$AnnualCost9;} else {echo 'N/A';} ?></td>
</tr>
<tr>
	<td class="bottomrow"><strong>Year 10:</strong></td>
	<td class="bottomrow"><?php if($AnnualCost10) {echo '$'.$AnnualCost10;} else {echo 'N/A';} ?></td>
</tr>
<tr>
	<td class="total" colspan="2"><strong>Total Cost:</strong> $<?php echo $totalcost; ?></td>
	
</tr>
</table>
<?php
}
?>
<!-- END COST DETAILS -->

<!-- START SERVICE EVALUATION DETAILS -->
<div class="topbar" id="sevdetails">
	<div id="backform">
	<form action="editsev.php" method="post" enctype="multipart/form-data">
	<input type="text" value="<?php echo $id; ?>" name="id" class="hid" hidden>
	<input type="image" src="img/BTNEdit.png" name="backbutton" value="Back" onMouseOver="this.src='img/BTNEditHO.png'" onMouseOut="this.src='img/BTNEdit.png'"/>
	</form>
	</div>
	<h1>service evaluation details</h1>
</div>
<table class="serviceeval">
<tr>
	<td><strong>Service Evaluation Period</strong></td>
	<td><strong>Last Evaluation Date</strong></td>
	<td><strong>Next Evaluation Date</strong></td>
</tr>
<tr>
	<td><?php echo $ServiceEvaluationPeriod; ?></td>
	<td><?php echo $LastServiceEvaluationDate; ?></td>  
	<td><?php echo $NextServiceEvaluationDate; ?></td>
</tr>
</table>
<!-- END SERVICE EVALUATION DETAILS -->

</div>
<?php
}


function text_search(){
?>
<!--
<div class="topbar" id="textsearch">
	<h1>text search</h1>
	</div>
-->	
	<form method="post" action="results.php" enctype="multipart/form-data" id="textform">
	<input type="text" value="1" name="textsearch" class="hid" hidden>
	<table class="search">
	<tbody>
	<tr>
		<td class="searchtitle"><strong>Contract Name/Description/Vendor/Department:</strong></td>
		<td><input type="text" title="Enter text to search all contract titles and descriptions" name="Text" placeholder="Enter text to search..." required></td>
	</tr>
	
	</tbody>
	</table>
	<div class="searchbutton"><input type="image" value="Submit" src="img/submitbtn.png" onMouseOver="this.src='img/submitbtnHO.png'" onMouseOut="this.src='img/submitbtn.png'"/></div>
	</form>
<?php
}





?>
