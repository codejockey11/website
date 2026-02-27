<?php
class PreferredRouteData
{
	public $id;
	public $depart;
	public $arrive;
	public $type;
	public $dp;
	public $waypoints;
	public $star;

	public $sess;

	public function __construct($sess)
	{
		$this->sess = $sess;
	}

	public function FormatEntry()
	{
		$str  = sprintf("<tr><td><a href=\"../preferred/index.php?id=%s&dep=%s&arr=%s\">%s</td>\r\n", $this->sess->sessionId, $this->depart, $this->arrive, $this->depart);
		
		$str .= sprintf("<td>%s</td>\r\n", $this->arrive);

		$p = new parameter("preferred" . $this->type);
		
		$str .= sprintf("<td>%s</td>\r\n", $p->value1);

		$str .= sprintf("<td>%s</td>\r\n", $this->dp);
		
		$str .= sprintf("<td>%s</td>\r\n", $this->waypoints);
		
		$str .= sprintf("<td><a href=\"../starDp/index.php?id=%s&wp=%s\">%s</td></tr>\r\n", $this->sess->sessionId, $this->star, $this->star);

		return $str;
	}
}

class PreferredRoute
{
	public $sess;
	public $route = array();

	public function __construct($sess, $sql)
	{
		$this->sess = $sess;

		$pfrDbase = new Database();
		
		$pfrDbase->ExecSql($sql);

		if ($pfrDbase->GetRowCount() > 0)
		{
			while($row = $pfrDbase->FetchRow())
			{
				$this->GetRow($row);
			}
		}
		else
		{
			$this->route = null;
		}

		$pfrDbase->Disconnect();
	}

	public function GetRow($row)
	{
		$preferredRouteData = new PreferredRouteData($this->sess);

		$preferredRouteData->id = $row["id"];
		$preferredRouteData->depart = $row["depart"];
		$preferredRouteData->arrive = $row["arrive"];
		$preferredRouteData->type = $row["type"];
		$preferredRouteData->dp = $row["dp"];
		$preferredRouteData->waypoints = $row["waypoints"];
		$preferredRouteData->star = $row["star"];

		array_push($this->route, $preferredRouteData);
	}

	public function ListEntries()
	{
		if ($this->route == null)
		{
			return;
		}

		$str = sprintf("<table>\r\n");

		$str .= sprintf("<tr><th>Departure</th>\r\n");
		$str .= sprintf("<th>Arrival</th>\r\n");
		$str .= sprintf("<th>Type</th>\r\n");
		$str .= sprintf("<th>DP Ident</th>\r\n");
		$str .= sprintf("<th>Waypoints</th>\r\n");
		$str .= sprintf("<th>STAR Ident</th></tr>\r\n");

		foreach ($this->route as $rte)
		{
			$str .= $rte->FormatEntry();
		}

		$str .= sprintf("</table>\r\n");

		return $str;
	}
}
?>