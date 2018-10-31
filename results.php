<?php

require_once ('cms_fns.php');

page_header('Search Results','main');

global $superusers;
$vendor = $_POST['Vendor'];
$department = $_POST['Department'];
$text = $_POST['Text'];
$user = str_replace("'","''",strtoupper($_SERVER['LOGON_USER']));

$conn = db_conn();


if ($vendor) {
	$sql = "SELECT cd.ContractID,cd.Vendor,cd.ContractDescription,cd.ContractTitle,cd.Department,CONVERT(varchar(10),cd.ExpirationDate,23) AS 'ExpirationDate' 
			FROM ContractData AS cd
			LEFT JOIN ContractUsers AS cu1 ON cd.ResponsiblePartyPri=cu1.Name
			LEFT JOIN ContractUsers AS cu2 ON cd.ResponsiblePartySec=cu2.Name
			LEFT JOIN ContractUsers AS cu3 ON cd.ResponsiblePartyTer=cu3.Name
			LEFT JOIN ContractUsers AS cu4 ON cd.AdditionalReviewer1=cu4.Name
			LEFT JOIN ContractUsers AS cu5 ON cd.AdditionalReviewer2=cu5.Name
			WHERE ((cu1.ClaxtonUsername = '".$user."') OR (cu2.ClaxtonUsername = '".$user."') OR (cu3.ClaxtonUsername = '".$user."') OR (cu4.ClaxtonUsername = '".$user."') OR (cu5.ClaxtonUsername = '".$user."')
			OR ('".$user."' IN (SELECT ClaxtonUsername FROM ContractUsers WHERE Superuser = 'Y')))
			AND Vendor = '".$vendor."'";
	$result = sqlsrv_query($conn, $sql, array(),array("Scrollable" => 'static'));  //the 'array(),array("Scrollable" => 'static'))' part of this line is being used so sqlsrv_num_rows can be used.);
	$count = sqlsrv_num_rows($result);
	
	if ($count < 1) {
?>
	<div class="topbar" id="noresults">
	<div id="backform">
	<form action="existing.php" method="post" enctype="multipart/form-data">
	<input type="image" src="img/Back.png" name="backbutton" value="Back" onMouseOver="this.src='img/BackHO.png'" onMouseOut="this.src='img/Back.png'"/>
	</form>
	</div>
	<h1>no results found</h1>
	</div>
	<div id="noresultsbox">
	
		<p>No results were found that matched your search criteria.  Please click the Back button and try another search.</p>
	
	</div>
	
	
<?php	
	} else {
?>
	<div class="topbar" id="searchresults">
	<div id="backform">
	<form action="existing.php" method="post" enctype="multipart/form-data">
	<input type="image" src="img/Back.png" name="backbutton" value="Back" onMouseOver="this.src='img/BackHO.png'" onMouseOut="this.src='img/Back.png'"/>
	</form>
	</div>
	<h1>search results</h1>
	</div>
	
	<form method="post" action="fulldisplay.php" enctype="multipart/form-data" id="results">
	<table class="resultstable">
	<tr>
	<td style="width:50px"></td>
	<!--  <td style="width:75px">Contract ID</td>  -->
	<td  style="width:200px"><strong>Vendor</strong></td>
	<td  style="width:375px"><strong>Contract Title</strong></td>
	<td  style="width:250px"><strong>Department</strong></td>
	<td  style="width:125px"><strong>Expiration Date</strong></td>
	</tr>
<?php
	while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)){
			echo '<tr>';
			echo '<td><input type="radio" name="selected" value="'.$row['ContractID'].'" required/></td>';
			//echo '<td>'.($row['ContractID']).'</td>';
			echo '<td>'.($row['Vendor']).'</td>';
			echo '<td>'.($row['ContractTitle']).'</td>';
			echo '<td>'.($row['Department']).'</td>';
			echo '<td>'.($row['ExpirationDate']).'</td>';
			echo '</tr>';
		}
?>			
	</table>
	<div id="pick"><input type="image" src="img/RSC.png" value="Submit"  onMouseOver="this.src='img/RSCHO.png'" onMouseOut="this.src='img/RSC.png'"/></div>
	</form>
	
<?php	
	}
}

if ($department) {
	$sql = "SELECT cd.ContractID,cd.Vendor AS cd_Vendor,cd.ContractDescription AS cd_ContractDescription,cd.ContractTitle AS cd_ContractTitle
			,cd.Department AS cd_Department,CONVERT(varchar(10),cd.ExpirationDate,23) AS 'ExpirationDate',dpt.DepartmentNumber AS dpt_DepartmentNumber FROM ContractData AS cd
			LEFT JOIN ContractDepartments AS dpt ON cd.Department=dpt.DepartmentName 
			LEFT JOIN ContractUsers AS cu1 ON cd.ResponsiblePartyPri=cu1.Name
			LEFT JOIN ContractUsers AS cu2 ON cd.ResponsiblePartySec=cu2.Name
			LEFT JOIN ContractUsers AS cu3 ON cd.ResponsiblePartyTer=cu3.Name
			LEFT JOIN ContractUsers AS cu4 ON cd.AdditionalReviewer1=cu4.Name
			LEFT JOIN ContractUsers AS cu5 ON cd.AdditionalReviewer2=cu5.Name
			WHERE ((cu1.ClaxtonUsername = '".$user."') OR (cu2.ClaxtonUsername = '".$user."') OR (cu3.ClaxtonUsername = '".$user."') OR (cu4.ClaxtonUsername = '".$user."') OR (cu5.ClaxtonUsername = '".$user."')
			OR ('".$user."' IN (SELECT ClaxtonUsername FROM ContractUsers WHERE Superuser = 'Y')))
			AND cd.Department = '".$department."'";
	$result = sqlsrv_query($conn, $sql, array(),array("Scrollable" => 'static'));  //the 'array(),array("Scrollable" => 'static'))' part of this line is being used so sqlsrv_num_rows can be used.
	$count = sqlsrv_num_rows($result);
	
	if ($count < 1) {
?>
	<div class="topbar" id="noresults">
	<div id="backform">
	<form action="existing.php" method="post" enctype="multipart/form-data">
	<input type="image" src="img/Back.png" name="backbutton" value="Back" onMouseOver="this.src='img/BackHO.png'" onMouseOut="this.src='img/Back.png'"/>
	</form>
	</div>
	<h1>no results found</h1>
	</div>
	<div id="noresultsbox">
	
		<p>No results were found that matched your search criteria.  Please click the Back button and try another search.</p>
	
	</div>
	
<?php
	} else {
?>
		<div class="topbar" id="searchresults">
		<div id="backform">
		<form action="existing.php" method="post" enctype="multipart/form-data">
		<input type="image" src="img/Back.png" name="backbutton" value="Back" onMouseOver="this.src='img/BackHO.png'" onMouseOut="this.src='img/Back.png'"/>
		</form>
		</div>
		<h1>search results</h1>
		</div>
		<form method="post" action="fulldisplay.php" enctype="multipart/form-data" id="results">
		<table class="resultstable">
		<tr>
		<td style="width:50px"></td>
	<!--  <td style="width:75px">Contract ID</td>  -->
	<td  style="width:200px"><strong>Vendor</strong></td>
	<td  style="width:375px"><strong>Contract Title</strong></td>
	<td  style="width:250px"><strong>Department</strong></td>
	<td  style="width:125px"><strong>Expiration Date</strong></td>
				</tr>
<?php
		while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)){
			echo '<tr>';
			echo '<td><input type="radio" name="selected" value="'.$row['ContractID'].'"required/></td>';
			echo '<td>'.($row['cd_Vendor']).'</td>';
			echo '<td>'.($row['cd_ContractTitle']).'</td>';
			echo '<td>'.($row['dpt_DepartmentNumber'].' - '.$row['cd_Department']).'</td>';
			echo '<td>'.($row['ExpirationDate']).'</td>';
			echo '</tr>';
		}
?>			
		</table>
		<div id="pick"><input type="image" src="img/RSC.png" value="Submit"  onMouseOver="this.src='img/RSCHO.png'" onMouseOut="this.src='img/RSC.png'"/></div>
		</form>
		
<?php	
	}
}


if ($text) {
	$sql = "SELECT cd.ContractID
				,cd.Vendor
				,cd.ContractDescription
				,cd.ContractTitle
				,cd.Department
				,CONVERT(varchar(10),cd.ExpirationDate,23) AS 'ExpirationDate' 
			FROM 
				ContractData AS cd
			LEFT JOIN ContractUsers AS cu1 ON cd.ResponsiblePartyPri=cu1.Name
			LEFT JOIN ContractUsers AS cu2 ON cd.ResponsiblePartySec=cu2.Name
			LEFT JOIN ContractUsers AS cu3 ON cd.ResponsiblePartyTer=cu3.Name 
			LEFT JOIN ContractUsers AS cu4 ON cd.AdditionalReviewer1=cu4.Name
			LEFT JOIN ContractUsers AS cu5 ON cd.AdditionalReviewer2=cu5.Name
			WHERE ((cd.Department LIKE '%".$text."%') OR (cd.ContractTitle LIKE '%".$text."%') OR (cd.ContractDescription LIKE '%".$text."%') OR (cd.Vendor LIKE '%".$text."%'))
			AND
			((cu1.ClaxtonUsername = '".$user."') OR (cu2.ClaxtonUsername = '".$user."') OR (cu3.ClaxtonUsername = '".$user."') OR (cu4.ClaxtonUsername = '".$user."') OR (cu5.ClaxtonUsername = '".$user."')
			OR ('".$user."' IN (SELECT ClaxtonUsername FROM ContractUsers WHERE Superuser = 'Y')))";
	$result = sqlsrv_query($conn, $sql, array(),array("Scrollable" => 'static'));  //the 'array(),array("Scrollable" => 'static'))' part of this line is being used so sqlsrv_num_rows can be used.
	$count = sqlsrv_num_rows($result);
	
	if ($count < 1) {
?>
	<div class="topbar" id="noresults">
	<div id="backform">
	<form action="existing.php" method="post" enctype="multipart/form-data">
	<input type="image" src="img/Back.png" name="backbutton" value="Back" onMouseOver="this.src='img/BackHO.png'" onMouseOut="this.src='img/Back.png'"/>
	</form>
	</div>
	<h1>no results found</h1>
	</div>
	<div id="noresultsbox">
	
		<p>No results were found that matched your search criteria.  Please click the Back button and try another search.</p>
	
	</div>
<?php
	} else {
?>
		<div class="topbar" id="searchresults">
		<div id="backform">
		<form action="existing.php" method="post" enctype="multipart/form-data">
		<input type="image" src="img/Back.png" name="backbutton" value="Back" onMouseOver="this.src='img/BackHO.png'" onMouseOut="this.src='img/Back.png'"/>
		</form>
		</div>
		<h1>search results</h1>
		</div>
		<form method="post" action="fulldisplay.php" enctype="multipart/form-data" id="results">
		<table class="resultstable">
		<tr>
		<td style="width:50px"></td>
	<!--  <td style="width:75px">Contract ID</td>  -->
	<td  style="width:200px"><strong>Vendor</strong></td>
	<td  style="width:375px"><strong>Contract Title</strong></td>
	<td  style="width:250px"><strong>Department</strong></td>
	<td  style="width:125px"><strong>Expiration Date</strong></td>
				</tr>
<?php
		while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)){
			echo '<tr title="'.$row['ContractDescription'].'">';
			echo '<td><input type="radio" name="selected" value="'.$row['ContractID'].'"required/></td>';
			echo '<td>'.($row['Vendor']).'</td>';
			echo '<td>'.$row['ContractTitle'].'</td>';
			echo '<td>'.($row['Department']).'</td>';
			echo '<td>'.($row['ExpirationDate']).'</td>';
			echo '</tr>';
		}
?>			
		</table>
		<div id="pick"><input type="image" src="img/RSC.png" value="Submit"  onMouseOver="this.src='img/RSCHO.png'" onMouseOut="this.src='img/RSC.png'"/></div>
		</form>
		
		
<?php	
	}
}



page_footer();
?>