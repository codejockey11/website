<?php
class AwosData
{
	public $id;
	public $sensorId;
	public $type;
	public $latitude;
	public $longitude;
	public $elevation;
	public $freq1;
	public $freq2;
	public $phone1;
	public $phone2;

	public $remarks;

	public function FormatEntry()
	{
		$str = null;

		if ($this->freq1)
		{
			$str .= sprintf("\r\n<br/>%s %s", $this->type, $this->freq1);
		}

		if ($this->phone1)
		{
			$str .= sprintf("\r\n<br/>%s (%s)", $this->type, $this->phone1);
		}

		if ($this->freq2)
		{
			$str .= sprintf("\r\n<br/>%s %s", $this->type, $this->freq2);
		}

		if ($this->phone2)
		{
			$str .= sprintf("\r\n<br/>%s (%s)", $this->type, $this->phone2);
		}

		/*
		if ($this->remarks->remarks)
		{
			$str .= $this->remarks->ListEntries();
		}
		*/

		return $str;
	}
}

class Awos
{
	public $station = array();

	public function __construct($sql)
	{
		$awosDbase = new Database();
		
		$awosDbase->ExecSql($sql);

		if ($awosDbase->GetRowCount() > 0)
		{
			while($row = $awosDbase->FetchRow())
			{
				$this->GetRow($row);
			}
		}
		else
		{
			$this->station = null;
		}

		$awosDbase->Disconnect();
	}

	public function GetRow($row)
	{
		$awosData = new AwosData();

		$awosData->id = $row["id"];
		$awosData->sensorId = $row["sensorId"];
		$awosData->type = $row["type"];
		$awosData->latitude = $row["latitude"];
		$awosData->longitude = $row["longitude"];
		$awosData->elevation = $row["elevation"];
		$awosData->freq1 = $row["freq1"];
		$awosData->freq2 = $row["freq2"];
		$awosData->phone1 = $row["phone1"];
		$awosData->phone2 = $row["phone2"];

		$sql = sprintf("SELECT * FROM awosRemarks USE INDEX(awosRemarksSensorId) WHERE sensorId='%s'", $awosData->sensorId);

		$awosData->remarks = new AwosRemarks($sql);

		array_push($this->station, $awosData);
	}

	public function ListEntries()
	{
		if ($this->station == null)
		{
			return;
		}

		$str = null;

		foreach ($this->station as $stn)
		{
			$str .= $stn->FormatEntry();
		}

		return $str;
	}
}
?>