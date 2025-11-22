<?php
require_once "../includes.php";
?>

<!DOCTYPE html>
<html>

<head>
<title>Preferred Routes Help</title>
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
		Enter the three letter identifier of the Departure and Arrival airports to retrieve the preferred route. i.e. ATL and DTW<br/>
		You can specify either Departure to get a complete list of routes for the departure airport or Arrival to receive a list of preferred routes for the arrival airport.<br/>
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