<?php
class LatLon
{
	//N + s - W - E +
	//Decimal Degrees = Degrees + minutes/60 + seconds/3600

	public $formattedLat;
	public $formattedLatFSX;
	public $decimalLat;
	public $hemiLat;

	public $formattedLon;
	public $formattedLonFSX;
	public $decimalLon;
	public $hemiLon;

	public $valid;

	public function __construct($lat, $lon)
	{
		$this->valid = 0;

		if ((strpos($lat, ".") < 5) && (strpos($lon, ".") > 0))
		{
			$t = "N";

			if ($lat < 0)
			{
				$t = "S";
			}

			//get absolute value of decimal
			$d = abs($lat);

			//get degrees
			$degrees = floor($d);

			//get seconds
			$seconds = ($d - $degrees) * 3600;

			//get minutes
			$minutes = floor($seconds / 60);

			//reset seconds
			$seconds = $seconds - ($minutes * 60);

			$this->formattedLat = sprintf("%02d", $degrees) . "-" . sprintf("%02d", $minutes) . "-" . sprintf("%02.4f", $seconds) . $t;
		}
		else
		{
			$this->formattedLat = $lat;
		}

		if ((strpos($lon, ".") < 5) && (strpos($lon, ".") > 0))
		{
			$t = "W";

			if ($lon > 0)
			{
				$t = "E";
			}

			//get absolute value of decimal
			$d = abs($lon);

			//get degrees
			$degrees = floor($d);

			//get seconds
			$seconds = ($d - $degrees) * 3600;

			//get minutes
			$minutes = floor($seconds / 60);

			//reset seconds
			$seconds = $seconds - ($minutes * 60);

			$this->formattedLon = sprintf("%03d", $degrees) . "-" . sprintf("%02d", $minutes) . "-" . sprintf("%02.4f", $seconds) . $t;
		}
		else
		{
			$this->formattedLon = $lon;
		}

		$partsLat = explode("-", $this->formattedLat);

		if (count($partsLat) != 3)
		{
			$this->formattedLat = null;

			return;
		}

		$a = $partsLat[2];

		$length = strlen($a);

		$this->hemiLat = $a[$length - 1];

		$a[$length - 1] = "\n";

		$partsLat[2] = trim($a);

		$this->decimalLat = floatval($partsLat[0]) + (floatval($partsLat[1]) / 60) + (floatval($partsLat[2]) / 3600);

		if ((strcmp($this->hemiLat, "S") == 0) || (strcmp($this->hemiLat, "W") == 0))
		{
			$this->decimalLat *= -1;
		}

		$partsLon = explode("-", $this->formattedLon);

		if (count($partsLon) != 3)
		{
			$this->formattedLon = null;

			return;
		}

		$a = $partsLon[2];

		$length = strlen($a);

		$this->hemiLon = $a[$length - 1];

		$a[$length - 1] = "\n";

		$partsLon[2] = trim($a);

		$this->decimalLon = floatval($partsLon[0]) + (floatval($partsLon[1]) / 60) + (floatval($partsLon[2]) / 3600);

		if ((strcmp($this->hemiLon, "S") == 0) || (strcmp($this->hemiLon, "W") == 0))
		{
			$this->decimalLon *= -1;
		}

		$this->formattedLatFSX = $this->hemiLat . $partsLat[0] . " " . $partsLat[1] . " " . $partsLat[2];

		$this->formattedLonFSX = $this->hemiLon . $partsLon[0] . " " . $partsLon[1] . " " . $partsLon[2];

		$this->valid = 1;
	}

	// final distance is nautical miles
	public function DistanceInMiles($toLatLon)
	{
		if ($this->valid == 0)
		{
			return;
		}

		$lat2 = $toLatLon->decimalLat  * M_PI / 180;
		$lon2 = $toLatLon->decimalLon * M_PI / 180;

		$lat1 = $this->decimalLat  * M_PI / 180;
		$lon1 = $this->decimalLon * M_PI / 180;

		$d = acos(sin($lat1) * sin($lat2) + cos($lat1) * cos($lat2) * cos($lon1 - $lon2));

		$dist = ((180*60)/M_PI) * $d;

		return $dist;
	}

	public function TrueCourse($toLatLon)
	{
		if ($this->valid == 0)
		{
			return;
		}

		$LatA = $this->decimalLat * (M_PI / 180);
		$LatB = $toLatLon->decimalLat * (M_PI / 180);

		$LonA = $this->decimalLon * (M_PI / 180);
		$LonB = $toLatLon->decimalLon * (M_PI / 180);

		$Y = (sin($LonB - $LonA) * cos($LatB));
		$X = (cos($LatA) * sin($LatB) - sin($LatA) * cos($LatB) * cos($LonB - $LonA));

		$b = (atan2($Y, $X));

		$h = $b * (180 / M_PI);

		$tc = $h;

		if ($h < 0)
		{
			$tc = $h + 360;
		}

		return $tc;
	}

	// Looking up the region code for the state where this latitude and longitude is located
	public function GetLocation()
	{
		if ($this->valid == 0)
		{
			return;
		}

		$xml = sprintf("https://maps.googleapis.com/maps/api/geocode/xml?latlng=%s,%s&key=", $this->decimalLat, $this->decimalLon);

		$sr = new SimpleRequest($xml);

		if ($sr->xml == null)
		{
			return;
		}

		foreach ($sr->xml->result->address_component as $address_component)
		{
			$p = new Parameter("region" . $address_component->short_name);

			if ($p->value1)
			{
				return $p->value1;
			}
		}
	}

	// Computing latitude and longitude based on number of minutes to add or subtract from
	// this classes latitude and longitude
	public function Rotate($lat, $lon)
	{
		if ($this->valid == 0)
		{
			return;
		}

		$ll = new LatLon($this->formattedLat, $this->formattedLon);

		$ll->decimalLat = abs($ll->decimalLat) + ($lat/60);

		if ((strcmp($ll->hemiLat, "S") == 0) || (strcmp($ll->hemiLat, "W") == 0))
		{
			$ll->decimalLat *= -1;
		}

		$hours = abs(intval($ll->decimalLat));

		$minutes = (abs($ll->decimalLat) - $hours) * 60;

		$le = explode("-", $this->formattedLat);

		$seconds = $le[2];

		$ll->formattedLat = sprintf("%02d-%02d-%s", $hours, $minutes, $seconds);

		$ll->decimalLon = abs($ll->decimalLon) + ($lon/60);

		if ((strcmp($ll->hemiLon, "S") == 0) || (strcmp($ll->hemiLon, "W") == 0))
		{
			$ll->decimalLon *= -1;
		}

		$hours = abs(intval($ll->decimalLon));

		$minutes = (abs($ll->decimalLon) - $hours) * 60;

		$le = explode("-", $this->formattedLon);

		$seconds = $le[2];

		$ll->formattedLon = sprintf("%03d-%02d-%s", $hours, $minutes, $seconds);

		$ll = new LatLon($ll->formattedLat, $ll->formattedLon);

		return $ll;
	}

	public function PointFromHeadingDistance($distance, $bearing)
	{
		if ($this->valid == 0)
		{
			return;
		}

		// radius of earth in miles 7,926.41 miles
		$radius = floatval(7926.41/2);

		// assuming input is in nm
		// distance must be in miles (6076/5280) = 1.15
		$d = floatval(($distance * (6076/5280)) / $radius);
		$b = floatval($bearing) * (M_PI / 180);

		$lat1 = $this->decimalLat * (M_PI / 180);
		$lon1 = $this->decimalLon * (M_PI / 180);

		$sinlat1 = sin($lat1);
		$coslat1 = cos($lat1);

		$sind = sin($d);
		$cosd = cos($d);

		$sinb = sin($b);
		$cosb = cos($b);

		$sinlat2 = $sinlat1 * $cosd + $coslat1 * $sind * $cosb;

		$lat2 = asin($sinlat2);

		$y = $sinb * $sind * $coslat1;
		$x = $cosd - $sinlat1 * $sinlat2;

		$lon2 = $lon1 + atan2($y, $x);

		$lat2 = $lat2 * (180 / M_PI);

		$lon2 = $lon2 * (180 / M_PI) + 540 % 360 - 180;

		return new LatLon($lat2, $lon2);
	}
}
/*
http://edwilliams.org/avform.htm#Intro

Intersecting radials
Now how to compute the latitude, lat3, and longitude, lon3 of an intersection formed by the crs13 true bearing from point 1 and the crs23 true bearing from point 2:
dst12=2*asin(sqrt((sin((lat1-lat2)/2))^2+
                   cos(lat1)*cos(lat2)*sin((lon1-lon2)/2)^2))
IF sin(lon2-lon1)<0
   crs12=acos((sin(lat2)-sin(lat1)*cos(dst12))/(sin(dst12)*cos(lat1)))
   crs21=2.*pi-acos((sin(lat1)-sin(lat2)*cos(dst12))/(sin(dst12)*cos(lat2)))
ELSE
   crs12=2.*pi-acos((sin(lat2)-sin(lat1)*cos(dst12))/(sin(dst12)*cos(lat1)))
   crs21=acos((sin(lat1)-sin(lat2)*cos(dst12))/(sin(dst12)*cos(lat2)))
ENDIF

ang1=mod(crs13-crs12+pi,2.*pi)-pi
ang2=mod(crs21-crs23+pi,2.*pi)-pi

IF (sin(ang1)=0 AND sin(ang2)=0)
   "infinity of intersections"
ELSEIF sin(ang1)*sin(ang2)<0
   "intersection ambiguous"
ELSE
   ang1=abs(ang1)
   ang2=abs(ang2)
   ang3=acos(-cos(ang1)*cos(ang2)+sin(ang1)*sin(ang2)*cos(dst12))
   dst13=atan2(sin(dst12)*sin(ang1)*sin(ang2),cos(ang2)+cos(ang1)*cos(ang3))
   lat3=asin(sin(lat1)*cos(dst13)+cos(lat1)*sin(dst13)*cos(crs13))
   dlon=atan2(sin(crs13)*sin(dst13)*cos(lat1),cos(dst13)-sin(lat1)*sin(lat3))
   lon3=mod(lon1-dlon+pi,2*pi)-pi
ENDIF
The points 1,2 and the (if unique) intersection 3 form a spherical triangle with interior angles abs(ang1), abs(ang2) and ang3. To find the pair of antipodal intersections of two great circles uses the following reference.

*/
?>