<?php
class TowerRemarksData
{
	public $id;
	public $facilityId;
	public $element;
	public $text;

	public function FormatEntry()
	{
		return sprintf("%s", $this->text);
	}

	public function FormatPlanInfo()
	{
		return sprintf("\r\n<br/>%s", $this->text);
	}
}

class TowerRemarks
{
	public $remarks = array();

	public function __construct($ident)
	{
		$sql = sprintf("SELECT * FROM twrRemarks USE INDEX(twrRemarksFacilityId) WHERE facilityId='%s' ORDER BY element", $ident);

		$twrDbase = new Database();
		
		$twrDbase->ExecSql($sql);

		if ($twrDbase->GetRowCount() > 0)
		{
			while($row = $twrDbase->FetchRow())
			{
				$this->GetRow($row);
			}
		}
		else
		{
			$this->remarks = null;
		}

		$twrDbase->Disconnect();
	}

	public function GetRow($row)
	{
		$towerRemarksData = new TowerRemarksData();

		$towerRemarksData->id = $row["id"];
		$towerRemarksData->facilityId = $row["facilityId"];
		$towerRemarksData->element = $row["element"];
		$towerRemarksData->text = htmlspecialchars($row["text"], ENT_QUOTES);

		array_push($this->remarks, $towerRemarksData);
	}

	public function ListEntries($header)
	{
		if ($this->remarks == null)
		{
			return;
		}

		$str = null;
		
		$firstOne = true;

		if ($header)
		{
			$str .= sprintf("<b>TOWER REMARKS</b><br/>\r\n");
		}

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

	public function FormatPlanInfo()
	{
		if ($this->remarks == null)
		{
			return;
		}

		$str = null;


		foreach ($this->remarks as $rmk)
		{
			$str .= $rmk->FormatPlanInfo();
		}

		return $str;
	}
}
?>