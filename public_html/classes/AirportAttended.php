<?php
class AirportAttendedData
{
	public $id;
	public $facilityId;
	public $attendance;

	public function FormatEntry()
	{
		return sprintf("\r\n<br/>%s", $this->attendance);
	}

	public function FormatPlanInfo()
	{
		return sprintf(" h:%s", $this->attendance);
	}
}

class AirportAttended
{
	public $attended = array();

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
			$this->attended = null;
		}

		$aptDbase->Disconnect();
	}

	public function GetRow($row)
	{
		$airportAttendedData = new AirportAttendedData();

		$airportAttendedData->id = $row["id"];
		$airportAttendedData->facilityId = $row["facilityId"];
		$airportAttendedData->attendance = $row["attendance"];

		array_push($this->attended, $airportAttendedData);
	}

	public function ListEntries($header)
	{
		if ($this->attended == null)
		{
			return;
		}

		$str = null;

		if ($header)
		{
			$str .= sprintf("\r\n<br/>Attended:M-F/Sat/Sun");
		}

		foreach ($this->attended as $atd)
		{
			$str .= $atd->FormatEntry();
		}

		return $str;
	}

	public function FormatPlanInfo()
	{
		if ($this->attended == null)
		{
			return;
		}

		$str = null;

		foreach ($this->attended as $atd)
		{
			$str .= $atd->FormatPlanInfo();
		}

		return $str;
	}
}
?>