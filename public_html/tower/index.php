<?php
require_once "../includes.php";

if (isset($_POST["tower"]))
{
	$tower = trim(strtoupper($_POST["tower"]));
}
else
{
	$tower = $sess->tower;
}

if (isset($_GET["ident"]))
{
	$tower = $_GET["ident"];
}

if (strlen($tower) == 4)
{
	$tt = str_split($tower);
	
	$tower = $tt[1] . $tt[2] . $tt[3];
}

if (isset($_POST["resetForm"]))
{
	$tower = null;
}

$sess->SetSessionVariable("tower", $tower);
?>

<!DOCTYPE html>
<html>

<head>
<title>Tower</title>
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
				<td class="centerLabel">ATCT Facility or Radio Call</td>
			</tr>
			<tr>
				<td><input name="tower" type="text" size="30" value="<?php echo $tower;?>" AUTOFOCUS /></td>
				<td><input type="submit" value="Get" class="button" /></td>
				<td><input type="submit" value="Reset" name="resetForm" class="button" /></td>
			</tr>
		</table>
		</form>
		</td>
	</tr>
</table>

<?php
if ($tower)
{
	$t = new Tower($sess, $tower);

	foreach($t->tower as $twr)
	{
		printf("<table class=\"pageResult\"><tr><td>");

		printf("<table class=\"tower\"><tr><td>\r\n");

		printf("%s", $twr->FormatBaseInfo(true));

		printf("</td><td>\r\n");

		printf("%s", $twr->towerFrequency->ListEntries(true, null));

		printf("</td><td>\r\n");

		printf("<table class=\"tower\"><tr><td>\r\n");

		printf("%s", $twr->towerServices->ListEntries(true));
		
		printf("%s", $twr->towerRadars->ListEntries(true));

		printf("</td></tr></table>\r\n");

		printf("</td></tr></table>\r\n");

		printf("<table class=\"remarks\"><tr><td>\r\n");

		printf("%s", $twr->towerRemarks->ListEntries(true));

		printf("</td></tr></table>\r\n");

		printf("</td></tr></table>\r\n");
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