<?php
class LogbookData
{
	public $id;
	public $pilotId;
	public $flightDateTime;
	public $departArrive;
	public $planeType;
	public $registration;
	public $vfrTime;
	public $ifrTime;
	public $lessonTime;
	public $simLocation;
	public $safetyPilot;
	public $experienceType;
	public $conditionsType;
	public $landings;
	public $simulationType;
	public $simulatorType;
	public $goggleTime;
	public $gogglesType;
	public $remarks;

	public $sess;

	public function __construct($sess)
	{
		$this->sess = $sess;
	}

	public function FormatEntry()
	{
		$str = sprintf("Date Time: <a href=\"index.php?id=%s&fdt=%s\">%s</a>&nbsp;&nbsp;&nbsp;", $this->sess->sessionId, $this->flightDateTime, $this->flightDateTime);

		if ($this->departArrive > " ")
		{
			$str .= sprintf("Depart Arrive: %s&nbsp;&nbsp;&nbsp;", $this->departArrive);
		}

		$str .= sprintf("Plane Type: %s&nbsp;&nbsp;&nbsp;", $this->planeType);

		if ($this->registration > " ")
		{
			$str .= sprintf("Registration: %s&nbsp;&nbsp;&nbsp;", $this->registration);
		}

		if ($this->vfrTime > 0)
		{
			$str .= sprintf("VFR Time: %s&nbsp;&nbsp;&nbsp;", $this->vfrTime);
		}

		if ($this->ifrTime > 0)
		{
			$str .= sprintf("IFR Time: %s&nbsp;&nbsp;&nbsp;", $this->ifrTime);
		}

		if ($this->landings > 0)
		{
			$str .= sprintf("Landings: %s&nbsp;&nbsp;&nbsp;", $this->landings);
		}

		switch($this->conditionsType)
		{
			case 0:
			{
				$str .= sprintf("&nbsp;&nbsp;&nbsp;Conditions: Day");

				break;
			}

			case 1:
			{
				$str .= sprintf("&nbsp;&nbsp;&nbsp;Conditions: Night");

				break;
			}

			default:
			{
				$str .= sprintf("&nbsp;&nbsp;&nbsp;Conditions: Error");

				break;
			}
		}

		switch($this->experienceType)
		{
			case 0:
			{
				$str .= sprintf("\r\n<br/>Experience: Solo");

				break;
			}

			case 1:
			{
				$str .= sprintf("\r\n<br/>Experience: Pilot In Command");

				break;
			}

			case 2:
			{
				$str .= sprintf("\r\n<br/>Experience: Second In Command");

				break;
			}

			case 3:
			{
				$str .= sprintf("\r\n<br/>Experience: Flight And Ground Training");

				break;
			}

			case 4:
			{
				$str .= sprintf("\r\n<br/>Experience: Flight Simulator");

				break;
			}

			case 5:
			{
				$str .= sprintf("\r\n<br/>Experience: Flight Training Device");

				break;
			}

			case 6:
			{
				$str .= sprintf("\r\n<br/>Experience: Aviation Training Device");

				break;
			}

			default:
			{
				$str .= sprintf("\r\n<br/>Experience: Error");

				break;
			}
		}

		if ($this->lessonTime > 0)
		{
			$str .= sprintf("\r\n<br/>Lesson Time: %s&nbsp;&nbsp;&nbsp;", $this->lessonTime);

			if ($this->simLocation > " ")
			{
				$str .= sprintf("Simulator Local: %s&nbsp;&nbsp;&nbsp;", $this->simLocation);
			}

			if ($this->safetyPilot > " ")
			{
				$str .= sprintf("Safety Pilot: %s&nbsp;&nbsp;&nbsp;", $this->safetyPilot);
			}

			switch($this->simulationType)
			{
				case 0:
				{
					break;
				}

				case 1:
				{
					$str .= sprintf("Simulation Type: Simulated Instrument Flight&nbsp;&nbsp;&nbsp;");

					break;
				}

				case 2:
				{
					$str .= sprintf("Simulation Type: Flight Simulator&nbsp;&nbsp;&nbsp;");

					break;
				}

				case 3:
				{
					$str .= sprintf("Simulation Type: Flight Training Device&nbsp;&nbsp;&nbsp;");

					break;
				}

				case 4:
				{
					$str .= sprintf("Simulation Type: Aviation Training Device&nbsp;&nbsp;&nbsp;");

					break;
				}

				default:
				{
					$str .= sprintf("Error&nbsp;&nbsp;&nbsp;");

					break;
				}

			}

			if ($this->simulatorType > " ")
			{
				$str .= sprintf("Simulator: %s", $this->simulatorType);
			}

			switch($this->gogglesType)
			{
				case 0:
				{
					break;
				}

				case 1:
				{
					$str .= sprintf("\r\n<br/>Goggles: Aircraft In Flight %d", intval($this->goggleTime));

					break;
				}

				case 2:
				{
					$str .= sprintf("\r\n<br/>Goggles: Flight Simulator %d", intval($this->goggleTime));

					break;
				}

				case 3:
				{
					$str .= sprintf("\r\n<br/>Goggles: Flight Training Device %d", intval($this->goggleTime));

					break;
				}

				default:
				{
					$str .= sprintf("\r\n<br/>Goggles: Error %d", intval($this->goggleTime));

					break;
				}
			}
		}

		if ($this->remarks > " ")
		{
			$str .= sprintf("\r\n<br/>Remarks:<br/>%s", str_replace("\r\n", "<br/>", $this->remarks));
		}

		return $str;
	}
}

class Logbook
{
	public $sess;
	public $logbook = array();

	public $totalVfr = 0;
	public $totalIfr = 0;
	public $totalLesson = 0;
	public $totalSim = 0;
	public $totalDay = 0;
	public $totalNight = 0;
	public $totalGoggles = 0;
	public $totalLandings = 0;

	public function __construct($sess, $fdt)
	{
		$this->sess = $sess;

		$sql = sprintf("SELECT * FROM logbook where pilotId='%s'", $this->sess->pilotId);

		if ($fdt)
		{
			$sql .= sprintf(" AND flightDateTime='%s'", $fdt);
		}

		$sql .= sprintf(" ORDER BY flightDateTime ASC");

		$logbookDbase = new Database();

		$logbookDbase->ExecSql($sql);

		if ($logbookDbase->GetRowCount() > 0)
		{
			while($row = $logbookDbase->FetchRow())
			{
				$this->GetRow($row);
			}
		}
		else
		{
			$this->logbook = null;
		}

		$logbookDbase->Disconnect();
	}

	public function GetRow($row)
	{
		$logbookData = new LogbookData($this->sess);

		$logbookData->id = $row["id"];
		$logbookData->pilotId = $row["pilotId"];
		$logbookData->flightDateTime = $row["flightDateTime"];
		$logbookData->departArrive = $row["departArrive"];
		$logbookData->planeType = $row["planeType"];
		$logbookData->registration = $row["registration"];
		$logbookData->vfrTime = $row["vfrTime"];
		$logbookData->ifrTime = $row["ifrTime"];
		$logbookData->lessonTime = $row["lessonTime"];
		$logbookData->simLocation = $row["simLocation"];
		$logbookData->safetyPilot = $row["safetyPilot"];
		$logbookData->experienceType = $row["experienceType"];
		$logbookData->conditionsType = $row["conditionsType"];
		$logbookData->landings = $row["landings"];
		$logbookData->simulationType = $row["simulationType"];
		$logbookData->simulatorType = $row["simulatorType"];
		$logbookData->goggleTime = $row["goggleTime"];
		$logbookData->gogglesType = $row["gogglesType"];
		$logbookData->remarks = $row["remarks"];

		array_push($this->logbook, $logbookData);

		if ($row["vfrTime"] > 0)
		{
			$this->totalVfr += intval($row["vfrTime"]);
		}

		if ($row["ifrTime"] > 0)
		{
			$this->totalIfr += intval($row["ifrTime"]);
		}

		if ($row["landings"] > 0)
		{
			$this->totalLandings += intval($row["landings"]);
		}

		switch($row["conditionsType"])
		{
			case 0:
			{
				$this->totalDay += intval($row["vfrTime"]);

				$this->totalDay += intval($row["ifrTime"]);

				$this->totalDay += intval($row["lessonTime"]);

				$this->totalDay += intval($row["goggleTime"]);

				break;
			}

			case 1:
			{
				$this->totalNight += intval($row["vfrTime"]);

				$this->totalNight += intval($row["ifrTime"]);

				$this->totalNight += intval($row["lessonTime"]);

				$this->totalNight += intval($row["goggleTime"]);

				break;
			}

			default:
			{
				break;
			}
		}

		if ($row["lessonTime"] > 0)
		{
			$this->totalLesson += intval($row["lessonTime"]);
		}

		// "Flight Simulator"
		if ($row["simulationType"] == 2)
		{
			$this->totalSim += intval($row["lessonTime"]);
		}

		switch($row["gogglesType"])
		{
			case 0:
			{
				break;
			}

			case 1:
			case 2:
			case 3:
			{
				$this->totalGoggles += intval($row["goggleTime"]);

				break;
			}

			default:
			{
				break;
			}
		}

	}

	public function AddLogEntry($pilotId, $flightDateTime, $departArrive, $planeType, $registration, $vfrTime, $ifrTime, $lessonTime, $simLocation, $safetyPilot, $experienceType, $conditionsType, $landings, $simulationType, $simulatorType, $goggleTime, $gogglesType, $remarks)
	{
		$sql = sprintf("INSERT INTO logbook (pilotId,flightDateTime,departArrive,planeType,registration,vfrTime,ifrTime,lessonTime,simLocation,safetyPilot,experienceType,conditionsType,landings,simulationType,simulatorType,goggleTime,gogglesType,remarks)
						VALUES ('%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s')",
						$pilotId, $flightDateTime, $departArrive, $planeType, $registration, $vfrTime, $ifrTime, $lessonTime, $simLocation, $safetyPilot, $experienceType, $conditionsType, $landings, $simulationType, $simulatorType, $goggleTime, $gogglesType, $remarks);

		$logbookDbase = new Database();

		$logbookDbase->ExecSql($sql);

		$logbookDbase->Disconnect();
	}

	public function DeleteLogEntry($pilotId, $flightDateTime)
	{
		$sql = sprintf("DELETE FROM logbook WHERE pilotId='%s' AND flightDateTime='%s'", $pilotId, $flightDateTime);

		$logbookDbase = new Database();

		$logbookDbase->ExecSql($sql);

		$logbookDbase->Disconnect();
	}

	public function UpdateLogEntry($pilotId, $flightDateTime, $departArrive, $planeType, $registration, $vfrTime, $ifrTime, $lessonTime, $simLocation, $safetyPilot, $experienceType, $conditionsType, $landings, $simulationType, $simulatorType, $goggleTime, $gogglesType, $remarks)
	{
		$sql = sprintf("UPDATE logbook SET departArrive='%s', planeType='%s', registration='%s', vfrTime='%s', ifrTime='%s', lessonTime='%s', simLocation='%s', safetyPilot='%s', experienceType='%s', conditionsType='%s', landings='%s', simulationType='%s', simulatorType='%s', goggleTime='%s', gogglesType='%s', remarks='%s'
						WHERE pilotId='%s' AND flightDateTime='%s'",
						$departArrive, $planeType, $registration, $vfrTime, $ifrTime, $lessonTime, $simLocation, $safetyPilot, $experienceType, $conditionsType, $landings, $simulationType, $simulatorType, $goggleTime, $gogglesType, $remarks, $pilotId, $flightDateTime);

		$logbookDbase = new Database();

		$logbookDbase->ExecSql($sql);

		$logbookDbase->Disconnect();
	}

	public function GetSingle($i)
	{
		if ($this->logbook == null)
		{
			return;
		}

		return $this->logbook[$i];
	}

	public function ListEntries()
	{
		if ($this->logbook == null)
		{
			return;
		}

		$str = "<br/>";

		foreach ($this->logbook as $lbk)
		{
			$str .= $lbk->FormatEntry();

			$str .= sprintf("<hr>\r\n");
		}

		$str .= sprintf("<div class=\"pagebreak\"> </div>\r\n");

		$str .= sprintf("<table>\r\n");

		$str .= sprintf("<tr><th>&nbsp;</th><th>Minutes</th><th>Hours</th></tr>\r\n");

		$str .= sprintf("<tr><td class=\"logbookTot\">Total VFR:</td><td class=\"logbookTot\">%d</td><td class=\"logbookTot\">%0.2f</td></tr>\r\n", $this->totalVfr, floatval($this->totalVfr/60));

		$str .= sprintf("<tr><td class=\"logbookTot\">Total IFR:</td><td class=\"logbookTot\">%d</td><td class=\"logbookTot\">%0.2f</td></tr>\r\n", $this->totalIfr, floatval($this->totalIfr/60));

		$str .= sprintf("<tr><td class=\"logbookTot\">Total Lesson:</td><td class=\"logbookTot\">%d</td><td class=\"logbookTot\">%0.2f</td></tr>\r\n", $this->totalLesson, floatval($this->totalLesson/60));

		if ($this->totalGoggles > 0)
		{
			$str .= sprintf("<tr><td class=\"logbookTot\">Total Goggles:</td><td class=\"logbookTot\">%d</td><td class=\"logbookTot\">%0.2f</td></tr>\r\n", intval($this->totalGoggles), floatval($this->totalGoggles/60));
		}

		$str .= sprintf("<tr><td class=\"logbookTot\">Total All:</td><td class=\"logbookTot\">%d</td><td class=\"logbookTot\">%0.2f</td></tr>\r\n", intval($this->totalDay + $this->totalNight), floatval(floatval($this->totalDay/60) + floatval($this->totalNight/60)));

		$str .= sprintf("<tr><td class=\"logbookTot\">&nbsp;</td><td class=\"logbookTot\">&nbsp;</td><td class=\"logbookTot\">&nbsp;</td></tr>\r\n");

		$str .= sprintf("<tr><td class=\"logbookTot\">Total Simulator:</td><td class=\"logbookTot\">%d</td><td class=\"logbookTot\">%0.2f</td></tr>\r\n", $this->totalSim, floatval($this->totalSim/60));

		$str .= sprintf("<tr><td class=\"logbookTot\">Total Day:</td><td class=\"logbookTot\">%d</td><td class=\"logbookTot\">%0.2f</td></tr>\r\n", $this->totalDay, floatval($this->totalDay/60));

		$str .= sprintf("<tr><td class=\"logbookTot\">Total Night:</td><td class=\"logbookTot\">%d</td><td class=\"logbookTot\">%0.2f</td></tr>\r\n", $this->totalNight, floatval($this->totalNight/60));

		$str .= sprintf("<tr><td class=\"logbookTot\">Total All:</td><td class=\"logbookTot\">%d</td><td class=\"logbookTot\">%0.2f</td></tr>\r\n", intval($this->totalSim + $this->totalDay + $this->totalNight), floatval(floatval($this->totalSim/60) + floatval($this->totalDay/60) + floatval($this->totalNight/60)));

		$str .= sprintf("<tr><td class=\"logbookTot\">&nbsp;</td><td class=\"logbookTot\">&nbsp;</td><td class=\"logbookTot\">&nbsp;</td></tr>\r\n");

		$str .= sprintf("<tr><td class=\"logbookTot\">Total Landings:</td><td class=\"logbookTot\">%d</td><td class=\"logbookTot\">&nbsp;</tr>\r\n", $this->totalLandings);

		$str .= sprintf("</table>\r\n");

		return $str;
	}
}
?>