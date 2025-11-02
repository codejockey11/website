<?php
class PjaContactData
{
	public $id;
	public $pjaId;
	public $contactFacilityId;
	public $commercialFrequency;
	public $militaryFrequency;

	public function FormatEntry()
	{
		return sprintf("<br/>%s %s %s", $this->contactFacilityId, $this->commercialFrequency, $this->militaryFrequency);
	}
}

class PjaContact
{
	public $contact = array();

	public function __construct($name)
	{
		$sql = sprintf("SELECT * FROM pjaContact WHERE pjaId='%s'", $name);

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
			$this->contact = null;
		}

		$pjaDbase->Disconnect();
	}

	public function GetRow($row)
	{
		$pjaContactData = new PjaContactData();

		$pjaContactData->id = $row["id"];
		$pjaContactData->pjaId = $row["pjaId"];
		$pjaContactData->contactFacilityId = $row["contactFacilityId"];
		$pjaContactData->commercialFrequency = $row["commercialFrequency"];
		$pjaContactData->militaryFrequency = $row["militaryFrequency"];

		array_push($this->contact, $pjaContactData);
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