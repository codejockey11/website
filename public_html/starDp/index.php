<?php
require_once "../includes.php";

if (isset($_POST["shortName"]))
{
	$shortName = trim(strtoupper($_POST["shortName"]));
}
else
{
	$shortName = $sess->shortName;
}

if (isset($_POST["ident"]))
{
	$ident = trim(strtoupper($_POST["ident"]));
}
else
{
	$ident = $sess->ident;
}

if (isset($_POST["transition"]))
{
	$transition = trim(strtoupper($_POST["transition"]));
}
else
{
	$transition = $sess->transition;
}

if (isset($_POST["computerCode"]))
{
	$computerCode = trim(strtoupper($_POST["computerCode"]));
}
else
{
	$computerCode = $sess->computerCode;
}

if (isset($_POST["starDpFacilityId"]))
{
	$starDpFacilityId = trim(strtoupper($_POST["starDpFacilityId"]));
}
else
{
	$starDpFacilityId = $sess->starDpFacilityId;
}

if (strlen($starDpFacilityId) > 3)
{
	$ap = str_split($starDpFacilityId);
	
	$starDpFacilityId = $ap[1] . $ap[2] . $ap[3];
}

if (isset($_GET["shortName"]))
{
	$shortName = $_GET["shortName"];

	$ident = null;
	$transition = null;
	$computerCode = null;
	$starDpFacilityId = null;
}

$wp = null;
if (isset($_GET["wp"]))
{
	$wp = $_GET["wp"];

	$shortName = null;
	$ident = null;
	$transition = null;
	$computerCode = null;
	$starDpFacilityId = null;
}

if (isset($_POST["resetForm"]))
{
	$shortName = null;
	$ident = null;
	$transition = null;
	$computerCode = null;
	$starDpFacilityId = null;
}

$sess->SetSessionVariable("shortName", $shortName);
$sess->SetSessionVariable("ident", $ident);
$sess->SetSessionVariable("transition", $transition);
$sess->SetSessionVariable("computerCode", $computerCode);
$sess->SetSessionVariable("starDpFacilityId", $starDpFacilityId);
?>

<!DOCTYPE html>
<html>

<head>
<title>Terminal Arrival Departure Procedure</title>
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
		<form id="mainForm" method="post" action="<?php printf("index.php?id=%s", $sess->sessionId);?>">
		<table>
			<tr>
				<td class="centerLabel">Short Name</td>
				<td class="centerLabel">Ident</td>
				<td class="centerLabel">Transition</td>
				<td class="centerLabel">Computer Code</td>
				<td class="centerLabel">Facility</td>
			</tr>
			<tr>
				<td><input name="shortName" type="text" size="10" value="<?php echo $shortName;?>" AUTOFOCUS /></td>
				<td><input name="ident" type="text" size="5" value="<?php echo $ident;?>" /></td>
				<td><input name="transition" type="text" size="30" value="<?php echo $transition;?>" /></td>
				<td><input name="computerCode" type="text" size="15" value="<?php echo $computerCode;?>" /></td>
				<td><input name="starDpFacilityId" type="text" size="10" value="<?php echo $starDpFacilityId;?>" /></td>
				<td><input type="submit" value="Get" class="button" /></td>
				<td><input type="submit" value="Reset" name="resetForm" class="button" /></td>
			</tr>
		</table>
		</form>
		</td>
	</tr>
</table>

<?php
if (($shortName) || ($ident) || ($computerCode) || ($starDpFacilityId) || ($transition) || ($wp))
{
	if ($shortName)
	{
		$sql = sprintf("SELECT * FROM starDp USE INDEX(starDpShortname) WHERE shortName='%s' ORDER BY type, shortname, computerCode ASC", $shortName);
	}

	if ($ident)
	{
		$sql = sprintf("SELECT * FROM starDp USE INDEX(starDpIdent) WHERE ident='%s' ORDER BY type, shortname, computerCode ASC", $ident);
	}

	if ($transition)
	{
		$sql = sprintf("SELECT * FROM starDp USE INDEX(starDpTransition) WHERE transition LIKE '%%%s%%' ORDER BY type, shortname, computerCode ASC", $transition);
	}

	if ($computerCode)
	{
		$sql = sprintf("SELECT * FROM starDp USE INDEX(starDpComputerCode) WHERE computerCode='%s' ORDER BY type, shortname, computerCode ASC", $computerCode);
	}

	if ($starDpFacilityId)
	{
		$sql = sprintf("SELECT * FROM starDp USE INDEX(starDpAirports) WHERE airports LIKE '%%%s%%' ORDER BY type, shortname, computerCode ASC", $starDpFacilityId);
	}

	if ($wp)
	{
		$sql = sprintf("SELECT * FROM starDp USE INDEX(starDpWaypoints) WHERE waypoints LIKE '%%%s%%'", $wp);
	}
	
	$sdp = new StarDp($sess, $sql);

	if ($sdp->starDp)
	{
		printf("<table class=\"pageResult\"><tr><td>");

		printf("%s", $sdp->ListEntries());

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