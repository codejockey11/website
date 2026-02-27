<?php
require_once "../includes.php";

$state = "AK";

if (isset($_POST["stateSelect"]))
{
	$state = $_POST["stateSelect"];
}

$city = "Adak";

if (isset($_POST["citySelect"]))
{
	$city = $_POST["citySelect"];
}

$zip = "99546";

if (isset($_POST["zipSelect"]))
{
	$zip = $_POST["zipSelect"];
}

$county = "Aleutians West";

if (isset($_POST["countySelect"]))
{
	$county = $_POST["countySelect"];
}

if (isset($_POST["resetStateCity"]))
{
	$state = "AK";
	$city = "Adak";
	$zip = "99546";
	$county = "Aleutians West";
}
?>

<!DOCTYPE html>
<html>

<head>
<title>US State City Zip County Select Test</title>
<meta charset="UTF-8">
<link rel="shortcut icon" href="../../favicon.ico" />
<link rel="stylesheet" href="../../base.css" />
<script src="../../base.js" type="text/javascript"></script>
<script type="text/javascript">
//==========================================================================================
function UpdateCounties(xmlDoc)
{
	var select = document.getElementById("countySelect");
    
	ClearSelect(select);

	var city = xmlDoc.getElementsByTagName('city');

	for (var i=0;i<city.length;i++)
	{
		var opt = document.createElement('option');

		opt.value = city[i].getElementsByTagName('county')[0].childNodes[0].nodeValue;
		
		opt.innerHTML = city[i].getElementsByTagName('county')[0].childNodes[0].nodeValue;

		select.appendChild(opt);
	}
}
//==========================================================================================
function UpdateZipcodes(xmlDoc)
{
	var select = document.getElementById("zipSelect");
    
	ClearSelect(select);

	var city = xmlDoc.getElementsByTagName('city');

	for (var i=0;i<city.length;i++)
	{
		var opt = document.createElement('option');

		opt.value = city[i].getElementsByTagName('zip')[0].childNodes[0].nodeValue;
		
		opt.innerHTML = city[i].getElementsByTagName('zip')[0].childNodes[0].nodeValue;

		select.appendChild(opt);
	}

	if (city.length == 1)
	{
		select.selectedIndex = 0;
		
		DoHttpRequestCounties();
	}

	DoHttpRequestCounties();
}
//==========================================================================================
function UpdateCities(xmlDoc)
{
	var select = document.getElementById("citySelect");
    
	ClearSelect(select);

	var city = xmlDoc.getElementsByTagName('city');

	for (var i=0;i<city.length;i++)
	{
		var opt = document.createElement('option');

		opt.value = city[i].getElementsByTagName('name')[0].childNodes[0].nodeValue;
		
		opt.innerHTML = city[i].getElementsByTagName('name')[0].childNodes[0].nodeValue;

		select.appendChild(opt);
	}

	DoHttpRequestZipcodes();
	
	DoHttpRequestCounties();
}
//==========================================================================================
function HandleHttpRequestCities()
{
	if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
	{
		var parser = new DOMParser();
		
		var xmlDoc = parser.parseFromString(xmlhttp.responseText, 'text/xml');

		switch (xmlDoc.getElementsByTagName('result')[0].getAttribute('type'))
		{
			case 'cities':
			{
				UpdateCities(xmlDoc);
				
				break;
			}

			case 'zipcodes':
			{
				UpdateZipcodes(xmlDoc);
				
				break;
			}

			case 'counties':
			{
				UpdateCounties(xmlDoc);
				
				break;
			}

			default:
			{
				break;
			}

		}
	}
}
//==========================================================================================
function DoHttpRequestCities()
{
	xmlhttp = new XMLHttpRequest();
	
	xmlhttp.onreadystatechange = HandleHttpRequestCities;

	var state = document.getElementById("stateSelect");

<?php
printf("	xmlhttp.open('POST', '../xmlFormatters/getCities.php?state=' + state.options[state.selectedIndex].text + '&city=' + '&id=%s', false);\r\n", $sess->sessionId);
?>
	xmlhttp.send();
}
//==========================================================================================
function DoHttpRequestZipcodes()
{
	xmlhttp = new XMLHttpRequest();
	
	xmlhttp.onreadystatechange = HandleHttpRequestCities;

	var state = document.getElementById("stateSelect");
	var city = document.getElementById("citySelect");

<?php
printf("	xmlhttp.open('POST', '../xmlFormatters/getZipcodes.php?state=' + state.options[state.selectedIndex].text + '&city=' + city.options[city.selectedIndex].text + '&id=%s', false);\r\n", $sess->sessionId);
?>
	xmlhttp.send();
}
//==========================================================================================
function DoHttpRequestCounties()
{
	xmlhttp = new XMLHttpRequest();
	
	xmlhttp.onreadystatechange = HandleHttpRequestCities;

	var state = document.getElementById("stateSelect");
	var city = document.getElementById("citySelect");
	var zip = document.getElementById("zipSelect");

<?php printf("	xmlhttp.open('POST', '../xmlFormatters/getCounties.php?state=' + state.options[state.selectedIndex].text + '&city=' + city.options[city.selectedIndex].text + '&zip=' + zip.options[zip.selectedIndex].text + '&id=%s', false);\r\n", $sess->sessionId);
?>
	xmlhttp.send();
}
//==========================================================================================
</script>
</head>

<body>

<form name="mainForm" method="post" enctype="multipart/form-data" action="<?php printf("usZips.php?id=%s", $sess->sessionId);?>" >
<table>
<tr>
<?php
$usz = new USZips($state);

printf("%s", $usz->LoadStates());

printf("<td>%s</td>", $usz->StateDropdown($state));

printf("%s", $usz->LoadCities($state));

printf("<td>%s</td>", $usz->CityDropdown($city));

printf("%s", $usz->LoadZipcodes($state, $city));

printf("<td>%s</td>", $usz->ZipDropdown($zip));

printf("%s", $usz->LoadCounties($state, $city, $zip));

printf("<td>%s</td>", $usz->CountyDropdown($county));

if ($usz->foundCity == false)
{
	$city = null;
}

if ($usz->foundZip == false)
{
	$zip = null;
}

if ($usz->foundCounty == false)
{
	$county = null;
}
?>
<td><input type="submit" value="Submit" name="pickStateCity" class="button" />
<input type="submit" value="Reset" name="resetStateCity" class="button" />
</td>
</tr></table>
</form>
<?php
if (isset($_POST["pickStateCity"]))
{
	printf("%s, %s %s %s<br/>\r\n", $state, $city, $zip, $county);
}
?>

</body>
</html>