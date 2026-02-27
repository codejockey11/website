<?php
class StarDpData
{
	public $id;
	public $type;
	public $shortName;
	public $ident;
	public $transition;
	public $computerCode;
	public $waypoints;
	public $airports;

	public $sess;

	public function __construct($sess)
	{
		$this->sess = $sess;
	}

	public function FormatEntry()
	{
		$str  = sprintf("<tr><td>%s</td>\r\n", $this->type);

		$str .= sprintf("<td><a href=\"../starDp/index.php?id=%s&shortName=%s\">%s</a></td>\r\n", $this->sess->sessionId, $this->shortName, $this->shortName);
		
		$str .= sprintf("<td>%s</td>\r\n", $this->ident);
		
		$str .= sprintf("<td>%s</td>\r\n", $this->transition);
		
		$str .= sprintf("<td>%s</td>\r\n", $this->computerCode);
		
		$str .= sprintf("<td style=\"max-width:400px;\">%s</td>\r\n", $this->waypoints);
		
		$str .= sprintf("<td>%s</td></tr>\r\n", $this->airports);

		return $str;
	}
}

class StarDp
{
	public $sess;
	public $starDp = array();

	public function __construct($sess, $sql)
	{
		$this->sess = $sess;

		$starDpDbase = new Database();
		
		$starDpDbase->ExecSql($sql);

		if ($starDpDbase->GetRowCount() > 0)
		{
			while($row = $starDpDbase->FetchRow())
			{
				$this->GetRow($row);
			}
		}
		else
		{
			$this->starDp = null;
		}

		$starDpDbase->Disconnect();
	}

	public function GetRow($row)
	{
		$starDpData = new StarDpData($this->sess);

		$starDpData->id = $row["id"];
		$starDpData->type = $row["type"];
		$starDpData->shortName = $row["shortName"];
		$starDpData->ident = $row["ident"];
		$starDpData->transition = $row["transition"];
		$starDpData->computerCode = $row["computerCode"];
		$starDpData->waypoints = $row["waypoints"];
		$starDpData->airports = $row["airports"];

		array_push($this->starDp, $starDpData);
	}

	public function GetSingle($i)
	{
		if ($this->starDp == null)
		{
			return;
		}

		return $this->starDp[$i];
	}

	public function ListEntries()
	{
		if ($this->starDp == null)
		{
			return;
		}

		$str  = sprintf("<table>\r\n");

		$str .= sprintf("<tr><th>Type</th>\r\n");
		
		$str .= sprintf("<th>Short Name</th>\r\n");
		
		$str .= sprintf("<th>Ident</th>\r\n");
		
		$str .= sprintf("<th>Transition</th>\r\n");
		
		$str .= sprintf("<th>Computer Code</th>\r\n");
		
		$str .= sprintf("<th>Waypoints</th>\r\n");
		
		$str .= sprintf("<th>Associated Airports</th></tr>\r\n");

		$prevType = $this->starDp[0]->type;

		foreach ($this->starDp as $sdp)
		{
			if ($sdp->type != $prevType)
			{
				$prevType = $sdp->type;

				$str .= "<tr><td colspan=\"7\">&nbsp;</td></tr>";
			}

			$str .= $sdp->FormatEntry();
		}

		$str .= sprintf("</table>\r\n");

		return $str;
	}
}
?>