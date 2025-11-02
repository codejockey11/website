<?php
class NavaidRemarksData
{
	public $id;
	public $facilityId;
	public $name;
	public $text;

	public function FormatEntry()
	{
		return sprintf("%s", $this->text);
	}
}

class NavaidRemarks
{
	public $remarks = array();

	public function __construct($sql)
	{
		$navDbase = new Database();
		
		$navDbase->ExecSql($sql);

		if ($navDbase->GetRowCount() > 0)
		{
			while($row = $navDbase->FetchRow())
			{
				$this->GetRow($row);
			}
		}
		else
		{
			$this->remarks = null;
		}

		$navDbase->Disconnect();
	}

	public function GetRow($row)
	{
		$navaidRemarksData = new NavaidRemarksData();

		$navaidRemarksData->id = $row["id"];
		$navaidRemarksData->facilityId = $row["facilityId"];
		$navaidRemarksData->name = $row["name"];
		$navaidRemarksData->text = htmlspecialchars($row["text"], ENT_QUOTES);

		array_push($this->remarks, $navaidRemarksData);
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