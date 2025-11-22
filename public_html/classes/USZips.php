<?php
class USZipsData
{
	public $state;
	public $city;
	public $county;
	public $zip;
	public $latitude;
	public $longitude;
	public $timezone;

	public function FormatEntry()
	{
		$str = sprintf("\r\n<br/>%s %s", $this->state, $this->city, $this->county, $this->zip, $this->latitude, $this->longitude, $this->timezone);

		return $str;
	}
}

class USZips
{
	public $usZips = array();
	public $foundCity = false;
	public $foundZip = false;
	public $foundCounty = false;

	public function __construct($s)
	{
		$sql = sprintf("SELECT * FROM uszips WHERE state='%s'", $s);

		$usZipsDbase = new Database();
		
		$usZipsDbase->ExecSql($sql);

		if ($usZipsDbase->GetRowCount() > 0)
		{
			while($row = $usZipsDbase->FetchRow())
			{
				$this->GetRow($row);
			}
		}
		else
		{
			$this->usZips = null;
		}

		$usZipsDbase->Disconnect();
	}

	public function GetRow($row)
	{
		$usZipsData = new USZipsData();

		$usZipsData->state = $row["state"];
		$usZipsData->city = $row["city"];
		$usZipsData->county = $row["county"];
		$usZipsData->zip = $row["zip"];
		$usZipsData->latitude = $row["latitude"];
		$usZipsData->longitude = $row["longitude"];
		$usZipsData->timezone = $row["timezone"];

		array_push($this->usZips, $usZipsData);
	}

	public function ListEntries()
	{
		if ($this->usZips == null)
		{
			return;
		}

		$str = null;

		foreach ($this->usZips as $zips)
		{
			$str .= $zips->FormatEntry();
		}

		return $str;
	}

	public function LoadStates()
	{
		$this->usZips = array();
		
		$sql = sprintf("SELECT DISTINCT state FROM uszips");

		$usZipsDbase = new Database();
		
		$usZipsDbase->ExecSql($sql);

		if ($usZipsDbase->GetRowCount() > 0)
		{
			while($row = $usZipsDbase->FetchRow())
			{
				$usZipsData = new USZipsData();

				$usZipsData->state = $row["state"];

				array_push($this->usZips, $usZipsData);
			}
		}
		else
		{
			$this->usZips = null;
		}

		$usZipsDbase->Disconnect();
	}

	public function StateDropdown($i)
	{
		if ($this->usZips == null)
		{
			return;
		}

		$str = sprintf("<select name=\"stateSelect\" id=\"stateSelect\" onfocus=\"this.selectedIndex = 0;\" onchange=\"DoHttpRequestCities();\">\r\n", $i);

		foreach ($this->usZips as $zips)
		{
			if (strcmp($i, $zips->state) == 0)
			{
				$str .= sprintf("<option selected value=\"%s\">%s</option>\r\n", $zips->state, $zips->state);
			}
			else
			{
				$str .= sprintf("<option value=\"%s\">%s</option>\r\n", $zips->state, $zips->state);
			}
		}
		
		$str .= sprintf("</select>\r\n");

		return $str;
	}
	
	public function LoadCities($s)
	{
		$this->usZips = array();
		
		$sql = sprintf("SELECT DISTINCT city FROM uszips WHERE state='%s'", $s);

		$usZipsDbase = new Database();
		
		$usZipsDbase->ExecSql($sql);

		if ($usZipsDbase->GetRowCount() > 0)
		{
			while($row = $usZipsDbase->FetchRow())
			{
				$usZipsData = new USZipsData();

				$usZipsData->city = $row["city"];

				array_push($this->usZips, $usZipsData);
			}
		}
		else
		{
			$this->usZips = null;
		}

		$usZipsDbase->Disconnect();
	}

	public function CityDropdown($c)
	{
		if ($this->usZips == null)
		{
			return;
		}

		$this->foundCity = false;

		$str = sprintf("<select name=\"citySelect\" id=\"citySelect\" onfocus=\"this.selectedIndex = 0;\" onchange=\"DoHttpRequestZipcodes();\">\r\n");

		foreach ($this->usZips as $zips)
		{
			if (strcmp($c, $zips->city) == 0)
			{
				$str .= sprintf("<option selected value=\"%s\">%s</option>\r\n", $zips->city, $zips->city);
				
				$this->foundCity = true;
			}
			else
			{
				$str .= sprintf("<option value=\"%s\">%s</option>\r\n", $zips->city, $zips->city);
			}
		}
		
		$str .= sprintf("</select>\r\n");

		return $str;
	}
	
	public function ListCitiesXML()
	{
		if ($this->usZips == null)
		{
			return;
		}
		
		$str = null;

		foreach ($this->usZips as $zips)
		{
			$str .= "<city>\r\n";
			
			$str .= sprintf("<name>%s</name>\r\n", $zips->city);
			
			$str .= "</city>\r\n";
		}

		return $str;
	}
	
	public function LoadZipcodes($s, $c)
	{
		$this->usZips = array();
		
		$sql = sprintf("SELECT * FROM uszips WHERE state='%s' AND city='%s'", $s, $c);

		$usZipsDbase = new Database();
		
		$usZipsDbase->ExecSql($sql);

		if ($usZipsDbase->GetRowCount() > 0)
		{
			while($row = $usZipsDbase->FetchRow())
			{
				$this->GetRow($row);
			}
		}
		else
		{
			$this->usZips = null;
		}

		$usZipsDbase->Disconnect();
	}

	public function ZipDropdown($z)
	{
		if ($this->usZips == null)
		{
			return;
		}

		$this->foundZip = false;

		$str = sprintf("<select name=\"zipSelect\" id=\"zipSelect\" onfocus=\"this.selectedIndex = 0;\" onchange=\"DoHttpRequestCounties();\">\r\n");

		foreach ($this->usZips as $zips)
		{
			if (strcmp($z, $zips->zip) == 0)
			{
				$str .= sprintf("<option selected value=\"%s\">%s</option>\r\n", $zips->zip, $zips->zip);
				
				$this->foundZip = true;
			}
			else
			{
				$str .= sprintf("<option value=\"%s\">%s</option>\r\n", $zips->zip, $zips->zip);
			}
		}
		
		$str .= sprintf("</select>\r\n");

		return $str;
	}
	
	public function ListZipcodesXML()
	{
		if ($this->usZips == null)
		{
			return;
		}
		
		$str = null;

		foreach ($this->usZips as $zips)
		{
			$str .= "<city>\r\n";
			
			$str .= sprintf("<zip>%s</zip>\r\n", $zips->zip);
			
			$str .= "</city>\r\n";
		}

		return $str;
	}
	
	public function LoadCounties($s, $c, $z)
	{
		$this->usZips = array();
		
		$sql = sprintf("SELECT * FROM uszips WHERE state='%s' AND city='%s' AND zip='%s'", $s, $c, $z);

		$usZipsDbase = new Database();
		
		$usZipsDbase->ExecSql($sql);

		if ($usZipsDbase->GetRowCount() > 0)
		{
			while($row = $usZipsDbase->FetchRow())
			{
				$this->GetRow($row);
			}
		}
		else
		{
			$this->usZips = null;
		}

		$usZipsDbase->Disconnect();
	}

	public function CountyDropdown($c)
	{
		if ($this->usZips == null)
		{
			return;
		}

		$this->foundCounty = false;

		$str = sprintf("<select name=\"countySelect\" id=\"countySelect\" onfocus=\"this.selectedIndex = 0;\">\r\n");

		foreach ($this->usZips as $zips)
		{
			if (strcmp($c, $zips->county) == 0)
			{
				$str .= sprintf("<option selected value=\"%s\">%s</option>\r\n", $zips->county, $zips->county);
				
				$this->foundCounty = true;
			}
			else
			{
				$str .= sprintf("<option value=\"%s\">%s</option>\r\n", $zips->county, $zips->county);
			}
		}
		
		$str .= sprintf("</select>\r\n");

		return $str;
	}
	
	public function ListCountiesXML()
	{
		if ($this->usZips == null)
		{
			return;
		}
		
		$str = null;

		foreach ($this->usZips as $zips)
		{
			$str .= "<city>\r\n";
			
			$str .= sprintf("<county>%s</county>\r\n", $zips->county);
			
			$str .= "</city>\r\n";
		}

		return $str;
	}
}
?>