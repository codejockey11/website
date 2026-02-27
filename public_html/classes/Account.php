<?php
class Account
{
	public $pilotId;
	public $pilotPassword;
	public $email;
	public $firstName;
	public $lastName;
	public $homeBase;
	public $homeLatLon;
	public $showHeliport;
	public $showFrequency;
	public $ts;
	public $accessCount;

	public function __construct($pi, $pw, $was)
	{
		$sql = sprintf("SELECT * FROM account WHERE pilotId='%s'", $pi);

		$accountDbase = new Database();

		$accountDbase->ExecSql($sql);

		if ($accountDbase->GetRowCount() > 0)
		{
			$this->GetRow($accountDbase->FetchRow());
		}

		if ($pw)
		{
			if ($was)
			{
				if ($this->pilotPassword == $was)
				{
				}
			}
			else //if (password_verify($pw, $this->pilotPassword))
			{
				$sql = sprintf("SELECT SHA2('%s', 256)", $pw);

				$sha2Dbase = new Database();

				$sha2Dbase->ExecSql($sql);

				$row = $sha2Dbase->FetchRowNumeric();

				$sha2Dbase->Disconnect();

				if ($row[0] != $this->pilotPassword)
				{
					$accountDbase->Disconnect();

					$this->pilotId = null;
					$this->pilotPassword = null;
					$this->email = null;
					$this->firstName = null;
					$this->lastName = null;
					$this->homeBase = null;
					$this->homeLatLon = null;
					$this->showHeliport = null;
					$this->showFrequency = null;
					$this->ts = null;
					$this->accessCount = null;

					return;
				}
			}
		}

		$accountDbase->Disconnect();

		if ($this->pilotId)
		{
			$this->UpdateAccount($this->pilotId, $this->pilotPassword, $this->email, $this->firstName, $this->lastName, $this->homeBase, $this->homeLatLon, $this->showHeliport, $this->showFrequency);
		}
	}

	public function GetRow($row)
	{
		$this->pilotId = $row["pilotId"];
		$this->pilotPassword = $row["pilotPassword"];
		$this->email = $row["email"];
		$this->firstName = $row["firstName"];
		$this->lastName = $row["lastName"];
		$this->homeBase = $row["homeBase"];
		$this->homeLatLon = $row["homeLatLon"];
		$this->showHeliport = $row["showHeliport"];
		$this->showFrequency = $row["showFrequency"];
		$this->ts = $row["ts"];
		$this->accessCount = $row["accessCount"];
	}

	public function CheckPilotId($pi)
	{
		$sql = sprintf("SELECT * FROM account WHERE pilotId='%s'", $pi);

		$accountDbase = new Database();

		$accountDbase->ExecSql($sql);

		if ($accountDbase->GetRowCount() > 0)
		{
			$row = $accountDbase->FetchRow();

			$this->GetRow($row);
		}

		$accountDbase->Disconnect();
	}

	public function GetAccountByEmail($e)
	{
		$sql = sprintf("SELECT * FROM account WHERE email='%s'", $e);

		$accountDbase = new Database();

		$accountDbase->ExecSql($sql);

		if ($accountDbase->GetRowCount() > 0)
		{
			$row = $accountDbase->FetchRow();

			$this->GetRow($row);
		}

		$accountDbase->Disconnect();
	}

	public function AddAccount($pi, $pw, $e, $fn, $ln, $hb, $hll, $sh, $sf)
	{
		//$pw = password_hash($pw, PASSWORD_DEFAULT);

		$sql = sprintf("SELECT SHA2('%s', 256)", $pw);

		$sha2Dbase = new Database();

		$sha2Dbase->ExecSql($sql);

		$row = $sha2Dbase->FetchRowNumeric();

		$pw = $row[0];

		$sha2Dbase->Disconnect();

		$sql = sprintf("INSERT INTO account (pilotId, pilotPassword, email, firstName, lastName, homeBase, homeLatLon, showHeliport, showFrequency) VALUES ('%s','%s','%s','%s','%s','%s','%s','%s','%s')",
			$pi, $pw, $e, $fn, $ln, $hb, $hll, $sh, $sf);

		$accountDbase = new Database();

		$accountDbase->ExecSql($sql);

		$accountDbase->Disconnect();
	}

	public function DeleteAccount($pi)
	{
		$accountDbase = new Database();

		$sql = sprintf("DELETE FROM account WHERE pilotId='%s'", $pi);

		$accountDbase->ExecSql($sql);

		$sql = sprintf("DELETE FROM airplane WHERE pilotId='%s'", $pi);

		$accountDbase->ExecSql($sql);

		$sql = sprintf("DELETE FROM flightPlan WHERE pilotId='%s'", $pi);

		$accountDbase->ExecSql($sql);

		$accountDbase->Disconnect();

		$this->pilotId = null;
		$this->pilotPassword = null;
		$this->email = null;
		$this->firstName = null;
		$this->lastName = null;
		$this->homeBase = null;
		$this->homeLatLon = null;
		$this->showHeliport = null;
		$this->showFrequency = null;
		$this->ts = null;
		$this->accessCount = null;
	}

	public function UpdateAccount($pi, $pw, $e, $fn, $ln, $hb, $hll, $sh, $sf)
	{
		$this->accessCount++;

		$sql = sprintf("UPDATE account SET pilotPassword='%s',email='%s',firstName='%s',lastName='%s',homeBase='%s',homeLatLon='%s',showHeliport='%s',showFrequency='%s',accessCount='%s' WHERE pilotId='%s'", $pw, $e, $fn, $ln, $hb, $hll, $sh, $sf, $this->accessCount, $pi);

		$accountDbase = new Database();

		$accountDbase->ExecSql($sql);

		$accountDbase->Disconnect();
	}

	public function UpdatePassword($pi, $pw)
	{
		//$pw = password_hash($pw, PASSWORD_DEFAULT);

		$sql = sprintf("SELECT SHA2('%s', 256)", $pw);

		$sha2Dbase = new Database();

		$sha2Dbase->ExecSql($sql);

		$row = $sha2Dbase->FetchRowNumeric();

		$pw = $row[0];

		$sha2Dbase->Disconnect();

		$sql = sprintf("UPDATE account SET pilotPassword='%s' WHERE pilotId='%s'", $pw, $pi);

		$accountDbase = new Database();

		$accountDbase->ExecSql($sql);

		$accountDbase->Disconnect();
	}
}
?>