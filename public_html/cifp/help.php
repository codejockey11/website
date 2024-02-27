<?php
require_once "../includes.php";
?>

<!DOCTYPE html>
<html>

<head>
<title>Coded Instrument Flight Procedures Help</title>
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
		Facility Id is the ICAO identifier of the airport.  i.e. KATL, KPIT, I43<br/>
		SIAP Id is the STAR DP or IAP<br/>
		Transition is the transition fix for the initial fix of the route.<br/>
		Turn direction for holds are after the hold leg type. R is right and L is Left. i.e. HM:R:..... or HF:R:........<br/>
		There is no need to specify all these values as you can just use the ICAO identifier and get a complete list for the airport.
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