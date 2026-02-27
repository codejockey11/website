<?php
class IlsApproachData
{
	public $id;
	public $facilityId;
	public $runway;
	public $type;
	public $idCode;
	public $morse;
	public $category;
	public $approachBearing;
	public $magVar;

	public function FormatEntry()
	{
		$str  = sprintf("\r\n<br/><br/>Course:<br/>%s", $this->runway);
		
		$str .= sprintf(" %s", $this->type);
		
		$str .= sprintf(" cat:%s", $this->category);
		
		$str .= sprintf(" %s", $this->idCode);
		
		$str .= sprintf(" %s", $this->morse);
		
		$str .= sprintf(" %s", $this->approachBearing);

		return $str;
	}

	public function WaypointInfo()
	{
		$str  = sprintf("\r\n<br/>%s", $this->runway);
		
		$str .= sprintf(" %s", $this->type);
		
		$str .= sprintf("\r\n<br/>%s", $this->category);
		
		$str .= sprintf(" %s", $this->idCode);
		
		$str .= sprintf(" %s", $this->morse);
		
		$str .= sprintf(" %s", $this->approachBearing);

		return $str;
	}
}

class IlsApproach
{
	public $approach = array();

	public function __construct($name, $rwy)
	{
		$sql = sprintf("SELECT * FROM ilsApproach WHERE facilityId='%s' AND runway='%s'", $name, $rwy);

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
			$this->approach = null;
		}

		$ilsDbase->Disconnect();
	}

	public function GetRow($row)
	{
		$ilsApproachData = new IlsApproachData();

		$ilsApproachData->id = $row["id"];
		$ilsApproachData->facilityId = $row["facilityId"];
		$ilsApproachData->runway = $row["runway"];
		$ilsApproachData->type = $row["type"];
		$ilsApproachData->idCode = $row["idCode"];
		$ilsApproachData->morse = $row["morse"];
		$ilsApproachData->category = $row["category"];
		$ilsApproachData->approachBearing = $row["approachBearing"];
		$ilsApproachData->magVar = $row["magVar"];

		array_push($this->approach, $ilsApproachData);
	}

	public function GetSingle($i)
	{
		if ($this->approach == null)
		{
			return;
		}

		return $this->approach[$i];
	}

	public function ListEntries()
	{
		if ($this->approach == null)
		{
			return;
		}

		$str = null;

		foreach ($this->approach as $apr)
		{
			$str .= $apr->FormatEntry();
		}

		return $str;
	}

	public function WaypointInfo()
	{
		if ($this->approach == null)
		{
			return;
		}

		$str = null;

		foreach ($this->approach as $apr)
		{
			$str .= $apr->WaypointInfo();
		}

		return $str;
	}
}
?>