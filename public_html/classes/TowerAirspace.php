<?php
class TowerAirspace
{
	public $id;
	public $facilityId;
	public $classB;
	public $classC;
	public $classD;
	public $classE;
	public $airspaceHours;

	public function __construct($ident)
	{
		$sql = sprintf("SELECT * FROM twrAirspace USE INDEX(twrAirspaceFacilityId) WHERE facilityId='%s'", $ident);

		$twrDbase = new Database();
		
		$twrDbase->ExecSql($sql);

		if ($twrDbase->GetRowCount() > 0)
		{
			$row = $twrDbase->FetchRow();

			$this->GetRow($row);
		}

		$twrDbase->Disconnect();
	}

	public function GetRow($row)
	{
		$this->id = $row["id"];
		$this->facilityId = $row["facilityId"];
		$this->classB = $row["classB"];
		$this->classC = $row["classC"];
		$this->classD = $row["classD"];
		$this->classE = $row["classE"];
		$this->airspaceHours = $row["airspaceHours"];
	}

	public function ListEntries()
	{
		if ($this->facilityId == null)
		{
			return;
		}

		$str = null;

		if ($this->classB)
		{
			$str .= sprintf("\r\n<br/>Class:B");
		}

		if ($this->classC)
		{
			$str .= sprintf("\r\n<br/>Class:C");
		}

		if ($this->classD)
		{
			$str .= sprintf("\r\n<br/>Class:D");
		}

		if ($this->airspaceHours)
		{
			$str .= sprintf("\r\n<br/>Hours:%s", $this->airspaceHours);
		}

		return $str;
	}
}
?>