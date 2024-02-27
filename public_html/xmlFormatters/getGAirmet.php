<?php
require_once "../includes.php";

$lookup = $_GET["q"];

$gairmet = new GAirmet($lookup);

header("Content-Type: text/xml");

printf("<?xml version=\"1.0\"?>");

printf("<result sessionId=\"%s\">", $sess->sessionId);

printf("%s", $gairmet->FormatXML());

printf("</result>");
?>