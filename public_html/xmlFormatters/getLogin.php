<?php
require_once "../includes.php";

$userId = null;
if (isset($_POST["userId"]))
{
	$userId = $_POST["userId"];
}

$password = null;
if (isset($_POST["password"]))
{
	$password = $_POST["password"];
}

$result = null;
if (($userId != null) && ($password != null))
{
	$account = new Account($userId, $password, null);

	if ($account->pilotId == null)
	{
		$result = "N";
	}
	else
	{
		$result = "Y";
	}
}
else
{
	$result = "N";
}

header("Content-Type: text/xml");

printf("<?xml version=\"1.0\"?>");

printf("<result>");

printf("<login>");

printf("<valid>%s</valid>", $result);

printf("</login>");

printf("</result>");
?>