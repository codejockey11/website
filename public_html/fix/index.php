<?php
require_once "../includes.php";

if (isset($_POST["fix"]))
{
	$fix = trim(strtoupper($_POST["fix"]));
}
else
{
	$fix = $sess->fix;
}

if (isset($_GET["ident"]))
{
	$fix = $_GET["ident"];
}

$key = null;

if (isset($_GET["key"]))
{
	$key = $_GET["key"];
}

if (isset($_POST["resetForm"]))
{
	$fix = null;
}

$f = null;

if ($key)
{
	$sql = sprintf("SELECT * FROM fixLocation WHERE id='%s'", $key);

	$f = new Fix($sess, $sql);

	$fix = $f->GetSingle(0)->fixId;
}
else
{
	$fx = explode(";", $fix);

	if (count($fx) == 2)
	{
		$sql = sprintf("SELECT * FROM fixLocation USE INDEX(fixLocationFixId) WHERE fixId='%s' AND region='%s' AND (fixUsage='REP-PT' || fixUsage='WAYPOINT' || fixUsage='CNF')", $fx[0], $fx[1]);

		$f = new Fix($sess, $sql);
	}
	else if ((strlen($fix) > 0) && (strlen($fix) < 5))
	{
		$sql = sprintf("SELECT * FROM fixLocation USE INDEX(fixLocationFixId) WHERE fixId>='%s' AND fixId<='%sZZZZZ' AND (fixUsage='REP-PT' || fixUsage='WAYPOINT' || fixUsage='CNF') ORDER BY state,fixId ASC", $fix, $fix);

		$f = new Fix($sess, $sql);

		if ($f->fix != null)
		{
			if (count($f->fix) == 1)
			{
				$fix = $f->GetSingle(0)->fixId;
			}
		}
	}
	else if ($fix)
	{
		$sql = sprintf("SELECT * FROM fixLocation USE INDEX(fixLocationFixId) WHERE fixId='%s'", $fix);

		$f = new Fix($sess, $sql);
	}
}

if ($f != null)
{
	if ($f->fix != null)
	{
		UpdateWaypoint($sess, "F;" . $f->GetSingle(0)->fixId . ";" . $f->GetSingle(0)->id);
	}
}

$sess->SetSessionVariable("fix", $fix);
?>

<!DOCTYPE html>
<html>

<head>
<title>Fix</title>
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
				<td class="centerLabel">Fix Ident</td>
			</tr>
			<tr>
				<td><input name="fix" type="text" size="15" value="<?php echo $fix;?>" AUTOFOCUS /></td>
				<td><input type="submit" value="Get" class="button" /></td>
				<td><input type="submit" value="Reset" name="resetForm" class="button" /></td>

				<?php WaypointDropdown($sess);?>
			</tr>
		</table>
		</form>
		</td>
	</tr>
</table>

<?php
if ($fix)
{
	if ($f->fix)
	{
		if (count($f->fix) > 1)
		{
			printf("<table class=\"pageResult\"><tr><td>");

			printf("%s", $f->ListEntries());

			printf("</td></tr></table>");
		}
		else
		{
			$fx = $f->GetSingle(0);

			if ($fx)
			{
				printf("<table class=\"pageResult\"><tr><td>");

				printf("<table>\r\n");
				printf("<tr>\r\n");
				printf("<td>\r\n");

				printf("%s", $fx->FormatBaseInfo());

				if ($fx->fixCharting->chart)
				{
					printf("\r\n<br/>");
					printf("\r\n<br/><b>CHARTING</b>\r\n");

					printf("%s", $fx->fixCharting->ListEntries());
				}

				if ($fx->fixNavaid->navaid)
				{
					printf("\r\n<br/>");
					printf("\r\n<br/><b>NAVAIDS</b>\r\n");

					printf("%s", $fx->fixNavaid->ListEntries());
				}

				if ($fx->fixIls->fixIls)
				{
					printf("\r\n<br/>");
					printf("\r\n<br/><b>ILS</b><br/>\r\n");

					printf("%s", $fx->fixIls->ListEntries());
				}

				printf("</td>\r\n");

				if ($fx->fixNavaid->navaid)
				{
					printf("<td>\r\n");
					printf("<table>\r\n");

					printf("%s", $fx->fixNavaid->ListFixNavaidEntries());

					printf("</table>\r\n");
					printf("</td>\r\n");
				}

				printf("</tr>\r\n");
				printf("</table>\r\n");

				if ($fx->fixRemarks)
				{
					printf("<table class=\"remarks\"><tr><td>\r\n");

					printf("%s", $fx->fixRemarks->ListEntries());

					printf("</td></tr></table>\r\n");
				}

				printf("</td></tr></table>");
			}
		}
	}
}
?>

<table class="footer">
	<tr>
		<td><?php $f = new Footer();?></td>
	</tr>
</table>

</body>
</html>