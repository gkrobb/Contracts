<!DOCTYPE html>

<html>
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=Edge">
	</head>
<body>
<?php
require_once ('cms_fns.php');
require_once ('forms_fns.php');


$fullname = "Robb, Greg";
$fname = trim(end(explode(',',$fullname)));
$lname = current(explode (',',$fullname));
echo "First Name =".$fname."<br/>";
echo "Last Name =".$lname;


?>



</body>
</html>