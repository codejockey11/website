<?php
class ObstacleData
{
	public $id;
	public $ors;
	public $country;
	public $state;
	public $city;
	public $latitude;
	public $longitude;
	public $type;
	public $agl;
	public $msl;

	public $latLon;

	public $sess;

	public function __construct($sess)
	{
		$this->sess = $sess;
	}

	function FormatMarkerGoogle()
	{
		$icon = "../images/obstacle.png";

		$infoWindow  = "<div class=\"infoboxText\">";

		$infoWindow .= sprintf("%s", $this->type);
			
		$infoWindow .= sprintf(" agl:%s", $this->agl);
			
		$infoWindow .= sprintf(" msl:%s", $this->msl);
			
		$infoWindow .= "</div>";

		$str  = sprintf("    obstacleMarker = new Marker(map, '%s', %s, %s, black, '%s', '%s');\r\n", $this->type, $this->latLon->decimalLat, $this->latLon->decimalLon, $icon, $infoWindow);

		return $str;
	}

	function FormatMarkerBing()
	{
		$icon = "../images/obstacle.png";

		$infoWindow  = "<div class=\"infoboxText\">";

		$infoWindow .= sprintf("%s", $this->type);
			
		$infoWindow .= sprintf(" agl:%s", $this->agl);
			
		$infoWindow .= sprintf(" msl:%s", $this->msl);
			
		$infoWindow .= "</div>";

		$str  = sprintf("    obstacleMarker = new BingMarker(map, '%s', %s, %s, black, '%s', '%s');\r\n", $this->type, $this->latLon->decimalLat, $this->latLon->decimalLon, $icon, $infoWindow);

		return $str;
	}
}

class Obstacle
{
	public $sess;
	public $obstacle = array();

	public function __construct($sess, $sql)
	{
		$this->sess = $sess;
		
		$obsDbase = new Database();
		
		$obsDbase->ExecSql($sql);

		if ($obsDbase->GetRowCount() > 0)
		{
			while($row = $obsDbase->FetchRow())
			{
				$this->GetRow($row);
			}
		}
		else
		{
			$this->obstacle = null;
		}

		$obsDbase->Disconnect();
	}

	public function GetRow($row)
	{
		$obstacleData = new ObstacleData($this->sess);

		$obstacleData->id = $row["id"];
		$obstacleData->ors = $row["ors"];
		$obstacleData->country = $row["country"];
		$obstacleData->state = $row["state"];
		$obstacleData->city = $row["city"];
		$obstacleData->latitude = $row["latitude"];
		$obstacleData->longitude = $row["longitude"];
		$obstacleData->type = $row["type"];
		$obstacleData->agl = $row["agl"];
		$obstacleData->msl = $row["msl"];

		$obstacleData->latLon = new LatLon($obstacleData->latitude, $obstacleData->longitude);

		array_push($this->obstacle, $obstacleData);
	}

	public function MapMarkerGoogle()
	{
		if ($this->obstacle == null)
		{
			return;
		}

		$str = "";

		foreach ($this->obstacle as $obs)
		{
			$str .= $obs->FormatMarkerGoogle();
		}

		return $str;
	}

	public function MapMarkerBing()
	{
		if ($this->obstacle == null)
		{
			return;
		}

		$str = "";

		foreach ($this->obstacle as $obs)
		{
			$str .= $obs->FormatMarkerBing();
		}

		return $str;
	}
}
?>