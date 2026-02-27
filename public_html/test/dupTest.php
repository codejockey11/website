<?php
require_once "../includes.php";
?>

<!DOCTYPE html>
<html>

<head>
<title>Duplicate Navaid Id</title>
<meta charset="UTF-8">
<link rel="shortcut icon" href="../favicon.ico">
<link rel="stylesheet" href="../base.css?v=1">
<script type="text/javascript" src="../base.js?v=1"></script>
</head>

<body>
<?php

$sql = sprintf("SELECT facilityId,city,state FROM navnavaid where type!='VOT' ORDER BY facilityId");

$navDbase = new Database();

$navDbase->ExecSql($sql);

$row = $navDbase->FetchRow();

$prev = $row["facilityId"];
$prevc = $row["city"];
$prevs = $row["state"];

$count = 0;

while($row)
{
	if ($prev === $row["facilityId"])
	{
		$count++;
	}
	else
	{
		if ($count > 1)
		{
			if (strlen($prev) > 2)
			{
				printf("%s:%s %s:%d<br/>", $prev, $prevc, $prevs, $count);
			}
		}
		
		$prev = $row["facilityId"];
		$prevc = $row["city"];
		$prevs = $row["state"];
		
		$count = 1;
	}
	
	$row = $navDbase->FetchRow();
}

if ($count > 1)
{
	printf("%s:%d<br/>", $prev, $count);
}

$navDbase->Disconnect();

?>
</body>
</html>