<?php
require_once "../includes.php";

$holder = null;

if (isset($_GET["holder"]))
{
	$holder = $_GET["holder"];
}

$sql = sprintf("SELECT * FROM aircraft WHERE holder='%s'", $holder);

$aircraft = new Aircraft($sql);

$aircraft->LoadModels($holder);

header("Content-Type: text/xml");

printf("<?xml version=\"1.0\"?>");

printf("<result type=\"models\">");

printf("%s", $aircraft->ListModelsXML());

printf("</result>");
?>