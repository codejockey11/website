<?php
class TowerData
{
	public $id;
	public $facilityId;
	public $state;
	public $city;
	public $name;
	public $latitude;
	public $longitude;
	public $fssId;
	public $fssName;
	public $type;
	public $hoursOfOp;
	public $hoursOfOpOther;
	public $airportId;
	public $airportName;
	public $radioCall;

	public $latLon;

	public $towerFrequency;
	public $towerAtis;
	public $towerAirspace;
	public $towerHoursOfOp;
	public $towerRadars;
	public $towerRemarks;
	public $towerServices;

	public $sess;

	public function __construct($sess, $ident)
	{
		$this->sess = $sess;

		$this->towerFrequency = new TowerFrequency($sess, $ident);

		$this->towerAtis = new TowerAtis($ident);
		$this->towerAirspace = new TowerAirspace($ident);
		$this->towerHoursOfOp = new TowerHoursOfOp($ident);
		$this->towerRadars = new TowerRadars($ident);
		$this->towerRemarks = new TowerRemarks($ident);
		$this->towerServices = new TowerServices($ident);
	}

	public function FormatBaseInfo($header)
	{
		$str = null;

		if ($header)
		{
			$str .= sprintf("<b>TOWER</b><br/>\r\n");
		}

		$str .= sprintf("<a href=\"../tower/index.php?id=%s&ident=%s\">%s:%s</a>\r\n", $this->sess->sessionId, $this->facilityId, $this->facilityId, $this->name);
		
		$str .= sprintf("\r\n<br/>City,State:%s,%s", $this->city, $this->state);
		
		$str .= sprintf("\r\n<br/>GPS:%s %s", $this->latitude, $this->longitude);
		
		$str .= sprintf("\r\n<br/>FSS:%s %s", $this->fssId, $this->fssName);
		
		$str .= sprintf("\r\n<br/>Type:%s", $this->type);

		if ($this->hoursOfOp)
		{
			$str .= sprintf("\r\n<br/>Hours Of Op:%s", $this->hoursOfOp);
		}

		if ($this->hoursOfOpOther)
		{
			$str .= sprintf("\r\n<br/>Hours Of Op Other:%s", $this->hoursOfOpOther);
		}

		if ($this->airportId)
		{
			$str .= sprintf("\r\n<br/>Airport ID:%s", $this->airportId);
		}

		if ($this->airportName)
		{
			$str .= sprintf("\r\n<br/>Airport Name:%s", $this->airportName);
		}

		if ($this->radioCall)
		{
			$str .= sprintf("\r\n<br/>Radio Call:%s", $this->radioCall);
		}

		if ($this->towerAirspace)
		{
			$str .= $this->towerAirspace->ListEntries();
		}

		if ($this->towerHoursOfOp)
		{
			$str .= $this->towerHoursOfOp->ListEntries(true);
		}

		return $str;
	}

	public function FormatEntry()
	{
		$str  = sprintf("<tr><td class=\"list\"><a href=\"../tower/index.php?id=%s&ident=%s\">%s</a></td>\r\n", $this->sess->sessionId, $this->facilityId, $this->facilityId);
		
		$str .= sprintf("<td class=\"list\">%s</td>\r\n", $this->name);
		
		$str .= sprintf("<td class=\"list\">%s</td></tr>\r\n", $this->state);

		return $str;
	}

	public function FormatPlanInfo($apt)
	{
		$str = sprintf("Name:%s", $this->name);

		if ($this->radioCall)
		{
			$str .= sprintf("\r\n<br/>Radio Call:%s", $this->radioCall);
		}

		if ($this->airportId)
		{
			$str .= sprintf("\r\n<br/>Airport ID:%s", $this->airportId);
		}

		if ($this->airportName)
		{
			$str .= sprintf("\r\n<br/>Airport Name:%s", $this->airportName);
		}

		if ($this->towerHoursOfOp)
		{
			if ($this->towerHoursOfOp->hoursOfOp)
			{
				$str .= sprintf("\r\n<br/>Hours:%s", $this->towerHoursOfOp->hoursOfOp);
			}
		}

		$str .= $this->towerFrequency->ListEntries(false, $apt);
		
		$str .= $this->towerAirspace->ListEntries(false);
		
		$str .= $this->towerRemarks->FormatPlanInfo();

		return $str;
	}
}

class Tower
{
	public $sess;
	public $tower = array();

	public function __construct($sess, $ident)
	{
		$this->sess = $sess;

		if (strlen($ident) < 4)
		{
			$sql = sprintf("SELECT * FROM twrTower USE INDEX(twrTowerFacilityId) WHERE facilityId='%s'", $ident);
		}
		else
		{
			$sql = sprintf("SELECT * FROM twrTower USE INDEX(twrTowerRadioCall) WHERE radioCall='%s'", $ident);
		}

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
			$this->tower = null;
		}

		$twrDbase->Disconnect();
	}

	public function GetRow($row)
	{
		$towerData = new TowerData($this->sess, $row["facilityId"]);

		$towerData->id = $row["id"];
		$towerData->facilityId = $row["facilityId"];
		$towerData->state = $row["state"];
		$towerData->city = $row["city"];
		$towerData->name = $row["name"];
		$towerData->latitude = $row["latitude"];
		$towerData->longitude = $row["longitude"];
		$towerData->fssId = $row["fssId"];
		$towerData->fssName = $row["fssName"];
		$towerData->type = $row["type"];
		$towerData->hoursOfOp = $row["hoursOfOp"];
		$towerData->hoursOfOpOther = $row["hoursOfOpOther"];
		$towerData->airportId = $row["airportId"];
		$towerData->airportName = $row["airportName"];
		$towerData->radioCall = $row["radioCall"];

		$towerData->latLon = new LatLon($towerData->latitude, $towerData->longitude);

		array_push($this->tower, $towerData);
	}

	public function GetSingle($i)
	{
		if ($this->tower == null)
		{
			return;
		}

		return $this->tower[$i];
	}

	public function ListEntries()
	{
		if ($this->tower == null)
		{
			return;
		}

		if (count($this->tower) < 2)
		{
			return;
		}

		$str  = sprintf("<table>\r\n");

		$str .= sprintf("<tr><th>Facility</th>\r\n");
		
		$str .= sprintf("<th>Name</th>\r\n");
		
		$str .= sprintf("<th>State</th></tr>\r\n");

		foreach ($this->tower as $twr)
		{
			$str .= $twr->FormatEntry();
		}

		$str .= sprintf("</table>\r\n");

		return $str;
	}

	public function FormatPlanInfo($apt)
	{
		if ($this->tower == null)
		{
			$str = null;

			if ($apt)
			{
				$str .= sprintf("Radio Call:%s", $apt->name);
				
				$str .= $apt->ListComms(false);
			}

			return $str;
		}

		$str = null;

		foreach ($this->tower as $twr)
		{
			$str .= $twr->FormatPlanInfo($apt);
		}

		return $str;
	}
}
?>