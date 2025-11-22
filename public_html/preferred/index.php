<?php
require_once "../includes.php";

if (isset($_POST["depart"]))
{
	$depart = trim(strtoupper($_POST["depart"]));
}
else
{
	$depart = $sess->depart;
}

if (strlen($depart) > 3)
{
	$dp = str_split($depart);
	
	$depart = $dp[1] . $dp[2] . $dp[3];
}

if (isset($_POST["arrive"]))
{
	$arrive = trim(strtoupper($_POST["arrive"]));
}
else
{
	$arrive = $sess->arrive;
}

if (strlen($arrive) > 3)
{
	$ar = str_split($arrive);
	
	$arrive = $ar[1] . $ar[2] . $ar[3];
}

if (isset($_POST["dp"]))
{
	$dp = trim(strtoupper($_POST["dp"]));
}
else
{
	$dp = $sess->dp;
}

if (isset($_POST["star"]))
{
	$star = trim(strtoupper($_POST["star"]));
}
else
{
	$star = $sess->star;
}

if (isset($_POST["resetForm"]))
{
	$depart = null;
	$arrive = null;
	$dp = null;
	$star = null;
}

if (isset($_GET["dep"]))
{
	$depart = $_GET["dep"];
}

if (isset($_GET["arr"]))
{
	$arrive = $_GET["arr"];
}

$sess->SetSessionVariable("depart", $depart);
$sess->SetSessionVariable("arrive", $arrive);
$sess->SetSessionVariable("dp", $dp);
$sess->SetSessionVariable("star", $star);
?>

<!DOCTYPE html>
<html>

<head>
<title>Preferred Routes</title>
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
		<form id="mainForm" method="post" action="<?php printf("index.php?id=%s", $sess->sessionId);?>" >
		<table>
			<tr>
				<td class="centerLabel">Departure</td>
				<td class="centerLabel">Arrival</td>
				<td class="centerLabel">DP Ident</td>
				<td class="centerLabel">STAR Ident</td>
			</tr>
		<tr>
			<td><input name="depart" type="text" size="10" value="<?php echo $depart;?>" AUTOFOCUS /></td>
			<td><input name="arrive" type="text" size="10" value="<?php echo $arrive;?>" /></td>
			<td><input name="dp" type="text" size="10" value="<?php echo $dp;?>" /></td>
			<td><input name="star" type="text" size="10" value="<?php echo $star;?>" /></td>
			<td><input type="submit" value="Get" class="button" /></td>
			<td><input type="submit" value="Reset" name="resetForm" class="button" /></td>
		</tr>
		</table>
		</form>
		</td>
	</tr>
</table>

<?php
if (($depart) || ($arrive) || ($dp) || ($star))
{
	if (($depart) && ($arrive))
	{
		$sql = sprintf("SELECT * FROM pfrRoutes USE INDEX(pfrRoutesDepartArrive) WHERE depart='%s' AND arrive='%s' ORDER BY arrive,depart ASC", $depart, $arrive);
	}
	else if ($depart)
	{
		$sql = sprintf("SELECT * FROM pfrRoutes USE INDEX(pfrRoutesDepart) WHERE depart='%s' ORDER BY arrive,depart ASC", $depart);
	}
	else if ($arrive)
	{
		$sql = sprintf("SELECT * FROM pfrRoutes USE INDEX(pfrRoutesArrive) WHERE arrive='%s' ORDER BY arrive,depart ASC", $arrive);
	}
	else if ($dp)
	{
		$sql = sprintf("SELECT * FROM pfrRoutes USE INDEX(pfrRoutesDp) WHERE dp='%s' ORDER BY arrive,depart ASC", $dp);
	}
	else if ($star)
	{
		$sql = sprintf("SELECT * FROM pfrRoutes USE INDEX(pfrRoutesStar) WHERE star='%s' ORDER BY arrive,depart ASC", $star);
	}

	$p = new PreferredRoute($sess, $sql);

	if ($p->route)
	{
		printf("<table class=\"pageResult\"><tr><td>");

		printf("%s", $p->ListEntries());

		printf("</td></tr></table>");
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