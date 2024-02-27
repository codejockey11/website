<?php
class CodedInstrumentFlightProcedureExcludedData
{
	public $id;
	public $ICAO;	
	public $termID;

	public function FormatEntry()
	{
		$str = sprintf("%s", $this->termID);

		return $str;
	}
}

class CodedInstrumentFlightProcedureExcluded
{
	public $procedure = array();

	public function __construct($sql)
	{
		$cifpExcludedDbase = new Database();
		
		$cifpExcludedDbase->ExecSql($sql);

		if ($cifpExcludedDbase->GetRowCount() > 0)
		{
			while($row = $cifpExcludedDbase->FetchRow())
			{
				$this->GetRow($row);
			}
		}
		else
		{
			$this->procedure = null;
		}

		$cifpExcludedDbase->Disconnect();
	}

	public function GetRow($row)
	{
		$codedInstrumentFlightProcedureData = new CodedInstrumentFlightProcedureExcludedData();

		$codedInstrumentFlightProcedureData->id = $row["id"];
		$codedInstrumentFlightProcedureData->ICAO = $row["ICAO"];		
		$codedInstrumentFlightProcedureData->termID = $row["termID"];

		array_push($this->procedure, $codedInstrumentFlightProcedureData);
	}

	public function ListEntries()
	{
		if ($this->procedure == null)
		{
			return;
		}

		$str = sprintf("<table><tr><td colspan=\"13\">Excluded Procedures: ");
					
		foreach ($this->procedure as $prc)
		{
			$str .= $prc->FormatEntry();
			
			$str .= ", ";
		}

		$str = rtrim($str, ", ");
		
		$str .= sprintf("</td></tr>\r\n");		
		
		$str .= sprintf("</table>\r\n");

		return $str;
	}
}
?>