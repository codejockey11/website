<?php
require_once "../includes.php";
?>

<!DOCTYPE html>
<html>

<head>
<title>My Flight Plan Printable</title>
<meta charset="UTF-8">
<link rel="shortcut icon" href="../favicon.ico">
<link rel="stylesheet" href="../base.css?v=1">
<script type="text/javascript" src="../base.js?v=1"></script>
</head>

<body>

<?php
if ($sess->waypoints)
{
	$fpf = new FlightPlanFormatter($sess);

	printf("%s", $fpf->FormatPlan());
}
?>

<script>print(document)</script>

</body>
</html>