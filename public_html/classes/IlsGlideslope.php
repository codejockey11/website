<?php
class IlsGlideslopeData
{
	public $id;
	public $facilityId;
	public $runway;
	public $latitude;
	public $longitude;
	public $altitudeMsl;
	public $type;
	public $angle;
	public $freq;

	public function FormatEntry()
	{
		$str  = sprintf("\r\n<br/>Glideslope:<br/>%s", $this->runway);
		
		$str .= sprintf(" %s", $this->type);
		
		$str .= sprintf(" %s", $this->angle);
		
		$str .= sprintf(" %.3f", $this->freq);

		return $str;
	}

	public function WaypointInfo()
	{
		$str  = sprintf("\r\n<br/>%s", $this->runway);
		
		$str .= sprintf(" %s", $this->type);
		
		$str .= sprintf(" %s", $this->angle);
		
		$str .= sprintf(" %.3f", $this->freq);

		return $str;
	}
}

class IlsGlideslope
{
	public $glideslope = array();

	public function __construct($name, $rwy)
	{
		$sql = sprintf("SELECT * FROM ilsGlideslope WHERE facilityId='%s' AND runway='%s'", $name, $rwy);

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
			$this->glideslope = null;
		}

		$ilsDbase->Disconnect();
	}

	public function GetRow($row)
	{
		$ilsGlideslopeData = new IlsGlideslopeData();

		$ilsGlideslopeData->id = $row["id"];
		$ilsGlideslopeData->facilityId = $row["facilityId"];
		$ilsGlideslopeData->runway = $row["runway"];
		$ilsGlideslopeData->latitude = $row["latitude"];
		$ilsGlideslopeData->longitude = $row["longitude"];
		$ilsGlideslopeData->altitudeMsl = $row["altitudeMsl"];
		$ilsGlideslopeData->type = $row["type"];
		$ilsGlideslopeData->angle = $row["angle"];
		$ilsGlideslopeData->freq = $row["freq"];

		array_push($this->glideslope, $ilsGlideslopeData);
	}

	public function ListEntries()
	{
		if ($this->glideslope == null)
		{
			return;
		}

		$str = null;

		foreach ($this->glideslope as $gls)
		{
			$str .= $gls->FormatEntry();
		}

		return $str;
	}

	public function WaypointInfo()
	{
		if ($this->glideslope == null)
		{
			return;
		}

		$str = null;

		foreach ($this->glideslope as $gls)
		{
			$str .= $gls->WaypointInfo();
		}

		return $str;
	}
}
?>