<?php
class TowerHoursOfOp
{
	public $id;
	public $facilityId;
	public $hoursOfOp;
	public $pilotToMetroService;
	public $militaryAircraftCommandPost;
	public $militaryOp;
	public $priApproachControl;
	public $secApproachControl;
	public $priDepartureControl;
	public $secDepartureControl;

	public function __construct($ident)
	{
		$sql = sprintf("SELECT * FROM twrHoursOfOp USE INDEX(twrHoursOfOpFacilityId) WHERE facilityId='%s'", $ident);

		$twrDbase = new Database();
		
		$twrDbase->ExecSql($sql);

		if ($twrDbase->GetRowCount() > 0)
		{
			$row = $twrDbase->FetchRow();

			$this->GetRow($row);
		}

		$twrDbase->Disconnect();
	}

	public function GetRow($row)
	{
		$this->id = $row["id"];	
		$this->facilityId = $row["facilityId"];
		$this->hoursOfOp = $row["hoursOfOp"];
		$this->pilotToMetroService = $row["pilotToMetroService"];
		$this->militaryAircraftCommandPost = $row["militaryAircraftCommandPost"];
		$this->militaryOp = $row["militaryOp"];
		$this->priApproachControl = $row["priApproachControl"];
		$this->secApproachControl = $row["secApproachControl"];
		$this->priDepartureControl = $row["priDepartureControl"];
		$this->secDepartureControl = $row["secDepartureControl"];
	}

	public function ListEntries()
	{
		if ($this->facilityId == null)
		{
			return;
		}

		$str  = sprintf("\r\n<br/><b>HOURS OF OPERATION</b>\r\n");
		
		$str .= sprintf("\r\n<br/>Hours:%s", $this->hoursOfOp);

		if ($this->pilotToMetroService)
		{
			$str .= sprintf("\r\n<br/>Pilot To Metro Service:%s", $this->pilotToMetroService);
		}

		if ($this->militaryAircraftCommandPost)
		{
			$str .= sprintf("\r\n<br/>Military Aircraft Command Post:%s", $this->militaryAircraftCommandPost);
		}

		if ($this->militaryOp)
		{
			$str .= sprintf("\r\n<br/>Military Op:%s", $this->militaryOp);
		}

		if ($this->priApproachControl)
		{
			$str .= sprintf("\r\n<br/>Pri-Approach Control:%s", $this->priApproachControl);
		}

		if ($this->secApproachControl)
		{
			$str .= sprintf("\r\n<br/>Sec-Approach Control:%s", $this->secApproachControl);
		}

		if ($this->priDepartureControl)
		{
			$str .= sprintf("\r\n<br/>Pri-Departure Control:%s", $this->priDepartureControl);
		}

		if ($this->secDepartureControl)
		{
			$str .= sprintf("\r\n<br/>Sec-Departure Control:%s", $this->secDepartureControl);
		}

		return $str;
	}
}
?>