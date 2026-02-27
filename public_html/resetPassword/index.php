<?php
require_once "../includes.php";

if (isset($_POST["email"]))
{
	$email = trim($_POST["email"]);
}
else
{
	$email = null;
}

$error = null;

$msg = null;

if (isset($_POST["resetPassword"]))
{
	$valid = false;

	if ($email)
	{
		$a = new Account(null, null, null);
		
		$a->GetAccountByEmail($email);

		if ($a->pilotId != "")
		{
			$np = sprintf("%s%s%s%s%s%s%s%s%s%s", chr(rand(65, 90)), chr(rand(48, 57)), chr(rand(65, 90)), chr(rand(48, 57)), chr(rand(65, 90)), chr(rand(48, 57)), chr(rand(65, 90)), chr(rand(48, 57)), chr(rand(65, 90)), chr(rand(48, 57)));

			$a->UpdatePassword($a->pilotId, $np);

			if (isset($_POST["email"]))
			{
				unset($_POST["email"]);
			}

			// New Password being displayed until email package is selected
			$msg  = sprintf("%s<br/>\r\n", $np);
			$msg .= sprintf("Password reset was sent to %s.<br/>\r\n", $a->email);
			$msg .= sprintf("Please check your email and change your password.<br/>\r\n", $a->email);
		}
		else
		{
			$error = sprintf("Email was not found");
		}
	}
}
?>

<!DOCTYPE html>
<html>

<head>
<title>Reset Password</title>
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
	<form id="mainForm" method="post" action="<?php printf("index.php?id=%s", $sess->sessionId);?>">
	<tr>
		<td>
		<table>
			<tr>
				<td class="centerLabel">Email</td>
				<td><input name="email" type="text" size="50" AUTOFOCUS value="<?php echo $email; ?>" /></td>
				<td><input type="submit" value="Reset Password" name="resetPassword" class="button120px" /></td>
			</tr>
		</table>
	</tr>
	</form>
	<tr>
	<?php
	if ($error)
	{
		printf("<td class=\"error\">%s</td>\r\n", $error);
	}
	else
	{
		printf("<td class=\"leftLabel\" rowspan=\"3\">%s</td>\r\n", $msg);
	}
	?>
	</tr>
</table>

<table class="footer">
	<tr>
		<td><?php $f = new Footer();?></td>
	</tr>
</table>

</body>
</html>