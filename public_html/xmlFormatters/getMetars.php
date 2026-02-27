<?php
require_once "../includes.php";

$lookup = explode(",", $_GET["q"]);

$from = new LatLon($lookup[0], $lookup[1]);

$to = new LatLon($lookup[2], $lookup[3]);

$metar = array();

$station = array();

$taf = array();

$parms = new Parameter("metarsLatLon");

$xml = $parms->value1;

$xml .= "&minLat=" . $to->decimalLat;
$xml .= "&minLon=" . $from->decimalLon;
$xml .= "&maxLat=" . $from->decimalLat;
$xml .= "&maxLon=" . $to->decimalLon;

$sr = new SimpleRequest($xml);

if ($sr->xml !== false)
{
	foreach ($sr->xml->data->METAR as $mtr)
	{
		$stn = trim($mtr->station_id);
		
		if (array_search($stn, $metar) === false)
		{
			array_push($metar, $stn);
			
			array_push($station, new Station($stn));
			
			array_push($taf, new TAF($stn));
		}
	}
}

header("Content-Type: text/xml");

printf("<?xml version=\"1.0\"?>");

printf("<result sessionId=\"%s\">", $sess->sessionId);

for ($s=0;$s<count($station);$s++)
{
	$mtr = $station[$s]->GetSingle(0);
	
	$t = $taf[$s]->GetSingle(0);

	printf("%s", $mtr->FormatXML($t));
}

printf("</result>");
?>