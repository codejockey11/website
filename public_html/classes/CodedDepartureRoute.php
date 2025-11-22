<?php
class CodedDepatureRouteData
{
	public $id;
	public $origin;
	public $destination;
	public $code;
	public $fixIdent;
	public $waypoints;
	public $artcc;

	public $sess;

	public function __construct($sess)
	{
		$this->sess = $sess;
	}

	public function FormatHeader()
	{
		$str  = sprintf("<tr><th><br/>Origin</th>\r\n");
		
		$str .= sprintf("<th><br/>Dest</th>\r\n");
		
		$str .= sprintf("<th><br/>Code</th>\r\n");
		
		$str .= sprintf("<th>Fix<br/>Ident</th>\r\n");
		
		$str .= sprintf("<th><br/>WayPoints</th>\r\n");
		
		$str .= sprintf("<th><br/>ARTCC</th></tr>\r\n");

		return $str;
	}

	public function FormatEntry()
	{
		$str  = sprintf("<tr><td class=\"listcdr\"><a href=\"../cdr/index.php?id=%s&ident=%s,%s\">%s<a/></td>\r\n", $this->sess->sessionId, $this->origin, $this->destination, $this->origin);

		$str .= sprintf("<td class=\"listcdr\">%s</td>\r\n", $this->destination);
		
		$str .= sprintf("<td class=\"listcdr\">%s</td>\r\n", $this->code);
		
		$str .= sprintf("<td class=\"listcdr\">%s</td>\r\n", $this->fixIdent);
		
		$str .= sprintf("<td class=\"listcdr\">%s</td>\r\n", $this->waypoints);

		$p = new Parameter("center" . $this->artcc);
		
		$str .= sprintf("<td class=\"listcdr\">%s:%s</td></tr>\r\n", $this->artcc, $p->value1);

		return $str;
	}
}

class CodedDepatureRoute
{
	public $sess;
	public $route = array();

	public function __construct($sess, $sql)
	{
		$this->sess = $sess;

		$cdrDbase = new Database();
		
		$cdrDbase->ExecSql($sql);

		if ($cdrDbase->GetRowCount() > 0)
		{
			while($row = $cdrDbase->FetchRow())
			{
				$this->GetRow($row);
			}
		}
		else
		{
			$this->route = null;
		}

		$cdrDbase->Disconnect();
	}

	public function GetRow($row)
	{
		$codedDepatureRouteData = new CodedDepatureRouteData($this->sess);

		$codedDepatureRouteData->id = $row["id"];
		$codedDepatureRouteData->origin = $row["origin"];
		$codedDepatureRouteData->destination = $row["destination"];
		$codedDepatureRouteData->code = $row["code"];
		$codedDepatureRouteData->fixIdent = $row["fixIdent"];
		$codedDepatureRouteData->waypoints = $row["waypoints"];
		$codedDepatureRouteData->artcc = $row["artcc"];

		array_push($this->route, $codedDepatureRouteData);
	}

	public function ListEntries()
	{
		if ($this->route == null)
		{
			return;
		}

		$str  = sprintf("<table>\r\n");

		$str .= $this->route[0]->FormatHeader();

		foreach ($this->route as $rte)
		{
			$str .= $rte->FormatEntry();
		}

		$str .= sprintf("</table>\r\n");

		return $str;
	}
}
?>