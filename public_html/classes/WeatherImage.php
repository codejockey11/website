<?php
class WeatherImage
{
	public $images = array();

	public function __construct()
	{
		$date = gmdate("Y~m~d~H~i");
		
		$datea = explode("~", $date);

		$year  = $datea[0];
		$month = $datea[1];
		$day   = $datea[2];
		$hour  = $datea[3];
		$min   = $datea[4];

		if (($min >= 0) && ($min <= 7))
		{
			$hour -= 1;
			
			$min = 58;
		}

		if (($min >= 8) && ($min <= 17))
		{
			$min = 8;
		}

		if (($min >= 18) && ($min <= 27))
		{
			$min = 18;
		}

		if (($min >= 28) && ($min <= 37))
		{
			$min = 28;
		}

		if (($min >= 38) && ($min <= 47))
		{
			$min = 38;
		}

		if (($min >= 48) && ($min <= 57))
		{
			$min = 48;
		}

		if (($min >= 58) && ($min <= 59))
		{
			$min = 58;
		}

		$t = 0;

		for ($i = 9;$i >= 0;$i--)
		{
			$d = date("Ymd_Hi", mktime($hour, $min - $t, 0, $month, $day, $year));

			$url = "https://radar.weather.gov/ridge/Conus/RadarImg/Conus_" . $d . "_N0Ronly.gif";

			$c = new CheckHttp($url);

			if ($c->isFound == "1")
			{
				array_push($this->images, $url);
			}

			$t += 10;
		}

		asort($this->images);
	}
}
?>