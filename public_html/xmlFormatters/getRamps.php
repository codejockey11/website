<?php
require_once "../includes.php";

$lookup = explode(",", $_GET["q"]);

$from = new LatLon($lookup[0], $lookup[1]);

$to = new LatLon($lookup[2], $lookup[3]);

$sql = sprintf("SELECT * FROM ramps WHERE X<='%s' AND X>='%s' AND Y<='%s' AND Y>='%s'", $from->decimalLon, $to->decimalLon, $from->decimalLat, $to->decimalLat);

$ramps = new Ramps($sess, $sql);

header("Content-Type: text/xml");

printf("<?xml version=\"1.0\"?>");

printf("<result sessionId=\"%s\">", $sess->sessionId);

printf("%s", $ramps->FormatXML());

printf("</result>");
?>