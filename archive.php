<?php
require_once('cms_fns.php');
require_once('forms_fns.php');

page_header('Archive','main');

$id = $_POST['id'];

$conn = db_conn();
$sql = "SELECT ContractID, ArchivedFileName,DateArchived, FileType FROM ContractFileArchive WHERE ContractID = '".$id."'";
$result = sqlsrv_query($conn,$sql, array(),array("Scrollable" => 'static'));
$count = sqlsrv_num_rows($result);

 	if ($count < 1) {
?>
	<div class="topbar" id="noresults">
	<div id="backform">
	<form action="fulldisplay.php" method="post" enctype="multipart/form-data">
	<input type="text" name="backid" value="<?php echo $id; ?>" class="hid" hidden />
	<input type="image" src="img/Back.png" name="backbutton" value="Back" onMouseOver="this.src='img/BackHO.png'" onMouseOut="this.src='img/Back.png'"/>
	</form>
	</div>
	<h1>archived files</h1>
	</div>
	<div id="noarchbox">
	
		<p id="noarch">No archived files exist for this contract.  Use the Back button to return to the previous screen.</p>
	
	</div>
	
	
<?php	
	} else {
?>
<div class="topbar" id="viewarchive">
	<div id="backform">
	<form action="fulldisplay.php" method="post" enctype="multipart/form-data">
	<input type="text" name="backid" value="<?php echo $id; ?>" class="hid" hidden />
	<input type="image" src="img/Back.png" name="backbutton" value="Back" onMouseOver="this.src='img/BackHO.png'" onMouseOut="this.src='img/Back.png'"/>
	</form>
	</div>
	<h1>archived files</h1>
	</div>
	<div id="archbox">
		<table class="archivetable">
			<tr>
				<td class="archtdl lefttd" id="archhead">File Type</td>
				<td class="archtdl" id="archhead">Archived Date</td>
				<td class="archtdc" id="archhead">View/DL</td>
				<td class="archtdl righttd" id="archhead">Delete</td>
			</tr>
<?php
	while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)){
?>
			<tr id="arch">
			<td class="archtdl lefttd"><?php echo $row['FileType']; ?></td>
			<td class="archtdl"><?php echo $row['DateArchived']; ?></td>
			<td class="archtdc">
				<a href="uploads/archived/<?php echo $row['ArchivedFileName']; ?>" target="_blank"><img src="img/MFGTrans.png" alt="View File" onMouseOver="this.src='img/MFGTransHO.png'" onMouseOut="this.src='img/MFGTrans.png'"></a>
			</td>
			<td class="archtdl">
				<form action="fulldisplay.php" method="post" enctype="multipart/form-data">
					<input type="image" src="img/x.png" name="deletebutton" value="Delete" onMouseOver="this.src='img/xHO.png'" onMouseOut="this.src='img/x.png'"/>
					<input type="text" name="filename" value="<?php echo $row['ArchivedFileName']; ?>" class="hid" hidden />
					<input type="text" name="delete" value="1" class="hid" hidden />
				</form>
			</td>
			</tr>
			<?php
		}
?>			
		</table>
	</div>
<?php
	}
page_footer();
?>

