<?php
class ChartSupplementData
{
	public $id;
    public $facilityId;
    public $city;
    public $state;
    public $navaidName;
    public $pdf;
	public $zipName;

	public $sess;

	public function __construct($sess)
	{
		$this->sess = $sess;
	}

	public function FormatEntry()
	{
		$fdp = explode('_', $this->pdf);

		$str  = sprintf("<br/>\r\n<a href=\"../dTPPCS/index.php?id=%s&type=cs&pdf=%s_front_%s\">%s Front</a>", $this->sess->sessionId, $fdp[0], $fdp[2], $fdp[0]);

		if ($this->facilityId == null)
		{
			$str .= sprintf("<br/>\r\n<a href=\"../dTPPCS/index.php?id=%s&ident=%s&type=cs&pdf=%s\">%s:%s</a>", $this->sess->sessionId, $this->navaidName, $this->pdf, $this->state, $this->pdf);
		}
		else
		{
			$str .= sprintf("<br/>\r\n<a href=\"../dTPPCS/index.php?id=%s&ident=%s&type=cs&pdf=%s\">%s:%s</a>", $this->sess->sessionId, $this->facilityId, $this->pdf, $this->state, $this->pdf);
		}

		$str .= sprintf("<br/>\r\n<a href=\"../dTPPCS/index.php?id=%s&type=cs&pdf=%s_rear_%s\">%s Rear</a>", $this->sess->sessionId, $fdp[0], $fdp[2], $fdp[0]);

		return $str;
	}

	public function FormatInfobox()
	{
		if ($this->facilityId != null)
		{
			return sprintf("<br/><a href=\"../dTPPCS/index.php?id=%s&ident=%s&type=cs&pdf=%s\">Chart Supplement</a>",  $this->sess->sessionId, $this->facilityId, $this->pdf);
		}

		return sprintf("<br/><a href=\"../dTPPCS/index.php?id=%s&ident=%s&type=cs&pdf=%s\">Chart Supplement</a>",  $this->sess->sessionId, $this->navaidName, $this->pdf);
	}

	public function FormatXML()
	{
		return sprintf("%s", $this->pdf);
	}
}

class ChartSupplement
{
	public $sess;
    public $supplement = array();

    public function __construct($sess, $sql)
    {
		$this->sess = $sess;

		$supDbase = new Database();

		$supDbase->ExecSql($sql);

		if ($supDbase->GetRowCount() > 0)
		{
			while($row = $supDbase->FetchRow())
			{
				$this->GetRow($row);
			}
		}
		else
		{
			$this->supplement = null;
		}

		$supDbase->Disconnect();
	}

    public function GetRow($row)
    {
		$chartSupplementData = new ChartSupplementData($this->sess);

		$chartSupplementData->id = $row["id"];
		$chartSupplementData->facilityId = $row["facilityId"];
		$chartSupplementData->city = $row["city"];
		$chartSupplementData->state = $row["state"];
		$chartSupplementData->navaidName = $row["navaidName"];
		$chartSupplementData->pdf = $row["pdf"];
		$chartSupplementData->zipName = $row["zipName"];

		array_push($this->supplement, $chartSupplementData);
    }

	public function GetSingle($i)
	{
		if ($this->supplement == null)
		{
			return;
		}

		return $this->supplement[$i];
	}

    public function ListEntries($header)
    {
		$str = null;

		if ($header)
		{
			$str .= sprintf("<br/>CHART SUPPLEMENT");

			if ($this->supplement == null)
			{
				$str .= sprintf("<br/>No Documents");

				return $str;
			}
		}

		if ($this->supplement == null)
		{
			return;
		}

		foreach ($this->supplement as $sup)
		{
			$str .= $sup->FormatEntry();
		}

		return $str;
	}

	public function FormatInfobox()
	{
		if ($this->supplement == null)
		{
			return;
		}

		$str = null;

		foreach ($this->supplement as $sup)
		{
			$str .= $sup->FormatInfobox();
		}

		return $str;
	}

	public function GetFirstDocument()
	{
		$doc = null;

		if ($this->supplement)
		{
			$css = $this->GetSingle(0);

			$doc = $css->pdf;
		}

		return $doc;
	}

	public function CheckDocumentCache($doc)
	{
		if (!file_exists("cs/" . $doc))
		{
			if ($this->supplement != null)
			{
				foreach($this->supplement as $sup)
				{
					if (strcmp($sup->pdf, $doc) == 0)
					{
						$dir = $GLOBALS["userProfile"] . "/Downloads/" . $sup->zipName;

						$z = new Zip($this->sess, $dir);

						$z->ExtractEntry($doc, "cs/");

						break;
					}
				}
			}
		}
	}

	public function FormatXML($tag)
	{
		if ($this->supplement == null)
		{
			return;
		}

		$str = null;

		foreach ($this->supplement as $sup)
		{
			$str .= sprintf("<%s>", $tag);

			$str .= $sup->FormatXML();

			$str .= sprintf("</%s>", $tag);
		}

		return $str;
	}
}
?>