<?php
class StationInfo
{
	public $station_id;
	public $wmo_id;
	public $latitude;
	public $longitude;
	public $elevation_m;
	public $site;
	public $state;
	public $country;
	public $type;
}

class StationMetar
{
	public $stationInfo;
	public $raw_text;
	public $station_id;
	public $observation_time;
	public $latitude;
	public $longitude;
	public $temp_c;
	public $dewpoint_c;
	public $wind_dir_degrees;
	public $wind_speed_kt;
	public $wind_gust_kt;
	public $visibility_statute_mi;
	public $altim_in_hg;
	public $quality_control_flags;
	public $sea_level_pressure_mb;
	public $wx_string;
	public $corrected;
	public $auto;
	public $no_signal;
	public $lightning_sensor_off;
	public $freezing_rain_sensor_off;
	public $present_weather_sensor_off;
	public $skyCondition = array();
	public $flight_category;
	public $three_hr_pressure_tendency_mb;
	public $maxT_c;
	public $minT_c;
	public $maxT24hr_c;
	public $minT24hr_c;
	public $precip_in;
	public $pcp3hr_in;
	public $pcp6hr_in;
	public $pcp24hr_in;
	public $snow_in;
	public $vert_vis_ft;
	public $metar_type;
	public $elevation_m;

	public $rh = 0;
	public $cbagl = 0;
	public $da = 0;
	public $pa = 0;

	public function FormatEntry()
	{
		$alt = $this->elevation_m * 3.2808399;

		$tc = new Temperature("C", floatval($this->temp_c));

		$dc = new Temperature("C", floatval($this->dewpoint_c));

		$str  = sprintf("<hr><b>ATMOSPHERE</b><br/>\r\n");

		$str .= sprintf("Pressure Altitude:%.2f<br/>\r\n", ($this->pa + $alt));

		$str .= sprintf("Density Altitude:%.2f (%.2f)<br/>\r\n", $this->da, (($this->elevation_m * 3.2808399) + $this->da));

		$str .= sprintf("Relative Humidity:%.2f<br/>\r\n", $this->rh);

		$str .= sprintf("Cloud Base AGL:%.2f", $this->cbagl);

		$str .= sprintf("<hr>\r\n");

		$str .= sprintf("<b>METAR</b>");

		$str .= sprintf("\r\n<br/>Raw Text:%s", $this->raw_text);

		$str .= sprintf("\r\n<br/>Station ID:%s", $this->station_id);

		$str .= sprintf("\r\n<br/>Time:%s", FlipTimeDate(str_replace("T", " ", $this->observation_time)));

		$str .= sprintf("\r\n<br/>GPS:%s %s", $this->latitude, $this->longitude);

		$str .= sprintf("\r\n<br/>Temperature:%.2f&nbsp;&nbsp;(%.2f)", $this->temp_c, $tc->fValue);

		$str .= sprintf("\r\n<br/>Dewpoint:%.2f&nbsp;&nbsp;(%.2f)", $this->dewpoint_c, $dc->fValue);

		$str .= sprintf("\r\n<br/>Winds:%s/%s", $this->wind_dir_degrees, $this->wind_speed_kt);

		if ($this->wind_gust_kt > " ")
		{
			$str .= sprintf("\r\n<br/>Wind Gust:%s", $this->wind_gust_kt);
		}

		$str .= sprintf("\r\n<br/>Visibility:%s", $this->visibility_statute_mi);

		$str .= sprintf("\r\n<br/>Altimeter:%.2f", $this->altim_in_hg);

		if ($this->sea_level_pressure_mb > " ")
		{
			$str .= sprintf("\r\n<br/>Sealevel Pressure:%s", $this->sea_level_pressure_mb);
		}

		if ($this->wx_string > " ")
		{
			$str .= sprintf("\r\n<br/>WX:%s", $this->wx_string);
		}

		if ($this->corrected > " ")
		{
			$str .= sprintf("\r\n<br/>Corrected:%s", $this->corrected);
		}

		if ($this->auto > " ")
		{
			$str .= sprintf("\r\n<br/>Auto:%s", $this->auto);
		}

		if ($this->quality_control_flags)
		{
			if ($this->quality_control_flags->auto_station > ' ')
			{
				$str .= sprintf("\r\n<br/>Auto Station:%s", $this->quality_control_flags->auto_station);
			}

			if ($this->quality_control_flags->maintenance_indicator_on > ' ')
			{
				$str .= sprintf("\r\n<br/><b class=\"error\">Maintenance:%s</b>\r\n", $this->quality_control_flags->maintenance_indicator_on);
			}
		}

		if ($this->no_signal > " ")
		{
			$str .= sprintf("\r\n<br/>No Signal:%s", $this->no_signal);
		}

		if ($this->lightning_sensor_off > " ")
		{
			$str .= sprintf("\r\n<br/>Lightning Sensor Off:%s", $this->lightning_sensor_off);
		}

		if ($this->freezing_rain_sensor_off > " ")
		{
			$str .= sprintf("\r\n<br/>Freezing Rain Sensor Off:%s", $this->freezing_rain_sensor_off);
		}

		if ($this->present_weather_sensor_off > " ")
		{
			$str .= sprintf("\r\n<br/>Present Weather Sensor Off:%s", $this->present_weather_sensor_off);
		}

		$str .= sprintf("\r\n<br/>Sky:");

		foreach ($this->skyCondition as $sky)
		{
			if ($sky->sky_cover > " ")
			{
				$str .= sprintf("%s ", $sky->sky_cover);
			}

			if ($sky->cloud_base_ft_agl > " ")
			{
				$str .= sprintf("%s ", $sky->cloud_base_ft_agl);
			}

			if ($sky->cloud_type > " ")
			{
				$str .= sprintf("%s ", $sky->cloud_type);
			}
		}

		$str .= sprintf("\r\n<br/>Flight Category:%s", $this->flight_category);

		if ($this->maxT_c > " ")
		{
			$str .= sprintf("\r\n<br/>Max Temp:%s", $this->maxT_c);
		}

		if ($this->minT_c > " ")
		{
			$str .= sprintf("\r\n<br/>Min Temp:%s", $this->minT_c);
		}

		if ($this->maxT24hr_c > " ")
		{
			$str .= sprintf("\r\n<br/>Max Temp 24hr:%s", $this->maxT24hr_c);
		}

		if ($this->minT24hr_c > " ")
		{
			$str .= sprintf("\r\n<br/>Min Temp 24hr:%s", $this->minT24hr_c);
		}

		if ($this->precip_in > " ")
		{
			$str .= sprintf("\r\n<br/>Precipitation:%s", $this->precip_in);
		}

		if ($this->pcp3hr_in > " ")
		{
			$str .= sprintf("\r\n<br/>Precipitation 3hr:%s", $this->pcp3hr_in);
		}

		if ($this->pcp6hr_in > " ")
		{
			$str .= sprintf("\r\n<br/>Precipitation 6hr:%s", $this->pcp6hr_in);
		}

		if ($this->pcp24hr_in > " ")
		{
			$str .= sprintf("\r\n<br/>Precipitation 24hr:%s", $this->pcp24hr_in);
		}

		if ($this->snow_in > " ")
		{
			$str .= sprintf("\r\n<br/>Snow:%s", $this->snow_in);
		}

		if ($this->vert_vis_ft > " ")
		{
			$str .= sprintf("\r\n<br/>Vertical Visibility:%s", $this->vert_vis_ft);
		}

		if ($this->metar_type > " ")
		{
			$str .= sprintf("\r\n<br/>Metar Type:%s", $this->metar_type);
		}

		$str .= sprintf("\r\n<br/>Elevation:%.2f&nbsp;&nbsp;(%.2f)", $this->elevation_m, ($this->elevation_m * 3.2808399));

		return $str;
	}

	public function FormatPlanInfo()
	{
		$str = null;

		switch($this->flight_category)
		{
			case "VFR":
			{
				$str .= sprintf("<td class=\"weatherVFR\">\r\n");

				break;
			}

			case "MVFR":
			{
				$str .= sprintf("<td class=\"weatherMVFR\">\r\n");

				break;
			}

			case "IFR":
			{
				$str .= sprintf("<td class=\"weatherIFR\">\r\n");

				break;
			}

			case "LIFR":
			{
				$str .= sprintf("<td class=\"weatherLIFR\">\r\n");

				break;
			}

			default:
			{
				$str .= sprintf("<td class=\"weatherVFR\">\r\n");

				break;
			}
		}

		$nws = new Parameter("nwsForecast");

		$str .= sprintf("<a href=\"%slat=%s&lon=%s&site=all&smap=1\">%s</a>\r\n", $nws->value1, $this->stationInfo->latitude, $this->stationInfo->longitude, $this->station_id);

		$str .= sprintf(" %s,%s", $this->stationInfo->site, $this->stationInfo->state);

		$str .= sprintf("\r\n<br/>%s", FlipTimeDate(str_replace("T", " ", $this->observation_time)));

		$str .= sprintf("\r\n<br/>%s ", $this->flight_category);

		$str .= sprintf("%2.2f/%2.2f", $this->temp_c, $this->dewpoint_c);

		$tc = new Temperature("C", $this->temp_c);

		$dc = new Temperature("C", $this->dewpoint_c);

		$str .= sprintf("\r\n<br/>(%2.2f/%2.2f)", $tc->fValue, $dc->fValue);

		if ($this->wind_speed_kt > 0)
		{
			$str .= sprintf("\r\n<br/>%s/", $this->wind_dir_degrees);

			$str .= sprintf("%s", $this->wind_speed_kt);
		}
		else
		{
			$str .= sprintf("\r\n<br/>CLM");
		}

		$str .= sprintf(" %s %s %2.2f<br/>\r\n", $this->visibility_statute_mi, $this->wx_string, $this->altim_in_hg);

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

		$str .= sprintf("\r\n<br/>DA %.2f (%.2f)", $this->da, (($this->elevation_m * 3.2808399) + $this->da));

		$str .= sprintf("</td>\r\n");

		return $str;
	}

	public function FormatMarkerGoogle($taf)
	{
		$icon = "../images/unk.png";

		if (strcmp($this->flight_category, "VFR") == 0)
		{
			$icon = "../images/vfr.png";
		}
		else if (strcmp($this->flight_category, "MVFR") == 0)
		{
			$icon = "../images/mvfr.png";
		}
		else if (strcmp($this->flight_category, "IFR") == 0)
		{
			$icon = "../images/ifr.png";
		}
		else if (strcmp($this->flight_category, "LIFR") == 0)
		{
			$icon = "../images/lifr.png";
		}

		$infoWindow  = "<div class=\"infoboxWeather\">";

		$infoWindow .= sprintf("%s", $this->flight_category);

		if ($this->da)
		{
			$alt = $this->elevation_m * 3.2808399;

			$infoWindow .= sprintf(" DAlt:%0.2f", $this->da + $alt);
		}

		$infoWindow .= sprintf("<br/>%s", $this->raw_text);

		if ($taf)
		{
			$infoWindow .= $taf->InfoBoxText();
		}

		$infoWindow .= "</div>";

		$str  = sprintf("    stationMarker = new Marker(map, '%s', %s, %s, black, '%s', '%s');\r\n", $this->station_id, $this->latitude, $this->longitude, $icon, $infoWindow);

		return $str;
	}

	public function FormatMarkerBing($taf)
	{
		$icon = "../images/unk.png";

		if (strcmp($this->flight_category, "VFR") == 0)
		{
			$icon = "../images/vfr.png";
		}
		else if (strcmp($this->flight_category, "MVFR") == 0)
		{
			$icon = "../images/mvfr.png";
		}
		else if (strcmp($this->flight_category, "IFR") == 0)
		{
			$icon = "../images/ifr.png";
		}
		else if (strcmp($this->flight_category, "LIFR") == 0)
		{
			$icon = "../images/lifr.png";
		}

		$infoWindow  = "<div class=\"infoboxWeather\">";

		$infoWindow .= sprintf("%s", $this->flight_category);

		if ($this->da)
		{
			$alt = $this->elevation_m * 3.2808399;

			$infoWindow .= sprintf(" DAlt:%0.2f", $this->da + $alt);
		}

		$infoWindow .= sprintf("<br/>%s", $this->raw_text);

		if ($taf)
		{
			$infoWindow .= $taf->InfoBoxText();
		}

		$infoWindow .= "</div>";

		$str  = sprintf("    stationMarker = new BingMarker(map, '%s', %s, %s, black, '%s', '%s');\r\n", $this->station_id, $this->latitude, $this->longitude, $icon, $infoWindow);

		return $str;
	}
}

class Station
{
	public $stationInfo;
	public $metar = array();

	public function __construct($ident)
	{
		if ($ident == null)
		{
			$this->metar = null;

			return;
		}

		// get the station info
		$parms = new Parameter("metarsStation");

		$xml = sprintf("%s%s", $parms->value1, $ident);

		$sr = new SimpleRequest($xml);

		if ($sr->xml == null)
		{
			$this->metar = null;

			return;
		}

		if ($sr->xml->data->attributes()->num_results == 0)
		{
			$this->metar = null;

			return;
		}

		$station = $sr->xml->data->Station;

		$this->stationInfo = new StationInfo();

		$this->stationInfo->station_id = $station->station_id;
		$this->stationInfo->wmo_id = $station->wmo_id;
		$this->stationInfo->latitude = $station->latitude;
		$this->stationInfo->longitude = $station->longitude;
		$this->stationInfo->elevation_m = $station->elevation_m;
		$this->stationInfo->site = $station->site;
		$this->stationInfo->state = $station->state;
		$this->stationInfo->country = $station->country;

		foreach ($station->site_type->METAR as $element => $value)
		{
			$this->stationInfo->type .= $element;
		}

		foreach ($station->site_type->TAF as $element => $value)
		{
			if ($this->stationInfo->type)
			{
				$this->stationInfo->type .= "/" . $element;
			}
			else
			{
				$this->stationInfo->type .= $element;
			}
		}

		// get the metars
		$parms = new Parameter("metars");

		$xml = sprintf("%s%s", $parms->value1, $ident);

		$sr = new SimpleRequest($xml);

		if ($sr->xml == null)
		{
			$this->metar = null;

			return;
		}

		if ($sr->xml->data->attributes()->num_results == 0)
		{
			$this->metar = null;

			return;
		}

		foreach ($sr->xml->data->METAR as $mtr)
		{
			$this->GetRow($mtr);
		}
	}

	public function GetRow($mtr)
	{
		$stationMetar = new StationMetar();

		$stationMetar->stationInfo = $this->stationInfo;

		$stationMetar->raw_text = trim($mtr->raw_text);
		$stationMetar->station_id = trim($mtr->station_id);
		$stationMetar->observation_time = trim($mtr->observation_time);
		$stationMetar->latitude = trim($mtr->latitude);
		$stationMetar->longitude = trim($mtr->longitude);
		$stationMetar->temp_c = floatval(trim($mtr->temp_c));
		$stationMetar->dewpoint_c = floatval(trim($mtr->dewpoint_c));
		$stationMetar->wind_dir_degrees = trim($mtr->wind_dir_degrees);
		$stationMetar->wind_speed_kt = trim($mtr->wind_speed_kt);
		$stationMetar->wind_gust_kt = trim($mtr->wind_gust_kt);
		$stationMetar->visibility_statute_mi = trim($mtr->visibility_statute_mi);
		$stationMetar->altim_in_hg = floatval(trim($mtr->altim_in_hg));
		// simple xml element so don't trim
		$stationMetar->quality_control_flags = $mtr->quality_control_flags;
		$stationMetar->sea_level_pressure_mb = floatval(trim($mtr->sea_level_pressure_mb));
		$stationMetar->wx_string = trim($mtr->wx_string);
		$stationMetar->corrected = trim($mtr->corrected);
		$stationMetar->auto = trim($mtr->auto);
		$stationMetar->no_signal = trim($mtr->no_signal);
		$stationMetar->lightning_sensor_off = trim($mtr->lightning_sensor_off);
		$stationMetar->freezing_rain_sensor_off = trim($mtr->freezing_rain_sensor_off);
		$stationMetar->present_weather_sensor_off = trim($mtr->present_weather_sensor_off);

		foreach ($mtr->sky_condition as $sky)
		{
			$skyCondition = new SkyCondition();

			foreach ($sky->attributes() as $element => $value)
			{
				if (strcmp($element, "sky_cover") == 0)
				{
					$skyCondition->sky_cover = trim($value);
				}

				if (strcmp($element, "cloud_base_ft_agl") == 0)
				{
					$skyCondition->cloud_base_ft_agl = trim($value);
				}

				if (strcmp($element, "cloud_type") == 0)
				{
					$skyCondition->cloud_type = trim($value);
				}
			}

			array_push($stationMetar->skyCondition, $skyCondition);
		}

		$stationMetar->flight_category = trim($mtr->flight_category);
		$stationMetar->three_hr_pressure_tendency_mb = trim($mtr->three_hr_pressure_tendency_mb);
		$stationMetar->maxT_c = trim($mtr->maxT_c);
		$stationMetar->minT_c = trim($mtr->minT_c);
		$stationMetar->maxT24hr_c = trim($mtr->maxT24hr_c);
		$stationMetar->minT24hr_c = trim($mtr->minT24hr_c);
		$stationMetar->precip_in = trim($mtr->precip_in);
		$stationMetar->pcp3hr_in = trim($mtr->pcp3hr_in);
		$stationMetar->pcp6hr_in = trim($mtr->pcp6hr_in);
		$stationMetar->pcp24hr_in = trim($mtr->pcp24hr_in);
		$stationMetar->snow_in = trim($mtr->snow_in);
		$stationMetar->vert_vis_ft = trim($mtr->vert_vis_ft);
		$stationMetar->metar_type = trim($mtr->metar_type);
		$stationMetar->elevation_m = floatval(trim($mtr->elevation_m));

		$stationMetar->pa = $this->PressureAltitude($stationMetar->altim_in_hg);

		$tc = new Temperature("C", $stationMetar->temp_c);

		$dc = new Temperature("C", $stationMetar->dewpoint_c);

		$stationMetar->da = $this->DensityAltitude($tc, $stationMetar->altim_in_hg, $dc);

		$stationMetar->rh = $this->RelativeHumidity($stationMetar->dewpoint_c, $stationMetar->temp_c);

		$stationMetar->cbagl = $this->CloudBaseAGL($stationMetar->temp_c, $stationMetar->dewpoint_c, "C");

		array_push($this->metar, $stationMetar);
	}

	public function PressureAltitude($p)
	{
		return 145366.45 * (1 - pow(((33.8639 * $p) / 1013.25), 0.190284));
	}

	public function CloudBaseAGL($t, $d, $tp)
	{
		if ((!is_numeric($t)) || (!is_numeric($d)) )
		{
			return 0;
		}

		// 2.5 for celcius 4.4 for farenheit
		if ($tp === 'C')
		{
			return (($t - $d) / 2.5) * 1000.00;
		}
		else
		{
			return (($t - $d) / 4.4) * 1000.00;
		}
	}

	public function DensityAltitude($tc, $pressureHg, $dc)
	{
		// Find virtual temperature using temperature in kelvin and dewpoint in celcius
		$Tv = $this->VirtualTemperature($tc, $pressureHg, $dc);

		// passing virtual temperature in Kelvin
		$Da = $this->CalcDensityAltitude($pressureHg, $Tv);

		return $Da;
	}

	public function VirtualTemperature($tc, $pressureHg, $dc)
	{
		// vapor pressure uses celcius
		$vp = floatVal(6.11 * pow(10, ((7.5 * $dc->cValue) / (237.7 + $dc->cValue))));

		$mbpressure = floatval(33.8639 * $pressureHg);

		// use temperature in Kelvin
		if ($mbpressure != 0)
		{
			return $tc->kValue / (1.0 - ($vp / $mbpressure ) * (1.0 - 0.622));
		}

		return 0;
	}

	public function CalcDensityAltitude($pressureHg, $tv)
	{
		if (!is_numeric($tv))
		{
			return 0;
		}

		// virtual temperature comes in as Kelvin
		$tk = new Temperature("K", $tv);

		// use virtual temperature as Rankine
		$p = floatval((17.326 * $pressureHg) / $tk->rValue);

		// weather.gov and seems to be the most used
		return 145366 * (1.0 - (pow($p, 0.235)));

		// NWS
		//return 145442.16 * (1.0 - (pow($p, 0.235)));
	}

	public function RelativeHumidity($d, $t)
	{
		if ((!is_numeric($d)) || (!is_numeric($t)))
		{
			return 0;
		}

		// Temperatures are celcius
		// =100*(EXP((17.625*TD)/(243.04+TD))/EXP((17.625*T)/(243.04+T)))
		return 100 * (exp((17.625 * $d) / (243.04 + $d)) / exp((17.625 * $t) / (243.04 + $t)));
	}

	public function StationInfo()
	{
		if ($this->stationInfo == null)
		{
			return;
		}

		$str  = sprintf("<b>STATION</b>\r\n");
		$str .= sprintf("\r\n<br/>Station ID:%s", $this->stationInfo->station_id);
		$str .= sprintf("\r\n<br/>WMO ID:%s", $this->stationInfo->wmo_id);
		$str .= sprintf("\r\n<br/>GPS:%s %s", $this->stationInfo->latitude, $this->stationInfo->longitude);
		$str .= sprintf("\r\n<br/>Elevation:%s (%.2f)", $this->stationInfo->elevation_m, ($this->stationInfo->elevation_m * 3.2808399));
		$str .= sprintf("\r\n<br/>Site:%s", $this->stationInfo->site);
		$str .= sprintf("\r\n<br/>State:%s", $this->stationInfo->state);
		$str .= sprintf("\r\n<br/>Country:%s", $this->stationInfo->country);
		$str .= sprintf("\r\n<br/>Type:%s", $this->stationInfo->type);

		return $str;
	}

	public function NWSLink()
	{
		if ($this->stationInfo == null)
		{
			return;
		}

		return sprintf("&nbsp;<a href=\"http://forecast.weather.gov/MapClick.php?lat=%s&lon=%s&site=all&smap=1\" target=\"_blank\">National Weather Service</a>\r\n", $this->stationInfo->latitude, $this->stationInfo->longitude);
	}

	public function GetSingle($i)
	{
		if ($this->metar == null)
		{
			return;
		}

		return $this->metar[$i];
	}

	public function ListEntries()
	{
		if ($this->metar == null)
		{
			return;
		}

		$str = null;

		foreach ($this->metar as $mtr)
		{
			$str .= $mtr->FormatEntry();
		}

		return $str;
	}
}
?>