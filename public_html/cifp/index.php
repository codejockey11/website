<?php
require_once "../includes.php";

if (isset($_POST["facilityId"]))
{
	$facilityId = trim(strtoupper($_POST["facilityId"]));
}
else
{
	$facilityId = $sess->cifpFacilityId;
}

if (isset($_POST["siapId"]))
{
	$siapId = trim(strtoupper($_POST["siapId"]));
}
else
{
	$siapId = $sess->siapId;
}

if (isset($_POST["transition"]))
{
	$transition = trim(strtoupper($_POST["transition"]));
}
else
{
	$transition = $sess->cifptransition;
}

if (isset($_POST["resetForm"]))
{
	$facilityId = null;
	$siapId = null;
	$transition = null;
}

if ($facilityId)
{
	$sql = sprintf("SELECT * FROM cifpExcluded USE INDEX(cifpExcludedICAO) WHERE ICAO='%s'", $facilityId);

	$cifpe = new CodedInstrumentFlightProcedureExcluded($sql);

	$sql = sprintf("SELECT * FROM cifp USE INDEX(cifpFacilityId) WHERE facilityId='%s'", $facilityId);

	if ($siapId)
	{
		$sql .= " AND siapId='" . $siapId . "'";
	}
	
	if ($transition)
	{
		$sql .= " AND transition='" . $transition . "'";
	}

	$cifp = new CodedInstrumentFlightProcedure($sess, $sql);
}

$sess->SetSessionVariable("cifpFacilityId", $facilityId);
$sess->SetSessionVariable("siapId", $siapId);
$sess->SetSessionVariable("cifptransition", $transition);
?>

<!DOCTYPE html>
<html>

<head>
<title>Coded Instrument Flight Procedures</title>
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

<table class="mainForm">
	<tr>
		<td>
		<form name="mainForm" method="post" action="<?php printf("index.php?id=%s", $sess->sessionId);?>" >
		<table>
			<tr>
				<td class="centerLabel">Facility Id</td>
				<td class="centerLabel">SIAP Id</td>
				<td class="centerLabel">Transition</td>
			</tr>
		<tr>
			<td><input name="facilityId" type="text" size="10" value="<?php echo $facilityId;?>" AUTOFOCUS /></td>
			<td><input name="siapId" type="text" size="10" value="<?php echo $siapId;?>" /></td>
			<td><input name="transition" type="text" size="10" value="<?php echo $transition;?>" /></td>
			<td><input type="submit" value="Get" class="button" /></td>
			<td><input type="submit" value="Reset" name="resetForm" class="button" /></td>
		</tr>
		</table>
		</form>
		</td>
	</tr>
</table>

<?php
if ($facilityId)
{
	$str  = $cifpe->ListEntries();
	
	$str .= $cifp->ListEntries();

	if ($str)
	{
		printf("<table class=\"pageResult\"><tr><td>");

		printf("%s", $str);

		printf("</td></tr></table>");
	}
}
?>

<table class="footer">
	<tr>
		<td><?php $f = new Footer();?></td>
	</tr>
</table>

</body>
</html>