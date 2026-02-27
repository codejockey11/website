<?php
require_once "../includes.php";

if ($sess->loggedOn == null)
{
	printf("<script>window.location='../planner/index.php?id=%s'</script>\r\n", $sess->sessionId);
}

if (isset($_POST["registration"]))
{
	$registration = trim(strtoupper($_POST["registration"]));
}
else
{
	$registration = $sess->registration;
}

if (isset($_GET["reg"]))
{
	$registration = $_GET["reg"];
}

$a = new Airplane($sess, $registration);

if ($pln = $a->GetSingle(0))
{
	$registration = $pln->registration;
}

$plane = null;
$cruiseSpeed = null;
$color = null;
$equip = null;
$taxiDepart = null;
$climb = null;
$enroute = null;
$descent = null;
$trafficPattern = null;
$taxiArrive = null;
$gph = null;
$emptyWeight = null;
$emptyArm = null;
$fuelGallons = null;
$fuelArm = null;
$station01Weight = null;
$station01Arm = null;
$station02Weight = null;
$station02Arm = null;
$station03Weight = null;
$station03Arm = null;
$station04Weight = null;
$station04Arm = null;
$station05Weight = null;
$station05Arm = null;
$station06Weight = null;
$station06Arm = null;
$station07Weight = null;
$station07Arm = null;
$station08Weight = null;
$station08Arm = null;
$maxGrossWeight = null;
$fuelTypeWeight = null;
$maxFuel = null;
$maxCargo = null;
$hobbs = null;
$tach = null;
$notes = null;

if (isset($_POST["plane"]))
{
	$plane = trim(strtoupper($_POST["plane"]));
}
else if ($a->airplane)
{
	$plane = $pln->plane;
}

if (isset($_POST["cruiseSpeed"]))
{
	$cruiseSpeed = trim($_POST["cruiseSpeed"]);
}
else if ($a->airplane)
{
	$cruiseSpeed = $pln->cruiseSpeed;
}

if (isset($_POST["color"]))
{
	$color = trim($_POST["color"]);
}
else if ($a->airplane)
{
	$color = $pln->color;
}

if (isset($_POST["equip"]))
{
	$equip = $_POST["equip"];
}
else if ($a->airplane)
{
	$equip = $pln->equip;
}

if (isset($_POST["equipmentSelect"]))
{
	$equip = $_POST["equipmentSelect"];
}

if (isset($_POST["taxiDepart"]))
{
	$taxiDepart = trim($_POST["taxiDepart"]);
}
else if ($a->airplane)
{
	$taxiDepart = $pln->taxiDepart;
}

if (isset($_POST["climb"]))
{
	$climb = trim($_POST["climb"]);
}
else if ($a->airplane)
{
	$climb = $pln->climb;
}

if (isset($_POST["enroute"]))
{
	$enroute = trim($_POST["enroute"]);
}
else if ($a->airplane)
{
	$enroute = $pln->enroute;
}

if (isset($_POST["descent"]))
{
	$descent = trim($_POST["descent"]);
}
else if ($a->airplane)
{
	$descent = $pln->descent;
}

if (isset($_POST["trafficPattern"]))
{
	$trafficPattern = trim($_POST["trafficPattern"]);
}
else if ($a->airplane)
{
	$trafficPattern = $pln->trafficPattern;
}

if (isset($_POST["taxiArrive"]))
{
	$taxiArrive = trim($_POST["taxiArrive"]);
}
else if ($a->airplane)
{
	$taxiArrive = $pln->taxiArrive;
}

if (isset($_POST["gph"]))
{
	$gph = trim($_POST["gph"]);
}
else if ($a->airplane)
{
	$gph = $pln->gph;
}

if (isset($_POST["emptyWeight"]))
{
	$emptyWeight = trim($_POST["emptyWeight"]);
}
else if ($a->airplane)
{
	$emptyWeight = $pln->emptyWeight;
}

if (isset($_POST["emptyArm"]))
{
	$emptyArm = trim($_POST["emptyArm"]);
}
else if ($a->airplane)
{
	$emptyArm = $pln->emptyArm;
}

if (isset($_POST["fuelGallons"]))
{
	$fuelGallons = trim($_POST["fuelGallons"]);
}
else if ($a->airplane)
{
	$fuelGallons = $pln->fuelGallons;
}

if (isset($_POST["fuelArm"]))
{
	$fuelArm = trim($_POST["fuelArm"]);
}
else if ($a->airplane)
{
	$fuelArm = $pln->fuelArm;
}

if (isset($_POST["station01Weight"]))
{
	$station01Weight = trim($_POST["station01Weight"]);
}
else if ($a->airplane)
{
	$station01Weight = $pln->station01Weight;
}

if (isset($_POST["station01Arm"]))
{
	$station01Arm = trim($_POST["station01Arm"]);
}
else if ($a->airplane)
{
	$station01Arm = $pln->station01Arm;
}

if (isset($_POST["station02Weight"]))
{
	$station02Weight = trim($_POST["station02Weight"]);
}
else if ($a->airplane)
{
	$station02Weight = $pln->station02Weight;
}

if (isset($_POST["station02Arm"]))
{
	$station02Arm = trim($_POST["station02Arm"]);
}
else if ($a->airplane)
{
	$station02Arm = $pln->station02Arm;
}

if (isset($_POST["station03Weight"]))
{
	$station03Weight = trim($_POST["station03Weight"]);
}
else if ($a->airplane)
{
	$station03Weight = $pln->station03Weight;
}

if (isset($_POST["station03Arm"]))
{
	$station03Arm = trim($_POST["station03Arm"]);
}
else if ($a->airplane)
{
	$station03Arm = $pln->station03Arm;
}

if (isset($_POST["station04Weight"]))
{
	$station04Weight = trim($_POST["station04Weight"]);
}
else if ($a->airplane)
{
	$station04Weight = $pln->station04Weight;
}

if (isset($_POST["station04Arm"]))
{
	$station04Arm = trim($_POST["station04Arm"]);
}
else if ($a->airplane)
{
	$station04Arm = $pln->station04Arm;
}

if (isset($_POST["station05Weight"]))
{
	$station05Weight = trim($_POST["station05Weight"]);
}
else if ($a->airplane)
{
	$station05Weight = $pln->station05Weight;
}

if (isset($_POST["station05Arm"]))
{
	$station05Arm = trim($_POST["station05Arm"]);
}
else if ($a->airplane)
{
	$station05Arm = $pln->station05Arm;
}

if (isset($_POST["station06Weight"]))
{
	$station06Weight = trim($_POST["station06Weight"]);
}
else if ($a->airplane)
{
	$station06Weight = $pln->station06Weight;
}

if (isset($_POST["station06Arm"]))
{
	$station06Arm = trim($_POST["station06Arm"]);
}
else if ($a->airplane)
{
	$station06Arm = $pln->station06Arm;
}

if (isset($_POST["station07Weight"]))
{
	$station07Weight = trim($_POST["station07Weight"]);
}
else if ($a->airplane)
{
	$station07Weight = $pln->station07Weight;
}

if (isset($_POST["station07Arm"]))
{
	$station07Arm = trim($_POST["station07Arm"]);
}
else if ($a->airplane)
{
	$station07Arm = $pln->station07Arm;
}

if (isset($_POST["station08Weight"]))
{
	$station08Weight = trim($_POST["station08Weight"]);
}
else if ($a->airplane)
{
	$station08Weight = $pln->station08Weight;
}

if (isset($_POST["station08Arm"]))
{
	$station08Arm = trim($_POST["station08Arm"]);
}
else if ($a->airplane)
{
	$station08Arm = $pln->station08Arm;
}

if (isset($_POST["maxGrossWeight"]))
{
	$maxGrossWeight = trim($_POST["maxGrossWeight"]);
}
else if ($a->airplane)
{
	$maxGrossWeight = $pln->maxGrossWeight;
}

if (isset($_POST["fuelTypeWeight"]))
{
	$fuelTypeWeight = trim($_POST["fuelTypeWeight"]);
}
else if ($a->airplane)
{
	$fuelTypeWeight = $pln->fuelTypeWeight;
}

if (isset($_POST["maxFuel"]))
{
	$maxFuel = trim($_POST["maxFuel"]);
}
else if ($a->airplane)
{
	$maxFuel = $pln->maxFuel;
}

if (isset($_POST["maxCargo"]))
{
	$maxCargo = trim($_POST["maxCargo"]);
}
else if ($a->airplane)
{
	$maxCargo = $pln->maxCargo;
}

if (isset($_POST["hobbs"]))
{
	$hobbs = trim($_POST["hobbs"]);
}
else if ($a->airplane)
{
	$hobbs = $pln->hobbs;
}

if (isset($_POST["tach"]))
{
	$tach = trim($_POST["tach"]);
}
else if ($a->airplane)
{
	$tach = $pln->tach;
}

if (isset($_POST["notes"]))
{
	$notes = trim($_POST["notes"]);
}
else if ($a->airplane)
{
	$notes = $pln->notes;
}

if (isset($_POST["print"]))
{
	printf("<script>window.location='../myAirplane/print.php?id=%s'</script>\r\n", $sess->sessionId);
}

if (isset($_POST["save"]))
{
	if ($sess->pilotId)
	{
		$notes = trim($notes, "");

		$a = new Airplane($sess, $registration);

		if (($a->airplane == null) && ($registration))
		{
			$a->AddAirplane($sess, $registration, $plane, $cruiseSpeed, $color, $equip, $taxiDepart, $climb, $enroute, $descent, $trafficPattern, $taxiArrive, $gph, $emptyWeight, $emptyArm, $fuelGallons, $fuelArm, $station01Weight, $station01Arm, $station02Weight, $station02Arm, $station03Weight, $station03Arm, $station04Weight, $station04Arm, $station05Weight, $station05Arm, $station06Weight, $station06Arm, $station07Weight, $station07Arm, $station08Weight, $station08Arm, $maxGrossWeight, $fuelTypeWeight, $hobbs, $tach, $maxFuel, $maxCargo, $notes);

			$a = new Airplane($sess, $registration);
		}
		else
		{
			$a->UpdateAirplane($sess, $registration, $plane, $cruiseSpeed, $color, $equip, $taxiDepart, $climb, $enroute, $descent, $trafficPattern, $taxiArrive, $gph, $emptyWeight, $emptyArm, $fuelGallons, $fuelArm, $station01Weight, $station01Arm, $station02Weight, $station02Arm, $station03Weight, $station03Arm, $station04Weight, $station04Arm, $station05Weight, $station05Arm, $station06Weight, $station06Arm, $station07Weight, $station07Arm, $station08Weight, $station08Arm, $maxGrossWeight, $fuelTypeWeight, $hobbs, $tach, $maxFuel, $maxCargo, $notes);

			$a = new Airplane($sess, $registration);
		}
	}
}

if (isset($_POST["delete"]))
{
	if (isset($_POST["registration"]))
	{
		unset($_POST["registration"]);
	}

	$a = new Airplane($sess, $registration);

	$a->DeleteAirplane($sess, $registration);

	$sess->SetSessionVariable("registration", null);
	$sess->SetSessionVariable("speed", "140");

	$registration = null;
	$plane = null;
	$cruiseSpeed = null;
	$color = null;
	$equip = null;
	$taxiDepart = null;
	$climb = null;
	$enroute = null;
	$descent = null;
	$trafficPattern = null;
	$taxiArrive = null;
	$gph = null;
	$emptyWeight = null;
	$emptyArm = null;
	$fuelGallons = null;
	$fuelArm = null;
	$station01Weight = null;
	$station01Arm = null;
	$station02Weight = null;
	$station02Arm = null;
	$station03Weight = null;
	$station03Arm = null;
	$station04Weight = null;
	$station04Arm = null;
	$station05Weight = null;
	$station05Arm = null;
	$station06Weight = null;
	$station06Arm = null;
	$station07Weight = null;
	$station07Arm = null;
	$station08Weight = null;
	$station08Arm = null;
	$maxGrossWeight = null;
	$fuelTypeWeight = null;
	$maxFuel = null;
	$maxCargo = null;
	$hobbs = null;
	$tach = null;
	$notes = null;
}

if (isset($_POST["get"]))
{
	$plane = null;
	$cruiseSpeed = null;
	$color = null;
	$equip = null;
	$taxiDepart = null;
	$climb = null;
	$enroute = null;
	$descent = null;
	$trafficPattern = null;
	$taxiArrive = null;
	$gph = null;
	$emptyWeight = null;
	$emptyArm = null;
	$fuelGallons = null;
	$fuelArm = null;
	$station01Weight = null;
	$station01Arm = null;
	$station02Weight = null;
	$station02Arm = null;
	$station03Weight = null;
	$station03Arm = null;
	$station04Weight = null;
	$station04Arm = null;
	$station05Weight = null;
	$station05Arm = null;
	$station06Weight = null;
	$station06Arm = null;
	$station07Weight = null;
	$station07Arm = null;
	$station08Weight = null;
	$station08Arm = null;
	$maxGrossWeight = null;
	$fuelTypeWeight = null;
	$maxFuel = null;
	$maxCargo = null;
	$hobbs = null;
	$tach = null;
	$notes = null;

	if ($pln = $a->GetSingle(0))
	{
		$registration = $pln->registration;
		$plane = $pln->plane;
		$cruiseSpeed = $pln->cruiseSpeed;
		$color = $pln->color;
		$equip = $pln->equip;
		$taxiDepart = $pln->taxiDepart;
		$climb = $pln->climb;
		$enroute = $pln->enroute;
		$descent = $pln->descent;
		$trafficPattern = $pln->trafficPattern;
		$gph = $pln->gph;
		$taxiArrive = $pln->taxiArrive;
		$emptyWeight = $pln->emptyWeight;
		$emptyArm = $pln->emptyArm;
		$fuelGallons = $pln->fuelGallons;
		$fuelArm = $pln->fuelArm;
		$station01Weight = $pln->station01Weight;
		$station01Arm = $pln->station01Arm;
		$station02Weight = $pln->station02Weight;
		$station02Arm = $pln->station02Arm;
		$station03Weight = $pln->station03Weight;
		$station03Arm = $pln->station03Arm;
		$station04Weight = $pln->station04Weight;
		$station04Arm = $pln->station04Arm;
		$station05Weight = $pln->station05Weight;
		$station05Arm = $pln->station05Arm;
		$station06Weight = $pln->station06Weight;
		$station06Arm = $pln->station06Arm;
		$station07Weight = $pln->station07Weight;
		$station07Arm = $pln->station07Arm;
		$station08Weight = $pln->station08Weight;
		$station08Arm = $pln->station08Arm;
		$maxGrossWeight = $pln->maxGrossWeight;
		$fuelTypeWeight = $pln->fuelTypeWeight;
		$hobbs = $pln->hobbs;
		$tach = $pln->tach;
		$maxFuel = $pln->maxFuel;
		$maxCargo = $pln->maxCargo;
		$notes = $pln->notes;
	}
}

$uploadError = null;

$valid = true;

if (isset($_POST["uploadFile"]))
{
	// fileUpload is the name attribute of the type=file input tag
	// and is needed for php to obtain the filename
	$fileUpload = basename($_FILES["fileUpload"]["name"]);

	$file = explode(".", $fileUpload);

	if (count($file) == 2)
	{
		switch($file[1])
		{
			// allowable upload extensions
			case "html":
			case "jpg":
			case "png":
			case "gif":
			case "pdf":
			{
				break;
			}

			default:
			{
				$uploadError = sprintf("Checklist file types can only be: pdf, html, jpg, png, gif.");
				$valid = false;
				break;
			}
		}
	}

	switch ($_FILES['fileUpload']['error'])
	{
		case UPLOAD_ERR_OK:
		{
			break;
		}

		case UPLOAD_ERR_NO_FILE:
		{
			//throw new RuntimeException('No file sent.');
			//$uploadError = sprintf("Select a checklist to upload.");
			//$valid = false;
			break;
		}

		case UPLOAD_ERR_INI_SIZE:
		case UPLOAD_ERR_FORM_SIZE:
		{
			//throw new RuntimeException('Exceeded filesize limit.');
			$uploadError = "Filesize must be less than " . ini_get("upload_max_filesize") . ".";
			$valid = false;
			break;
		}

		default:
		{
			//throw new RuntimeException('Unknown errors.');
			break;
		}
	}

	if ($valid)
	{
		$cl = new Checklist(null, null);

		if ($cl->CheckName($fileUpload))
		{
			$uploadError = sprintf("That checklist exists.  Please rename your checklist before uploading.");

			$valid = false;
		}
		else
		{
			$target_path = "checklists/";

			$target_path = $target_path . $fileUpload;

			if (move_uploaded_file($_FILES["fileUpload"]["tmp_name"], $target_path))
			{
				$file = explode("/", $target_path);

				rename($target_path, $file[0] . "/" . $file[1]);

				$cl->AddChecklist($sess->pilotId, $registration, $file[1]);
			}
		}
	}
}

if (isset($_POST["deleteFile"]))
{
	if (isset($_POST["check"]))
	{
		$check = $_POST["check"];

		foreach ($check as $chk)
		{
			unlink("checklists/" . $chk);

			$cl = new Checklist(null, null);

			$cl->DeleteChecklist($sess->pilotId, $chk);
		}
	}
	else
	{
		$uploadError = sprintf("Checkmark a checklist(s) to delete");

		$valid = false;
	}
}

$sess->SetSessionVariable("registration", $registration);
$sess->SetSessionVariable("speed", $cruiseSpeed);
?>

<!DOCTYPE html>
<html>

<head>
<title>My Airplane</title>
<meta charset="UTF-8">
<link rel="shortcut icon" href="../favicon.ico">
<link rel="stylesheet" href="../base.css?v=1">
<script type="text/javascript" src="../base.js?v=1"></script>
</head>

<body onload="SetScrollTop('equipmentSelect',16);">

<table class="topPanel">
	<tr>
		<td><?php require_once "../navSignOn.php";?></td>
	</tr>
</table>

<table class="mainForm">
	<tr>
		<td>
		<!--  enctype="multipart/form-data" is required for input type=file -->
		<form id="mainForm" method="post" enctype="multipart/form-data" action="<?php printf("index.php?id=%s", $sess->sessionId);?>">
		<table>
			<tr>
				<!-- left 2 columns -->
				<td>
				<table>
				<tr>
					<td class="rightLabel">Registration</td>
					<td><input name="registration" type="text" size="10" value="<?php echo $registration;?>" <?php if ($registration == null) {printf("AUTOFOCUS");}?> /></td>
					<td class="rightLabel">Plane</td>
					<td>
					<input name="plane" id="plane" type="text" size="10" onclick="ToggleDropdownVisibility('aircraftDropdown');" value="<?php echo $plane;?>" readonly />
					<?php
					$sql = sprintf("SELECT * FROM aircraft WHERE model='%s'", $plane);

					$acft = new Aircraft($sql);

					if ($acft->aircraft)
					{
						$a = $acft->GetSingle(0);

						$p = new Parameter("tcds");

						//printf("&nbsp;<a id=\"tcds\" target=\"_blank\" href=\"%s%s\">%s</a>\r\n", $p->value1, $a->TCDS, $a->TCDS);
						printf("&nbsp;<a id=\"tcds\" target=\"_blank\" href=\"%s\">%s</a>\r\n", $p->value1, $a->TCDS);
					}
					?>
					</td>
				</tr>
				<tr>
					<td class="rightLabel">Cruise Speed</td>
					<td><input name="cruiseSpeed" type="text" size="10" value="<?php echo $cruiseSpeed;?>" /></td>
					<td class="rightLabel">Color</td>
					<td><input name="color" type="text" size="15" value="<?php echo $color;?>" /></td>
				</tr>
				<tr>
					<td class="rightLabel">Equipment</td>
					<td><input name="equip" type="text" size="10" value="<?php echo $equip;?>" /></td>
					<td class="rightLabel">Fuel Weight</td>
					<td><input name="fuelTypeWeight" type="text" size="10" value="<?php echo $fuelTypeWeight;?>" /></td>
				</tr>
				<tr>
					<td class="rightLabel">Taxi Depart</td>
					<td><input name="taxiDepart" type="text" size="10" value="<?php echo $taxiDepart;?>" /></td>
					<td class="rightLabel">Max Gross</td>
					<td><input name="maxGrossWeight" type="text" size="10" value="<?php echo $maxGrossWeight;?>" /></td>
				</tr>
				<tr>
					<td class="rightLabel">Climb</td>
					<td><input name="climb" type="text" size="10" value="<?php echo $climb;?>" /></td>
					<td class="rightLabel">Max Fuel</td>
					<td><input name="maxFuel" type="text" size="10" value="<?php echo $maxFuel;?>" /></td>
				</tr>
				<tr>
					<td class="rightLabel">Enroute</td>
					<td><input name="enroute" type="text" size="10" value="<?php echo $enroute;?>"  <?php if ($registration != null) {printf("AUTOFOCUS");} ?> /></td>
					<td class="rightLabel">Max Cargo</td>
					<td><input name="maxCargo" type="text" size="10" value="<?php echo $maxCargo;?>" /></td>
				</tr>
				<tr>
					<td class="rightLabel">Descent</td>
					<td><input name="descent" type="text" size="10" value="<?php echo $descent;?>" /></td>
					<td class="rightLabel">Hobbs</td>
					<td><input name="hobbs" type="text" size="10" value="<?php echo $hobbs;?>" /></td>
				</tr>
				<tr>
					<td class="rightLabel">Traffic Pattern</td>
					<td><input name="trafficPattern" type="text" size="10" value="<?php echo $trafficPattern;?>" /></td>
					<td class="rightLabel">Tach</td>
					<td><input name="tach" type="text" size="10" value="<?php echo $tach;?>" /></td>
				</tr>
				<tr>
					<td class="rightLabel">Taxi Arrive</td>
					<td><input name="taxiArrive" type="text" size="10" value="<?php echo $taxiArrive;?>" /></td>
					<td class="rightLabel">GPH</td>
					<td><input name="gph" type="text" size="10" value="<?php echo $gph;?>" /></td>
				</tr>
				<tr>
					<td class="rightLabel">Empty Weight</td>
					<td><input name="emptyWeight" type="text" size="10" value="<?php echo $emptyWeight;?>" /></td>
					<td class="rightLabel">Empty Arm</td>
					<td><input name="emptyArm" type="text" size="10" value="<?php echo $emptyArm;?>" /></td>
				</tr>
				<tr>
					<td class="rightLabel">Fuel Gallons</td>
					<td><input name="fuelGallons" type="text" size="10" value="<?php echo $fuelGallons;?>" /></td>
					<td class="rightLabel">Fuel Arm</td>
					<td><input name="fuelArm" type="text" size="10" value="<?php echo $fuelArm;?>" /></td>
				</tr>
				<tr>
					<td class="rightLabel">Station 1 Weight</td>
					<td><input name="station01Weight" type="text" size="10" value="<?php echo $station01Weight;?>" /></td>
					<td class="rightLabel">Station 1 Arm</td>
					<td><input name="station01Arm" type="text" size="10" value="<?php echo $station01Arm;?>" /></td>
				</tr>
				<tr>
					<td class="rightLabel">Station 2 Weight</td>
					<td><input name="station02Weight" type="text" size="10" value="<?php echo $station02Weight;?>" /></td>
					<td class="rightLabel">Station 2 Arm</td>
					<td><input name="station02Arm" type="text" size="10" value="<?php echo $station02Arm;?>" /></td>
				</tr>
				<tr>
					<td class="rightLabel">Station 3 Weight</td>
					<td><input name="station03Weight" type="text" size="10" value="<?php echo $station03Weight;?>" /></td>
					<td class="rightLabel">Station 3 Arm</td>
					<td><input name="station03Arm" type="text" size="10" value="<?php echo $station03Arm;?>" /></td>
				</tr>
				<tr>
					<td class="rightLabel">Station 4 Weight</td>
					<td><input name="station04Weight" type="text" size="10" value="<?php echo $station04Weight;?>" /></td>
					<td class="rightLabel">Station 4 Arm</td>
					<td><input name="station04Arm" type="text" size="10" value="<?php echo $station04Arm;?>" /></td>
				</tr>
				<tr>
					<td class="rightLabel">Station 5 Weight</td>
					<td><input name="station05Weight" type="text" size="10" value="<?php echo $station05Weight;?>" /></td>
					<td class="rightLabel">Station 5 Arm</td>
					<td><input name="station05Arm" type="text" size="10" value="<?php echo $station05Arm;?>" /></td>
				</tr>
				<tr>
					<td class="rightLabel">Station 6 Weight</td>
					<td><input name="station06Weight" type="text" size="10" value="<?php echo $station06Weight;?>" /></td>
					<td class="rightLabel">Station 6 Arm</td>
					<td><input name="station06Arm" type="text" size="10" value="<?php echo $station06Arm;?>" /></td>
				</tr>
					<td class="rightLabel">Station 7 Weight</td>
					<td><input name="station07Weight" type="text" size="10" value="<?php echo $station07Weight;?>" /></td>
					<td class="rightLabel">Station 7 Arm</td>
					<td><input name="station07Arm" type="text" size="10" value="<?php echo $station07Arm;?>" /></td>
				</tr>
				<tr>
					<td class="rightLabel">Station 8 Weight</td>
					<td><input name="station08Weight" type="text" size="10" value="<?php echo $station08Weight;?>" /></td>
					<td class="rightLabel">Station 8 Arm</td>
					<td><input name="station08Arm" type="text" size="10" value="<?php echo $station08Arm;?>" /></td>
				</tr>
				<!-- plane list -->
				<tr>
					<td class="planeList" colspan="4">
					<?php
					$a = new Airplane($sess, null);

					printf("%s", $a->ListEntries());
					?>
					</td>
				</tr>
				<tr>
					<td colspan="4">
					<input type="submit" value="Get" name="get" class="button" />
					<input type="submit" value="Save" name="save" class="button" />
					<input type="submit" value="Delete" name="delete" class="button" />
					<input type="submit" value="Print" name="print" class="button" />
					</td>
				</tr>
			</table>
			</td>
			<!-- end of left 2 columns -->

			<!-- right 2 columns -->
			<td>
			<table>
				<tr>
					<td class="equipment">
					<?php
					$pdd = new Parameter(null);

					$pdd->MakeDropdown("equip00", "equip99", $equip, "equipment", "20", "A", $pdd->value1);
					?>
					</td>
					<td rowspan="2">
					<textarea name="notes" class="notes" style="height:600px;"><?php echo $notes;?></textarea>
					</td>
				</tr>
				<tr>
					<td>
					<textarea name="cgTextArea" readonly="readonly" class="cgTextarea" style="height:268px;">
					<?php
					if ($pln = $a->GetSingle(0))
					{
						printf("%s", str_replace("\r\n<br/>", "\r\n", $pln->FormatCG()));
					}
					?>
					</textarea>
					</td>
				</tr>
			</table>

			<table>
				<tr>
					<td class="checklist">
					<?php
					$cl = new Checklist($sess->pilotId, $registration);

					printf("%s", $cl->ListEntries());
					?>
					</td>
				</tr>
			</table>

			<table>
				<tr>
					<td>
					<table>
						<tr>
							<td class="fileUpload">
							<!-- using a label connected to the input type file for jscript button effects -->
							<label for="fileUpload">Select Checklist</label>
							
							<!-- type=file needs a name attribute to function with php -->
							<input id="fileUpload" name="fileUpload" type="file" />
							</td>
							
							<!-- Not allowing items to be uploaded at this time -->
							<!-- <td class="leftLabel"><input type="submit" value="Save Checklist" name="uploadFile" class="button120px" /></td> -->
							
							<td class="leftLabel"><input type="submit" value="Delete Checklist" name="deleteFile" class="button120px" /></td>
						</tr>
					</table>
					</td>
				</tr>
				<tr>
					<td colspan="3" class="fileUploadError" id="fileUploadError"><?php echo $uploadError; ?></td>
				</tr>
			</table>

			<script type="text/javascript">ShowUpload();</script>

			<!-- end of right 2 columns -->
			</td>
		</tr>
		</table>
		</form>
		</td>
	</tr>
</table>

<table class="footer">
	<tr>
		<td><?php $f = new Footer();?></td>
	</tr>
</table>

<!-- Airplane List Dropdown is defined here since it is not associated with the actual page -->
<div id="aircraftDropdown" class="aircraftDropdown">
	<table>
		<tr>
			<?php
			$holder = "328 Support Services GmbH";

			if (isset($_POST["holderSelect"]))
			{
				$holder = $_POST["holderSelect"];
			}

			$model = "Model";

			if (isset($_POST["modelSelect"]))
			{
				$model = $_POST["modelSelect"];
			}

			$sql = sprintf("SELECT * FROM aircraft WHERE holder='%s'", $holder);

			$aircraft = new Aircraft($sql);

			printf("%s", $aircraft->LoadHolders());

			printf("<td>%s</td>", $aircraft->HolderDropdown($holder));

			printf("%s", $aircraft->LoadModels($holder));

			printf("<td>%s</td>", $aircraft->ModelDropdown($model));

			printf("<td class=\"leftMidLabel\"><button id=\"closeAircraft\" name=\"closeAircraft\" class=\"smallButton\" onclick=\"ToggleDropdownVisibility('aircraftDropdown');\">Close</button></td>");

			if ($aircraft->foundModel == false)
			{
				$model = null;
			}
			?>
		</tr>
	</table>
<div>

<script type="text/javascript">
//==========================================================================================
// Airplane Dropdown
//==========================================================================================
var modelSelect = document.getElementById('modelSelect');

modelSelect.addEventListener('change', (event) =>
{
	var text = document.getElementById('plane');

	text.value = modelSelect.options[modelSelect.selectedIndex].value;
});
//==========================================================================================
function HandleHttpRequestModels()
{
	if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
	{
		var parser = new DOMParser();

		var xmlDoc = parser.parseFromString(xmlhttp.responseText, 'text/xml');

		switch (xmlDoc.getElementsByTagName('result')[0].getAttribute('type'))
		{
			case 'models':
			{
				var select = document.getElementById('modelSelect');

				ClearSelect(select);

				var opt = document.createElement('option');

				opt.value = null;

				opt.innerHTML = 'Model';

				var model = xmlDoc.getElementsByTagName('model');

				select.appendChild(opt);

				for (var i=0;i < model.length;i++)
				{
					var opt = document.createElement('option');

					opt.value = model[i].getElementsByTagName('name')[0].childNodes[0].nodeValue;

					opt.innerHTML = model[i].getElementsByTagName('name')[0].childNodes[0].nodeValue;

					select.appendChild(opt);
				}

				break;
			}

			default:
			{
				break;
			}
		}
	}
}
//==========================================================================================
function DoHttpRequestModels()
{
	xmlhttp = new XMLHttpRequest();

	xmlhttp.onreadystatechange = HandleHttpRequestModels;

	var holder = document.getElementById('holderSelect');

<?php
printf("	xmlhttp.open('POST', '../xmlFormatters/getModels.php?holder=' + URLSpecialChars(holder.options[holder.selectedIndex].text) + '&id=%s', true);\r\n", $sess->sessionId);
?>
	xmlhttp.send();
}
//==========================================================================================
</script>

</body>
</html>