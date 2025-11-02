<?php
class MaaNotamsData
{
	public $id;
	public $maaId;
	public $notams;

	public function FormatEntry()
	{
		return sprintf("<br/>%s", $this->notams);
	}
}

class MaaNotams
{
	public $notams = array();

	public function __construct($name)
	{
		$sql = sprintf("SELECT * FROM maaNotams WHERE maaId='%s'", $name);

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
			$this->notams = null;
		}

		$maaDbase->Disconnect();
	}

	public function GetRow($row)
	{
		$maaNotamsData = new MaaNotamsData();

		$maaNotamsData->id = $row["id"];
		$maaNotamsData->maaId = $row["maaId"];
		$maaNotamsData->notams = $row["notams"];

		array_push($this->notams, $maaNotamsData);
	}

	public function ListEntries()
	{
		if ($this->notams == null)
		{
			return;
		}

		$str = null;

		foreach ($this->notams as $ntm)
		{
			$str .= $ntm->FormatEntry();
		}

		return $str;
	}
}
?>