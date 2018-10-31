<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=Edge">
	<title>TEST</title>
	</head>
<body>
<?php

$DRserver 	= 'DATAREPO1';
$DRdb 		= 'Livedb';

$serverName = $DRserver;
$connectionInfo = array('Database'=>$DRdb);
$conn = sqlsrv_connect( $serverName, $connectionInfo);

if( !$conn ) {
     echo "Connection could not be established.<br />";
     die( print_r( sqlsrv_errors(), true));
}else{
     return $conn;
	 echo "connected!";
}


?>
</body>
</html>