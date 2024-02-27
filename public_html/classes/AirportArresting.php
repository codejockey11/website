<?php
class AirportArrestingData
{
	public $id;
	public $facilityId;
	public $arrestingEnd;
	public $arrestingType;

	public function FormatEntry()
	{
		$str  = sprintf("\r\n<br/>%s", $this->arrestingEnd);

		$p = new Parameter("arresting" . $this->arrestingType);
		
		$str .= sprintf(" <a class=\"tooltip\" href=\"#\">%s<span>%s</span></a>\r\n", $this->arrestingType, $p->value1);

		return $str;
	}

	public function FormatPlanInfo($rwy)
	{
		if ($this->arrestingEnd != $rwy)
		{
			return;
		}

		return sprintf("\r\n<br/>%s %s", $this->arrestingEnd, $this->arrestingType);
	}
}

class AirportArresting
{
	public $airportArresting = array();

	public function __construct($sql)
	{
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
			$this->airportArresting = null;
		}

		$aptDbase->Disconnect();
	}

	public function GetRow($row)
	{
		$airportArrestingData = new AirportArrestingData();

		$airportArrestingData->id = $row["id"];
		$airportArrestingData->facilityId = $row["facilityId"];
		$airportArrestingData->arrestingEnd = $row["arrestingEnd"];
		$airportArrestingData->arrestingType = $row["arrestingType"];

		array_push($this->airportArresting, $airportArrestingData);
	}

	public function ListEntries()
	{
		if ($this->airportArresting == null)
		{
			return;
		}

		$str = null;

		foreach ($this->airportArresting as $ars)
		{
			$str .= $ars->FormatEntry();
		}

		return $str;
	}

	public function FormatPlanInfo($rwy)
	{
		if ($this->airportArresting == null)
		{
			return;
		}

		$str = null;

		foreach ($this->airportArresting as $ars)
		{
			$str .= $ars->FormatPlanInfo($rwy);
		}

		return $str;
	}
}
?>