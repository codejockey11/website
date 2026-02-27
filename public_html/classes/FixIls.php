<?php
class FixIlsData
{
	public $id;
	public $fixId;
	public $facilityId;
	public $relation;
	public $radialDistance;

	public $ilsMarker;
	public $navaid;

	public $sess;

	public function __construct($sess)
	{
		$this->sess = $sess;
	}

	public function WaypointInfo()
	{
		if ($this->ilsMarker == null)
		{
			return;
		}

		return $this->ilsMarker->WaypointInfo();
	}

	public function FormatEntry()
	{
		$str = sprintf("Facility:%s", $this->facilityId);

		$p = new Parameter("ilsTypeCode" . $this->relation);

		$str .= sprintf("\r\n<br/>Relation:%s %s", $this->relation, $p->value1);

		$str .= sprintf("\r\n<br/>Heading/Distance:%s", $this->radialDistance);

		if ($this->ilsMarker)
		{
			$str .= $this->ilsMarker->ListFixEntries();
		}

		if ($this->navaid)
		{
			$str .= $this->navaid->ListFixIlsNavaidEntries();
		}

		return $str;
	}

	public function FormatXML()
	{
		if ($this->ilsMarker == null)
		{
			return;
		}

		return $this->ilsMarker->FormatXML();
	}
}

class FixIls
{
	public $sess;
	public $fixIls = array();

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
			$this->fixIls = null;
		}

		$fixDbase->Disconnect();
	}

	public function GetRow($row)
	{
		$fixIlsData = new FixIlsData($this->sess);

		$fixIlsData->id = $row["id"];
		$fixIlsData->fixId = $row["fixId"];
		$fixIlsData->facilityId = $row["facilityId"];
		$fixIlsData->relation = $row["relation"];
		$fixIlsData->radialDistance = $row["radialDistance"];

		$fixIlsData->ilsMarker = new IlsMarker($this->sess, $fixIlsData->fixId, null);

		// if the marker is operational grab its navaid information
		$mkr = $fixIlsData->ilsMarker->GetSingle(0);

		if ($mkr)
		{
			$sql = sprintf("SELECT * FROM navNavaid WHERE facilityId='%s' AND name='%s' AND type!='VOT'", $mkr->locationIdent, $mkr->name);

			$fixIlsData->navaid = new Navaid($this->sess, $sql);
		}

		array_push($this->fixIls, $fixIlsData);
	}

	public function WaypointInfo()
	{
		if ($this->fixIls == null)
		{
			return;
		}

		$str = null;

		foreach ($this->fixIls as $ils)
		{
			$str .= $ils->WaypointInfo();
		}

		return $str;
	}

	public function ListEntries()
	{
		if ($this->fixIls == null)
		{
			return;
		}

		$str = null;

		foreach ($this->fixIls as $ils)
		{
			$str .= $ils->FormatEntry();
		}

		return $str;
	}

	public function FormatXML()
	{
		if ($this->fixIls == null)
		{
			return;
		}

		$str = null;

		foreach ($this->fixIls as $ils)
		{
			$str .= $ils->FormatXML();
		}

		return $str;
	}
}
?>