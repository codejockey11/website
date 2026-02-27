<?php
class PjaTimesData
{
	public $id;
	public $pjaId;
	public $times;

	public function FormatEntry()
	{
		return sprintf("<br/>%s", $this->times);
	}
}

class PjaTimes
{
	public $pjaTimes = array();

	public function __construct($name)
	{
		$sql = sprintf("SELECT * FROM pjaTimes WHERE pjaId='%s'", $name);

		$pjaDbase = new Database();
		
		$pjaDbase->ExecSql($sql);

		if ($pjaDbase->GetRowCount() > 0)
		{
			while($row = $pjaDbase->FetchRow())
			{
				$this->GetRow($row);
			}
		}
		else
		{
			$this->pjaTimes = null;
		}

		$pjaDbase->Disconnect();
	}

	public function GetRow($row)
	{
		$pjaTimesData = new PjaTimesData();

		$pjaTimesData->id = $row["id"];
		$pjaTimesData->pjaId = $row["pjaId"];
		$pjaTimesData->times = htmlspecialchars($row["times"], ENT_QUOTES);

		array_push($this->pjaTimes, $pjaTimesData);
	}

	public function ListEntries()
	{
		if ($this->pjaTimes == null)
		{
			return;
		}

		$str = null;

		foreach ($this->pjaTimes as $tms)
		{
			$str .= $tms->FormatEntry();
		}

		return $str;
	}
}
?>