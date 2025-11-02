<?php
class AirSigmet
{
	public $xmlFile;

	public function __construct()
	{
		$parms = new Parameter("airSigmets");

		$xml = sprintf("%s", $parms->value1);

		$sr = new SimpleRequest($xml);

		if ($sr->xml == null)
		{
			return;
		}

		$this->xmlFile = $sr->xml;
	}

	public function MapMarkerGoogle($sigmet)
	{
		if ($this->xmlFile == null)
		{
			return;
		}

		$tm = gmdate("Y-m-d H:i");

		$tm .= ":00Z";

		$tm = str_replace(" ", "T", $tm);

		$color = "";

		$str = "";

		foreach ($this->xmlFile->data->AIRSIGMET as $airsigmet)
		{
			if ((($airsigmet->airsigmet_type == "AIRMET") || ($airsigmet->airsigmet_type == "SIGMET")) && ($tm < $airsigmet->valid_time_to))
			{
				if ($airsigmet->hazard->attributes()->type == $sigmet)
				{
					switch($sigmet)
					{
						case "CONVECTIVE":
						{
							$color = "rgba(100, 0, 100, 100)";

							break;
						}

						case "TURB":
						{
							$color = "rgba(100, 0, 0, 100)";

							break;
						}

						case "ICE":
						{
							$color = "rgba(0, 100, 100, 100)";

							break;
						}

						case "IFR":
						{
							$color = "rgba(0, 0, 100, 100)";

							break;
						}

						case "MTN OBSCN":
						{
							$color = "rgba(100, 100, 25, 100)";

							break;
						}

						case "ASH":
						{
							$color = "rgba(100, 100, 100, 100)";

							break;
						}

						default:
						{
							break;
						}
					}

					$infoWindow  = "<div class=\"infoboxSigmet\">";

					if (isset($airsigmet->altitude))
					{
						$infoWindow .= sprintf("%s", $airsigmet->altitude->attributes()->max_ft_msl);
					}

					$infoWindow .= sprintf("<br/>%s", $airsigmet->movement_dir_degrees);

					$infoWindow .= sprintf("<br/>%s", $airsigmet->movement_speed_kt);

					$infoWindow .= sprintf("<br/>%s", str_replace(array(" \n", "\n"), "<br/>", $airsigmet->raw_text));

					$infoWindow .= "<div/>";


					$str .= sprintf("    polygon = new Polygon(map, '%s', '%s');\r\n", $color, $infoWindow);

					foreach ($airsigmet->area->point as $point)
					{
						$str .= sprintf("    polygon.AddPoint('%0.6f', '%0.6f');\r\n", $point->latitude, $point->longitude);
					}

					$str .= sprintf("    polygon.End();\r\n\r\n");

					$str .= sprintf("    polygonArray.push(polygon);\r\n\r\n");
				}
			}
		}

		return $str;
	}

	public function MapMarkerBing($sigmet)
	{
		if ($this->xmlFile == null)
		{
			return;
		}

		$tm = gmdate("Y-m-d H:i");

		$tm .= ":00Z";

		$tm = str_replace(" ", "T", $tm);

		$color = "";

		$str = "";

		foreach ($this->xmlFile->data->AIRSIGMET as $airsigmet)
		{
			if ((($airsigmet->airsigmet_type == "AIRMET") || ($airsigmet->airsigmet_type == "SIGMET")) && ($tm < $airsigmet->valid_time_to))
			{
				if ($airsigmet->hazard->attributes()->type == $sigmet)
				{
					switch($sigmet)
					{
						case "CONVECTIVE":
						{
							$color = "rgba(100, 0, 100, 100)";

							break;
						}

						case "TURB":
						{
							$color = "rgba(100, 0, 0, 100)";

							break;
						}

						case "ICE":
						{
							$color = "rgba(0, 100, 100, 100)";

							break;
						}

						case "IFR":
						{
							$color = "rgba(0, 0, 100, 100)";

							break;
						}

						case "MTN OBSCN":
						{
							$color = "rgba(100, 100, 25, 100)";

							break;
						}

						case "ASH":
						{
							$color = "rgba(100, 100, 100, 100)";

							break;
						}

						default:
						{
							break;
						}
					}

					$infoWindow  = "<div class=\"infoboxSigmet\">";

					if (isset($airsigmet->altitude))
					{
						$infoWindow .= sprintf("%s", $airsigmet->altitude->attributes()->max_ft_msl);
					}

					$infoWindow .= sprintf("<br/>%s", $airsigmet->movement_dir_degrees);

					$infoWindow .= sprintf("<br/>%s", $airsigmet->movement_speed_kt);

					$infoWindow .= sprintf("<br/>%s", str_replace(array(" \n", "\n"), "<br/>", $airsigmet->raw_text));

					$infoWindow .= "<div/>";


					if (count($airsigmet->area->point) > 0)
					{
						$str .= sprintf("    polygon = new BingPolygon(map, '%s', '%s');\r\n", $color, $infoWindow);

						foreach ($airsigmet->area->point as $point)
						{
							$str .= sprintf("    polygon.AddPoint('%0.6f', '%0.6f');\r\n", $point->latitude, $point->longitude);
						}

						$str .= sprintf("    polygon.End();\r\n\r\n");

						$str .= sprintf("    polygonArray.push(polygon);\r\n\r\n");
					}
				}
			}
		}

		return $str;
	}
}
?>