<?php
class Waypoint
{
	public $sess;

	public $type;
	public $name;
	public $class;

	public $heading = 0;
	public $distance = 0;
	public $distanceRemain = 0;
	public $time = 0;
	public $timeCorr = 0;
	public $timeRemain = 0;
	public $timeRemainCorr = 0;

	public $from;
	public $to;

	public $latLon;
	public $magVar;
	public $desc;

	public $HDG;
	public $GS;

	public function __construct($sess, $type, $name, $class)
	{
		$this->sess = $sess;
		$this->type = $type;
		$this->name = $name;
		$this->class = $class;
	}

	public function CalculateCourse($next)
	{
		switch ($this->type)
		{
			case "A":
			case "F":
			case "N":
			{
				$afn = $this->class->GetSingle(0);
				
				$fromLatLon = $afn->latLon;
				$fromMagVar = $afn->magVar;
				
				$this->latLon = $afn->latLon;

				break;
			}

			case "G":
			{
				$fromLatLon = $this->latLon;
				$fromMagVar = $this->magVar;

				break;
			}
		}

		switch($next->type)
		{
			case "A":
			case "F":
			case "N":
			{
				$afn = $next->class->GetSingle(0);
				
				$toLatLon = $afn->latLon;

				break;
			}

			case "G":
			{
				$toLatLon = $next->latLon;

				break;
			}
		}

		if (($fromLatLon) && ($toLatLon))
		{
			$hdg = $fromLatLon->TrueCourse($toLatLon);

			$this->heading = floatval($hdg) - floatval($fromMagVar);
			
			if ($this->heading > 360.0)
			{
				$this->heading -= 360.0;
			}
			
			if ($this->heading < 0.0)
			{
				$this->heading += 360.0;
			}

			$this->distance = intval(round($fromLatLon->DistanceInMiles($toLatLon)));
			
			$this->time = round(($this->distance / $this->sess->speed) * 60);
		}

		if ($this->sess->winds)
		{
			$wa = explode("/", $this->sess->winds);
			
			$this->GndSpdCrsWca($wa[0], $wa[1], $this->heading, $this->sess->speed);
			
			$this->timeCorr = round(($this->distance / $this->GS) * 60);
		}
	}

	//
	//Calculate Ground Speed, Course & Wind Correction Angle
	//http://www.csgnetwork.com/e6bcalc.html
	//
	public function GndSpdCrsWca($windDir, $windSpd, $heading, $TAS)
	{
		$crs = (M_PI/180) * round($heading);
		
		$wd = (M_PI/180) * $windDir;
		
		$swc = ($windSpd/$TAS) * sin($wd - $crs);

		if (abs($swc) > 1)
		{
			return;
		}

		$hd = $crs + asin($swc);

		if ($hd < 0)
		{
			$hd = $hd + 2 * M_PI;
		}

		if ($hd > 2 * M_PI)
		{
			$hd = $hd - 2 * M_PI;
		}

		$this->HDG = round((180/M_PI) * $hd);

		$this->GS = round($TAS * sqrt(1 - pow($swc, 2)) - ($windSpd * cos($wd - $crs)));

		$wca = atan2($windSpd * sin($hd - $wd), $TAS - $windSpd * cos($hd - $wd));

		$WCA = round((180/M_PI) * ($wca * -1)); // 6/2/02 CED sign correction
	}

	public function WaypointInfo()
	{
		if ($this->distance == 0)
		{
			return;
		}
				
		printf("<td class=\"plannerInfo\">\r\n");

		switch($this->type)
		{
			case "A":
			{
				$apt = $this->class->GetSingle(0);

				printf("%s", $apt->WaypointInfo());

				break;
			}

			case "F":
			case "N":
			{
				$fn = $this->class->GetSingle(0);

				printf("%s", $fn->WaypointInfo());

				if ($this->sess->airway)
				{
					$this->ListAirway($fn->latLon);
				}

				break;
			}

			case "G":
			{
				if ($this->magVar == 0.0)
				{
					printf("%s <b class=\"planeInfoError\">%0.2f</b><br/>%s %s<br/>%s %s", $this->desc, $this->magVar, $this->latLon->formattedLat, $this->latLon->formattedLon, $this->latLon->decimalLat, $this->latLon->decimalLon);					
				}
				else
				{
					printf("%s %0.2f<br/>%s %s<br/>%s %s", $this->desc, $this->magVar, $this->latLon->formattedLat, $this->latLon->formattedLon, $this->latLon->decimalLat, $this->latLon->decimalLon);										
				}


				break;
			}

		}

		printf("</td>\r\n");
	}

	public function ListAirway($latLon)
	{
		$awyTypes = explode(",", $this->sess->airway);

		foreach ($awyTypes as $atp)
		{
			$awy = new Airway($this->sess, $this->from, $this->to, $atp, null);

			printf("%s", $awy->FormatPlanInfo($latLon));
		}
	}

	public function WaypointData()
	{
		if ($this->distance == 0)
		{
			return;
		}
				
		printf("<td class=\"plannerwp\">%d</td>\r\n", $this->heading);
		printf("<td class=\"plannerwp\">%d</td>\r\n", $this->distance);
		printf("<td class=\"plannerwp\">%d</td>\r\n", $this->distanceRemain);
		printf("<td class=\"plannerwp\">%d</td>\r\n", $this->time);
		printf("<td class=\"plannerwp\">%d</td>\r\n", $this->timeRemain);

		if ($this->sess->winds)
		{
			printf("<td class=\"plannerwp\">%d</td>\r\n", $this->HDG);
			printf("<td class=\"plannerwp\">%d</td>\r\n", $this->GS);
			printf("<td class=\"plannerwp\">%d</td>\r\n", $this->timeCorr);
			printf("<td class=\"plannerwp\">%d</td>\r\n", $this->timeRemainCorr);
		}
	}
}
/*
http://www.csgnetwork.com/e6bcalc.html
function Heading(calcHeading) {

  crs = (Math.PI/180) * calcHeading.course.value;

  wd = (Math.PI/180) * calcHeading.windDir.value;

  swc = (calcHeading.windSpd.value/calcHeading.TAS.value) *

        Math.sin(wd - crs);

  if (Math.abs(swc) > 1){

    alert("Danger!... Course should not be flown... Wind is too strong");

    return;

    }

  hd = crs + Math.asin(swc);

  if (hd < 0) {

    hd = hd + 2 * Math.PI;

    }

  if (hd > 2*Math.PI) {

    hd = hd - 2 * Math.PI;

    }

  calcHeading.heading.value = Math.round((180/Math.PI) * hd);

  calcHeading.GS.value = Math.round(calcHeading.TAS.value * Math.sqrt(1 - Math.pow(swc, 2)) -

         (calcHeading.windSpd.value * Math.cos(wd - crs)));

  wca = Math.atan2(calcHeading.windSpd.value * Math.sin(hd-wd),

                               calcHeading.TAS.value-calcHeading.windSpd.value *

                               Math.cos(hd-wd));

  calcHeading.WCA.value = Math.round((180/Math.PI) * (wca * -1)); // 6/2/02 CED sign correction

}
*/
?>