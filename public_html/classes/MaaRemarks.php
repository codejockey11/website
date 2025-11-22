<?php
class MaaRemarksData
{
	public $id;
	public $maaId;
	public $text;

	public function FormatEntry()
	{
		return sprintf("<br/>%s", $this->text);
	}
}

class MaaRemarks
{
	public $remarks = array();

	public function __construct($name)
	{
		$sql = sprintf("SELECT * FROM maaRemarks WHERE maaId='%s'", $name);

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
			$this->remarks = null;
		}

		$maaDbase->Disconnect();
	}

	public function GetRow($row)
	{
		$maaRemarksData = new MaaRemarksData();

		$maaRemarksData->id = $row["id"];
		$maaRemarksData->maaId = $row["maaId"];
		$maaRemarksData->text = htmlspecialchars($row["text"], ENT_QUOTES);

		array_push($this->remarks, $maaRemarksData);
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