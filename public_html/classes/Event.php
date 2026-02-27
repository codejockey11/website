<?php
class EventData
{
	public $eventDate;
	public $eventTime;
	public $title;
	public $description;
}

class Event
{
	public $event = array();

	public function __construct($date)
	{
		if ($date == null)
		{
			return;
		}

		$sql = sprintf("SELECT * FROM calevent WHERE eventDate='%s'", $date);

		$eventDbase = new Database();
		
		$eventDbase->ExecSql($sql);

		if ($eventDbase->GetRowCount() > 0)
		{
			while($row = $eventDbase->FetchRow())
			{
				$this->GetRow($row);
			}
		}
		else
		{
			$this->event = null;
		}

		$eventDbase->Disconnect();
	}

	public function GetRow($row)
	{
		$eventData = new EventData();

		$eventData->eventDate = $row[0];
		$eventData->eventTime = $row[1];
		$eventData->title = $row[2];
		$eventData->description = $row[3];

		array_push($this->event, $eventData);
	}

	public function GetYearMonthEvents($date)
	{
		$sql = sprintf("SELECT * FROM calevent WHERE eventDate>='%s00' AND eventDate<='%s99'", $date, $date);

		$eventDbase = new Database();
		
		$eventDbase->ExecSql($sql);

		if ($eventDbase->GetRowCount() > 0)
		{
			while($row = $eventDbase->FetchRow())
			{
				$this->GetRow($row);
			}
		}

		$eventDbase->Disconnect();
	}

	public function GetDateTimeEvent($date, $time)
	{
		$sql = sprintf("SELECT * FROM calevent WHERE eventDate='%s' AND eventTime='%s'", $date, $time);

		$eventDbase = new Database();
		
		$eventDbase->ExecSql($sql);

		if ($eventDbase->GetRowCount() > 0)
		{
			while($row = $eventDbase->FetchRow())
			{
				$this->GetRow($row);
			}
		}

		$eventDbase->Disconnect();
	}

	public function UpdateAddEvent($date, $time, $title, $desc)
	{
		$sql = sprintf("INSERT INTO calevent (eventDate, eventTime, title, description) VALUES ('%s','%s','%s','%s')", $date, $time, addslashes($title), addslashes($desc));

		$eventDbase = new Database();
		
		$eventDbase->ExecSql($sql);
		
		$eventDbase->Disconnect();
	}

	public function UpdateChangeEvent($title, $desc, $date, $time)
	{
		$sql = sprintf("UPDATE calevent SET title='%s', description='%s' WHERE eventDate='%s' AND eventTime='%s'", addslashes($title), addslashes($desc), $date, $time);

		$eventDbase = new Database();
		
		$eventDbase->ExecSql($sql);
		
		$eventDbase->Disconnect();
	}

	public function UpdateDeleteEvent($date, $time)
	{
		$sql = sprintf("DELETE from calevent WHERE eventDate='%s' AND eventTime='%s'", $date, $time);

		$eventDbase = new Database();
		
		$eventDbase->ExecSql($sql);
		
		$eventDbase->Disconnect();
	}
}
?>