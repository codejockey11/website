<?php
require_once "../includes.php";

$val = explode("~", $_GET["q"]);

if (count($val) == 2)
{
	$sess->SetSessionVariable($val[0], $val[1]);
}
else
{
	$sess->SetSessionVariable($val[0], null);

	$val[1] = null;
}

header("Content-Type: text/xml");

printf("<?xml version=\"1.0\"?>");

printf("<result type=\"setSessionVariable\" sessionId=\"%s\">", $sess->sessionId);

printf("<variable>");
printf("<name>%s</name>", $val[0]);
printf("<value>%s</value>", $val[1]);
printf("</variable>");

printf("</result>");
?>