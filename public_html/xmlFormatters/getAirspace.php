<?php
require_once "../includes.php";

$designator = $_GET["q"];

$sql = sprintf("SELECT * FROM saaLocation USE INDEX(saaLocationDesignator) WHERE designator='%s'", $designator);

if (strpos($designator, ",") > 0)
{
	$da = explode(",", $designator);
			
	$first = true;
			
	foreach($da as $d)
	{
		if ($first)
		{
			$first = false;
					
			$sql = sprintf("SELECT * FROM saaLocation USE INDEX(saaLocationDesignator) WHERE designator='%s'", $d);
		}
		else
		{
			$sql .= sprintf(" OR designator='%s'", $d);
		}
	}
}

$saa = new SaaLocation($sess, $sql);

header("Content-Type: text/xml");

printf("<?xml version=\"1.0\"?>");

printf("<result sessionId=\"%s\">", $sess->sessionId);

printf("%s", $saa->FormatXML());

printf("</result>");
?>