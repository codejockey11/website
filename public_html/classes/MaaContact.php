<?php
class MaaContactData
{
	public $id;
	public $maaId;
	public $contactFacilityId;
	public $contactFacilityName;
	public $commercialFrequency;
	public $commercialChartFlag;
	public $militaryFrequency;
	public $militaryChartFlag;

	public function FormatEntry()
	{
		return sprintf("<br/>%s %s<br/>%s %s", $this->contactFacilityId, $this->contactFacilityName, $this->commercialFrequency, $this->militaryFrequency);
	}
}

class MaaContact
{
	public $contact = array();

	public function __construct($name)
	{
		$sql = sprintf("SELECT * FROM maaContact WHERE maaId='%s'", $name);

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
			$this->contact = null;
		}

		$maaDbase->Disconnect();
	}

	public function GetRow($row)
	{
		$maaContactData = new MaaContactData();

		$maaContactData->id = $row["id"];
		$maaContactData->maaId = $row["maaId"];
		$maaContactData->contactFacilityId = $row["contactFacilityId"];
		$maaContactData->contactFacilityName = $row["contactFacilityName"];
		$maaContactData->commercialFrequency = $row["commercialFrequency"];
		$maaContactData->commercialChartFlag = $row["commercialChartFlag"];
		$maaContactData->militaryFrequency = $row["militaryFrequency"];
		$maaContactData->militaryChartFlag = $row["militaryChartFlag"];

		array_push($this->contact, $maaContactData);
	}

	public function ListEntries()
	{
		if ($this->contact == null)
		{
			return;
		}

		$str = null;

		foreach ($this->contact as $ctc)
		{
			$str .= $ctc->FormatEntry();
		}

		return $str;
	}
}
?>