<?php
require_once "../includes.php";

$weather = new WeatherImage();

header("Content-Type: text/xml");

printf("<?xml version=\"1.0\"?>");

printf("<result sessionId=\"%s\">", $sess->sessionId);

printf("%s", $weather->FormatXML());

printf("</result>");
?>