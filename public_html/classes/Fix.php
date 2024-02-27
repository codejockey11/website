<?php
class FixData
{
	public $id;
	public $fixId;
	public $state;
	public $region;
	public $latitude;
	public $longitude;
	public $magVar;
	public $category;
	public $fixUsage;
	public $nasId;
	public $highArtcc;
	public $lowArtcc;

	public $latLon;

	public $fixNavaid;
	public $fixIls;
	public $fixRemarks;
	public $fixCharting;

	public $cs;

	public $sess;

	public function __construct($sess)
	{
		$this->sess = $sess;
	}

	public function FormatBaseInfo()
	{
		$str  = sprintf("<b>%s</b>\r\n", $this->fixId);
		
		$str .= sprintf("\r\n<br/>State:%s", $this->state);

		$p = new Parameter("region" . $this->region);
		
		$str .= sprintf("\r\n<br/>Region:%s %s", $this->region, $p->value1);

		$str .= sprintf("\r\n<br/>GPS:%s %s", $this->latitude, $this->longitude);
		
		$str .= sprintf("\r\n<br/>MagVar:%s", $this->magVar);
		
		$str .= sprintf("\r\n<br/>Category:%s", $this->category);

		$p = new Parameter("fixUse" . $this->fixUsage);
		
		$str .= sprintf("\r\n<br/>Fix Usage:%s", $p->value1);

		$str .= sprintf("\r\n<br/>NASR ID:%s", $this->nasId);
		
		if ($this->highArtcc)
		{
			$p = new Parameter("center" . $this->highArtcc);
			
			$str .= sprintf("\r\n<br/>High ARTCC:%s %s", $this->highArtcc, $p->value1);
		}

		if ($this->lowArtcc)
		{
			$p = new Parameter("center" . $this->lowArtcc);
			
			$str .= sprintf("\r\n<br/>Low ARTCC:%s %s", $this->lowArtcc, $p->value1);
		}

		$str .= sprintf("\r\n<br/>");
		
		$p = new Parameter("fixLookup");
		
		$str .= sprintf("\r\n<br/><a href=\"%s%s\">NFDC Database</a>\r\n", $p->value1, $this->fixId);
		
		$str .= sprintf("\r\n<br/><a href=\"http://skyvector.com/?chart=301&zoom=4&ll=%s,%s\">Charts</a>\r\n", $this->latLon->decimalLat, $this->latLon->decimalLon);

		return $str;
	}

	public function FormatEntry()
	{
		$str  = sprintf("<tr><td class=\"list\"><a href=\"../fix/index.php?id=%s&key=%s\">%s</a></td>\r\n", $this->sess->sessionId, $this->id, $this->fixId);
		
		$str .= sprintf("<td class=\"list\">%s</td><td class=\"list\">%s</td>\r\n", $this->state, $this->region);
		
		$str .= sprintf("</tr>\r\n");

		return $str;
	}

	public function WaypointInfo()
	{
		$str = sprintf("%s", $this->fixId);

		if ($this->sess->remarks)
		{
			$str .= sprintf("\r\n<br/>%s", $this->state);
			
			$str .= sprintf(" %s", $this->region);
			
			$str .= sprintf(" %s", $this->category);
			
			$str .= sprintf(" %s", $this->fixUsage);

			if ($this->fixCharting)
			{
				$str .= $this->fixCharting->WaypointInfo();
			}

			if ($this->fixRemarks)
			{
				$str .= $this->fixRemarks->WaypointInfo();
			}

		}

		if ($this->fixNavaid)
		{
			$str .= $this->fixNavaid->WaypointInfo();
		}

		if ($this->fixIls)
		{
			$str .= $this->fixIls->WaypointInfo();
		}

		return $str;
	}

	public function FormatMarkerGoogle()
	{
		$icon = "../images/intersection.png";

		$infoWindow  = "<div class=\"infoboxText\">";

		$infoWindow .= "<img onclick=\"AppendWaypoint(\'F;" . $this->fixId . ";" . $this->id . "\')\"  onmouseover=\"SetImage(this, \'../images/add.png\')\" onmouseout=\"SetImage(this, \'" . $icon . "\')\"" .
		" src=\"" . $icon . "\" height=\"10\" width=\"10\"/>" .
		" <a href=\"../fix/index.php?id=" . $this->sess->sessionId . "&key=" . $this->id . "\">" . $this->fixId . "</a> ";

		$infoWindow .= sprintf("<br/>%s", $this->state);
			
		$infoWindow .= sprintf(" %s", $this->region);
			
		$infoWindow .= sprintf(" %s", $this->category);
			
		$infoWindow .= sprintf(" %s", $this->fixUsage);

		if ($this->fixCharting)
		{
			$infoWindow .= str_replace("\r\n", "", $this->fixCharting->WaypointInfo());
		}

		if ($this->fixRemarks)
		{
			$infoWindow .= str_replace("\r\n", "", $this->fixRemarks->WaypointInfo());
		}

		if ($this->fixNavaid)
		{
			$infoWindow .= str_replace("\r\n", "", $this->fixNavaid->WaypointInfo());
		}

		if ($this->fixIls)
		{
			$infoWindow .= str_replace("\r\n", "", $this->fixIls->WaypointInfo());
		}

		$infoWindow .= $this->cs->FormatInfobox();

		$infoWindow .= "</div>";

		$infoWindow = str_replace("\r\n", "", $infoWindow);

		$str  = sprintf("    fixMarker = new Marker(map, '%s', %s, %s, black, '%s', '%s');\r\n", $this->fixId, $this->latLon->decimalLat, $this->latLon->decimalLon, $icon, $infoWindow);

		return $str;
	}

	public function FormatMarkerBing()
	{
		$icon = "../images/intersection.png";

		$infoWindow  = "<div class=\"infoboxText\">";

		$infoWindow .= "<img onclick=\"AppendWaypoint(\'F;" . $this->fixId . ";" . $this->id . "\')\"  onmouseover=\"SetImage(this, \'../images/add.png\')\" onmouseout=\"SetImage(this, \'" . $icon . "\')\"" .
		" src=\"" . $icon . "\" height=\"10\" width=\"10\"/>" .
		" <a href=\"../fix/index.php?id=" . $this->sess->sessionId . "&key=" . $this->id . "\">" . $this->fixId . "</a> ";

		$infoWindow .= sprintf("<br/>%s", $this->state);
			
		$infoWindow .= sprintf(" %s", $this->region);
			
		$infoWindow .= sprintf(" %s", $this->category);
			
		$infoWindow .= sprintf(" %s", $this->fixUsage);

		if ($this->fixCharting)
		{
			$infoWindow .= str_replace("\r\n", "", $this->fixCharting->WaypointInfo());
		}

		if ($this->fixRemarks)
		{
			$infoWindow .= str_replace("\r\n", "", $this->fixRemarks->WaypointInfo());
		}

		if ($this->fixNavaid)
		{
			$infoWindow .= str_replace("\r\n", "", $this->fixNavaid->WaypointInfo());
		}

		if ($this->fixIls)
		{
			$infoWindow .= str_replace("\r\n", "", $this->fixIls->WaypointInfo());
		}

		$infoWindow .= $this->cs->FormatInfobox();

		$infoWindow .= "</div>";

		$infoWindow = str_replace("\r\n", "", $infoWindow);

		$str  = sprintf("    fixMarker = new BingMarker(map, '%s', %s, %s, black, '%s', '%s');\r\n", $this->fixId, $this->latLon->decimalLat, $this->latLon->decimalLon, $icon, $infoWindow);

		return $str;
	}

	public function PdfMenu()
	{
		$str = null;

		$str .= $this->cs->ListEntries(true);

		return $str;
	}

	public function FormatDTPPMenu()
	{
		$str = sprintf("<b>%s:%s</b>\r\n", $this->fixId, $this->state);

		$str .= $this->PdfMenu();

		return $str;
	}

	public function FormatXML()
	{
		$hl = "";

		if ($this->highArtcc)
		{
			$hl .= "H";
		}
		
		if ($this->lowArtcc)
		{
			$hl .= "L";
		}

		$str  = sprintf("<key>%s</key>", $this->id);

		$str .= sprintf("<fixId>%s</fixId>", $this->fixId);
		
		$str .= sprintf("<usage>%s %s</usage>", $this->fixUsage, $hl);
		
		$str .= sprintf("<region>%s</region>", $this->region);
		
		$str .= sprintf("<state>%s</state>", $this->state);
		
		$str .= sprintf("<category>%s</category>", $this->category);
		
		$str .= sprintf("<icon>../images/intersection.png</icon>");
		
		$str .= sprintf("<latitude>%s</latitude>", $this->latLon->decimalLat);
		
		$str .= sprintf("<longitude>%s</longitude>", $this->latLon->decimalLon);

		if ($this->fixIls)
		{
			$str .= $this->fixIls->FormatXML();
		}

		if ($this->fixNavaid)
		{
			$str .= $this->fixNavaid->FormatXML();
		}

		$str .= $this->cs->FormatXML("fixcs" . $this->id);

		return $str;
	}
}

class Fix
{
	public $sess;
	public $fix = array();

	public function __construct($sess, $sql)
	{
		$this->sess = $sess;

		$fixDbase = new Database();
		
		$fixDbase->ExecSql($sql);

		if ($fixDbase->GetRowCount() > 0)
		{
			while($row = $fixDbase->FetchRow())
			{
				$this->GetRow($row);
			}
		}
		else
		{
			$this->fix = null;
		}

		$fixDbase->Disconnect();
	}

	public function GetRow($row)
	{
		$fixData = new FixData($this->sess);

		$fixData->id = $row["id"];
		$fixData->fixId = $row["fixId"];
		$fixData->state = $row["state"];
		$fixData->region = $row["region"];
		$fixData->latitude = $row["latitude"];
		$fixData->longitude = $row["longitude"];
		$fixData->magVar = $row["magVar"];
		$fixData->category = $row["category"];
		$fixData->fixUsage = $row["fixUsage"];
		$fixData->nasId = $row["nasId"];
		$fixData->highArtcc = $row["highArtcc"];
		$fixData->lowArtcc = $row["lowArtcc"];

		$fixData->latLon = new LatLon($fixData->latitude, $fixData->longitude);

		$sql = sprintf("SELECT * FROM fixNavaid WHERE fixid='%s'", $fixData->fixId);

		$fixData->fixNavaid = new FixNavaid($this->sess, $sql);

		$sql = sprintf("SELECT * FROM fixIls WHERE fixid='%s' AND relation!='LO'", $fixData->fixId);

		$fixData->fixIls = new FixIls($this->sess, $sql);

		$sql = sprintf("SELECT * FROM fixRemarks WHERE fixid='%s'", $fixData->fixId);

		$fixData->fixRemarks = new FixRemarks($sql);
		
		$sql = sprintf("SELECT * FROM fixCharting WHERE fixid='%s'", $fixData->fixId);

		$fixData->fixCharting = new FixCharting($sql);

		$sql = sprintf("SELECT * FROM chartSupplement WHERE navaidName='%s'", $fixData->fixId);

		$fixData->cs = new ChartSupplement($this->sess, $sql);

		array_push($this->fix, $fixData);
	}

	public function GetSingle($i)
	{
		if ($this->fix == null)
		{
			return;
		}

		return $this->fix[$i];
	}

	public function ListEntries()
	{
		if ($this->fix == null)
		{
			return;
		}

		if (count($this->fix) < 2)
		{
			return;
		}

		$str  = sprintf("<table>\r\n");

		$str .= sprintf("<tr><th>Identifier</th>\r\n");
		
		$str .= sprintf("<th>State</th>\r\n");
		
		$str .= sprintf("<th>Region</th></tr>\r\n");

		foreach ($this->fix as $fix)
		{
			$str .= $fix->FormatEntry();
		}

		$str .= sprintf("</table>\r\n");

		return $str;
	}

	public function WaypointInfo()
	{
		if ($this->fix == null)
		{
			return;
		}

		$str = null;

		foreach ($this->fix as $fix)
		{
			$str .= $fix->WaypointInfo();
		}

		return $str;
	}

	public function MapMarkerGoogle()
	{
		if ($this->fix == null)
		{
			return;
		}

		$str = null;

		foreach ($this->fix as $fix)
		{
			$str .= $fix->FormatMarkerGoogle();

		}

		return $str;
	}

	public function MapMarkerBing()
	{
		if ($this->fix == null)
		{
			return;
		}

		$str = null;

		foreach ($this->fix as $fix)
		{
			$str .= $fix->FormatMarkerBing();

		}

		return $str;
	}

	public function DTPPMenu()
	{
		if ($this->fix == null)
		{
			return;
		}

		$str = null;

		foreach ($this->fix as $fix)
		{
			$str .= $fix->FormatDTPPMenu();
		}

		return $str;
	}

	public function FormatXML()
	{
		if ($this->fix == null)
		{
			return;
		}

		$str = null;

		foreach ($this->fix as $fix)
		{
			$str .= sprintf("<fix>");

			$str .= $fix->FormatXML();

			$str .= sprintf("</fix>");
		}

		return $str;
	}
}
?>