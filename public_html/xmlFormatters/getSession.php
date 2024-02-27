<?php
require_once "../includes.php";

$name = 'None';

if (isset($_GET["q"]))
{
	$name = $_GET["q"];
}

header("Content-Type: text/xml");

printf("<?xml version=\"1.0\"?>");

printf("<result sessionId=\"%s\">", $sess->sessionId);

printf("<variables>");

printf("<name>%s</name>", $name);

printf("%s", $sess->FormatXML());

printf("</variables>");

printf("</result>");
?>