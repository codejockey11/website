<?php
class IlsRemarksData
{
	public $id;
	public $facilityId;
	public $runway;
	public $text;

	public function FormatEntry()
	{
		return sprintf("%s", $this->text);
	}
}

class IlsRemarks
{
	public $remarks = array();

	public function __construct($name, $rwy)
	{
		$sql = sprintf("SELECT * FROM ilsRemarks WHERE facilityId='%s' AND runway='%s'", $name, $rwy);

		$ilsDbase = new Database();
		
		$ilsDbase->ExecSql($sql);

		if ($ilsDbase->GetRowCount() > 0)
		{
			while($row = $ilsDbase->FetchRow())
			{
				$this->GetRow($row);
			}
		}
		else
		{
			$this->remarks = null;
		}

		$ilsDbase->Disconnect();
	}

	public function GetRow($row)
	{
		$ilsRemarksData = new IlsRemarksData();

		$ilsRemarksData->id = $row["id"];
		$ilsRemarksData->facilityId = $row["facilityId"];
		$ilsRemarksData->runway = $row["runway"];
		$ilsRemarksData->text = htmlspecialchars($row["text"], ENT_QUOTES);

		array_push($this->remarks, $ilsRemarksData);
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