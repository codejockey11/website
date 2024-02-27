<?php
require_once "../includes.php";

if ($sess->waypoints)
{
	$swa = explode(" ", $sess->waypoints);
}
?>

<!DOCTYPE html>
<html>

<head>
<title>Risk Assesment</title>
<meta charset="UTF-8">
<link rel="shortcut icon" href="../favicon.ico">
<link rel="stylesheet" href="../base.css?v=1">
<style>
input[type='checkbox']
{
	display:inline;
}
</style>
<script type="text/javascript" src="../base.js?v=1"></script>
<script type="text/javascript">
//==========================================================================================
function UpdateColumnAmount(isChecked, amount)
{
	if (isChecked == true)
	{
		return amount;
	}

	return 0;
}
//==========================================================================================
function calcRisk(form)
{
	var col1 = 0;
	var col2 = 0;

	col1 += UpdateColumnAmount(form.sleep.checked, 2);
	col1 += UpdateColumnAmount(form.sleepWell.checked, 0);
	col1 += UpdateColumnAmount(form.ill.checked, 4);
    col1 += UpdateColumnAmount(form.great.checked, 0);
    col1 += UpdateColumnAmount(form.bitOff.checked, 2);
    col1 += UpdateColumnAmount(form.vfr.checked, 1);
    col1 += UpdateColumnAmount(form.mvfr.checked, 3);
    col1 += UpdateColumnAmount(form.ifr.checked, 4);

	col2 += UpdateColumnAmount(form.day.checked, 4);
    col2 += UpdateColumnAmount(form.gday.checked, 0);
    col2 += UpdateColumnAmount(form.dayFlight.checked, 1);
	col2 += UpdateColumnAmount(form.nightFlight.checked, 3);
	col2 += UpdateColumnAmount(form.rush.checked, 3);
	col2 += UpdateColumnAmount(form.noHurry.checked, 1);
    col2 += UpdateColumnAmount(form.charts.checked, 0);
	col2 += UpdateColumnAmount(form.computerY.checked, 3);
	col2 += UpdateColumnAmount(form.computerN.checked, 0);
	col2 += UpdateColumnAmount(form.wbcgY.checked, 0);
	col2 += UpdateColumnAmount(form.wbcgN.checked, 3);
	col2 += UpdateColumnAmount(form.performanceY.checked, 0);
	col2 += UpdateColumnAmount(form.performanceN.checked, 3);
	col2 += UpdateColumnAmount(form.briefY.checked, 0);
    col2 += UpdateColumnAmount(form.briefN.checked, 2);

	if (col1 > 0)
	{
		form.col1.value = col1;
		form.tcol1.value = col1;
	}

	if (col2 > 0)
	{
		form.col2.value = col2;
		form.tcol2.value = col2;
	}

	if ((col1 > 0) || (col2 > 0))
	{
		form.total.value = col1 + col2;
	}
}
//==========================================================================================
function clearForm(form)
{
	form.sleep.checked = false;
	form.sleepWell.checked = false;
	form.ill.checked = false;
	form.great.checked = false;
	form.bitOff.checked = false;
	form.vfr.checked = false;
	form.mvfr.checked = false;
	form.ifr.checked = false;

	form.day.checked = false;
	form.gday.checked = false;
	form.dayFlight.checked = false;
	form.nightFlight.checked = false;
	form.rush.checked = false;
	form.noHurry.checked = false;
	form.charts.checked = false;
	form.computerY.checked = false;
	form.computerN.checked = false;
	form.wbcgY.checked = false;
	form.wbcgN.checked = false;
	form.performanceY.checked = false;
	form.performanceN.checked = false;
	form.briefY.checked = false;
	form.briefN.checked = false;

	form.col1.value = "";
	form.col2.value = "";
	form.tcol1.value = "";
	form.tcol2.value = "";
	form.total.value = "";
}
</script>
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

			<input class="adm" name="name" type="text" size="25" value="<?php echo $sess->pilotId; ?>" style="position:absolute;left:280px;top:34px;"/>
			<input class="adm" name="from" type="text" size="5"  value="<?php if ($sess->waypoints){echo $swa[0];} ?>" style="position:absolute;left:585px;top:34px;"/>
			<input class="adm" name="to"   type="text" size="5"  value="<?php if ($sess->waypoints){echo $swa[count($swa) - 1];} ?>" style="position:absolute;left:685px;top:34px;"/>

			<input name="sleep" type="checkbox" AUTOFOCUS style="position:absolute;top:94px;left:442px;"/>
			<input name="sleepWell" type="checkbox" style="position:absolute;top:110px;left:442px;"/>
			<input name="ill" type="checkbox" style="position:absolute;top:157px;left:442px;"/>
			<input name="great" type="checkbox" style="position:absolute;top:172px;left:442px;"/>
			<input name="bitOff" type="checkbox" style="position:absolute;top:188px;left:442px;"/>
			<input name="vfr" type="checkbox" style="position:absolute;top:252px;left:442px;"/>
			<input name="mvfr" type="checkbox" style="position:absolute;top:299px;left:442px;"/>
			<input name="ifr" type="checkbox" style="position:absolute;top:314px;left:442px;"/>
			<input class="adm" name="col1" readonly type="text" style="font-size:10px;text-align:center;width:25px;height:12px;top:345px;left:430px;"/>

			<input name="day" type="checkbox" style="position:absolute;top:109px;left:754px;"/>
			<input name="gday" type="checkbox" style="position:absolute;top:125px;left:754px;"/>
			<input name="dayFlight" type="checkbox" style="position:absolute;top:172px;left:754px;"/>
			<input name="nightFlight" type="checkbox" style="position:absolute;top:188px;left:754px;"/>
			<input name="rush" type="checkbox" style="position:absolute;top:238px;left:754px;"/>
			<input name="noHurry" type="checkbox" style="position:absolute;top:253px;left:754px;"/>
			<input name="charts" type="checkbox" style="position:absolute;top:269px;left:754px;"/>
			<input name="computerY" type="checkbox" style="position:absolute;top:285px;left:754px;"/>
			<input name="computerN" type="checkbox" style="position:absolute;top:300px;left:754px;"/>
			<input name="wbcgY" type="checkbox" style="position:absolute;top:316px;left:754px;"/>
			<input name="wbcgN" type="checkbox" style="position:absolute;top:331px;left:754px;"/>
			<input name="performanceY" type="checkbox" style="position:absolute;top:347px;left:754px;"/>
			<input name="performanceN" type="checkbox" style="position:absolute;top:362px;left:754px;"/>
			<input name="briefY" type="checkbox" style="position:absolute;top:378px;left:754px;"/>
			<input name="briefN" type="checkbox" style="position:absolute;top:394px;left:754px;"/>
			<input class="adm" name="col2" readonly type="text" style="font-size:10px;text-align:center;width:25px;height:12px;top:427px;left:742px;"/>

			<input class="adm" name="tcol1" readonly type="text" style="font-size:10px;text-align:center;width:25px;height:12px;top:463px;left:412px;"/>
			<input class="adm" name="tcol2" readonly type="text" style="font-size:10px;text-align:center;width:25px;height:12px;top:463px;left:575px;"/>
			<input class="adm" name="total" readonly type="text" style="font-size:10px;text-align:center;width:25px;height:12px;top:463px;left:700px;"/>

			<input name="Clear" type="button" value="Clear" onclick="clearForm(this.form)" class="admButton" style="position:absolute;top:499px;left:650px;"/>
			<input name="Submit" type="button" value="Submit" onclick="calcRisk(this.form)" class="admButton" style="position:absolute;top:499px;left:732px;"/>
			</form>

			<img src="riskAssesment.png" style="margin:0px 0px 0px 176px;" />
			<br/>
			<br/>
			<br/>
			<img src="riskAssesment2.png" style="margin:0px 0px 0px 176px;" />

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