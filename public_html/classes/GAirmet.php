<?php
class GAirmet
{
	public $xmlFile;

	public function __construct()
	{
		$parms = new Parameter("gAirmets");

		$xml = sprintf("%s", $parms->value1);

		$sr = new SimpleRequest($xml);

		if ($sr->xml == null)
		{
			return;
		}

		$this->xmlFile = $sr->xml;
	}

	public function MapMarkerGoogle($airmet)
	{
		if ($this->xmlFile == null)
		{
			return;
		}

		$tm = gmdate("Y-m-d H:i");

		$tm .= ":00Z";

		$tm = str_replace(" ", "T", $tm);

		$str = "";

		foreach ($this->xmlFile->data->GAIRMET as $gairmet)
		{
			$color = "";

			if ($tm <= $gairmet->expire_time)
			{
				if ($gairmet->hazard->attributes()->type == $airmet)
				{
					switch($airmet)
					{
						case "IFR":
						{
							$color = "rgba(0, 0, 100, 100)";

							break;
						}

						case "MT_OBSC":
						{
							$color = "rgba(100, 100, 25, 100)";

							break;
						}

						case "TURB-HI":
						{
							$color = "rgba(100, 0, 100, 100)";

							break;
						}

						case "TURB-LO":
						{
							$color = "rgba(100, 0, 0, 100)";

							break;
						}

						case "ICE":
						{
							$color = "rgba(0, 100, 100, 100)";

							break;
						}

						case "FZLVL":
						{
							$color = "rgba(0, 100, 100, 255)";

							break;
						}

						case "M_FZLVL":
						{
							$color = "rgba(0, 100, 100, 100)";

							break;
						}

						case "SFC_WND":
						{
							$color = "rgba(100, 100, 100, 100)";

							break;
						}

						case "LLWS":
						{
							$color = "rgba(100, 100, 100, 100)";

							break;
						}

						default:
						{
							break;
						}
					}

					$infoWindow  = "<div class=\"infoboxText\">";

					$infoWindow .= FlipTimeDate(str_replace("T", " ", $gairmet->expire_time));

					$infoWindow .= sprintf("<br/>%s", $gairmet->hazard->attributes()->type);

					switch($airmet)
					{
						case "IFR":
						case "MT_OBSC":
						{
							$infoWindow .= sprintf("<br/>%s", $gairmet->wx_details);

							break;
						}

						case "TURB-HI":
						case "TURB-LO":
						case "M_FZLVL":
						{
							$infoWindow .= sprintf("<br/>%s", $gairmet->hazard->attributes()->severity);

							$infoWindow .= sprintf("<br/>%s to %s", $gairmet->altitude->attributes()->min_ft_msl, $gairmet->altitude->attributes()->max_ft_msl);

							break;
						}

						case "ICE":
						{
							$infoWindow .= sprintf("<br/>%s", $gairmet->hazard->attributes()->severity);

							$infoWindow .= sprintf("<br/>msl:%s to %s", $gairmet->altitude->attributes()->min_ft_msl, $gairmet->altitude->attributes()->max_ft_msl);

							if ($gairmet->fzl_altitude)
							{
								$infoWindow .= sprintf("<br/>frz:%s to %s", $gairmet->fzl_altitude->attributes()->min_ft_msl, $gairmet->fzl_altitude->attributes()->max_ft_msl);
							}

							break;
						}

						case "SFC_WND":
						case "LLWS":
						{
							break;
						}

						case "FZLVL":
						{
							$infoWindow .= sprintf("<br/>%s", $gairmet->altitude->attributes()->level_ft_msl);

							break;
						}

						default:
						{
							break;
						}
					}

					if ($airmet == "FZLVL")
					{
						$str .= sprintf("    line = new Line(map, false, '%s', '6', '%s');\r\n", $color, $infoWindow);
					}
					else
					{
						$str .= sprintf("    polygon = new Polygon(map, '%s', '%s');\r\n", $color, $infoWindow);
					}


					foreach ($gairmet->area->point as $point)
					{
						if ($airmet == "FZLVL")
						{
							$str .= sprintf("    line.AddPoint('', '%0.6f', '%0.6f', '');\r\n", $point->latitude, $point->longitude);
						}
						else
						{
							$str .= sprintf("    polygon.AddPoint('%0.6f', '%0.6f');\r\n", $point->latitude, $point->longitude);
						}

					}


					if ($airmet == "FZLVL")
					{
						$str .= sprintf("    line.End('', '%0.6f', '%0.6f', '');\r\n\r\n", $point->latitude, $point->longitude);

						$str .= sprintf("    lineArray.push(line);\r\n\r\n");
					}
					else
					{
						$str .= sprintf("    polygon.End();\r\n\r\n");

						$str .= sprintf("    polygonArray.push(polygon);\r\n\r\n");
					}
				}
			}
		}

		return $str;
	}

	public function MapMarkerBing($airmet)
	{
		if ($this->xmlFile == null)
		{
			return;
		}

		$tm = gmdate("Y-m-d H:i");

		$tm .= ":00Z";

		$tm = str_replace(" ", "T", $tm);

		$str = "";

		foreach ($this->xmlFile->data->GAIRMET as $gairmet)
		{
			$color = "";

			if ($tm <= $gairmet->expire_time)
			{
				if ($gairmet->hazard->attributes()->type == $airmet)
				{
					switch($airmet)
					{
						case "IFR":
						{
							$color = "rgba(0, 0, 100, 100)";

							break;
						}

						case "MT_OBSC":
						{
							$color = "rgba(100, 100, 25, 100)";

							break;
						}

						case "TURB-HI":
						{
							$color = "rgba(100, 0, 100, 100)";

							break;
						}

						case "TURB-LO":
						{
							$color = "rgba(100, 0, 0, 100)";

							break;
						}

						case "ICE":
						{
							$color = "rgba(0, 100, 100, 100)";

							break;
						}

						case "FZLVL":
						{
							$color = "rgba(0, 100, 100, 255)";

							break;
						}

						case "M_FZLVL":
						{
							$color = "rgba(0, 100, 100, 100)";

							break;
						}

						case "SFC_WND":
						{
							$color = "rgba(100, 100, 100, 100)";

							break;
						}

						case "LLWS":
						{
							$color = "rgba(100, 100, 100, 100)";

							break;
						}

						default:
						{
							break;
						}
					}

					$infoWindow  = "<div class=\"infoboxText\">";

					$infoWindow .= FlipTimeDate(str_replace("T", " ", $gairmet->expire_time));

					$infoWindow .= sprintf("<br/>%s", $gairmet->hazard->attributes()->type);

					switch($airmet)
					{
						case "IFR":
						case "MT_OBSC":
						{
							$infoWindow .= sprintf("<br/>%s", $gairmet->wx_details);

							break;
						}

						case "TURB-HI":
						case "TURB-LO":
						case "M_FZLVL":
						{
							$infoWindow .= sprintf("<br/>%s", $gairmet->hazard->attributes()->severity);

							$infoWindow .= sprintf("<br/>%s to %s", $gairmet->altitude->attributes()->min_ft_msl, $gairmet->altitude->attributes()->max_ft_msl);

							break;
						}

						case "ICE":
						{
							$infoWindow .= sprintf("<br/>%s", $gairmet->hazard->attributes()->severity);

							$infoWindow .= sprintf("<br/>msl:%s to %s", $gairmet->altitude->attributes()->min_ft_msl, $gairmet->altitude->attributes()->max_ft_msl);

							if ($gairmet->fzl_altitude)
							{
								$infoWindow .= sprintf("<br/>frz:%s to %s", $gairmet->fzl_altitude->attributes()->min_ft_msl, $gairmet->fzl_altitude->attributes()->max_ft_msl);
							}

							break;
						}

						case "SFC_WND":
						case "LLWS":
						{
							break;
						}

						case "FZLVL":
						{
							$infoWindow .= sprintf("<br/>%s", $gairmet->altitude->attributes()->level_ft_msl);

							break;
						}

						default:
						{
							break;
						}
					}

					if ($airmet == "FZLVL")
					{
						$str .= sprintf("    line = new BingLineGAirmet(map, '%s', '6', '%s');\r\n", $color, $infoWindow);
					}
					else
					{
						$str .= sprintf("    polygon = new BingPolygon(map, '%s', '%s');\r\n", $color, $infoWindow);
					}


					foreach ($gairmet->area->point as $point)
					{
						if ($airmet == "FZLVL")
						{
							$str .= sprintf("    line.AddPoint('', '%0.6f', '%0.6f', '');\r\n", $point->latitude, $point->longitude);
						}
						else
						{
							$str .= sprintf("    polygon.AddPoint('%0.6f', '%0.6f');\r\n", $point->latitude, $point->longitude);
						}

					}


					if ($airmet == "FZLVL")
					{
						$str .= sprintf("    line.End('', '%0.6f', '%0.6f', '');\r\n\r\n", $point->latitude, $point->longitude);

						$str .= sprintf("    lineArray.push(line);\r\n\r\n");
					}
					else
					{
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