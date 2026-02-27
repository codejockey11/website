<?php
require_once "../includes.php";

if (isset($_POST["navaid"]))
{
	$navaid = trim(strtoupper($_POST["navaid"]));
}
else
{
	$navaid = $sess->navaid;
}

if (isset($_GET["ident"]))
{
	$navaid = $_GET["ident"];
}

$key = null;

if (isset($_GET["key"]))
{
	$key = $_GET["key"];
}

if (isset($_POST["resetForm"]))
{
	$navaid = null;
}

$n = null;

if ($key)
{
	$sql = sprintf("SELECT * FROM navNavaid WHERE id='%s'", $key);

	$n = new Navaid($sess, $sql);

	$navaid = $n->GetSingle(0)->facilityId;
}
else if (strpos($navaid, ".") > 0)
{
	$str = sprintf("%3.3f", floatval($navaid));

	$navaid = $str;

	$sql = sprintf("SELECT * FROM navNavaid USE INDEX(navNavaidFreq) WHERE freq='%s' AND type!='VOT' ORDER BY facilityId ASC", $navaid);

	$n = new Navaid($sess, $sql);
}
else if (is_numeric($navaid))
{
	$sql = sprintf("SELECT * FROM navNavaid USE INDEX(navNavaidFreq) WHERE freq='%s' AND type!='VOT' ORDER BY facilityId ASC", $navaid);

	$n = new Navaid($sess, $sql);
}
else if (strlen($navaid) > 3)
{
	$sql = sprintf("SELECT * FROM navNavaid USE INDEX(navNavaidName) WHERE name='%s' AND type!='VOT' ORDER BY state ASC", $navaid);

	$n = new Navaid($sess, $sql);
}
else if ((strlen($navaid) > 0) && (strlen($navaid) < 3))
{
	$sql = sprintf("SELECT * FROM navNavaid USE INDEX(navNavaidFacilityId) WHERE facilityId>='%s' AND facilityId<='%sZZ' AND type!='VOT' ORDER BY state,name ASC", $navaid, $navaid);

	$n = new Navaid($sess, $sql);

	if ($n->navaid != null)
	{
		if (count($n->navaid) == 1)
		{
			$navaid = $n->GetSingle(0)->facilityId;
		}
	}
}
else if ($navaid)
{
	$sql = sprintf("SELECT * FROM navNavaid USE INDEX(navNavaidFacilityId) WHERE facilityId='%s' AND type!='VOT'", $navaid);

	$n = new Navaid($sess, $sql);
}

if ($n != null)
{
	if ($n->navaid != null)
	{
		UpdateWaypoint($sess, "N;" . $n->GetSingle(0)->facilityId . ";" . $n->GetSingle(0)->id);
	}
}

$sess->SetSessionVariable("navaid", $navaid);
?>

<!DOCTYPE html>
<html>

<head>
<title>Navaid</title>
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
				<td class="centerLabel">Navaid Ident or Name</td>
			</tr>
			<tr>
				<td><input name="navaid" type="text" size="20" value="<?php echo $navaid;?>" AUTOFOCUS /></td>
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
if ($navaid)
{
	if ($n->navaid)
	{
		if (count($n->navaid) > 1)
		{
			printf("<table class=\"pageResult\"><tr><td>");

			printf("%s", $n->ListEntries());

			printf("</td></tr></table>");
		}
		else
		{
			$nav = $n->GetSingle(0);

			if ($nav)
			{
				printf("<table class=\"pageResult\"><tr><td>");

				printf("<table><tr><td>\r\n");

				printf("%s", $nav->FormatBaseInfo());

				printf("</td>\r\n");

				printf("%s", $nav->rco->FormatNavaidEntries());

				printf("</tr>\r\n");
				printf("</table>\r\n");

				printf("<table class=\"remarks\">\r\n");
				printf("<tr>\r\n");
				printf("<td>\r\n");

				printf("%s", $nav->remarks->ListEntries());

				printf("</td>\r\n");
				printf("</tr>\r\n");
				printf("</table>\r\n");

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