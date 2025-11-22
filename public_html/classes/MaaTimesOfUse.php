<?php
class MaaTimesOfUseData
{
	public $id;
	public $maaId;
	public $times;

	public function FormatEntry()
	{
		return sprintf("<br/>%s", $this->times);
	}
}

class MaaTimesOfUse
{
	public $times = array();

	public function __construct($name)
	{
		$sql = sprintf("SELECT * FROM maaTimes WHERE maaId='%s'", $name);

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
			$this->times = null;
		}

		$maaDbase->Disconnect();
	}

	public function GetRow($row)
	{
		$maaTimesOfUseData = new MaaTimesOfUseData();

		$maaTimesOfUseData->id = $row["id"];
		$maaTimesOfUseData->maaId = $row["maaId"];
		$maaTimesOfUseData->times = $row["timesOfUse"];

		array_push($this->times, $maaTimesOfUseData);
	}

	public function ListEntries()
	{
		if ($this->times == null)
		{
			return;
		}

		$str = null;

		foreach ($this->times as $tms)
		{
			$str .= $tms->FormatEntry();
		}

		return $str;
	}
}
?>