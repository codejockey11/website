<?php
require_once "../includes.php";

$state = null;

if (isset($_GET["state"]))
{
	$state = $_GET["state"];
}

$usz = new USZips($state);

$usz->LoadCities($state);

header("Content-Type: text/xml");

printf("<?xml version=\"1.0\"?>");

printf("<result type=\"cities\">");

printf("%s", $usz->ListCitiesXML());

printf("</result>");
?>