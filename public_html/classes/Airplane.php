<?php
class AirplaneData
{
	public $pilotId;
	public $registration;
	public $plane;
	public $cruiseSpeed;
	public $color;
	public $equip;
	public $taxiDepart;
	public $climb;
	public $enroute;
	public $descent;
	public $trafficPattern;
	public $taxiArrive;
	public $gph;
	public $emptyWeight;
	public $emptyArm;
	public $fuelGallons;
	public $fuelArm;
	public $station01Weight;
	public $station01Arm;
	public $station02Weight;
	public $station02Arm;
	public $station03Weight;
	public $station03Arm;
	public $station04Weight;
	public $station04Arm;
	public $station05Weight;
	public $station05Arm;
	public $station06Weight;
	public $station06Arm;
	public $station07Weight;
	public $station07Arm;
	public $station08Weight;
	public $station08Arm;
	public $maxGrossWeight;
	public $fuelTypeWeight;
	public $hobbs;
	public $tach;
	public $maxFuel;
	public $maxCargo;
	public $notes;

	public $sess;

	public $enrouteTime;

	public function __construct($sess)
	{
		$this->sess = $sess;
	}

	public function FormatEntry()
	{
		return sprintf("<a href=\"index.php?id=%s&reg=%s\">%s:%s</a>\r\n", $this->sess->sessionId, $this->registration, $this->registration, $this->plane);
	}

	public function FuelBurnItems()
	{
		$tfb = 0;

		$p = explode(",", $this->taxiDepart);

		if (count($p) == 2)
		{
			$tfb += (($p[0]/60) * $p[1]);
		}

		$p = explode(",", $this->climb);

		if (count($p) == 2)
		{
			$tfb += (($p[0]/60) * $p[1]);
		}

		$p = explode(",", $this->enroute);

		if (count($p) == 2)
		{
			$tfb += (($p[0]/60) * $p[1]);
		}

		$p = explode(",", $this->descent);

		if (count($p) == 2)
		{
			$tfb += (($p[0]/60) * $p[1]);
		}

		$p = explode(",", $this->trafficPattern);

		if (count($p) == 2)
		{
			$tfb += (($p[0]/60) * $p[1]);
		}

		$p = explode(",", $this->taxiArrive);

		if (count($p) == 2)
		{
			$tfb += (($p[0]/60) * $p[1]);
		}

		return $tfb;
	}

	public function FuelBurn()
	{
		$tfb = $this->FuelBurnItems();

		if ($tfb <= $this->fuelGallons)
		{
			$str = sprintf("\r\n<br/>Fuel Burn:%dmin. %dGal. %dlb. On Board:%dGal. %dlb. %dmin.",
					$this->enrouteTime,
					$tfb,
					$tfb * $this->fuelTypeWeight,
					$this->fuelGallons,
					$this->fuelGallons * $this->fuelTypeWeight,
					$this->fuelGallons / ($this->gph / 60));
		}
		else
		{
			$str = sprintf("\r\n<br/><b class=\"planeInfoError\">Check Fuel<br/>Fuel Burn:%dmin. %dGal. %dlb. On Board:%dGal. %dlb. %dmin.</b>",
					$this->enrouteTime,
					$tfb,
					$tfb * $this->fuelTypeWeight,
					$this->fuelGallons,
					$this->fuelGallons * $this->fuelTypeWeight,
					$this->fuelGallons / ($this->gph / 60));
		}

		return $str;
	}

	public function FormatCG()
	{
		$tfw = 0;

		$zfw = $this->emptyWeight;

		$zfm = $this->emptyWeight * $this->emptyArm;

		$str  = sprintf("&nbsp;&nbsp;&nbsp;&nbsp;Station&nbsp;&nbsp;&nbsp;&nbsp;Weight&nbsp;&nbsp;&nbsp;Arm&nbsp;&nbsp;&nbsp;&nbsp;Moment");

		$str .= sprintf("\r\n&nbsp;&nbsp;&nbsp;---------&nbsp;&nbsp;--------&nbsp;------&nbsp;---------");

		$str .= sprintf("\r\n&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Empty&nbsp;&nbsp;&nbsp;&nbsp;%s&nbsp;%s&nbsp;%s",
				RemoveLeadingZeroes(sprintf("%08.2f", $this->emptyWeight), 1),
				RemoveLeadingZeroes(sprintf("%06.2f", $this->emptyArm), 1),
				RemoveLeadingZeroes(sprintf("%09.2f", $this->emptyWeight * $this->emptyArm), 1));

		if (($this->fuelGallons != 0) && ($this->fuelArm != 0))
		{
			$tfw = $this->fuelGallons * $this->fuelTypeWeight;

			$str .= sprintf("\r\n&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Fuel&nbsp;&nbsp;&nbsp;&nbsp;%s&nbsp;%s&nbsp;%s",
					RemoveLeadingZeroes(sprintf("%08.2f", $tfw), 1),
					RemoveLeadingZeroes(sprintf("%06.2f", $this->fuelArm), 1),
					RemoveLeadingZeroes(sprintf("%09.2f", $tfw * $this->fuelArm), 1));

			$zfw += $tfw;

			$zfm += $tfw * $this->fuelArm;
		}

		if (($this->station01Weight != 0) && ($this->station01Arm != 0))
		{
			$str .= sprintf("\r\n&nbsp;&nbsp;&nbsp;Station 1&nbsp;&nbsp;%s&nbsp;%s&nbsp;%s",
					RemoveLeadingZeroes(sprintf("%08.2f", $this->station01Weight), 1),
					RemoveLeadingZeroes(sprintf("%06.2f", $this->station01Arm), 1),
					RemoveLeadingZeroes(sprintf("%09.2f", $this->station01Weight * $this->station01Arm), 1));

			$zfw += $this->station01Weight;

			$zfm += $this->station01Weight * $this->station01Arm;
		}

		if (($this->station02Weight != 0) && ($this->station02Arm != 0))
		{
			$str .= sprintf("\r\n&nbsp;&nbsp;&nbsp;Station 2&nbsp;&nbsp;%s&nbsp;%s&nbsp;%s",
					RemoveLeadingZeroes(sprintf("%08.2f", $this->station02Weight), 1),
					RemoveLeadingZeroes(sprintf("%06.2f", $this->station02Arm), 1),
					RemoveLeadingZeroes(sprintf("%09.2f", $this->station02Weight * $this->station02Arm), 1));

			$zfw += $this->station02Weight;

			$zfm += $this->station02Weight * $this->station02Arm;
		}

		if (($this->station03Weight != 0) && ($this->station03Arm != 0))
		{
			$str .= sprintf("\r\n&nbsp;&nbsp;&nbsp;Station 3&nbsp;&nbsp;%s&nbsp;%s&nbsp;%s",
					RemoveLeadingZeroes(sprintf("%08.2f", $this->station03Weight), 1),
					RemoveLeadingZeroes(sprintf("%06.2f", $this->station03Arm), 1),
					RemoveLeadingZeroes(sprintf("%09.2f", $this->station03Weight * $this->station03Arm), 1));

			$zfw += $this->station03Weight;

			$zfm += $this->station03Weight * $this->station03Arm;
		}

		if (($this->station04Weight != 0) && ($this->station04Arm != 0))
		{
			$str .= sprintf("\r\n&nbsp;&nbsp;&nbsp;Station 4&nbsp;&nbsp;%s&nbsp;%s&nbsp;%s",
					RemoveLeadingZeroes(sprintf("%08.2f", $this->station04Weight), 1),
					RemoveLeadingZeroes(sprintf("%06.2f", $this->station04Arm), 1),
					RemoveLeadingZeroes(sprintf("%09.2f", $this->station04Weight * $this->station04Arm), 1));

			$zfw += $this->station04Weight;

			$zfm += $this->station04Weight * $this->station04Arm;
		}

		if (($this->station05Weight != 0) && ($this->station05Arm != 0))
		{
			$str .= sprintf("\r\n&nbsp;&nbsp;&nbsp;Station 5&nbsp;&nbsp;%s&nbsp;%s&nbsp;%s",
					RemoveLeadingZeroes(sprintf("%08.2f", $this->station05Weight), 1),
					RemoveLeadingZeroes(sprintf("%06.2f", $this->station05Arm), 1),
					RemoveLeadingZeroes(sprintf("%09.2f", $this->station05Weight * $this->station05Arm), 1));

			$zfw += $this->station05Weight;

			$zfm += $this->station05Weight * $this->station05Arm;
		}

		if (($this->station06Weight != 0) && ($this->station06Arm != 0))
		{
			$str .= sprintf("\r\n&nbsp;&nbsp;&nbsp;Station 6&nbsp;&nbsp;%s&nbsp;%s&nbsp;%s",
					RemoveLeadingZeroes(sprintf("%08.2f", $this->station06Weight), 1),
					RemoveLeadingZeroes(sprintf("%06.2f", $this->station06Arm), 1),
					RemoveLeadingZeroes(sprintf("%09.2f", $this->station06Weight * $this->station06Arm), 1));

			$zfw += $this->station06Weight;

			$zfm += $this->station06Weight * $this->station06Arm;
		}

		if (($this->station07Weight != 0) && ($this->station07Arm != 0))
		{
			$str .= sprintf("\r\n&nbsp;&nbsp;&nbsp;Station 7&nbsp;&nbsp;%s&nbsp;%s&nbsp;%s",
					RemoveLeadingZeroes(sprintf("%08.2f", $this->station07Weight), 1),
					RemoveLeadingZeroes(sprintf("%06.2f", $this->station07Arm), 1),
					RemoveLeadingZeroes(sprintf("%09.2f", $this->station07Weight * $this->station07Arm), 1));

			$zfw += $this->station07Weight;

			$zfm += $this->station07Weight * $this->station07Arm;
		}

		if (($this->station08Weight != 0) && ($this->station08Arm != 0))
		{
			$str .= sprintf("\r\n&nbsp;&nbsp;&nbsp;Station 8&nbsp;&nbsp;%s&nbsp;%s&nbsp;%s",
					RemoveLeadingZeroes(sprintf("%08.2f", $this->station08Weight), 1),
					RemoveLeadingZeroes(sprintf("%06.2f", $this->station08Arm), 1),
					RemoveLeadingZeroes(sprintf("%09.2f", $this->station08Weight * $this->station08Arm), 1));

			$zfw += $this->station08Weight;

			$zfm += $this->station08Weight * $this->station08Arm;
		}

		$zfa = 0;

		if (($zfw) && ($zfw != 0))
		{
			$zfa = $zfm / $zfw;
		}

		$tfw = $this->fuelGallons * $this->fuelTypeWeight;

		if ($zfw != 0)
		{
			$str .= sprintf("\r\n&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Total&nbsp;&nbsp;&nbsp;&nbsp;%s&nbsp;%s&nbsp;%s",
				RemoveLeadingZeroes(sprintf("%08.2f", $zfw), 1),
				RemoveLeadingZeroes(sprintf("%06.2f", ($zfm / $zfw)), 1),
				RemoveLeadingZeroes(sprintf("%09.2f", $zfm), 1));
		}

		$tfb = $this->FuelBurnItems();

		if ($this->fuelGallons == 0)
		{
			$str .= sprintf("\r\n\r\n&nbsp;&nbsp;&nbsp;zero fuel weight:%s",
					RemoveLeadingZeroes(sprintf("%08.2f", $zfw), 1));
		}
		else
		{
			$str .= sprintf("\r\n\r\n&nbsp;&nbsp;&nbsp;with fuel weight:%s",
					RemoveLeadingZeroes(sprintf("%08.2f", $zfw), 1));

			$str .= sprintf("\r\n&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;landing weight:%s",
					RemoveLeadingZeroes(sprintf("%08.2f", $zfw - (intval($tfb) * $this->fuelTypeWeight)), 1));
		}

		if ($this->fuelTypeWeight != 0)
		{
			$str .= sprintf("\r\n");

			if (($this->maxGrossWeight - $zfw) < 0)
			{
				$str .= sprintf("&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;OVERWEIGHT:%s&nbsp;%s",
						RemoveLeadingZeroes(sprintf("%8.2f", $this->maxGrossWeight - $zfw), 1),
						RemoveLeadingZeroes(sprintf("%7.2f gal", ($this->maxGrossWeight - $zfw) / $this->fuelTypeWeight), 1));
			}
			else
			{
				$str .= sprintf("&nbsp;&nbsp;&nbsp;available weight:%s&nbsp;%s",
						RemoveLeadingZeroes(sprintf("%8.2f", $this->maxGrossWeight - $zfw), 1),
						RemoveLeadingZeroes(sprintf("%7.2f gal", ($this->maxGrossWeight - $zfw) / $this->fuelTypeWeight), 1));
			}
		}

		return $str;
	}

	public function FormatPrintable()
	{
		$str  = sprintf("<table><tr><td class=\"planePrint\">\r\n");

		$str .= sprintf("Airplane:%s", $this->registration);

		$str .= sprintf(" %s", $this->plane);

		$str .= sprintf(" Equipment:%s", $this->equip);

		$str .= sprintf(" Color:%s", $this->color);

		$str .= $this->FuelBurn();

		$str .= sprintf("</tr><tr><td class=\"planePrint\" colspan=\"3\">\r\n");

		$str .= sprintf("CG:<br/>\r\n");

		$str .= sprintf("%s", str_replace("\r\n", "<br/>", str_replace(" ", "&nbsp", $this->FormatCG())));

		$str .= sprintf("</td></tr><tr><td class=\"planePrint\" colspan=\"3\">\r\n");

		$str .= sprintf("<br/>Notes:<br/>");

		if ($this->notes)
		{
			$n = str_replace("\r\n", "<br/>", $this->notes);

			$n = str_replace(" ", "&nbsp;", $n);

			$str .= sprintf("%s", $n);
		}

		$str .= sprintf("</td></tr></table>\r\n");

		return $str;
	}
}

class Airplane
{
	public $sess;
	public $airplane = array();

	public function __construct($sess, $reg)
	{
		$this->sess = $sess;

		if ($reg == null)
		{
			$sql = sprintf("SELECT * FROM airplane WHERE pilotId='%s'", $this->sess->pilotId);
		}
		else
		{
			$sql = sprintf("SELECT * FROM airplane WHERE pilotId='%s' AND registration='%s'", $this->sess->pilotId, $reg);
		}

		$airplaneDbase = new Database();

		$airplaneDbase->ExecSql($sql);

		if ($airplaneDbase->GetRowCount() > 0)
		{
			while($row = $airplaneDbase->FetchRow())
			{
				$this->GetRow($row);
			}
		}
		else
		{
			$this->airplane = null;
		}

		$airplaneDbase->Disconnect();
	}

	public function GetRow($row)
	{
		$airplaneData = new AirplaneData($this->sess);

		$airplaneData->pilotId = $row["pilotId"];
		$airplaneData->registration = $row["registration"];
		$airplaneData->plane = $row["plane"];
		$airplaneData->cruiseSpeed = floatval($row["cruiseSpeed"]);
		$airplaneData->color = $row["color"];
		$airplaneData->equip = $row["equip"];
		$airplaneData->taxiDepart = $row["taxiDepart"];
		$airplaneData->climb = $row["climb"];
		$airplaneData->enroute = $row["enroute"];
		$airplaneData->gph = floatval($row["gph"]);
		$airplaneData->descent = $row["descent"];
		$airplaneData->trafficPattern = $row["trafficPattern"];
		$airplaneData->taxiArrive = $row["taxiArrive"];
		$airplaneData->emptyWeight = floatval($row["emptyWeight"]);
		$airplaneData->emptyArm = floatval($row["emptyArm"]);
		$airplaneData->fuelGallons = floatval($row["fuelGallons"]);
		$airplaneData->fuelArm = floatval($row["fuelArm"]);
		$airplaneData->station01Weight = floatval($row["station01Weight"]);
		$airplaneData->station01Arm = floatval($row["station01Arm"]);
		$airplaneData->station02Weight = floatval($row["station02Weight"]);
		$airplaneData->station02Arm = floatval($row["station02Arm"]);
		$airplaneData->station03Weight = floatval($row["station03Weight"]);
		$airplaneData->station03Arm = floatval($row["station03Arm"]);
		$airplaneData->station04Weight = floatval($row["station04Weight"]);
		$airplaneData->station04Arm = floatval($row["station04Arm"]);
		$airplaneData->station05Weight = floatval($row["station05Weight"]);
		$airplaneData->station05Arm = floatval($row["station05Arm"]);
		$airplaneData->station06Weight = floatval($row["station06Weight"]);
		$airplaneData->station06Arm = floatval($row["station06Arm"]);
		$airplaneData->station07Weight = floatval($row["station07Weight"]);
		$airplaneData->station07Arm = floatval($row["station07Arm"]);
		$airplaneData->station08Weight = floatval($row["station08Weight"]);
		$airplaneData->station08Arm = floatval($row["station08Arm"]);
		$airplaneData->maxGrossWeight = floatval($row["maxGrossWeight"]);
		$airplaneData->fuelTypeWeight = floatval($row["fuelTypeWeight"]);
		$airplaneData->hobbs = floatval($row["hobbs"]);
		$airplaneData->tach = floatval($row["tach"]);
		$airplaneData->maxFuel = floatval($row["maxFuel"]);
		$airplaneData->maxCargo = floatval($row["maxCargo"]);
		$airplaneData->notes = $row["notes"];

		$e = explode(",", $airplaneData->enroute);

		$airplaneData->enrouteTime = $e[0];

		array_push($this->airplane, $airplaneData);
	}

	public function GetSingle($i)
	{
		if ($this->airplane == null)
		{
			return;
		}

		return $this->airplane[$i];
	}

	public function ListEntries()
	{
		if ($this->airplane == null)
		{
			return;
		}

		$str = null;

		$c = 0;

		foreach ($this->airplane as $pln)
		{
			switch($c)
			{
				case 4:
				case 8:
				case 12:
				case 16:
				case 20:
				{
					$str .= "<br/>";

					break;
				}

				default:
				{
					break;
				}
			}

			$str .= $pln->FormatEntry();

			$c++;
		}

		return $str;
	}

	public function AddAirplane($ci, $id, $p, $cs, $clr, $xp, $td, $cl, $en, $d, $tp, $ta, $gph, $ew, $ea, $fg, $fa, $s01w, $s01a, $s02w, $s02a, $s03w, $s03a, $s04w, $s04a, $s05w, $s05a, $s06w, $s06a, $s07w, $s07a, $s08w, $s08a, $mgw, $ftw, $hm, $hc, $mf, $mb, $n)
	{
		$sql = sprintf("INSERT INTO airplane (pilotId,registration,plane,cruiseSpeed,color,equip,taxiDepart,climb,enroute,descent,trafficPattern,taxiArrive,gph,emptyWeight,emptyArm,fuelGallons,fuelArm,station01Weight,station01Arm,station02Weight,station02Arm,station03Weight,station03Arm,station04Weight,station04Arm,station05Weight,station05Arm,station06Weight,station06Arm,station07Weight,station07Arm,station08Weight,station08Arm,maxGrossWeight,fuelTypeWeight,hobbs,tach,maxFuel,maxCargo,notes)
			VALUES ('%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s')",
			$ci->pilotId, $id, $p, $cs, $clr, $xp, $td, $cl, $en, $d, $tp, $ta, $gph, $ew, $ea, $fg, $fa, $s01w, $s01a, $s02w, $s02a, $s03w, $s03a, $s04w, $s04a, $s05w, $s05a, $s06w, $s06a, $s07w, $s07a, $s08w, $s08a, $mgw, $ftw, $hm, $hc, $mf, $mb, $n);

		$airplaneDbase = new Database();

		$airplaneDbase->ExecSql($sql);

		$airplaneDbase->Disconnect();
	}

	public function DeleteAirplane($ci, $reg)
	{
		$sql = sprintf("DELETE FROM airplane WHERE pilotId='%s' AND registration='%s'", $ci->pilotId, $reg);

		$airplaneDbase = new Database();

		$airplaneDbase->ExecSql($sql);

		$airplaneDbase->Disconnect();
	}

	public function UpdateAirplane($ci, $id, $p, $cs, $clr, $xp, $td, $cl, $en, $d, $tp, $ta, $gph, $ew, $ea, $fg, $fa, $s01w, $s01a, $s02w, $s02a, $s03w, $s03a, $s04w, $s04a, $s05w, $s05a, $s06w, $s06a, $s07w, $s07a, $s08w, $s08a, $mgw, $ftw, $hm, $hc, $mf, $mb, $n)
	{
		$sql = sprintf("UPDATE airplane SET plane='%s', cruiseSpeed='%s', color='%s', equip='%s', taxiDepart='%s', climb='%s', enroute='%s', descent='%s', trafficPattern='%s', taxiArrive='%s', gph='%s', emptyWeight='%s', emptyArm='%s', fuelGallons='%s', fuelArm='%s', station01Weight='%s', station01Arm='%s', station02Weight='%s', station02Arm='%s', station03Weight='%s', station03Arm='%s', station04Weight='%s', station04Arm='%s', station05Weight='%s', station05Arm='%s', station06Weight='%s', station06Arm='%s', station07Weight='%s', station07Arm='%s', station08Weight='%s', station08Arm='%s', maxGrossWeight='%s', fuelTypeWeight='%s', hobbs='%s', tach='%s', maxFuel='%s', maxCargo='%s', notes='%s'
			WHERE pilotId='%s' AND registration='%s'", $p, $cs, $clr, $xp, $td, $cl, $en, $d, $tp, $ta, $gph, $ew, $ea, $fg, $fa, $s01w, $s01a, $s02w, $s02a, $s03w, $s03a, $s04w, $s04a, $s05w, $s05a, $s06w, $s06a, $s07w, $s07a, $s08w, $s08a, $mgw, $ftw, $hm, $hc, $mf, $mb, $n, $ci->pilotId, $id);

		$airplaneDbase = new Database();

		$airplaneDbase->ExecSql($sql);

		$airplaneDbase->Disconnect();
	}
}
?>