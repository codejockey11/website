<?php
class SaaLocationData
{
	public $id;
	public $designator;
	public $name;

	public $saaNote;
	public $saaTimes;
	public $saaGeometry;

	public $sess;

	public $color;

	public function __construct($sess)
	{
		$this->sess = $sess;
	}

	public function FormatList()
	{
		$str = sprintf("<tr><td><a href=\"../saa/index.php?id=%s&d=%s\">%s</a></td><td>%s</td></tr>", $this->sess->sessionId, $this->designator, $this->designator, $this->name);

		return $str;
	}

	public function FormatTimes()
	{
		$str = "";

		if ($this->saaTimes->times)
		{
			foreach($this->saaTimes->times as $tim)
			{
				if ($tim->day)
				{
					switch ($tim->day)
					{
						case 0:
						{
							$str .= sprintf("ANY</br>");

							break;
						}

						case 1:
						{
							$str .= sprintf("SUN ");

							break;
						}

						case 2:
						{
							$str .= sprintf("MON ");

							break;
						}

						case 3:
						{
							$str .= sprintf("TUE ");

							break;
						}

						case 4:
						{
							$str .= sprintf("WED ");

							break;
						}

						case 5:
						{
							$str .= sprintf("THU ");

							break;
						}

						case 6:
						{
							$str .= sprintf("FRI ");

							break;
						}

						case 7:
						{
							$str .= sprintf("SAT ");

							break;
						}

						default:
						{
							$str .= sprintf("%s</br>", $tim->day);

							break;
						}

					}
				}

				if ($tim->startDate)
				{
					$str .= sprintf("%s:%s ", $tim->startDate, $tim->endDate);
				}

				if ($tim->startTime)
				{
					$str .= sprintf("%s:%s</br>", $tim->startTime, $tim->endTime);
				}

				if ($tim->startEvent)
				{
					$str .= sprintf("%s:%s</br>", $tim->startEvent, $tim->endEvent);
				}

			}
		}

		return $str;
	}

	public function FormatBaseInfo()
	{
		$str = sprintf("%s:%s</br>", $this->designator, $this->name);

		$str .= $this->FormatTimes();

		if ($this->saaNote->notes)
		{
			$str .= sprintf("%s</br>", $this->saaNote->notes[0]->note);
		}

		return $str;
	}

	public function FormatNotes()
	{
		$str = sprintf("%s:%s</br>", $this->designator, $this->name);

		if ($this->saaNote->notes)
		{
			$str .= sprintf("%s</br>", $this->saaNote->notes[0]->note);
		}

		return $str;
	}

	public function FormatXML()
	{
		$str = "";

		foreach ($this->saaGeometry->geometry as $geo)
		{
			$str .= sprintf("<airspace>\r\n");

			$str .= sprintf("<designator>%s</designator>\r\n", $geo->designator);

			$str .= sprintf("<type>%s</type>\r\n", $geo->type);

			$str .= sprintf("<sequence>%s</sequence>\r\n", $geo->sequence);

			$str .= sprintf("<count>%s</count>\r\n", $geo->count);

			$str .= sprintf("<latitude>%s</latitude>\r\n", $geo->latitude);

			$str .= sprintf("<longitude>%s</longitude>\r\n", $geo->longitude);

			$str .= sprintf("</airspace>\r\n");
		}

		return $str;
	}

	public function FormatMarkerGoogle()
	{
		$str = "";

		$infoWindow  = "<div class=\"infoboxWeather\">";

		$infoWindow .= sprintf("%s %s", $this->designator, $this->name);

		$infoWindow .= "<div/>";

		$first = true;

		foreach ($this->saaGeometry->geometry as $geo)
		{
			if ($geo->count == "000")
			{
				if ($first)
				{
					$first = false;

					$clat = floatval($geo->latitude);
					$clon = floatval($geo->longitude);
				}
				else
				{
					$str .= sprintf("    line.End();\r\n\r\n");
				}

				$str .= sprintf("    line = new Line(map, false, '%s', 8, '%s');\r\n", $color, $infoWindow);
			}

			$str .= sprintf("    line.AddPoint('', '%0.6f', '%0.6f', '');\r\n", $geo->latitude, $geo->longitude);
		}

		$str .= sprintf("    line.End();\r\n");

		$str .= sprintf("    lineArray.push(line);\r\n\r\n");

		$str .= sprintf("    map.setCenter(new google.maps.LatLng(%0.6f, %0.6f));\r\n", $geo->latitude, $geo->longitude);

		return $str;
	}

	public function FormatMarkerBing()
	{
		$str = "";

		$infoWindow  = "<div class=\"infoboxWeather\">";

		$infoWindow .= sprintf("%s %s", $this->designator, $this->name);

		$infoWindow .= "<div/>";

		$first = true;

		$color = "rgb(100, 0, 0)";

		$prev = null;

		foreach ($this->saaGeometry->geometry as $geo)
		{
			if ($geo->count == "000")
			{
				if ($first)
				{
					$first = false;

					$clat = floatval($geo->latitude);
					$clon = floatval($geo->longitude);
				}
				else
				{
					$str .= sprintf("	line.End();\r\n");

					$str .= sprintf("	lineArray.push(line);\r\n\r\n");
				}

				if ($prev != $geo->designator)
				{
					$color = sprintf("rgb(%s, %s, %s)", rand(0,255), rand(0,255), rand(0,255));

					$prev = $geo->designator;
				}

				$str .= sprintf("	line = new BingLineGAirmet(map, '%s', 8, '%s');\r\n", $color, $infoWindow);
			}

			$str .= sprintf("	line.AddPoint('', %0.6f, %0.6f, '');\r\n", $geo->latitude, $geo->longitude);
		}

		$str .= sprintf("	line.End();\r\n");

		$str .= sprintf("	lineArray.push(line);\r\n\r\n");

		return $str;
	}
}

class SaaLocation
{
	public $sess;
	public $location = array();

	public function __construct($sess, $sql)
	{
		$this->sess = $sess;

		$saaDbase = new Database();

		$saaDbase->ExecSql($sql);

		if ($saaDbase->GetRowCount() > 0)
		{
			while($row = $saaDbase->FetchRow())
			{
				$this->GetRow($row);
			}
		}
		else
		{
			$this->location = null;
		}

		$saaDbase->Disconnect();
	}

	public function GetRow($row)
	{
		$saaLocationData = new SaaLocationData($this->sess);

		$saaLocationData->id = $row["id"];
		$saaLocationData->designator = $row["designator"];
		$saaLocationData->name = $row["name"];

		$saaLocationData->saaNote = new SaaNote($this->sess, $saaLocationData->designator);
		$saaLocationData->saaTimes = new SaaTimes($this->sess, $saaLocationData->designator);
		$saaLocationData->saaGeometry = new SaaGeometry($this->sess, $saaLocationData->designator);

		array_push($this->location, $saaLocationData);
	}

	public function GetSingle($i)
	{
		if ($this->location == null)
		{
			return;
		}

		return $this->location[$i];
	}

	public function ListEntries()
	{
		if ($this->location == null)
		{
			return;
		}

		$str = "<table>";

		$str .= "<th>Designator</th><th>Name</th>";

		foreach($this->location as $loc)
		{
			$str .= $loc->FormatList();
		}

		$str .= "</table>";

		return $str;
	}

	public function ListBaseInfo()
	{
		if ($this->location == null)
		{
			return;
		}

		$str = "<table>";

		foreach($this->location as $loc)
		{
			$str .= "<tr><td>";

			$str .= $loc->FormatNotes();

			$str .= "</td></tr>";
		}

		$str .= "</table>";

		return $str;
	}

	public function DesignatorList()
	{
		if ($this->location == null)
		{
			return;
		}

		$str = "";

		$first = true;

		foreach($this->location as $loc)
		{
			if ($first == true)
			{
				$str .= $loc->designator;

				$first = false;
			}
			else
			{
				$str .= "," . $loc->designator;
			}
		}

		return $str;
	}

	public function FormatXML()
	{
		if ($this->location == null)
		{
			return;
		}

		$str = "";

		foreach($this->location as $loc)
		{
			$str .= $loc->FormatXML();
		}

		return $str;
	}

	public function MapMarkerGoogle()
	{
		if ($this->location == null)
		{
			return;
		}

		$str = "";

		foreach($this->location as $loc)
		{
			$str .= $loc->FormatMarkerGoogle();
		}

		return $str;
	}

	public function MapMarkerBing()
	{
		if ($this->location == null)
		{
			return;
		}

		$str = "";

		foreach($this->location as $loc)
		{
			$str .= $loc->FormatMarkerBing();
		}

		return $str;
	}
}
?>