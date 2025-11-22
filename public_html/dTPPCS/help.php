<?php
require_once "../includes.php";
?>

<!DOCTYPE html>
<html>

<head>
<title>Plates and Chart Supplement Help</title>
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
		Enter the three character facility identifier not the ICAO to view an airport's plates.<br/>
		Enter the navaid name to view a navaid's chart supplement.<br/>
		Click the document name to view the plate.<br/>
		Click the ViewDoc button to view the plate on its own page.<br/>
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