<?php
class FixNavaidData
{
	public $id;
	public $fixId;
	public $facilityId;
	public $relation;
	public $radialDistance;

	public $navaid;

	public $sess;

	public function __construct($sess)
	{
		$this->sess = $sess;
	}

	public function FormatEntry()
	{
		return sprintf("\r\n<br/>%s %s %s", $this->facilityId, $this->relation, $this->radialDistance);
	}

	public function FormatFixNavaidEntry()
	{
		if ($this->navaid == null)
		{
			return;
		}

		return $this->navaid->ListFixNavaidEntries();
	}

	public function WaypointInfo()
	{
		if ($this->sess->rnav)
		{
			return;
		}

		$str = null;

		if ($this->radialDistance)
		{
			$str .= sprintf("\r\n<br/>%s %s", $this->facilityId, $this->radialDistance);
		}

		if ($this->navaid)
		{
			$str .= sprintf("\r\n<br/>");

			$str .= $this->navaid->WaypointInfo();
		}

		return $str;
	}

	public function FormatXML()
	{
		$str = sprintf("<fixNavaidInfo>%s %s %s</fixNavaidInfo>", $this->facilityId, $this->relation, $this->radialDistance);

		return $str;
	}
}

class FixNavaid
{
	public $sess;
	public $navaid = array();

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
			$this->navaid = null;
		}

		$fixDbase->Disconnect();
	}

	public function GetRow($row)
	{
		$fixNavaidData = new FixNavaidData($this->sess);

		$fixNavaidData->id = $row["id"];
		$fixNavaidData->fixId = $row["fixId"];
		$fixNavaidData->facilityId = $row["facilityId"];
		$fixNavaidData->relation = $row["relation"];
		$fixNavaidData->radialDistance = $row["radialDistance"];

		if (strlen($fixNavaidData->facilityId) > 2)
		{
			$sql = sprintf("SELECT * FROM navNavaid WHERE facilityId='%s' AND type!='VOT'", $fixNavaidData->facilityId);

			$fixNavaidData->navaid = new Navaid($this->sess, $sql);
		}
		else
		{
			$sql = sprintf("SELECT * FROM navNavaid WHERE facilityId='%s' AND type!='VOT'", $fixNavaidData->fixId);

			$fixNavaidData->navaid = new Navaid($this->sess, $sql);
		}

		array_push($this->navaid, $fixNavaidData);
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

	public function ListEntries()
	{
		if ($this->navaid == null)
		{
			return;
		}

		$str = null;

		foreach ($this->navaid as $nav)
		{
			$str .= $nav->FormatEntry();
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

		$col = 1;

		$firstOne = true;

		foreach ($this->navaid as $nav)
		{
			if ($col == 1)
			{
				$str .= sprintf("<tr>\r\n");
			}

			if ($col == 4)
			{
				$str .= sprintf("</tr>\r\n");

				$str .= sprintf("<tr>\r\n");
			}

			if ($col == 7)
			{
				$str .= sprintf("</tr>\r\n");

				$str .= sprintf("<tr>\r\n");
			}

			$str .= sprintf("<td>\r\n");

			if ($firstOne)
			{
				$str .= sprintf("<b>NAVAID</b>\r\n");

				$firstOne = false;
			}

			$str .= $nav->FormatFixNavaidEntry();

			$str .= sprintf("</td>\r\n");

			$col++;
		}

		$str .= sprintf("</tr>\r\n");

		return $str;
	}

	public function FormatXML()
	{
		if ($this->navaid == null)
		{
			return sprintf("<fixNavaid></fixNavaid>");
		}

		$str = sprintf("<fixNavaid>");

		foreach ($this->navaid as $nav)
		{
			$str .= $nav->FormatXML();
		}

		foreach ($this->navaid as $nav)
		{
			$str .= $nav->navaid->FormatXML(true);
		}

		$str .= sprintf("</fixNavaid>");

		return $str;
	}
}
?>