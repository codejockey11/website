<?php
require_once "../includes.php";
?>

<!DOCTYPE html>
<html>

<head>
<title>Fix Help</title>
<meta charset="UTF-8">
<link rel="shortcut icon" href="../favicon.ico">
<link rel="stylesheet" href="../base.css?v=1">
<script type="text/javascript" src="../base.js?v=1"></script>
</head>

<body>

<table class="topPanel">
	<tr>
		<td>
		<?php 
		require_once "../navSignOn.php";
		$p = new Parameter("magVarCalculator");
		?>
		</td>
	</tr>
</table>

<table class="pageResult">
	<tr>
		<td>
		<p>
		Enter the five letter identifier of the fix or intersection. i.e. SUNOL<br/>
		The magnetic variation value is calculated every 28 day cycle.&nbsp;&nbsp;<?php echo "<a href=\""; echo $p->value1; echo "\">"; echo $p->value2; ?></a><br/>
		If you have a flightplan active you can insert the viewed fix into the plan. Just select the point and click Add and the airport will insert after that waypoint.
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