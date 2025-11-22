<?php
class CodedInstrumentFlightProcedureData
{
	public $id;
	public $facilityId;
	public $subsectionCode;
	public $siapId;
	public $transition;
	public $sequence;
	public $point;
	public $region;
	public $turn;
	public $legType;
	public $navaid;
	public $theta;
	public $rho;
	public $magCourse;
	public $hold;
	public $altitude;
	public $pointId;
	public $pointMagVar;
	public $navaidId;
	public $navaidMagVar;

	public function FormatEntry()
	{
		$str  = sprintf("<td>%s</td>\r\n", $this->facilityId);

		$str .= sprintf("<td>%s</td>\r\n", $this->siapId);

		$str .= sprintf("<td>%s</td>\r\n", $this->transition);

		$str .= sprintf("<td>%s</td>\r\n", $this->sequence);

		$p = new Parameter("cifpLeg" . $this->legType);

		if ($this->turn != "")
		{
			$str .= sprintf("<td>%s:%s:%s</td>\r\n", $this->legType, $this->turn, $p->value1);
		}
		else
		{
			$str .= sprintf("<td>%s:%s</td>\r\n", $this->legType, $p->value1);
		}

		if (($this->point == "") && ($this->navaid == "") && ($this->legType != "CA") && ($this->legType != "VA") && ($this->legType != "VI") && ($this->legType != "VM") && ($this->legType != "CI"))
		{
			$str .= sprintf("<td class=\"error\">MISSING</td>\r\n", $this->point);

			$str .= sprintf("<td class=\"error\">%s</td>\r\n", $this->region);

			$str .= sprintf("<td class=\"error\">MISSING</td>\r\n", $this->navaid);
		}
		else if ((strlen($this->navaid) == 2) && ($this->point == ""))
		{
			$str .= sprintf("<td class=\"error\">MISSING</td>\r\n", $this->point);

			$str .= sprintf("<td class=\"error\">%s</td>\r\n", $this->region);

			$str .= sprintf("<td class=\"error\">%s</td>\r\n", $this->navaid);
		}
		else
		{
			$str .= sprintf("<td>%s</td>\r\n", $this->point);

			$str .= sprintf("<td>%s</td>\r\n", $this->region);

			$str .= sprintf("<td>%s</td>\r\n", $this->navaid);
		}

		$str .= sprintf("<td>%5.1f</td>\r\n", floatval($this->theta));

		$str .= sprintf("<td>%5.1f</td>\r\n", floatval($this->rho));

		$str .= sprintf("<td>%5.1f</td>\r\n", floatval($this->magCourse));

		if ($this->hold)
		{
			if ($this->hold[0] == 'T')
			{
				$str .= sprintf("<td>%s:", $this->hold[0]);

				$str .= sprintf("%s%s%s%s</td>\r\n", $this->hold[1], $this->hold[2], $this->hold[3], $this->hold[4]);
			}
			else
			{
				$str .= sprintf("<td>%5.1f</td>\r\n", floatval($this->hold));
			}
		}
		else
		{
			$str .= sprintf("<td>&nbsp;</td>\r\n");
		}

		$str .= sprintf("<td>%s</td>\r\n", $this->altitude);

		return $str;
	}
}

class CodedInstrumentFlightProcedure
{
	public $sess;
	public $procedure = array();


	// need to retain the previous points latLon and magVar
	public $name = null;
	public $point = null;

	public $saveLatLon = null;
	public $saveMagVar = null;


	public function __construct($sess, $sql)
	{
		$this->sess = $sess;

		$cifpDbase = new Database();

		$cifpDbase->ExecSql($sql);

		if ($cifpDbase->GetRowCount() > 0)
		{
			while($row = $cifpDbase->FetchRow())
			{
				$this->GetRow($row);
			}
		}
		else
		{
			$this->procedure = null;
		}

		$cifpDbase->Disconnect();
	}

	public function GetRow($row)
	{
		$codedInstrumentFlightProcedureData = new CodedInstrumentFlightProcedureData();

		$codedInstrumentFlightProcedureData->id = $row["id"];
		$codedInstrumentFlightProcedureData->facilityId = $row["facilityId"];
		$codedInstrumentFlightProcedureData->subsectionCode = $row["subsectionCode"];
		$codedInstrumentFlightProcedureData->siapId = $row["siapId"];
		$codedInstrumentFlightProcedureData->transition = $row["transition"];
		$codedInstrumentFlightProcedureData->sequence = $row["sequence"];
		$codedInstrumentFlightProcedureData->point = $row["point"];
		$codedInstrumentFlightProcedureData->region = $row["region"];
		$codedInstrumentFlightProcedureData->turn = $row["turn"];
		$codedInstrumentFlightProcedureData->legType = $row["legType"];
		$codedInstrumentFlightProcedureData->navaid = $row["navaid"];
		$codedInstrumentFlightProcedureData->theta = $row["theta"];
		$codedInstrumentFlightProcedureData->rho = $row["rho"];
		$codedInstrumentFlightProcedureData->magCourse = $row["magCourse"];
		$codedInstrumentFlightProcedureData->hold = $row["hold"];
		$codedInstrumentFlightProcedureData->altitude = $row["altitude"];
		$codedInstrumentFlightProcedureData->pointId = $row["pointId"];
		$codedInstrumentFlightProcedureData->pointMagVar = $row["pointMagVar"];
		$codedInstrumentFlightProcedureData->navaidId = $row["navaidId"];
		$codedInstrumentFlightProcedureData->navaidMagVar = $row["navaidMagVar"];

		array_push($this->procedure, $codedInstrumentFlightProcedureData);
	}

	public function GetLast()
	{
		if ($this->procedure == null)
		{
			return;
		}

		return $this->procedure[count($this->procedure) - 1];
	}

	public function GetSingle($i)
	{
		if ($this->procedure == null)
		{
			return;
		}

		return $this->procedure[$i];
	}

	public function ListEntries()
	{
		if ($this->procedure == null)
		{
			return;
		}

		$firstOne = true;

		$str  = sprintf("<table>\r\n");

		$str .= sprintf("<tr><th>Facility<br/>Id</th>\r\n");

		$str .= sprintf("<th>SIAP<br/>Id</th>\r\n");

		$str .= sprintf("<th><br/>Transition</th>\r\n");

		$str .= sprintf("<th><br/>Sequence</th>\r\n");

		$str .= sprintf("<th><br/>Leg Type</th>\r\n");

		$str .= sprintf("<th>Point<br/>Name</th>\r\n");

		$str .= sprintf("<th><br/>Region</th>\r\n");

		$str .= sprintf("<th><br/>Navaid</th>\r\n");

		$str .= sprintf("<th><br/>Theta</th>\r\n");

		$str .= sprintf("<th>Rho<br/>(nm)</th>\r\n");

		$str .= sprintf("<th>Magnetic<br/>Course</th>\r\n");

		$str .= sprintf("<th>Hold<br/>Distance/Time</th>\r\n");

		$str .= sprintf("<th>Altitude<br/>(msl)</th></tr>\r\n");

		$prevSiapId = null;

		$prevTransition = null;

		foreach ($this->procedure as $proc)
		{
			if ($firstOne)
			{
				$firstOne = false;

				$prevTransition = $proc->transition;

				$prevSiapId = $proc->siapId;
			}
			else if ($prevSiapId != $proc->siapId)
			{
				$prevTransition = $proc->transition;

				$prevSiapId = $proc->siapId;

				$str .= sprintf("<tr><td><br/></td></tr>\r\n");
			}
			else if ($prevTransition != $proc->transition)
			{
				$prevTransition = $proc->transition;

				$str .= sprintf("<tr><td><br/></td></tr>\r\n");
			}

			$str .= sprintf("<tr>\r\n");

			$str .= $proc->FormatEntry();

			$str .= sprintf("</tr>\r\n");
		}

		$str .= sprintf("</table>\r\n");

		return $str;
	}

	public function DepartureList($icao, $siapId, $trans)
	{
		$str = array();

		foreach ($this->procedure as $proc)
		{
			switch ($proc->legType)
			{
				case "CF":
				case "DF":
				case "IF":
				case "TF":
				{
					if (strlen($proc->point) == 3)
					{
						$sql = sprintf("SELECT * FROM navNavaid WHERE id='%s'", $proc->pointId);

						$nav = new Navaid($this->sess, $sql);

						array_push($str, " N;" . $proc->point . ";" . $proc->pointId);
					}

					if (strlen($proc->point) == 5)
					{
						$sql = sprintf("SELECT * FROM fixLocation WHERE id='%s'", $proc->pointId);

						$fix = new Fix($this->sess, $sql);

						array_push($str, " F;" . $proc->point . ";" . $proc->pointId);
					}

					break;
				}

				default:
				{
					//printf("Departure:%s %s %s %s %s %s<br/>", $icao, $siapId, $trans, $proc->legType, $proc->point, $proc->pointId);

					break;
				}
			}
		}

		if ($trans === null)
		{
			return $str;
		}

		$sql = sprintf("SELECT * FROM cifp WHERE facilityId='%s' AND siapId='%s' AND transition='%s'", $icao, $siapId, $trans);

		$cifp = new CodedInstrumentFlightProcedure($this->sess, $sql);

		foreach ($cifp->procedure as $proc)
		{
			switch ($proc->legType)
			{
				case "CF":
				case "DF":
				case "IF":
				case "TF":
				{
					if (strlen($proc->point) == 3)
					{
						$sql = sprintf("SELECT * FROM navNavaid WHERE id='%s'", $proc->pointId);

						$nav = new Navaid($this->sess, $sql);

						array_push($str, " N;" . $proc->point . ";" . $proc->pointId);
					}

					if (strlen($proc->point) == 5)
					{
						$sql = sprintf("SELECT * FROM fixLocation WHERE id='%s'", $proc->pointId);

						$fix = new Fix($this->sess, $sql);

						array_push($str, " F;" . $proc->point . ";" . $proc->pointId);
					}

					break;
				}

				default:
				{
					//printf("Departure:%s %s %s %s %s %s<br/>", $icao, $siapId, $trans, $proc->legType, $proc->point, $proc->pointId);

					break;
				}
			}
		}

		$ret = null;

		foreach($str as $s)
		{
			$ret .= $s;
		}

		return trim($ret);
	}

	public function ArrivalList($icao, $siapId, $trans)
	{
		$str = array();

		foreach ($this->procedure as $proc)
		{
			switch ($proc->legType)
			{
				case "CF":
				case "DF":
				case "IF":
				case "TF":
				{
					if (strlen($proc->point) == 3)
					{
						$sql = sprintf("SELECT * FROM navNavaid WHERE id='%s'", $proc->pointId);

						$nav = new Navaid($this->sess, $sql);

						array_push($str, " N;" . $proc->point . ";" . $proc->pointId);
					}

					if (strlen($proc->point) == 5)
					{
						$sql = sprintf("SELECT * FROM fixLocation WHERE id='%s'", $proc->pointId);

						$fix = new Fix($this->sess, $sql);

						array_push($str, " F;" . $proc->point . ";" . $proc->pointId);
					}

					break;
				}

				default:
				{
					//printf("Arrival:%s %s %s %s %s %s<br/>", $proc->facilityId, $proc->siapId, $proc->transition, $proc->legType, $proc->point, $proc->pointId);

					break;
				}
			}
		}

		if ($trans === null)
		{
			return $str;
		}

		$sql = sprintf("SELECT * FROM cifp WHERE facilityId='%s' AND siapId='%s' AND transition='%s'", $icao, $siapId, $trans);

		$cifp = new CodedInstrumentFlightProcedure($this->sess, $sql);

		if ($cifp->procedure != null)
		{
			foreach ($cifp->procedure as $proc)
			{
				switch ($proc->legType)
				{
					case "CF":
					case "DF":
					case "IF":
					case "TF":
					{
						if (strlen($proc->point) == 5)
						{
							$sql = sprintf("SELECT * FROM fixLocation WHERE id='%s'", $proc->pointId);

							$fix = new Fix($this->sess, $sql);

							array_push($str, " F;" . $proc->point . ";" . $proc->pointId);
						}

						break;
					}

					default:
					{
						//printf("Arrival:%s %s %s %s %s %s<br/>", $proc->facilityId, $proc->siapId, $proc->transition, $proc->legType, $proc->point, $proc->pointId);

						break;
					}
				}
			}
		}

		$ret = null;

		foreach($str as $s)
		{
			$ret .= $s;
		}

		return trim($ret);
	}

	public function ApproachList($trans)
	{
		// climb-to-altitude distance
		$caDist = 2.0;

		$start = 0;

		$str = array();

		$transArray = array();

		if ($trans)
		{
			// sql procedure second transition
			$sql = sprintf("SELECT * FROM cifp WHERE facilityId='%s' AND siapId='%s' AND transition='%s'", $this->procedure[0]->facilityId, $this->procedure[0]->siapId, $trans);

			$trans = new CodedInstrumentFlightProcedure($this->sess, $sql);

			$transArray = $trans->FormatWaypoints();
		}

		// if there was a transition find the starting point for final
		if ($trans)
		{
			foreach($this->procedure as $proc)
			{
				$subsectionCode = $proc->subsectionCode;

				// if we reach the runway then the name was not found
				// so we can start at the first waypoint
				if ((strpos($proc->point, "RW") > -1) && (strlen($proc->point) > 3))
				{
					break;
				}

				// the point name or navaid name was found
				if ((strcmp($proc->point, $this->point) == 0) || (strcmp($proc->point, $trans->name) == 0))
				{
					// add to start for next position and go from there
					$start++;

					break;
				}

				$start++;
			}
		}

		for ($i = $start;$i < count($this->procedure);$i++)
		{
			$proc = $this->procedure[$i];

			switch ($proc->legType)
			{
				case "IF":
				case "TF":
				case "CF":
				case "DF":
				{
					// this fix for the runway is the localizer so add as a GPS waypoint
					if ((strpos($proc->point, "RW") > -1) && (strlen($proc->point) > 3))
					{
						$ils = new IlsFrequency($proc->facilityId[1] . $proc->facilityId[2] . $proc->facilityId[3], str_replace("RW", "", $proc->point));

						if ($ils->GetSingle(0) != null)
						{
							$latLon = new LatLon($ils->GetSingle(0)->latitude, $ils->GetSingle(0)->longitude);

							if ($proc->navaid)
							{
								array_push($str, " G;" . $latLon->formattedLat . ";" . $latLon->formattedLon . ";" . $proc->navaid . "/" . $ils->GetSingle(0)->frequency . ";" . $proc->navaidMagVar);

								$this->saveMagVar = $proc->navaidMagVar;
							}
							else
							{
								array_push($str, " G;" . $latLon->formattedLat . ";" . $latLon->formattedLon . ";LOCALIZER;" . $this->saveMagVar);

								//$this->saveMagVar = $this->saveMagVar;
							}

							$this->saveLatLon = $latLon;
						}
						else
						{
							$tll = $this->saveLatLon->PointFromHeadingDistance($caDist, floatval($proc->magCourse) + floatval($this->saveMagVar));

							array_push($str, " G;" . $tll->formattedLat . ";" . $tll->formattedLon . ";CTA;" . $this->saveMagVar);

							$this->saveLatLon = $tll;
						}
					}
					else if (strlen($proc->point) == 5)
					{
						$sql = sprintf("SELECT * FROM fixLocation WHERE id='%s'", $proc->pointId);

						$fix = new Fix($this->sess, $sql);

						array_push($str, " F;" . $proc->point . ";" . $proc->pointId);

						$this->saveLatLon = $fix->GetSingle(0)->latLon;
						$this->saveMagVar = $proc->pointMagVar;
					}
					else if ((strlen($proc->point) == 2) || (strlen($proc->point) == 3))
					{
						$sql = sprintf("SELECT * FROM navNavaid WHERE id='%s'", $proc->pointId);

						$nav = new Navaid($this->sess, $sql);

						array_push($str, " N;" . $proc->point . ";" . $proc->pointId);

						$this->saveLatLon = $nav->GetSingle(0)->latLon;
						$this->saveMagVar = $proc->pointMagVar;
					}

					break;
				}

				case "CA":
				{
					$tll = $this->saveLatLon->PointFromHeadingDistance($caDist, floatval($proc->magCourse) + floatval($this->saveMagVar));

					array_push($str, " G;" . $tll->formattedLat . ";" . $tll->formattedLon . ";CTA;" . $this->saveMagVar);

					$this->saveLatLon = $tll;
					//$this->saveMagVar = $this->saveMagVar;

					break;
				}

				case "VA":
				{
					$tll = $this->saveLatLon->PointFromHeadingDistance($caDist, floatval($proc->magCourse) + floatval($this->saveMagVar));

					array_push($str, " G;" . $tll->formattedLat . ";" . $tll->formattedLon . ";VTA;" . $this->saveMagVar);

					$this->saveLatLon = $tll;
					//$this->saveMagVar = $this->saveMagVar;

					break;
				}

				default:
				{
					//printf("Approach:%s %s %s %s %s %s<br/>", $proc->facilityId, $proc->siapId, $proc->transition, $proc->legType, $proc->point, $proc->pointId);

					break;
				}
			}
		}

		$ret = null;

		foreach($transArray as $s)
		{
			$ret .= $s;
		}

		foreach($str as $s)
		{
			$ret .= $s;
		}

		return trim($ret);
	}

	public function FormatWaypoints()
	{
		$str = array();

		foreach($this->procedure as $proc)
		{
			switch ($proc->legType)
			{
				case "IF":
				case "TF":
				case "CF":
				case "DF":
				{
					if (strlen($proc->point) == 2)
					{
						array_push($str, " N;" . $proc->point . ";" . $proc->pointId);

						$sql = sprintf("SELECT * FROM navNavaid WHERE id='%s'", $proc->pointId);

						$nav = new Navaid($this->sess, $sql);

						$this->name = $nav->GetSingle(0)->name;
						$this->point = $proc->point;

						$this->saveLatLon = $nav->GetSingle(0)->latLon;
						$this->saveMagVar = $nav->GetSingle(0)->magVar;
					}

					if (strlen($proc->point) == 3)
					{
						array_push($str, " N;" . $proc->point . ";" . $proc->pointId);

						$sql = sprintf("SELECT * FROM navNavaid WHERE id='%s'", $proc->pointId);

						$nav = new Navaid($this->sess, $sql);

						$this->name = $nav->GetSingle(0)->name;
						$this->point = $proc->point;

						$this->saveLatLon = $nav->GetSingle(0)->latLon;
						$this->saveMagVar = $nav->GetSingle(0)->magVar;
					}

					if (strlen($proc->point) == 5)
					{
						$sql = sprintf("SELECT * FROM fixLocation WHERE id='%s'", $proc->pointId);

						$fix = new Fix($this->sess, $sql);

						array_push($str, " F;" . $proc->point . ";" . $proc->pointId);

						$this->name = $proc->point;
						$this->point = $proc->point;

						$this->saveLatLon = $fix->GetSingle(0)->latLon;
						$this->saveMagVar = $fix->GetSingle(0)->magVar;
					}

					break;
				}

				case "AF":
				{
					// number of arc points plus one
					// 2 points + 1
					$wpCount = 5;

					$pfll = $this->saveLatLon;

					$sql = sprintf("SELECT * FROM fixLocation WHERE id='%s'", $proc->pointId);

					$fix = new Fix($this->sess, $sql);

					$fll = $fix->GetSingle(0)->latLon;

					$sql = sprintf("SELECT * FROM navNavaid WHERE id='%s'", $proc->navaidId);

					$nav = new Navaid($this->sess, $sql);

					$nll = $nav->GetSingle(0)->latLon;

					$stc = $nll->TrueCourse($pfll);
					$etc = $nll->TrueCourse($fll);

					$dist = $proc->rho;

					if (strcmp($proc->turn, "L") == 0)
					{
						if ($etc < $stc)
						{
							$dtc = abs($stc - $etc) / $wpCount;
						}
						else
						{
							$dtc = abs($etc - ($stc + 360)) / $wpCount;
						}

						for ($ai = 1; $ai < $wpCount; $ai++)
						{
							$tc = $stc - ($dtc * $ai);

							if ($tc < 0)
							{
								$tc += 360;
							}

							$all = $nll->PointFromHeadingDistance($dist, $tc);

							array_push($str, " G;" . $all->formattedLat . ";" . $all->formattedLon . ";Arc-" . $ai . ";" . $this->saveMagVar);
						}
					}
					else
					{
						if ($etc < $stc)
						{
							$dtc = abs($stc - ($etc + 360)) / $wpCount;
						}
						else
						{
							$dtc = abs($stc - $etc) / $wpCount;
						}

						for ($ai = 1; $ai < $wpCount; $ai++)
						{
							$tc = $stc + ($dtc * $ai);

							if ($tc > 360)
							{
								$tc -= 360;
							}

							$all = $nll->PointFromHeadingDistance($dist, $tc);

							array_push($str, " G;" . $all->formattedLat . ";" . $all->formattedLon . ";Arc-" . $ai . ";" . $this->saveMagVar);
						}
					}

					array_push($str, " F;" . $proc->point . ";" . $proc->pointId);

					$this->name = $proc->point;
					$this->point = $proc->point;

					$this->saveLatLon = $fix->GetSingle(0)->latLon;
					$this->saveMagVar = $fix->GetSingle(0)->magVar;

					break;
				}

				default:
				{
					//printf("Approach:%s %s %s %s %s %s<br/>", $proc->facilityId, $proc->siapId, $proc->transition, $proc->legType, $proc->point, $proc->pointId);

					break;
				}
			}
		}

		return $str;
	}
}