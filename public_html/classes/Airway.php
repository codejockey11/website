<?php
class AirwayData
{
	public $id;
	public $airway;
	public $type;
	public $pointNbr;
	public $pointName;
	public $pointType;
	public $pointId;
	public $magCourse;
	public $magCourseOpposite;
	public $MEA;
	public $MAX;
	public $MOCA;
	public $latLon;

	public $sess;

	public function __construct($sess)
	{
		$this->sess = $sess;
	}

	public function FormatPlanInfo($latLon)
	{
		$str  = sprintf("\r\n<br/>%s", $this->airway);

		$str .= sprintf(" %s ", $this->pointName);

		if ($this->MEA)
		{
			if ($this->sess->altitude < $this->MEA)
			{
				$str .= sprintf("<b class=\"plannerError\">\r\n");

				$str .= sprintf(" MEA(%d)</b>\r\n", $this->MEA);
			}
			else
			{
				$str .= sprintf(" MEA(%d)", $this->MEA);
			}
		}

		if ($this->MAX)
		{
			$str .= sprintf(" MAX(%d)", $this->MAX);
		}

		if ($this->MOCA)
		{
			if ($this->sess->altitude < $this->MOCA)
			{
				$str .= sprintf("<b class=\"plannerError\">\r\n");

				$str .= sprintf(" MOCA(%d)</b>\r\n", $this->MOCA);
			}
			else
			{
				$str .= sprintf(" MOCA(%d)", $this->MOCA);
			}
		}

		if ($latLon)
		{
			$str .= sprintf(" (%s)", sprintf("%d", round($this->latLon->DistanceInMiles($latLon))));
		}

		return $str;
	}
}

class Airway
{
	public $sess;
	public $airway = array();

	public function __construct($sess, $from, $to, $type, $name)
	{
		$this->sess = $sess;

		// airway based on airway name and from-to points
		if ($name)
		{
			$sql = sprintf("SELECT * FROM airway WHERE (pointName='%s' OR pointName='%s') AND airway='%s' ORDER BY pointNbr ASC", $from, $to, $name);

			$awyDbase = new Database();

			$awyDbase->ExecSql($sql);

			if ($awyDbase->GetRowCount() > 1)
			{
				$row = $awyDbase->FetchRow();

				if (strcmp($row["pointName"], $from) == 0)
				{
					$fn = $row["pointNbr"];

					$row = $awyDbase->FetchRow();

					$tn = $row["pointNbr"];

					$sql = sprintf("SELECT * FROM airway WHERE (pointNbr>='%s' AND pointNbr<='%s') AND airway='%s' ORDER BY pointNbr ASC", $fn, $tn, $name);
				}
				else
				{
					$fn = $row["pointNbr"];

					$row = $awyDbase->FetchRow();

					$tn = $row["pointNbr"];

					$sql = sprintf("SELECT * FROM airway WHERE (pointNbr>='%s' AND pointNbr<='%s') AND airway='%s' ORDER BY pointNbr DESC", $fn, $tn, $name);
				}

				$awyDbase->ExecSql($sql);

				$this->airway = array();

				while($row = $awyDbase->FetchRow())
				{
					$this->GetRow($row);
				}
			}

			$awyDbase->Disconnect();

			return;
		}

		// airway based on airway type and from-to points
		$sql = sprintf("SELECT * FROM airway WHERE (pointName='%s' OR pointName='%s') AND type='%s' ORDER BY airway, pointName ASC", $from, $to, $type);

		$awyDbase = new Database();

		$awyDbase->ExecSql($sql);

		if ($awyDbase->GetRowCount() == 0)
		{
			$this->airway = null;

			return;
		}

		while($row = $awyDbase->FetchRow())
		{
			$this->GetRow($row);
		}

		$airway = array();

		$prev = null;

		foreach ($this->airway as $awy)
		{
			if (strcmp($prev, $awy->airway) == 0)
			{
				array_push($airway, $awy->airway);
			}
			else
			{
				$prev = $awy->airway;
			}
		}

		if (count($airway) == 0)
		{
			$this->airway = null;

			return;
		}

		$this->airway = array();

		foreach ($airway as $awy)
		{
			$sql = sprintf("SELECT * FROM airway WHERE (pointName='%s' OR pointName='%s') AND airway='%s' ORDER BY pointNbr ASC", $from, $to, $awy);

			$awyDbase->ExecSql($sql);

			if ($awyDbase->GetRowCount() > 0)
			{
				$row = $awyDbase->FetchRow();

				if (strcmp($row["pointName"], $from) == 0)
				{
					$fn = $row["pointNbr"];

					$row = $awyDbase->FetchRow();

					$tn = $row["pointNbr"];

					$sql = sprintf("SELECT * FROM airway WHERE (pointNbr>'%s' AND pointNbr<='%s') AND airway='%s' ORDER BY pointNbr ASC", $fn, $tn, $awy);
				}
				else
				{
					$fn = $row["pointNbr"];

					$row = $awyDbase->FetchRow();

					$tn = $row["pointNbr"];

					$sql = sprintf("SELECT * FROM airway WHERE (pointNbr>='%s' AND pointNbr<'%s') AND airway='%s' ORDER BY pointNbr DESC", $fn, $tn, $awy);
				}

				$awyDbase->ExecSql($sql);

				while($row = $awyDbase->FetchRow())
				{
					$this->GetRow($row);
				}
			}
			else
			{
				$this->airway = null;
			}
		}

		$awyDbase->Disconnect();
	}

	public function GetRow($row)
	{
		$airwayData = new AirwayData($this->sess);

		$airwayData->id = $row["id"];
		$airwayData->airway = $row["airway"];
		$airwayData->type = $row["type"];
		$airwayData->pointNbr = $row["pointNbr"];
		$airwayData->pointName = $row["pointName"];
		$airwayData->pointType = $row["pointType"];
		$airwayData->pointId = $row["pointId"];
		$airwayData->magCourse = $row["magCourse"];
		$airwayData->magCourseOpposite = $row["magCourseOpposite"];
		$airwayData->MEA = $row["MEA"];
		$airwayData->MAX = $row["MAX"];
		$airwayData->MOCA = $row["MOCA"];

		$airwayData->latLon = new LatLon($row["latitude"], $row["longitude"]);

		array_push($this->airway, $airwayData);
	}

	public function FormatPlanInfo($latLon)
	{
		if ($this->airway == null)
		{
			return;
		}

		$str = null;

		foreach ($this->airway as $awy)
		{
			$str .= $awy->FormatPlanInfo($latLon);
		}

		return $str;
	}

	public function WaypointList()
	{
		$wp = null;

		// insert the waypoints when more than two in airway path
		// otherwise its just the from and to point
		$ac = count($this->airway);

		if ($ac > 2)
		{
			// from point and to point are entered as waypoints so
			// append the airway names starting at the second name
			for ($ee=1;$ee<($ac - 2);$ee++)
			{
				$pt = str_split($this->airway[$ee]->pointType);

				if (($pt[0] == 'N') || ($pt[0] == 'V'))
				{
					$wp .= " N;";
				}
				else
				{
					$wp .= " F;";
				}

				if ($this->airway[$ee]->pointId)
				{
					$wp .= $this->airway[$ee]->pointName . ";" . $this->airway[$ee]->pointId;
				}
				else
				{
					$wp .= $this->airway[$ee]->pointName;
				}
			}

			// from point and to point are entered as waypoints so
			// append the next-to-last airway name
			$pt = str_split($this->airway[$ac - 2]->pointType);

			if (($pt[0] == 'N') || ($pt[0] == 'V'))
			{
				$wp .= " N;";
			}
			else
			{
				$wp .= " F;";
			}

			if ($this->airway[$ee]->pointId)
			{
				$wp .= $this->airway[$ee]->pointName . ";" . $this->airway[$ee]->pointId;
			}
			else
			{
				$wp .= $this->airway[$ee]->pointName;
			}
		}

		return trim($wp);
	}
}
?>