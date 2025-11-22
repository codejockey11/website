<?php
require_once "../includes.php";

$query = null;

if (isset($_POST["query"]))
{
	$query = trim($_POST["query"]);
}
?>

<!DOCTYPE html>
<html>

<head>
<title>Sql Query</title>
<meta charset="UTF-8">
<link rel="shortcut icon" href="../favicon.ico">
<link rel="stylesheet" href="../base.css?v=1">
</head>

<body>

<form name="mainForm" method="post" action="<?php printf("query.php?id=%s", $sess->sessionId);?>" >
	<table>
		<tr>
			<td><input name="query" type="text" size="200" value="<?php echo $query;?>" spellcheck="false" AUTOFOCUS /></td>
			<td><input type="submit" value="Go" class="smallButton"/></td>
		</tr>
	</table>
</form>

<?php
if ($query)
{
	$sqlDbase = new Database();
	
	$sqlDbase->ExecSql($query);

	if ($sqlDbase->GetRowCount() > 0)
	{
		$row = $sqlDbase->FetchRow();

		printf("%s\r\n<br/>", $sqlDbase->GetRowCount());

		printf("<table class=\"sqler\">");

		$head = null;

		foreach ($row as $key => $val)
		{
			$head .= "<th>" . $key . "</th>";// . ": ";// . $val . "\n";
		}

		printf("%s", $head);

		while($row)
		{
			printf("<tr>");

			foreach ($row as $r)
			{
				printf("<td>%s</td>", $r);
			}

			printf("</tr>");

			$row = $sqlDbase->FetchRow();
		}

		printf("</table>");
	}

	$sqlDbase->Disconnect();
}
?>

<table class="sqlertext">
	<tr>
		<td>
		SELECT a.facilityId, a.name, a.city, a.state, r.runwayid, r.length FROM aptAirport a, aptrunway r WHERE a.facilityId=r.facilityId AND a.state='OH' AND r.length>'3000' AND r.length<'5000' AND CHAR_LENGTH(r.length) > 3 ORDER BY a.city<br/>
		SELECT facilityId, city, state, airframeRepair, powerplantRepair FROM aptAirport WHERE airframeRepair='MAJOR' OR airframeRepair='MINOR' OR powerplantRepair='MAJOR' OR powerplantRepair='MINOR' ORDER BY state, city<br/>
		SELECT a.facilityId, a.name, a.city, a.state FROM navNavaid n, aptAirport a WHERE n.type='VOT' AND a.facilityId=n.facilityId ORDER BY a.state, a.city<br/>
		SELECT ICAO, name, elevation FROM aptAirport WHERE elevation<='0'<br/>
		SELECT * FROM navNavaid  WHERE type!='NDB' AND facilityId IN (SELECT facilityId FROM navNavaid WHERE type='NDB')<br/>
		SELECT a.facilityId, a.name, f.type, f.freq FROM aptAirport a, twrFrequency f WHERE a.state='WV' AND a.facilityId=f.facilityId AND f.type LIKE '%Z%' AND f.freq<'2' ORDER BY a.facilityId<br/>
		SELECT ICAO,name,city,state FROM aptAirport WHERE facilityId IN (SELECT facilityId FROM twrAirspace WHERE classD!='' AND classE='') ORDER BY state,city,name<br/>
		<br/>
		UPDATE parameter SET value1='3/1/2018' WHERE name='effectiveDate'<br/>
		DROP INDEX aptIndex ON aptAirport<br/>
		SHOW INDEX FROM aptAirport<br/>
		SELECT * FROM dTPP WHERE facilityId NOT IN (SELECT facilityId FROM chartSupplement)<br/>
		DELETE FROM session WHERE ts<=(NOW() - INTERVAL 15 MINUTE)<br/>
		SHOW status LIKE '%qcach%'<br/>
		SELECT DISTINCT facilityId,siapId,transition FROM cifp WHERE fixId='' AND navaid='' AND legType!='CA' AND legType!='VI' AND legType!='VA' AND legType!='CI'<br/>
		<br/>
		<?php
		if (isset($GLOBALS["userProfile"]))
		{
			$dcs = null;
	
			$dtpp = array();

			$d = dir($GLOBALS["userProfile"] . "/Downloads");

			$e = $d->read();

			while ($e)
			{
				$ss = substr($e, 0, 4);

				if ($ss == "DCS_")
				{
					$dcs = $GLOBALS["userProfile"] . "/Downloads/" . $e;
				}

				$ss = substr($e, 0, 5);

				if ($ss == "DDTPP")
				{
					array_push($dtpp, $GLOBALS["userProfile"] . "/Downloads/" . $e);
				}

				$e = $d->read();
			}

			$d->close();

			printf("%s\r\n<br/>", $dcs);

			foreach ($dtpp as $d)
			{
				printf("%s\r\n<br/>", $d);
			}

			printf("\r\n<br/><b class=\"sqlerheading\">ENV</b><br/>");

			printf("%s\r\n<br/>", $GLOBALS["userProfile"]);

			foreach ($_ENV as $key => $val)
			{
				printf("<br/><b>%s</b>" . ":<br/>%s", $key, str_replace(";", "<br/>", $val));

				printf("<br/>");
			}
		}

		printf("\r\n<br/><b class=\"sqlerheading\">SERVER</b><br/>");

		foreach ($_SERVER as $key => $val)
		{
			printf("<br/><b>%s</b>" . ":<br/>%s", $key, str_replace(";", "<br/>", $val));

			printf("<br/>");
		}
		?>
		</td>
	</tr>
</table>

</body>
</html>