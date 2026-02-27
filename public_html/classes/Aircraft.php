<?php
class AircraftData
{
	public $holder;
	public $model;
	public $TCDS;

	public function FormatEntry()
	{
		$str = sprintf("<td>%s</td><td>%s</td><td>%s</td>\r\n", $this->holder, $this->model, $this->TCDS);

		return $str;
	}
}

class Aircraft
{
	public $aircraft = array();
	public $foundModel = false;

	public function __construct($sql)
	{
		$aircraftDbase = new Database();

		$aircraftDbase->ExecSql($sql);

		if ($aircraftDbase->GetRowCount() > 0)
		{
			while($row = $aircraftDbase->FetchRow())
			{
				$this->GetRow($row);
			}
		}
		else
		{
			$this->aircraft = null;
		}

		$aircraftDbase->Disconnect();
	}

	public function GetRow($row)
	{
		$aircraftData = new AircraftData();

		$aircraftData->holder = $row["holder"];
		$aircraftData->model = $row["model"];
		$aircraftData->TCDS = $row["TCDS"];

		array_push($this->aircraft, $aircraftData);
	}

	public function GetSingle($i)
	{
		if ($this->aircraft == null)
		{
			return;
		}

		return $this->aircraft[$i];
	}

	public function ListEntries($wh)
	{
		if ($this->aircraft == null)
		{
			return;
		}

		$str = "<table>";

		if ($wh == true)
		{
			$str .= "<th>Holder</th><th>Model</th><th>TCDS</th>\r\n";
		}

		foreach ($this->aircraft as $acft)
		{
			$str .= "<tr>";

			$str .= $acft->FormatEntry();

			$str .= "</tr>";
		}

		$str .= "</table>";

		return $str;
	}

	public function LoadHolders()
	{
		$this->aircraft = array();

		$sql = sprintf("SELECT DISTINCT holder FROM aircraft ORDER BY holder");

		$aircraftDbase = new Database();

		$aircraftDbase->ExecSql($sql);

		if ($aircraftDbase->GetRowCount() > 0)
		{
			while($row = $aircraftDbase->FetchRow())
			{
				$aircraftData = new AircraftData();

				$aircraftData->holder = $row["holder"];

				array_push($this->aircraft, $aircraftData);
			}
		}
		else
		{
			$this->aircraft = null;
		}

		$aircraftDbase->Disconnect();
	}

	public function HolderDropdown($i)
	{
		if ($this->aircraft == null)
		{
			return;
		}

		$str = sprintf("<select name=\"holderSelect\" id=\"holderSelect\" onfocus=\"this.selectedIndex = 0;\" onchange=\"DoHttpRequestModels();\">\r\n", $i);

		foreach ($this->aircraft as $acft)
		{
			if (strcmp($i, $acft->holder) == 0)
			{
				$str .= sprintf("<option selected value=\"%s\">%s</option>\r\n", $acft->holder, $acft->holder);
			}
			else
			{
				$str .= sprintf("<option value=\"%s\">%s</option>\r\n", $acft->holder, $acft->holder);
			}
		}

		$str .= sprintf("</select>\r\n");

		return $str;
	}

	public function LoadModels($s)
	{
		$this->aircraft = array();

		$sql = sprintf("SELECT DISTINCT model FROM aircraft WHERE holder='%s' ORDER BY model", $s);

		$aircraftDbase = new Database();

		$aircraftDbase->ExecSql($sql);

		if ($aircraftDbase->GetRowCount() > 0)
		{
			while($row = $aircraftDbase->FetchRow())
			{
				$aircraftData = new AircraftData();

				$aircraftData->model = $row["model"];

				array_push($this->aircraft, $aircraftData);
			}
		}
		else
		{
			$this->aircraft = null;
		}

		$aircraftDbase->Disconnect();
	}

	public function ModelDropdown($c)
	{
		if ($this->aircraft == null)
		{
			return;
		}

		$this->foundModel = false;

		$str = sprintf("<select name=\"modelSelect\" id=\"modelSelect\" onfocus=\"this.selectedIndex = 0;\">\r\n");

		$str .= sprintf("<option value=\"\">Model</option>\r\n");

		foreach ($this->aircraft as $acft)
		{
			if (strcmp($c, $acft->model) == 0)
			{
				$str .= sprintf("<option selected value=\"%s\">%s</option>\r\n", $acft->model, $acft->model);

				$this->foundModel = true;
			}
			else
			{
				$str .= sprintf("<option value=\"%s\">%s</option>\r\n", $acft->model, $acft->model);
			}
		}

		$str .= sprintf("</select>\r\n");

		return $str;
	}

	public function ListModelsXML()
	{
		if ($this->aircraft == null)
		{
			return;
		}

		$str = null;

		foreach ($this->aircraft as $acft)
		{
			$str .= "<model>\r\n";

			$str .= sprintf("<name>%s</name>\r\n", $acft->model);

			$str .= "</model>\r\n";
		}

		return $str;
	}
}
?>