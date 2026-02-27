<?php
class RampsData
{
	public $id;
	public $Name;
	public $X;
	public $Y;
	public $OBJECTID;
	public $FacType;
	public $Access;
	public $PrimAgency;
	public $PartAgency;
	public $Status;
	public $Hours;
	public $Fees;
	public $FeeAmt;
	public $FeeCollect;
	public $RampSurf;
	public $RampCond;
	public $SingleLane;
	public $DoubleLane;
	public $TotalLane;
	public $DockType;
	public $ParkSurf;
	public $ParkCond;
	public $Trailer;
	public $HandiTrail;
	public $Vehicle;
	public $Handicap;
	public $Restroom;
	public $HandiRestr;
	public $HandiAcces;
	public $Picnic;
	public $Lighting;
	public $Grill;
	public $Street;
	public $City;
	public $County;
	public $Zip;
	public $Latitude;
	public $Longitude;
	public $WaterType;
	public $WaterName;
	public $created_user;
	public $created_date;
	public $last_edited_user;
	public $last_edited_date;
	public $GlobalID;

	public $latLon;

	public $sess;

	public function __construct($sess)
	{
		$this->sess = $sess;
	}

	public function FormatBaseInfo()
	{
		$str  = sprintf("<b>%s</b>\r\n", $this->Name);

		return $str;
	}

	public function FormatXML()
	{
		$str  = sprintf("<key>%s</key>", htmlspecialchars($this->id));
		$str .= sprintf("<Name>%s</Name>", htmlspecialchars($this->Name));
		$str .= sprintf("<X>%s</X>", $this->X);
		$str .= sprintf("<Y>%s</Y>", $this->Y);
		$str .= sprintf("<OBJECTID>%s</OBJECTID>", htmlspecialchars($this->OBJECTID));
		$str .= sprintf("<FacType>%s</FacType>", htmlspecialchars($this->FacType));
		$str .= sprintf("<Access>%s</Access>", htmlspecialchars($this->Access));
		$str .= sprintf("<PrimAgency>%s</PrimAgency>", htmlspecialchars($this->PrimAgency));
		$str .= sprintf("<PartAgency>%s</PartAgency>", htmlspecialchars($this->PartAgency));
		$str .= sprintf("<Status>%s</Status>", htmlspecialchars($this->Status));
		$str .= sprintf("<Hours>%s</Hours>", htmlspecialchars($this->Hours));
		$str .= sprintf("<Fees>%s</Fees>", htmlspecialchars($this->Fees));
		$str .= sprintf("<FeeAmt>%s</FeeAmt>", htmlspecialchars($this->FeeAmt));
		$str .= sprintf("<FeeCollect>%s</FeeCollect>", htmlspecialchars($this->FeeCollect));
		$str .= sprintf("<RampSurf>%s</RampSurf>", htmlspecialchars($this->RampSurf));
		$str .= sprintf("<RampCond>%s</RampCond>", htmlspecialchars($this->RampCond));
		$str .= sprintf("<SingleLane>%s</SingleLane>", htmlspecialchars($this->SingleLane));
		$str .= sprintf("<DoubleLane>%s</DoubleLane>", htmlspecialchars($this->DoubleLane));
		$str .= sprintf("<TotalLane>%s</TotalLane>", htmlspecialchars($this->TotalLane));
		$str .= sprintf("<DockType>%s</DockType>", htmlspecialchars($this->DockType));
		$str .= sprintf("<ParkSurf>%s</ParkSurf>", htmlspecialchars($this->ParkSurf));
		$str .= sprintf("<ParkCond>%s</ParkCond>", htmlspecialchars($this->ParkCond));
		$str .= sprintf("<Trailer>%s</Trailer>", htmlspecialchars($this->Trailer));
		$str .= sprintf("<HandiTrail>%s</HandiTrail>", htmlspecialchars($this->HandiTrail));
		$str .= sprintf("<Vehicle>%s</Vehicle>", htmlspecialchars($this->Vehicle));
		$str .= sprintf("<Handicap>%s</Handicap>", htmlspecialchars($this->Handicap));
		$str .= sprintf("<Restroom>%s</Restroom>", htmlspecialchars($this->Restroom));
		$str .= sprintf("<HandiRestr>%s</HandiRestr>", htmlspecialchars($this->HandiRestr));
		$str .= sprintf("<HandiAcces>%s</HandiAcces>", htmlspecialchars($this->HandiAcces));
		$str .= sprintf("<Picnic>%s</Picnic>", htmlspecialchars($this->Picnic));
		$str .= sprintf("<Lighting>%s</Lighting>", htmlspecialchars($this->Lighting));
		$str .= sprintf("<Grill>%s</Grill>", htmlspecialchars($this->Grill));
		$str .= sprintf("<Street>%s</Street>", htmlspecialchars($this->Street));
		$str .= sprintf("<City>%s</City>", htmlspecialchars($this->City));
		$str .= sprintf("<County>%s</County>", htmlspecialchars($this->County));
		$str .= sprintf("<Zip>%s</Zip>", htmlspecialchars($this->Zip));

		$str .= sprintf("<Latitude>%s</Latitude>", $this->Latitude);
		$str .= sprintf("<Longitude>%s</Longitude>", $this->Longitude);

		$str .= sprintf("<WaterType>%s</WaterType>", htmlspecialchars($this->WaterType));
		$str .= sprintf("<WaterName>%s</WaterName>", htmlspecialchars($this->WaterName));
		$str .= sprintf("<created_user>%s</created_user>", htmlspecialchars($this->created_user));
		$str .= sprintf("<created_date>%s</created_date>", htmlspecialchars($this->created_date));
		$str .= sprintf("<last_edited_user>%s</last_edited_user>", htmlspecialchars($this->last_edited_user));
		$str .= sprintf("<last_edited_date>%s</last_edited_date>", htmlspecialchars($this->last_edited_date));
		$str .= sprintf("<GlobalID>%s</GlobalID>", htmlspecialchars($this->GlobalID));

		$str .= "<icon>../images/ramp.png</icon>";

		return $str;
	}

	public function FormatMarkerGoogle()
	{
		$icon = "../images/ramp.png";

		$infoWindow  = "<div class=\"infoboxRamps\">";

		$infoWindow .= sprintf("%s", htmlspecialchars($this->Name));

		$infoWindow .= sprintf("<br/>Type:%s:%s", htmlspecialchars($this->FacType), htmlspecialchars($this->Access));

		$infoWindow .= sprintf("<br/>Hours:%s:%s", htmlspecialchars($this->Hours), htmlspecialchars($this->Status));

		$infoWindow .= sprintf("<br/>Fee:$%0.2f:%s (May be inaccurate)", htmlspecialchars($this->FeeAmt), htmlspecialchars($this->FeeCollect));

		$infoWindow .= sprintf("<br/>Condition:%s:%s", htmlspecialchars($this->RampCond), htmlspecialchars($this->RampSurf));

		$infoWindow .= sprintf(":Total Lanes:%s", htmlspecialchars($this->TotalLane));

		$infoWindow .= sprintf("<br/>Parking:%s:%s", htmlspecialchars($this->ParkCond), htmlspecialchars($this->ParkSurf));

		$infoWindow .= sprintf("<br/>WaterType:%s:%s", htmlspecialchars($this->WaterType), htmlspecialchars($this->WaterName));

		$infoWindow .= '</div>';

		$infoWindow = str_replace("'", "\'", $infoWindow);


		$str  = sprintf("    rampMarker = new Marker(map, '%s', %s, %s, black, '%s', '%s');\r\n", "", $this->Latitude, $this->Longitude, $icon, $infoWindow);

		return $str;
	}

	public function FormatMarkerBing()
	{
		$icon = "../images/ramp.png";

		$infoWindow  = "<div class=\"infoboxRamps\">";

		$infoWindow .= sprintf("%s", htmlspecialchars($this->Name));

		$infoWindow .= sprintf("<br/>Type:%s:%s", htmlspecialchars($this->FacType), htmlspecialchars($this->Access));

		$infoWindow .= sprintf("<br/>Hours:%s:%s", htmlspecialchars($this->Hours), htmlspecialchars($this->Status));

		$infoWindow .= sprintf("<br/>Fee:$%0.2f:%s (May be inaccurate)", htmlspecialchars($this->FeeAmt), htmlspecialchars($this->FeeCollect));

		$infoWindow .= sprintf("<br/>Condition:%s:%s", htmlspecialchars($this->RampCond), htmlspecialchars($this->RampSurf));

		$infoWindow .= sprintf(":Total Lanes:%s", htmlspecialchars($this->TotalLane));

		$infoWindow .= sprintf("<br/>Parking:%s:%s", htmlspecialchars($this->ParkCond), htmlspecialchars($this->ParkSurf));

		$infoWindow .= sprintf("<br/>WaterType:%s:%s", htmlspecialchars($this->WaterType), htmlspecialchars($this->WaterName));

		$infoWindow .= '</div>';

		$infoWindow = str_replace("'", "\'", $infoWindow);


		$str  = sprintf("    rampMarker = new BingMarker(map, %s, %s, %s, black, '%s', '%s');\r\n", 0x00, $this->Latitude, $this->Longitude, $icon, $infoWindow);

		return $str;
	}
}

class Ramps
{
	public $sess;
	public $ramps = array();

	public function __construct($sess, $sql)
	{
		$this->sess = $sess;

		$rampsDbase = new Database();

		$rampsDbase->ExecSql($sql);

		if ($rampsDbase->GetRowCount() > 0)
		{
			while($row = $rampsDbase->FetchRow())
			{
				$this->GetRow($row);
			}
		}
		else
		{
			$this->ramps = null;
		}

		$rampsDbase->Disconnect();
	}

	public function GetRow($row)
	{
		$rampsData = new RampsData($this->sess);

		$rampsData->id = $row["id"];
		$rampsData->Name = $row["Name"];
		$rampsData->X = $row["X"];
		$rampsData->Y = $row["Y"];
		$rampsData->OBJECTID = $row["OBJECTID"];
		$rampsData->FacType = $row["FacType"];
		$rampsData->Access = $row["Access"];
		$rampsData->PrimAgency = $row["PrimAgency"];
		$rampsData->PartAgency = $row["PartAgency"];
		$rampsData->Status = $row["Status"];
		$rampsData->Hours = $row["Hours"];
		$rampsData->Fees = $row["Fees"];
		$rampsData->FeeAmt = $row["FeeAmt"];
		$rampsData->FeeCollect = $row["FeeCollect"];
		$rampsData->RampSurf = $row["RampSurf"];
		$rampsData->RampCond = $row["RampCond"];
		$rampsData->SingleLane = $row["SingleLane"];
		$rampsData->DoubleLane = $row["DoubleLane"];
		$rampsData->TotalLane = $row["TotalLane"];
		$rampsData->DockType = $row["DockType"];
		$rampsData->ParkSurf = $row["ParkSurf"];
		$rampsData->ParkCond = $row["ParkCond"];
		$rampsData->Trailer = $row["Trailer"];
		$rampsData->HandiTrail = $row["HandiTrail"];
		$rampsData->Vehicle = $row["Vehicle"];
		$rampsData->Handicap = $row["Handicap"];
		$rampsData->Restroom = $row["Restroom"];
		$rampsData->HandiRestr = $row["HandiRestr"];
		$rampsData->HandiAcces = $row["HandiAcces"];
		$rampsData->Picnic = $row["Picnic"];
		$rampsData->Lighting = $row["Lighting"];
		$rampsData->Grill = $row["Grill"];
		$rampsData->Street = $row["Street"];
		$rampsData->City = $row["City"];
		$rampsData->County = $row["County"];
		$rampsData->Zip = $row["Zip"];
		$rampsData->Latitude = $row["Latitude"];
		$rampsData->Longitude = $row["Longitude"];
		$rampsData->WaterType = $row["WaterType"];
		$rampsData->WaterName = $row["WaterName"];
		$rampsData->created_user = $row["created_user"];
		$rampsData->created_date = $row["created_date"];
		$rampsData->last_edited_user = $row["last_edited_user"];
		$rampsData->last_edited_date = $row["last_edited_date"];
		$rampsData->GlobalID = $row["GlobalID"];

		$rampsData->latLon = new LatLon($rampsData->Latitude, $rampsData->Longitude);

		array_push($this->ramps, $rampsData);
	}

	public function GetSingle($i)
	{
		if ($this->ramps == null)
		{
			return;
		}

		return $this->ramps[$i];
	}

	public function MapMarkerGoogle()
	{
		if ($this->ramps == null)
		{
			return;
		}

		$str = null;

		foreach ($this->ramps as $ramps)
		{
			$str .= $ramps->FormatMarkerGoogle();
		}

		return $str;
	}

	public function MapMarkerBing()
	{
		if ($this->ramps == null)
		{
			return;
		}

		$str = null;

		foreach ($this->ramps as $ramps)
		{
			$str .= $ramps->FormatMarkerBing();
		}

		return $str;
	}

	public function FormatXML()
	{
		if ($this->ramps == null)
		{
			return;
		}

		$str = null;

		foreach ($this->ramps as $ramps)
		{
			$str .= "<ramp>";

			$str .= $ramps->FormatXML();

			$str .= "</ramp>";
		}

		return $str;
	}
}
?>