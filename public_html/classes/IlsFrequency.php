<?php
class IlsFrequencyData
{
	public $id;
	public $facilityId;
	public $runway;
	public $latitude;
	public $longitude;
	public $altitudeMsl;
	public $frequency;
	public $backcourse;
	public $courseWidth;
	public $courseWidthThreshold;

	public function FormatEntry()
	{
		$str  = sprintf("\r\n<br/>Localizer Frequency &amp; Beam:");
		
		$str .= sprintf("\r\n<br/>%s", $this->runway);
		
		$str .= sprintf(" %s", $this->frequency);

		if ($this->backcourse)
		{
			$str .= sprintf(" bc:%s", $this->backcourse);
		}

		$str .= sprintf(" %s", $this->courseWidth);
		
		$str .= sprintf(" %s", $this->courseWidthThreshold);
		
		$str .= sprintf("\r\n<br/>%s %s", $this->latitude, $this->longitude);

		return $str;
	}

	public function WaypointInfo()
	{
		$str  = sprintf("%s", $this->runway);
		
		$str .= sprintf(" %s", $this->frequency);

		if ($this->backcourse)
		{
			$str .= sprintf(" bc:%s", $this->backcourse);
		}

		return $str;
	}
}

class IlsFrequency
{
	public $frequency = array();

	public function __construct($ident, $rwy)
	{
		$sql = sprintf("SELECT * FROM ilsFrequency WHERE facilityId='%s' AND runway='%s'", $ident, $rwy);

		$ilsDbase = new Database();
		
		$ilsDbase->ExecSql($sql);

		if ($ilsDbase->GetRowCount() > 0)
		{
			while($row = $ilsDbase->FetchRow())
			{
				$this->GetRow($row);
			}
		}
		else
		{
			$this->frequency = null;
		}

		$ilsDbase->Disconnect();
	}

	public function GetRow($row)
	{
		$ilsFrequencyData = new IlsFrequencyData();

		$ilsFrequencyData->id = $row["id"];
		$ilsFrequencyData->facilityId = $row["facilityId"];
		$ilsFrequencyData->runway = $row["runway"];
		$ilsFrequencyData->latitude = $row["latitude"];
		$ilsFrequencyData->longitude = $row["longitude"];
		$ilsFrequencyData->altitudeMsl = $row["altitudeMsl"];
		$ilsFrequencyData->frequency = $row["frequency"];
		$ilsFrequencyData->backcourse = $row["backcourse"];
		$ilsFrequencyData->courseWidth = $row["courseWidth"];
		$ilsFrequencyData->courseWidthThreshold = $row["courseWidthThreshold"];

		array_push($this->frequency, $ilsFrequencyData);
	}

	public function GetSingle($i)
	{
		if ($this->frequency == null)
		{
			return;
		}

		return $this->frequency[$i];
	}

	public function ListEntries()
	{
		if ($this->frequency == null)
		{
			return;
		}

		$str = null;

		foreach ($this->frequency as $frq)
		{
			$str .= $frq->FormatEntry();
		}

		return $str;
	}

	public function WaypointInfo()
	{
		if ($this->frequency == null)
		{
			return;
		}

		$str = null;

		foreach ($this->frequency as $frq)
		{
			$str .= "\r\n<br/>";
			
			$str .= $frq->WaypointInfo();
		}

		return $str;
	}
}
?>