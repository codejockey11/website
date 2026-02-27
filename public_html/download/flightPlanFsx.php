<?php
require_once "../includes.php";

if ($sess->waypoints)
{
	$wp = explode(' ', str_replace("A;", "", $sess->waypoints));
	
	$wpc = count($wp);

	$fpf = new FlightPlanFormatter($sess);

	// FSX must be encoded
	$so = mb_convert_encoding($fpf->FormatFsx(), "Windows-1252");
	
	$planName = $wp[0] . "_" . $wp[$wpc-1] . ".pln";

	$fn = sprintf("../temp/%s_%s_%s.pln", $wp[0], $wp[$wpc-1], $sess->sessionId);
	
	$file = fopen($fn, "wb");
	
	fputs($file, $so);
	
	fclose($file);

	header('Content-Type: application/pln charset=windows-1252');
	header("Content-Disposition: attachment; filename=\"$planName\"");
	
	readfile($fn);
}
?>
