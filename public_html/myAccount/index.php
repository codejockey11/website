<?php
require_once "../includes.php";

if ($sess->loggedOn == null)
{
	printf("<script>window.location='../planner/index.php?id=%s'</script>\r\n", $sess->sessionId);
}

$pilotId = $sess->pilotId;

if (isset($_POST["currentPassword"]))
{
	$currentPassword = trim($_POST["currentPassword"]);
}
else
{
	$currentPassword = null;
}

if (isset($_POST["password"]))
{
	$password = trim($_POST["password"]);
}
else
{
	$password = $sess->password;
}

if (isset($_POST["retypePassword"]))
{
	$retypePassword = trim($_POST["retypePassword"]);
}
else
{
	$retypePassword = $sess->retypePassword;
}

$currentEmail = $sess->currentEmail;

if (isset($_POST["email"]))
{
	$email = trim($_POST["email"]);
}
else
{
	$email = $sess->email;
}

if (isset($_POST["retypeEmail"]))
{
	$retypeEmail = trim($_POST["retypeEmail"]);
}
else
{
	$retypeEmail = $sess->retypeEmail;
}

if (isset($_POST["firstName"]))
{
	$firstName = trim($_POST["firstName"]);
}
else
{
	$firstName = $sess->firstName;
}

if (isset($_POST["lastName"]))
{
	$lastName = trim($_POST["lastName"]);
}
else
{
	$lastName = $sess->lastName;
}

if (isset($_POST["homeBase"]))
{
	$homeBase = strtoupper(trim($_POST["homeBase"]));
}
else
{
	$homeBase = $sess->homeBase;
}

if ($_POST)
{
	if (isset($_POST["showHeliport"]))
	{
		$showHeliport = "Y";
	}
	else
	{
		$showHeliport = null;
	}
}
else
{
	$showHeliport = $sess->showHeliport;
}

if (isset($_POST["radio"]))
{
	$showFrequency = $_POST["radio"];
}
else if ($sess->showFrequency)
{
	$showFrequency = $sess->showFrequency;
}
else
{
	$showFrequency = "A";
}

$sess->SetSessionVariable("password", $password);
$sess->SetSessionVariable("retypePassword", $retypePassword);
$sess->SetSessionVariable("currentEmail", $currentEmail);
$sess->SetSessionVariable("email", $email);
$sess->SetSessionVariable("retypeEmail", $retypeEmail);
$sess->SetSessionVariable("firstName", $firstName);
$sess->SetSessionVariable("lastName", $lastName);
$sess->SetSessionVariable("homeBase", $homeBase);
$sess->SetSessionVariable("showHeliport", $showHeliport);
$sess->SetSessionVariable("showFrequency", $showFrequency);

$currentPasswordError = null;
$passwordError = null;
$retypePasswordError = null;
$emailError = null;
$retypeEmailError = null;
$firstNameError = null;
$lastNameError = null;
$homeBaseError = null;
$showHeliportError = null;
$showFrequencyError = null;
$uploadError = null;

$valid = true;

if (isset($_POST["updateAccount"]) || isset($_POST["deleteAccount"]))
{
	if ($currentPassword)
	{
		$a = new Account($sess->pilotId, $currentPassword, null);

		if ($a->pilotId == null)
		{
			$currentPasswordError = "Incorrect Current Password";

			$valid = false;
		}
	}
	else if ($currentPassword == null)
	{
		$currentPasswordError = "Enter Current Password";

		$valid = false;
	}
}

if (isset($_POST["updateAccount"]))
{
	if (($password) || ($retypePassword))
	{
		if (strcmp($password, $retypePassword) != 0)
		{
			$retypePasswordError = "New Password and Retyped Password Must Match";

			$valid = false;
		}
	}

	if (($email) || ($retypeEmail))
	{
		if ($retypeEmail == null)
		{
			$retypeEmailError = "Retype Email";

			$valid = false;
		}
		else if (strcmp($email, $retypeEmail) != 0)
		{
			$retypeEmailError = "Email and Retyped Email Must Match";

			$valid = false;
		}
	}

	if ($email > " ")
	{
		if (ValidateEmail($email) == 0)
		{
			$emailError = "Email is not in a valid format";

			$valid = false;
		}
	}

	if ($firstName == null)
	{
		$firstNameError = "Enter First Name";

		$valid = false;
	}

	if ($lastName == null)
	{
		$lastNameError = "Enter Last Name";

		$valid = false;
	}

	$homeBaseLatLon = null;

	if ($homeBase)
	{
		$sql = sprintf("SELECT * FROM aptAirport WHERE ICAO='%s'", $homeBase);

		$a = new Airport($sess, $sql);

		if ($a->airport == null)
		{
			$homeBaseError = "Home Base not found";

			$homeBaseLatLon = null;

			$valid = false;
		}
		else
		{
			$apt = $a->GetSingle(0);

			$homeBaseLatLon = sprintf("%0.6f,%0.6f", $apt->latLon->decimalLat, $apt->latLon->decimalLon);
		}
	}

	if ($valid)
	{
		if ($password == null)
		{
			$password = $currentPassword;
		}

		if ($email == null)
		{
			$email = $currentEmail;
		}

		$account = new Account($pilotId, $currentPassword, null);

		$account->UpdateAccount($pilotId, password_hash($password, PASSWORD_DEFAULT), $email, $firstName, $lastName, $homeBase, $homeBaseLatLon, $showHeliport, $showFrequency);

		$account = new Account($pilotId, $password, null);

		$sess->SetSessionVariable("password", null);
		$sess->SetSessionVariable("retypePassword", null);
		$sess->SetSessionVariable("currentEmail", $email);
		$sess->SetSessionVariable("email", null);
		$sess->SetSessionVariable("retypeEmail", null);
		$sess->SetSessionVariable("firstName", $firstName);
		$sess->SetSessionVariable("lastName", $lastName);
		$sess->SetSessionVariable("homeBase", $homeBase);
		$sess->SetSessionVariable("showHeliport", $showHeliport);
		$sess->SetSessionVariable("showFrequency", $showFrequency);
		$sess->SetSessionVariable("mapCenter", $homeBaseLatLon);
		$sess->SetSessionVariable("mapZoom", 10);

		$currentPassword = null;
		$password = null;
		$retypePassword = null;
		$email = null;
		$retypeEmail = null;

		printf("<script>document.cookie = 'id=; expires=Thu, 01 Jan 1970 00:00:01 GMT; path=/';document.cookie = 'pass=; expires=Thu, 01 Jan 1970 00:00:01 GMT; path=/';</script>\r\n");
		printf("<script>window.location='../myAccount/index.php?id=%s'</script>\r\n", $sess->sessionId);
	}
}

if (isset($_POST["deleteAccount"]))
{
	if ($valid)
	{
		$account = new Account($pilotId, $currentPassword, null);

		$account->DeleteAccount($pilotId);

		$sess->DestroySession($sess->sessionId);

		printf("<script>document.cookie = 'id=; expires=Thu, 01 Jan 1970 00:00:01 GMT; path=/';document.cookie = 'pass=; expires=Thu, 01 Jan 1970 00:00:01 GMT; path=/';</script>\r\n");
		printf("<script>window.location='../myAccount/index.php?id=%s'</script>\r\n", $sess->sessionId);
	}
}
?>

<!DOCTYPE html>
<html>

<head>
<title>Account Management</title>
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
		<form id="mainForm" method="post" enctype="multipart/form-data" action="<?php printf("index.php?id=%s", $sess->sessionId);?>" >
		<table>
			<tr>
				<td class="spacer100px"></td>
			</tr>
			<tr>
				<td class="spacer100px"></td>
				<td class="rightLabel">Pilot ID</td>
				<td class="leftLabel"><?php echo $pilotId;?></td>
			</tr>
			<tr>
				<td class="spacer100px"></td>
				<td class="rightLabel">Current Password</td>
				<td><input name="currentPassword" type="password" value="<?php echo $currentPassword;?>" AUTOFOCUS /></td>
				<td class="error"><?php echo $currentPasswordError;?></td>
			</tr>
			<tr>
				<td class="spacer100px"></td>
				<td class="rightLabel">New Password</td>
				<td><input name="password" type="text" value="<?php echo $password;?>" /></td>
				<td class="error"><?php echo $passwordError;?></td>
			</tr>
			<tr>
				<td class="spacer100px"></td>
				<td class="rightLabel">Retype Password</td>
				<td><input name="retypePassword" type="text" value="<?php echo $retypePassword;?>" /></td>
				<td class="error"><?php echo $retypePasswordError;?></td>
			</tr>
			<tr>
				<td class="spacer100px"></td>
				<td class="rightLabel">Current Email</td>
				<td class="leftLabel" colspan="2"><?php echo $currentEmail;?></td>
			</tr>
			<tr>
				<td class="spacer100px"></td>
				<td class="rightLabel">New Email</td>
				<td><input name="email" type="text" value="<?php echo $email;?>" /></td>
				<td class="error"><?php echo $emailError;?></td>
			</tr>
			<tr>
				<td class="spacer100px"></td>
				<td class="rightLabel">Retype New Email</td>
				<td><input name="retypeEmail" type="text" value="<?php echo $retypeEmail;?>" /></td>
				<td class="error"><?php echo $retypeEmailError;?></td>
			</tr>
			<tr>
				<td class="spacer100px"></td>
				<td class="rightLabel">First Name</td>
				<td><input name="firstName" type="text" value="<?php echo $firstName;?>" /></td>
				<td class="error"><?php echo $firstNameError;?></td>
			</tr>
			<tr>
				<td class="spacer100px"></td>
				<td class="rightLabel">Last Name</td>
				<td><input name="lastName" type="text" value="<?php echo $lastName;?>" /></td>
				<td class="error"><?php echo $lastNameError;?></td>
			</tr>
			<tr>
				<td class="spacer100px"></td>
				<td class="rightLabel">Home Base</td>
				<td><input name="homeBase" type="text" value="<?php echo $homeBase;?>" /></td>
				<td class="error"><?php echo $homeBaseError;?></td>
			</tr>
			<tr>
				<td class="spacer100px"></td>
				<td class="rightLabel">Show Heliports</td>
				<?php
				printf("<td class=\"checkbox\"><label for=\"imageSHOWHELIPORT\"></label>\r\n");

				if ($showHeliport)
				{
					printf("<input checked=\"checked\" type=\"checkbox\" name=\"showHeliport\" value=\"SHOWHELIPORT\" id=\"SHOWHELIPORT\">\r\n");
					printf("<img id=\"imageSHOWHELIPORT\" src=\"../images/checkboxChecked.png\" onclick=\"CheckboxClicked('SHOWHELIPORT')\" /></td>\r\n");
				}
				else
				{
					printf("<input type=\"checkbox\" name=\"showHeliport\" value=\"SHOWHELIPORT\" id=\"SHOWHELIPORT\">\r\n");
					printf("<img id=\"imageSHOWHELIPORT\" src=\"../images/checkboxUnchecked.png\" onclick=\"CheckboxClicked('SHOWHELIPORT')\" /></td>\r\n");
				}
				?>
				<td class="error"><?php echo $showHeliportError;?></td>
			</tr>
			<tr>
				<td class="spacer100px"></td>
				<td class="rightLabel" style="padding-top:3px;">Frequency Type</td>
				<td>
				<table>
					<tr>
						<?php
						printf("<td class=\"radio\"><label for=\"imageVHF\">VHF</label>\r\n");

						if (strcmp($showFrequency, "V") == 0)
						{
							printf("<input checked=\"checked\" type=\"radio\" name=\"radio\" value=\"V\" id=\"VHF\">\r\n");
							printf("<img id=\"imageVHF\" src=\"../images/radioChecked.png\" onclick=\"RadioClicked('VHF', 'mainForm', 'radio')\" /></td>\r\n");
						}
						else
						{
							printf("<input type=\"radio\" name=\"radio\" value=\"V\" id=\"VHF\">\r\n");
							printf("<img id=\"imageVHF\" src=\"../images/radioUnchecked.png\" onclick=\"RadioClicked('VHF', 'mainForm', 'radio')\" /></td>\r\n");
						}

						printf("<td class=\"radio\"><label for=\"imageALL\">ALL</label>\r\n");

						if (strcmp($showFrequency, "A") == 0)
						{
							printf("<input checked=\"checked\" type=\"radio\" name=\"radio\" value=\"A\" id=\"ALL\">\r\n");
							printf("<img id=\"imageALL\" src=\"../images/radioChecked.png\" onclick=\"RadioClicked('ALL', 'mainForm', 'radio')\" /></td>\r\n");
						}
						else
						{
							printf("<input type=\"radio\" name=\"radio\" value=\"A\" id=\"ALL\">\r\n");
							printf("<img id=\"imageALL\" src=\"../images/radioUnchecked.png\" onclick=\"RadioClicked('ALL', 'mainForm', 'radio')\" /></td>\r\n");
						}
						?>
						<td class="error"><?php echo $showFrequencyError;?></td>
					</tr>
				</table>
				</td>
			</tr>
		</table>
		<table>
			<tr>
				<td class="spacer85px"></td>
				<td><input type="submit" value="Update Account" name="updateAccount" class="button120px" /></td>
				<td><input type="submit" value="Delete Account" name="deleteAccount" class="button120px" /></td>
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

</body>
</html>