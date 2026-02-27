<?php
require_once "../includes.php";

$symbol = "";

if (isset($_POST["symbol"]))
{
	$symbol = trim(strtoupper($_POST["symbol"]));
}

if (isset($_GET["symbol"]))
{
	$symbol = trim(strtoupper($_GET["symbol"]));
}

$url = "https://iextrading.com/apps/stocks/";

$name = "";

if (isset($_POST["name"]))
{
	$name = ucwords(trim($_POST["name"]));
}
?>

<!DOCTYPE html>
<html>

<head>
<title>Stock Quote</title>
<meta charset="UTF-8">
<link rel="shortcut icon" href="../favicon.ico">
<link rel="stylesheet" href="../base.css?v=1">
<script type="text/javascript" src="../base.js?v=1"></script>
<style>
th
{
	font-family:Courier;
	text-align:left;
}
.stockList
{
	font-family:Courier;
	min-width:75px;
}
</style>
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
				<td class="centerLabel">Symbol(s)</td>
				<td class="centerLabel">Name</td>
			</tr>
			<tr>
				<td><input name="symbol" type="text" size="50" value="<?php echo $symbol;?>" AUTOFOCUS /></td>
				<td><input name="name" type="text" size="25" value="<?php echo $name;?>"/></td>
				<td><input type="submit" value="Get" class="button" /></td>
			</tr>
		</table>
		</form>
		</td>
	</tr>
</table>

<?php
if (($symbol != "") || ($name != null))
{
	$s = new Stock($symbol, $name);

	if ($s->symbols != null)
	{
		printf("<table class=\"pageResult\"><tr><td>");

		printf("<table>\r\n");

		if ($s->errors != null)
		{
			foreach ($s->errors as $err)
			{
				printf("<tr><td class=\"error\">%s</td></tr>", $err);
			}

			printf("<tr><td colspan=\"15\"><hr/></td></tr>");
		}

		foreach ($s->symbols as $sym)
		{
			printf("<tr><th>&nbsp;</th><th>Symbol</th><th>Company Name</th><th>Latest</th><th>Open</th><th>Close</th><th>High</th><th>Low</th><th>52W High</th><th>52W Low</th><th>Market Cap</th></tr>\r\n");

			printf("<tr>\r\n");

			printf("<td><img src=\"%s\" width=\"64\" height=\"64\"></td>\r\n", $sym->logo);

			printf("<td><a target=\"_blank\" href=\"%s%s\">%s</a></td>\r\n", $url, $sym->symbol, $sym->symbol);

			printf("<td>%s</td>\r\n", trim($sym->companyName));

			printf("<td class=\"stockList\">%s</td>\r\n", RemoveLeadingZeroes(sprintf("%04.2f", $sym->latestPrice), false));
			printf("<td class=\"stockList\">%s</td>\r\n", RemoveLeadingZeroes(sprintf("%04.2f", $sym->open), false));
			printf("<td class=\"stockList\">%s</td>\r\n", RemoveLeadingZeroes(sprintf("%04.2f", $sym->close), false));
			printf("<td class=\"stockList\">%s</td>\r\n", RemoveLeadingZeroes(sprintf("%04.2f", $sym->high), false));
			printf("<td class=\"stockList\">%s</td>\r\n", RemoveLeadingZeroes(sprintf("%04.2f", $sym->low), false));
			printf("<td class=\"stockList\">%s</td>\r\n", RemoveLeadingZeroes(sprintf("%04.2f", $sym->week52High), false));
			printf("<td class=\"stockList\">%s</td>\r\n", RemoveLeadingZeroes(sprintf("%04.2f", $sym->week52Low), false));

			$mc = $sym->marketCap / 1000000000;

			printf("<td class=\"stockList\">%s</td>\r\n", RemoveLeadingZeroes(sprintf("%04.2fB", $mc), false));

			printf("</tr><tr><td colspan=\"10\">");

			foreach ($sym->news as $news)
			{
				printf("<a target=\"_blank\" href=\"%s/\">%s</a><br/>", $news->url, $news->headline);
			}

			printf("<hr/></td></tr>\r\n");
		}

		printf("</table></td></tr></table>\r\n");
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