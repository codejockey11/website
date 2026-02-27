<?php
class RcoData
{
	public $id;
	public $facilityId;
	public $type;
	public $navaid;
	public $radioCall;
	public $fssIdent;
	public $freq;

	public function WaypointInfo()
	{
		$str  = sprintf("\r\n<br/>%s", $this->type);
		
		$str .= sprintf(" %s", $this->fssIdent);
		
		// frequency as string because it might be a "R"eceive only
		$str .= sprintf(" %s", $this->freq);

		return $str;
	}

	public function FixNavaidEntry()
	{
		$str  = sprintf("\r\n<br/>%s", $this->type);
		
		$str .= sprintf(" FSS:%s %s", $this->fssIdent, $this->freq);

		return $str;
	}

	public function FormatEntry()
	{
		$str = sprintf("Type:%s", $this->type);

		if ($this->navaid)
		{
			$str .= sprintf("\r\n<br/>Navaid:%s", $this->navaid);
		}

		if ($this->radioCall)
		{
			$str .= sprintf("\r\n<br/>Radio Call:%s", $this->radioCall);
		}

		$str .= sprintf("\r\n<br/>FSS Ident:%s", $this->fssIdent);
		
		$str .= sprintf("\r\n<br/>Frequency:%s", $this->freq);

		return $str;
	}
	
	public function FormatAirportEntry()
	{
		$str = sprintf("\r\n<br/>%s:%s", $this->type, $this->freq);

		return $str;
	}
}

class Rco
{
	public $sess;
	public $rco = array();

	public function __construct($sess, $sql)
	{
		$this->sess = $sess;
		
		$comDbase = new Database();
		
		$comDbase->ExecSql($sql);

		if ($comDbase->GetRowCount() > 0)
		{
			while($row = $comDbase->FetchRow())
			{
				$this->GetRow($row);
			}
		}
		else
		{
			$this->rco = null;
		}

		$comDbase->Disconnect();
	}

	public function GetRow($row)
	{
		$rcoData = new RcoData($this->sess);

		$rcoData->id = $row["id"];
		$rcoData->facilityId = $row["facilityId"];
		$rcoData->type = $row["type"];
		$rcoData->navaid = $row["navaid"];
		$rcoData->radioCall = $row["radioCall"];
		$rcoData->fssIdent = $row["fssIdent"];
		$rcoData->freq = $row["freq"];

		array_push($this->rco, $rcoData);
	}

	public function WaypointInfo()
	{
		if ($this->rco == null)
		{
			return;
		}

		$str = null;

		foreach ($this->rco as $rco)
		{
			$str .= $rco->WaypointInfo();
		}

		return $str;
	}

	public function FormatFixNavaidEntry()
	{
		if ($this->rco == null)
		{
			return;
		}

		$str = "\r\n<br/>";

		foreach ($this->rco as $rco)
		{
			$str .= $rco->FixNavaidEntry();
		}

		return $str;
	}

	public function ListEntries()
	{
		if ($this->rco == null)
		{
			return;
		}

		$str = null;

		foreach ($this->rco as $rco)
		{
			$str .= $rco->FormatEntry();
		}

		return $str;
	}

	public function ListAirportEntries()
	{
		if ($this->rco == null)
		{
			return;
		}

		$str = null;

		foreach ($this->rco as $rco)
		{
			$str .= $rco->FormatAirportEntry();
		}

		return $str;
	}

	public function FormatNavaidEntries()
	{
		if ($this->rco == null)
		{
			return;
		}

		$str = null;
		
		$col = 0;

		foreach ($this->rco as $rco)
		{
			if ($col == 0)
			{
				$str .= sprintf("<td>\r\n");
				
				$str .= sprintf("<b>COMMS</b><br/>\r\n");
			}

			if ($col == 3)
			{
				$str .= sprintf("</td>\r\n");
				
				$str .= sprintf("<td>\r\n");
				
				$str .= sprintf("\r\n<br/>");
			}

			if ($col == 6)
			{
				$str .= sprintf("</td>\r\n");
				
				$str .= sprintf("<td>\r\n");
				
				$str .= sprintf("\r\n<br/>");
			}

			if ($col == 9)
			{
				$str .= sprintf("</td>\r\n");
				
				$str .= sprintf("<td>\r\n");
				
				$str .= sprintf("\r\n<br/>");
			}

			$str .= $rco->FormatEntry();

			$str .= sprintf("\r\n<br/><br/>\r\n");

			$col++;
		}

		$str .= sprintf("</td>\r\n");

		return $str;
	}
}
?>