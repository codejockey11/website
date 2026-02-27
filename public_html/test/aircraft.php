<?php
require_once "../includes.php";

$holder = "328 Support Services GmbH";

if (isset($_POST["holderSelect"]))
{
	$holder = $_POST["holderSelect"];
}

$model = "328-100";

if (isset($_POST["modelSelect"]))
{
	$model = $_POST["modelSelect"];
}

if (isset($_POST["reset"]))
{
	$holder = "328 Support Services GmbH";

	$model = "328-100";
}
?>

<!DOCTYPE html>
<html>

<head>
<title>Aircraft Holder Model Select Test</title>
<meta charset="UTF-8">
<link rel="shortcut icon" href="../../favicon.ico" />
<link rel="stylesheet" href="../../base.css" />
<script src="../../base.js" type="text/javascript"></script>
<script type="text/javascript">
//==========================================================================================
function UpdateModels(xmlDoc)
{
	var select = document.getElementById("modelSelect");
	
	ClearSelect(select);

	var model = xmlDoc.getElementsByTagName('model');

	for (var i=0;i < model.length;i++)
	{
		var opt = document.createElement('option');

		opt.value = model[i].getElementsByTagName('name')[0].childNodes[0].nodeValue;
		opt.innerHTML = model[i].getElementsByTagName('name')[0].childNodes[0].nodeValue;

		select.appendChild(opt);
	}
}
//==========================================================================================
function HandleHttpRequestModels()
{
	if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
	{
		var parser = new DOMParser();
		
		var xmlDoc = parser.parseFromString(xmlhttp.responseText, 'text/xml');

		switch (xmlDoc.getElementsByTagName('result')[0].getAttribute('type'))
		{
			case 'models':
			{
				UpdateModels(xmlDoc);
				
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
function DoHttpRequestModels()
{
	xmlhttp = new XMLHttpRequest();
	
	xmlhttp.onreadystatechange = HandleHttpRequestModels;

	var holder = document.getElementById("holderSelect");

<?php
printf("	xmlhttp.open('POST', '../xmlFormatters/getModels.php?holder=' + URLSpecialChars(holder.options[holder.selectedIndex].text) + '&id=%s', false);\r\n", $sess->sessionId);
?>
	xmlhttp.send();
}
//==========================================================================================
</script>
</head>

<body>

<form name="mainForm" method="post" enctype="multipart/form-data" action="<?php printf("aircraft.php?id=%s", $sess->sessionId);?>" >
	<table>
		<tr>
			<?php
			$sql = "SELECT * FROM aircraft";

			$aircraft = new Aircraft($sql);

			printf("%s", $aircraft->LoadHolders());

			printf("<td>%s</td>", $aircraft->HolderDropdown($holder));

			printf("%s", $aircraft->LoadModels($holder));

			printf("<td>%s</td>", $aircraft->ModelDropdown($model));

			if ($aircraft->foundModel == false)
			{
				$model = null;
			}
			?>
			<td><input type="submit" value="Submit" name="submit" class="button" />
			<input type="submit" value="Reset" name="reset" class="button" />
			</td>
		</tr>
	</table>
</form>

<?php
if (isset($_POST["submit"]))
{
	$sql = "SELECT * FROM aircraft WHERE model='" . $model . "'";

	$a = new Aircraft($sql);

	printf("%s", $a->ListEntries(true));

	$tcds = $a->GetSingle(0);

	printf("<a href=\"https://rgl.faa.gov/Regulatory_and_Guidance_Library/rgMakeModel.nsf/WebSearchDefault?SearchView&SearchOrder=1&SearchMax=50&Query=%s\" target=\"_blank\">%s</a>\r\n", $tcds->TCDS, $model);
}
?>

</body>
</html>
