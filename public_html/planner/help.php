<?php
require_once "../includes.php";
?>

<!DOCTYPE html>
<html>

<head>
<title>Flight Planner Help</title>
<meta charset="UTF-8">
<link rel="shortcut icon" href="../favicon.ico">
<link rel="stylesheet" href="../base.css?v=1">
<script type="text/javascript" src="../base.js?v=1"></script>
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
		<p>
		Waypoints can be entered in the following format:<br/>
		<UL>
		<LI>Departure ICAO Facility Ident i.e. A;KAGC</LI>
		<LI>Waypoints along the route whether it be a navaid, fix, or GPS location</LI>
		<UL>
		<LI>Navaid is NDB VOR/VORTAC/VORDME as its identifier i.e. N;APE<br/>
		Sometimes NDB's are duplicated with other navaids and when this occurs use its 5 letter fix name instead</LI>
		<LI>Fixes are Five letter fix identifier i.e. F;GUNNE</LI>
		<LI>GPS locations are entered as longitude and latitude in FAA format, a description, and the magnetic variation i.e. G;39-32-58.00N,081-35-18.00W,RIVER,-8.00<br/>
		Negative variations are to the west and positive are to the east.<br/>
		If you are making an FSX plan the description can only be 5 characters.</LI>
		<LI>Use an intersection or fix instead of a GPS waypoint when you can.</LI>
		</UL>
		<LI>Arrival ICAO Facility Ident i.e. A;KUNI</LI>
		<LI>Speed is the ground speed of the flight</LI>
		<LI>Optional Items:</LI>
		<UL>
		<LI>Weather is the nautical mile radius at each waypoint to retrieve the ground stations within that radius.</LI>
		<LI>Wind is the direction and knots of the winds aloft. 200/10</LI>
		<LI>Winds aloft items will add wind correction and ground speeds to the flight plan.</LI>
		<LI>You can specify up to three alternate aiports in the ICAO format.</LI>
		</UL>
		</UL>
		</p>
		<p>
		When you are editing a flight plan you must set the flight plan drop down to NewPlan otherwise the original plan will be retrieved.<br/>
		Be sure to click "Save" after making any changes to your plan or any alternate airport.<br/>
		You can specify VOR/JET/QGPS/TGPS routes along the flight path provided you have the proper start and end points for the given route.<br/>
		To specify VOR route V45 from Appleton to Yeager you would put N;APE @V45 N;HVQ in the waypoints for that part of the route and the<br/>
		planner will create additional waypoints for that part of the route.<br/>
		Route V38 is huge victor airway route and you can use this plan to see how the waypoints are created; A;C00 N;MZV @V38 N;CCV A;KMFV.<br/>
		As an alternative you can specify the airway points along the route and use the airway dropdown to specify what types of airway information<br/>
		to include with the waypoints.  i.e. APE CRW will provide waypoint information about the airway points between the two in APE's information box.<br/>
		You can specify the "ocean" routes same as you would for the VOR/JET/QGPS/TGPS routes.<br/>
		Amber, Red, and Green routes are under the ATL route type.<br/>
		</p>
		<p>
		You can specify an instrument procedure with a "D", "S", and "I".  These can be STARs, DPs, and IAPs.<br/>
		For example: A;KATL D;KATL;PADGT;RW08L;RAFTN F;SMTTH @Q67 F;JONEN S;KCMH;SCRLT;MCGNS;RW28R I;KCMH;I28R; A;KCMH<br/>
		<ul>
		<li>The format for the depature entry is the airport ICAO, the siapId, the main transition, and secondary transition if any; D;KATL;PADGT;RW08L;RAFTN</li>
		<li>The format for the STAR entry is the airport ICAO, the siapId, transition, and final; S;KCMH;SCRLT;MCGNS;RW28R<br/>
		<li>The format for the IAP is the airport ICAO, the siapId, and any transition; I;KCMH;I28R;<br/>
		If you wanted to specify the APE transition for this approach you would enter I;KCMH;I28R;APE</li>
		</ul>
		</p>
		<p>
		All instrument procedures can be found under the CIFP part of the website.<br/>
		</p>
		<p>
		Example plans:<br/>
		<UL>
		<LI>A;KAGC N;HLG N;CTW N;APE A;KCMH</LI>
		<LI>A;KAGC N;AIR @V214 F;AMALE F;CFBSD A;KCMH</LI>
		<LI>A;KPKB G;39-32-58.00N,081-35-18.00W,RIVER,-8.00 G;39-57-13.00N,081-53-06.00W,KZZV,-8.00 G;40-09-17.00N,082-01-50.00W,HIWAY,-8.00 G;40-38-09.00N,082-22-59.00W,ELAKE,-8.00 A;KMFD</LI>
		</UL>
		</p>
		<p>
		If you have an account (it's free) you can:<br/>
		<UL>
		<LI>Save your airplanes so fuel burn can be calculated</LI>
		<LI>Store your flight plans</LI>
		<LI>Request airway route info to be included in the plan</LI>
		<LI>Specify the altitude of your flight and check that against the MEA's</LI>
		<LI>Use any one of the buttons to get, store, reverse, or delete the plan</LI>
		<LI>The airway drop down will put the point-to-point info of an airway in the way point's info area</LI>
		<LI>You can choose whether it's an IFR or VFR plan with the two radio buttons</LI>
		<LI>Enter a checkmark in the comms, remarks, or RNAV to include/exclude extra waypoint information</LI>
		<LI>Save your plan in an fpl or gpx format for your Garmin.</LI>
		<LI>There is an fsx format for folks that like flying the FSX Simulator.  Just click it and it will download to your download's folder.</LI>
		</UL>
		</p>
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