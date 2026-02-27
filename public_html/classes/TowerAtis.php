<?php
class TowerAtis
{
	public $id;
	public $facilityId;
	public $serialNbr;
	public $hours;
	public $description;
	public $phone;

	public function __construct($ident)
	{
		$sql = sprintf("SELECT * FROM twrAtis USE INDEX(twrAtisFacilityId) WHERE facilityId='%s'", $ident);

		$twrDbase = new Database();
		
		$twrDbase->ExecSql($sql);

		if ($twrDbase->GetRowCount() > 0)
		{
			$this->GetRow($row = $twrDbase->FetchRow());
		}

		$twrDbase->Disconnect();
	}

	public function GetRow($row)
	{
		$this->id = $row["id"];
		$this->facilityId = $row["facilityId"];
		$this->serialNbr = $row["serialNbr"];
		$this->hours = $row["hours"];
		$this->description = $row["description"];
		$this->phone = $row["phone"];
	}

	public function ListEntries()
	{
		if ($this->facilityId == null)
		{
			return;
		}

		$str = null;

		if ($this->serialNbr)
		{
			$str .= sprintf("\r\n<br/>Serial Nbr:%s", $this->serialNbr);
		}

		if ($this->hours)
		{
			$str .= sprintf("\r\n<br/>Hours:%s", $this->hours);
		}

		if ($this->description)
		{
			$str .= sprintf("\r\n<br/>Description:%s", $this->description);
		}

		if ($this->phone)
		{
			$str .= sprintf("\r\n<br/>Phone:%s", $this->phone);
		}

		return $str;
	}
}
?>