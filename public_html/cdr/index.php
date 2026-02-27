<?php
require_once "../includes.php";

if (isset($_POST["origin"]))
{
	$origin = trim(strtoupper($_POST["origin"]));
}
else
{
	$origin = $sess->origin;
}

if ((strlen($origin) > 0) && (strlen($origin) < 4))
{
	$origin = "K" . $origin;
}

if (isset($_POST["destination"]))
{
	$destination = trim(strtoupper($_POST["destination"]));
}
else
{
	$destination = $sess->destination;
}

if ((strlen($destination) > 0) && (strlen($destination) < 4))
{
	$destination = "K" . $destination;
}

if (isset($_GET["ident"]))
{
	$i = explode(",", $_GET["ident"]);

	if (count($i) == 2)
	{
		$origin = $i[0];
		
		$destination = $i[1];
	}
}

if (isset($_POST["resetForm"]))
{
	$origin = null;
	
	$destination = null;
}

if (($origin) || ($destination))
{
	if ($origin)
	{
		$sql = sprintf("SELECT * FROM cdrRoutes USE INDEX(cdrRoutesOrigin) WHERE origin='%s' ORDER BY origin,destination,fixIdent ASC", $origin);
	}

	if ($destination)
	{
		$sql = sprintf("SELECT * FROM cdrRoutes USE INDEX(cdrRoutesDestination) WHERE destination='%s' ORDER BY origin,destination,fixIdent ASC", $destination);
	}

	if (($origin) && ($destination))
	{
		$sql = sprintf("SELECT * FROM cdrRoutes USE INDEX(cdrRoutesOriginDestination) WHERE origin='%s' AND destination='%s' ORDER BY origin,destination,fixIdent ASC", $origin, $destination);
	}

	$cdr = new CodedDepatureRoute($sess, $sql);
}

$sess->SetSessionVariable("origin", $origin);
$sess->SetSessionVariable("destination", $destination);
?>

<!DOCTYPE html>
<html>

<head>
<title>Coded Departure Routes</title>
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
					<td class="centerLabel">Origin</td>
					<td class="centerLabel">Destination</td>
				</tr>
				<tr>
					<td><input name="origin" type="text" size="10" value="<?php echo $origin;?>" AUTOFOCUS /></td>
					<td><input name="destination" type="text" size="10" value="<?php echo $destination;?>" /></td>
					<td><input type="submit" value="Get" class="button" /></td>
					<td><input type="submit" value="Reset" name="resetForm" class="button" /></td>
				</tr>
			</table>
			</form>
		</td>
	</tr>
</table>

<?php
if (($origin) || ($destination))
{
	if ($cdr->route)
	{
		printf("<table class=\"pageResult\"><tr><td>");

		printf("%s", $cdr->ListEntries());

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