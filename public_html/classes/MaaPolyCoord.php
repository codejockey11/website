<?php
class MaaPolyCoordData
{
	public $id;
	public $maaId;
	public $latitude;
	public $longitude;

	public function FormatEntry()
	{
		return sprintf("<br/>%s %s", $this->latitude, $this->longitude);
	}
}

class MaaPolyCoord
{
	public $coordinates = array();

	public function __construct($name)
	{
		$sql = sprintf("SELECT * FROM maaPolyCoord WHERE maaId='%s'", $name);

		$maaDbase = new Database();
		
		$maaDbase->ExecSql($sql);

		if ($maaDbase->GetRowCount() > 0)
		{
			while($row = $maaDbase->FetchRow())
			{
				$this->GetRow($row);
			}
		}
		else
		{
			$this->coordinates = null;
		}

		$maaDbase->Disconnect();
	}

	public function GetRow($row)
	{
		$maaPolyCoordData = new MaaPolyCoordData();

		$maaPolyCoordData->id = $row["id"];
		$maaPolyCoordData->maaId = $row["maaId"];
		$maaPolyCoordData->latitude = $row["latitude"];
		$maaPolyCoordData->longitude = $row["longitude"];

		array_push($this->coordinates, $maaPolyCoordData);
	}
	
	public function GetSingle($i)
	{
		if ($this->coordinates == null)
		{
			return;
		}

		return $this->coordinates[$i];
	}

	public function ListEntries()
	{
		if ($this->coordinates == null)
		{
			return;
		}

		$str = null;

		foreach ($this->coordinates as $crd)
		{
			$str .= $crd->FormatEntry();
		}

		return $str;
	}
}
?>