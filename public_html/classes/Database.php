<?php
class Database
{
	public $result;
	public $connection;

	public function __construct()
	{
		//$servername, $username, $password, $database, $port
		$this->connection = mysqli_connect("localhost", "root", "mysql", "aviation", 26106);
	}

	public function Disconnect()
	{
		if ($this->connection == null)
		{
			return;
		}

		$this->connection->close();
	}

	public function ExecSql($sql)
	{
		if ($this->connection == null)
		{
			return;
		}

		$this->result = $this->connection->query($sql);

		if ($this->result === false)
		{
			varDump(false, $sql);

			varDump(false, $this->connection);
		}
	}

	public function FetchRow()
	{
		if ($this->connection == null)
		{
			return;
		}

		if (($this->result !== null) && ($this->result !== false) && ($this->result !== true))
		{
			return $this->result->fetch_assoc();
		}
	}

	public function FetchRowNumeric()
	{
		if ($this->connection == null)
		{
			return;
		}

		if (($this->result !== null) && ($this->result !== false) && ($this->result !== true))
		{
			return $this->result->fetch_row();
		}
	}

	public function GetRowCount()
	{
		if ($this->connection == null)
		{
			return;
		}

		if (($this->result !== null) && ($this->result !== false) && ($this->result !== true))
		{
			return $this->result->num_rows;
		}

		return 0;
	}
}
?>