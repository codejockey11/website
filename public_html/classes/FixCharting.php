<?php
class FixChartingData
{
	public $id;
	public $fixId;
	public $chart;

	public function FormatEntry()
	{
		return sprintf("\r\n<br/>%s", $this->chart);
	}

	public function WaypointInfo()
	{
		return sprintf("\r\n<br/>%s ", $this->chart);
	}
}

class FixCharting
{
	public $chart = array();

	public function __construct($sql)
	{
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
			$this->chart = null;
		}

		$fixDbase->Disconnect();
	}

	public function GetRow($row)
	{
		$fixChartingData = new FixChartingData();

		$fixChartingData->id = $row["id"];
		$fixChartingData->fixId = $row["fixId"];
		$fixChartingData->chart = $row["chart"];

		array_push($this->chart, $fixChartingData);
	}

	public function ListEntries()
	{
		if ($this->chart == null)
		{
			return;
		}

		$str = null;

		foreach ($this->chart as $chr)
		{
			$str .= $chr->FormatEntry();
		}

		return $str;
	}

	public function WaypointInfo()
	{
		if ($this->chart == null)
		{
			return;
		}

		$str = null;

		foreach ($this->chart as $chr)
		{
			$str .= $chr->WaypointInfo();
		}

		return $str;
	}
}
?>