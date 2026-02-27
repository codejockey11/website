<?php
class AirportListData
{
	public $id;
	public $facilityId;
	public $type;
	public $state;
	public $city;
	public $name;
	public $runwayId;
	public $length;
	public $width;
	public $surface;

	public $sess;

	public function __construct($sess)
	{
		$this->sess = $sess;
	}

	function FormatAirport()
	{
		$str  = sprintf("<tr><td><a href=\"../airport/index.php?id=%s&key=%s\">%s</a></td>\r\n", $this->sess->sessionId, $this->id, $this->facilityId);

		$str .= sprintf("<td>%s</td>\r\n", $this->name);

		$str .= sprintf("<td>%s, %s</td>\r\n", $this->city, $this->state);

		$str .= sprintf("</tr>\r\n");

		return $str;
	}

	function FormatRunway()
	{
		$str  = sprintf("<tr><td colspan=\"2\">%s %s %s %s</td></tr>\r\n", $this->runwayId, $this->length, $this->width, $this->surface);

		return $str;
	}
}

class AirportList
{
	public $airport = array();
	public $sess;

	public function __construct($sess, $sql)
	{
		$this->sess = $sess;

		$aptDbase = new Database();

		$aptDbase->ExecSql($sql);

		if ($aptDbase->GetRowCount() > 0)
		{
			while($row = $aptDbase->FetchRow())
			{
				$this->GetRow($row);
			}
		}
		else
		{
			$this->airport = null;
		}

		$aptDbase->Disconnect();
	}

	public function GetRow($row)
	{
		$airportListData = new AirportListData($this->sess);

		$airportListData->id = $row["id"];
		$airportListData->facilityId = $row["facilityId"];
		$airportListData->type = $row["type"];
		$airportListData->state = $row["state"];
		$airportListData->city = $row["city"];
		$airportListData->name = htmlspecialchars($row["name"], ENT_QUOTES);
		$airportListData->runwayId = $row["runwayId"];
		$airportListData->length = $row["length"];
		$airportListData->width = $row["width"];
		$airportListData->surface = $row["surface"];

		array_push($this->airport, $airportListData);
	}

	public function GetSingle($i)
	{
		if ($this->airport == null)
		{
			return;
		}

		return $this->airport[$i];
	}

	public function ListEntries()
	{
		if ($this->airport == null)
		{
			return;
		}

		$str  = sprintf("<table>\r\n");

		$str .= sprintf("<tr><th>Facility</th>\r\n");

		$str .= sprintf("<th>Name</th>\r\n");

		$str .= sprintf("<th>City, State</th></tr>\r\n");

		$prev = null;
		$first = true;
	
		foreach ($this->airport as $apt)
		{
			if ($prev != $apt->facilityId)
			{
				if ($first == true)
				{
					$first = false;
				}
				else
				{
					$str .= sprintf("<tr><td>&nbsp;</td></tr>");
				}

				$str .= $apt->FormatAirport();

				$prev = $apt->facilityId;
			}

			$str .= $apt->FormatRunway();
		}

		$str .= sprintf("</table>\r\n");

		return $str;
	}
}
?>