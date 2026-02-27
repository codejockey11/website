<?php
class SaaTimesData
{
	public $id;
	public $designator;
	public $startDate;
	public $endDate;
	public $startTime;
	public $endTime;
	public $day;
	public $startEvent;
	public $endEvent;

	public $sess;

	public function __construct($sess)
	{
		$this->sess = $sess;
	}
	
}

class SaaTimes
{
	public $sess;
	public $times = array();

	public function __construct($sess, $name)
	{
		$this->sess = $sess;
		
		$sql = null;

		if ($name)
		{
			$sql = sprintf("SELECT * FROM saaTimes WHERE designator='%s' ORDER BY day", $name);
		}

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
			$this->times = null;
		}

		$saaDbase->Disconnect();
	}

	public function GetRow($row)
	{
		$saaTimesData = new SaaTimesData($this->sess);

		$saaTimesData->id = $row["id"];
		$saaTimesData->designator = $row["designator"];
		$saaTimesData->startDate = $row["startDate"];
		$saaTimesData->endDate = $row["endDate"];
		$saaTimesData->startTime = $row["startTime"];
		$saaTimesData->endTime = $row["endTime"];
		$saaTimesData->day = $row["day"];
		$saaTimesData->startEvent = $row["startEvent"];
		$saaTimesData->endEvent = $row["endEvent"];

		array_push($this->times, $saaTimesData);
	}

}
?>