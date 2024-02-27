<?php
class FlightPlanData
{
	public $id;
	public $pilotId;
	public $departure;
	public $arrival;
	public $waypoints;
	public $planType;
	public $alternate1;
	public $alternate2;
	public $alternate3;
}

class FlightPlan
{
	public $plan = array();

	public function __construct($pi)
	{
		$sql = sprintf("SELECT * FROM flightPlan WHERE pilotId='%s'", $pi);

		$flightPlanDbase = new Database();
		
		$flightPlanDbase->ExecSql($sql);

		if ($flightPlanDbase->GetRowCount() > 0)
		{
			while($row = $flightPlanDbase->FetchRow())
			{
				$this->GetRow($row);
			}
		}
		else
		{
			$this->plan = null;
		}

		$flightPlanDbase->Disconnect();
	}

	public function GetRow($row)
	{
		$flightPlanData = new FlightPlanData();

		$flightPlanData->id = $row["id"];
		$flightPlanData->pilotId = $row["pilotId"];
		$flightPlanData->departure = $row["departure"];
		$flightPlanData->arrival = $row["arrival"];
		$flightPlanData->waypoints = $row["waypoints"];
		$flightPlanData->planType = $row["planType"];
		$flightPlanData->alternate1 = $row["alternate1"];
		$flightPlanData->alternate2 = $row["alternate2"];
		$flightPlanData->alternate3 = $row["alternate3"];

		array_push($this->plan, $flightPlanData);
	}

	public function UpdateFlightPlan($pi, $r, $t, $a1, $a2, $a3)
	{
		if ($t == null)
		{
			return;
		}

		$waypoint = explode(" ", $r);
		
		$waypointCount = count($waypoint);

		$sql = sprintf("SELECT * FROM flightPlan WHERE pilotId='%s' AND departure='%s' AND arrival='%s' AND planType='%s'", $pi, $waypoint[0], $waypoint[$waypointCount-1], $t);

		$flightPlanDbase = new Database();
		
		$flightPlanDbase->ExecSql($sql);

		if ($flightPlanDbase->GetRowCount() > 0)
		{
			$sql = sprintf("UPDATE flightPlan SET waypoints='%s', alternate1='%s', alternate2='%s', alternate3='%s' WHERE pilotId='%s' AND departure='%s' AND arrival='%s' AND planType='%s'", $r, $a1, $a2, $a3, $pi, $waypoint[0], $waypoint[$waypointCount-1], $t);
			
			$flightPlanDbase->ExecSql($sql);
		}
		else
		{
			$sql = sprintf("INSERT INTO flightPlan (pilotId,departure,arrival,waypoints,planType,alternate1,alternate2,alternate3) VALUES ('%s','%s','%s','%s','%s','%s','%s','%s')", $pi, $waypoint[0], $waypoint[$waypointCount-1], $r, $t, $a1, $a2, $a3);
			
			$flightPlanDbase->ExecSql($sql);
		}

		$flightPlanDbase->Disconnect();
	}

	public function DeleteFlightPlan($pi, $r, $t)
	{
		$waypoint = explode(" ", $r);
		
		$waypointCount = count($waypoint);

		$sql = sprintf("DELETE FROM flightPlan WHERE pilotId='%s' AND departure='%s' AND arrival='%s' AND planType='%s'", $pi, $waypoint[0], $waypoint[$waypointCount-1], $t);

		$flightPlanDbase = new Database();
		
		$flightPlanDbase->ExecSql($sql);
		
		$flightPlanDbase->Disconnect();
	}

	public function GetFlightPlan($pi, $r)
	{
		$wp = null;

		$waypoint = explode(" ", $r);

		$sql = sprintf("SELECT * FROM flightPlan WHERE pilotId='%s' AND departure='%s' AND arrival='%s' AND planType='%s'", $pi, $waypoint[0], $waypoint[1], $waypoint[2]);

		$flightPlanDbase = new Database();
		
		$flightPlanDbase->ExecSql($sql);

		if ($flightPlanDbase->GetRowCount() > 0)
		{
			$this->plan = array();

			$this->GetRow($row = $flightPlanDbase->FetchRow());

			$wp = $row["waypoints"];
		}

		$flightPlanDbase->Disconnect();

		return $wp;
	}

	public function MakeDropdown($pilotId, $route, $planType)
	{
		if ($route)
		{
			$waypoint = explode(" ", $route);
			
			$waypointCount = count($waypoint);
		}

		$sql = sprintf("SELECT * FROM flightPlan WHERE pilotId='%s' AND waypoints='%s' AND planType='%s'", $pilotId, $route, $planType);

		$flightPlanDbase = new Database();
		
		$flightPlanDbase->ExecSql($sql);

		$found = false;

		if ($flightPlanDbase->GetRowCount() > 0)
		{
			$found = true;
		}

		$flightPlanDbase->Disconnect();

		$sql = sprintf("SELECT * FROM flightPlan WHERE pilotId='%s' ORDER BY departure,arrival ASC", $pilotId);

		$flightPlanDbase = new Database();
		
		$flightPlanDbase->ExecSql($sql);

		$str = sprintf("<select name=\"flightPlanSelect\">\r\n");

		if ($flightPlanDbase->GetRowCount() > 0)
		{
			if ($found)
			{
				$str .= sprintf("<option value=\"\">New Plan</option>\r\n");
			}
			else
			{
				$str .= sprintf("<option selected value=\"\">New Plan</option>\r\n");
			}

			while($row = $flightPlanDbase->FetchRow())
			{
				$dep = $row["departure"] . "&nbsp;";
				
				if (strlen($dep) == 9)
				{
					$dep .= "&nbsp;";
				}
				
				$arv = $row["arrival"] . "&nbsp;";
				
				if (strlen($arv) == 9)
				{
					$arv .= "&nbsp;";
				}
				
				$text = $dep . $arv . $row["planType"];

				if ((strcmp($route, $row["waypoints"]) == 0) && (strcmp($planType, $row["planType"]) == 0))
				{
					$str .= sprintf("<option selected value=\"%s %s %s\">%s</option>\r\n", $row["departure"], $row["arrival"], $row["planType"], $text);
				}
				else
				{
					$str .= sprintf("<option value=\"%s %s %s\">%s</option>\r\n", $row["departure"], $row["arrival"], $row["planType"], $text);
				}
			}
		}
		else
		{
			$str .= sprintf("<option selected value=\"\">New Plan</option>\r\n");
		}

		$str .= sprintf("</select>\r\n");

		$flightPlanDbase->Disconnect();

		return $str;
	}
}
?>