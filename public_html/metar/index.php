<?php
require_once "../includes.php";

if (isset($_POST["station"]))
{
	$station = trim(strtoupper($_POST["station"]));
}
else
{
	$station = $sess->station;
}

if ((strlen($station) < 4) && (strlen($station) > 0))
{
	$station = "K" . $station;
}

if (isset($_POST["resetForm"]))
{
	$station = null;
}

$sess->SetSessionVariable("station", $station);

$s = new Station($station);
?>

<!DOCTYPE html>
<html>

<head>
<title>Weather Station</title>
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
				<td class="centerLabel">Station ID</td>
			</tr>
			<tr>
				<td><input name="station" type="text" size="10" value="<?php echo $station;?>" AUTOFOCUS /></td>
				<td><input type="submit" value="Get" class="button" /></td>
				<td><input type="submit" value="Reset" name="resetForm" class="button" /></td>
				<td class="leftMidLabel"><a href="https://aviationweather.gov/data/windtemp/?region=all" target="_blank">Winds Aloft</a>
				&nbsp;<a href="https://aviationweather.gov/gfa/#afd" target="_blank">Area Forecast</a>
				&nbsp;<a href="http://radar.weather.gov" target="_blank">Radar</a>
				&nbsp;<a href="https://aviationweather.gov/graphics/" target="_blank">Prog Charts</a>
				&nbsp;<a href="http://www.spc.noaa.gov" target="_blank">Storm Prediction Center</a>
				<?php printf("%s", $s->NWSLink());?>
				</td>
			</tr>
		</table>
		</form>
		</td>
	</tr>
</table>

<?php
if ($s->metar)
{
	printf("<table class=\"pageResult\"><tr><td>");

	printf("<table class=\"remarks\"><tr><td>\r\n");

	printf("%s", $s->StationInfo());

	$c = str_split($station);

	$sql = sprintf("SELECT * FROM awosStation USE INDEX(awosStationSensorId) WHERE sensorid='%s'", $c[1] . $c[2] . $c[3]);

	$awos = new Awos($sql);

	printf("%s<br/>", $awos->ListEntries());

	$twr = new Tower($sess, $c[1] . $c[2] . $c[3]);

	$ts = $twr->GetSingle(0);

	if ($ts)
	{
		for ($i = 0;$i < count($ts->towerFrequency->frequency);$i++)
		{
			$tfs = $ts->towerFrequency->GetSingle($i);

			$pos = strpos($tfs->type, "ATIS");

			if ($pos === false)
			{
			}
			else
			{
				printf("ATIS:%s<br/>", $tfs->freq);
			}
		}
	}

	printf("</td></tr></table>\r\n");

	printf("<table class=\"remarks\"><tr><td>\r\n");

	printf("%s", $s->ListEntries());

	printf("</td></tr></table>\r\n");

	$t = new TAF($station);

	printf("<table class=\"remarks\"><tr><td>\r\n");

	printf("%s", $t->ListEntries());

	printf("</td></tr></table>\r\n");

	printf("</td></tr></table>\r\n");
}
?>

<table class="footer">
	<tr>
		<td><?php $f = new Footer();?></td>
	</tr>
</table>

</body>
</html>