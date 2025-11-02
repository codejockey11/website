<?php
class NavaidData
{
	public $id;
	public $facilityId;
	public $morse;
	public $type;
	public $freq;
	public $tacan;
	public $magVar;
	public $magVarYear;
	public $radioCall;
	public $fssId;
	public $fssName;
	public $name;
	public $city;
	public $state;
	public $class;
	public $artccHighId;
	public $artccHighName;
	public $artccLowId;
	public $artccLowName;
	public $latitude;
	public $longitude;
	public $status;
	public $hiwas;
	public $elevation;

	public $region;

	public $rco;
	public $latLon;
	public $remarks;

	public $cs;

	public $sess;

	public function __construct($sess)
	{
		$this->sess = $sess;
	}

	public function FormatBaseInfo()
	{
		$str  = sprintf("<b>%s</b>\r\n", $this->facilityId);

		$str .= sprintf("\r\n<br/>Morse:%s", $this->morse);

		$str .= sprintf("\r\n<br/>Type:%s", $this->type);

		if ($this->freq)
		{
			$str .= sprintf("\r\n<br/>Freqency:%s", $this->freq);
		}

		if ($this->tacan)
		{
			$str .= sprintf("\r\n<br/>TACAN:%s", $this->tacan);
		}

		$str .= sprintf("\r\n<br/>MagVar:%s %s", $this->magVar, $this->magVarYear);

		$str .= sprintf("\r\n<br/>Radio Call:%s", $this->radioCall);

		$str .= sprintf("\r\n<br/>FSS:%s %s", $this->fssId, $this->fssName);

		$str .= sprintf("\r\n<br/>Name:%s", $this->name);

		$str .= sprintf("\r\n<br/>City,State:%s,%s", $this->city, $this->state);

		$str .= sprintf("\r\n<br/>Class:%s", $this->class);

		if ($this->artccHighId)
		{
			$str .= sprintf("\r\n<br/>ARTCC High:%s %s", $this->artccHighId, $this->artccHighName);
		}

		if ($this->artccLowId)
		{
			$str .= sprintf("\r\n<br/>ARTCC Low:%s %s", $this->artccLowId, $this->artccLowName);
		}

		$str .= sprintf("\r\n<br/>GPS:%s %s", $this->latitude, $this->longitude);

		$str .= sprintf("\r\n<br/>Status:%s", $this->status);

		if ($this->hiwas)
		{
			$str .= sprintf("\r\n<br/>HIWAS:%s", $this->hiwas);
		}

		$str .= sprintf("\r\n<br/>Elevation:%s", $this->elevation);

		if ($sup = $this->cs->GetSingle(0))
		{
			$str .= sprintf("\r\n<br/><br/><a href=\"../dTPPCS/index.php?id=%s&ident=%s&type=cs&pdf=%s\">Documents</a>\r\n", $this->sess->sessionId, $this->name, $sup->pdf);
		}
		else
		{
			$str .= sprintf("\r\n<br/>");
		}

		$str .= sprintf("\r\n<br/><a href=\"http://skyvector.com/?chart=301&zoom=4&ll=%s,%s\">Charts</a>\r\n", $this->latLon->decimalLat, $this->latLon->decimalLon);

		return $str;
	}

	public function FormatEntry()
	{
		$str  = sprintf("<tr><td class=\"list\"><a href=\"../navaid/index.php?id=%s&key=%s\">%s</a></td>\r\n", $this->sess->sessionId, $this->id, $this->facilityId);

		$str .= sprintf("<td class=\"list\">%s</td>\r\n", $this->name);

		$str .= sprintf("<td class=\"list\">%s</td>\r\n", $this->type);

		$str .= sprintf("<td class=\"list\">%s</td></tr>\r\n", $this->state);

		return $str;
	}

	public function WaypointInfo()
	{
		$str  = sprintf("%s", $this->facilityId);

		$str .= sprintf(" %s", $this->name);

		$str .= sprintf(" %s", $this->type);

		if (strcmp($this->hiwas, "Y") == 0)
		{
			$str .= sprintf(" HIWAS");
		}

		if (($this->sess->comms && $this->sess->rnav) || ($this->sess->comms) || (!$this->sess->comms && !$this->sess->rnav))
		{
			if ($this->freq)
			{
				if ($this->type == "NDB")
				{
					$str .= sprintf(" %s", $this->freq);
				}
				else
				{
					$str .= sprintf("\r\n<br/>%s", $this->freq);
				}
			}
			/* Pilot decision use tacan
			if ($this->tacan)
			{
				$str .= sprintf(" %s", $this->tacan);
			}
			*/
			$str .= sprintf(" %s", $this->morse);
		}

		if ($this->sess->comms)
		{
			$str .= $this->rco->WaypointInfo();
		}

		if ($this->sess->remarks)
		{
			$str .= "\r\n<br/>";

			$str .= $this->remarks->ListEntries();

			if ($this->status != "OPERATIONAL IFR")
			{
				$str .= sprintf("\r\n<br/><span class=\"error\">%s</span>\r\n", $this->status);
			}
			else
			{
				$str .= sprintf("\r\n<br/>%s", $this->status);
			}
		}

		return $str;
	}

	public function FormatFixNavaidEntry()
	{
		$str = sprintf("\r\n<br/>Facility:<a href=\"../navaid/index.php?id=%s&key=%s\">%s</a> %s", $this->sess->sessionId, $this->id, $this->facilityId, $this->name);

		$sup = $this->cs->GetSingle(0);

		if ($sup)
		{
			$str .= sprintf("\r\n<br/><a href=\"../dTPPCS/index.php?id=%s&ident=%s&type=cs&pdf=%s\">Documents</a>\r\n", $this->sess->sessionId, $this->name, $sup->pdf);
		}

		$str .= sprintf("\r\n<br/>Type:%s", $this->type);

		if ($this->hiwas)
		{
			$str .= sprintf("\r\n<br/>HIWAS:%s", $this->hiwas);
		}

		$str .= sprintf("\r\n<br/>Morse:%s", $this->morse);

		$str .= sprintf("\r\n<br/>Freqency:%s", $this->freq);

		if ($this->tacan)
		{
			$str .= sprintf("\r\n<br/>TACAN:%s", $this->tacan);
		}

		$str .= sprintf("\r\n<br/>MagVar:%s %s", $this->magVar, $this->magVarYear);

		$str .= sprintf("\r\n<br/>Radio Call:%s", $this->radioCall);

		if ($this->fssId)
		{
			$str .= sprintf("\r\n<br/>FSS Id:%s %s", $this->fssId, $this->fssName);
		}

		$str .= sprintf("\r\n<br/>Name:%s", $this->name);

		if ($this->city)
		{
			$str .= sprintf("\r\n<br/>City:%s", $this->city);
		}

		if ($this->state)
		{
			$str .= sprintf(", %s", $this->state);
		}

		$str .= sprintf("\r\n<br/>Class:%s", $this->class);

		if ($this->artccHighId)
		{
			$str .= sprintf("\r\n<br/>ARTCC High Id:%s %s", $this->artccHighId, $this->artccHighName);
		}

		if ($this->artccLowId)
		{
			$str .= sprintf("\r\n<br/>ARTCC Low Id:%s %s", $this->artccLowId, $this->artccLowName);
		}

		$str .= sprintf("\r\n<br/>GPS:%s %s", $this->latitude, $this->longitude);

		if ($this->status == 'OPERATIONAL IFR')
		{
			$str .= sprintf("\r\n<br/>Status:%s", $this->status);
		}
		else
		{
			$str .= sprintf("\r\n<br/>Status:<span class=\"error\">%s</span>\r\n", $this->status);
		}

		if ($this->elevation)
		{
			$str .= sprintf("\r\n<br/>Elevation:%s", $this->elevation);
		}

		$str .= $this->rco->FormatFixNavaidEntry();

		return $str;
	}

	public function FormatMarkerGoogle()
	{
		$icon = "../images/unk.png";

		$freq = $this->freq;

		$tacan = "";

		switch($this->type)
		{
			case "NDB":
			{
				$icon = "../images/ndb.png";

				break;
			}

			case "DME":
			{
				$icon = "../images/dme.png";

				break;
			}

			case "VORTAC":
			{
				$icon = "../images/vortac.png";

				$tacan = $this->tacan;

				break;
			}

			case "VOR/DME":
			{
				$icon = "../images/vordme.png";

				break;
			}

			case "VOR":
			{
				$icon = "../images/vor.png";

				break;
			}

			case "TACAN":
			{
				$icon = "../images/tacan.png";

				$freq = $this->tacan;

				break;
			}

			default:
			{
				$icon = "../images/unk.png";

				break;
			}
		}

		$infoWindow  = "<div class=\"infoboxText\">";

		$infoWindow .= "<img onclick=\"AppendWaypoint(\'N;" . $this->facilityId . ";" . $this->id . "\')\"  onmouseover=\"SetImage(this, \'../images/add.png\')\" onmouseout=\"SetImage(this, \'" . $icon . "\')\"" .
		" src=\"" . $icon . "\" height=\"10\" width=\"10\"/>" .
		" <a href=\"../navaid/index.php?id=" . $this->sess->sessionId . "&key=" . $this->id . "\">" . $this->facilityId . "</a> " . $this->name . "<br/>" .
		$this->freq . " " . $tacan . " " . $this->morse . " " . $this->type . "<br/>" .
		$this->status;

		$infoWindow .= $this->cs->FormatInfobox();

		$infoWindow .= "</div>";

		$infoWindow = str_replace("\r\n", "", $infoWindow);
		
		$str  = sprintf("    navMarker = new Marker(map, '%s', %s, %s, black, '%s', '%s');\r\n", $this->facilityId, $this->latLon->decimalLat, $this->latLon->decimalLon, $icon, $infoWindow);

		return $str;
	}

	public function FormatMarkerBing()
	{
		$icon = "../images/unk.png";

		$freq = $this->freq;

		$tacan = "";

		switch($this->type)
		{
			case "NDB":
			{
				$icon = "../images/ndb.png";

				break;
			}

			case "DME":
			{
				$icon = "../images/dme.png";

				break;
			}

			case "VORTAC":
			{
				$icon = "../images/vortac.png";

				$tacan = $this->tacan;

				break;
			}

			case "VOR/DME":
			{
				$icon = "../images/vordme.png";

				break;
			}

			case "VOR":
			{
				$icon = "../images/vor.png";

				break;
			}

			case "TACAN":
			{
				$icon = "../images/tacan.png";

				$freq = $this->tacan;

				break;
			}

			default:
			{
				$icon = "../images/unk.png";

				break;
			}
		}

		$infoWindow  = "<div class=\"infoboxText\">";

		$infoWindow .= "<img onclick=\"AppendWaypoint(\'N;" . $this->facilityId . ";" . $this->id . "\')\"  onmouseover=\"SetImage(this, \'../images/add.png\')\" onmouseout=\"SetImage(this, \'" . $icon . "\')\"" .
		" src=\"" . $icon . "\" height=\"10\" width=\"10\"/>" .
		" <a href=\"../navaid/index.php?id=" . $this->sess->sessionId . "&key=" . $this->id . "\">" . $this->facilityId . "</a> " . $this->name . "<br/>" .
		$this->freq . " " . $tacan . " " . $this->morse . " " . $this->type . "<br/>" .
		$this->status;

		$infoWindow .= $this->cs->FormatInfobox();

		$infoWindow .= "</div>";

		$infoWindow = str_replace("\r\n", "", $infoWindow);
		
		$str  = sprintf("    navMarker = new BingMarker(map, '%s', %s, %s, black, '%s', '%s');\r\n", $this->facilityId, $this->latLon->decimalLat, $this->latLon->decimalLon, $icon, $infoWindow);

		return $str;
	}

	public function FormatMarkerOSM()
	{
		$icon = "../images/unk.png";

		$freq = $this->freq;

		$tacan = "";

		switch($this->type)
		{
			case "NDB":
			{
				$icon = "../images/ndb.png";

				break;
			}

			case "DME":
			{
				$icon = "../images/dme.png";

				break;
			}

			case "VORTAC":
			{
				$icon = "../images/vortac.png";

				$tacan = $this->tacan;

				break;
			}

			case "VOR/DME":
			{
				$icon = "../images/vordme.png";

				break;
			}

			case "VOR":
			{
				$icon = "../images/vor.png";

				break;
			}

			case "TACAN":
			{
				$icon = "../images/tacan.png";

				$freq = $this->tacan;

				break;
			}

			default:
			{
				$icon = "../images/unk.png";

				break;
			}
		}

		$infoWindow  = "<div class=\"infoboxText\">";

		$infoWindow .= "<img onclick=\"AppendWaypoint(\'N;" . $this->facilityId . ";" . $this->id . "\')\"  onmouseover=\"SetImage(this, \'../images/add.png\')\" onmouseout=\"SetImage(this, \'" . $icon . "\')\"" .
		" src=\"" . $icon . "\" height=\"10\" width=\"10\"/>" .
		" <a href=\"../navaid/index.php?id=" . $this->sess->sessionId . "&key=" . $this->id . "\">" . $this->facilityId . "</a> " . $this->name . "<br/>" .
		$this->freq . " " . $tacan . " " . $this->morse . " " . $this->type . "<br/>" .
		$this->status;

		$infoWindow .= $this->cs->FormatInfobox();

		$infoWindow .= "</div>";

		$infoWindow = str_replace("\r\n", "", $infoWindow);
		
		$str  = sprintf("    navMarker = new OSMMarker(map, '%s', %s, %s, black, '%s', '%s');\r\n", $this->facilityId, $this->latLon->decimalLat, $this->latLon->decimalLon, $icon, $infoWindow);
		
		$str .= sprintf("    map.addLayer(navMarker.markerLayer);\r\n");

		return $str;
	}

	public function PdfMenu()
	{
		return $this->cs->ListEntries(true);
	}

	public function FormatDTPPMenu()
	{
		$str = sprintf("<b>%s:%s</b>\r\n", $this->facilityId, $this->name);

		$str .= $this->PdfMenu();

		return $str;
	}

	public function FormatXML()
	{
		$str = sprintf("<key>%s</key>", $this->id);

		$str.= sprintf("<facilityId>%s</facilityId>", $this->facilityId);

		$str .= sprintf("<type>%s</type>", $this->type);

		$str .= sprintf("<name>%s</name>", $this->name);

		$str .= sprintf("<region>%s</region>", $this->region);

		$str .= sprintf("<morse>%s</morse>", $this->morse);

		$str .= sprintf("<status>%s</status>", $this->status);

		$icon = null;

		$freq = $this->freq;

		switch($this->type)
		{
			case "NDB":
			{
				$icon = "../images/ndb.png";

				break;
			}

			case "DME":
			{
				$icon = "../images/dme.png";

				break;
			}

			case "VORTAC":
			{
				$icon = "../images/vortac.png";

				break;
			}

			case "VOR/DME":
			{
				$icon = "../images/vordme.png";

				break;
			}

			case "VOR":
			{
				$icon = "../images/vor.png";

				break;
			}

			case "TACAN":
			{
				$icon = "../images/tacan.png";

				$freq = $this->tacan;

				break;
			}

			default:
			{
				$icon = "../images/unk.png";

				break;
			}
		}

		$str .= sprintf("<freq>%s</freq>", $freq);

		$str .= sprintf("<icon>%s</icon>", $icon);

		$str .= sprintf("<latitude>%s</latitude>", $this->latLon->decimalLat);

		$str .= sprintf("<longitude>%s</longitude>", $this->latLon->decimalLon);

		$str .= $this->cs->FormatXML("navcs" . $this->id);

		return $str;
	}
}

class Navaid
{
	public $sess;
	public $navaid = array();

	public function __construct($sess, $sql)
	{
		$this->sess = $sess;

		$navDbase = new Database();

		$navDbase->ExecSql($sql);

		if ($navDbase->GetRowCount() > 0)
		{
			while($row = $navDbase->FetchRow())
			{
				$this->GetRow($row);
			}
		}
		else
		{
			$this->navaid = null;
		}

		$navDbase->Disconnect();
	}

	public function GetRow($row)
	{
		$navaidData = new NavaidData($this->sess);

		$navaidData->id = $row["id"];
		$navaidData->facilityId = $row["facilityId"];
		$navaidData->morse = $row["morse"];
		$navaidData->type = $row["type"];
		$navaidData->freq = $row["freq"];
		$navaidData->tacan = $row["tacan"];
		$navaidData->magVar = $row["magVar"];
		$navaidData->magVarYear = $row["magVarYear"];
		$navaidData->radioCall = $row["radioCall"];
		$navaidData->fssId = $row["fssId"];
		$navaidData->fssName = $row["fssName"];
		$navaidData->name = htmlspecialchars($row["name"], ENT_QUOTES);
		$navaidData->city = $row["city"];
		$navaidData->state = $row["state"];
		$navaidData->class = $row["class"];
		$navaidData->artccHighId = $row["artccHighId"];
		$navaidData->artccHighName = $row["artccHighName"];
		$navaidData->artccLowId = $row["artccLowId"];
		$navaidData->artccLowName = $row["artccLowName"];
		$navaidData->latitude = $row["latitude"];
		$navaidData->longitude = $row["longitude"];
		$navaidData->status = $row["status"];
		$navaidData->hiwas = $row["hiwas"];
		$navaidData->elevation = $row["elevation"];

		$navaidData->latLon = new LatLon($navaidData->latitude, $navaidData->longitude);

		$sql = sprintf("SELECT * FROM comStation USE INDEX(comStationFacilityId) WHERE facilityId='%s'", $navaidData->facilityId);
		
		if ($this->sess->showFrequency == "V")
		{
			$sql .= " AND freq>'108.000' AND freq<'137.000'";
		}

		$navaidData->rco = new Rco($this->sess, $sql);

		$sql = sprintf("SELECT * FROM navRemarks USE INDEX(navRemarksFacilityId) WHERE facilityId='%s' AND name='%s' ORDER BY text", $navaidData->facilityId, $navaidData->name);

		$navaidData->remarks = new NavaidRemarks($sql);

		$sql = sprintf("SELECT * FROM chartSupplement USE INDEX(chartSupplementNavaidName) WHERE navaidName='%s'", $navaidData->name);

		$navaidData->cs = new ChartSupplement($this->sess, $sql);

		$sql = sprintf("SELECT * FROM fixLocation USE INDEX(fixLocationFixId) where fixId='%s'", $navaidData->name);

		$fixDbase = new Database();

		$fixDbase->ExecSql($sql);

		if ($fixDbase->GetRowCount() > 0)
		{
			$row = $fixDbase->FetchRow();

			$navaidData->region = $row["region"];
		}

		$fixDbase->Disconnect();

		array_push($this->navaid, $navaidData);
	}

	public function GetSingle($i)
	{
		if ($this->navaid == null)
		{
			return;
		}

		return $this->navaid[$i];
	}

	public function GetByRegion($i)
	{
		if ($this->navaid == null)
		{
			return;
		}

		foreach ($this->navaid as $nav)
		{
			if ($nav->region == $i)
			{
				return $nav;
			}
		}

		return;
	}

	public function ListEntries()
	{
		if ($this->navaid == null)
		{
			return;
		}

		if (count($this->navaid) < 2)
		{
			return;
		}

		$str  = sprintf("<table>\r\n");

		$str .= sprintf("<tr><th>Facility</th>\r\n");

		$str .= sprintf("<th>Name</th>\r\n");

		$str .= sprintf("<th>Type</th>\r\n");

		$str .= sprintf("<th>State</th></tr>\r\n");

		foreach ($this->navaid as $nav)
		{
			$str .= $nav->FormatEntry();
		}

		$str .= sprintf("</table>\r\n");

		return $str;
	}

	public function WaypointInfo()
	{
		if ($this->navaid == null)
		{
			return;
		}

		$str = null;

		foreach ($this->navaid as $nav)
		{
			$str .= $nav->WaypointInfo();
		}

		return $str;
	}

	public function ListFixNavaidEntries()
	{
		if ($this->navaid == null)
		{
			return;
		}

		$str = null;

		foreach ($this->navaid as $nav)
		{
			$str .= $nav->FormatFixNavaidEntry();
		}

		return $str;
	}

	public function ListFixIlsNavaidEntries()
	{
		if ($this->navaid == null)
		{
			return;
		}

		$str = null;

		foreach ($this->navaid as $nav)
		{
			$str .= "\r\n<br/>";

			$str .= $nav->FormatFixNavaidEntry();
		}

		return $str;
	}

	public function MapMarkerGoogle()
	{
		if ($this->navaid == null)
		{
			return;
		}

		$str = null;

		foreach ($this->navaid as $nav)
		{
			$str .= $nav->FormatMarkerGoogle();
		}

		return $str;
	}

	public function MapMarkerBing()
	{
		if ($this->navaid == null)
		{
			return;
		}

		$str = null;

		foreach ($this->navaid as $nav)
		{
			$str .= $nav->FormatMarkerBing();
		}

		return $str;
	}

	public function MapMarkerOSM()
	{
		if ($this->navaid == null)
		{
			return;
		}

		$str = null;

		foreach ($this->navaid as $nav)
		{
			$str .= $nav->FormatMarkerOSM();
		}

		return $str;
	}
	
	public function DTPPMenu()
	{
		if ($this->navaid == null)
		{
			return;
		}

		$str = null;

		foreach ($this->navaid as $nav)
		{
			$str .= $nav->FormatDTPPMenu();
		}

		return $str;
	}

	public function FormatXML($info)
	{
		if ($this->navaid == null)
		{
			return;
		}

		$str = null;

		foreach ($this->navaid as $nav)
		{
			if ($info == true)
			{
				$str .= sprintf("<navaidInfo>");

				$str .= $nav->FormatXML();

				$str .= sprintf("</navaidInfo>");
			}
			else
			{
				$str .= sprintf("<nav>");

				$str .= $nav->FormatXML();

				$str .= sprintf("</nav>");
			}
		}

		return $str;
	}
}
?>