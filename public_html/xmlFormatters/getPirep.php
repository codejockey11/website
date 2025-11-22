<?php
require_once "../includes.php";

$pirep = new Pirep();

header("Content-Type: text/xml");

printf("<?xml version=\"1.0\"?>");

printf("<result sessionId=\"%s\">", $sess->sessionId);

printf("%s", $pirep->FormatXML());

printf("</result>");
?>