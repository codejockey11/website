<?php
class SkyCondition
{
	public $sky_cover;
	public $cloud_base_ft_agl;
	public $cloud_type;
}

class Bulletin
{
	public $raw_text;
	public $station_id;
	public $issue_time;
	public $bulletin_time;
	public $valid_time_from;
	public $valid_time_to;
	public $change_indicator;
	public $remarks;
	public $latitude;
	public $longitude;
	public $elevation_m;

	public $forecast = array();

	public function InfoBoxText()
	{
		return sprintf("%s", str_replace("FM", "<br/>FM ", str_replace("TEMPO", "<br/>TEMPO ", $this->raw_text)));
	}

	public function FormatEntry()
	{
		$str  = sprintf("<hr><b>TAF</b>\r\n");
		$str .= sprintf("\r\n<br/>Raw Text:%s", $this->raw_text);
		$str .= sprintf("\r\n<br/>Station ID:%s", $this->station_id);
		$str .= sprintf("\r\n<br/>Issue:%s", FlipTimeDate(str_replace("T", " ", $this->issue_time)));
		$str .= sprintf("\r\n<br/>Bulletin:%s", FlipTimeDate(str_replace("T", " ", $this->bulletin_time)));
		$str .= sprintf("\r\n<br/>Valid From:%s To:%s", FlipTimeDate(str_replace("T", " ", $this->valid_time_from)), FlipTimeDate(str_replace("T", " ", $this->valid_time_to)));
		$str .= sprintf("\r\n<br/>Change:%s", $this->change_indicator);

		if ($this->remarks)
		{
			$str .= sprintf("\r\n<br/>Remarks:%s", $this->remarks);
		}

		$str .= sprintf("\r\n<br/>GPS:%s %s", $this->latitude, $this->longitude);

		$str .= sprintf("\r\n<br/>Elevation:%.2f&nbsp;&nbsp;(%.2f)", $this->elevation_m, ($this->elevation_m * 3.2808399));

		foreach ($this->forecast as $fcs)
		{
			$str .= $fcs->FormatEntry();
		}

		return $str;
	}

	public function FormatPlanInfo()
	{
		if ($this->forecast == null)
		{
			return;
		}

		$str = null;

		foreach ($this->forecast as $fcs)
		{
			$str .= $fcs->FormatPlanInfo();
		}

		return $str;
	}
}

class Forecast
{
	public $fcst_time_from;
	public $fcst_time_to;
	public $wind_dir_degrees;
	public $wind_speed_kt;
	public $wx_string;
	public $visibility_statute_mi;

	public $skyCondition = array();

	public function FormatEntry()
	{
		$str  = sprintf("\r\n<br/>");
		$str .= sprintf("\r\n<br/><b>FORECAST</b>\r\n");

		$str .= sprintf("\r\n<br/>From:%s To:%s",
			FlipTimeDate(str_replace("T", " ", $this->fcst_time_from)),
			FlipTimeDate(str_replace("T", " ", $this->fcst_time_to)));

		if ($this->change_indicator == "TEMPO")
		{
			$str .= sprintf("\r\n<br/>%s", $this->change_indicator);
		}

		if ($this->wind_dir_degrees > " ")
		{
			$str .= sprintf("\r\n<br/>Winds:%s/%s", $this->wind_dir_degrees, $this->wind_speed_kt);
		}

		if ($this->wx_string > " ")
		{
			$str .= sprintf("\r\n<br/>WX:%s", $this->wx_string);
		}

		if ($this->visibility_statute_mi > " ")
		{
			$str .= sprintf("\r\n<br/>Visibility:%s", $this->visibility_statute_mi);
		}

		if ($this->skyCondition)
		{
			$str .= sprintf("\r\n<br/>Sky:");

			foreach ($this->skyCondition as $sky)
			{
				$str .= sprintf("%s ", $sky->sky_cover);

				if ($sky->cloud_base_ft_agl > " ")
				{
					$str .= sprintf("%s ", $sky->cloud_base_ft_agl);
				}

				if ($sky->cloud_type > " ")
				{
					$str .= sprintf("%s ", $sky->cloud_type);
				}
			}
		}

		return $str;
	}

	public function FormatPlanInfo()
	{
		$str  = sprintf("<td class=\"weather\">%s<br/>%s",
			FlipTimeDate(str_replace("T", " ", $this->fcst_time_from)),
			FlipTimeDate(str_replace("T", " ", $this->fcst_time_to)));

		if ($this->change_indicator == "TEMPO")
		{
			$str .= sprintf("\r\n<br/>%s", $this->change_indicator);
		}

		if ($this->wind_dir_degrees > " ")
		{
			$str .= sprintf("\r\n<br/>Winds:%s/%s", $this->wind_dir_degrees, $this->wind_speed_kt);
		}

		if ($this->wx_string > " ")
		{
			$str .= sprintf("\r\n<br/>WX:%s", $this->wx_string);
		}

		if ($this->visibility_statute_mi > " ")
		{
			$str .= sprintf("\r\n<br/>Visibility:%s", $this->visibility_statute_mi);
		}

		if ($this->skyCondition)
		{
			$str .= sprintf("\r\n<br/>Sky:");

			foreach ($this->skyCondition as $sky)
			{
				if ($sky->sky_cover)
				{
					$str .= sprintf("%s ", $sky->sky_cover);
				}

				if ($sky->cloud_base_ft_agl)
				{
					$str .= sprintf("%s ", $sky->cloud_base_ft_agl);
				}

				if ($sky->cloud_type)
				{
					$str .= sprintf("%s ", $sky->cloud_type);
				}
			}
		}

		$str .= sprintf("</td>\r\n");

		return $str;
	}
}

class TAF
{
	public $bulletin = array();

	public function __construct($station)
	{
		if ($station == null)
		{
			$this->bulletin = null;
			return;
		}

		// get the tafs
		$parms = new Parameter("tafs");

		$xml = sprintf("%s%s", $parms->value1, $station);

		$sr = new SimpleRequest($xml);

		if ($sr->xml == null)
		{
			$this->bulletin = null;

			return;
		}

		if ($sr->xml->data->attributes()->num_results == 0)
		{
			$this->bulletin = null;

			return;
		}

		foreach ($sr->xml->data->TAF as $taf)
		{
			$this->GetRow($taf);
		}
	}

	public function GetRow($taf)
	{
		$bulletin = new Bulletin();

		$bulletin->raw_text = $taf->raw_text;
		$bulletin->station_id = $taf->station_id;
		$bulletin->issue_time = $taf->issue_time;
		$bulletin->bulletin_time = $taf->bulletin_time;
		$bulletin->valid_time_from = $taf->valid_time_from;
		$bulletin->valid_time_to = $taf->valid_time_to;
		$bulletin->remarks = $taf->remarks;
		$bulletin->latitude = $taf->latitude;
		$bulletin->longitude = $taf->longitude;
		$bulletin->elevation_m = $taf->elevation_m;

		foreach ($taf->forecast as $fm)
		{
			$forecast = new Forecast();

			$forecast->fcst_time_from = $fm->fcst_time_from;
			$forecast->fcst_time_to = $fm->fcst_time_to;
			$forecast->change_indicator = $fm->change_indicator;
			$forecast->wind_dir_degrees = $fm->wind_dir_degrees;
			$forecast->wind_speed_kt = $fm->wind_speed_kt;
			$forecast->wx_string = $fm->wx_string;
			$forecast->visibility_statute_mi = $fm->visibility_statute_mi;

			foreach ($fm->sky_condition as $sky)
			{
				$skyCondition = new SkyCondition();

				foreach ($sky->attributes() as $element => $value)
				{
					if (strcmp($element, "sky_cover") == 0)
					{
						$skyCondition->sky_cover = $value;
					}

					if (strcmp($element, "cloud_base_ft_agl") == 0)
					{
						$skyCondition->cloud_base_ft_agl = $value;
					}

					if (strcmp($element, "cloud_type") == 0)
					{
						$skyCondition->cloud_type = $value;
					}
				}

				array_push($forecast->skyCondition, $skyCondition);
			}

			array_push($bulletin->forecast, $forecast);
		}

		array_push($this->bulletin, $bulletin);
	}

	public function GetSingle($i)
	{
		if ($this->bulletin == null)
		{
			return;
		}

		return $this->bulletin[$i];
	}

	public function ListEntries()
	{
		if ($this->bulletin == null)
		{
			return;
		}

		$str = null;

		foreach ($this->bulletin as $blt)
		{
			$str .= $blt->FormatEntry();
		}

		return $str;
	}
}
?>