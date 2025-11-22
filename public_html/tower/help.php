<?php
require_once "../includes.php";
?>

<!DOCTYPE html>
<html>

<head>
<title>Tower Help</title>
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
		Enter the three letter identifier of the ATC tower. i.e. CMH<br/>
		You can enter the radio call that cooresponds to the  aid. ie. COLUMBUS<br/>
		CTAF and UNICOM frequencies are maintained by the airport and not the control tower.<br/>
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