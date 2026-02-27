<?php
require_once "../includes.php";

if (isset($_POST["airport"]))
{
	$airport = trim(strtoupper($_POST["airport"]));
}
else
{
	$airport = $sess->airport;
}

if (isset($_POST["name"]))
{
	$airportName = trim(strtoupper($_POST["name"]));
}
else
{
	$airportName = $sess->airportName;
}

if (isset($_POST["cityState"]))
{
	$cityState = trim(strtoupper($_POST["cityState"]));
}
else
{
	$cityState = $sess->cityState;
}

$nearby = null;

if (isset($_POST["nearbyForm"]))
{
	$nearby = 1;
}

if (isset($_POST["resetForm"]))
{
	$airport = null;
	$airportName = null;
	$cityState = null;
}

$key = null;

if (isset($_GET["key"]))
{
	$key = $_GET["key"];

	$airportName = null;
	$cityState = null;

	unset($_GET["key"]);
}

$a = null;
$al = null;

if (strlen($airport) == 3)
{
	$sql = sprintf("SELECT * FROM aptAirport USE INDEX(aptAirportFacilityId) WHERE facilityId='%s'", $airport);

	$a = new Airport($sess, $sql);
}
else if (strlen($airport) == 4)
{
	$sql = sprintf("SELECT * FROM aptAirport USE INDEX(aptAirportICAO) WHERE ICAO='%s'", $airport);

	$a = new Airport($sess, $sql);
}

if ($key)
{
	$sql = sprintf("SELECT * FROM aptAirport WHERE id='%s'", $key);

	$a = new Airport($sess, $sql);

	$airport = $a->GetSingle(0)->ICAO;
}
else  if (($nearby) && ($airport))
{
	if ($apt = $a->GetSingle(0))
	{
		$ll = new LatLon($apt->latLon->formattedLat, $apt->latLon->formattedLon);

		$from = $ll->Rotate(30, 30);

		$ll = new LatLon($apt->latLon->formattedLat, $apt->latLon->formattedLon);

		$to = $ll->Rotate(-30, -30);

		$sql = sprintf("SELECT a.id,a.facilityId, a.name, a.city, a.state, a.type, r.runwayId, r.length, r.width, r.surface FROM aptAirport a USE INDEX(aptAirportLatLon, aptAirportFacilityId), aptRunway r USE INDEX(aptRunwayFacilityId) WHERE a.facilityId=r.facilityId AND a.latitude>='%s' AND a.latitude<='%s' AND a.longitude>='%s' AND a.longitude<='%s'", $to->formattedLat, $from->formattedLat, $to->formattedLon, $from->formattedLon);

		$sql .= CheckHeliport($sess);

		$al = new AirportList($sess, $sql);
	}
}
else if ($cityState)
{
	$cs = explode(",", $cityState);

	if (count($cs) == 2)
	{
		$sql = sprintf("SELECT a.id,a.facilityId, a.name, a.city, a.state, a.type, r.runwayId, r.length, r.width, r.surface FROM aptAirport a USE INDEX(aptAirportStateCity, aptAirportFacilityId), aptRunway r USE INDEX(aptRunwayFacilityId) WHERE a.facilityId=r.facilityId AND a.state='%s' AND a.city='%s'", trim($cs[1]), trim($cs[0]));

		$sql .= CheckHeliport($sess);

		$al = new AirportList($sess, $sql);
	}
	else if (strlen($cs[0]) == 2)
	{
		$sql = sprintf("SELECT a.id,a.facilityId, a.name, a.city, a.state, a.type, r.runwayId, r.length, r.width, r.surface FROM aptAirport a USE INDEX(aptAirportState, aptAirportFacilityId), aptRunway r USE INDEX(aptRunwayFacilityId) WHERE a.facilityId=r.facilityId AND a.state='%s'", trim($cs[0]));

		$sql .= CheckHeliport($sess);

		$al = new AirportList($sess, $sql);
	}
	else
	{
		$sql = sprintf("SELECT a.id,a.facilityId, a.name, a.city, a.state, a.type, r.runwayId, r.length, r.width, r.surface FROM aptAirport a USE INDEX(aptAirportCity, aptAirportFacilityId), aptRunway r USE INDEX(aptRunwayFacilityId) WHERE a.facilityId=r.facilityId AND a.city LIKE '%%%s%%'", $cs[0]);

		$sql .= CheckHeliport($sess);

		$al = new AirportList($sess, $sql);
	}
}
else if ($airportName)
{
	$sql = sprintf("SELECT a.id,a.facilityId, a.name, a.city, a.state, a.type, r.runwayId, r.length, r.width, r.surface FROM aptAirport a, aptRunway r USE INDEX(aptRunwayFacilityId) WHERE a.facilityId=r.facilityId AND a.name LIKE '%%%s%%'", $airportName);

	$sql .= CheckHeliport($sess);

	$al = new AirportList($sess, $sql);
}

if ($a)
{
	UpdateWaypoint($sess, "A;" . $a->GetSingle(0)->ICAO . ";" . $a->GetSingle(0)->id);
}

$sess->SetSessionVariable("airport", $airport);
$sess->SetSessionVariable("airportName", $airportName);
$sess->SetSessionVariable("cityState", $cityState);

function CheckHeliport($sess)
{
	$sql = null;

	if ($sess->showHeliport)
	{
		$sql .= " AND a.type='HELIPORT'";
	}
	else
	{
		$sql .= " AND a.type!='HELIPORT'";
	}

	$sql .= " ORDER BY a.state,a.city,a.name ASC";

	return $sql;
}
?>

<!DOCTYPE html>
<html>

<head>
<title>Airport</title>
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
					<td class="centerLabel">Facility Ident</td>
					<td class="centerLabel">Name</td>
					<td class="centerLabel">City, State</td>
				</tr>
				<tr>
					<td><input name="airport" type="text" size="10" value="<?php echo $airport;?>" AUTOFOCUS /></td>
					<td><input name="name" type="text" size="25" value="<?php echo $airportName;?>" /></td>
					<td><input name="cityState" type="text" size="25" value="<?php echo $cityState;?>" /></td>
					<td><input type="submit" value="Get" class="button" /></td>
					<td><input type="submit" value="Nearby" name="nearbyForm" class="button" /></td>
					<td><input type="submit" value="Reset" name="resetForm" class="button" /></td>

					<?php WaypointDropdown($sess);?>
				</tr>
			</table>
			</form>
		</td>
	</tr>
</table>

<?php
if ((($nearby) && ($airport)) || ($airportName) || ($cityState))
{
	printf("<table class=\"pageResult\">");

	printf("<tr><td><table class=\"list\"");

	if ($al)
	{
		printf("%s", $al->ListEntries());
	}

	printf("</table></td></tr></table>\r\n");
}
else if ($a)
{
	$apt = $a->GetSingle(0);

	if ($apt)
	{
		printf("<table class=\"pageResult\"><tr><td>");

		printf("<table class=\"airport\"><tr>\r\n");

		printf("%s", $apt->FormatBaseInfo());

		printf("</tr></table>\r\n");

		if ($apt->tower)
		{
			if ($twr = $apt->tower->GetSingle(0))
			{
				printf("<table class=\"tower\"><tr>\r\n");

				printf("<td>\r\n");

				printf("%s", $twr->FormatBaseInfo(true));

				printf("</td>\r\n");

				printf("<td>\r\n");

				printf("%s", $twr->towerFrequency->ListEntries(true, $apt));

				printf("</td>\r\n");

				printf("<td>\r\n");

				printf("%s", $twr->towerServices->ListEntries(true));

				printf("%s", $twr->towerRadars->ListEntries(true));

				printf("</td>\r\n");

				printf("</tr></table>\r\n");

				printf("<table class=\"remarks\"><tr><td>\r\n");

				printf("%s", $twr->towerRemarks->ListEntries(true));

				printf("</td></tr></table>\r\n");
			}
			else
			{
				printf("<table><tr><td>\r\n");

				printf("%s", $apt->ListComms(true));

				printf("</td></tr></table>\r\n");
			}
		}

		if ($apt->airportRunway)
		{
			printf("<table class=\"runway\">\r\n");

			printf("%s", $apt->airportRunway->ListEntries(true));

			printf("</table>\r\n");
		}

		if ($apt->airportRemarks)
		{
			printf("<table class=\"remarks\"><tr><td>\r\n");

			printf("%s", $apt->airportRemarks->ListEntries(true));

			printf("</td></tr></table>\r\n");
		}

		printf("</td></tr></table>\r\n");
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