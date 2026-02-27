<?php
class PjaUserGroupData
{
	public $id;
	public $pjaId;
	public $name;
	public $description;

	public function FormatEntry()
	{
		return sprintf("<br/>%s %s", $this->name, $this->description);
	}
}

class PjaUserGroup
{
	public $userGroup = array();

	public function __construct($name)
	{
		$sql = sprintf("SELECT * FROM pjaUserGroup WHERE pjaId='%s'", $name);

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
			$this->userGroup = null;
		}

		$pjaDbase->Disconnect();
	}

	public function GetRow($row)
	{
		$pjaUserGroupData = new PjaUserGroupData();

		$pjaUserGroupData->id = $row["id"];
		$pjaUserGroupData->pjaId = $row["pjaId"];
		$pjaUserGroupData->name = htmlspecialchars($row["name"], ENT_QUOTES);
		$pjaUserGroupData->description = htmlspecialchars($row["description"], ENT_QUOTES);

		array_push($this->userGroup, $pjaUserGroupData);
	}

	public function ListEntries()
	{
		if ($this->userGroup == null)
		{
			return;
		}

		$str = null;

		foreach ($this->userGroup as $usg)
		{
			$str .= $usg->FormatEntry();
		}

		return $str;
	}
}
?>