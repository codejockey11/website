<?php
class CompareData
{
	public $id;
	public $facilityId;
	public $alnum;
	public $chartCode;
	public $title;
	public $pdf;
	public $zipName;

	public $sess;

	public function __construct($sess)
	{
		$this->sess = $sess;
	}

	public function FormatEntry()
	{
		return sprintf("<br/>\r\n<a href=\"../dTPPCS/index.php?id=%s&ident=%s&type=cmp&pdf=%s\">%s:%s</a>", $this->sess->sessionId, $this->facilityId, $this->pdf, $this->chartCode, $this->title);
	}

	public function FormatInfobox()
	{
		return sprintf("<br/>\r\n<a href=\"../dTPPCS/index.php?id=%s&ident=%s&type=cmp&pdf=%s\">%s:%s</a>", $this->sess->sessionId, $this->facilityId, $this->pdf, $this->chartCode, $this->title);
	}

	public function FormatXML()
	{
		return sprintf("%s~%s~%s", $this->pdf, $this->chartCode, $this->title);
	}
}

class Compares
{
	public $sess;
	public $plate = array();

	public $compares;

	public function __construct($sess, $sql)
	{
		$this->sess = $sess;

		$dtppDbase = new Database();

		$dtppDbase->ExecSql($sql);

		if ($dtppDbase->GetRowCount() > 0)
		{
			while($row = $dtppDbase->FetchRow())
			{
				$this->GetRow($row);
			}
		}
		else
		{
			$this->plate = null;
		}

		$dtppDbase->Disconnect();
	}

	public function GetRow($row)
	{
		$compareData = new CompareData($this->sess);

		$compareData->id = $row["id"];
		$compareData->facilityId = $row["facilityId"];
		$compareData->alnum = $row["alnum"];
		$compareData->chartCode = $row["chartCode"];
		$compareData->title = $row["title"];
		$compareData->pdf = $row["pdf"];
		$compareData->zipName = $row["zipName"];

		array_push($this->plate, $compareData);
	}

	public function GetSingle($i)
	{
		if ($this->plate == null)
		{
			return;
		}

		return $this->plate[$i];
	}

    public function ListEntries($header)
    {
		if ($this->plate == null)
		{
			return;
		}

		$str = null;

		if ($header)
		{
			$str .= sprintf("<br/>CHANGED PROCEDURES");
		}

		foreach ($this->plate as $plt)
		{
			$str .= $plt->FormatEntry();
		}

		return $str;
	}

	public function FormatInfobox()
	{
		if ($this->plate == null)
		{
			return;
		}

		$str = null;

		foreach ($this->plate as $plt)
		{
			$str .= $plt->FormatInfobox();
		}

		return $str;
	}

	public function CheckDocumentCache($doc)
	{
		if (!file_exists("compare_pdf/" . $doc))
		{
			foreach($this->plate as $plt)
			{
				if (strcmp($plt->pdf, $doc) == 0)
				{
					$dir = $GLOBALS["userProfile"] . "/Downloads/" . $plt->zipName;

					$z = new Zip($this->sess, $dir);

					$z->ExtractEntry($doc, "compare_pdf/");

					break;
				}
			}
		}
	}

	public function FormatXML()
	{
		if ($this->plate == null)
		{
			return;
		}

		$str = null;

		foreach ($this->plate as $plt)
		{
			$str .= sprintf("<compares>");

			$str .= $plt->FormatXML();

			$str .= sprintf("</compares>");
		}

		return $str;
	}
}
?>