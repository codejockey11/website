<?php
require_once "../includes.php";
?>

<!DOCTYPE html>
<html>

<head>
<title>Risk Assesment Help</title>
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
		Enter the pilot's name and the flight from and to text fields.  These text fields will populate when logged on and with an active flight plan.<br/>
		Click the check boxes to select the appropriate item for your flight.<br/>
		Press submit to calulate to risk and evaulate that amount with the diagram at the bottom.<br/>
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