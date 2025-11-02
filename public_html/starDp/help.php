<?php
require_once "../includes.php";
?>

<!DOCTYPE html>
<html>

<head>
<title>STAR DP Help</title>
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
		It helps to know what the facility is using as its arrival or departure so the procedure is easier to identify in the list.<br/>
		The leftmost variable is used so if Ident is filled and Transition is filled Ident is what is retrieved.<br/>
		The short name will return the STARs and DPs for those procedures. i.e. BANNG2<br/>
		Ident will return the procedures associated with that navaid or fix identifier. i.e. ATL or BANNG<br/>
		Transition will retrieve a list of procedures to choose from. i.e. BANNG TWO<br/>
		Computer Code is used to retrieve the exact FAA named procedure. i.e. BANNG2.BANNG<br/>
		Facility is a search for an airport's procedures. i.e. ORD<br/>
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