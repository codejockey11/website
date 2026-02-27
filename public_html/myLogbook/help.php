<?php
require_once "../includes.php";
?>

<!DOCTYPE html>
<html>

<head>
<title>My Logbook Help</title>
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
		Enter the information in the form to update your logbook.<br/>
		Electronic Code of Federal Regulations for Logbooks&nbsp;&nbsp;&nbsp;<a href="http://www.ecfr.gov/cgi-bin/text-idx?node=pt14.1.61#se14.2.61_151">eCFR Logbooks</a><br/>
		Enter Flight Date and time as YYYY/MM/DD 24 hour time.  ie. 2017/02/16 15:36<br/>
		All flight times should be entered in total minutes of flight. ie. an hour is 60<br/>
		Click the Date Time link in the log entries list to edit the log entry.<br/>
		Use the print button to generate a printer friendly version of your log book.<br/>
		Goggles is the time Night Vision Goggles were worn during flight.<br/>
		Print will print your logbook from the earliest date to the most recent.<br/>
		You only need to physically print the last page and the total page.<br/>
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