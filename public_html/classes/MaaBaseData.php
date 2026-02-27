<?php
class MaaBaseDataData
{
	public $id;
	public $maaId;
	public $type;
	public $navaidIdentifier;
	public $navaidFacilityTypeCode;
	public $navaidFacilityTypeDescribed;
	public $azimuthFromNavaid;
	public $distance;
	public $navaidName;
	public $stateAbbreviation;
	public $stateName;
	public $associatedCityName;
	public $latitude;
	public $longitude;
	public $associatedAirportId;
	public $associatedAirportName;
	public $associatedAirportSiteNumber;
	public $nearestAirportId;
	public $nearestAirportDistance;
	public $nearestAirportDirection;
	public $areaName;
	public $maximumAltitude;
	public $minimumAltitude;
	public $radius;
	public $showOnVfrChart;
	public $description;
	public $maaUse;

	public $latLon;

	public $polycoord;
	public $timesofuse;
	public $usergroup;
	public $contact;
	public $notams;
	public $remarks;

	public $sess;

	public function __construct($sess)
	{
		$this->sess = $sess;
	}

	public function FormatMarkerGoogle()
	{
		$infoWindow  = "<div class=\"infoboxWeather\">";

		$infoWindow .= sprintf("%s %s", $this->maaId, $this->type);

		if ($this->navaidIdentifier != null)
		{
			$infoWindow .= sprintf("<br/>%s %s %s", $this->navaidIdentifier, $this->navaidFacilityTypeCode, $this->navaidFacilityTypeDescribed);
		}

		if ($this->azimuthFromNavaid != null)
		{
			$infoWindow .= sprintf("<br/>%s %s %s", $this->azimuthFromNavaid, $this->distance, $this->navaidName);
		}

		$infoWindow .= sprintf("<br/>%s %s", $this->stateAbbreviation, $this->stateName);

		if ($this->associatedCityName != null)
		{
			$infoWindow .= sprintf("<br/>%s", $this->associatedCityName);
		}

		$infoWindow .= sprintf("<br/>%s %s", $this->latitude, $this->longitude);

		if ($this->associatedAirportId != null)
		{
			$infoWindow .= sprintf("<br/>%s %s %s", $this->associatedAirportId, str_replace("'", "", $this->associatedAirportName), $this->associatedAirportSiteNumber);
		}

		if ($this->nearestAirportId != null)
		{
			$infoWindow .= sprintf("<br/>%s %s %s", $this->nearestAirportId, $this->nearestAirportDistance, $this->nearestAirportDirection);
		}

		if ($this->areaName != null)
		{
			$infoWindow .= sprintf("<br/>%s", $this->areaName);
		}

		if ($this->maximumAltitude != null)
		{
			$infoWindow .= sprintf("<br/>%s %s", $this->maximumAltitude, $this->minimumAltitude);
		}

		$infoWindow .= sprintf("<br/>VFR CHART %s", $this->showOnVfrChart);

		$infoWindow .= sprintf("<br/>%s", str_replace("'", "\'", $this->description));


		if ($this->maaUse != null)
		{
			$infoWindow .= sprintf("<br/>%s", $this->maaUse);
		}

		$infoWindow .= "</div>";

		$infoWindow = (str_replace("\r\n", "", $infoWindow));

		$str  = sprintf("    maaCircle = new Circle(map, '%s', %s, %s, '%s', '%s');\r\n", $this->radius, $this->latLon->decimalLat, $this->latLon->decimalLon, 'red', $infoWindow);

		return $str;
	}

	public function FormatMarkerBing()
	{
		$infoWindow  = "<div class=\"infoboxWeather\">";

		$infoWindow .= sprintf("%s %s", $this->maaId, $this->type);

		if ($this->navaidIdentifier != null)
		{
			$infoWindow .= sprintf("<br/>%s %s %s", $this->navaidIdentifier, $this->navaidFacilityTypeCode, $this->navaidFacilityTypeDescribed);
		}

		if ($this->azimuthFromNavaid != null)
		{
			$infoWindow .= sprintf("<br/>%s %s %s", $this->azimuthFromNavaid, $this->distance, $this->navaidName);
		}

		$infoWindow .= sprintf("<br/>%s %s", $this->stateAbbreviation, $this->stateName);

		if ($this->associatedCityName != null)
		{
			$infoWindow .= sprintf("<br/>%s", $this->associatedCityName);
		}

		$infoWindow .= sprintf("<br/>%s %s", $this->latitude, $this->longitude);

		if ($this->associatedAirportId != null)
		{
			$infoWindow .= sprintf("<br/>%s %s %s", $this->associatedAirportId, str_replace("'", "", $this->associatedAirportName), $this->associatedAirportSiteNumber);
		}

		if ($this->nearestAirportId != null)
		{
			$infoWindow .= sprintf("<br/>%s %s %s", $this->nearestAirportId, $this->nearestAirportDistance, $this->nearestAirportDirection);
		}

		if ($this->areaName != null)
		{
			$infoWindow .= sprintf("<br/>%s", $this->areaName);
		}

		if ($this->maximumAltitude != null)
		{
			$infoWindow .= sprintf("<br/>%s %s", $this->maximumAltitude, $this->minimumAltitude);
		}

		$infoWindow .= sprintf("<br/>VFR CHART %s", $this->showOnVfrChart);

		$infoWindow .= sprintf("<br/>%s", str_replace("'", "\'", $this->description));


		$str  = sprintf("	Microsoft.Maps.loadModule(['Microsoft.Maps.SpatialMath', 'Microsoft.Maps.Contour'], function () {\r\n");

		$str  .= sprintf("		var location = new Microsoft.Maps.Location(%s, %s);\r\n\r\n", $this->latLon->decimalLat, $this->latLon->decimalLon);

		if ($this->radius > "")
		{
			$str  .= sprintf("    	var circle = createCircle(location, %s, 'rgb(255,255,0)');\r\n", $this->radius);
		}
		else
		{
			$str  .= sprintf("    	var circle = createCircle(location, 3, 'rgb(255,255,0)');\r\n");
		}

		$str .= sprintf("    	var layer = new Microsoft.Maps.ContourLayer([circle], {\r\n");
		$str .= sprintf("    			colorCallback: function (val) {\r\n");
		$str .= sprintf("    			return val;\r\n");
		$str .= sprintf("    		},\r\n");
		$str .= sprintf("    		polygonOptions: {\r\n");
		$str .= sprintf("    			strokeColor: green,\r\n");
		$str .= sprintf("    			strokeThickness: 3\r\n");
		$str .= sprintf("    		}\r\n");
		$str .= sprintf("    	});\r\n");
		$str .= sprintf("\r\n");

		$str .= sprintf("    	var infoWindow = new Microsoft.Maps.Infobox(location, {\r\n");
		$str .= sprintf("    		visible: false,\r\n");
		$str .= sprintf("    		showPointer: false,\r\n");
		$str .= sprintf("    		showCloseButton: false,\r\n");
		$str .= sprintf("    		htmlContent: '%s'\r\n", $infoWindow);
		$str .= sprintf("    	});\r\n\r\n");

		$str .= sprintf("    	infoWindow.setMap(map);\r\n");

		$str .= sprintf("    	Microsoft.Maps.Events.addHandler(layer, 'click', (function (a)\r\n");
		$str .= sprintf("    	{\r\n");
		$str .= sprintf("    		return function ()\r\n");
		$str .= sprintf("    		{\r\n");
		$str .= sprintf("    			if (a.getOptions().visible == false)\r\n");
		$str .= sprintf("    			{\r\n");
		$str .= sprintf("    				a.setOptions({\r\n");
		$str .= sprintf("    					visible: true\r\n");
		$str .= sprintf("    				});\r\n");
		$str .= sprintf("\r\n");
		$str .= sprintf("    			}\r\n");
		$str .= sprintf("    			else\r\n");
		$str .= sprintf("    			{\r\n");
		$str .= sprintf("    				a.setOptions({\r\n");
		$str .= sprintf("    					visible: false\r\n");
		$str .= sprintf("    				});\r\n");
		$str .= sprintf("\r\n");
		$str .= sprintf("    			}\r\n");
		$str .= sprintf("    		};\r\n");
		$str .= sprintf("    	})(infoWindow));\r\n\r\n");

		$str .= sprintf("    	map.layers.insert(layer);\r\n");
		$str .= sprintf("\r\n");
		$str .= sprintf("    });\r\n\r\n");

		return $str;
	}
}

class MaaBaseData
{
	public $sess;
	public $base = array();

	public function __construct($sess, $sql)
	{
		$this->sess = $sess;

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
			$this->base = null;
		}

		$maaDbase->Disconnect();
	}

	public function GetRow($row)
	{
		$maaBaseDataData = new MaaBaseDataData($this->sess);

		$maaBaseDataData->id = $row["id"];
		$maaBaseDataData->maaId = $row["maaId"];
		$maaBaseDataData->type = $row["type"];
		$maaBaseDataData->navaidIdentifier = $row["navaidIdentifier"];
		$maaBaseDataData->navaidFacilityTypeCode = $row["navaidFacilityTypeCode"];
		$maaBaseDataData->navaidFacilityTypeDescribed = $row["navaidFacilityTypeDescribed"];
		$maaBaseDataData->azimuthFromNavaid = $row["azimuthFromNavaid"];
		$maaBaseDataData->distance = $row["distance"];
		$maaBaseDataData->navaidName = $row["navaidName"];
		$maaBaseDataData->stateAbbreviation = $row["stateAbbreviation"];
		$maaBaseDataData->stateName = $row["stateName"];
		$maaBaseDataData->associatedCityName = $row["associatedCityName"];
		$maaBaseDataData->latitude = $row["latitude"];
		$maaBaseDataData->longitude = $row["longitude"];
		$maaBaseDataData->associatedAirportId = $row["associatedAirportId"];
		$maaBaseDataData->associatedAirportName = $row["associatedAirportName"];
		$maaBaseDataData->associatedAirportSiteNumber = $row["associatedAirportSiteNumber"];
		$maaBaseDataData->nearestAirportId = $row["nearestAirportId"];
		$maaBaseDataData->nearestAirportDistance = $row["nearestAirportDistance"];
		$maaBaseDataData->nearestAirportDirection = $row["nearestAirportDirection"];
		$maaBaseDataData->areaName = $row["areaName"];
		$maaBaseDataData->maximumAltitude = $row["maximumAltitude"];
		$maaBaseDataData->minimumAltitude = $row["minimumAltitude"];
		$maaBaseDataData->radius = $row["radius"];
		$maaBaseDataData->showOnVfrChart = $row["showOnVfrChart"];
		$maaBaseDataData->description = $row["description"];
		$maaBaseDataData->maaUse = $row["maaUse"];

		$maaBaseDataData->latLon = new LatLon($maaBaseDataData->latitude, $maaBaseDataData->longitude);

		$maaBaseDataData->polycoord = new MaaPolyCoord($maaBaseDataData->maaId);
		$maaBaseDataData->timesofuse = new MaaTimesOfUse($maaBaseDataData->maaId);
		$maaBaseDataData->usergroup = new MaaUserGroup($maaBaseDataData->maaId);
		$maaBaseDataData->contact = new MaaContact($maaBaseDataData->maaId);
		$maaBaseDataData->notams = new MaaNotams($maaBaseDataData->maaId);
		$maaBaseDataData->remarks = new MaaRemarks($maaBaseDataData->maaId);

		array_push($this->base, $maaBaseDataData);
	}

	public function GetSingle($i)
	{
		if ($this->base == null)
		{
			return;
		}

		return $this->base[$i];
	}

	public function MapMarkerGoogle()
	{
		if ($this->base == null)
		{
			return;
		}

		$str = null;

		foreach ($this->base as $bse)
		{
			$str .= $bse->FormatMarkerGoogle();
		}

		return $str;
	}

	public function MapMarkerBing()
	{
		if ($this->base == null)
		{
			return;
		}

		$str = null;

		foreach ($this->base as $bse)
		{
			$str .= $bse->FormatMarkerBing();
		}

		return $str;
	}
}
?>