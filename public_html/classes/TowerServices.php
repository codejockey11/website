<?php
class TowerServicesData
{
	public $id;
	public $facilityId;
	public $masterAirportServices;

	public function FormatEntry()
	{
		$str = null;

		$pos = strpos($this->masterAirportServices, "CPDLC");
		
		if ($pos === 0)
		{
			$s = explode("(", $this->masterAirportServices);
			
			$p = new Parameter("towerRadarService" . $s[0]);
			
			$str .= sprintf("\r\n<br/>%s", $p->value1);
			
			$str .= sprintf("\r\n<br/>%s", str_replace("(", "", str_replace(")", "", $this->masterAirportServices)));
		}
		else
		{
			$p = new Parameter("towerRadarService" . $this->masterAirportServices);
			
			if ($p->value1)
			{
				$str .= sprintf("\r\n<br/>%s:%s", $this->masterAirportServices, $p->value1);
			}
			else
			{
				$str .= sprintf("\r\n<br/>%s", $this->masterAirportServices);
			}
		}

		return $str;
	}
}

class TowerServices
{
	public $services = array();

	public function __construct($ident)
	{
		$sql = sprintf("SELECT * FROM twrServices USE INDEX(twrServicesFacilityId) WHERE facilityId='%s'", $ident);

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
			$this->services = null;
		}

		$twrDbase->Disconnect();
	}

	public function GetRow($row)
	{
		$towerServicesData = new TowerServicesData();

		$towerServicesData->id = $row["id"];
		$towerServicesData->facilityId = $row["facilityId"];
		$towerServicesData->masterAirportServices = $row["masterAirportServices"];

		array_push($this->services, $towerServicesData);
	}

	public function ListEntries($header)
	{
		if ($this->services == null)
		{
			return;
		}

		$str = null;

		if ($header)
		{
			$str .= sprintf("<b>SERVICES</b>\r\n");
		}

		foreach ($this->services as $srv)
		{
			$str .= $srv->FormatEntry();
		}

		$str .= sprintf("\r\n<br/>");

		return $str;
	}
}
?>