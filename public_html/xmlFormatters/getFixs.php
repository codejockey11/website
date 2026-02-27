<?php
require_once "../includes.php";

$lookup = explode(",", $_GET["q"]);

$from = new LatLon($lookup[0], $lookup[1]);

$to = new LatLon($lookup[2], $lookup[3]);

$sql = sprintf("SELECT * FROM fixLocation USE INDEX (fixLocationLatLon) WHERE latitude>='%s' AND latitude<='%s' AND longitude>='%s' AND longitude<='%s'", $to->formattedLat, $from->formattedLat, $to->formattedLon, $from->formattedLon);

$fix = new Fix($sess, $sql);

header("Content-Type: text/xml");

printf("<?xml version=\"1.0\"?>");

printf("<result sessionId=\"%s\">", $sess->sessionId);

printf("%s", $fix->FormatXML());

printf("</result>");
?>