<?php
class TowerRadars
{
	public $id;
	public $facilityId;
	public $priApproachCall;
	public $secApproachCall;
	public $priDepartCall;
	public $secDepartCall;
	public $type01;
	public $hours01;
	public $type02;
	public $hours02;
	public $type03;
	public $hours03;
	public $type04;
	public $hours04;

	public function __construct($ident)
	{
		$sql = sprintf("SELECT * FROM twrRadars USE INDEX(twrRadarsFacilityId) WHERE facilityId='%s'", $ident);

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
		$this->priApproachCall = $row["priApproachCall"];
		$this->secApproachCall = $row["secApproachCall"];
		$this->priDepartCall = $row["priDepartCall"];
		$this->secDepartCall = $row["secDepartCall"];
		$this->type01 = $row["type01"];
		$this->hours01 = $row["hours01"];
		$this->type02 = $row["type02"];
		$this->hours02 = $row["hours02"];
		$this->type03 = $row["type03"];
		$this->hours03 = $row["hours03"];
		$this->type04 = $row["type04"];
		$this->hours04 = $row["hours04"];
	}

	public function ListEntries($header)
	{
		if ($this->facilityId == null)
		{
			return;
		}

		$str = null;

		if ($header)
		{
			$str .= sprintf("<b>RADARS</b>\r\n");
		}

		if ($this->priApproachCall)
		{
			$str .= sprintf("\r\n<br/>Pri-Approach:%s", $this->priApproachCall);
		}

		if ($this->secApproachCall)
		{
			$str .= sprintf("\r\n<br/>Sec-Approach:%s", $this->secApproachCall);
		}

		if ($this->priDepartCall)
		{
			$str .= sprintf("\r\n<br/>Pri-Depart:%s", $this->priDepartCall);
		}

		if ($this->secDepartCall)
		{
			$str .= sprintf("\r\n<br/>Sec-Depart:%s", $this->secDepartCall);
		}

		if ($this->type01)
		{
			$p = new Parameter("towerRadarType" . $this->type01);
			
			if ($p->value1)
			{
				$str .= sprintf("\r\n<br/>Type:%s:%s Hours:%s", $this->type01, $p->value1, $this->hours01);
			}
			else
			{
				$str .= sprintf("\r\n<br/>Type:%s Hours:%s", $this->type01, $this->hours01);
			}
		}

		if ($this->type02)
		{
			$p = new Parameter("towerRadarType" . $this->type02);
			
			if ($p->value1)
			{
				$str .= sprintf("\r\n<br/>Type:%s:%s Hours:%s", $this->type02, $p->value1, $this->hours02);
			}
			else
			{
				$str .= sprintf("\r\n<br/>Type:%s Hours:%s", $this->type02, $this->hours02);
			}
		}

		if ($this->type03)
		{
			$p = new Parameter("towerRadarType" . $this->type03);
			
			if ($p->value1)
			{
				$str .= sprintf("\r\n<br/>Type:%s:%s Hours:%s", $this->type03, $p->value1, $this->hours03);
			}
			else
			{
				$str .= sprintf("\r\n<br/>Type:%s Hours:%s", $this->type03, $this->hours02);
			}
		}

		if ($this->type04)
		{
			$p = new Parameter("towerRadarType" . $this->type04);
			
			if ($p->value1)
			{
				$str .= sprintf("\r\n<br/>Type:%s:%s Hours:%s", $this->type04, $p->value1, $this->hours04);
			}
			else
			{
				$str .= sprintf("\r\n<br/>Type:%s Hours:%s", $this->type04, $this->hours02);
			}
		}

		return $str;
	}
}
?>