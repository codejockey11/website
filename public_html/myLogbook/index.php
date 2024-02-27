<?php
require_once "../includes.php";

if ($sess->loggedOn == null)
{
	printf("<script>window.location='../planner/index.php?id=%s'</script>\r\n", $sess->sessionId);
}

if (isset($_POST["print"]))
{
	printf("<script>window.location='../myLogbook/print.php?id=%s'</script>\r\n", $sess->sessionId);
}

if (isset($_POST["flightDateTime"]))
{
	$flightDateTime = trim(strtoupper($_POST["flightDateTime"]));
}
else
{
	$flightDateTime = null;
}

if (isset($_POST["departArrive"]))
{
	$departArrive = trim(strtoupper($_POST["departArrive"]));
}
else
{
	$departArrive = null;
}

if (isset($_POST["planeType"]))
{
	$planeType = trim(strtoupper($_POST["planeType"]));
}
else
{
	$planeType = null;
}

if (isset($_POST["registration"]))
{
	$registration = trim(strtoupper($_POST["registration"]));
}
else
{
	$registration = null;
}

if (isset($_POST["vfrTime"]))
{
	$vfrTime = trim(strtoupper($_POST["vfrTime"]));
}
else
{
	$vfrTime = null;
}

if (isset($_POST["ifrTime"]))
{
	$ifrTime = trim(strtoupper($_POST["ifrTime"]));
}
else
{
	$ifrTime = null;
}

if (isset($_POST["lessonTime"]))
{
	$lessonTime = trim(strtoupper($_POST["lessonTime"]));
}
else
{
	$lessonTime = null;
}

if (isset($_POST["simLocation"]))
{
	$simLocation = trim($_POST["simLocation"]);
}
else
{
	$simLocation = null;
}

if (isset($_POST["safetyPilot"]))
{
	$safetyPilot = trim($_POST["safetyPilot"]);
}
else
{
	$safetyPilot = null;
}

if (isset($_POST["experienceSelect"]))
{
	$experienceType = trim(strtoupper($_POST["experienceSelect"]));
}
else
{
	$experienceType = null;
}

if (isset($_POST["conditionsSelect"]))
{
	$conditionsType = trim(strtoupper($_POST["conditionsSelect"]));
}
else
{
	$conditionsType = null;
}

if (isset($_POST["landings"]))
{
	$landings = trim(strtoupper($_POST["landings"]));
}
else
{
	$landings = null;
}

if (isset($_POST["simulationSelect"]))
{
	$simulationType = trim(strtoupper($_POST["simulationSelect"]));
}
else
{
	$simulationType = null;
}

if (isset($_POST["simulatorType"]))
{
	$simulatorType = trim($_POST["simulatorType"]);
}
else
{
	$simulatorType = null;
}

if (isset($_POST["goggleTime"]))
{
	$goggleTime = trim(strtoupper($_POST["goggleTime"]));
}
else
{
	$goggleTime = null;
}

if (isset($_POST["gogglesSelect"]))
{
	$gogglesType = trim(strtoupper($_POST["gogglesSelect"]));
}
else
{
	$gogglesType = null;
}

if (isset($_POST["remarks"]))
{
	$remarks = trim($_POST["remarks"]);
}
else
{
	$remarks = null;
}

if (isset($_GET["fdt"]))
{
	$fdt = $_GET["fdt"];

	$lb = new Logbook($sess, $fdt, null);

	if ($lbk = $lb->GetSingle(0))
	{
		$pilotId = $lbk->pilotId;
		$flightDateTime = $lbk->flightDateTime;
		$departArrive = $lbk->departArrive;
		$planeType = $lbk->planeType;
		$registration = $lbk->registration;
		$vfrTime = $lbk->vfrTime;
		$ifrTime = $lbk->ifrTime;
		$lessonTime = $lbk->lessonTime;
		$simLocation = $lbk->simLocation;
		$safetyPilot = $lbk->safetyPilot;
		$experienceType = $lbk->experienceType;
		$conditionsType = $lbk->conditionsType;
		$landings = $lbk->landings;
		$simulationType = $lbk->simulationType;
		$simulatorType = $lbk->simulatorType;
		$goggleTime = $lbk->goggleTime;
		$gogglesType = $lbk->gogglesType;
		$remarks = $lbk->remarks;
	}

	unset($_GET["fdt"]);
}

$valid = true;

$errorMsg = array();

if (isset($_POST["save"]))
{
	if ($flightDateTime == null)
	{
		array_push($errorMsg, 'Date and Time is required');

		$valid = false;
	}

	if ($planeType == null)
	{
		array_push($errorMsg, 'Plane Type is required');

		$valid = false;
	}

	if (($vfrTime == null) && ($ifrTime == null) && ($lessonTime == null) && ($goggleTime == null))
	{
		array_push($errorMsg, 'Enter Time for type of flight');

		$valid = false;
	}

	if ($valid)
	{
		$lb = new Logbook($sess, $flightDateTime, null);

		if ($lbk = $lb->GetSingle(0))
		{
			$lb->UpdateLogEntry($sess->pilotId, $flightDateTime, $departArrive, $planeType, $registration, $vfrTime, $ifrTime, $lessonTime, $simLocation, $safetyPilot, $experienceType, $conditionsType, $landings, $simulationType, $simulatorType, $goggleTime, $gogglesType, $remarks);
		}
		else
		{
			$lb->AddLogEntry($sess->pilotId, $flightDateTime, $departArrive, $planeType, $registration, $vfrTime, $ifrTime, $lessonTime, $simLocation, $safetyPilot, $experienceType, $conditionsType, $landings, $simulationType, $simulatorType, $goggleTime, $gogglesType, $remarks);
		}
	}
}

if (isset($_POST["delete"]))
{
	$lb = new Logbook($sess, $flightDateTime, null);

	if ($lbk = $lb->GetSingle(0))
	{
		$lb->DeleteLogEntry($sess->pilotId, $flightDateTime);
	}
}
?>
<!DOCTYPE html>
<html>

<head>
<title>My Logbook</title>
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

<table class="mainForm"><tr><td>
	<form id="mainForm" method="post" action="<?php printf("index.php?id=%s", $sess->sessionId);?>" >
	<table>
		<tr>
			<td class="centerLabel"><br/>Date Time</td>
			<td class="centerLabel"><br/>Depart Arrive</td>
			<td class="centerLabel"><br/>Plane Type</td>
			<td class="centerLabel"><br/>Registration</td>
			<td class="centerLabel">Time<br/>VFR</td>
			<td class="centerLabel"><br/>IFR</td>
			<td class="centerLabel"><br/>Lesson</td>
			<td class="centerLabel">Flight<br/>Conditions</td>
			<td class="centerLabel"><br/>Landings</td>
			<td class="centerLabel"><br/>Safety Pilot</td>
			<td class="centerLabel">Time<br/>Goggles</td>
		</tr>
		<tr>
			<td><input type="text" size="15" name="flightDateTime" value="<?php echo $flightDateTime;?>" /></td>
			<td><input type="text" size="15" name="departArrive" value="<?php echo $departArrive;?>" /></td>
			<td><input type="text" size="10" name="planeType" value="<?php echo $planeType;?>" /></td>
			<td><input type="text" size="10" name="registration" value="<?php echo $registration;?>" /></td>
			<td><input type="text" size="5" class="centerLabel" name="vfrTime" value="<?php echo $vfrTime;?>" /></td>
			<td><input type="text" size="5" class="centerLabel" name="ifrTime" value="<?php echo $ifrTime;?>" /></td>
			<td><input type="text" size="5" class="centerLabel" name="lessonTime" value="<?php echo $lessonTime;?>" /></td>
			<td>
			<select name="conditionsSelect" class="conditions" size="2">
			<option <?php if ($conditionsType == 0){printf("selected");} ?> value="0">Day</option>
			<option <?php if ($conditionsType == 1){printf("selected");} ?> value="1">Night</option>
			</select>
			</td>
			<td><input type="text" size="5" class="centerLabel" name="landings" value="<?php echo $landings;?>" /></td>
			<td><input type="text" size="20" name="safetyPilot" value="<?php echo $safetyPilot;?>" /></td>
			<td><input type="text" size="5" class="centerLabel" name="goggleTime" value="<?php echo $goggleTime;?>" /></td>
		</tr>
	</table>
	<table>
		<tr>
			<td class="centerLabel">Pilot Experience Or Training</td>
			<td class="centerLabel">Simulation Type</td>
			<td class="centerLabel">Night Vision Goggles</td>
			<td class="centerLabel">Simulator Type</td>
			<td class="centerLabel">Simulator Lesson Location</td>
		</tr>
		<tr>
			<td>
			<select name="experienceSelect" class="experience" size="4">
			<option <?php if ($experienceType == 0){printf("selected");} ?> value="0">Solo</option>
			<option <?php if ($experienceType == 1){printf("selected");} ?> value="1">Pilot In Command</option>
			<option <?php if ($experienceType == 2){printf("selected");} ?> value="2">Second In Command</option>
			<option <?php if ($experienceType == 3){printf("selected");} ?> value="3">Flight And Ground Training</option>
			<option <?php if ($experienceType == 4){printf("selected");} ?> value="4">Flight Simulator</option>
			<option <?php if ($experienceType == 5){printf("selected");} ?> value="5">Flight Training Device</option>
			<option <?php if ($experienceType == 6){printf("selected");} ?> value="6">Aviation Training Device</option>
			</select>
			</td>
			<td>
			<select name="simulationSelect" size="4">
			<option <?php if ($simulationType == 0){printf("selected");} ?> value="0">None</option>
			<option <?php if ($simulationType == 1){printf("selected");} ?> value="1">Simulated Instrument Flight</option>
			<option <?php if ($simulationType == 2){printf("selected");} ?> value="2">Flight Simulator</option>
			<option <?php if ($simulationType == 3){printf("selected");} ?> value="3">Flight Training Device</option>
			<option <?php if ($simulationType == 4){printf("selected");} ?> value="4">Aviation Training Device</option>
			</select>
			</td>
			<td>
			<select name="gogglesSelect" size="4" >
			<option <?php if ($gogglesType == 0){printf("selected");} ?> value="0">None</option>
			<option <?php if ($gogglesType == 1){printf("selected");} ?> value="1">Aircraft In Flight</option>
			<option <?php if ($gogglesType == 2){printf("selected");} ?> value="2">Flight Simulator</option>
			<option <?php if ($gogglesType == 3){printf("selected");} ?> value="3">Flight Training Device</option>
			</select>
			</td>
			<td><input type="text" size="25" name="simulatorType" value="<?php echo $simulatorType;?>" /></td>
			<td><input type="text" size="25" name="simLocation" value="<?php echo $simLocation;?>" /></td>
		</tr>
	</table>
	<table>
		<tr>
			<td class="leftLabel">Remarks</td>
		</tr>
		<tr>
			<td>
			<textarea name="remarks" class="logbookRemarks" rows="4"><?php echo $remarks;?></textarea>
			</td>
		</tr>
	</table>
	<table>
		<tr>
			<td>
			<input type="submit" value="Save" name="save" class="button" />
			<input type="submit" value="Delete" name="delete" class="button" />
			<input type="submit" value="Print" name="print" class="button" />
			</td>
		</tr>
	</table>
	</form>
</table>

<table class="pageResult">
	<tr>
		<td>
		<?php
		if (!$valid)
		{
			foreach ($errorMsg as $em)
			{
				printf("<b class=\"error\">%s</b><br/>\r\n", $em);
			}
		}

		$lb = new Logbook($sess, null, "D");

		printf("%s", $lb->ListEntries());
		?>
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