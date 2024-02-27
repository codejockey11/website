<?php
require_once "../includes.php";
?>

<!DOCTYPE html>
<html>

<head>
<title>Weather</title>
<meta charset="UTF-8">
<link rel="shortcut icon" href="../favicon.ico">
<link rel="stylesheet" href="../base.css?v=1">
<style>
img
{
	max-width:750px;
}
</style>
<script type="text/javascript" src="../base.js?v=1"></script>
<script type="text/javascript" src="http://oap.accuweather.com/launch.js"></script>
</head>

<body>

<table class="topPanel">
	<tr>
		<td><?php require_once "../navSignOn.php";?></td>
	</tr>
</table>

<table class="pageResult">
	<tr>
		<td>
		<table>
			<tr>
				<td class="weatherLeft">
				<?php
				$r = new RssFeed("http://www.spc.noaa.gov/products/spcrss.xml");
				//$r = new RssFeed("https://www.prlog.org/news/us/ind/aerospace/rss.xml");
				/*
				$p = new Parameter(null);

				$p->RangedSelection("aviationtoday001", "aviationtoday999", "A", "value1");
				
				foreach ($p->parmList as $parm)
				{
					$r = new RssFeed($parm->value1);
				}
				*/
				?>
				</td>
				<td>
				<table>
					<tr>
						<td id="awtd1496425946195" class="aw-widget-36hour"  data-locationkey="" data-unit="f" data-language="en-us" data-useip="true" data-uid="awtd1496425946195" data-editlocation="true">
						<a href="http://www.accuweather.com/en/us/parkersburg-wv/26101/weather-forecast/331474" class="aw-widget-legal"></a>
						</td>
					</tr>
				</table>
				</td>
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