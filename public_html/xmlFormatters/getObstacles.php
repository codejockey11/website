<?php
require_once "../includes.php";

$lookup = explode(",", $_GET["q"]);

$from = new LatLon($lookup[0], $lookup[1]);

$to = new LatLon($lookup[2], $lookup[3]);

$alt = "00000";

switch($sess->mapZoom)
{
	case 16:
	case 17:
	case 18:
	{
		$alt = "00010";

		break;
	}
				
	case 15:
	{
		$alt = "00050";

		break;
	}
				
	case 14:
	{
		$alt = "00100";

		break;
	}
				
	case 13:
	{
		$alt = "00150";

		break;
	}
				
	case 12:
	{
		$alt = "00200";

		break;
	}
				
	default:
	{
		$alt = "00215";

		break;
	}
}

$sql = sprintf("SELECT * FROM obstacle USE INDEX (obstacleLatLon) WHERE latitude>='%s' AND latitude<='%s' AND longitude>='%s' AND longitude<='%s' AND agl>='%s'", $to->formattedLat, $from->formattedLat, $to->formattedLon, $from->formattedLon, $alt);

$obs = new Obstacle($sess, $sql);

header("Content-Type: text/xml");

printf("<?xml version=\"1.0\"?>");

printf("<result sessionId=\"%s\">", $sess->sessionId);

printf("%s", $obs->FormatXML());

printf("</result>");
?>