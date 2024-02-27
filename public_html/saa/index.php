<?php
require_once "../includes.php";

if (isset($_GET["mapCenter"]))
{
	$mapCenter = $_GET["mapCenter"];
}
else
{
	$mapCenter = $sess->mapCenter;
}

if (isset($_GET["mapZoom"]))
{
	$mapZoom = $_GET["mapZoom"];
}
else
{
	$mapZoom = $sess->mapZoom;
}

if (isset($_GET["mapBounds"]))
{
	$mapBounds = $_GET["mapBounds"];
}
else
{
	$mapBounds = $sess->mapBounds;
}

if (isset($_GET["action"]))
{
	$fa = explode("~", $_GET["action"]);

	if ($fa[0] == "getForm")
	{
		$designator = trim(strtoupper($fa[1]));

		$saaName = trim(strtoupper($fa[2]));
	}

	if ($fa[0] == "resetForm")
	{
		$designator = null;
		$saaName = null;
	}
}
else
{
	$designator = $sess->designator;

	$saaName = $sess->saaName;
}

if (isset($_GET["d"]))
{
	$designator = $_GET["d"];
	$saaName = "";
}

$sess->SetSessionVariable("mapCenter", $mapCenter);
$sess->SetSessionVariable("mapZoom", $mapZoom);
$sess->SetSessionVariable("mapBounds", $mapBounds);
$sess->SetSessionVariable("designator", $designator);
$sess->SetSessionVariable("saaName", $saaName);
?>

<!DOCTYPE html>
<html>

<head>
<title>Special Activity Area</title>
<meta charset="UTF-8">
<link rel="shortcut icon" href="../favicon.ico">
<link rel="stylesheet" href="../base.css?v=1">
<script type="text/javascript" src="../base.js?v=1"></script>
<script type="text/javascript" src="http://www.bing.com/api/maps/mapcontrol?callback=InitMap" async defer></script>
<script type="text/javascript">
//==========================================================================================
// PHP Dynamic Variables
//==========================================================================================
<?php
printf("var sessionId = '%s';\r\n", $sess->sessionId);

if ($sess->mapZoom == null)
{
	printf("var mapZoom = 10;\r\n");
}
else
{
	printf("var mapZoom = %s;\r\n", $sess->mapZoom);
}

if ($sess->mapCenter == null)
{
	// New York, NY 40.63992575, -73.778694972222
	printf("var mapCenter = ['40.63992575', '-73.778694972222'];\r\n");
}
else
{
	$mc = explode(',', $sess->mapCenter);

	printf("var mapCenter = ['%s', '%s'];\r\n", $mc[0], $mc[1]);
}

if ($sess->mapBounds == null)
{
	printf("var mapBounds = '';\r\n");
}
else
{
	printf("var mapBounds = '%s';\r\n", $sess->mapBounds);
}
?>
//==========================================================================================
// Variables
//==========================================================================================
var map = null;

var line = null;

var lineArray = [];

var mousePosition = null;

document.addEventListener('keydown', function (k)
{
	if (k.which == 13)
	{
		PostURL(document.getElementById('getForm'));
	}

}, false);
//==========================================================================================
function InitMap()
{
	map = new Microsoft.Maps.Map('#map',
	{
		credentials: 'ArZP1HDL-as-_VQnajKbHiDpKqkkSHhLbIyBSUWi0lWZw9b6h8vWJ3H80KJ9fYw9',
		center: new Microsoft.Maps.Location(parseFloat(mapCenter[0]), parseFloat(mapCenter[1])),
		zoom: mapZoom
	});

	Microsoft.Maps.Events.addHandler(map, 'mousemove', function (event) { mousePosition = event.location; lineArray.forEach(SetMousePosition); });
	Microsoft.Maps.Events.addHandler(map, 'viewchangeend', function () { mapZoom = map.getZoom(); mapBounds = map.getBounds(); });

	<?php
	if ($designator)
	{
		$sql = sprintf("SELECT * FROM saaLocation USE INDEX(saaLocationDesignator) WHERE designator='%s'", $designator);

		if (strpos($designator, ",") > 0)
		{
			$da = explode(",", $designator);

			$first = true;

			foreach($da as $d)
			{
				if ($first)
				{
					$first = false;

					$sql = sprintf("SELECT * FROM saaLocation USE INDEX(saaLocationDesignator) WHERE designator='%s'", $d);
				}
				else
				{
					$sql .= sprintf(" OR designator='%s'", $d);
				}
			}
		}

		$saaLocation = new SaaLocation($sess, $sql);

		$str = $saaLocation->MapMarkerBing();

		printf("%s", $str);
	}
	?>
	if (lineArray.length > 0)
	{
		mapZoom = 9;

		var count = 0;

		var sumLatitude = 0;
		var sumLongitude = 0;

		lineArray.forEach(function(line)
		{
			line.points.forEach(function(location)
			{
				sumLatitude += location.latitude;
				sumLongitude += location.longitude;

				count++;
			});
		});

		sumLatitude /= count;
		sumLongitude /= count;

		map.setView(
		{
			center: new Microsoft.Maps.Location(sumLatitude, sumLongitude),
			zoom: mapZoom
		});

		SetSession('mapCenter', mapCenter);
		SetSession('mapZoom', mapZoom);
	}
}
//==========================================================================================
function SetMousePosition(value, index, array)
{
	array[index].SetMousePosition(mousePosition);
}
//==========================================================================================
function SetSession(name, val)
{
    var httpSetSession = new XMLHttpRequest();

    httpSetSession.onreadystatechange = function()
    {
        if (httpSetSession.readyState == 4 && httpSetSession.status == 200)
        {
            //var parser = new DOMParser();

            //var xmlDoc = parser.parseFromString(httpSetSession.responseText, 'text/xml');

            //console.log(xmlDoc);
        }
    }

    httpSetSession.open('POST', '../xmlFormatters/setSession.php?q=' + name + '~' + val);

    httpSetSession.send();
}
//==========================================================================================
function PostURL(b)
{
    mapCenter = map.getCenter().latitude.toFixed(6) + ',' + map.getCenter().longitude.toFixed(6);

    mapBounds = map.getBounds().getNorthwest().latitude + ',' + map.getBounds().getNorthwest().longitude + ',' + map.getBounds().getSoutheast().latitude + ',' + map.getBounds().getSoutheast().longitude;

	window.location='../saa/index.php?id=' + sessionId + '&mapCenter=' + mapCenter + '&mapZoom=' + mapZoom + '&mapBounds=' + mapBounds +
	'&action=' + b.getAttribute("name") + '~' + document.getElementById('designator').value + '~' + document.getElementById('saaName').value;
}
//==========================================================================================
</script>
</head>

<body onload="InitMap()">

<table class="topPanel">
	<tr>
		<td><?php require_once "../navSignOn.php";?></td>
	</tr>
</table>

<table class="mainForm">
	<tr>
		<td>
		<table>
			<tr>
				<td class="centerLabel">Designator</td>
				<td class="centerLabel">Name</td>
			</tr>
			<tr>
				<td><input name="designator" id="designator" type="text" size="50" value="<?php echo $designator;?>" AUTOFOCUS /></td>
				<td><input name="saaName" id="saaName" type="text" size="50" value="<?php echo $saaName;?>" /></td>
				<td><button type="submit" name="getForm" id="getForm"  class="button" onclick="PostURL(this);">Get</button></td>
				<td><button type="submit" name="resetForm" id="resetForm"  class="button" onclick="PostURL(this);">Reset</button></td>
			</tr>
		</table>
		</td>
	</tr>
</table>

<table class="pageResult" height="700px">
	<tr>
		<?php
		if ($saaName)
		{
			$sql = sprintf("SELECT * FROM saaLocation USE INDEX(saaLocationName) WHERE name LIKE '%%%s%%' ORDER BY name", $saaName);

			$saaLocation = new SaaLocation($sess, $sql);

			if ($saaLocation->location)
			{
				if (count($saaLocation->location) > 1)
				{
					printf("<td>%s</td>\r\n", $saaLocation->ListEntries());

					printf("<td id=\"map\" width=\"800px\"></td>\r\n");
				}
				else
				{
					printf("<td>%s</td>\r\n", $saaLocation->location[0]->FormatBaseInfo());

					printf("<td id=\"map\" width=\"800px\"></td>\r\n");
				}
			}
			else
			{
				printf("<td id=\"map\" width=\"800px\"></td>\r\n");
			}
		}
		else if ($designator)
		{
			if ($saaLocation->location)
			{
				if (count($saaLocation->location) > 1)
				{
					printf("<td>%s</td>\r\n", $saaLocation->ListBaseInfo());

					$str = $saaLocation->DesignatorList();

					printf("<td id=\"map\" width=\"800px\"></td>\r\n");
				}
				else
				{
					printf("<td>%s</td>", $saaLocation->location[0]->FormatBaseInfo());

					printf("<td id=\"map\" width=\"800px\"></td>\r\n");
				}
			}
			else
			{
				printf("<td id=\"map\" width=\"800px\"></td>\r\n");
			}
		}
		else
		{
			printf("<td id=\"map\" width=\"800px\"></td>\r\n");
		}
		?>
	</tr>
</table>

<table class="footer">
	<tr>
		<td><?php $f = new Footer();?></td>
	</tr>
</table>

</body>
</html>