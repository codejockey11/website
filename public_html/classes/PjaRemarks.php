<?php
class PjaRemarksData
{
	public $id;
	public $pjaId;
	public $text;

	public function FormatEntry()
	{
		return sprintf("<br/>%s", $this->text);
	}
}

class PjaRemarks
{
	public $remarks = array();

	public function __construct($name)
	{
		$sql = sprintf("SELECT * FROM pjaRemarks WHERE pjaId='%s'", $name);

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
			$this->remarks = null;
		}

		$pjaDbase->Disconnect();
	}

	public function GetRow($row)
	{
		$pjaRemarksData = new PjaRemarksData();

		$pjaRemarksData->id = $row["id"];
		$pjaRemarksData->pjaId = $row["pjaId"];
		$pjaRemarksData->text = htmlspecialchars($row["text"], ENT_QUOTES);

		array_push($this->remarks, $pjaRemarksData);
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