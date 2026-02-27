<?php
class MaaUserGroupData
{
	public $id;
	public $maaId;
	public $name;

	public function FormatEntry()
	{
		return sprintf("<br/>%s", $this->name);
	}
}

class MaaUserGroup
{
	public $userGroup = array();

	public function __construct($name)
	{
		$sql = sprintf("SELECT * FROM maaUserGroup WHERE maaId='%s'", $name);

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
			$this->userGroup = null;
		}

		$maaDbase->Disconnect();
	}

	public function GetRow($row)
	{
		$maaUserGroupData = new MaaUserGroupData();

		$maaUserGroupData->id = $row["id"];
		$maaUserGroupData->maaId = $row["maaId"];
		$maaUserGroupData->name = htmlspecialchars($row["name"], ENT_QUOTES);

		array_push($this->userGroup, $maaUserGroupData);
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