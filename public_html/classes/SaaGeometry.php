<?php
class SaaGeometryData
{
	public $id;
	public $designator;
	public $upperLimituom;
	public $upperLimit;
	public $upperLimitReference;
	public $lowerLimituom;
	public $lowerLimit;
	public $lowerLimitReference;
	public $type;
	public $sequence;
	public $count;
	public $longitude;
	public $latitude;

	public $sess;

	public function __construct($sess)
	{
		$this->sess = $sess;
	}
	
}

class SaaGeometry
{
	public $sess;
	public $geometry = array();

	public function __construct($sess, $name)
	{
		$this->sess = $sess;
		
		$sql = null;

		if ($name)
		{
			$sql = sprintf("SELECT * FROM saaGeometry WHERE designator='%s'", $name);
		}

		$saaDbase = new Database();
		
		$saaDbase->ExecSql($sql);

		if ($saaDbase->GetRowCount() > 0)
		{
			while($row = $saaDbase->FetchRow())
			{
				$this->GetRow($row);
			}
		}
		else
		{
			$this->geometry = null;
		}

		$saaDbase->Disconnect();
	}

	public function GetRow($row)
	{
		$saaGeometryData = new SaaGeometryData($this->sess);

		$saaGeometryData->id = $row["id"];
		$saaGeometryData->designator = $row["designator"];
		$saaGeometryData->upperLimituom = $row["upperLimituom"];
		$saaGeometryData->upperLimit = $row["upperLimit"];
		$saaGeometryData->upperLimitReference = $row["upperLimitReference"];
		$saaGeometryData->lowerLimituom = $row["lowerLimituom"];
		$saaGeometryData->lowerLimit = $row["lowerLimit"];
		$saaGeometryData->lowerLimitReference = $row["lowerLimitReference"];
		$saaGeometryData->type = $row["type"];
		$saaGeometryData->sequence = $row["sequence"];
		$saaGeometryData->count = $row["count"];
		$saaGeometryData->longitude = $row["longitude"];
		$saaGeometryData->latitude = $row["latitude"];

		array_push($this->geometry, $saaGeometryData);
	}
}
?>