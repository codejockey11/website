<?php
class IlsMarkerData
{
	public $id;
	public $facilityId;
	public $runway;
	public $type;
	public $status;
	public $distance;
	public $facilityType;
	public $locationIdent;
	public $morse;
	public $name;
	public $freq;
	public $relation;
	public $ndbStatus;
	public $service;

	public $sess;

	public function __construct($sess)
	{
		$this->sess = $sess;
	}

	public function FormatXML()
	{
		$str = sprintf("<marker>");
		
		$str .= sprintf("<key>%s</key>", $this->id);
		
		$str .= sprintf("<type>%s</type>", $this->type);
		
		$str .= sprintf("<name>%s</name>", $this->name);
		
		$str .= sprintf("<locationIdent>%s</locationIdent>", $this->locationIdent);
		
		$str .= sprintf("<freq>%s</freq>", $this->freq);
		
		$str .= sprintf("<morse>%s</morse>", $this->morse);
		
		$str .= sprintf("<icon>../images/ndb.png</icon>");
		
		$str .= sprintf("<status>%s</status>", $this->status);

		$str .= sprintf("</marker>");

		return $str;
	}

	public function FormatEntry()
	{
		$str  = sprintf("<br/>Marker:<br/>%s", $this->runway);
		
		$str .= sprintf(" %s", $this->type);
		
		$str .= sprintf(" %s", $this->status);

		if (is_numeric($this->distance))
		{
			$str .= sprintf(" %1.2fnm", $this->distance / 6076);
		}

		$str .= sprintf(" %s", $this->facilityType);

		if ($this->locationIdent)
		{
			$str .= sprintf("<br/>%s", $this->locationIdent);
			
			$str .= sprintf(" %s", $this->morse);
			
			$str .= sprintf(" %s", $this->name);

			if ($this->freq)
			{
				$str .= sprintf(" %3d", $this->freq);
			}
			else
			{
				$str .= sprintf(" No Frequency");
			}

			$str .= sprintf(" %s", $this->relation);
			
			$str .= sprintf(" %s", $this->ndbStatus);
			
			$str .= sprintf(" %s", $this->service);
		}

		return $str;
	}

	public function FormatFixEntry()
	{
		$str  = sprintf("\r\n<br/>Runway:%s", $this->runway);
		
		$str .= sprintf("\r\n<br/>Type:%s", $this->type);

		if ($this->status == 'OPERATIONAL IFR')
		{
			$str .= sprintf("\r\n<br/>Status:%s", $this->status);
		}
		else
		{
			$str .= sprintf("\r\n<br/>Status:<span class=\"error\">%s</span>\r\n", $this->status);
		}

		if (is_numeric($this->distance))
		{
			$str .= sprintf("\r\n<br/>Distance:%1.2fnm", $this->distance / 6076);
		}

		$str .= sprintf("\r\n<br/>Facility Type:%s", $this->facilityType);

		if ($this->locationIdent)
		{
			$str .= sprintf("\r\n<br/>Local Ident:%s", $this->locationIdent);
			
			$str .= sprintf("\r\n<br/>Morse:%s", $this->morse);
			
			$str .= sprintf("\r\n<br/>Name:%s", $this->name);

			if ($this->freq)
			{
				$str .= sprintf("\r\n<br/>Frequency:%3d", $this->freq);
			}
			else
			{
				$str .= sprintf("\r\n<br/>No Frequency");
			}

			if ($this->relation)
			{
				$str .= sprintf("\r\n<br/>Relation:%s", $this->relation);
			}

			if ($this->ndbStatus)
			{
				$str .= sprintf("\r\n<br/>NDB Status:%s", $this->ndbStatus);
			}

			if ($this->service)
			{
				$str .= sprintf("\r\n<br/>Service:%s", $this->service);
			}
		}

		return $str;
	}

	public function WaypointInfo()
	{
		$str = null;

		if ($this->type == "OM")
		{
			$str .= sprintf("\r\n<br/>%s", $this->facilityId);
			
			$str .= sprintf(" %s", $this->type);
			
			$str .= sprintf(" %s", $this->relation);
			
			$str .= sprintf(" %s", $this->name);

			if ($this->freq)
			{
				$str .= sprintf("<br/>%s", $this->locationIdent);
				
				$str .= sprintf(" %s", $this->freq);
				
				$str .= sprintf(" %s", $this->morse);
			}

			if ($this->sess->remarks)
			{
				$str .= sprintf("\r\n<br/>%s", $this->status);
			}
		}

		return $str;
	}
}

class IlsMarker
{
	public $sess;
	public $marker = array();

	public function __construct($sess, $ident, $rwy)
	{
		$this->sess = $sess;

		if (strlen($ident) < 4)
		{
			$sql = sprintf("SELECT * FROM ilsMarker WHERE facilityId='%s' AND runway='%s'", $ident, $rwy);
		}
		else
		{
			$sql = sprintf("SELECT * FROM ilsMarker WHERE name='%s'", $ident);
		}

		$ilsDbase = new Database();
		
		$ilsDbase->ExecSql($sql);

		if ($ilsDbase->GetRowCount() > 0)
		{
			while($row = $ilsDbase->FetchRow())
			{
				$this->GetRow($row);
			}
		}
		else
		{
			$this->marker = null;
		}

		$ilsDbase->Disconnect();
	}

	public function GetRow($row)
	{
		$ilsMarkerData = new IlsMarkerData($this->sess);

		$ilsMarkerData->id = $row["id"];
		$ilsMarkerData->facilityId = $row["facilityId"];
		$ilsMarkerData->runway = $row["runway"];
		$ilsMarkerData->type = $row["type"];
		$ilsMarkerData->status = $row["status"];
		$ilsMarkerData->distance = $row["distance"];
		$ilsMarkerData->facilityType = $row["facilityType"];
		$ilsMarkerData->locationIdent = $row["locationIdent"];
		$ilsMarkerData->morse = $row["morse"];
		$ilsMarkerData->name = $row["name"];
		$ilsMarkerData->freq = $row["freq"];
		$ilsMarkerData->relation = $row["relation"];
		$ilsMarkerData->ndbStatus = $row["ndbStatus"];
		$ilsMarkerData->service = $row["service"];

		array_push($this->marker, $ilsMarkerData);
	}

	public function GetSingle($i)
	{
		if ($this->marker == null)
		{
			return;
		}

		return $this->marker[$i];
	}

	public function ListEntries()
	{
		if ($this->marker == null)
		{
			return;
		}

		$str = null;

		foreach ($this->marker as $mkr)
		{
			$str .= $mkr->FormatEntry();
		}

		return $str;
	}

	public function ListFixEntries()
	{
		if ($this->marker == null)
		{
			return;
		}

		$str = null;

		foreach ($this->marker as $mkr)
		{
			$str .= $mkr->FormatFixEntry();
		}

		return $str;
	}

	public function WaypointInfo()
	{
		if ($this->marker == null)
		{
			return;
		}

		$str = null;

		foreach ($this->marker as $mkr)
		{
			$str .= $mkr->WaypointInfo();
		}

		return $str;
	}

	public function FormatXML()
	{
		if ($this->marker == null)
		{
			return;
		}

		$str = null;

		foreach ($this->marker as $mkr)
		{
			$str .= $mkr->FormatXML();
		}

		return $str;

	}
}
?>