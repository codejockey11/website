<?php
class AirportData
{
	public $id;
	public $facilityId;
	public $ICAO;
	public $type;
	public $state;
	public $county;
	public $city;
	public $name;
	public $ownerType;
	public $facilityUse;
	public $ownersName;
	public $ownersAddr;
	public $ownersCityStateZip;
	public $ownersPhone;
	public $managersName;
	public $managersAddr;
	public $managersCityStateZip;
	public $managersPhone;
	public $latitude;
	public $longitude;
	public $elevation;
	public $magVar;
	public $sectional;
	public $acreage;
	public $artccId;
	public $artccName;
	public $fss;
	public $fssName;
	public $fssTollFreeNbr;
	public $fssPilotNbr;
	public $notamFacility;
	public $notamServices;
	public $status;
	public $fuelTypes;
	public $airframeRepair;
	public $powerplantRepair;
	public $bottledOxygen;
	public $bulkOxygen;
	public $controlTower;
	public $unicom;
	public $ctaf;
	public $segCircle;
	public $beaconColor;
	public $landingFee;
	public $transientStorage;
	public $otherServices;
	public $windIndicator;
	public $minimumOperationalNetwork;

	public $latLon;

	public $airportRunway;
	public $airportAttended;
	public $airportRemarks;

	public $awos;
	public $tower;

	public $cs;
	public $dTPP;
	public $compares;

	public $rco;

	public $sess;

	public function __construct($sess)
	{
		$this->sess = $sess;
	}

	public function WaypointInfo()
	{
		printf("%s:%s<br/>\r\n", $this->ICAO, $this->name);

		if ($this->ctaf)
		{
			printf("ctaf:%s", $this->ctaf);
		}

		if ($this->unicom)
		{
			printf(" unicom:%s", $this->unicom);
		}

		if ($this->rco->rco != null)
		{
			foreach ($this->rco->rco as $rco)
			{
				printf("<br/>%s:%s", $rco->type, $rco->freq);
			}
		}
	}

	public function FormatEntry()
	{
		$str  = sprintf("<tr><td><a href=\"../airport/index.php?id=%s&key=%s\">%s</a></td>\r\n", $this->sess->sessionId, $this->id, $this->facilityId);

		$str .= sprintf("<td>%s</td>\r\n", $this->name);

		$str .= sprintf("<td>%s, %s</td>\r\n", $this->city, $this->state);

		$str .= sprintf("</tr>\r\n");

		$str .= sprintf("<tr><td><table>\r\n");

		$str .= $this->airportRunway->FormatAirportList();

		$str .= sprintf("</table></td></tr>\r\n");

		return $str;
	}

	public function FormatBaseInfo()
	{
		$str  = "<td>";

		if ($this->ICAO == null)
		{
			$str .= sprintf("<b>%s:%s</b>\r\n", $this->facilityId, $this->name);
		}
		else
		{
			$str .= sprintf("<b>%s:%s</b>\r\n", $this->ICAO, $this->name);
		}

		$str .= sprintf("\r\n<br/>%s,%s", $this->city, $this->state);

		$str .= sprintf("\r\n<br/>");

		$p = new Parameter("airportOwnershipType" . $this->ownerType);

		$str .= sprintf("\r\n<br/>Ownership:%s", $p->value1);

		$p = new Parameter("facilityUse" . $this->facilityUse);

		$str .= sprintf("\r\n<br/>Facility Use:%s %s", $this->type, $p->value1);

		$p = new Parameter("airportStatusCode" . $this->status);

		$str .= sprintf("\r\n<br/>Status:%s", $p->value1);

		$str .= sprintf("\r\n<br/>");

		$str .= sprintf("\r\n<br/>Owner:");

		$str .= sprintf("\r\n<br/>%s", $this->ownersName);

		$str .= sprintf("\r\n<br/>%s", str_replace(",", "\r\n<br/>", $this->ownersAddr));

		$str .= sprintf("\r\n<br/>%s", $this->ownersCityStateZip);

		$str .= sprintf("\r\n<br/>%s", $this->ownersPhone);

		if ($this->managersName)
		{
			$str .= sprintf("\r\n<br/>");

			$str .= sprintf("\r\n<br/>Manager:");

			$str .= sprintf("\r\n<br/>%s", $this->managersName);

			$str .= sprintf("\r\n<br/>%s", str_replace(",", "\r\n<br/>", $this->managersAddr));

			$str .= sprintf("\r\n<br/>%s", $this->managersCityStateZip);

			$str .= sprintf("\r\n<br/>%s", $this->managersPhone);
		}

		$str .= sprintf("\r\n<br/>");

		$str .= sprintf("\r\n<br/>GPS:%s %s", $this->latitude, $this->longitude);

		$str .= sprintf("\r\n<br/>");

		if ($this->airportAttended)
		{
			$str .= $this->airportAttended->ListEntries(true);
		}

		if ($this->cs)
		{
			if ($csp = $this->cs->GetSingle(0))
			{
				$str .= sprintf("\r\n<br/><br/><a href=\"../dTPPCS/index.php?id=%s&ident=%s&type=cs&pdf=%s\">Documents</a>\r\n", $this->sess->sessionId, $this->facilityId, $csp->pdf);
			}
			else
			{
				$str .= sprintf("\r\n<br/>");
			}
		}

		$airportLookup = new Parameter("airportLookup");
		$skyVector = new Parameter("skyVector");
		$airNav = new Parameter("airNav");
		$notamshref = new Parameter("notamshref");
		$construction = new Parameter("construction");

		$str .= sprintf("\r\n<br/><a href=\"%s%s\">%s</a>\r\n", $airportLookup->value1, $this->facilityId, $airportLookup->value2);

		$str .= sprintf("\r\n<br/><a href=\"%s%s,%s\">%s</a>\r\n", $skyVector->value1, $this->latLon->decimalLat, $this->latLon->decimalLon, $skyVector->value2);

		$str .= sprintf("\r\n<br/><a href=\"%s%s\">%s</a>\r\n", $airNav->value1, $this->facilityId, $airNav->value2);

		$str .= sprintf("\r\n<br/><a href=\"%s%s\">%s</a>\r\n", $notamshref->value1, $this->facilityId, $notamshref->value2);

		$file = sprintf("%s%s.pdf", $construction->value1, strtolower($this->facilityId));

		$ch = new CheckHttp($file);

		if ($ch->isFound)
		{
			$str .= sprintf("\r\n<br/><a href=\"%s\">%s</a>\r\n", $file, $construction->value2);
		}

		$str .= sprintf("</td>\r\n");

		$str .= sprintf("<td>\r\n");

		$str .= sprintf("Elevation:%s", $this->elevation);

		$str .= sprintf("\r\n<br/>Acreage:%1d", $this->acreage);

		$str .= sprintf("\r\n<br/>MagVar:%s", $this->magVar);

		$str .= sprintf("\r\n<br/>Sectional:%s", $this->sectional);

		$str .= sprintf("\r\n<br/>ARTCC:%s %s", $this->artccId, $this->artccName);

		$str .= sprintf("\r\n<br/>FSS:%s %s", $this->fss, $this->fssName);

		$str .= sprintf("\r\n<br/>FSS Phone:%s", $this->fssPilotNbr);

		if ($this->fssTollFreeNbr)
		{
			$str .= sprintf("\r\n<br/>FSS Toll Free:1-%s", $this->fssTollFreeNbr);
		}

		if ($this->notamFacility)
		{
			$str .= sprintf("\r\n<br/>NOTAM:%s Services:%s", $this->notamFacility, $this->notamServices);
		}

		if ($this->fuelTypes)
		{
			$str .= sprintf("\r\n<br/>Fuel:%s", $this->fuelTypes);
		}

		if ($this->airframeRepair)
		{
			$str .= sprintf("\r\n<br/>Airframe Repair:%s", $this->airframeRepair);
		}

		if ($this->powerplantRepair)
		{
			$str .= sprintf("\r\n<br/>Powerplant Repair:%s", $this->powerplantRepair);
		}

		if ($this->bottledOxygen)
		{
			$str .= sprintf("\r\n<br/>Bottled Oxygen:%s", $this->bottledOxygen);
		}

		if ($this->bulkOxygen)
		{
			$str .= sprintf("\r\n<br/>Bulk Oxygen:%s", $this->bulkOxygen);
		}

		if ($this->controlTower)
		{
			$str .= sprintf("\r\n<br/>Control Tower:%s", $this->controlTower);
		}

		if ($this->segCircle)
		{
			$str .= sprintf("\r\n<br/>Seg Circle:%s", $this->segCircle);
		}

		if ($this->beaconColor)
		{
			$p = new Parameter("beaconColor" . $this->beaconColor);

			$str .= sprintf("\r\n<br/>Beacon:<a class=\"tooltip\" href=\"#\">%s<span>%s</span></a>\r\n", $this->beaconColor, $p->value1);
		}

		if ($this->landingFee)
		{
			$str .= sprintf("\r\n<br/>Landing Fee:%s", $this->landingFee);
		}

		if ($this->transientStorage)
		{
			$str .= sprintf("\r\n<br/>Transient:%s", $this->transientStorage);
		}

		if ($this->windIndicator)
		{
			$str .= sprintf("\r\n<br/>Wind Indicator:%s", $this->windIndicator);
		}

		if ($this->minimumOperationalNetwork)
		{
			$str .= sprintf("\r\n<br/>Minimum Operational Network:%s", $this->minimumOperationalNetwork);
		}

		$str .= sprintf("\r\n<br/>");

		if ($this->otherServices)
		{
			$str .= sprintf("\r\n<br/>Other Services:");

			$osa = explode(',', $this->otherServices);

			foreach ($osa as $os)
			{
				$p = new Parameter("airportService" . $os);

				$str .= sprintf("\r\n<br/>%s", $p->value1);
			}
		}

		$str .= sprintf("</td>\r\n");

		$str .= sprintf("<td>\r\n");

		$str .= $this->ShowMap();

		$str .= sprintf("</td>\r\n");

		return $str;
	}

	public function ShowMap()
	{
		$map = new BingMap($this->latitude, $this->longitude, $this->acreage, 440, 400);
		//$map = new GoogleMap($this->latitude, $this->longitude, $this->acreage, 440, 400);

		return $map->ShowMap();
	}

	public function FormatPlanInfo()
	{
		$str  = sprintf("%s", $this->facilityId);

		$str .= sprintf(" elv:%s", $this->elevation);

		if ($this->fuelTypes)
		{
			$str .= sprintf(" %s", $this->fuelTypes);
		}

		$str .= $this->airportAttended->FormatPlanInfo();

		$str .= sprintf("\r\n<br/>");

		$str .= sprintf("%s", $this->managersName);

		$str .= sprintf(" %s", $this->managersPhone);

		$str .= sprintf("\r\n<br/>");

		$str .= sprintf("fss:%s", $this->fss);

		$str .= sprintf(" %s ", $this->fssName);

		if ($this->fssTollFreeNbr)
		{
			$str .= sprintf(" %s", $this->fssTollFreeNbr);
		}

		$str .= sprintf(" notam:%s", $this->notamServices);

		$str .= sprintf(" %s<br/>\r\n", $this->notamFacility);

		$str .= $this->airportRemarks->FormatPlanInfo();

		return $str;
	}

	public function ListComms($header)
	{
		$str = null;

		$ss  = null;

		$hasFreq = false;

		if ($this->ctaf)
		{
			$hasFreq = true;

			$ss .= sprintf("\r\n<br/>CTAF %s", $this->ctaf);
		}

		if ($this->unicom)
		{
			$hasFreq = true;

			$ss .= sprintf("\r\n<br/>UNICOM %s", $this->unicom);
		}

		if ($this->rco)
		{
			if ($this->rco->rco != null)
			{
				$hasFreq = true;

				$ss .= $this->rco->ListAirportEntries();
			}
		}

		if ($hasFreq)
		{
			if ($header)
			{
				$str .= sprintf("<b>FREQUENCIES</b>\r\n");
			}

			$str .= $ss;

			$str .= $this->awos->ListEntries();
		}

		return $str;
	}

	public function FormatRunwayInfo()
	{
		return $this->airportRunway->FormatPlanInfo();
	}

	public function PdfMenu()
	{
		$str  = null;

		$str .= $this->cs->ListEntries(true);

		$str .= $this->dTPP->ListEntries(true);

		$str .= $this->compares->ListEntries(true);

		return $str;
	}

	public function FormatDTPPMenu()
	{
		$str  = sprintf("<b>%s:%s</b>\r\n", $this->facilityId, $this->name);

		$str .= $this->PdfMenu();

		return $str;
	}

	public function FormatMarkerGoogle()
	{
		$icon = $this->airportRunway->GetIcon();

		$infoWindow  = "<div class=\"infoboxText\">";

		$infoWindow .= "<img onclick=\"AppendWaypoint(\'A;" . $this->ICAO . ";" . $this->id . "\')\"  onmouseover=\"SetImage(this, \'../images/add.png\')\" onmouseout=\"SetImage(this, \'" . $icon . "\')\"" .
		" src=\"" . $icon . "\" height=\"10\" width=\"10\"/>" .
		" <a href=\"../airport/index.php?id=" . $this->sess->sessionId . "&key=" . $this->id . "\">" . $this->ICAO . "</a> " . $this->name;
		
		$infoWindow .= $this->airportRunway->FormatInfobox();

		$infoWindow .= $this->cs->FormatInfobox();

		$infoWindow .= $this->dTPP->FormatInfobox();

		$infoWindow .= $this->compares->FormatInfobox();

		$infoWindow .= "</div>";

		$infoWindow = str_replace("\r\n", "", $infoWindow);

		$str  = sprintf("    aptMarker = new Marker(map, '%s', %s, %s, black, '%s', '%s');\r\n", $this->ICAO, $this->latLon->decimalLat, $this->latLon->decimalLon, $icon, $infoWindow);

		return $str;
	}

	public function FormatMarkerBing()
	{
		$icon = $this->airportRunway->GetIcon();

		$infoWindow  = "<div class=\"infoboxText\">";

		$infoWindow .= "<img onclick=\"AppendWaypoint(\'A;" . $this->ICAO . ";" . $this->id . "\')\"  onmouseover=\"SetImage(this, \'../images/add.png\')\" onmouseout=\"SetImage(this, \'" . $icon . "\')\"" .
		" src=\"" . $icon . "\" height=\"10\" width=\"10\"/>" .
		" <a href=\"../airport/index.php?id=" . $this->sess->sessionId . "&key=" . $this->id . "\">" . $this->ICAO . "</a> " . $this->name;
		
		$infoWindow .= $this->airportRunway->FormatInfobox();

		$infoWindow .= $this->cs->FormatInfobox();

		$infoWindow .= $this->dTPP->FormatInfobox();

		$infoWindow .= $this->compares->FormatInfobox();

		$infoWindow .= "</div>";

		$infoWindow = str_replace("\r\n", "", $infoWindow);

		$str  = sprintf("    aptMarker = new BingMarker(map, '%s', %s, %s, black, '%s', '%s');\r\n", $this->ICAO, $this->latLon->decimalLat, $this->latLon->decimalLon, $icon, $infoWindow);

		return $str;
	}

	public function FormatMarkerOSM()
	{
		$icon = $this->airportRunway->GetIcon();

		$infoWindow  = "<div class=\"infoboxText\">";

		$infoWindow .= "<img onclick=\"AppendWaypoint(\'A;" . $this->ICAO . ";" . $this->id . "\')\"  onmouseover=\"SetImage(this, \'../images/add.png\')\" onmouseout=\"SetImage(this, \'" . $icon . "\')\"" .
		" src=\"" . $icon . "\" height=\"10\" width=\"10\"/>" .
		" <a href=\"../airport/index.php?id=" . $this->sess->sessionId . "&key=" . $this->id . "\">" . $this->ICAO . "</a> " . $this->name;
		
		$infoWindow .= $this->airportRunway->FormatInfobox();

		$infoWindow .= $this->cs->FormatInfobox();

		$infoWindow .= $this->dTPP->FormatInfobox();

		$infoWindow .= $this->compares->FormatInfobox();

		$infoWindow .= "</div>";

		$infoWindow = str_replace("\r\n", "", $infoWindow);

		$str  = sprintf("    aptMarker = new OSMMarker(map, '%s', %s, %s, black, '%s', '%s');\r\n", $this->ICAO, $this->latLon->decimalLat, $this->latLon->decimalLon, $icon, $infoWindow);
		
		$str .= sprintf("    map.addLayer(aptMarker.markerLayer);\r\n");

		return $str;
	}
	
	public function FormatXML()
	{
		$str  = sprintf("<key>%s</key>", $this->id);

        $str .= sprintf("<icao>%s</icao>", $this->ICAO);

		$str .= sprintf("<ident>%s</ident>", $this->facilityId);

		$str .= sprintf("<icao>%s</icao>", $this->ICAO);

		$str .= sprintf("<name>%s</name>", $this->name);

		$str .= sprintf("<type>%s</type>", $this->type);

		$c = 0;
		$t = 0;
		$w = 0;

		foreach ($this->airportRunway->runway as $rwy)
		{
			switch(substr($rwy->surface, 0 ,4))
			{
				case "ALUM":
				{
					$t = 1;

					break;
				}

				case "ASPH":
				{
					$c = 1;

					break;
				}

				case "BRIC":
				{
					$t = 1;

					break;
				}

				case "CALI":
				{
					$t = 1;

					break;
				}

				case "CONC":
				{
					$c = 1;

					break;
				}

				case "CORA":
				{
					$t = 1;

					break;
				}

				case "DECK":
				{
					$t = 1;

					break;
				}

				case "DIRT":
				{
					$t = 1;

					break;
				}

				case "GRAS":
				{
					$t = 1;

					break;
				}

				case "GRAV":
				{
					$t = 1;

					break;
				}

				case "GRE":
				{
					$t = 1;

					break;
				}

				case "GRVL":
				{
					$t = 1;

					break;
				}

				case "MATS":
				{
					$t = 1;

					break;
				}

				case "META":
				{
					$t = 1;

					break;
				}

				case "NSTD":
				{
					$t = 1;

					break;
				}

				case "OIL&":
				{
					$t = 1;

					break;
				}

				case "PEM":
				{
					$c = 1;

					break;
				}

				case "PEM-":
				{
					$c = 1;

					break;
				}

				case "PFC":
				{
					$t = 1;

					break;
				}

				case "PSP":
				{
					$t = 1;

					break;
				}

				case "ROOF":
				{
					$t = 1;

					break;
				}

				case "SAND":
				{
					$t = 1;

					break;
				}

				case "SOD":
				{
					$t = 1;

					break;
				}

				case "STEE":
				{
					$t = 1;

					break;
				}

				case "TREA":
				{
					$t = 1;

					break;
				}

				case "TRTD":
				{
					$t = 1;

					break;
				}

				case "TUIR":
				{
					$t = 1;

					break;
				}

				case "TURF":
				{
					$t = 1;

					break;
				}

				case "WATE":
				{
					$w = 1;

					break;
				}

				case "WOOD":
				{
					$t = 1;

					break;
				}
			}
		}

		if (($c == 1) && ($t == 1))
		{
			$str .= sprintf("<icon>../images/airportBoth.png</icon>");
		}
		else if ($c == 1)
		{
			$str .= sprintf("<icon>../images/airport.png</icon>");
		}
		else if ($t == 1)
		{
			$str .= sprintf("<icon>../images/airportTurf.png</icon>");
		}
		else
		{
			$str .= sprintf("<icon>../images/airportWater.png</icon>");
		}

		$str .= sprintf("<latitude>%s</latitude>", $this->latLon->decimalLat);

		$str .= sprintf("<longitude>%s</longitude>", $this->latLon->decimalLon);

		$str .= $this->airportRunway->FormatXML();

		$str .= $this->cs->FormatXML("aptcs". $this->id);

		$str .= $this->dTPP->FormatXML();

		$str .= $this->compares->FormatXML();

		return $str;
	}
}

class Airport
{
	public $airport = array();
	public $sess;

	public function __construct($sess, $sql)
	{
		$this->sess = $sess;

		$aptDbase = new Database();

		$aptDbase->ExecSql($sql);

		if ($aptDbase->GetRowCount() > 0)
		{
			while($row = $aptDbase->FetchRow())
			{
				$this->GetRow($row);
			}
		}
		else
		{
			$this->airport = null;
		}

		$aptDbase->Disconnect();
	}

	public function GetRow($row)
	{
		$airportData = new AirportData($this->sess);

		$airportData->id = $row["id"];
		$airportData->facilityId = $row["facilityId"];
		$airportData->ICAO = $row["ICAO"];
		$airportData->type = $row["type"];
		$airportData->state = $row["state"];
		$airportData->county = $row["county"];
		$airportData->city = $row["city"];
		$airportData->name = htmlspecialchars($row["name"], ENT_QUOTES);
		$airportData->ownerType = $row["ownerType"];
		$airportData->facilityUse = $row["facilityUse"];
		$airportData->ownersName = htmlspecialchars($row["ownersName"], ENT_QUOTES);
		$airportData->ownersAddr = $row["ownersAddr"];
		$airportData->ownersCityStateZip = $row["ownersCityStateZip"];
		$airportData->ownersPhone = $row["ownersPhone"];
		$airportData->managersName = htmlspecialchars($row["managersName"], ENT_QUOTES);
		$airportData->managersAddr = $row["managersAddr"];
		$airportData->managersCityStateZip = $row["managersCityStateZip"];
		$airportData->managersPhone = $row["managersPhone"];
		$airportData->latitude = $row["latitude"];
		$airportData->longitude = $row["longitude"];
		$airportData->elevation = $row["elevation"];
		$airportData->magVar = $row["magVar"];
		$airportData->sectional = $row["sectional"];
		$airportData->acreage = $row["acreage"];
		$airportData->artccId = $row["artccId"];
		$airportData->artccName = $row["artccName"];
		$airportData->fss = $row["fss"];
		$airportData->fssName = $row["fssName"];
		$airportData->fssTollFreeNbr = $row["fssTollFreeNbr"];
		$airportData->fssPilotNbr = $row["fssPilotNbr"];
		$airportData->notamFacility = $row["notamFacility"];
		$airportData->notamServices = $row["notamServices"];
		$airportData->status = $row["status"];
		$airportData->fuelTypes = $row["fuelTypes"];
		$airportData->airframeRepair = $row["airframeRepair"];
		$airportData->powerplantRepair = $row["powerplantRepair"];
		$airportData->bottledOxygen = $row["bottledOxygen"];
		$airportData->bulkOxygen = $row["bulkOxygen"];
		$airportData->controlTower = $row["controlTower"];
		$airportData->unicom = $row["unicom"];
		$airportData->ctaf = $row["ctaf"];
		$airportData->segCircle = $row["segCircle"];
		$airportData->beaconColor = $row["beaconColor"];
		$airportData->landingFee = $row["landingFee"];
		$airportData->transientStorage = $row["transientStorage"];
		$airportData->otherServices = $row["otherServices"];
		$airportData->windIndicator = $row["windIndicator"];
		$airportData->minimumOperationalNetwork = $row["minimumOperationalNetwork"];

		$airportData->latLon = new LatLon($airportData->latitude, $airportData->longitude);

		$sql = sprintf("SELECT * FROM aptRunway USE INDEX(aptRunwayFacilityId) WHERE facilityId='%s'", $airportData->facilityId);

		$airportData->airportRunway = new AirportRunway($this->sess, $sql);

		$sql = sprintf("SELECT * FROM aptAttended USE INDEX(aptAttendedFacilityId) WHERE facilityId='%s'", $airportData->facilityId);

		$airportData->airportAttended = new AirportAttended($sql);

		$sql = sprintf("SELECT * FROM aptRemarks USE INDEX(aptRemarksFacilityId) WHERE facilityId='%s'", $airportData->facilityId);

		$airportData->airportRemarks = new AirportRemarks($sql);

		$sql = sprintf("SELECT * FROM awosStation USE INDEX(awosStationSensorId) WHERE sensorid='%s'", $airportData->facilityId);

		$airportData->awos = new Awos($sql);

		$airportData->tower = new Tower($this->sess, $airportData->facilityId);

		$sql = sprintf("SELECT * FROM chartSupplement USE INDEX(chartSupplementFacilityId) WHERE facilityId='%s'", $airportData->facilityId);

		$airportData->cs = new ChartSupplement($this->sess, $sql);
		
		$sql = sprintf("SELECT * FROM dTPP USE INDEX(dTPPFacilityId) WHERE facilityId='%s'", $airportData->facilityId);

		$airportData->dTPP = new DigitalTerminalProcedure($this->sess, $sql);
		
		$sql = sprintf("SELECT * FROM compares USE INDEX(comparesFacilityId) WHERE facilityId='%s'", $airportData->facilityId);

		$airportData->compares = new Compares($this->sess, $sql);

		$sql = sprintf("SELECT * FROM comStation USE INDEX(comStationFacilityId) WHERE facilityId='%s'", $airportData->facilityId);
		
		if ($this->sess->showFrequency == "V")
		{
			$sql .= " AND freq>'108.000' AND freq<'137.000'";
		}

		$airportData->rco = new Rco($this->sess, $sql);

		array_push($this->airport, $airportData);
	}

	public function GetSingle($i)
	{
		if ($this->airport == null)
		{
			return;
		}

		return $this->airport[$i];
	}

	public function ListEntries()
	{
		if ($this->airport == null)
		{
			return;
		}

		$str  = sprintf("<table>\r\n");

		$str .= sprintf("<tr><th>Facility</th>\r\n");

		$str .= sprintf("<th>Name</th>\r\n");

		$str .= sprintf("<th>City, State</th></tr>\r\n");

		foreach ($this->airport as $apt)
		{
			$str .= $apt->FormatEntry();
		}

		$str .= sprintf("</table>\r\n");

		return $str;
	}

	public function FormatBaseInfo()
	{
		if ($this->airport == null)
		{
			return;
		}

		$str = null;

		foreach ($this->airport as $apt)
		{
			$str .= $apt->FormatBaseInfo();
		}

		return $str;
	}

	public function DTPPMenu()
	{
		if ($this->airport == null)
		{
			return;
		}

		$str = null;

		foreach ($this->airport as $apt)
		{
			$str .= $apt->FormatDTPPMenu();
		}

		return $str;
	}

	public function MapMarkerGoogle()
	{
		if ($this->airport == null)
		{
			return;
		}

		$str = null;

		foreach ($this->airport as $apt)
		{
			$str .= $apt->FormatMarkerGoogle();
		}

		return $str;
	}

	public function MapMarkerBing()
	{
		if ($this->airport == null)
		{
			return;
		}

		$str = null;

		foreach ($this->airport as $apt)
		{
			$str .= $apt->FormatMarkerBing();
		}

		return $str;
	}

	public function MapMarkerOSM()
	{
		if ($this->airport == null)
		{
			return;
		}

		$str = null;

		foreach ($this->airport as $apt)
		{
			$str .= $apt->FormatMarkerOSM();
		}

		return $str;
	}

	public function FormatXML()
	{
		if ($this->airport == null)
		{
			return;
		}

		$str = null;

		foreach ($this->airport as $apt)
		{
			$str .= sprintf("<apt>");

			$str .= $apt->FormatXML();

			$str .= sprintf("</apt>");
		}

		return $str;
	}
}
?>