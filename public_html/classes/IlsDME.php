<?php
class IlsDMEData
{
	public $id;
	public $facilityId;
	public $runway;
	public $status;
	public $distance;

	public function FormatEntry()
	{
		$str  = sprintf("\r\n<br/>DME:<br/>%s", $this->runway);
		
		$str .= sprintf(" %s", $this->status);

		if (is_numeric($this->distance))
		{
			$str .= sprintf(" %1.2fnm", $this->distance / 6076);
		}

		return $str;
	}

	public function WaypointInfo()
	{
		$str = null;

		if (is_numeric($this->distance))
		{
			$str .= sprintf("\r\n<br/>%s", $this->runway);
			
			$str .= sprintf(" %1.2fnm", $this->distance / 6076);
		}

		return $str;
	}
}

class IlsDME
{
	public $dme = array();

	public function __construct($name, $rwy)
	{
		$sql = sprintf("SELECT * FROM ilsDme WHERE facilityId='%s' AND runway='%s'", $name, $rwy);

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
			$this->dme = null;
		}

		$ilsDbase->Disconnect();
	}

	public function GetRow($row)
	{
		$ilsDMEData = new IlsDMEData();

		$ilsDMEData->id = $row["id"];
		$ilsDMEData->facilityId = $row["facilityId"];
		$ilsDMEData->runway = $row["runway"];
		$ilsDMEData->status = $row["status"];
		$ilsDMEData->distance = $row["distance"];

		array_push($this->dme, $ilsDMEData);
	}

	public function ListEntries()
	{
		if ($this->dme == null)
		{
			return;
		}

		$str = null;

		foreach ($this->dme as $dme)
		{
			$str .= $dme->FormatEntry();
		}

		return $str;
	}

	public function WaypointInfo()
	{
		if ($this->dme == null)
		{
			return;
		}

		$str = null;

		foreach ($this->dme as $dme)
		{
			$str .= $dme->WaypointInfo();
		}

		return $str;
	}
}
?>