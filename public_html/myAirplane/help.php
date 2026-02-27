<?php
require_once "../includes.php";
?>

<!DOCTYPE html>
<html>

<head>
<title>My Airplane Help</title>
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
		Enter the information in the form to create an entry for your airplane.<br/>
		You can enter more than one airplane.  Just click Save to save the current plane.<br/>
		You will receive a list of airplanes if you have entered more than one plane.<br/>
		Use the equipment list to select your airplane's equipment.<br/>
		Taxi Depart, Climb, Enroute, Descent, Trafic Pattern, Taxi Arrive are entered as minutes,gallons.<br/>
		The Hobbs counter is the total operating airframe time for the airplane.<br/>
		Tach is for the total amount of time the engine has been operating.<br/>
		The text area beside the CG calculation is for any notes about your airplane.<br/>
		If "available weight" is negative then you need to remove some weight from the plane.<br/>
		You can upload your own checklists in ay of these formats:html, pdf, jpg, gif, png.  Currently disabled.<br/>
		The checklist file size must be 200K or smaller.<br/>
		Use the Select Checklist button to open a file dialog so that you can select the checklist to upload.<br/>
		After you select your checklist press the "Save Checklist" button.  If your checklist name is long it might be visually truncated.<br/>
		If there is another checklist with the same name try prefixing yours with your registration.<br/>
		If you checkmark the checkbox and then press "Delete Checklist" the checked items will be deleted.<br/>
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