<?php
require_once "../includes.php";
?>

<!DOCTYPE html>
<html>

<head>
<title>Login</title>
<meta charset="UTF-8">
<link rel="shortcut icon" href="../../favicon.ico" />
<link rel="stylesheet" href="../../base.css" />
<script src="../../base.js" type="text/javascript"></script>
<script type="text/javascript">
var passwordCheck = null;
//==========================================================================================
function HandlePasswordCheck()
{
	if (passwordCheck.readyState == 4 && passwordCheck.status == 200)
	{
		var parser = new DOMParser();

		var xmlDoc = parser.parseFromString(passwordCheck.responseText, 'text/xml');

		var valid = xmlDoc.getElementsByTagName('valid')[0].textContent;

		alert(valid);
	}
}
//==========================================================================================
function ToPhp()
{
	var uname = document.getElementById("uname").value;
	var psw = document.getElementById("psw").value;

	passwordCheck = new XMLHttpRequest();

	passwordCheck.onreadystatechange = HandlePasswordCheck;

	var url = '../xmlFormatters/getLogin.php?userId=' + uname + '&password=' + psw;
	
	alert(url);
	
	passwordCheck.open('POST', url);

	passwordCheck.send();
}
//==========================================================================================
</script>
</head>
<body>
<form action="javascript:;" onsubmit="ToPhp();">
<table>
<tr>
	<td>
		<label for="uname">Username</label>
	</td>
	<td>
		<input type="text" id="uname" name="uname" required>
	</td>
</tr>
<tr>
	<td>
		<label for="psw">Password</label>
	</td>
	<td>
		<input type="password" id="psw" name="psw" required>
	</td
</tr>
<tr>
	<td>
	&nbsp;
	</td>
	<td>
		<button type="submit">Login</button>
		<label>
			<input type="checkbox" checked="unchecked" name="remember"> Remember me
		</label>
	</td>
</tr>
<tr>
	<td>
	&nbsp;
	</td>
	<td>
		<span class="psw">Forgot <a href="#">password?</a></span>
	</td>
</tr>
</table>
</form>
</body>
</html>
