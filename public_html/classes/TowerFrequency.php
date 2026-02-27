<?php
class TowerFrequencyData
{
	public $id;
	public $facilityId;
	public $freq;
	public $type;
	public $siteLocation;

	public function FormatEntry()
	{
		$str = sprintf("\r\n<br/>%s %s", $this->type, $this->freq);

		return $str;
	}
}

class TowerFrequency
{
	public $sess;
	public $frequency = array();

	public function __construct($sess, $ident)
	{
		$this->sess = $sess;
		
		// See if these are satellite frequencies first
		$sql = sprintf("SELECT * FROM twrSatellite USE INDEX(twrSatelliteFacilityId) WHERE satelliteFacilityId='%s'", $ident);
		
		if ($this->sess->showFrequency == "V")
		{
			$sql .= " AND freq>'108.000' AND freq<'137.000'";
		}
		
		$sql .= " ORDER BY type,freq ASC";

		$twrDbase = new Database();
		
		$twrDbase->ExecSql($sql);

		if ($twrDbase->GetRowCount() > 0)
		{
			while ($row = $twrDbase->FetchRow())
			{
				$this->GetRow($row);
			}
			
			// grab the center frequencies
			$sql = sprintf("SELECT * FROM twrFrequency USE INDEX(twrFrequencyFacilityId) WHERE facilityId='%s'", $ident);

			if ($this->sess->showFrequency == "V")
			{
				$sql .= " AND freq>'108.000' AND freq<'137.000'";
			}
			
			$sql .= "  ORDER BY type,freq,siteLocation ASC";

			$twrDbase->ExecSql($sql);

			if ($twrDbase->GetRowCount() > 0)
			{
				while ($row = $twrDbase->FetchRow())
				{
					$this->GetRow($row);
				}
			}
		}
		else // this is an ATCT so grab all of its frequencies
		{
			$sql = sprintf("SELECT * FROM twrFrequency USE INDEX(twrFrequencyFacilityId) WHERE facilityId='%s'", $ident);

			if ($this->sess->showFrequency == "V")
			{
				$sql .= " AND freq>'108.000' AND freq<'137.000'";
			}
			
			$sql .= " ORDER BY type,freq ASC";

			$twrDbase->ExecSql($sql);

			if ($twrDbase->GetRowCount() > 0)
			{
				while ($row = $twrDbase->FetchRow())
				{
					$this->GetRow($row);
				}
			}
		}

		$twrDbase->Disconnect();
	}

	public function GetRow($row)
	{
		$towerFrequencyData = new TowerFrequencyData();

		$towerFrequencyData->id = $row["id"];
		$towerFrequencyData->facilityId = $row["facilityId"];
		$towerFrequencyData->freq = $row["freq"];
		$towerFrequencyData->type = htmlspecialchars($row["type"], ENT_QUOTES);

		if (isset($row["siteLocation"]))
		{
			$towerFrequencyData->siteLocation = $row["siteLocation"];
		}

		array_push($this->frequency, $towerFrequencyData);
	}

	public function GetSingle($i)
	{
		if ($this->frequency == null)
		{
			return;
		}

		return $this->frequency[$i];
	}

	public function ListEntries($header, $apt)
	{
		if ($this->frequency == null)
		{
			return;
		}

		$str = null;

		if ($header)
		{
			$str .= sprintf("<b>FREQUENCIES</b>\r\n");
		}
		
		if ($apt)
		{
			$str .= $apt->ListComms(false);
		}

		foreach ($this->frequency as $frq)
		{
			$str .= $frq->FormatEntry();
		}

		return $str;
	}
}
?>