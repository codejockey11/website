<?php
require_once "../includes.php";

if (isset($_POST["waypoints"]))
{
	$waypoints = trim(strtoupper($_POST["waypoints"]));
}
else
{
	$waypoints = $sess->waypoints;
}

$waypoints = OneSpace($waypoints);

if (isset($_GET["cc"]))
{
	$waypoints = str_replace($_GET["cc"], $_GET["wps"], $waypoints);
}

$fp = new FlightPlan($sess->pilotId);

if ((isset($_POST['flightPlanSelect'])) && (isset($_POST["create"])))
{
	if ($_POST['flightPlanSelect'])
	{
		$wpr = $fp->GetFlightPlan($sess->pilotId, $_POST['flightPlanSelect']);

		$waypoints = $wpr;

		$ss = explode(' ', $_POST['flightPlanSelect']);

		$planType = $ss[2];

		$_POST['radio'] = $planType;

		$_POST["alternate1"] = $fp->plan[0]->alternate1;
		$_POST["alternate2"] = $fp->plan[0]->alternate2;
		$_POST["alternate3"] = $fp->plan[0]->alternate3;
	}
}

if (isset($_POST["altitudeSelect"]))
{
	$altitude = $_POST["altitudeSelect"];
}
else if ($sess->altitude)
{
	$altitude = $sess->altitude;
}
else
{
	$altitude = 0;
}

if (isset($_POST["airwaySelect"]))
{
	$l = $_POST["airwaySelect"];

	$airway = $l;
}
else if ($sess->airway)
{
	$airway = $sess->airway;
}
else
{
	$airway = null;
}

if (isset($_POST["radio"]))
{
	$planType = $_POST["radio"];
}
else if ($sess->planType)
{
	$planType = $sess->planType;
}
else
{
	$planType = "VFR";
}

if (isset($_POST["speed"]))
{
	$speed = trim($_POST["speed"]);
}
else if ($sess->speed > 0)
{
	$speed = $sess->speed;
}
else
{
	$speed = 120;
}

if (isset($_POST["weather"]))
{
	$weather = trim($_POST["weather"]);
}
else if ($sess->weather)
{
	$weather = $sess->weather;
}
else
{
	$weather = null;
}

if (isset($_POST["winds"]))
{
	$winds = trim($_POST["winds"]);
}
else if ($sess->winds)
{
	$winds = $sess->winds;
}
else
{
	$winds = null;
}

if (isset($_POST["alternate1"]))
{
	$alternate1 = trim(strtoupper($_POST["alternate1"]));
}
else if ($sess->alternate1)
{
	$alternate1 = $sess->alternate1;
}
else
{
	$alternate1 = null;
}

if (isset($_POST["alternate2"]))
{
	$alternate2 = trim(strtoupper($_POST["alternate2"]));
}
else if ($sess->alternate2)
{
	$alternate2 = $sess->alternate2;
}
else
{
	$alternate2 = null;
}

if (isset($_POST["alternate3"]))
{
	$alternate3 = trim(strtoupper($_POST["alternate3"]));
}
else if ($sess->alternate3)
{
	$alternate3 = $sess->alternate3;
}
else
{
	$alternate3 = null;
}

if ($_POST)
{
	if (isset($_POST["comms"]))
	{
		$comms = "Y";
	}
	else
	{
		$comms = null;
	}
}
else
{
	$comms = $sess->comms;
}

if ($_POST)
{
	if (isset($_POST["rems"]))
	{
		$remarks = "Y";
	}
	else
	{
		$remarks = null;
	}
}
else
{
	$remarks = $sess->remarks;
}

if ($_POST)
{
	if (isset($_POST["rnav"]))
	{
		$rnav = "Y";
	}
	else
	{
		$rnav = null;
	}
}
else
{
	$rnav = $sess->rnav;
}

if (isset($_POST["save"]))
{
	if ($waypoints)
	{
		$fp->UpdateFlightPlan($sess->pilotId, $waypoints, $planType, $alternate1, $alternate2, $alternate3);
	}
}

if (isset($_POST["reset"]))
{
	$waypoints = null;
	$planType = "VFR";
	$speed = 120;
	$weather = null;
	$winds = null;
	$alternate1 = null;
	$alternate2 = null;
	$alternate3 = null;
	$airway = null;
	$altitude = 0;
	$comms = null;
	$remarks = null;
	$rnav = null;

	$filename = sprintf("../temp/pdfMenu_%s.html", $sess->sessionId);

	$file = fopen($filename, "wb");

	$pdfMenu = "";

	fwrite($file, $pdfMenu, strlen($pdfMenu));

	fclose($file);
}

if (isset($_POST["delete"]))
{
	if ($waypoints)
	{
		$fp->DeleteFlightPlan($sess->pilotId, $waypoints, $planType);
	}
}

$sess->SetSessionVariable("waypoints", $waypoints);
$sess->SetSessionVariable("speed", $speed);
$sess->SetSessionVariable("winds", $winds);
$sess->SetSessionVariable("alternate1", $alternate1);
$sess->SetSessionVariable("alternate2", $alternate2);
$sess->SetSessionVariable("alternate3", $alternate3);
$sess->SetSessionVariable("weather", $weather);
$sess->SetSessionVariable("airway", $airway);
$sess->SetSessionVariable("altitude", $altitude);
$sess->SetSessionVariable("planType", $planType);
$sess->SetSessionVariable("comms", $comms);
$sess->SetSessionVariable("remarks", $remarks);
$sess->SetSessionVariable("rnav", $rnav);

if (isset($_POST["print"]))
{
	printf("<script>window.location='../planner/print.php?id=%s'</script>\r\n", $sess->sessionId);
}
?>

<!DOCTYPE html>
<html>

<head>
<title>Flight Planner</title>
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
		<form id="mainForm" style="height:120px;" method="post" action="<?php printf("index.php?id=%s", $sess->sessionId);?>" >
		<table>
			<tr>
				<td class="leftLabel">Waypoints</td>
				<td class="centerLabel">Speed</td>
				<td class="centerLabel">Weather</td>
				<td class="centerLabel">Winds</td>
			</tr>
			<tr>
				<td rowspan="3"><textarea name="waypoints" AUTOFOCUS class="waypoints" spellcheck="false"><?php echo $waypoints;?></textarea></td>
				<td><input name="speed" type="text" size="5" value="<?php echo $speed;?>" /></td>
				<td><input name="weather" type="text" size="5" value="<?php echo $weather;?>" /></td>
				<td><input name="winds" type="text" size="5" value="<?php echo $winds;?>" /></td>
			</tr>
			<tr>
				<td class="centerLabel" colspan="3">Alternate Aiports</td>
			</tr>
			<tr>
				<td><input name="alternate1" type="text" size="5" value="<?php echo $alternate1;?>" /></td>
				<td><input name="alternate2" type="text" size="5" value="<?php echo $alternate2;?>" /></td>
				<td><input name="alternate3" type="text" size="5" value="<?php echo $alternate3;?>" /></td>
			</tr>
		</table>
		<table>
			<tr>
				<td><input type="submit" value="Create" name="create" class="button" />
				<input type="submit" value="Print" name="print" class="button" />
				<input type="submit" value="Reset" name="reset" class="button" />
				<?php
				if ($sess->loggedOn == 1)
				{
					printf("<input type=\"submit\" value=\"Save\" name=\"save\" class=\"button\" />\r\n");
					printf("<input type=\"submit\" value=\"Delete\" name=\"delete\" class=\"button\" /></td>\r\n");

					printf("<td>\r\n");

					printf("%s", $fp->MakeDropdown($sess->pilotId, $sess->waypoints, $planType));

					printf("</td>\r\n");

					printf("<td>\r\n");
					printf("<select name=\"altitudeSelect\">\r\n");

					$adder = 500;

					for ($e = 0;$e < 60001;$e += $adder)
					{
						if ($e > 17500)
						{
							$adder = 1000;
						}

						if ((strcmp($e, "0") == 0) && (strcmp($altitude, "0") == 0))
						{
							printf("<option selected value=\"%s\">Altitude</option>\r\n", $e);
						}
						else if (strcmp($e, "0") == 0)
						{
							printf("<option value=\"%s\">Altitude</option>\r\n", $e);
						}
						else if (strcmp($altitude, $e) == 0)
						{
							printf("<option selected value=\"%s\">%d</option>\r\n", $e, $e);
						}
						else
						{
							printf("<option value=\"%s\">%d</option>\r\n", $e, $e);
						}
					}

					printf("</select>\r\n");
					printf("</td>\r\n");


					printf("<td>\r\n");

					$pdd = new Parameter(null);

					$pdd->MakeDropdown("airwaySelect00", "airwaySelect99", $airway, "airway", null, null, null);

					printf("</td>\r\n");


					printf("<td class=\"radio\" style=\"padding-top:3px;\"><label for=\"imageIFR\">IFR</label>\r\n");

					if (strcmp($planType, "IFR") == 0)
					{
						printf("<input checked=\"checked\" type=\"radio\" name=\"radio\" value=\"IFR\" id=\"IFR\">\r\n");
						printf("<img id=\"imageIFR\" src=\"../images/radioChecked.png\" onclick=\"RadioClicked('IFR', 'mainForm', 'radio')\" /></td>\r\n");
					}
					else
					{
						printf("<input type=\"radio\" name=\"radio\" value=\"IFR\" id=\"IFR\">\r\n");
						printf("<img id=\"imageIFR\" src=\"../images/radioUnchecked.png\" onclick=\"RadioClicked('IFR', 'mainForm', 'radio')\" /></td>\r\n");
					}

					printf("<td class=\"radio\" style=\"padding-top:3px;\"><label for=\"imageVFR\">VFR</label>\r\n");

					if (strcmp($planType, "VFR") == 0)
					{
						printf("<input checked=\"checked\" type=\"radio\" name=\"radio\" value=\"VFR\" id=\"VFR\">\r\n");
						printf("<img id=\"imageVFR\" src=\"../images/radioChecked.png\" onclick=\"RadioClicked('VFR', 'mainForm', 'radio')\" /></td>\r\n");
					}
					else
					{
						printf("<input type=\"radio\" name=\"radio\" value=\"VFR\" id=\"VFR\">\r\n");
						printf("<img id=\"imageVFR\" src=\"../images/radioUnchecked.png\" onclick=\"RadioClicked('VFR', 'mainForm', 'radio')\" /></td>\r\n");
					}

					printf("<td class=\"checkbox\" style=\"padding-top:3px;\"><label for=\"imageCOM\">COM</label>\r\n");

					if ($comms)
					{
						printf("<input checked=\"checked\" type=\"checkbox\" name=\"comms\" value=\"COM\" id=\"COM\">\r\n");
						printf("<img id=\"imageCOM\" src=\"../images/checkboxChecked.png\" onclick=\"CheckboxClicked('COM')\" /></td>\r\n");
					}
					else
					{
						printf("<input type=\"checkbox\" name=\"comms\" value=\"COM\" id=\"COM\">\r\n");
						printf("<img id=\"imageCOM\" src=\"../images/checkboxUnchecked.png\" onclick=\"CheckboxClicked('COM')\" /></td>\r\n");
					}

					printf("<td class=\"checkbox\" style=\"padding-top:3px;\"><label for=\"imageREM\">REM</label>\r\n");

					if ($remarks)
					{
						printf("<input checked=\"checked\" type=\"checkbox\" name=\"rems\" value=\"REM\" id=\"REM\">\r\n");
						printf("<img id=\"imageREM\" src=\"../images/checkboxChecked.png\" onclick=\"CheckboxClicked('REM')\" /></td>\r\n");
					}
					else
					{
						printf("<input type=\"checkbox\" name=\"rems\" value=\"REM\" id=\"REM\">\r\n");
						printf("<img id=\"imageREM\" src=\"../images/checkboxUnchecked.png\" onclick=\"CheckboxClicked('REM')\" /></td>\r\n");
					}

					printf("<td class=\"checkbox\" style=\"padding-top:3px;\"><label for=\"imageNAV\">RNAV</label>\r\n");

					if ($rnav)
					{
						printf("<input checked=\"checked\" type=\"checkbox\" name=\"rnav\" value=\"NAV\" id=\"NAV\">\r\n");
						printf("<img id=\"imageNAV\" src=\"../images/checkboxChecked.png\" onclick=\"CheckboxClicked('NAV')\" /></td>\r\n");
					}
					else
					{
						printf("<input type=\"checkbox\" name=\"rnav\" value=\"NAV\" id=\"NAV\">\r\n");
						printf("<img id=\"imageNAV\" src=\"../images/checkboxUnchecked.png\" onclick=\"CheckboxClicked('NAV')\" /></td>\r\n");
					}

					printf("<td class=\"plannerLink\" style=\"padding-top:3px;\"><a href=\"../download/flightPlanFpl.php?id=%s\">fpl</a></td>\r\n", $sess->sessionId);
					printf("<td class=\"plannerLink\" style=\"padding-top:3px;\"><a href=\"../download/flightPlanGpx.php?id=%s\">gpx</a></td>\r\n", $sess->sessionId);
					printf("<td class=\"plannerLink\" style=\"padding-top:3px;\"><a href=\"../download/flightPlanFsx.php?id=%s\">fsx</a></td>\r\n", $sess->sessionId);

					$p = new Parameter("wmmLink");

					printf("<td class=\"plannerLink\" style=\"padding-top:3px;\"><a target=\"_blank\" href=\"%s\">MagVar</a></td>\r\n", $p->value1);
				}
				?>
			</tr>
		</table>
		</form>
		</td>
	</tr>
</table>

<?php
if ($waypoints)
{
	$fpf = new FlightPlanFormatter($sess);

	printf("<table class=\"pageResult\"><tr><td>");

	printf("%s", $fpf->FormatPlan());

	printf("</td></tr></table>");
}
?>

<table class="footer">
	<tr>
		<td><?php $f = new Footer();?></td>
	</tr>
</table>

</body>
</html>