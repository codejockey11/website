<?php
require_once "../includes.php";
?>

<!DOCTYPE html>
<html>

<head>
<title>Airport Help</title>
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
		Enter the identifier of the airport as the ICAO or the 3 letter identifier.  i.e. KPIT or PIT<br/>
		You can enter the airport name and receive a list of similarly named airports. CLERMONT<br/>
		You can enter a combination of city and state or city or state to receive a list of airports by location.  i.e. New York or NY or New York, NY<br/>
		Clicking the Facility's link will view the airport after receiving the list.<br/>
		Nearby will create a list of facilities that is a 30 minute radius latitude longitude from the viewed facility.  Nearby is about the size of a class B airspace.<br/>
		The magnetic variation value is calculated every 28 day cycle.&nbsp;&nbsp;<a href="<?php echo $p->value1; ?>" target="_blank">Magnetic Variation</a><br/>
		Gradient is measured from the lower end runway to the higher end.<br/>
		If you have a flightplan active you can insert the viewed airport into the plan.  Just select the point and click Add and the airport will insert after that waypoint.
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