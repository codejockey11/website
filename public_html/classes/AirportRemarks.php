<?php
class AirportRemarksData
{
	public $id;
	public $facilityId;
	public $element;
	public $text;

	public function FormatEntry()
	{
		return sprintf("%s %s", $this->element, $this->text);
	}

	public function FormatPlanInfo()
	{
		return sprintf("%s %s", $this->element, $this->text);
	}
}

class AirportRemarks
{
	public $remarks = array();

	public function __construct($sql)
	{
		$aptDbase = new Database();
		
		$aptDbase->ExecSql($sql);

		if ($aptDbase->GetRowCount() > 0)
		{
			while($row = $aptDbase->FetchRow())
			{
				$this->GetRow($row);
			}
		}
		else
		{
			$this->remarks = null;
		}

		$aptDbase->Disconnect();
	}

	public function GetRow($row)
	{
		$airportRemarksData = new AirportRemarksData();

		$airportRemarksData->id = $row["id"];
		$airportRemarksData->facilityId = $row["facilityId"];
		$airportRemarksData->element = $row["element"];
		$airportRemarksData->text = htmlspecialchars($row["text"], ENT_QUOTES);

		array_push($this->remarks, $airportRemarksData);
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
			$str .= sprintf("<b>AIRPORT REMARKS</b><br/>\r\n");
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

			$str .= $rmk->FormatPlanInfo();
		}

		return $str;
	}
}
?>