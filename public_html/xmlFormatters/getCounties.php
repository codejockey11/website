<?php
require_once "../includes.php";

$state = null;

if (isset($_GET["state"]))
{
	$state = $_GET["state"];
}

$city = null;

if (isset($_GET["city"]))
{
	$city = $_GET["city"];
}

$zip = null;

if (isset($_GET["zip"]))
{
	$zip = $_GET["zip"];
}

$usz = new USZips($state);

$usz->LoadCounties($state, $city, $zip);

header("Content-Type: text/xml");

printf("<?xml version=\"1.0\"?>");

printf("<result type=\"counties\">");

printf("%s", $usz->ListCountiesXML());

printf("</result>");
?>