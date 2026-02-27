<?php
require_once "../includes.php";

$lookup = $_GET["q"];

$airmet = new AirSigmet($lookup);

header("Content-Type: text/xml");

printf("<?xml version=\"1.0\"?>");

printf("<result sessionId=\"%s\">", $sess->sessionId);

printf("%s", $airmet->FormatXML());

printf("</result>");
?>