<?php
require_once "../includes.php";

$lookup = explode(",", $_GET["q"]);

$i = "";

if (isset($_GET["i"]))
{
	$i = $_GET["i"];	
}

$ll = new LatLon($lookup[0], $lookup[1]);

$from = $ll->Rotate(10, 10);

$to = $ll->Rotate(-10, -10);

$sql = sprintf("SELECT * FROM aptAirport USE INDEX (aptAirportLatLon) WHERE latitude>='%s' AND latitude<='%s' AND longitude>='%s' AND longitude<='%s'", $to->formattedLat, $from->formattedLat, $to->formattedLon, $from->formattedLon);

if ($sess->showHeliport)
{
	$sql .= " AND type='HELIPORT'";
}
else
{
	$sql .= " AND type!='HELIPORT'";
}

$apt = new Airport($sess, $sql);

$sql = sprintf("SELECT * FROM navNavaid USE INDEX (navNavaidLatLon) WHERE latitude>='%s' AND latitude<='%s' AND longitude>='%s' AND longitude<='%s'", $to->formattedLat, $from->formattedLat, $to->formattedLon, $from->formattedLon);

$nav = new Navaid($sess, $sql);

$from = $ll->Rotate(5, 5);

$to = $ll->Rotate(-5, -5);

$sql = sprintf("SELECT * FROM fixLocation USE INDEX (fixLocationLatLon) WHERE latitude>='%s' AND latitude<='%s' AND longitude>='%s' AND longitude<='%s'", $to->formattedLat, $from->formattedLat, $to->formattedLon, $from->formattedLon);

$fix = new Fix($sess, $sql);

header("Content-Type: text/xml");

printf("<?xml version=\"1.0\"?>");

printf("<result sessionId=\"%s\">", $sess->sessionId);

printf("<index>%s</index>", $i);

printf("<location>%s,%s</location>", $lookup[0], $lookup[1]);

printf("%s", $apt->FormatXML());
printf("%s", $nav->FormatXML(false));
printf("%s", $fix->FormatXML());

$lat = sprintf("%0.10f", $lookup[0]);
$lon = sprintf("%0.10f", $lookup[1]);

printf("<gps><icon>../images/gps.png</icon><latitude>%s</latitude><longitude>%s</longitude></gps>", $lat, $lon);

printf("</result>");
?>