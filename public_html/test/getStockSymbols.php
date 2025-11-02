<?php
require_once "../includes.php";

$url = "https://cloud.iexapis.com/stable/stock/market/batch?token=pk_338ec58be83340189f482c362711d226&types=quote,news&last=5&symbols=MSFT,HD";

$json = file_get_contents($url);

$symbols = json_decode($json, true);

if (!$symbols)
{
	return;
}
?>

<!DOCTYPE html>
<html>

<head>
<title>JSON Stock Symbols</title>
<meta charset="UTF-8">
</head>

<body>

<p>
<?php
foreach ($symbols as $sym)
{
	printf("%s ", $sym["quote"]["symbol"]);
	printf("%s<br/>", $sym["quote"]["companyName"]);
	
	$logo = "https://storage.googleapis.com/iex/api/logos/" . $sym["quote"]["symbol"] . ".png";

	printf("<img src=\"%s\" /><br/>", $logo);
	
	foreach ($sym["news"] as $news)
	{
		printf("%s<br/>", $news["headline"]);
		printf("%s<br/>", $news["source"]);
		printf("<a href=\"%s\">%s<a/><br/>", $news["url"], $news["headline"]);
		printf("%s<br/>", $news["summary"]);
		printf("%s<br/>", $news["related"]);
	}

	printf("<br/>");
}

print_r($symbols);
?>
</p>

</body>
</html>