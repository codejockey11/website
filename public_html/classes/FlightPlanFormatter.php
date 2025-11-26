<?php
class FlightPlanFormatter
{
	public $sess;

	public $error = array();
	public $valid = true;

	public $waypoint = array();
	public $waypointCount;

	public $weather;
	public $windSpeed;
	public $windDir;

	public $wp = array();
	public $airway = array();

	public $totalDistance;
	public $totalTime;

	public $alternate1;
	public $alternate2;
	public $alternate3;

	public $metar = array();
	public $station = array();
	public $taf = array();

	public $DEPART;
	public $ARRIVE;

	public function AddDepartureProcedure($apch)
	{
		$apch = explode(";", $apch);

		// Create the instrument approach object for final approach or transition to final approach
		$sql = sprintf("SELECT * FROM cifp WHERE facilityId='%s' AND siapId='%s' AND transition='%s'", $apch[1], $apch[2], $apch[3]);

		$cifp = new CodedInstrumentFlightProcedure($this->sess, $sql);

		return $cifp->DepartureList($apch[1], $apch[2], $apch[4]);
	}

	public function AddTerminalArrivalProcedure($apch)
	{
		$apch = explode(";", $apch);

		// Create the instrument approach object for final approach or transition to final approach
		$sql = sprintf("SELECT * FROM cifp WHERE facilityId='%s' AND siapId='%s' AND transition='%s'", $apch[1], $apch[2], $apch[3]);

		$cifp = new CodedInstrumentFlightProcedure($this->sess, $sql);

		return $cifp->ArrivalList($apch[1], $apch[2], $apch[4]);
	}

	public function AddInstrumentApproachProcedure($apch)
	{
		$apch = explode(";", $apch);

		// Create the instrument approach object for final approach or transition to final approach
		$sql = sprintf("SELECT * FROM cifp WHERE facilityId='%s' AND siapId='%s' AND transition=''", $apch[1], $apch[2]);

		$cifp = new CodedInstrumentFlightProcedure($this->sess, $sql);

		return $cifp->ApproachList($apch[3]);
	}

	public function AddAirway($awy, $f, $t)
	{
		// Strip the @ and grab the airway name
		$awy = trim(str_replace("@", "", $awy));

		// Create the airway object for the from-to-point and airway
		$airway = new Airway($this->sess, $f, $t, null, $awy);

		return $airway->WaypointList();
	}

	public function __construct($sess)
	{
		$this->sess = $sess;

		if ($this->sess->waypoints == null)
		{
			$this->valid = false;

			return;
		}

		$this->wp = explode(" ", $this->sess->waypoints);

		// ==================================================================================================
		// Replacing the waypoint when a STAR, DP, IAP, or airway is found
		// ==================================================================================================
		$found = false;

		for ($e = 1;$e < (count($this->wp) - 1);$e++)
		{
			switch (substr($this->wp[$e], 0, 1))
			{
				// Departure Procedure
				case "D":
				{
					$found = true;

					$pointa = explode(";", $this->wp[$e]);

					if (count($pointa) != 5)
					{
						array_push($this->error, sprintf("Instrument Procedure D;ICAO;siapId;transition;transition2: %s", $this->wp[$e]));

						$this->valid = false;

						$this->wp[$e] = null;

						break;
					}

					$this->wp[$e] = $this->AddDepartureProcedure($this->wp[$e]);

					break;
				}

				// Terminal Arrival Procedure
				case "S":
				{
					$found = true;

					$pointa = explode(";", $this->wp[$e]);

					if (count($pointa) != 5)
					{
						array_push($this->error, sprintf("Instrument Procedure S;ICAO;siapId;transition;transition2: %s", $this->wp[$e]));

						$this->valid = false;

						$this->wp[$e] = null;

						break;
					}

					$this->wp[$e] = $this->AddTerminalArrivalProcedure($this->wp[$e]);

					break;
				}

				// Instrument Approach Procedure
				case "I":
				{
					$found = true;

					$pointa = explode(";", $this->wp[$e]);

					if (count($pointa) != 4)
					{
						array_push($this->error, sprintf("Instrument Procedure I;ICAO;siapId;transition: %s", $this->wp[$e]));

						$this->valid = false;

						$this->wp[$e] = null;

						break;
					}

					$this->wp[$e] = $this->AddInstrumentApproachProcedure($this->wp[$e]);

					break;
				}

				// Airway
				case "@":
				{
					$found = true;

					$f = explode(";", $this->wp[$e - 1]);

					$t = explode(";", $this->wp[$e + 1]);

					if (count($t) > 1)
					{
						$this->wp[$e] = $this->AddAirway($this->wp[$e], $f[1], $t[1]);
					}
					else
					{
						$this->wp[$e] = $this->AddAirway($this->wp[$e], $f[1], null);
					}

					break;
				}
			}
		}

		// Some kind of route was found so rebuild the waypoint array
		if ($found)
		{
			$waypoints = null;

			for ($e = 0;$e < (count($this->wp) - 1);$e++)
			{
				if ($this->wp[$e] != null)
				{
					$waypoints .= $this->wp[$e] . " ";
				}
			}

			// Append the last waypoint name
			$waypoints .= $this->wp[(count($this->wp) - 1)];

			$this->wp = explode(" ", $waypoints);

			$tempWaypoints = array();

			$prevWaypoint = null;

			for ($e = 0;$e < (count($this->wp) - 1);$e++)
			{
				if ($this->wp[$e] != $prevWaypoint)
				{
					array_push($tempWaypoints, $this->wp[$e]);

					$prevWaypoint = $this->wp[$e];
				}
			}

			// Append the last waypoint name
			array_push($tempWaypoints, $this->wp[(count($this->wp) - 1)]);

			$this->wp = $tempWaypoints;

			unset($tempWaypoints);
		}

		// ==================================================================================================
		// Build the waypoint plan data
		// ==================================================================================================
		foreach ($this->wp as $point)
		{
			$pointa = explode(";", $point);

			switch($pointa[0])
			{
				case "A":
				{
					$sql = sprintf("SELECT * FROM aptAirport USE INDEX(aptAirportICAO) WHERE ICAO='%s'", $pointa[1]);

					if (count($pointa) == 3)
					{
						$sql = sprintf("SELECT * FROM aptAirport WHERE id='%s'", $pointa[2]);
					}

					$apt = new Airport($this->sess, $sql);

					if ($apt->airport == null)
					{
						array_push($this->error, sprintf("Airport not found:%s", $pointa[1]));

						$this->valid = false;
					}
					else
					{
						array_push($this->waypoint, new Waypoint($this->sess, "A", $pointa[1], $apt));
					}

					break;
				}

				case "F":
				{
					$sql = sprintf("SELECT * FROM fixLocation USE INDEX(fixLocationFixId) WHERE fixId='%s'", $pointa[1]);

					if (count($pointa) == 3)
					{
						$sql = sprintf("SELECT * FROM fixLocation WHERE id='%s'", $pointa[2]);
					}

					$fix = new Fix($this->sess, $sql);

					if ($fix->fix == null)
					{
						array_push($this->error, sprintf("Fix not found:%s", $pointa[1]));

						$this->valid = false;
					}
					else
					{
						array_push($this->waypoint, new Waypoint($this->sess, "F", $pointa[1], $fix));
					}

					break;
				}

				case "G":
				{
					$p = new Waypoint($this->sess, "G", $point, null);

					$p->latLon = new LatLon($pointa[1], $pointa[2]);

					$p->desc = $pointa[3];

					if (count($pointa) == 5)
					{
						if ($pointa[4] === "")
						{
							if (function_exists("getDeclination"))
							{
								$today = date("Y.z");

								$p->magVar = getDeclination($p->latLon->decimalLat, $p->latLon->decimalLon, $today);
							}
							else
							{
								$p->magVar = 0.0;
							}
						}
						else
						{
							$p->magVar = $pointa[4];
						}

						array_push($this->waypoint, $p);
					}
					else if (count($pointa) == 4)
					{
						if (function_exists("getDeclination"))
						{
							$today = date("Y.z");

							$p->magVar = getDeclination($p->latLon->decimalLat, $p->latLon->decimalLon, $today);
						}
						else
						{
							$p->magVar = 0.0;
						}

						array_push($this->waypoint, $p);
					}
					else
					{
						array_push($this->error, sprintf("GPS format G;lat;lon;name;magVar: %s", $point));

						$this->valid = false;
					}

					break;
				}

				case "N":
				{
					$sql = sprintf("SELECT * FROM navNavaid USE INDEX(navNavaidFacilityId) WHERE facilityId='%s' AND type!='VOT'", $pointa[1]);

					if (count($pointa) == 3)
					{
						$sql = sprintf("SELECT * FROM navNavaid WHERE id='%s'", $pointa[2]);
					}

					$nav = new Navaid($this->sess, $sql);

					if ($nav->navaid == null)
					{
						array_push($this->error, sprintf("Navaid not found:%s", $pointa[1]));

						$this->valid = false;
					}
					else
					{
						array_push($this->waypoint, new Waypoint($this->sess, "N", $pointa[1], $nav));
					}

					break;
				}

				default:
				{
					array_push($this->error, sprintf("There is an Invalid Waypoint Type"));

					$this->valid = false;

					break;
				}
			}
		}

		$this->waypointCount = count($this->waypoint);

		$this->DEPART = 0;

		$this->ARRIVE = $this->waypointCount - 1;

		// ==================================================================================================
		// Airspeed is required
		// ==================================================================================================
		if (!is_numeric($this->sess->speed))
		{
			array_push($this->error, sprintf("Enter a number for Speed:%s", $this->sess->speed));

			$this->valid = false;
		}

		// ==================================================================================================
		// Check the weather
		// ==================================================================================================
		if (($this->sess->weather) && ($this->sess->waypoints))
		{
			array_push($this->error, sprintf("Weather not supported"));

			$this->valid = false;
		}

		/*
			if (!is_numeric($this->sess->weather))
			{
				array_push($this->error, sprintf("Enter a numerical mile radius for Weather:%s", $this->sess->weather));

				$this->valid = false;
			}
			else if ($this->sess->weather > 75)
			{
				array_push($this->error, sprintf("Weather is greater than 75"));

				$this->valid = false;
			}
			else
			{
				// Grab the weather stations along the flight path for the given radius
				$parms = new Parameter("metarsFlightPath");

				$xml = sprintf("%s%s", $parms->value1, $this->sess->weather);

				foreach ($this->waypoint as $wayp)
				{
					switch($wayp->type)
					{
						case "A":
						{
							$apt = $wayp->class->GetSingle(0);

							$xml .= sprintf(";%s,%s", $apt->latLon->decimalLon, $apt->latLon->decimalLat);

							break;
						}

						case "F":
						{
							$fix = $wayp->class->GetSingle(0);

							$xml .= sprintf(";%s,%s", $fix->latLon->decimalLon, $fix->latLon->decimalLat);

							break;
						}

						case "G":
						{
							$xml .= sprintf(";%s,%s", $wayp->latLon->decimalLon, $wayp->latLon->decimalLat);

							break;
						}

						case "N":
						{
							$nav = $wayp->class->GetSingle(0);

							$xml .= sprintf(";%s,%s", $nav->latLon->decimalLon, $nav->latLon->decimalLat);

							break;
						}

						default:
						{
							break;
						}
					}
				}

				$sr = new SimpleRequest($xml);

				if ($sr->xml !== false)
				{
					foreach ($sr->xml->data->METAR as $mtr)
					{
						$stn = trim($mtr->station_id);

						if (array_search($stn, $this->metar) === false)
						{
							array_push($this->metar, $stn);

							array_push($this->station, new Station($stn));

							array_push($this->taf, new TAF($stn));
						}
					}
				}
			}
		}
*/
		// ==================================================================================================
		// Check the winds
		// ==================================================================================================
		if ($this->sess->winds)
		{
			$ws = explode("/", $this->sess->winds);

			if (count($ws) != 2)
			{
				array_push($this->error, sprintf("Wind direction/speed: %s", $pointa[1]));

				$this->valid = false;
			}
			else
			{
				$this->windDir = $ws[0];

				if (!is_numeric($this->windDir))
				{
					array_push($this->error, sprintf("Enter a numerical Degree for Winds:%s", $this->sess->winds));

					$this->valid = false;
				}

				$this->windSpeed = $ws[1];

				if (!is_numeric($this->windSpeed))
				{
					array_push($this->error, sprintf("Enter knots for Winds:%s", $this->sess->winds));

					$this->valid = false;
				}
			}
		}

		// ==================================================================================================
		// Check the alternates
		// ==================================================================================================
		if ($this->sess->alternate1)
		{
			if (strlen($this->sess->alternate1) == 3)
			{
				$sql = sprintf("SELECT * FROM aptAirport USE INDEX(aptAirportFacilityId) WHERE facilityId='%s'", $this->sess->alternate1);
			}
			else
			{
				$sql = sprintf("SELECT * FROM aptAirport USE INDEX(aptAirportICAO) WHERE ICAO='%s'", $this->sess->alternate1);
			}

			$this->alternate1 = new Airport($this->sess, $sql);

			if ($this->alternate1->airport == null)
			{
				array_push($this->error, sprintf("Alternate Airport not valid:%s", $this->sess->alternate1));

				$this->valid = false;
			}
		}

		if ($this->sess->alternate2)
		{
			if (strlen($this->sess->alternate2) == 3)
			{
				$sql = sprintf("SELECT * FROM aptAirport USE INDEX(aptAirportFacilityId) WHERE facilityId='%s'", $this->sess->alternate2);
			}
			else
			{
				$sql = sprintf("SELECT * FROM aptAirport USE INDEX(aptAirportICAO) WHERE ICAO='%s'", $this->sess->alternate2);
			}

			$this->alternate2 = new Airport($this->sess, $sql);

			if ($this->alternate2->airport == null)
			{
				array_push($this->error, sprintf("Alternate Airport not valid:%s", $this->sess->alternate2));

				$this->valid = false;
			}
		}

		if ($this->sess->alternate3)
		{
			if (strlen($this->sess->alternate3) == 3)
			{
				$sql = sprintf("SELECT * FROM aptAirport USE INDEX(aptAirportFacilityId) WHERE facilityId='%s'", $this->sess->alternate3);
			}
			else
			{
				$sql = sprintf("SELECT * FROM aptAirport USE INDEX(aptAirportICAO) WHERE ICAO='%s'", $this->sess->alternate3);
			}

			$this->alternate3 = new Airport($this->sess, $sql);

			if ($this->alternate3->airport == null)
			{
				array_push($this->error, sprintf("Alternate Airport not valid:%s", $this->sess->alternate3));

				$this->valid = false;
			}
		}

		// ==================================================================================================
		// return if any errors
		// ==================================================================================================
		if ($this->valid == false)
		{
			return;
		}

		// ==================================================================================================
		// Calculate waypoints course information
		// ==================================================================================================
		$depart = $this->waypoint[$this->DEPART];

		$arrive = $this->waypoint[$this->ARRIVE];

		for ($e = 0;$e < $this->waypointCount - 1;$e++)
		{
			$this->waypoint[$e]->CalculateCourse($this->waypoint[$e + 1]);

			$depart->distanceRemain += $this->waypoint[$e]->distance;

			$depart->timeRemain += $this->waypoint[$e]->time;

			$depart->timeRemainCorr += $this->waypoint[$e]->timeCorr;

			$this->waypoint[$e]->from = $this->waypoint[$e]->name;

			$this->waypoint[$e]->to = $this->waypoint[$e + 1]->name;
		}

		$this->totalDistance = $depart->distanceRemain;

		$this->totalTime = $depart->timeRemain;
/*
        // FIXME? Pilot's decision?
		// Distance remaining after leg is flown
		$depart->distanceRemain -= $this->waypoint[$this->DEPART]->distance;
		$depart->timeRemain -= $this->waypoint[$this->DEPART]->time;

		// Calculate each waypoints distances
		for ($e=1;$e<$this->waypointCount-1;$e++)
		{
			$this->waypoint[$e]->distanceRemain = $this->waypoint[$e-1]->distanceRemain - $this->waypoint[$e]->distance;
			$this->waypoint[$e]->timeRemain = $this->waypoint[$e-1]->timeRemain - $this->waypoint[$e]->time;
		}
*/
        // FIXME? Pilot's decision?
		// Total distance remaining before leg is flown
		for ($e = 1;$e < $this->waypointCount - 1;$e++)
		{
			$this->waypoint[$e]->distanceRemain = $this->waypoint[$e - 1]->distanceRemain - $this->waypoint[$e - 1]->distance;

			$this->waypoint[$e]->timeRemain = $this->waypoint[$e - 1]->timeRemain - $this->waypoint[$e - 1]->time;

			if ($this->sess->winds)
			{
				$this->waypoint[$e]->timeRemainCorr = $this->waypoint[$e - 1]->timeRemainCorr - $this->waypoint[$e - 1]->timeCorr;
			}
		}
	}

	public function FormatPlan()
	{
		// ==================================================================================================
		// Errors
		// ==================================================================================================
		if (count($this->error) > 0)
		{
			printf("<p class=\"error\">\r\n");

			foreach ($this->error as $err)
			{
				printf("%s<br/>\r\n", $err);
			}

			printf("</p>\r\n");

			return;
		}

		// ==================================================================================================
		// Headings
		// ==================================================================================================
		printf("<table class=\"planner\">\r\n");

		if ($this->sess->loggedOn ==  1)
		{
			printf("<tr>\r\n");

			if ($this->sess->winds)
			{
				printf("<td colspan=\"10\" class=\"planeInfo\">\r\n");
			}
			else
			{
				printf("<td colspan=\"6\" class=\"planeInfo\">\r\n");
			}

			if ($this->sess->registration == null)
			{
				printf("No Plane Selected");

				if ($this->sess->speed > 0)
				{
					printf(" Knots:%s", $this->sess->speed);
				}

				if ($this->sess->altitude > 0)
				{
					printf(" Altitude:%s", $this->sess->altitude);
				}

				if ($this->sess->winds)
				{
					printf(" Winds:%s", $this->sess->winds);
				}
			}
			else
			{
				$p = new Airplane($this->sess, $this->sess->registration);

				$pln = $p->GetSingle(0);

				if ($pln)
				{
					printf(" %s %s", $pln->registration, $pln->plane);

					if ($this->sess->speed > 0)
					{
						printf(" Knots:%s", $this->sess->speed);
					}

					if ($this->sess->altitude > 0)
					{
						printf(" Altitude:%s", $this->sess->altitude);
					}

					if ($this->sess->winds)
					{
						printf(" Winds:%s", $this->sess->winds);
					}

					if ($pln->enrouteTime != $this->totalTime)
					{
						printf("<b class=\"planeInfoError\"><br/>Check Time %s</b>", $pln->FuelBurn());
					}
					else
					{
						printf("%s", $pln->FuelBurn());
					}
				}
			}

			printf("</td>\r\n");

			printf("</tr>\r\n");
		}

		if ($this->sess->winds)
		{
			printf("<tr>\r\n");

			printf("<td class=\"plannerwpcorr\"></td>\r\n");

			printf("<td></td>\r\n");

			printf("<td></td>\r\n");

			printf("<td></td>\r\n");

			printf("<td></td>\r\n");

			printf("<td></td>\r\n");

			printf("<td class=\"plannerwp\" colspan=\"4\">Corrected</td>\r\n");

			printf("</tr>\r\n");
		}

		printf("<tr>\r\n");

		printf("<td class=\"plannerInfoHeading\">Waypoint Info</td>\r\n");

		printf("<td class=\"plannerwp\">Heading<br/>Radial</td>\r\n");

		printf("<td class=\"plannerwp\">Leg<br/>Distance</td>\r\n");

		printf("<td class=\"plannerwp\">Distance<br/>Remain</td>\r\n");

		printf("<td class=\"plannerwp\">Leg<br/>Time</td>\r\n");

		printf("<td class=\"plannerwp\">Time<br/>Remain</td>\r\n");

		if ($this->sess->winds)
		{
			printf("<td class=\"plannerwp\"><br/>Heading</td>\r\n");

			printf("<td class=\"plannerwp\">Ground<br/>Speed</td>\r\n");

			printf("<td class=\"plannerwp\">Leg<br/>Time</td>\r\n");

			printf("<td class=\"plannerwp\">Time<br/>Remain</td>\r\n");
		}

		printf("</tr>\r\n");

		// ==================================================================================================
		// Departure pdf docs
		// ==================================================================================================

		// Create the pdf menu
		$fn = sprintf("../temp/pdfMenu_%s.html", $this->sess->sessionId);

		$fp = fopen($fn, "wb");

		$pdfMenu = "";

		$ft = "1";

		// ==================================================================================================
		// Waypoints
		// ==================================================================================================
		for ($e = 0;$e < $this->waypointCount;$e++)
		{
			printf("<tr>\r\n");

			$this->waypoint[$e]->WaypointInfo();

			$this->waypoint[$e]->WaypointData();

			// If it's a airport add its pdf items to the menu
			if ($this->waypoint[$e]->type == "A")
			{
				if ($apt = $this->waypoint[$e]->class->GetSingle(0))
				{
					if ($ft == "1")
					{
						$ft = null;
					}
					else
					{
						$pdfMenu .= "\r\n<br/>";
					}

					$pdfMenu .= "<b>" . $apt->facilityId . ":" . $apt->name . "</b>";

					$pdfMenu .= $apt->PdfMenu();
				}
			}

			// If it's a fix add its pdf items to the menu
			if ($this->waypoint[$e]->type == "F")
			{
				if ($fix = $this->waypoint[$e]->class->GetSingle(0))
				{
					if ($ft == "1")
					{
						$ft = null;
					}
					else
					{
						$pdfMenu .= "\r\n<br/>";
					}

					$pdfMenu .= "<b>" . $fix->fixId . ":" . $fix->state . "</b>";

					$pdfMenu .= $fix->PdfMenu();
				}
			}

			// If it's a navaid add its pdf items to the menu
			if ($this->waypoint[$e]->type == "N")
			{
				if ($nav = $this->waypoint[$e]->class->GetSingle(0))
				{
					if ($nav->cs->GetSingle(0))
					{
						if ($ft == "1")
						{
							$ft = null;
						}
						else
						{
							$pdfMenu .= "\r\n<br/>";
						}

						$pdfMenu .= "<b>" . $nav->name . "</b>";

						$pdfMenu .= $nav->PdfMenu();
					}
				}
			}

			printf("</tr>\r\n");
		}

		printf("</table>\r\n");

		// ==================================================================================================
		// Airport Information
		// ==================================================================================================
		$depart = $this->waypoint[$this->DEPART]->class->GetSingle(0);

		$arrive = $this->waypoint[$this->ARRIVE]->class->GetSingle(0);

		printf("<table class=\"planner\" style=\"position:relative;top:-1px;\">\r\n");

		printf("<tr>\r\n");

		printf("<td class=\"plannerInfo\">\r\n");

		printf("%s", $depart->tower->FormatPlanInfo($depart));

		printf("</td>\r\n");

		printf("<td class=\"plannerInfo\" colspan=\"4\">\r\n");

		printf("%s", $arrive->tower->FormatPlanInfo($arrive));

		printf("</td>\r\n");

		printf("</tr>\r\n");

		printf("<tr>\r\n");

		printf("<td class=\"plannerInfo\">\r\n");

		printf("%s", $depart->FormatRunwayInfo());

		printf("</td>\r\n");

		printf("<td class=\"plannerInfo\" colspan=\"4\">\r\n");

		printf("%s", $arrive->FormatRunwayInfo());

		printf("</td>\r\n");

		printf("</tr>\r\n");

		printf("<tr>\r\n");

		printf("<td class=\"plannerInfo\">\r\n");


		printf("%s", $depart->FormatPlanInfo());

		printf("</td>\r\n");

		printf("<td class=\"plannerInfo\" colspan=\"4\">\r\n");

		printf("%s", $arrive->FormatPlanInfo());

		printf("</td>\r\n");

		printf("</tr>\r\n");

		// ==================================================================================================
		// Alternates Information
		// ==================================================================================================
		if ($this->sess->alternate1)
		{
			printf("<tr>\r\n");

			printf("<td class=\"plannerInfo\">Alternate:%s<br/>\r\n", $this->sess->alternate1);

			$apt = $this->alternate1->GetSingle(0);

			printf("%s", $apt->tower->FormatPlanInfo($apt));

			printf("</td>\r\n");

			printf("<td class=\"plannerInfo\" colspan=\"4\">Alternate:%s<br/>\r\n", $this->sess->alternate1);

			printf("%s", $apt->FormatRunwayInfo());

			printf("</td>\r\n");

			printf("<td class=\"plannerInfo\" colspan=\"4\">Alternate:%s<br/>\r\n", $this->sess->alternate1);

			printf("%s", $apt->FormatPlanInfo());

			$pdfMenu .= "\r\n<br/>";

			$pdfMenu .= "<b>" . $apt->facilityId . ":" . $apt->name . "</b>";

			$pdfMenu .= $apt->PdfMenu();

			printf("</td>\r\n");

			printf("</tr>\r\n");
		}

		if ($this->sess->alternate2)
		{
			printf("<tr>\r\n");

			printf("<td class=\"plannerInfo\">Alternate:%s<br/>\r\n", $this->sess->alternate2);

			$apt = $this->alternate2->GetSingle(0);

			printf("%s", $apt->tower->FormatPlanInfo($apt));

			printf("</td>\r\n");

			printf("<td class=\"plannerInfo\" colspan=\"4\">Alternate:%s<br/>\r\n", $this->sess->alternate2);

			printf("%s", $apt->FormatRunwayInfo());

			printf("</td>\r\n");

			printf("<td class=\"plannerInfo\" colspan=\"4\">Alternate:%s<br/>\r\n", $this->sess->alternate2);

			printf("%s", $apt->FormatPlanInfo());

			$pdfMenu .= "\r\n<br/>";

			$pdfMenu .= "<b>" . $apt->facilityId . ":" . $apt->name . "</b>";

			$pdfMenu .= $apt->PdfMenu();

			printf("</td>\r\n");

			printf("</tr>\r\n");
		}

		if ($this->sess->alternate3)
		{
			printf("<tr>\r\n");

			printf("<td class=\"plannerInfo\">Alternate:%s<br/>\r\n", $this->sess->alternate3);

			$apt = $this->alternate3->GetSingle(0);

			printf("%s", $apt->tower->FormatPlanInfo($apt));

			printf("</td>\r\n");

			printf("<td class=\"plannerInfo\" colspan=\"4\">Alternate:%s<br/>\r\n", $this->sess->alternate3);

			printf("%s", $apt->FormatRunwayInfo());

			printf("</td>\r\n");

			printf("<td class=\"plannerInfo\" colspan=\"4\">Alternate:%s<br/>\r\n", $this->sess->alternate3);

			printf("%s", $apt->FormatPlanInfo());

			$pdfMenu .= "\r\n<br/>";

			$pdfMenu .= "<b>" . $apt->facilityId . ":" . $apt->name . "</b>";

			$pdfMenu .= $apt->PdfMenu();

			printf("</td>\r\n");

			printf("</tr>\r\n");
		}

		// ==================================================================================================
		// Close pdf docs
		// ==================================================================================================
		fwrite($fp, $pdfMenu, strlen($pdfMenu));

		fclose($fp);

		// ==================================================================================================
		// Check for any airports in the plan
		// ==================================================================================================
		foreach ($this->waypoint as $wayp)
		{
			if ($wayp->type == 'A')
			{
				$apt = $wayp->class->GetSingle(0);

				if (($apt->ICAO != $depart->ICAO) && ($apt->ICAO != $arrive->ICAO))
				{
					printf("<tr>\r\n");

					printf("<td class=\"plannerInfo\">Waypoint:%s<br/>\r\n", $apt->ICAO);

					printf("%s", $apt->tower->FormatPlanInfo($apt));

					printf("</td>\r\n");

					printf("<td class=\"plannerInfo\" colspan=\"4\">Waypoint:%s<br/>\r\n", $apt->ICAO);

					printf("%s", $apt->FormatRunwayInfo());

					printf("</td>\r\n");

					printf("<td class=\"plannerInfo\" colspan=\"4\">Waypoint:%s<br/>\r\n", $apt->ICAO);

					printf("%s", $apt->FormatPlanInfo());

					printf("</td>\r\n");

					printf("</tr>\r\n");
				}
			}
		}

		printf("</table>\r\n");

		// ==================================================================================================
		// Weather
		// ==================================================================================================
		if (count($this->station) > 0)
		{
			printf("<div class=\"pagebreak\"> </div>\r\n");

			printf("<table class=\"planner\">\r\n");

			for ($sc = 0;$sc < count($this->station);$sc++)
			{
				printf("<tr>\r\n");

				if ($this->station[$sc]->metar)
				{
					if ($mtr = $this->station[$sc]->GetSingle(0))
					{
						printf("%s", $mtr->FormatPlanInfo());
					}
				}

				if ($this->taf[$sc]->bulletin)
				{
					if ($taf = $this->taf[$sc]->GetSingle(0))
					{
						printf("%s", $taf->FormatPlanInfo());
					}
				}

				printf("</tr>\r\n");
			}

			printf("</table>\r\n");
		}
	}

	public function FormatFpl()
	{
		if (!$this->valid)
		{
			return;
		}

		printf("<flight-plan xmlns=\"http://www8.garmin.com/xmlschemas/FlightPlan/v1\">\r\n");

		printf("\t<created>%sT%sZ</created>\r\n", gmdate("Y-m-d", time()), gmdate("h:i:s", time()));

		printf("\t<waypoint-table>\r\n");

		foreach ($this->waypoint as $wayp)
		{
			printf("\t\t<waypoint>\r\n");

			switch($wayp->type)
			{
				case "A":
				{
					$apt = $wayp->class->GetSingle(0);

					printf("\t\t\t<identifier>%s</identifier>\r\n", $apt->ICAO);

					printf("\t\t\t<type>AIRPORT</type>\r\n");

					$p = new Parameter("region" . $apt->state);

					printf("\t\t\t<country-code>%s</country-code>\r\n", $p->value1);

					printf("\t\t\t<lat>%s</lat>\r\n", $apt->latLon->decimalLat);

					printf("\t\t\t<lon>%s</lon>\r\n", $apt->latLon->decimalLon);

					break;
				}

				case "F":
				{
					$fix = $wayp->class->GetSingle(0);

					printf("\t\t\t<identifier>%s</identifier>\r\n", $fix->fixId);

					printf("\t\t\t<type>INT</type>\r\n");

					$p = new Parameter("state" . $fix->state);

					$p2 = new Parameter("region" . $p->value1);

					printf("\t\t\t<country-code>%s</country-code>\r\n", $p2->value1);

					printf("\t\t\t<lat>%s</lat>\r\n", $fix->latLon->decimalLat);

					printf("\t\t\t<lon>%s</lon>\r\n", $fix->latLon->decimalLon);

					break;
				}

				case "G":
				{
					printf("\t\t\t<identifier>%s</identifier>\r\n", $wayp->desc);

					printf("\t\t\t<type>USER WAYPOINT</type>\r\n");

					$xml = sprintf("https://maps.googleapis.com/maps/api/geocode/xml?address=%s,%s&key=", $wayp->latLon->decimalLat, $wayp->latLon->decimalLon);

					$sr = new SimpleRequest($xml);

					foreach ($sr->xml->result->address_component as $address_component)
					{
						foreach ($address_component as $comp)
						{
							$p = new Parameter("region" . $comp);

							if ($p->value1)
							{
								printf("\t\t\t<country-code>%s</country-code>\r\n", $p->value1);
							}
						}
					}

					printf("\t\t\t<lat>%s</lat>\r\n", $wayp->latLon->decimalLat);

					printf("\t\t\t<lon>%s</lon>\r\n", $wayp->latLon->decimalLon);

					break;
				}

				case "N":
				{
					$nav = $wayp->class->GetSingle(0);

					printf("\t\t\t<identifier>%s</identifier>\r\n", $nav->facilityId);

					if ($nav->type != "NDB")
					{
						printf("\t\t\t<type>VOR</type>\r\n");
					}
					else
					{
						printf("\t\t\t<type>NDB</type>\r\n");
					}

					$p = new Parameter("region" . $nav->state);

					printf("\t\t\t<country-code>%s</country-code>\r\n", $p->value1);

					printf("\t\t\t<lat>%s</lat>\r\n", $nav->latLon->decimalLat);

					printf("\t\t\t<lon>%s</lon>\r\n", $nav->latLon->decimalLon);

					break;
				}

				default:
				{
					break;
				}
			}

			printf("\t\t\t<comment></comment>\r\n");

			printf("\t\t</waypoint>\r\n");
		}

		printf("\t</waypoint-table>\r\n");

		printf("\t<route>\r\n");

		$fapt = $this->waypoint[$this->DEPART]->class->GetSingle(0);
		$lapt = $this->waypoint[$this->ARRIVE]->class->GetSingle(0);

		printf("\t\t<route-name>%s to %s %s %sZ</route-name>\r\n", $fapt->ICAO, $lapt->ICAO, gmdate("Y/m/d", time()), gmdate("h:i", time()));

		printf("\t\t<flight-plan-index>1</flight-plan-index>\r\n");

		foreach ($this->waypoint as $wayp)
		{
			printf("\t\t<route-point>\r\n");

			switch($wayp->type)
			{
				case "A":
				{
					$apt = $wayp->class->GetSingle(0);

					printf("\t\t\t<waypoint-identifier>%s</waypoint-identifier>\r\n", $apt->ICAO);

					printf("\t\t\t<waypoint-type>AIRPORT</waypoint-type>\r\n");

					$p = new Parameter("region" . $apt->state);

					printf("\t\t\t<country-code>%s</country-code>\r\n", $p->value1);

					break;
				}

				case "F":
				{
					$fix = $wayp->class->GetSingle(0);

					printf("\t\t\t<waypoint-identifier>%s</waypoint-identifier>\r\n", $fix->fixId);

					printf("\t\t\t<waypoint-type>INT</waypoint-type>\r\n");

					$p = new Parameter("state" . $fix->state);

					$p2 = new Parameter("region" . $p->value1);

					printf("\t\t\t<country-code>%s</country-code>\r\n", $p2->value1);

					break;
				}

				case "G":
				{
					printf("\t\t\t<waypoint-identifier>%s</waypoint-identifier>\r\n", $wayp->desc);

					printf("\t\t\t<waypoint-type>USER WAYPOINT</waypoint-type>\r\n");

					$xml = sprintf("https://maps.googleapis.com/maps/api/geocode/xml?address=%s,%s&key=AIzaSyCnoazHa0WEibhtQZmBqlMtXcr9LOjN5Dw", $wayp->latLon->decimalLat, $wayp->latLon->decimalLon);

					$sr = new SimpleRequest($xml);

					foreach ($sr->xml->result->address_component as $address_component)
					{
						foreach ($address_component as $comp)
						{
							$p = new Parameter("region" . $comp);

							if ($p->value1)
							{
								printf("\t\t\t<country-code>%s</country-code>\r\n", $p->value1);
							}
						}
					}


					break;
				}

				case "N":
				{
					$nav = $wayp->class->GetSingle(0);

					printf("\t\t\t<waypoint-identifier>%s</waypoint-identifier>\r\n", $nav->facilityId);

					if ($nav->type != "NDB")
					{
						printf("\t\t\t<waypoint-type>VOR</waypoint-type>\r\n");
					}
					else
					{
						printf("\t\t\t<waypoint-type>NDB</waypoint-type>\r\n");
					}

					$p = new Parameter("region" . $nav->state);

					printf("\t\t\t<country-code>%s</country-code>\r\n", $p->value1);
				}
			}

			printf("\t\t</route-point>\r\n");
		}

		printf("\t</route>\r\n");

		printf("</flight-plan>\r\n");
	}

	public function FormatGpx()
	{
		if (!$this->valid)
		{
			return;
		}

		$minLat = 999.00;
		$minLon = 999.00;

		$maxLat = -999.00;
		$maxLon = -999.00;

		foreach ($this->waypoint as $wayp)
		{
			switch($wayp->type)
			{
				case "A":
				{
					$apt = $wayp->class->GetSingle(0);

					if ($apt->latLon->decimalLat < $minLat)
					{
						$minLat = $apt->latLon->decimalLat;
					}

					if ($apt->latLon->decimalLon < $minLon)
					{
						$minLon = $apt->latLon->decimalLon;
					}

					if ($apt->latLon->decimalLat > $maxLat)
					{
						$maxLat = $apt->latLon->decimalLat;
					}

					if ($apt->latLon->decimalLon > $maxLon)
					{
						$maxLon = $apt->latLon->decimalLon;
					}

					break;
				}

				case "F":
				{
					$fix = $wayp->class->GetSingle(0);

					if ($fix->latLon->decimalLat < $minLat)
					{
						$minLat = $fix->latLon->decimalLat;
					}

					if ($fix->latLon->decimalLon < $minLon)
					{
						$minLon = $fix->latLon->decimalLon;
					}

					if ($fix->latLon->decimalLat > $maxLat)
					{
						$maxLat = $fix->latLon->decimalLat;
					}

					if ($fix->latLon->decimalLon > $maxLon)
					{
						$maxLon = $fix->latLon->decimalLon;
					}

					break;
				}

				case "G":
				{
					if ($wayp->latLon->decimalLat < $minLat)
					{
						$minLat = $wayp->latLon->decimalLat;
					}

					if ($wayp->latLon->decimalLon < $minLon)
					{
						$minLon = $wayp->latLon->decimalLon;
					}

					if ($wayp->latLon->decimalLat > $maxLat)
					{
						$maxLat = $wayp->latLon->decimalLat;
					}

					if ($wayp->latLon->decimalLon > $maxLon)
					{
						$maxLon = $wayp->latLon->decimalLon;
					}

					break;
				}

				case "N":
				{
					$nav = $wayp->class->GetSingle(0);

					if ($nav->latLon->decimalLat < $minLat)
					{
						$minLat = $nav->latLon->decimalLat;
					}

					if ($nav->latLon->decimalLon < $minLon)
					{
						$minLon = $nav->latLon->decimalLon;
					}

					if ($nav->latLon->decimalLat > $maxLat)
					{
						$maxLat = $nav->latLon->decimalLat;
					}

					if ($nav->latLon->decimalLon > $maxLon)
					{
						$maxLon = $nav->latLon->decimalLon;
					}

					break;
				}

				default:
				{
					break;
				}
			}
		}

		printf("<?xml version=\"1.0\" encoding=\"utf-8\"?>\r\n");

		printf("<gpx");

		printf("\tversion=\"1.1\"");

		printf("\tcreator=\"MyFlightPlanner - http://www.myflightplanner.com\"");

		printf("\txmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\"");

		printf("\txmlns=\"http://www.topografix.com/GPX/1/1\"");

		printf("\txsi:schemaLocation=\"http://www.topografix.com/GPX/1/1 http://www.topografix.com/GPX/1/1/gpx.xsd\">\r\n");

		printf("\t<metadata>\r\n");

		printf("\t\t<time>%sT%sZ</time>\r\n", gmdate("Y-m-d", time()), gmdate("h:i:s", time()));

		printf("\t\t<bounds minlat=\"%s\" minlon=\"%s\" maxlat=\"%s\" maxlon=\"%s\" />\r\n", $minLat, $minLon, $maxLat, $maxLon);

		printf("\t</metadata>\r\n");

		foreach ($this->waypoint as $wayp)
		{
			switch($wayp->type)
			{
				case "A":
				{
					$apt = $wayp->class->airport[0];

					printf("\t<wpt lat=\"%s\" lon=\"%s\">\r\n", $apt->latLon->decimalLat, $apt->latLon->decimalLon);

					printf("\t\t<name>%s</name>\r\n", $apt->ICAO);

					printf("\t\t<type>AIRPORT</type>\r\n");

					printf("\t</wpt>\r\n");

					break;
				}

				case "F":
				{
					$fix = $wayp->class->GetSingle(0);

					printf("\t<wpt lat=\"%s\" lon=\"%s\">\r\n", $fix->latLon->decimalLat, $fix->latLon->decimalLon);

					printf("\t\t<name>%s</name>\r\n", $fix->fixId);

					printf("\t\t<type>INT</type>\r\n");

					printf("\t</wpt>\r\n");

					break;
				}

				case "G":
				{
					printf("\t<wpt lat=\"%s\" lon=\"%s\">\r\n", $wayp->latLon->decimalLat, $wayp->latLon->decimalLon);

					printf("\t\t<name>%s</name>\r\n", $wayp->desc);

					printf("\t\t<type>USER WAYPOINT</type>\r\n");

					printf("\t</wpt>\r\n");

					break;
				}

				case "N":
				{
					$nav = $wayp->class->GetSingle(0);

					printf("\t<wpt lat=\"%s\" lon=\"%s\">\r\n", $nav->latLon->decimalLat, $nav->latLon->decimalLon);

					printf("\t\t<name>%s</name>\r\n", $nav->facilityId);

					if ($nav->type != "NDB")
					{
						printf("\t\t<type>VOR</type>\r\n");
					}
					else
					{
						printf("\t\t<type>NDB</type>\r\n");
					}

					printf("\t</wpt>\r\n");

					break;
				}

				default:
				{
					break;
				}
			}
		}

		printf("\t<rte>\r\n");

		$fapt = $this->waypoint[$this->DEPART]->class->GetSingle(0);
		$lapt = $this->waypoint[$this->ARRIVE]->class->GetSingle(0);

		printf("\t\t<name>%s to %s %s %sZ</name>\r\n", $fapt->ICAO, $lapt->ICAO, gmdate("Y/m/d", time()), gmdate("h:i", time()));

		printf("\t\t<number>1</number>\r\n");

		foreach ($this->waypoint as $wayp)
		{
			switch($wayp->type)
			{
				case "A":
				{
					$apt = $wayp->class->GetSingle(0);

					printf("\t\t<rtept lat=\"%s\" lon=\"%s\">\r\n", $apt->latLon->decimalLat, $apt->latLon->decimalLon);

					printf("\t\t\t<name>%s</name>\r\n", $apt->ICAO);

					printf("\t\t\t<type>AIRPORT</type>\r\n");

					printf("\t\t\t<ele>%d</ele>\r\n", $apt->elevation);

					printf("\t\t</rtept>\r\n");

					break;
				}

				case "F":
				{
					$fix = $wayp->class->GetSingle(0);

					printf("\t\t<rtept lat=\"%s\" lon=\"%s\">\r\n", $fix->latLon->decimalLat, $fix->latLon->decimalLon);

					printf("\t\t\t<name>%s</name>\r\n", $fix->fixId);

					printf("\t\t\t<type>INT</type>\r\n");

					if ($this->sess->altitude != "0")
					{
						printf("\t\t\t<ele>%d</ele>\r\n", $this->sess->altitude);
					}
					else
					{
						printf("\t\t\t<ele>4500</ele>\r\n");
					}

					printf("\t\t</rtept>\r\n");
				}

				case "G":
				{
					printf("\t\t<rtept lat=\"%s\" lon=\"%s\">\r\n", $wayp->latLon->decimalLat, $wayp->latLon->decimalLon);

					printf("\t\t\t<name>%s</name>\r\n", $wayp->desc);

					printf("\t\t\t<type>USER WAYPOINT</type>\r\n");

					if ($this->sess->altitude != "0")
					{
						printf("\t\t\t<ele>%d</ele>\r\n", $this->sess->altitude);
					}
					else
					{
						printf("\t\t\t<ele>4500</ele>\r\n");
					}

					printf("\t\t</rtept>\r\n");

					break;
				}

				case "N":
				{
					$nav = $wayp->class->GetSingle(0);

					printf("\t\t<rtept lat=\"%s\" lon=\"%s\">\r\n", $nav->latLon->decimalLat, $nav->latLon->decimalLon);

					printf("\t\t\t<name>%s</name>\r\n", $nav->facilityId);

					if ($nav->type != "NDB")
					{
						printf("\t\t\t<type>VOR</type>\r\n");
					}
					else
					{
						printf("\t\t\t<type>NDB</type>\r\n");
					}

					if ($this->sess->altitude != "0")
					{
						printf("\t\t\t<ele>%d</ele>\r\n", $this->sess->altitude);
					}
					else
					{
						printf("\t\t\t<ele>4500</ele>\r\n");
					}

					printf("\t\t</rtept>\r\n");
				}

				default:
				{
					break;
				}
			}
		}

		printf("\t</rte>\r\n");

		printf("</gpx>\r\n");
	}

	public function FormatFsx()
	{
		if (!$this->valid)
		{
			return;
		}

		$altitude = $this->sess->altitude;

		if ($altitude <= 0)
		{
			$altitude = 4500;
		}

		$fapt = $this->waypoint[$this->DEPART]->class->GetSingle(0);
		$lapt = $this->waypoint[$this->ARRIVE]->class->GetSingle(0);

		$fsxfp  = sprintf("<?xml version=\"1.0\" encoding=\"UTF-8\"?>\r\n");

		$fsxfp .= sprintf("\r\n");

		$fsxfp .= sprintf("<SimBase.Document Type=\"AceXML\" version=\"1,0\">\r\n");

		$fsxfp .= sprintf("\t<Descr>AceXML Document</Descr>\r\n");

		$fsxfp .= sprintf("\t<FlightPlan.FlightPlan>\r\n");

		$fsxfp .= sprintf("\t\t<Title>%s to %s</Title>\r\n", $fapt->ICAO, $lapt->ICAO);

		$fsxfp .= sprintf("\t\t<FPType>VFR</FPType>\r\n");

		$fsxfp .= sprintf("\t\t<RouteType>VOR</RouteType>\r\n");

		$fsxfp .= sprintf("\t\t<CruisingAlt>%s</CruisingAlt>\r\n", $altitude);

		$fsxfp .= sprintf("\t\t<DepartureID>%s</DepartureID>\r\n", $fapt->ICAO);

		$fsxfp .= sprintf("\t\t<DepartureLLA>%s,%s,+%d</DepartureLLA>\r\n", $fapt->latLon->formattedLatFSX, $fapt->latLon->formattedLonFSX, $fapt->elevation);

		$fsxfp .= sprintf("\t\t<DestinationID>%s</DestinationID>\r\n", $lapt->ICAO);

		$fsxfp .= sprintf("\t\t<DestinationLLA>%s,%s,+%d</DestinationLLA>\r\n", $lapt->latLon->formattedLatFSX, $lapt->latLon->formattedLonFSX, $lapt->elevation);

		$fsxfp .= sprintf("\t\t<Descr>%s,%s</Descr>\r\n", $fapt->ICAO, $lapt->ICAO);

		$fsxfp .= sprintf("\t\t<DeparturePosition>PARKING 1</DeparturePosition>\r\n");

		$fsxfp .= sprintf("\t\t<DepartureName>%s</DepartureName>\r\n", $fapt->name);

		$fsxfp .= sprintf("\t\t<DestinationName>%s</DestinationName>\r\n", $lapt->name);

		$fsxfp .= sprintf("\t\t<AppVersion>\r\n");

		$fsxfp .= sprintf("\t\t\t<AppVersionMajor>10</AppVersionMajor>\r\n");

		$fsxfp .= sprintf("\t\t\t<AppVersionBuild>61472</AppVersionBuild>\r\n");

		$fsxfp .= sprintf("\t\t</AppVersion>\r\n");

		foreach ($this->waypoint as $wayp)
		{
			switch($wayp->type)
			{
				case "A":
				{
					$apt = $wayp->class->GetSingle(0);

					$fsxfp .= sprintf("\t\t<ATCWaypoint id=\"%s\">\r\n", $apt->ICAO);

					$fsxfp .= sprintf("\t\t\t<ATCWaypointType>Airport</ATCWaypointType>\r\n");

					$fsxfp .= sprintf("\t\t\t<WorldPosition>%s,%s,+%d</WorldPosition>\r\n", $apt->latLon->formattedLatFSX, $apt->latLon->formattedLonFSX, $apt->elevation);

					$fsxfp .= sprintf("\t\t\t<ICAO>\r\n");

					$fsxfp .= sprintf("\t\t\t\t<ICAOIdent>%s</ICAOIdent>\r\n", $apt->ICAO);

					$fsxfp .= sprintf("\t\t\t</ICAO>\r\n");

					$fsxfp .= sprintf("\t\t</ATCWaypoint>\r\n");

					break;
				}

				case "F":
				{
					$fix = $wayp->class->GetSingle(0);

					$fsxfp .= sprintf("\t\t<ATCWaypoint id=\"%s\">\r\n", $fix->fixId);

					$fsxfp .= sprintf("\t\t\t<ATCWaypointType>Intersection</ATCWaypointType>\r\n");

					$fsxfp .= sprintf("\t\t\t<WorldPosition>%s,%s,+%d</WorldPosition>\r\n", $fix->latLon->formattedLatFSX, $fix->latLon->formattedLonFSX, $altitude);

					$fsxfp .= sprintf("\t\t\t<ICAO>\r\n");

					$fsxfp .= sprintf("\t\t\t\t<ICAORegion>%s</ICAORegion>\r\n", $fix->region);

					$fsxfp .= sprintf("\t\t\t\t<ICAOIdent>%s</ICAOIdent>\r\n", $fix->fixId);

					$fsxfp .= sprintf("\t\t\t</ICAO>\r\n");

					$fsxfp .= sprintf("\t\t</ATCWaypoint>\r\n");

					break;
				}

				case "G":
				{
					$fsxfp .= sprintf("\t\t<ATCWaypoint id=\"%s\">\r\n", $wayp->desc);

					$fsxfp .= sprintf("\t\t\t<ATCWaypointType>Intersection</ATCWaypointType>\r\n");

					$fsxfp .= sprintf("\t\t\t<WorldPosition>%s,%s,+%d</WorldPosition>\r\n", $wayp->latLon->formattedLatFSX, $wayp->latLon->formattedLonFSX, $altitude);

					$fsxfp .= sprintf("\t\t\t<ICAO>\r\n");

					$fsxfp .= sprintf("\t\t\t\t<ICAORegion>%s</ICAORegion>\r\n", $wayp->latLon->GetLocation());

					$fsxfp .= sprintf("\t\t\t\t<ICAOIdent>%s</ICAOIdent>\r\n", $wayp->desc);

					$fsxfp .= sprintf("\t\t\t</ICAO>\r\n");

					$fsxfp .= sprintf("\t\t</ATCWaypoint>\r\n");

					break;
				}

				case "N":
				{
					$nav = $wayp->class->GetSingle(0);

					$fsxfp .= sprintf("\t\t<ATCWaypoint id=\"%s\">\r\n", $nav->facilityId);

					$fsxfp .= sprintf("\t\t\t<ATCWaypointType>%s</ATCWaypointType>\r\n", substr($nav->type, 0, 3));

					$fsxfp .= sprintf("\t\t\t<WorldPosition>%s,%s,+%d</WorldPosition>\r\n", $nav->latLon->formattedLatFSX, $nav->latLon->formattedLonFSX, $altitude);

					$fsxfp .= sprintf("\t\t\t<ICAO>\r\n");

					$p = new Parameter("region" . $nav->state);

					$pv = explode(",", $p->value1);

					$fsxfp .= sprintf("\t\t\t\t<ICAORegion>%s</ICAORegion>\r\n", $pv[0]);

					$fsxfp .= sprintf("\t\t\t\t<ICAOIdent>%s</ICAOIdent>\r\n", $nav->facilityId);

					$fsxfp .= sprintf("\t\t\t</ICAO>\r\n");

					$fsxfp .= sprintf("\t\t</ATCWaypoint>\r\n");
				}

				default:
				{
					break;
				}
			}
		}

		$fsxfp .= sprintf("\t</FlightPlan.FlightPlan>\r\n");

		$fsxfp .= sprintf("</SimBase.Document>\r\n");

		return $fsxfp;
	}

	public function FormatXML()
	{
		$str  = sprintf("<?xml version=\"1.0\"?>");

		$str .= sprintf("<result sessionId=\"%s\">", $this->sess->sessionId);

		foreach ($this->waypoint as $wayp)
		{
			$str .= sprintf("<waypoint>");

			switch ($wayp->type)
			{
				case "A":
				{
					$str .= $wayp->class->FormatXML();

					break;
				}

				case "F":
				{

					$str .= $wayp->class->FormatXML();


					break;
				}

				case "N":
				{
					$str .= $wayp->class->FormatXML(false);

					break;
				}

				case "G":
				{
					$gpswp = explode(";", $wayp->name);

					$latLon = new LatLon($gpswp[1], $gpswp[2]);

					$str .= sprintf("<gps>");

					$str .= sprintf("<type>G</type>");

					$na = explode("/", $gpswp[3]);

					if (count($na) == 1)
					{
						$str .= sprintf("<name>%s</name>", $gpswp[3]);
					}
					else
					{
						$str .= sprintf("<name>%s</name>", $na[0]);
						$str .= sprintf("<freq>%s</freq>", $na[1]);
					}

					$str .= sprintf("<icon>../images/gps.png</icon>");

					$str .= sprintf("<latitude>%s</latitude>", $latLon->decimalLat);

					$str .= sprintf("<longitude>%s</longitude>", $latLon->decimalLon);

					$str .= sprintf("</gps>");

					break;
				}

				default:
				{
					break;
				}
			}

			$str .= sprintf("</waypoint>");
		}

		$str .= sprintf("</result>");

		return $str;
	}

	function ListMarkersGoogle()
	{
		$str = "";

		foreach ($this->waypoint as $point)
		{
			switch ($point->type)
			{
				case "A":
				{
					$str .= $point->class->ListMarkersGoogle();

					break;
				}

				case "F":
				{

					$str .= $point->class->ListMarkersGoogle();


					break;
				}

				case "N":
				{
					$str .= $point->class->ListMarkersGoogle();

					break;
				}

				case "G":
				{
					$gpswp = explode(";", $point->name);

					$latLon = new LatLon($gpswp[1], $gpswp[2]);

					$str .= sprintf("<gps>");

					$str .= sprintf("<type>G</type>");

					$str .= sprintf("<name>%s</name>", $gpswp[3]);

					$str .= sprintf("<icon>../images/gps.png</icon>");

					$str .= sprintf("<latitude>%s</latitude>", $latLon->decimalLat);

					$str .= sprintf("<longitude>%s</longitude>", $latLon->decimalLon);

					$str .= sprintf("</gps>");

					break;
				}

				default:
				{
					break;
				}
			}
		}

		return $str;
	}
}
?>