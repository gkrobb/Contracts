<!-- Multiple File Upload Test  -->
<?php $title = 'MFU Test'; ?>
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


<form method="post" action="mfuadd.php" enctype="multipart/form-data" id="inputform">

	<div class="filelabel">Select a Contract to upload...</div>
    <input type="file" name="cmsfile[]" id="confile" required/><br/>
	<div class="filelabel">Select a BAA to upload...</div>
	<input type="file" name="cmsfile[]" id="baafile" /><br/>
	<div class="filelabel">Select a COI to upload...</div>
	<input type="file" name="cmsfile[]" id="coifile" /><br/>
    <input type="image" src="img/submitbtn.png" value="Submit"  onMouseOver="this.src='img/submitbtnHO.png'" onMouseOut="this.src='img/submitbtn.png'"/>
</form>









</body>
</html>