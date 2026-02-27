<?php
class AwosRemarksData
{
	public $id;
	public $sensorId;
	public $text;

	public function FormatEntry()
	{
		$str = null;

		$str .= sprintf("\r\n<br/>%s", $this->text);

		return $str;
	}
}

class AwosRemarks
{
	public $remarks = array();

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
			$this->remarks = null;
		}

		$awosDbase->Disconnect();
	}

	public function GetRow($row)
	{
		$awosRemarksData = new AwosRemarksData();

		$awosRemarksData->id = $row["id"];
		$awosRemarksData->sensorId = $row["sensorId"];
		$awosRemarksData->text = $row["text"];

		array_push($this->remarks, $awosRemarksData);
	}

	public function ListEntries()
	{
		if ($this->remarks == null)
		{
			return;
		}

		$str = null;

		foreach ($this->remarks as $rmk)
		{
			$str .= $rmk->FormatEntry();
		}

		return $str;
	}
}
?>