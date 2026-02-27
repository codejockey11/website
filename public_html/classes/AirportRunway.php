<?php
class AirportRunwayData
{
	public $id;
	public $facilityId;
	public $runwayId;
	public $length;
	public $width;
	public $surface;
	public $surfaceTreatment;
	public $pavementClass;
	public $edgeLighting;
	public $ilsType;
	public $righthandTraffic;
	public $markingCondition;
	public $latitude;
	public $longitude;
	public $elevation;
	public $thresholdHeight;
	public $glidePathAngle;
	public $displacedThreshold;
	public $touchDownElevation;
	public $glideSlopeIndicator;
	public $visualRange;
	public $visualValue;
	public $als;
	public $reil;
	public $centerline;
	public $touchdown;
	public $relevation;
	public $tora;
	public $toda;
	public $asda;
	public $lda;
	public $lahsoDistance;
	public $lahsoRunway;
	public $lahsoEntity;
	public $singleWeight;
	public $dualWeight;
	public $tandemWeight;
	public $doubleTandemWeight;

	public $ils = array();
	public $arresting = array();

	public function FormatAirportList()
	{
		$str  = sprintf("<td class=\"list\">%s</td><td class=\"list\">%s</td><td class=\"list\">%s</td><td class=\"list\">%s</td>\r\n", $this->runwayId, $this->length, $this->width, $this->surface);

		if ($this->ilsType)
		{
			$str .= sprintf("<td>%s</td>\r\n", $this->ilsType);
		}

		return $str;
	}

	public function FormatEntry()
	{
		$str  = sprintf("<b>%s</b>\r\n", $this->runwayId);
		
		$str .= sprintf("\r\n<br/>Length:%s width:%s", $this->length, $this->width);

		$rt = explode("-", $this->surface);
		
		$p = new Parameter("runwaySurface" . $rt[0]);
		
		$str .= sprintf("\r\n<br/>Surface:<a class=\"tooltip\" href=\"#\">%s<span>%s</span></a>\r\n", $this->surface, $p->value1);

		if ($this->surfaceTreatment)
		{
			$p = new Parameter("runwayTreatment" . $this->surfaceTreatment);
			
			$str .= sprintf("\r\n<br/>Surface Treatment:<a class=\"tooltip\" href=\"#\">%s<span>%s</span></a>\r\n", $this->surfaceTreatment, $p->value1);
		}

		if ($this->pavementClass)
		{
			$str .= sprintf("\r\n<br/>Pavement Class:%s", $this->pavementClass);
		}

		if ($this->edgeLighting)
		{
			$str .= sprintf("\r\n<br/>Edge Lighting:%s", $this->edgeLighting);
		}

		if ($this->ilsType)
		{
			$p = new Parameter("ilsType" . $this->ilsType);
			
			$str .= sprintf("\r\n<br/>ILS Type:<a class=\"tooltip\" href=\"#\">%s<span>%s</span></a>\r\n", $this->ilsType, $p->value1);
		}

		if ($this->righthandTraffic)
		{
			$str .= sprintf("\r\n<br/>Righthand Traffic:%s", $this->righthandTraffic);
		}

		if ($this->markingCondition)
		{
			$p = new Parameter("runwayMarkingCondition" . $this->markingCondition);
			
			$str .= sprintf("\r\n<br/>Marking Condition:<a class=\"tooltip\" href=\"#\">%s<span>%s</span></a>\r\n", $this->markingCondition, $p->value1);
		}

		if ($this->latitude)
		{
			$str .= sprintf("\r\n<br/>GPS:%s %s", $this->latitude, $this->longitude);
		}

		$rw = explode("/", $this->runwayId);

		if ($this->elevation)
		{
			$str .= sprintf("\r\n<br/>Elevation:%02d %s", $rw[0], $this->elevation);
		}

		if ($this->relevation)
		{
			$str .= sprintf(" %02d %s", $rw[1], $this->relevation);
		}

		if (($this->elevation) && ($this->relevation))
		{
			$e = abs(floatval($this->elevation) - floatval($this->relevation));
			
			$s = ($e / $this->length) * 100;

			if ($this->elevation < $this->relevation)
			{
				$str .= sprintf("\r\n<br/>Gradient:%s >> %.1f%% >> %s", $rw[0], $s, $rw[1]);
			}
			else
			{
				$str .= sprintf("\r\n<br/>Gradient:%s >> %.1f%% >> %s", $rw[1], $s, $rw[0]);
			}
		}

		if ($this->thresholdHeight)
		{
			$str .= sprintf("\r\n<br/>Threshold Height:%s", $this->thresholdHeight);
		}

		if ($this->glidePathAngle)
		{
			$str .= sprintf("\r\n<br/>Glidepath Angle:%s", $this->glidePathAngle);
		}

		if ($this->displacedThreshold)
		{
			$str .= sprintf("\r\n<br/>Displaced Threshold:%s", $this->displacedThreshold);
		}

		if ($this->touchDownElevation)
		{
			$str .= sprintf("\r\n<br/>Touchdown Elevation:%s", $this->touchDownElevation);
		}

		if ($this->glideSlopeIndicator)
		{
			$p = new Parameter("vgsi" . $this->glideSlopeIndicator);
			
			$str .= sprintf("\r\n<br/>GlideSlope Indicator:<a class=\"tooltip\" href=\"#\">%s<span>%s</span></a>\r\n", $this->glideSlopeIndicator, $p->value1);
		}

		if ($this->visualRange)
		{
			$str .= sprintf("\r\n<br/>Visual Range:%s", $this->visualRange);
		}

		if ($this->visualValue)
		{
			$str .= sprintf("\r\n<br/>Visual Value:%s", $this->visualValue);
		}

		if ($this->als)
		{
			$p = new Parameter("als" . $this->als);
			
			$str .= sprintf("\r\n<br/>ALS:<a class=\"tooltip\" href=\"#\">%s<span>%s</span></a>\r\n", $this->als, $p->value1);
		}

		if ($this->reil)
		{
			$str .= sprintf("\r\n<br/>REIL:%s", $this->reil);
		}

		if ($this->centerline)
		{
			$str .= sprintf("\r\n<br/>Centerline:%s", $this->centerline);
		}

		if ($this->touchdown)
		{
			$str .= sprintf("\r\n<br/>Touchdown:%s", $this->touchdown);
		}

		if ($this->tora)
		{
			$str .= sprintf("\r\n<br/>tora:%s toda:%s", $this->tora, $this->toda);
		}

		if ($this->asda)
		{
			$str .= sprintf("\r\n<br/>asda:%s lda:%s", $this->asda, $this->lda);
		}

		if ($this->lahsoDistance)
		{
			$str .= sprintf("\r\n<br/>LAHSO Distance:%s", $this->lahsoDistance);
		}

		if ($this->lahsoRunway)
		{
			$str .= sprintf("\r\n<br/>LAHSO Runway:%s", $this->lahsoRunway);
		}

		if ($this->lahsoEntity)
		{
			$str .= sprintf("\r\n<br/>LAHSO Entity:%s", $this->lahsoEntity);
		}

		if ($this->singleWeight)
		{
			$str .= sprintf("\r\n<br/>Single Weight:%s", $this->singleWeight);
		}

		if ($this->dualWeight)
		{
			$str .= sprintf("\r\n<br/>Dual Weight:%s", $this->dualWeight);
		}

		if ($this->tandemWeight)
		{
			$str .= sprintf("\r\n<br/>Tandem Weight:%s", $this->tandemWeight);
		}

		if ($this->doubleTandemWeight)
		{
			$str .= sprintf("\r\n<br/>Double Tandem Weight:%s", $this->doubleTandemWeight);
		}

		// ILS entry for the ils at each end of the runway
		if (count($this->ils) > 0)
		{
			foreach ($this->ils as $ils)
			{
				$str .= $ils->ListEntries();
			}
		}

		// the arresting system at each end of the runway
		if (count($this->arresting) > 0)
		{
			$str .= "\r\n<br/><br/>Arresting:";

			foreach ($this->arresting as $ars)
			{
				$str .= $ars->ListEntries();
			}
		}

		return $str;
	}

	public function FormatPlanInfo()
	{
		$str  = sprintf("%s", $this->runwayId);
		
		$str .= sprintf(" l:%s", $this->length);
		
		$str .= sprintf(" w:%s", $this->width);
		
		$str .= sprintf(" s:%s", $this->surface);

		if ($this->edgeLighting)
		{
			$str .= sprintf("\r\n<br/>lt:%s", $this->edgeLighting);
		}

		if ($this->righthandTraffic)
		{
			$str .= sprintf(" rh:%s", $this->righthandTraffic);
		}

		if ($this->als)
		{
			$str .= sprintf(" als:%s", $this->als);
		}

		if ($this->reil)
		{
			$str .= sprintf(" reil:%s", $this->reil);
		}

		if ($this->displacedThreshold)
		{
			$str .= sprintf(" disp:%s", $this->displacedThreshold);
		}

		if ($this->tora)
		{
			$str .= sprintf("\r\n<br/>tora:%s", $this->tora);
		}

		if ($this->toda)
		{
			$str .= sprintf(" toda:%s", $this->toda);
		}

		if ($this->asda)
		{
			$str .= sprintf(" asda:%s", $this->asda);
		}

		if ($this->lda)
		{
			$str .= sprintf(" lda:%s", $this->lda);
		}

		if ($this->lahsoDistance)
		{
			$str .= sprintf("\r\n<br/>lahso:%s", $this->lahsoDistance);
			
			$str .= sprintf(" %s", $this->lahsoRunway);
			
			$str .= sprintf(" %s", $this->lahsoEntity);
		}

		if ($this->singleWeight)
		{
			$str .= sprintf("\r\n<br/>lb:S-%d", ($this->singleWeight * 1000)/1000);
		}

		if ($this->dualWeight)
		{
			$str .= sprintf(" D-%d", ($this->dualWeight * 1000)/1000);
		}

		if ($this->tandemWeight)
		{
			$str .= sprintf(" ST-%d", ($this->tandemWeight * 1000)/1000);
		}

		if ($this->doubleTandemWeight)
		{
			$str .= sprintf(" DT-%d", ($this->doubleTandemWeight * 1000)/1000);
		}

		// ILS entry for the ils at each end of the runway
		if (count($this->ils) > 0)
		{
			foreach ($this->ils as $ils)
			{
				$str .= $ils->FormatPlanInfo();
				
				$rwy = $ils->ilsApproach->GetSingle(0);

				// the arresting system at each end of the runway
				if (count($this->arresting) > 0)
				{
					foreach ($this->arresting as $ars)
					{
						$str .= $ars->FormatPlanInfo($rwy->runway);
					}
				}
			}
		}

		return $str;
	}

	public function FormatInfobox()
	{
		if ($this->surface != null)
		{
			return sprintf("<br/>%s %s %s %s", $this->runwayId, $this->length, $this->width, $this->surface);
		}
		
		return sprintf("<br/>%s %s %s", $this->runwayId, $this->length, $this->width);
	}

	public function FormatXML()
	{
		$str  = sprintf("<rway>");
		
		$str .= sprintf("%s %s %s %s", $this->runwayId, $this->length, $this->width, $this->surface);
		
		$str .= sprintf("</rway>");

		return $str;
	}
}

class AirportRunway
{
	public $sess;
	public $runway = array();

	public function __construct($sess, $sql)
	{
		$this->sess = $sess;

		$aptDbase = new Database();
		
		$aptDbase->ExecSql($sql);

		if ($aptDbase->GetRowCount() > 0)
		{
			while($row = $aptDbase->FetchRow())
			{
				$this->GetRow($row);
			}
		}
		else
		{
			$this->runway = null;
		}

		$aptDbase->Disconnect();
	}

	public function GetRow($row)
	{
		$airportRunwayData = new AirportRunwayData($this->sess);

		$airportRunwayData->id = $row["id"];
		$airportRunwayData->facilityId = $row["facilityId"];
		$airportRunwayData->runwayId = $row["runwayId"];
		$airportRunwayData->length = $row["length"];
		$airportRunwayData->width = $row["width"];
		$airportRunwayData->surface = $row["surface"];
		$airportRunwayData->surfaceTreatment = $row["surfaceTreatment"];
		$airportRunwayData->pavementClass = $row["pavementClass"];
		$airportRunwayData->edgeLighting = $row["edgeLighting"];
		$airportRunwayData->ilsType = $row["ilsType"];
		$airportRunwayData->righthandTraffic = $row["righthandTraffic"];
		$airportRunwayData->markingCondition = $row["markingCondition"];
		$airportRunwayData->latitude = $row["latitude"];
		$airportRunwayData->longitude = $row["longitude"];
		$airportRunwayData->elevation = $row["elevation"];
		$airportRunwayData->thresholdHeight = $row["thresholdHeight"];
		$airportRunwayData->glidePathAngle = $row["glidePathAngle"];
		$airportRunwayData->displacedThreshold = $row["displacedThreshold"];
		$airportRunwayData->touchDownElevation = $row["touchDownElevation"];
		$airportRunwayData->glideSlopeIndicator = $row["glideSlopeIndicator"];
		$airportRunwayData->visualRange = $row["visualRange"];
		$airportRunwayData->visualValue = $row["visualValue"];
		$airportRunwayData->als = $row["als"];
		$airportRunwayData->reil = $row["reil"];
		$airportRunwayData->centerline = $row["centerline"];
		$airportRunwayData->touchdown = $row["touchdown"];
		$airportRunwayData->relevation = $row["relevation"];
		$airportRunwayData->tora = $row["tora"];
		$airportRunwayData->toda = $row["toda"];
		$airportRunwayData->asda = $row["asda"];
		$airportRunwayData->lda = $row["lda"];
		$airportRunwayData->lahsoDistance = $row["lahsoDistance"];
		$airportRunwayData->lahsoRunway = $row["lahsoRunway"];
		$airportRunwayData->lahsoEntity = $row["lahsoEntity"];
		$airportRunwayData->singleWeight = $row["singleWeight"];
		$airportRunwayData->dualWeight = $row["dualWeight"];
		$airportRunwayData->tandemWeight = $row["tandemWeight"];
		$airportRunwayData->doubleTandemWeight = $row["doubleTandemWeight"];

		$rwya = explode("/", $airportRunwayData->runwayId);
		
		foreach ($rwya as $rwy)
		{
			$rwyIls = new Ils($this->sess, $airportRunwayData->facilityId, $rwy);
			
			if ($rwyIls->ilsApproach->approach)
			{
				array_push($airportRunwayData->ils, $rwyIls);
			}

			$sql = sprintf("SELECT * FROM aptArresting USE INDEX(aptArrestingFacilityId) WHERE facilityId='%s' AND arrestingEnd='%s'", $airportRunwayData->facilityId, $rwy);

			$rwyArs = new AirportArresting($sql);
			
			if ($rwyArs->airportArresting)
			{
				array_push($airportRunwayData->arresting, $rwyArs);
			}
		}

		array_push($this->runway, $airportRunwayData);
	}

	public function GetSingle($i)
	{
		if ($this->runway == null)
		{
			return;
		}

		return $this->runway[$i];
	}

	public function ListEntries($header)
	{
		if ($this->runway == null)
		{
			return;
		}

		$str = "";

		$col = 1;
		
		foreach ($this->runway as $rwy)
		{
			switch($col)
			{
				case 1:
				{
					$str .= sprintf("<tr>\r\n");
					
					$str .= sprintf("<td>\r\n");
					
					break;
				}

				case 5:
				{
					$str .= sprintf("</tr>\r\n");
					
					$str .= sprintf("<tr>\r\n");
					
					$str .= sprintf("<td>\r\n");
					
					break;
				}

				case 9:
				{
					$str .= sprintf("</tr>\r\n");
					
					$str .= sprintf("<tr>\r\n");
					
					$str .= sprintf("<td>\r\n");
					
					break;
				}

				case 13:
				{
					$str .= sprintf("</tr>\r\n");
					
					$str .= sprintf("<tr>\r\n");
					
					$str .= sprintf("<td>\r\n");
					
					break;
				}

				default:
				{
					$str .= sprintf("<td>\r\n");
					
					break;
				}
			}

			if (($header) && ($col == 1))
			{
				$str .= sprintf("<b>RUNWAYS</b><br/>\r\n");
			}
			else
			{
				$str .= sprintf("<br/>\r\n");
			}

			$col++;

			$str .= $rwy->FormatEntry();

			$str .= sprintf("</td>\r\n");
		}

		$str .= sprintf("</tr>\r\n");

		return $str;
	}

	public function FormatPlanInfo()
	{
		if ($this->runway == null)
		{
			return;
		}

		$str = null;
		
		$firstOne = true;

		foreach ($this->runway as $rwy)
		{
			if ($firstOne)
			{
				$firstOne = false;
			}
			else
			{
				$str .= "\r\n<br/><br/>";
			}

			$str .= $rwy->FormatPlanInfo();
		}

		return $str;
	}

	public function FormatAirportList()
	{
		if ($this->runway == null)
		{
			return;
		}

		$str = null;

		foreach ($this->runway as $rwy)
		{
			$str .= "<tr>";
			
			$str .= $rwy->FormatAirportList();
			
			$str .= "</tr>";
		}

		return $str;
	}

	public function FormatInfobox()
	{
		if ($this->runway == null)
		{
			return;
		}

		$str = null;

		foreach ($this->runway as $rwy)
		{
			$str .= $rwy->FormatInfobox();
		}

		return $str;
	}

	public function GetIcon()
	{
		if ($this->runway == null)
		{
			return;
		}

		$icon = null;

		$c = 0;
		$t = 0;
		$w = 0;

		foreach ($this->runway as $rwy)
		{
			switch(substr($rwy->surface, 0 ,4))
			{
				case "ALUM":
				{
					$t = 1;

					break;
				}

				case "ASPH":
				{
					$c = 1;

					break;
				}

				case "BRIC":
				{
					$t = 1;

					break;
				}

				case "CALI":
				{
					$t = 1;

					break;
				}

				case "CONC":
				{
					$c = 1;

					break;
				}

				case "CORA":
				{
					$t = 1;

					break;
				}

				case "DECK":
				{
					$t = 1;

					break;
				}

				case "DIRT":
				{
					$t = 1;

					break;
				}

				case "GRAS":
				{
					$t = 1;

					break;
				}

				case "GRAV":
				{
					$t = 1;

					break;
				}

				case "GRE":
				{
					$t = 1;

					break;
				}

				case "GRVL":
				{
					$t = 1;

					break;
				}

				case "MATS":
				{
					$t = 1;

					break;
				}

				case "META":
				{
					$t = 1;

					break;
				}

				case "NSTD":
				{
					$t = 1;

					break;
				}

				case "OIL&":
				{
					$t = 1;

					break;
				}

				case "PEM":
				{
					$c = 1;

					break;
				}

				case "PEM-":
				{
					$c = 1;

					break;
				}

				case "PFC":
				{
					$t = 1;

					break;
				}

				case "PSP":
				{
					$t = 1;

					break;
				}

				case "ROOF":
				{
					$t = 1;

					break;
				}

				case "SAND":
				{
					$t = 1;

					break;
				}

				case "SOD":
				{
					$t = 1;

					break;
				}

				case "STEE":
				{
					$t = 1;

					break;
				}

				case "TREA":
				{
					$t = 1;

					break;
				}

				case "TRTD":
				{
					$t = 1;

					break;
				}

				case "TUIR":
				{
					$t = 1;

					break;
				}

				case "TURF":
				{
					$t = 1;

					break;
				}

				case "WATE":
				{
					$w = 1;

					break;
				}

				case "WOOD":
				{
					$t = 1;

					break;
				}
			}
		}

		if (($c == 1) && ($t == 1))
		{
			$icon = "../images/airportBoth.png";
		}
		else if ($c == 1)
		{
			$icon = "../images/airport.png";
		}
		else if ($t == 1)
		{
			$icon = "../images/airportTurf.png";
		}
		else
		{
			$icon = "../images/airportWater.png";
		}

		return $icon;
	}

	public function FormatXML()
	{
		if ($this->runway == null)
		{
			return;
		}

		$str = null;

		foreach ($this->runway as $rwy)
		{
			$str .= $rwy->FormatXML();
		}

		return $str;
	}
}
?>