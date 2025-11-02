<?php
require_once "../includes.php";

$fp = new FlightPlanFormatter($sess);

header("Content-Type: text/xml");

printf("%s", $fp->FormatXML());
?>