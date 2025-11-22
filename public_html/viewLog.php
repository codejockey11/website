<?php
require_once "Utility.php";
?>

<!DOCTYPE html>
<html>

<head>
<title>View Log</title>
<meta charset="UTF-8">
<link rel="shortcut icon" href="../favicon.ico">
<link rel="stylesheet" href="../base.css?v=1">
</head>

<body>

<?php
$filename = "phpErrorLog.log";

if (file_exists($filename))
{
	$fp = fopen($filename, "r");
	
	$s = fread($fp, filesize($filename));
	
	fclose($fp);
	
	printf("<p>");
	
	varDump(false, $s);
	
	printf("</p>");
}
?>

</body>
</html>