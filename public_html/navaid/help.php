<?php
require_once "../includes.php";
?>

<!DOCTYPE html>
<html>

<head>
<title>Navaid Help</title>
<meta charset="UTF-8">
<link rel="shortcut icon" href="../favicon.ico">
<link rel="stylesheet" href="../base.css?v=1">
<script type="text/javascript" src="../base.js?v=1"></script>
</head>

<body>

<table class="topPanel">
	<tr>
		<td><?php require_once "../navSignOn.php";?></td>
	</tr>
</table>

<table class="pageResult">
	<tr>
		<td>
		<p>
		Enter the two or three letter identifier of the navagational aid. i.e. APE HEH BU<br/>
		You can enter the name that cooresponds to the navagational aid. ie. APPLETON<br/>
		You can enter the frequency that cooresponds to the navagational aid. ie. 116.80 or 391<br/>
		Decimal frequencies have only two decimal places.<br/>
		If you have a flightplan active you can insert the viewed navaid into the plan. Just select the point and click Add and the airport will insert after that waypoint.
		</p>
		</td>
	</tr>
</table>

<table class="footer">
	<tr>
		<td><?php $f = new Footer();?></td>
	</tr>
</table>

</body>
</html>