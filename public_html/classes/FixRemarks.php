<?php
class FixRemarksData
{
	public $id;
	public $fixId;
	public $text;

	public function WaypointInfo()
	{
		return sprintf("\r\n<br/>%s", $this->text);
	}

	public function FormatEntry()
	{
		return sprintf("%s", $this->text);
	}
}

class FixRemarks
{
	public $remarks = array();

	public function __construct($sql)
	{
		$fixDbase = new Database();
		
		$fixDbase->ExecSql($sql);

		if ($fixDbase->GetRowCount() > 0)
		{
			while($row = $fixDbase->FetchRow())
			{
				$this->GetRow($row);
			}
		}
		else
		{
			$this->remarks = null;
		}

		$fixDbase->Disconnect();
	}

	public function GetRow($row)
	{
		$fixRemarksData = new FixRemarksData();

		$fixRemarksData->id = $row["id"];
		$fixRemarksData->fixId = $row["fixId"];
		$fixRemarksData->text = htmlspecialchars($row["text"], ENT_QUOTES);

		array_push($this->remarks, $fixRemarksData);
	}

	public function WaypointInfo()
	{
		if ($this->remarks == null)
		{
			return;
		}

		$str = null;

		foreach ($this->remarks as $rmk)
		{
			$str .= $rmk->WaypointInfo();
		}

		return $str;
	}

	public function ListEntries()
	{
		if ($this->remarks == null)
		{
			return;
		}

		$str = null;
		
		$firstOne = true;

		foreach ($this->remarks as $rmk)
		{
			if ($firstOne)
			{
				$firstOne = false;
			}
			else
			{
				$str .= sprintf("\r\n<br/>");
			}

			$str .= $rmk->FormatEntry();
		}

		return $str;
	}
}
?>