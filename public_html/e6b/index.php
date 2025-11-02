<?php
require_once "../includes.php";
?>

<!DOCTYPE html>
<html>

<head>
<title>E6B Calculations</title>
<meta charset="UTF-8" />
<link rel="shortcut icon" href="../favicon.ico">
<link rel="stylesheet" href="../base.css?v=1">
<style type="text/css">
th
{
	text-align:center;
}
</style>
<script type="text/javascript" src="../base.js?v=1"></script>
<script type="text/javascript">
function LoadFormValues()
{
	document.form1.elements["speed"].value = GetCookie("form1speed");
	document.form1.elements["fpnm"].value = GetCookie("form1fpnm");
	document.form1.elements["roc"].value = GetCookie("form1roc");

	document.form2.elements["speed"].value = GetCookie("form2speed");
	document.form2.elements["gsa"].value = GetCookie("form2gsa");
	document.form2.elements["rod"].value = GetCookie("form2rod");
	
	document.form3.elements["altitude"].value = GetCookie("form3altitude");
	document.form3.elements["faltitude"].value = GetCookie("form3faltitude");
	document.form3.elements["fpm"].value = GetCookie("form3fpm");
	document.form3.elements["speed"].value = GetCookie("form3speed");
	document.form3.elements["distance"].value = GetCookie("form3distance");
	
	document.form4.elements["temp"].value = GetCookie("form4temp");
	document.form4.elements["dp"].value = GetCookie("form4dp");
	document.form4.elements["cb"].value = GetCookie("form4cb");
	
	if (GetCookie("form4tempUnit") == null)
	{
		SetCookie("form4tempUnit", "F", 10);
	}
	
	document.form5.elements["temp"].value = GetCookie("form5temp");
	document.form5.elements["tempCF"].value = GetCookie("form5tempCF");
	
	if (GetCookie("form5tempUnit") == null)
	{
		SetCookie("form5tempUnit", "F", 10);
	}
	
	document.form6.elements["windDir"].value = GetCookie("form6windDir");
	document.form6.elements["windSpeed"].value = GetCookie("form6windSpeed");
	document.form6.elements["airspeed"].value = GetCookie("form6airspeed");
	document.form6.elements["course"].value = GetCookie("form6course");
	document.form6.elements["correction"].value = GetCookie("form6correction");
	document.form6.elements["groundspeed"].value = GetCookie("form6groundspeed");
	
	document.form7.elements["latitude"].value = GetCookie("form7latitude");
	document.form7.elements["longitude"].value = GetCookie("form7longitude");
	document.form7.elements["gps"].value = GetCookie("form7gps");
	
	document.form8.elements["Temp"].value = GetCookie("form8temp");
	document.form8.elements["StatPress"].value = GetCookie("form8pressure");
	document.form8.elements["Dewpoint"].value = GetCookie("form8dewpoint");
	document.form8.elements["DensityAltfeet"].value = GetCookie("form8daft");
	document.form8.elements["DensityAltmetric"].value = GetCookie("form8damt");

	if (GetCookie("form8tempUnit2") == null)
	{
		SetCookie("form8tempUnit2", "F", 10);
	}

	if (GetCookie("form8tempUnit3") == null)
	{
		SetCookie("form8tempUnit3", "F", 10);
	}

	if (GetCookie("form8pressuretype") == null)
	{
		SetCookie("form8pressuretype", "F", 10);
	}

	document.form9.elements["vdist"].value = GetCookie("form9vdist");
	document.form9.elements["hdist"].value = GetCookie("form9hdist");
	document.form9.elements["gslope"].value = GetCookie("form9gslope");
}
//==========================================================================================
function RateOfClimb()
{
	var speed = Number(document.form1.elements["speed"].value);
	var fpnm = Number(document.form1.elements["fpnm"].value);
	var roc = ((speed / 60) * fpnm);
	
	SetCookie("form1speed", speed.toFixed(0), 10);
	SetCookie("form1fpnm", fpnm.toFixed(0), 10);
	SetCookie("form1roc", roc.toFixed(0), 10);
}
//==========================================================================================
function RateOfDecent()
{
	var speed = Number(document.form2.elements["speed"].value);
	var gsa = Number(document.form2.elements["gsa"].value);
	var rod = Math.tan(gsa * Math.PI/180) * ((speed * 6076) / 60);
	
	SetCookie("form2speed", speed.toFixed(0), 10);
	SetCookie("form2gsa", gsa.toFixed(2), 10);
	SetCookie("form2rod", rod.toFixed(0), 10);
}
//==========================================================================================
function AltitudeDistance()
{
	var altitude = Number(document.form3.elements["altitude"].value);
	var faltitude = Number(document.form3.elements["faltitude"].value);
	var fpm = Number(document.form3.elements["fpm"].value);
	var speed = Number(document.form3.elements["speed"].value);
	
	var distance = 0;
	
	if (speed > 0)
	{
		distance = Math.abs((((altitude - faltitude) / 60) / fpm) * speed);
	}
	
	SetCookie("form3altitude", altitude.toFixed(0), 10);
	SetCookie("form3faltitude", faltitude.toFixed(0), 10);
	SetCookie("form3fpm", fpm.toFixed(0), 10);
	SetCookie("form3speed", speed.toFixed(0), 10);
	SetCookie("form3distance", distance.toFixed(0), 10);
}
//==========================================================================================
function CloudBase()
{
	var temp = Number(document.form4.elements["temp"].value);
	var dp = Number(document.form4.elements["dp"].value);
	var radios = document.form4.elements["radio"];
	
	var tempUnit = "F";
	
	for (var i = 0;i < radios.length;i++)
	{
		if (radios[i].checked)
		{
			tempUnit = radios[i].value;
	
			break;
		}
	}
	
	var cb = 0;
	
	if (tempUnit === "C")
	{
		cb = ((temp - dp) / 2.5) * 1000;
	}
	else
	{
		cb = ((temp - dp) / 4.4) * 1000;
	}

	SetCookie("form4temp", temp.toFixed(2), 10);
	SetCookie("form4dp", dp.toFixed(2), 10);
	SetCookie("form4tempUnit", tempUnit, 10);
	SetCookie("form4cb", cb.toFixed(0), 10);
}
//==========================================================================================
function CelsiusFahrenheit()
{
	var temp = Number(document.form5.elements["temp"].value);
	var radios = document.form5.elements["radio"];
	
	var tempUnit = "F";
	
	var tempCF = 0;
	
	for (var i = 0;i < radios.length;i++)
	{
		if (radios[i].checked)
		{
			tempUnit = radios[i].value;
			
			break;
		}
	}
	
	if (tempUnit === "C")
	{
		tempCF = (temp * (9 / 5)) + 32;
	}
	else
	{
		tempCF = (temp - 32) * (5 / 9);
	}
	
	SetCookie("form5temp", temp.toFixed(2), 10);
	SetCookie("form5tempUnit", tempUnit, 10);
	SetCookie("form5tempCF", tempCF.toFixed(2), 10);
}
//==========================================================================================
function WindCorrection()
{
	var windDir = Number(document.form6.elements["windDir"].value);
	var windSpeed = Number(document.form6.elements["windSpeed"].value);
	var airspeed = Number(document.form6.elements["airspeed"].value);
	var course = Number(document.form6.elements["course"].value);
	
	var wd = (Math.PI/180) * windDir;
	var hd = (Math.PI/180) * course;
	
	var groundspeed = Math.round(Math.sqrt(Math.pow(windSpeed, 2) +
							  Math.pow(airspeed, 2) - 2 * windSpeed *
							  airspeed * Math.cos(hd - wd)));
	
	var wca = Math.atan2(windSpeed * Math.sin(hd - wd),
							   airspeed - windSpeed *
							   Math.cos(hd - wd));
	
	var WCA = Math.round((180/Math.PI) * (wca * -1));
	
	SetCookie("form6windDir", windDir.toFixed(0), 10);
	SetCookie("form6windSpeed", windSpeed.toFixed(0), 10);
	SetCookie("form6airspeed", airspeed.toFixed(0), 10);
	SetCookie("form6course", course.toFixed(0), 10);
	SetCookie("form6correction", WCA.toFixed(0), 10);
	SetCookie("form6groundspeed", groundspeed.toFixed(0), 10);
}
//==========================================================================================
function GPSConversion()
{
	var latitude = document.form7.elements["latitude"].value;
	var longitude = document.form7.elements["longitude"].value;
	var gps = document.form7.elements["gps"].value;
	
	gps = latitude.toString() + "," + longitude.toString();
	
	var partsLat = latitude.split("-");
	
	if (partsLat.length === 3)
	{
		var a = partsLat[2];
		
		var hemiLat = a.substr(a.length - 1);
		
		partsLat[2] = "";
		
		for (var x = 0;x < (a.length - 1);x++)
		{
			partsLat[2] += a.substr(x, 1);
		}
		
		var decimalLat = Number(partsLat[0]) + (Number(partsLat[1]) / 60) + (Number(partsLat[2]) / 3600);
		
		if ( (hemiLat.localeCompare("S") === 0) || (hemiLat.localeCompare("W") === 0) )
		{
			decimalLat *= -1;
		}
		
		var partsLon = longitude.split("-");
		
		if (partsLon.length !== 3)
		{
			return;
		}

		a = partsLon[2];
		
		var hemiLon = a.substr(a.length - 1);
		
		partsLon[2] = "";
		
		for (x = 0;x < (a.length - 1);x++)
		{
			partsLon[2] += a.substr(x, 1);
		}
		
		var decimalLon = Number(partsLon[0]) + (Number(partsLon[1]) / 60) + (Number(partsLon[2]) / 3600);
		
		if ( (hemiLon.localeCompare("S") === 0) || (hemiLon.localeCompare("W") === 0) )
		{
			decimalLon *= -1;
		}
		
		gps = decimalLat.toString() + "," + decimalLon.toString();
	}

	SetCookie("form7latitude", latitude, 10);
	SetCookie("form7longitude", longitude, 10);
	SetCookie("form7gps", gps, 10);
}
//==========================================================================================
function DAConvert(temp, pressure, dewpoint)
{
	temp = parseFloat(document.form8.Temp.value);
	pressure = parseFloat(document.form8.StatPress.value);
	dewpoint = parseFloat(document.form8.Dewpoint.value);

	var INpressure, Cdewpoint;
	var radios2 = document.form8.elements["radio2"];
	var pressureUnit = "I";
	
	for (var i = 0;i < radios2.length;i++)
	{
		if (radios2[i].checked)
		{
			pressureUnit = radios2[i].value;
			
			break;
		}
	}

	SetCookie("form8pressuretype", pressureUnit, 10);

	if (pressureUnit === "I")
	{
		INpressure = pressure;
	}
	
	if (pressureUnit === "M")
	{
		INpressure = parseFloat(convertmmHGtoinHG(pressure));
	}
	
	if (pressureUnit === "B")
	{
		INpressure = parseFloat(convertmbtoinHG(pressure));
	}

	var radios3 = document.form8.elements["radio3"];
	var tempUnit3 = "F";
	
	for (var i = 0;i < radios3.length;i++)
	{
		if (radios3[i].checked)
		{
			tempUnit3 = radios3[i].value;
			
			break;
		}
	}

	SetCookie("form8tempUnit3", tempUnit3, 10);

	if (tempUnit3 === "F")
	{
		Cdewpoint = parseFloat(convertFtoC(dewpoint));
	}
	
	if (tempUnit3 === "C")
	{
		Cdewpoint = dewpoint;
	}
	
	if (tempUnit3 === "K")
	{
		Cdewpoint = dewpoint - 273.15;
	}

	var Kel, Tv, Da;
	
	var radios1 = document.form8.elements["radio1"];
	
	var tempUnit1 = "F";
	
	for (var i = 0;i < radios1.length;i++)
	{
		if (radios1[i].checked)
		{
			tempUnit = radios1[i].value;
			
			break;
		}
	}

	SetCookie("form8tempUnit1", tempUnit1, 10);

	if (tempUnit === "F")
	{
		Kel = parseFloat(convertCtoK(convertFtoC(temp)));
		Tv = parseFloat(virtualTemperature(Kel, INpressure, Cdewpoint));
		Da = parseFloat(densityAltitude(INpressure, Tv));
		
		document.form8.DensityAltfeet.value = roundOff(Da.toString());
		document.form8.DensityAltmetric.value= roundOff(convertfeettometer(Da));
	}
	
	if (tempUnit === "C")
	{
		Kel = parseFloat(convertCtoK(temp));
		Tv = parseFloat(virtualTemperature(Kel, INpressure, Cdewpoint));
		Da = parseFloat(densityAltitude(INpressure, Tv));
		
		document.form8.DensityAltfeet.value = roundOff(Da.toString());
		document.form8.DensityAltmetric.value= roundOff(convertfeettometer(Da));
	}
	
	if (tempUnit === "K")
	{
		Kel = temp;
		
		Tv = parseFloat(virtualTemperature(Kel, INpressure, Cdewpoint));
		Da = parseFloat(densityAltitude(INpressure, Tv));
		
		document.form8.DensityAltfeet.value = roundOff(Da.toString());
		document.form8.DensityAltmetric.value = roundOff(convertfeettometer(Da));
	}

	SetCookie("form8temp", temp, 10);
	SetCookie("form8pressure", pressure, 10);
	SetCookie("form8dewpoint", dewpoint, 10);
	SetCookie("form8daft", document.form8.DensityAltfeet.value, 10);
	SetCookie("form8damt", document.form8.DensityAltmetric.value, 10);

}
//==========================================================================================
function convertFtoC(Fahr)
{
	var Cels;
	
	var Cels = 0.55556 * (Fahr - 32.0);
	
	return Cels;
}
//==========================================================================================
function convertCtoK(Cels)
{
	var Kel;
	
	Kel = Cels + 273.15;
	
	return Kel;
}
//==========================================================================================
function convertCtoF(Cels)
{
	var Fahr;
	
	Fahr = 1.8 * Cels +32;
	
	return Fahr;
}
//==========================================================================================
function convertKtoC(Kel)
{
	var Cels;
	
	Cels = Kel - 273.15;
	
	return Cels;
}
//==========================================================================================
function convertKtoR(Kel)
{
	var Fahr, Cels, Rank;
	
	Cels = parseFloat(convertKtoC(Kel));
	Fahr = parseFloat(convertCtoF(Cels));
	Rank = Fahr + 459.69;
	
	return Rank;
}
//==========================================================================================
function convertmmHGtoinHG(mmHG)
{
	var inHG;
	
	inHG = 0.03937008*mmHG;
	
	return inHG;
}
//==========================================================================================
function convertmbtoinHG(mb)
{
	var inHG;
	
	inHG = 0.0295300*mb;
	
	return inHG;
}
//==========================================================================================
function convertinHGtomb(inHG)
{
	var mb;
	
	mb = 33.8639*inHG;
	
	return mb;
}
//==========================================================================================
function convertfeettometer(feet)
{
	var meter;
	
	meter = 0.3048 * feet;
	
	return meter;
}
//==========================================================================================
function virtualTemperature(Kel, INpressure, Cdewpoint)
{
	var Tempv, dewpoint, E;
	
	dewpoint = parseFloat(convertKtoC(Kel));
	
	E = parseFloat(vaporPressure(Cdewpoint));
	
	mbpressure = parseFloat(convertinHGtomb(INpressure));
	
	Tempv = Kel / ( 1 - (E / mbpressure ) * ( 1 - 0.622));
	
	return Tempv;
}
//==========================================================================================
function vaporPressure(Cdewpoint)
{
	var E;
	
	E = 6.11 * Math.pow(10, (7.5 * Cdewpoint / (237.7 + Cdewpoint)));
	
	return E;
}
//==========================================================================================
function densityAltitude(INpressure, Tempv)
{
	var DensityAlt, dummy, Rank;
	
	Rank = parseFloat(convertKtoR(Tempv));
	
	dummy = (17.326 * INpressure) / Rank;
	
	DensityAlt = 145366 * (1 - (Math.pow(dummy, 0.235)));
	
	return DensityAlt;
}
//==========================================================================================
function roundOff(value)
{
	value = Math.round(10*value)/10;
	
	return value;
}
//==========================================================================================
function ApproachRatio()
{
	var vdist = Number(document.form9.elements["vdist"].value);
	var hdist = Number(document.form9.elements["hdist"].value);
	
	var gslope = Math.atan(vdist / hdist) * (180 / Math.PI);
	
	SetCookie("form9vdist", vdist.toFixed(0), 10);
	SetCookie("form9hdist", hdist.toFixed(0), 10);
	SetCookie("form9gslope", gslope.toFixed(2), 10);
}
</script>
</head>

<body onload="LoadFormValues()">

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
				<td>
				<table>
					<!-- First Row -->
					<tr>
						<td>
							<form name="form1" id="form1">
							<table class="e6b200px">
								<tr>
									<th colspan="2">Takeoff Minimums</th>
								</tr>
								<tr>
									<td class="rightLabel">Ground Speed</td><td><input size="5" name="speed" type="text" id="speed"/></td>
								</tr>
								<tr>
									<td class="rightLabel">Feet per NM</td><td><input size="5" name="fpnm" type="text" id="fpnm"/></td>
								</tr>
								<tr>
									<td class="rightLabel">Rate Of Climb</td><td><input readonly size="5" name="roc" type="text" id="roc"/></td>
								</tr>
								<tr>
									<td>&nbsp;</td><td><input type="submit" value="Calc" id="Submit" class="button" onclick="RateOfClimb()"/></td>
								</tr>
							</table>
							</form>
						</td>
						<td>
							<form name="form2" id="form2">
							<table class="e6b200px">
								<tr>
									<th colspan="2">GS Rate Of Decent</th>
								</tr>
								<tr>
									<td class="rightLabel">Ground Speed</td><td><input size="5" name="speed" type="text" id="speed"/></td>
								</tr>
								<tr>
									<td class="rightLabel">Glide Slope Angle</td><td><input size="5" name="gsa" type="text" id="gsa"/></td>
								</tr>
								<tr>
									<td class="rightLabel">Rate Of Decent</td><td><input readonly size="5" name="rod" type="text" id="rod"/></td>
								</tr>
								<tr>
									<td>&nbsp;</td><td><input type="submit" value="Calc" id="Submit" class="button" onclick="RateOfDecent()"/></td>
								</tr>
							</table>
							</form>
						</td>
						<td>
							<form name="form3" id="form3">
							<table class="e6b200px">
								<tr>
									<th colspan="2">Decent Distance</th>
								</tr>
								<tr>
									<td class="rightLabel">Altitude</td><td><input size="5" name="altitude" type="text" id="altitude"/></td>
								</tr>
								<tr>
									<td class="rightLabel">Final Altitude</td><td><input size="5" name="faltitude" type="text" id="faltitude"/></td>
								</tr>
								<tr>
									<td class="rightLabel">Vertical FPM</td><td><input size="5" name="fpm" type="text" id="fpm"/></td>
								</tr>
								<tr>
									<td class="rightLabel">Ground Speed</td><td><input size="5" name="speed" type="text" id="speed"/></td>
								</tr>
								<tr>
									<td class="rightLabel">Distance (nm.)</td><td><input readonly size="5" name="distance" type="text" id="distance"/></td>
								</tr>
								<tr>
									<td>&nbsp;</td><td><input type="submit" value="Calc" id="Submit" class="button" onclick="AltitudeDistance()"/></td>
								</tr>
							</table>
							</form>
						</td>
						<td>
							<form name="form4" id="form4">
							<table class="e6b200px">
								<tr>
									<th colspan="2">Cloud Base</th>
								</tr>
								<tr>
									<td class="rightLabel">Temperature</td><td><input size="5" name="temp" type="text" id="temp"/></td>
								</tr>
								<tr>
									<td class="rightLabel">Dew Point</td><td><input size="5" name="dp" type="text" id="dp"/></td>
								</tr>
								<tr>
									<td class="rightLabel">Cloud Base</td><td><input readonly size="5" name="cb" type="text" id="cb"/></td>
								</tr>
								<tr>
									<td colspan="2" class="radio" style="text-align: center;">
									<label for="imageform4unitTypeF">Fahrenheit</label>
									<?php
									$tempUnit = "";

									if (isset($_COOKIE["form4tempUnit"]))
									{
										$tempUnit = $_COOKIE["form4tempUnit"];
									}

									if (($tempUnit == "F") || (($tempUnit != "C")) && ($tempUnit != "F"))
									{
										printf("	<input type=\"radio\" checked=\"checked\" name=\"radio\" id=\"form4unitTypeF\" value=\"F\" />\r\n");
										printf("	<img id=\"imageform4unitTypeF\" src=\"../images/radioChecked.png\" onclick=\"RadioClicked('form4unitTypeF', 'form4', 'radio')\" />\r\n");
									}
									else
									{
										printf("	<input type=\"radio\" name=\"radio\" id=\"form4unitTypeF\" value=\"F\" />\r\n");
										printf("	<img id=\"imageform4unitTypeF\" checked=\"\" src=\"../images/radioUnchecked.png\" onclick=\"RadioClicked('form4unitTypeF', 'form4', 'radio')\" />\r\n");
									}
									?>
										<label for="imageform4unitTypeC">Celcius</label>
									<?php
										if ($tempUnit === "C")
										{
											printf("	<input type=\"radio\" checked=\"checked\" name=\"radio\" id=\"form4unitTypeC\" value=\"C\" />\r\n");
											printf("	<img id=\"imageform4unitTypeC\" checked=\"checked\" src=\"../images/radioChecked.png\" onclick=\"RadioClicked('form4unitTypeC', 'form4', 'radio')\" />\r\n");
										}
										else
										{
											printf("	<input type=\"radio\" name=\"radio\" id=\"form4unitTypeC\" value=\"C\" />\r\n");
											printf("	<img id=\"imageform4unitTypeC\" checked=\"\" src=\"../images/radioUnchecked.png\" onclick=\"RadioClicked('form4unitTypeC', 'form4', 'radio')\" />\r\n");
										}
									?>
									</td>
								</tr>
								<tr>
									<td>&nbsp;</td><td><input type="submit" value="Calc" id="Submit" class="button" onclick="CloudBase()"/></td>
								</tr>
							</table>
							</form>
						</td>
						<td>
						<form name="form5" id="form5">
						<table class="e6b200px">
							<tr>
								<th colspan="2">Celsius/Fahrenheit</th>
							</tr>
							<tr>
								<td class="rightLabel">Temperature</td><td><input size="5" name="temp" type="text" id="temp"/></td>
							</tr>
							<tr>
								<td>&nbsp;</td><td><input readonly size="5" name="tempCF" type="text" id="tempCF"/></td>
							</tr>
							<tr>
								<td colspan="2" class="radio" style="text-align: center;">
								<label for="imageform5unitTypeF">Fahrenheit</label>
								<?php
								$tempUnit = "";

								if (isset($_COOKIE["form5tempUnit"]))
								{
									$tempUnit = $_COOKIE["form5tempUnit"];
								}

								if (($tempUnit == "F") || (($tempUnit != "C")) && ($tempUnit != "F"))
								{
									printf("	<input type=\"radio\" checked=\"checked\" name=\"radio\" id=\"form5unitTypeF\" value=\"F\" />\r\n");
									printf("	<img id=\"imageform5unitTypeF\" src=\"../images/radioChecked.png\" onclick=\"RadioClicked('form5unitTypeF', 'form5', 'radio')\" />\r\n");
								}
								else
								{
									printf("	<input type=\"radio\" name=\"radio\" id=\"form5unitTypeF\" value=\"F\" />\r\n");
									printf("	<img id=\"imageform5unitTypeF\" checked=\"\" src=\"../images/radioUnchecked.png\" onclick=\"RadioClicked('form5unitTypeF', 'form5', 'radio')\" />\r\n");
								}
								?>
								
								<label for="imageform5unitTypeC">Celcius</label>

								<?php
								if ($tempUnit === "C")
								{
									printf("	<input type=\"radio\" checked=\"checked\" name=\"radio\" id=\"form5unitTypeC\" value=\"C\" />\r\n");
									printf("	<img id=\"imageform5unitTypeC\" checked=\"checked\" src=\"../images/radioChecked.png\" onclick=\"RadioClicked('form5unitTypeC', 'form5', 'radio')\" />\r\n");
								}
								else
								{
									printf("	<input type=\"radio\" name=\"radio\" id=\"form5unitTypeC\" value=\"C\" />\r\n");
									printf("	<img id=\"imageform5unitTypeC\" checked=\"\" src=\"../images/radioUnchecked.png\" onclick=\"RadioClicked('form5unitTypeC', 'form5', 'radio')\" />\r\n");
								}
								?>
								</td>
							</tr>
							<tr>
								<td>&nbsp;</td>
								<td><input type="submit" value="Calc" id="Submit" class="button" onclick="CelsiusFahrenheit()"/></td>
							</tr>
						</table>
						</form>
						</td>
					</tr>
  
					<!-- Second Row -->
					<tr>
						<td>
						<form name="form6" id="form6">
						<table class="e6b200px">
							<tr>
								<th colspan="2">Wind Correction</th>
							</tr>
							<tr>
								<td class="rightLabel">Wind Direction</td><td><input size="5" name="windDir" type="text" id="windDir"/></td>
							</tr>
							<tr>
								<td class="rightLabel">Wind Speed</td><td><input size="5" name="windSpeed" type="text" id="windSpeed"/></td>
							</tr>
							<tr>
								<td class="rightLabel">Airspeed</td><td><input size="5" name="airspeed" type="text" id="airspeed"/></td>
							</tr>
							<tr>
								<td class="rightLabel">Desired Course</td><td><input size="5" name="course" type="text" id="course"/></td>
							</tr>
							<tr>
								<td class="rightLabel">Correction</td><td><input readonly size="5" name="correction" type="text" id="correction"/></td>
							</tr>
							<tr>
								<td class="rightLabel">Ground Speed</td><td><input readonly size="5" name="groundspeed" type="text" id="groundspeed"/></td>
							</tr>
							<tr>
								<td>&nbsp;</td><td><input type="submit" value="Calc" id="Submit" class="button" onclick="WindCorrection()"/></td>
							</tr>
						</table>
						</form>
						</td>
						<td colspan="2">
						<form name="form7" id="form7">
						<table class="e6b220px">
							<tr>
								<th colspan="2">GPS Conversion</th>
							</tr>
							<tr>
								<td style="text-align:center" colspan="2">(FAA Format)</td>
							</tr>
							<tr>
								<td class="rightLabel">Latitude</td><td><input size="25" name="latitude" type="text" id="latitude" /></td>
							</tr>
							<tr>
								<td class="rightLabel">Longitude</td><td><input size="25" name="longitude" type="text" id="longitude" /></td>
							</tr>
							<tr>
								<td class="rightLabel">GPS</td><td style="min-width:333px;max-width:333px;"><input readonly size="40" name="gps" type="text" id="gps"/></td>
							</tr>
							<tr>
								<td>&nbsp;</td><td><input type="submit" value="Calc" id="Submit" class="button" onclick="GPSConversion()"/></td>
							</tr>
						</table>
						</form>
						</td>
						<td>
						<form name="form9" id="form9">
						<table class="e6b200px">
							<tr>
								<th colspan="2">Approach Ratio</th>
							</tr>
							<tr>
								<td class="rightLabel">Vertical Distance</td><td><input size="5" name="vdist" type="text" id="vdist"/></td>
							</tr>
							<tr>
								<td class="rightLabel">Horizontal Distance</td><td><input size="5" name="hdist" type="text" id="hdist"/></td>
							</tr>
							<tr>
								<td class="rightLabel">Glide Angle</td><td><input readonly size="5" name="gslope" type="text" id="gslope"/></td>
							</tr>
							<tr>
								<td>&nbsp;</td><td><input type="submit" value="Calc" id="Submit" class="button" onclick="ApproachRatio()"/></td>
							</tr>
						</table>
						</form>
						</td>
					</tr>
					<!-- Third Row -->
					<tr>
						<td colspan="2">
						<form name="form8" id="form8">
						<table class="e6bda">
							<tr>
								<th colspan="2">Density Altitude (from NOAA)</th>
							</tr>
							<tr>
								<td colspan="2">Enter the air temperature and choose a unit:</td>
							</tr>
							<tr>
								<td><input type="text" name="Temp" /></td>
								<td class="radio">
								<label for="imageform8unitTypeF">Fahrenheit</label>
								<?php
								$tempUnit2 = "";

								if (isset($_COOKIE["form8tempUnit2"]))
								{
									$tempUnit2 = $_COOKIE["form8tempUnit2"];
								}

								if (($tempUnit2 == "F") || (($tempUnit2 != "C")) && ($tempUnit2 != "F"))
								{
									printf("	<input type=\"radio\" checked=\"checked\" name=\"radio1\" id=\"form8unitTypeF\" value=\"F\" />\r\n");
									printf("	<img id=\"imageform8unitTypeF\" src=\"../images/radioChecked.png\" onclick=\"RadioClicked('form8unitTypeF', 'form8', 'radio1')\" />\r\n");
								}
								else
								{
									printf("	<input type=\"radio\" name=\"radio1\" id=\"form8unitTypeF\" value=\"F\" />\r\n");
									printf("	<img id=\"imageform8unitTypeF\" checked=\"\" src=\"../images/radioUnchecked.png\" onclick=\"RadioClicked('form8unitTypeF', 'form8', 'radio1')\" />\r\n");
								}
								?>

								<label for="imageform8unitTypeC">Celcius</label>

								<?php
								if ($tempUnit2 === "C")
								{
									printf("	<input type=\"radio\" checked=\"checked\" name=\"radio1\" id=\"form8unitTypeC\" value=\"C\" />\r\n");
									printf("	<img id=\"imageform8unitTypeC\" checked=\"checked\" src=\"../images/radioChecked.png\" onclick=\"RadioClicked('form8unitTypeC', 'form8', 'radio1')\" />\r\n");
								}
								else
								{
									printf("	<input type=\"radio\" name=\"radio1\" id=\"form8unitTypeC\" value=\"C\" />\r\n");
									printf("	<img id=\"imageform8unitTypeC\" checked=\"\" src=\"../images/radioUnchecked.png\" onclick=\"RadioClicked('form8unitTypeC', 'form8', 'radio1')\" />\r\n");
								}
								?>

								<label for="imageform8unitTypeK">Kelvin</label>

								<?php
								if ($tempUnit2 === "K")
								{
									printf("	<input type=\"radio\" checked=\"checked\" name=\"radio1\" id=\"form8unitTypeK\" value=\"K\" />\r\n");
									printf("	<img id=\"imageform8unitTypeK\" checked=\"checked\" src=\"../images/radioChecked.png\" onclick=\"RadioClicked('form8unitTypeK', 'form8', 'radio1')\" />\r\n");
								}
								else
								{
									printf("	<input type=\"radio\" name=\"radio1\" id=\"form8unitTypeK\" value=\"K\" />\r\n");
									printf("	<img id=\"imageform8unitTypeK\" checked=\"\" src=\"../images/radioUnchecked.png\" onclick=\"RadioClicked('form8unitTypeK', 'form8', 'radio1')\" />\r\n");
								}
								?>
								</td>
							</tr>
							<tr>
								<td colspan="2">Enter the actual station pressure (not the altimeter setting)<br/>and choose a unit:</td>
							</tr>
							<tr>
								<td><input type="text" name="StatPress" /></td>
								<td class="radio">
								<label for="imageform8pressureTypeI">inches</label>
								<?php
								$pressureType = "";

								if (isset($_COOKIE["form8pressuretype"]))
								{
									$pressureType = $_COOKIE["form8pressuretype"];
								}

								if (($pressureType == "I") || (($pressureType != "I")) && ($pressureType != "M") && ($pressureType != "B"))
								{
									printf("	<input type=\"radio\" checked=\"checked\" name=\"radio2\" id=\"form8pressureTypeI\" value=\"I\" />\r\n");
									printf("	<img id=\"imageform8pressureTypeI\" src=\"../images/radioChecked.png\" onclick=\"RadioClicked('form8pressureTypeI', 'form8', 'radio2')\" />\r\n");
								}
								else
								{
									printf("	<input type=\"radio\" name=\"radio2\" id=\"form8pressureTypeI\" value=\"I\" />\r\n");
									printf("	<img id=\"imageform8pressureTypeI\" checked=\"\" src=\"../images/radioUnchecked.png\" onclick=\"RadioClicked('form8pressureTypeI', 'form8', 'radio2')\" />\r\n");
								}
								?>

								<label for="imageform8pressureTypeM">mm mercury</label>

								<?php
								if ($pressureType === "M")
								{
									printf("	<input type=\"radio\" checked=\"checked\" name=\"radio2\" id=\"form8pressureTypeM\" value=\"M\" />\r\n");
									printf("	<img id=\"imageform8pressureTypeM\" checked=\"checked\" src=\"../images/radioChecked.png\" onclick=\"RadioClicked('form8pressureTypeM', 'form8', 'radio2')\" />\r\n");
								}
								else
								{
									printf("	<input type=\"radio\" name=\"radio2\" id=\"form8pressureTypeM\" value=\"M\" />\r\n");
									printf("	<img id=\"imageform8pressureTypeM\" checked=\"\" src=\"../images/radioUnchecked.png\" onclick=\"RadioClicked('form8pressureTypeM', 'form8', 'radio2')\" />\r\n");
								}
								?>

								<label for="imageform8pressureTypeB">millibars</label>

								<?php
								if ($pressureType === "B")
								{
									printf("	<input type=\"radio\" checked=\"checked\" name=\"radio2\" id=\"form8pressureTypeB\" value=\"B\" />\r\n");
									printf("	<img id=\"imageform8pressureTypeB\" checked=\"checked\" src=\"../images/radioChecked.png\" onclick=\"RadioClicked('form8pressureTypeB', 'form8', 'radio2')\" />\r\n");
								}
								else
								{
									printf("	<input type=\"radio\" name=\"radio2\" id=\"form8pressureTypeB\" value=\"B\" />\r\n");
									printf("	<img id=\"imageform8pressureTypeB\" checked=\"\" src=\"../images/radioUnchecked.png\" onclick=\"RadioClicked('form8pressureTypeB', 'form8', 'radio2')\" />\r\n");
								}
								?>
								</td>
							</tr>
							<tr>
								<td colspan="2">Enter the dewpoint and choose a unit:</td>
							</tr>
							<tr>
								<td><input type="text" name="Dewpoint" /></td>
								<td class="radio">
								<label for="imageform8tempUnit3F">Fahrenheit</label>
								<?php
								$tempUnit3 = "";

								if (isset($_COOKIE["form8tempUnit3"]))
								{
									$tempUnit3 = $_COOKIE["form8tempUnit3"];
								}

								if (($tempUnit3 == "F") || (($tempUnit3 != "C")) && ($tempUnit3 != "F"))
								{
									printf("	<input type=\"radio\" checked=\"checked\" name=\"radio3\" id=\"form8tempUnit3F\" value=\"F\" />\r\n");
									printf("	<img id=\"imageform8tempUnit3F\" src=\"../images/radioChecked.png\" onclick=\"RadioClicked('form8tempUnit3F', 'form8', 'radio3')\" />\r\n");
								}
								else
								{
									printf("	<input type=\"radio\" name=\"radio3\" id=\"form8tempUnit3F\" value=\"F\" />\r\n");
									printf("	<img id=\"imageform8tempUnit3F\" checked=\"\" src=\"../images/radioUnchecked.png\" onclick=\"RadioClicked('form8tempUnit3F', 'form8', 'radio3')\" />\r\n");
								}
								?>

								<label for="imageform8tempUnit3C">Celcius</label>

								<?php
								if ($tempUnit3 === "C")
								{
									printf("	<input type=\"radio\" checked=\"checked\" name=\"radio3\" id=\"form8tempUnit3C\" value=\"C\" />\r\n");
									printf("	<img id=\"imageform8tempUnit3C\" checked=\"checked\" src=\"../images/radioChecked.png\" onclick=\"RadioClicked('form8tempUnit3C', 'form8', 'radio3')\" />\r\n");
								}
								else
								{
									printf("	<input type=\"radio\" name=\"radio3\" id=\"form8tempUnit3C\" value=\"C\" />\r\n");
									printf("	<img id=\"imageform8tempUnit3C\" checked=\"\" src=\"../images/radioUnchecked.png\" onclick=\"RadioClicked('form8tempUnit3C', 'form8', 'radio3')\" />\r\n");
								}
								?>

								<label for="imageform8tempUnit3K">Kelvin</label>

								<?php
								if ($tempUnit3 === "K")
								{
									printf("	<input type=\"radio\" checked=\"checked\" name=\"radio3\" id=\"form8tempUnit3K\" value=\"K\" />\r\n");
									printf("	<img id=\"imageform8tempUnit3K\" checked=\"checked\" src=\"../images/radioChecked.png\" onclick=\"RadioClicked('form8tempUnit3K', 'form8', 'radio3')\" />\r\n");
								}
								else
								{
									printf("	<input type=\"radio\" name=\"radio3\" id=\"form8tempUnit3K\" value=\"K\" />\r\n");
									printf("	<img id=\"imageform8tempUnit3K\" checked=\"\" src=\"../images/radioUnchecked.png\" onclick=\"RadioClicked('form8tempUnit3K', 'form8', 'radio3')\" />\r\n");
								}
								?>
								</td>
							</tr>
							<tr>
								<td>Density Altitude in feet:</td>
								<td>Density Altitude in meters:</td>
							</tr>
							<tr>
								<td><input type="text" readonly name="DensityAltfeet" /></td>
								<td><input type="text" readonly name="DensityAltmetric" /></td>
							</tr>
							<tr>
								<td><input class="button" type="button" onclick="DAConvert(document.form8.Temp.value, document.form8.StatPress.value, document.form8.Dewpoint.value)" value="Calc" /></td>
								<td  style="min-width:250px;max-width:250px">&nbsp;</td>
							</tr>
						</table>
						</form>
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