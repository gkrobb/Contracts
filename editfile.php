<?php
session_start();

require_once ('cms_fns.php');
require_once ('forms_fns.php');

page_header('Edit Contract Files','main');

$id = $_POST['id'];
$conn = db_conn();
$sql = "SELECT ContractID,Vendor,ContractTitle,ContractDescription,Department,ContractFileName,BAAFileName,COIFileName,ServiceEvaluationFileName,
		AddendumFileName,MemorandumOfUnderstandingFileName,PurchaseOrderFileName FROM ContractData WHERE ContractID = '".$id."'";
$result = sqlsrv_query($conn, $sql);
$row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);

$confile = $row['ContractFileName'];
$baafile = $row['BAAFileName'];
$coifile = $row['COIFileName'];
$sevfile = $row['ServiceEvaluationFileName'];
$admfile = $row['AddendumFileName'];
$moufile = $row['MemorandumOfUnderstandingFileName'];
$pofile = $row['PurchaseOrderFileName'];
?>

<h1 class="filehead"><span id="namehead"><?php echo $row['Vendor']; ?> - <?php echo $row['ContractTitle']; ?></span></h1>
<?php
if ($confile == '' && $baafile == '' && $coifile == '' && $sevfile == '' && $admfile == '' && $moufile == '' && $pofile == '') { //IF NO FILES ARE UPLOADED
?>
	<div class="topbar" id="notuploaded">
		<div id="backform">
			<form action="fulldisplay.php" method="post" enctype="multipart/form-data">
				<input type="text" value="<?php echo $id; ?>" name="backid" class="hid" hidden>
				<input type="image" src="img/Back.png" name="backbutton" value="Back" onMouseOver="this.src='img/BackHO.png'" onMouseOut="this.src='img/Back.png'"/>
			</form>
		</div>
	<h1>files not uploaded</h1>
	</div>

<form method="post" action="fulldisplay.php" enctype="multipart/form-data" id="noupfile">
<input type="text" value="1" name="fileedit" class="hid" hidden>
<input type="text" value="1" name="uploadfile" class="hid" hidden>
<input type="text" value="<?php echo $row['ContractID']; ?>" name="ContractID" class="hid" hidden>
<table class="uploadtab">
<?php	
if (!$confile) { 
?>
	<tr>
		<td><strong>Contract</strong></td>
		<td><input type="file" name="cmsfile[0]" /></td>
	</tr>
<?php	 
	}

if (!$baafile) { 
?>
	<tr>
		<td><strong>BAA</strong></td>
		<td><input type="file" name="cmsfile[1]" /></td>
	</tr>
<?php	 
	}

if (!$coifile) { 
?>
	<tr>
		<td><strong>COI</strong></td>
		<td><input type="file" name="cmsfile[2]" /></td>
	</tr>
<?php	 
	}

if (!$sevfile) { 
?>
	<tr>
		<td><strong>Service Evaluation</strong></td>
		<td><input type="file" name="cmsfile[3]" /></td>
	</tr>
<?php	 
	}

if (!$admfile) { 
?>
	<tr>
		<td><strong>Addendum</strong></td>
		<td><input type="file" name="cmsfile[4]" /></td>
	</tr>
<?php	 
	}

if (!$moufile) { 
?>
	<tr>
		<td><strong>Memorandum of Understanding</strong></td>
		<td><input type="file" name="cmsfile[5]" /></td>
	</tr>
<?php	 
	}

if (!$pofile) { 
?>
	<tr>
		<td><strong>Purchase Order</strong></td>
		<td><input type="file" name="cmsfile[6]" /></td>
	</tr>
<?php	 
	}
?>
</table>
<div class="fileupdatebutton"><input type="image" value="Update" src="img/Update.png" onMouseOver="this.src='img/UpdateHO.png'" onMouseOut="this.src='img/Update.png'"/></div>
</form>
<?php
} elseif($confile != '' && $baafile != '' && $coifile != '' && $sevfile != '' && $admfile != '' && $moufile != '' && $pofile != '') {  //IF ALL FILES ARE UPLOADED
?>

<div class="topbar" id="uploaded">
<div id="backform">
	<form action="fulldisplay.php" method="post" enctype="multipart/form-data">
	<input type="text" value="<?php echo $id; ?>" name="backid" class="hid" hidden>
	<input type="image" src="img/Back.png" name="backbutton" value="Back" onMouseOver="this.src='img/BackHO.png'" onMouseOut="this.src='img/Back.png'"/>
	</form>
	</div>
	<h1>uploaded files</h1>
</div>

<form method="post" action="fulldisplay.php" enctype="multipart/form-data" id="upfile">
<input type="text" value="1" name="fileedit" class="hid" hidden>
<input type="text" value="1" name="updatefile" class="hid" hidden>
<input type="text" value="<?php echo $row['ContractID']; ?>" name="ContractID" class="hid" hidden>
<table class="uploadtab">

<?php
if ($confile) { 
?>
	<tr>
		<td><strong>Contract</strong></td>
		<td><input type="file" name="cmsfile[0]" /></td>
	</tr>
<?php	 
	}

if ($baafile) { 
?>
	<tr>
		<td><strong>BAA</strong></td>
		<td><input type="file" name="cmsfile[1]" /></td>
	</tr>
<?php	 
	}

if ($coifile) { 
?>
	<tr>
		<td><strong>COI</strong></td>
		<td><input type="file" name="cmsfile[2]" /></td>
	</tr>
<?php	 
	}

if ($sevfile) { 
?>
	<tr>
		<td><strong>Service Evaluation</strong></td>
		<td><input type="file" name="cmsfile[3]" /></td>
	</tr>
<?php	 
	}

if ($admfile) { 
?>
	<tr>
		<td><strong>Addendum</strong></td>
		<td><input type="file" name="cmsfile[4]" /></td>
	</tr>
<?php	 
	}

if ($moufile) { 
?>
	<tr>
		<td><strong>Memorandum of Understanding</strong></td>
		<td><input type="file" name="cmsfile[5]" /></td>
	</tr>
<?php	 
	}

if ($pofile) { 
?>
	<tr>
		<td><strong>Purchase Order</strong></td>
		<td><input type="file" name="cmsfile[6]" /></td>
	</tr>
<?php	 
	}
?>

</table>
<div class="fileupdatebutton"><input type="image" value="Update" src="img/Update.png" onMouseOver="this.src='img/UpdateHO.png'" onMouseOut="this.src='img/Update.png'"/></div>
</form>
<?php
} else {  //IF SOME FILES ARE UPLOADED, BUT NOT ALL
?>

<div class="topbar" id="uploaded">
<div id="backform">
	<form action="fulldisplay.php" method="post" enctype="multipart/form-data">
	<input type="text" value="<?php echo $id; ?>" name="backid" class="hid" hidden>
	<input type="image" src="img/Back.png" name="backbutton" value="Back" onMouseOver="this.src='img/BackHO.png'" onMouseOut="this.src='img/Back.png'"/>
	</form>
	</div>
	<h1>uploaded files</h1>
</div>

<form method="post" action="fulldisplay.php" enctype="multipart/form-data" id="upfile">
<input type="text" value="1" name="fileedit" class="hid" hidden>
<input type="text" value="1" name="updatefile" class="hid" hidden>
<input type="text" value="<?php echo $row['ContractID']; ?>" name="ContractID" class="hid" hidden>
<table class="uploadtab">

<?php
if ($confile) { 
?>
	<tr>
		<td><strong>Contract</strong></td>
		<td><input type="file" name="cmsfile[0]" /></td>
	</tr>
<?php	 
	}

if ($baafile) { 
?>
	<tr>
		<td><strong>BAA</strong></td>
		<td><input type="file" name="cmsfile[1]" /></td>
	</tr>
<?php	 
	}

if ($coifile) { 
?>
	<tr>
		<td><strong>COI</strong></td>
		<td><input type="file" name="cmsfile[2]" /></td>
	</tr>
<?php	 
	}

if ($sevfile) { 
?>
	<tr>
		<td><strong>Service Evaluation</strong></td>
		<td><input type="file" name="cmsfile[3]" /></td>
	</tr>
<?php	 
	}

if ($admfile) { 
?>
	<tr>
		<td><strong>Addendum</strong></td>
		<td><input type="file" name="cmsfile[4]" /></td>
	</tr>
<?php	 
	}

if ($moufile) { 
?>
	<tr>
		<td><strong>Memorandum of Understanding</strong></td>
		<td><input type="file" name="cmsfile[5]" /></td>
	</tr>
<?php	 
	}

if ($pofile) { 
?>
	<tr>
		<td><strong>Purchase Order</strong></td>
		<td><input type="file" name="cmsfile[6]" /></td>
	</tr>
<?php	 
	}
?>

</table>
<div class="fileupdatebutton"><input type="image" value="Update" src="img/Update.png" onMouseOver="this.src='img/UpdateHO.png'" onMouseOut="this.src='img/Update.png'"/></div>
</form>

<!-- -->

<div class="topbar" id="notuploaded">
<div id="backform">
	<form action="fulldisplay.php" method="post" enctype="multipart/form-data">
	<input type="text" value="<?php echo $id; ?>" name="backid" class="hid" hidden>
	<input type="image" src="img/Back.png" name="backbutton" value="Back" onMouseOver="this.src='img/BackHO.png'" onMouseOut="this.src='img/Back.png'"/>
	</form>
	</div>
	<h1>files not uploaded</h1>
</div>

<form method="post" action="fulldisplay.php" enctype="multipart/form-data" id="noupfile">
<input type="text" value="1" name="fileedit" class="hid" hidden>
<input type="text" value="1" name="uploadfile" class="hid" hidden>
<input type="text" value="<?php echo $row['ContractID']; ?>" name="ContractID" class="hid" hidden>
<table class="uploadtab">
<?php	
if (!$confile) { 
?>
	<tr>
		<td><strong>Contract</strong></td>
		<td><input type="file" name="cmsfile[0]" /></td>
	</tr>
<?php	 
	}

if (!$baafile) { 
?>
	<tr>
		<td><strong>BAA</strong></td>
		<td><input type="file" name="cmsfile[1]" /></td>
	</tr>
<?php	 
	}

if (!$coifile) { 
?>
	<tr>
		<td><strong>COI</strong></td>
		<td><input type="file" name="cmsfile[2]" /></td>
	</tr>
<?php	 
	}

if (!$sevfile) { 
?>
	<tr>
		<td><strong>Service Evaluation</strong></td>
		<td><input type="file" name="cmsfile[3]" /></td>
	</tr>
<?php	 
	}

if (!$admfile) { 
?>
	<tr>
		<td><strong>Addendum</strong></td>
		<td><input type="file" name="cmsfile[4]" /></td>
	</tr>
<?php	 
	}

if (!$moufile) { 
?>
	<tr>
		<td><strong>Memorandum of Understanding</strong></td>
		<td><input type="file" name="cmsfile[5]" /></td>
	</tr>
<?php	 
	}

if (!$pofile) { 
?>
	<tr>
		<td><strong>Purchase Order</strong></td>
		<td><input type="file" name="cmsfile[6]" /></td>
	</tr>
<?php	 
	}
?>
</table>
<div class="fileupdatebutton"><input type="image" value="Update" src="img/Update.png" onMouseOver="this.src='img/UpdateHO.png'" onMouseOut="this.src='img/Update.png'"/></div>
</form>

<?php
}	





page_footer();
?>