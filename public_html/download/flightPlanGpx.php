<?php
require_once "../includes.php";

if ($sess->waypoints)
{
	$wp = explode(' ', str_replace("A;", "", $sess->waypoints));
	
	$wpc = count($wp);

	$o = sprintf("Content-Disposition: attachment;filename=\"%s_%s.gpx\"", $wp[0], $wp[$wpc-1]);

	header($o);
	
	header("Content-Transfer-Encoding: utf-8");
	header("Expires: 0");
	header("Pragma: no-cache");

	$fpf = new FlightPlanFormatter($sess);
	
	$fpf->FormatGpx();
}
?>