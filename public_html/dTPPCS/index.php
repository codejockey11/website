<?php
require_once "../includes.php";

$pdf = null;

if (isset($_GET["pdf"]))
{
	$pdf = $_GET["pdf"];
}

$type = null;

if (isset($_GET["type"]))
{
	$type = $_GET["type"];
}

$ident = null;

if (isset($_GET["ident"]))
{
	$ident = $_GET["ident"];
}

$pdfident = null;

if (isset($_POST["pdfident"]))
{
	$pdfident = trim(strtoupper($_POST["pdfident"]));
}
else
{
	$pdfident = $sess->pdfIdent;
}

if (isset($_POST["resetForm"]))
{
	$pdfident = null;
}

$sess->SetSessionVariable("pdfident", $pdfident);

$url = "../dTPPCS/empty.php?id=" . $sess->sessionId;

if ($type == null)
{
	if ($pdfident)
	{
		if (strlen($pdfident) >= 5)
		{
			$sql = sprintf("SELECT * FROM chartSupplement USE INDEX(chartSupplementNavaidName) WHERE navaidName='%s'", $pdfident);
		}
		else
		{
			$sql = sprintf("SELECT * FROM chartSupplement USE INDEX(chartSupplementFacilityId) WHERE facilityId='%s'", $pdfident);
		}

		$cs = new ChartSupplement($sess, $sql);

		$pdf = $cs->GetFirstDocument();

		if ($pdf)
		{
			$cs->CheckDocumentCache($pdf);

			$url = sprintf("../dTPPCS/cs/%s?id=%s", $pdf, $sess->sessionId);
		}
	}
	else if ($sess->airport)
	{
		if (strlen($sess->airport) == 3)
		{
			$sql = sprintf("SELECT * FROM aptAirport USE INDEX(aptAirportFacilityId) WHERE facilityId='%s'", $sess->airport);	
		}
		else
		{
			$sql = sprintf("SELECT * FROM aptAirport USE INDEX(aptAirportICAO) WHERE ICAO='%s'", $sess->airport);	
		}
		
		$sapt = new Airport($sess, $sql);

		$sql = sprintf("SELECT * FROM chartSupplement USE INDEX(chartSupplementFacilityId) WHERE facilityId='%s'", $sapt->GetSingle(0)->facilityId);

		$cs = new ChartSupplement($sess, $sql);

		$pdf = $cs->GetFirstDocument();

		if ($pdf)
		{
			$cs->CheckDocumentCache($pdf);

			$url = sprintf("../dTPPCS/cs/%s?id=%s", $pdf, $sess->sessionId);
		}
	}
	else if ($sess->navaid)
	{
		if (strlen($sess->navaid) > 3)
		{
			$sql = sprintf("SELECT * FROM navNavaid USE INDEX(navNavaidName) WHERE name='%s' AND type!='VOT'", $sess->navaid);
		}
		else
		{
			$sql = sprintf("SELECT * FROM navNavaid USE INDEX(navNavaidFacilityId) WHERE facilityId='%s' AND type!='VOT'", $sess->navaid);
		}

		$snav = new Navaid($sess, $sql);

		$sql = sprintf("SELECT * FROM chartSupplement USE INDEX(chartSupplementNavaidName) WHERE navaidName='%s'", $snav->GetSingle(0)->name);

		$cs = new ChartSupplement($sess, $sql);

		$pdf = $cs->GetFirstDocument();

		if ($pdf)
		{
			$cs->CheckDocumentCache($pdf);

			$url = sprintf("../dTPPCS/cs/%s?id=%s", $pdf, $sess->sessionId);
		}
	}

	$td = SetFrame($url);
}

if ($type == "cs")
{
	if ($pdf)
	{
		if (strlen($ident) >= 5)
		{
			$sql = sprintf("SELECT * FROM chartSupplement USE INDEX(chartSupplementNavaidName) WHERE navaidName='%s'", $ident);
		}
		else
		{
			$sql = sprintf("SELECT * FROM chartSupplement USE INDEX(chartSupplementFacilityId) WHERE facilityId='%s'", $ident);
		}

		$cs = new ChartSupplement($sess, $sql);

		$cs->CheckDocumentCache($pdf);

		$url = sprintf("../dTPPCS/cs/%s?id=%s", $pdf, $sess->sessionId);
	}

	$td = SetFrame($url);
}

if ($type == "dTPP")
{
	if ($pdf)
	{
		$sql = sprintf("SELECT * FROM dTPP USE INDEX(dTPPFacilityId) WHERE facilityId='%s' ORDER BY chartCode,title ASC", $ident);

		$dtp = new DigitalTerminalProcedure($sess, $sql);

		$dtp->CheckDocumentCache($pdf);

		$url = sprintf("../dTPPCS/dTPP/%s?id=%s", $pdf, $sess->sessionId);
	}

	$td = SetFrame($url);
}

if ($type == "cmp")
{
	if ($pdf)
	{
		$sql = sprintf("SELECT * FROM compares USE INDEX(comparesFacilityId) WHERE facilityId='%s' ORDER BY chartCode,title ASC", $ident);

		$cmp = new Compares($sess, $sql);

		$cmp->CheckDocumentCache($pdf);

		$url = sprintf("../dTPPCS/compare_pdf/%s?id=%s", $pdf, $sess->sessionId);
	}

	$td = SetFrame($url);
}

// flight plan
$fn = sprintf("../temp/pdfMenu_%s.html", $sess->sessionId);

if (file_exists($fn) === true)
{
	if (filesize($fn) > 0)
	{
		$r = strpos($url, "empty");

		if ($r > 0)
		{
			$wps = explode(" ", $sess->waypoints);

			$wp = explode(";", $wps[count($wps) - 1]);

			if (strlen($wp[1]) == 3)
			{
				$sql = sprintf("SELECT * FROM aptAirport USE INDEX(aptAirportFacilityId) WHERE facilityId='%s'", $wp[1]);	
			}
			else
			{
				$sql = sprintf("SELECT * FROM aptAirport USE INDEX(aptAirportICAO) WHERE ICAO='%s'", $wp[1]);	
			}

			$a = new Airport($sess, $sql);

			if ($a->airport)
			{
				$sql = sprintf("SELECT * FROM chartSupplement USE INDEX(chartSupplementFacilityId) WHERE facilityId='%s'", $a->GetSingle(0)->facilityId);

				$cs = new ChartSupplement($sess, $sql);

				$pdf = $cs->GetFirstDocument();

				if ($pdf)
				{
					$cs->CheckDocumentCache($pdf);

					$url = sprintf("../dTPPCS/cs/%s?id=%s", $pdf, $sess->sessionId);
				}
			}
		}

		$td = SetFrame($url);
	}
}

function SetFrame($url)
{
	$str = sprintf("<td>\r\n<iframe class=\"pdfFrame\" src=\"%s#view=FitH\"></iframe>\r\n</td>\r\n", $url);

	return $str;
}
?>

<!DOCTYPE html>
<html>

<head>
<title>dTPP CS View</title>
<meta charset="UTF-8">
<link rel="shortcut icon" href="../favicon.ico">
<link rel="stylesheet" href="../base.css?v=1">
<script type="text/javascript" src="../base.js?v=1"></script>
</head>

<body>

<table class="topPanel">
	<tr>
		<td><?php require_once "../navSignOn.php";?></td>
	</tr>
</table>

<table class="mainForm">
	<tr>
		<td>
		<form name="mainForm" method="post" action="<?php printf("index.php?id=%s", $sess->sessionId);?>" >
		<table>
			<tr>
				<td class="centerLabel">Facility Ident or Navaid Name</td>
			</tr>
			<tr>
				<td><input name="pdfident" type="text" size="30" value="<?php echo $pdfident;?>" AUTOFOCUS /></td>
				<td><input type="submit" value="Get" class="button" /></td>
				<td><input type="submit" value="Reset" name="resetForm" class="button" /></td>
			</tr>
		</table>
		</form>
		</td>

		<?php
		if (strpos($url, "empty") === false)
		{
			printf("<td style=\"vertical-align:bottom;text-align:left;width:800px;padding-left:0px;padding-bottom:4px;\"><button id=\"airplaneLink\" class=\"button\" onclick=\"window.location.href='%s#zoom=150'\">ViewDoc</button></td>\r\n", $url);
		}
		?>
	</tr>
</table>

<table class="pageResult">
	<tr>
		<td>
		<table>
			<tr>
				<td class="pdfmenu">
				<?php
				if ($pdfident)
				{
					if (strlen($pdfident) == 3)
					{
						$sql = sprintf("SELECT * FROM aptAirport USE INDEX(aptAirportFacilityId) WHERE facilityId='%s'", $pdfident);

						$a = new Airport($sess, $sql);

						if ($a->airport)
						{
							$sa = $a->GetSingle(0);

							$f1 = strpos($sess->waypoints, $sa->ICAO);

							if ($f1 === false)
							{
								printf("%s<br/>\r\n", $a->DTPPMenu());
							}
						}
					}
					else if (strlen($pdfident) == 5)
					{
						$sql = sprintf("SELECT * FROM fixLocation USE INDEX(fixLocationFixId) WHERE fixId='%s'", $pdfident);

						$f = new Fix($sess, $sql);

						if ($f->fix)
						{
							$sf = $f->GetSingle(0);

							$f1 = strpos($sess->waypoints, $sf->fixId);

							if ($f1 === false)
							{
								printf("%s<br/>\r\n", $sf->FormatDTPPMenu());
							}
						}
					}
					else
					{
						$sql = sprintf("SELECT * FROM navNavaid USE INDEX(navNavaidName) WHERE name='%s'", $pdfident);

						$n = new Navaid($sess, $sql);

						if ($n->navaid)
						{
							foreach ($n->navaid as $nav)
							{
								$f1 = strpos($sess->waypoints, $nav->facilityId);

								if (($f1 === false) && ($nav->facilityId != $sess->navaid))
								{
									printf("%s<br/>\r\n", $nav->FormatDTPPMenu());
								}
							}
						}
					}
				}

				// flight plan
				$fn = sprintf("../temp/pdfMenu_%s.html", $sess->sessionId);

				if (file_exists($fn) === true)
				{
					if (filesize($fn) > 0)
					{
						$fp = fopen($fn, "r");

						$s = fread($fp, filesize($fn));

						printf("%s", $s);

						fclose($fp);
					}
				}


				if ($sess->airport)
				{
					if (strlen($sess->airport) == 3)
					{
						$sql = sprintf("SELECT * FROM aptAirport USE INDEX(aptAirportFacilityId) WHERE facilityId='%s'", $sess->airport);	
					}
					else
					{
						$sql = sprintf("SELECT * FROM aptAirport USE INDEX(aptAirportICAO) WHERE ICAO='%s'", $sess->airport);	
					}
	
					$sapt = new Airport($sess, $sql);

					$sa = $sapt->GetSingle(0);

					$f1 = strpos($sess->waypoints, $sa->ICAO);

					if (($sa->facilityId != $pdfident) && ($f1 === false))
					{
						printf("<br/>%s\r\n", $sa->FormatDTPPMenu());
					}
				}

				if ($sess->navaid)
				{
					if (strlen($sess->navaid) > 3)
					{
						$sql = sprintf("SELECT * FROM navNavaid USE INDEX(navNavaidName) WHERE name='%s'", $sess->navaid);

						$snav = new Navaid($sess, $sql);
					}
					else
					{
						$sql = sprintf("SELECT * FROM navNavaid USE INDEX(navNavaidFacilityId) WHERE facilityId='%s'", $sess->navaid);

						$snav = new Navaid($sess, $sql);
					}

					foreach ($snav->navaid as $nav)
					{
						$f1 = strpos($sess->waypoints, $nav->facilityId);

						if ($f1 === false)
						{
							printf("<br/>%s\r\n", $nav->FormatDTPPMenu());
						}
					}
				}

				if ($sess->fix)
				{
					$sql = sprintf("SELECT * FROM fixLocation USE INDEX(fixLocationFixId) WHERE fixId='%s'", $sess->fix);

					$f = new Fix($sess, $sql);

					if ($f->fix)
					{
						$sf = $f->GetSingle(0);

						$f1 = strpos($sess->waypoints, $sf->fixId);

						if ($f1 === false)
						{
							printf("<br/>%s\r\n", $sf->FormatDTPPMenu());
						}
					}
				}

				printf("</td>\r\n");

				if ($td)
				{
					printf("%s", $td);
				}
				?>
			</tr>
		</table>
		</td>
	</tr>
</table>

<table class="footer">
	<tr>
		<td><?php $f = new Footer();?></td>
	</tr>
</table>

</body>
</html>