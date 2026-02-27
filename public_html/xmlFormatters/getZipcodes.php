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

$usz = new USZips($state);

$usz->LoadZipcodes($state, $city);

header("Content-Type: text/xml");

printf("<?xml version=\"1.0\"?>");

printf("<result type=\"zipcodes\">");

printf("%s", $usz->ListZipcodesXML());

printf("</result>");
?>