<?php
require_once "../includes.php";

if (isset($_POST["pilotIdSignUp"]))
{
	$pilotIdSignUp = trim($_POST["pilotIdSignUp"]);
}
else
{
	$pilotIdSignUp = $sess->pilotIdSignUp;
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

$sess->SetSessionVariable("pilotIdSignUp", $pilotIdSignUp);
$sess->SetSessionVariable("password", $password);
$sess->SetSessionVariable("retypePassword", $retypePassword);
$sess->SetSessionVariable("email", $email);
$sess->SetSessionVariable("retypeEmail", $retypeEmail);
$sess->SetSessionVariable("firstName", $firstName);
$sess->SetSessionVariable("lastName", $lastName);
$sess->SetSessionVariable("homeBase", $homeBase);
$sess->SetSessionVariable("showHeliport", $showHeliport);
$sess->SetSessionVariable("showFrequency", $showFrequency);

$pilotIDError = null;
$passwordError = null;
$retypePasswordError = null;
$emailError = null;
$retypeEmailError = null;
$firstNameError = null;
$lastNameError = null;
$homeBaseError = null;
$showHeliportError = null;
$showFrequencyError = null;

$valid = true;

if (isset($_POST["button120px"]))
{
	$account = new Account($pilotIdSignUp, $password, null);

	$account->CheckPilotId($pilotIdSignUp);

	if ($account->pilotId)
	{
		$pilotIDError = "Pilot ID is Already In Use";

		$valid = false;
	}
	else if ($pilotIdSignUp == null)
	{
		$pilotIDError = "Enter Pilot ID";

		$valid = false;
	}

	if ($password == null)
	{
		$passwordError = "Enter Password";

		$valid = false;
	}

	if ($retypePassword == null)
	{
		$retypePasswordError = "Retype Password";

		$valid = false;
	}
	else if (strcmp($password, $retypePassword) != 0)
	{
		$retypePasswordError = "Password and Retyped Password Must Match";

		$valid = false;
	}

	if ($email == null)
	{
		$emailError = "Enter Email";

		$valid = false;
	}
	else
	{
		$account = new Account($pilotIdSignUp, $password, null);

		$account->GetAccountByEmail($email);

		if ($account->pilotId)
		{
			$emailError = "Email Already on File";

			$valid = false;
		}
	}

	if (ValidateEmail($email) == 0)
	{
		$emailError = "Email is not in a valid format";

		$valid = false;
	}

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


	if ($homeBase == null)
	{
		$homeBaseError = "Enter Home Base";

		$valid = false;
	}
	
	$homeBaseLatLon = null;

	if ($homeBase)
	{
		$sql = sprintf("SELECT * FROM aptAirport WHERE ICAO='%s'", $homeBase);

		$a = new Airport($sess, $sql);

		if ($apt = $a->GetSingle(0))
		{
			$homeBaseLatLon = $apt->latitude . "," . $apt->longitude;
		}
		else
		{
			$homeBaseError = "Home Base not found";

			$homeBaseLatLon = null;

			$valid = false;
		}
	}

	if ($valid)
	{
		$account = new Account($pilotIdSignUp, $password, null);

		$account->AddAccount($pilotIdSignUp, $password, $email, $firstName, $lastName, $homeBase, $homeBaseLatLon, $showHeliport, $showFrequency);

		$account = new Account($pilotIdSignUp, $password, null);

		$sess->SetSessionVariable("pilotId", $pilotIdSignUp);
		$sess->SetSessionVariable("currentEmail", $account->email);
		$sess->SetSessionVariable("firstName", $account->firstName);
		$sess->SetSessionVariable("lastName", $account->lastName);
		$sess->SetSessionVariable("homeBase", $homeBase);
		$sess->SetSessionVariable("showHeliport", $showHeliport);
		$sess->SetSessionVariable("showFrequency", $showFrequency);
		$sess->SetSessionVariable("mapCenter", $homeBaseLatLon);
		$sess->SetSessionVariable("mapZoom", 10);
		$sess->SetSessionVariable("loggedOn", 1);

		$sess->SetSessionVariable("pilotIdSignUp", null);
		$sess->SetSessionVariable("password", null);
		$sess->SetSessionVariable("retypePassword", null);
		$sess->SetSessionVariable("email", null);
		$sess->SetSessionVariable("retypeEmail", null);

		printf("<script>window.location='../planner/index.php?id=%s'</script>\r\n", $sess->sessionId);
	}
}
?>

<!DOCTYPE html>
<html>

<head>
<title>Account Registration</title>
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
		<form id="mainForm" method="post" action="<?php printf("index.php?id=%s", $sess->sessionId);?>" >
		<table>
			<tr>
				<td class="rightLabel">Pilot ID</td>
				<td><input name="pilotIdSignUp" type="text" value="<?php echo $pilotIdSignUp;?>" AUTOFOCUS /></td>
				<td class="error"><?php echo $pilotIDError;?></td>
			</tr>
			<tr>
				<td class="rightLabel">Password</td>
				<td><input name="password" type="text" value="<?php echo $password;?>" /></td>
				<td class="error"><?php echo $passwordError;?></td>
			</tr>
			<tr>
				<td class="rightLabel">Retype Password</td>
				<td><input name="retypePassword" type="text" value="<?php echo $retypePassword;?>" /></td>
				<td class="error"><?php echo $retypePasswordError;?></td>
			</tr>
			<tr>
				<td class="rightLabel">Email</td>
				<td><input name="email" type="text" size="30" value="<?php echo $email;?>" /></td>
				<td class="error"><?php echo $emailError;?></td>
			</tr>
			<tr>
				<td class="rightLabel">Retype Email</td>
				<td><input name="retypeEmail" type="text" size="30" value="<?php echo $retypeEmail;?>" /></td>
				<td class="error"><?php echo $retypeEmailError;?></td>
			</tr>
			<tr>
				<td class="rightLabel">First Name</td>
				<td><input name="firstName" type="text" value="<?php echo $firstName;?>" /></td>
				<td class="error"><?php echo $firstNameError;?></td>
			</tr>
			<tr>
				<td class="rightLabel">Last Name</td>
				<td><input name="lastName" type="text" value="<?php echo $lastName;?>" /></td>
				<td class="error"><?php echo $lastNameError;?></td>
			</tr>
			<tr>
				<td class="rightLabel">Home Base</td>
				<td><input name="homeBase" type="text" value="<?php echo $homeBase;?>" /></td>
				<td class="error"><?php echo $homeBaseError;?></td>
			</tr>
			<tr>
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
			<tr>
				<td></td>
				<td><input type="submit" value="Create Account" name="button120px" class="button120px"/></td>
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