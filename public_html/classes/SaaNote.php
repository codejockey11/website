<?php
class SaaNoteData
{
	public $id;
	public $designator;
	public $note;

	public $sess;

	public function __construct($sess)
	{
		$this->sess = $sess;
	}

}

class SaaNote
{
	public $sess;
	public $notes = array();

	public function __construct($sess, $name)
	{
		$this->sess = $sess;
		
		$sql = null;

		if ($name)
		{
			$sql = sprintf("SELECT * FROM saaNote WHERE designator='%s'", $name);
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
			$this->note = null;
		}

		$saaDbase->Disconnect();
	}

	public function GetRow($row)
	{
		$saaNoteData = new SaaNoteData($this->sess);

		$saaNoteData->id = $row["id"];
		$saaNoteData->designator = $row["designator"];
		$saaNoteData->note = $row["note"];

		array_push($this->notes, $saaNoteData);
	}

}
?>