<!-- Multiple File Upload Test  -->
<?php $title = 'MFU Test';
require_once ('forms_fns.php');
 ?>
<!DOCTYPE html>

<html>
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=Edge">
	<title><?php echo $title; ?></title>
	<link rel="stylesheet" href="cms.css?version=2" />
	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

	
</head>
<body id="main">
<div id="header">
<img src="img/CHCMSBanner.png" class="banner">
<a href="./"><img src="img/Homebtn.png" alt="Home" onMouseOver="this.src='img/HomebtnHO.png'" onMouseOut="this.src='img/Homebtn.png'" class="home"></a>
</div>


<?php

$confile = $_FILES['cmsfile']['name'][0];
$baafile = $_FILES['cmsfile']['name'][1];
$coifile = $_FILES['cmsfile']['name'][2];

$unqconfilename = uniqid('con_',TRUE);
$unqbaafilename = uniqid('baa_',TRUE);
$unqcoifilename = uniqid('coi_',TRUE);

$tempcon = explode(".",$confile);
$tempbaa = explode(".",$baafile);
$tempcoi = explode(".",$coifile);

$conext = end($tempcon);
$baaext = end($tempbaa);
$coiext = end($tempcoi);

if ($_FILES['cmsfile']['name'][0]) {$newconfilename = $unqconfilename . '.' . $conext; } ELSE {$newconfilename = NULL;}
if ($_FILES['cmsfile']['name'][1]) {$newbaafilename = $unqbaafilename . '.' . $baaext; } ELSE {$newbaafilename = NULL;}
if ($_FILES['cmsfile']['name'][2]) {$newcoifilename = $unqcoifilename . '.' . $coiext; } ELSE {$newcoifilename = NULL;}

$target_dir = 'uploads/';

$newnames = array($newconfilename,$newbaafilename,$newcoifilename);

//print_r($_FILES['cmsfile']['name']);
//echo '<br />';
//print_r($newnames);

foreach($_FILES['cmsfile']['name'] as $key => $name) {
	move_uploaded_file($_FILES['cmsfile']['tmp_name'][$key], $target_dir . $newnames[$key]);
}









?>
</body>
</html>