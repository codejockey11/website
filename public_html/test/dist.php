<?php
require_once "../includes.php";

$ll = new LatLon("39-20-41.9000N", "081-26-21.5000W");

printf("from: %s,%s", $ll->decimalLat, $ll->decimalLon);

$tll = new LatLon("40-28-12.6000N", "081-25-11.8000W");

printf("<br/>to: %s,%s", $tll->decimalLat, $tll->decimalLon);

$tc = $ll->TrueCourse($tll);
$d = $ll->DistanceInMiles($tll);

printf("<br/>true course: %s distance: %s", $tc, $d);

$nll = $ll->PointFromHeadingDistance($d, $tc);

printf("<br/>point from heading: %s,%s", $nll->decimalLat, $nll->decimalLon);

printf("<br/><br/>42.025138888889,-70.838111111111");

printf("<br/>nm, tc +- mag var (1, 360 - 14.70)");

$ll = new LatLon("42.025138888889","-70.838111111111");
$ll = $ll->PointFromHeadingDistance(1, 360 - 14.70);

printf("<br/>point from heading: %s,%s", $ll->decimalLat, $ll->decimalLon);
?>
<script type="text/javascript">
//==========================================================================================
function CalcPoint(distance, bearing)
{
	var radius = Number(7926.41/2);

	var lat = Number(39.344972222222);
	var lon = Number(-81.439305555556);

	var d = Number(distance * (6076/6076)) / radius;
	var b = Number(bearing) * (Math.PI / 180);

	var lat1 = lat * (Math.PI / 180);
	var lon1 = lon * (Math.PI / 180);

	var sinlat1 = Math.sin(lat1), coslat1 = Math.cos(lat1);
	var sind = Math.sin(d), cosd = Math.cos(d);
	var sinb = Math.sin(b), cosb = Math.cos(b);

	var sinlat2 = sinlat1 * cosd + coslat1 * sind * cosb;
	var lat2 = Math.asin(sinlat2);
	var y = sinb * sind * coslat1;
	var x = cosd - sinlat1 * sinlat2;
	var lon2 = lon1 + Math.atan2(y, x);

	document.write('<br/>js: ');
	document.write(lat2 * (180 / Math.PI));
	document.write(',');
	document.write(((lon2 * (180 / Math.PI)) + 540) % 360 - 180);
}
//==========================================================================================
CalcPoint(67.517546619474, 0.7500088215038);
//==========================================================================================
</script>

<!DOCTYPE html>
<html>

<head>
<title>LatLon Class</title>
<meta charset="UTF-8">
<link rel="shortcut icon" href="../favicon.ico">
<link rel="stylesheet" href="../base.css?v=1">
<script type="text/javascript" src="../base.js?v=1"></script>
</head>

<body>

</body>
</html>