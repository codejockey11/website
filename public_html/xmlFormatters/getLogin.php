<?php
require_once "../includes.php";

$userId = null;
if (isset($_GET["userId"]))
{
	$userId = $_GET["userId"];
}

$password = null;
if (isset($_GET["password"]))
{
	$password = $_GET["password"];
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
printf("<name>%s</name>", $account->firstName);

printf("</login>");

printf("</result>");
?>