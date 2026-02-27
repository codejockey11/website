<?php
require_once "../includes.php";
?>

<!DOCTYPE html>
<html>

<head>
<title>JsDatePick Test</title>
<meta charset="UTF-8">
<link rel="shortcut icon" href="../../favicon.ico" />
<link rel="stylesheet" href="../../base.css" />
<link rel="stylesheet" href="JsDatePick.css" />
<script src="JsDatePick.js" type="text/javascript"></script>
<script type="text/javascript">
//==========================================================================================
window.onload = function()
{
	new JsDatePick(
	{
		useMode:2,
		target:"inputField"
	});

	new JsDatePick(
	{
		useMode:2,
		target:"inputField2",
		limitToToday:true
	});

	g_globalObject = new JsDatePick(
	{
		useMode:1,
		isStripped:true,
		target:"div3_example",
		cellColorScheme:"armygreen"
	});

	g_globalObject.setOnSelectedDelegate(function()
	{
		var obj = g_globalObject.getSelectedDay();
		
		alert("a date was just selected and the date is : " + obj.day + "/" + obj.month + "/" + obj.year);
		
		document.getElementById("div3_example_result").innerHTML = obj.day + "/" + obj.month + "/" + obj.year;
	});
};
//==========================================================================================
</script>
</head>

<body>

<form name="mainForm" method="post" enctype="multipart/form-data" action="<?php printf("../test/usZips.php?id=%s", $sess->sessionId);?>" >
	<p>
	This is an example of the JsDatePick calendar in action<br/>
	with an input field - The user launches the calendar by clicking the input field,<br/>
	and then chooses a date, automatically returning the selected date to the field.<br/>
	This is the most basic use of a javascript calendar.<br/>
	<br/>
	new JsDatePick(<br/>
	{<br/>
	&nbsp;&nbsp;&nbsp;&nbsp;useMode:2,<br/>
	&nbsp;&nbsp;&nbsp;&nbsp;target:"aFieldId"<br/>
	});<br/>
	</p>

	<table>
		<tr>
			<td><input type="text" size="12" id="inputField"/></td>
			<td><input type="text" size="12" id="inputField2"/></td>
		</tr>
	</table>
</form>

</body>
</html>