<?php
require_once "../includes.php";
?>

<!DOCTYPE html>
<html>

<head>
<title>Map Help</title>
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
		Click the UpdatePlan button after making changes to your flight plan.<br/>
		Click on ClearPlan to erase the current flight plan.<br/>
		Click on the Weather button to get a weather map.<br/>
		The other dynamic buttons are for sectional maps. ie. Miami<br/>
		Select as many check boxes to the right for the map item to display.<br>
		The zoom level will affect which items will display as a far zoom will take too long to make.<br/>
		Click the GetMapItems button after making your selections.<br/>
		The ClearSelections button will remove all the selected items.<br/>
		Right Clicking on the map will bring up a group of items near the location clicked on the map.<br/>
		You can start a flight plan by doing this.<br/>
		Right clicking a next location will allow you to append a next waypoint to your plan.<br/>
		Once you have a plan made you can make edits to the plan.<br/>
		Click and drag the line to where the item is located to insert it as a waypoint.<br/>
		Double click a waypoint to delete it.<br/>
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