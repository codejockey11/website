<?php
class ParameterData
{
	public $name;
	public $value1;
	public $value2;
	public $value3;
	public $value4;

	public function FormatLinkEntry()
	{
		return sprintf("<a href=\"%s\">%s</a><br/>\r\n", $this->value1, $this->value2);
	}
}

class Parameter
{
	public $name;
	public $value1;
	public $value2;
	public $value3;
	public $value4;

	public $parmList = array();

	public $scrollTop = 0;

	public function __construct($n)
	{
		if ($n == null)
		{
			return;
		}

		$sql = sprintf("SELECT * FROM parameter WHERE name='%s'", $n);

		$parmDbase = new Database();

		$parmDbase->ExecSql($sql);

		if ($parmDbase->GetRowCount() > 0)
		{
			$row = $parmDbase->FetchRow();

			$this->name = $row["name"];
			$this->value1 = $row["value1"];
			$this->value2 = $row["value2"];
			$this->value3 = $row["value3"];
			$this->value4 = $row["value4"];
		}
		else
		{
			$this->parmList = null;
		}

		$parmDbase->Disconnect();
	}

	public function RangedSelection($f, $t, $o, $cs)
	{
		if ($cs)
		{
			if ($o == "A")
			{
				$sql = sprintf("SELECT * FROM parameter WHERE name>='%s' AND name<='%s' ORDER BY %s ASC", $f, $t, $cs);
			}
			else
			{
				$sql = sprintf("SELECT * FROM parameter WHERE name>='%s' AND name<='%s' ORDER BY %s DESC", $f, $t, $cs);
			}
		}
		else if ($o == "A")
		{
			$sql = sprintf("SELECT * FROM parameter WHERE name>='%s' AND name<='%s' ORDER BY value1 ASC", $f, $t);
		}
		else if ($o == "D")
		{
			$sql = sprintf("SELECT * FROM parameter WHERE name>='%s' AND name<='%s' ORDER BY value1 DESC", $f, $t);
		}
		else
		{
			$sql = sprintf("SELECT * FROM parameter WHERE name>='%s' AND name<='%s'", $f, $t);
		}

		$parmDbase = new Database();

		$parmDbase->ExecSql($sql);

		if ($parmDbase->GetRowCount() > 0)
		{
			while($row = $parmDbase->FetchRow())
			{
				$this->GetRow($row);
			}
		}
		else
		{
			$this->parmList = null;
		}

		$parmDbase->Disconnect();
	}

	public function GetRow($row)
	{
		$parameterData = new ParameterData();

		$parameterData->name = $row["name"];
		$parameterData->value1 = htmlspecialchars($row["value1"], ENT_QUOTES);
		$parameterData->value2 = htmlspecialchars($row["value2"], ENT_QUOTES);
		$parameterData->value3 = htmlspecialchars($row["value3"], ENT_QUOTES);
		$parameterData->value4 = htmlspecialchars($row["value4"], ENT_QUOTES);

		array_push($this->parmList, $parameterData);
	}

	public function MakeDropdown($f, $t, $i, $name, $size, $o, $cs)
	{
		$this->RangedSelection($f, $t, $o, $cs);

		if ($this->parmList)
		{
			printf("<select name=\"%sSelect\" id=\"%sSelect\" size=\"%s\">\r\n", $name, $name, $size);

			foreach ($this->parmList as $parm)
			{
				if (strcmp($i, $parm->value2) == 0)
				{
					printf("<option selected value=\"%s\" title=\"%s\">%s</option>\r\n", $parm->value2, $parm->value1, $parm->value1);
				}
				else
				{
					printf("<option value=\"%s\" title=\"%s\">%s</option>\r\n", $parm->value2, $parm->value1, $parm->value1);
				}
			}

			printf("</select>\r\n");
		}
	}

	public function MakeMultiDropdown($f, $t, $i, $name, $size, $o, $cs)
	{
		$this->RangedSelection($f, $t, $o, $cs);

		if ($this->parmList)
		{
			$eq = explode(',', $i);

			printf("<select multiple name=\"%sSelect[]\" id=\"%sSelect\" size=\"%s\">\r\n", $name, $name, $size);

			foreach ($this->parmList as $parm)
			{
				$found = 0;

				foreach ($eq as $e)
				{
					if (strcmp($e, $parm->value2) == 0)
					{
						printf("<option selected value=\"%s\" title=\"%s\">%s</option>\r\n", $parm->value2, $parm->value1, $parm->value1);

						$found = 1;

						break;
					}
				}

				if ($found == 0)
				{
					printf("<option value=\"%s\" title=\"%s\">%s</option>\r\n", $parm->value2, $parm->value1, $parm->value1);
				}
			}

			printf("</select>\r\n");
		}
	}

	public function ListLinksRanged()
	{
		if ($this->parmList == null)
		{
			return;
		}

		$str = null;

		foreach ($this->parmList as $parm)
		{
			$str .= $parm->FormatLinkEntry();
		}

		return $str;
	}
}
?>