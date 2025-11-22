<!DOCTYPE html>
<html>

<head>
<title>Index.html</title>
</head>

<body>

<?php
$files = scandir('../public_html/');

foreach ($files as $file)
{
	if (($file != ".") && ($file != ".."))
	{
		printf("<a href=\"../%s/\">%s</a><br/>", $file, $file);
	}
}
?>

</body>
</html>
