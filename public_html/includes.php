<?php
//printf("<script>window.location='../maintenance/index.php'</script>\r\n");

$GLOBALS["userProfile"] = "C:/Users/junk_";

$root = dirname(dirname(__FILE__));

$publicFolder = "/public_html";

require_once $root . $publicFolder . "/Utility.php";

require_once $root . $publicFolder . "/classes/Zip.php";
require_once $root . $publicFolder . "/classes/SimpleRequest.php";

require_once $root . $publicFolder . "/classes/Footer.php";

require_once $root . $publicFolder . "/classes/Temperature.php";
require_once $root . $publicFolder . "/classes/LatLon.php";
require_once $root . $publicFolder . "/classes/Waypoint.php";
//require_once $root . $publicFolder . "/classes/Phonetic.php";
require_once $root . $publicFolder . "/classes/BingMap.php";
//require_once $root . $publicFolder . "/classes/GoogleMap.php";
require_once $root . $publicFolder . "/classes/RssFeed.php";
//require_once $root . $publicFolder . "/classes/WeatherImage.php";
require_once $root . $publicFolder . "/classes/USZips.php";

require_once $root . $publicFolder . "/classes/Database.php";
require_once $root . $publicFolder . "/classes/Parameter.php";
require_once $root . $publicFolder . "/classes/SessionMgr.php";

require_once $root . $publicFolder . "/classes/Account.php";
require_once $root . $publicFolder . "/classes/Airplane.php";
require_once $root . $publicFolder . "/classes/FlightPlan.php";
require_once $root . $publicFolder . "/classes/Checklist.php";
require_once $root . $publicFolder . "/classes/Logbook.php";

require_once $root . $publicFolder . "/classes/Aircraft.php";
require_once $root . $publicFolder . "/classes/Obstacle.php";

require_once $root . $publicFolder . "/classes/Awos.php";
require_once $root . $publicFolder . "/classes/AwosRemarks.php";

require_once $root . $publicFolder . "/classes/ChartSupplement.php";
require_once $root . $publicFolder . "/classes/DigitalTerminalProcedures.php";
require_once $root . $publicFolder . "/classes/Compares.php";

require_once $root . $publicFolder . "/classes/AirportList.php";
require_once $root . $publicFolder . "/classes/AirportAttended.php";
require_once $root . $publicFolder . "/classes/AirportArresting.php";
require_once $root . $publicFolder . "/classes/AirportRunway.php";
require_once $root . $publicFolder . "/classes/AirportRemarks.php";
require_once $root . $publicFolder . "/classes/Airport.php";

require_once $root . $publicFolder . "/classes/Rco.php";
require_once $root . $publicFolder . "/classes/NavaidRemarks.php";
require_once $root . $publicFolder . "/classes/Navaid.php";

require_once $root . $publicFolder . "/classes/IlsApproach.php";
require_once $root . $publicFolder . "/classes/IlsFrequency.php";
require_once $root . $publicFolder . "/classes/IlsGlideslope.php";
require_once $root . $publicFolder . "/classes/IlsDME.php";
require_once $root . $publicFolder . "/classes/IlsMarker.php";
require_once $root . $publicFolder . "/classes/IlsRemarks.php";
require_once $root . $publicFolder . "/classes/Ils.php";

require_once $root . $publicFolder . "/classes/FixNavaid.php";
require_once $root . $publicFolder . "/classes/FixIls.php";
require_once $root . $publicFolder . "/classes/FixRemarks.php";
require_once $root . $publicFolder . "/classes/FixCharting.php";
require_once $root . $publicFolder . "/classes/Fix.php";

require_once $root . $publicFolder . "/classes/Airway.php";
require_once $root . $publicFolder . "/classes/StarDp.php";
require_once $root . $publicFolder . "/classes/PreferredRoute.php";
require_once $root . $publicFolder . "/classes/CodedDepartureRoute.php";
require_once $root . $publicFolder . "/classes/CodedInstrumentFlightProcedure.php";
require_once $root . $publicFolder . "/classes/CodedInstrumentFlightProcedureExcluded.php";

require_once $root . $publicFolder . "/classes/TowerFrequency.php";
require_once $root . $publicFolder . "/classes/TowerAtis.php";
require_once $root . $publicFolder . "/classes/TowerAirspace.php";
require_once $root . $publicFolder . "/classes/TowerHoursOfOp.php";
require_once $root . $publicFolder . "/classes/TowerRadars.php";
require_once $root . $publicFolder . "/classes/TowerRemarks.php";
require_once $root . $publicFolder . "/classes/TowerServices.php";
require_once $root . $publicFolder . "/classes/Tower.php";

require_once $root . $publicFolder . "/classes/PjaRemarks.php";
require_once $root . $publicFolder . "/classes/PjaContact.php";
require_once $root . $publicFolder . "/classes/PjaUserGroup.php";
require_once $root . $publicFolder . "/classes/PjaTimes.php";
require_once $root . $publicFolder . "/classes/PjaLocation.php";

require_once $root . $publicFolder . "/classes/MaaBaseData.php";
require_once $root . $publicFolder . "/classes/MaaPolyCoord.php";
require_once $root . $publicFolder . "/classes/MaaTimesOfUse.php";
require_once $root . $publicFolder . "/classes/MaaUserGroup.php";
require_once $root . $publicFolder . "/classes/MaaContact.php";
require_once $root . $publicFolder . "/classes/MaaNotams.php";
require_once $root . $publicFolder . "/classes/MaaRemarks.php";

//require_once $root . $publicFolder . "/classes/Event.php";
//require_once $root . $publicFolder . "/classes/Calendar.php";

require_once $root . $publicFolder . "/classes/Station.php";
require_once $root . $publicFolder . "/classes/TAF.php";
require_once $root . $publicFolder . "/classes/AirSigmet.php";
require_once $root . $publicFolder . "/classes/GAirmet.php";
require_once $root . $publicFolder . "/classes/Pirep.php";

require_once $root . $publicFolder . "/classes/Ramps.php";

require_once $root . $publicFolder . "/classes/FlightPlanFormatter.php";

require_once $root . $publicFolder . "/classes/Login.php";

require_once $root . $publicFolder . "/classes/Stock.php";

require_once $root . $publicFolder . "/classes/SaaGeometry.php";
require_once $root . $publicFolder . "/classes/SaaTimes.php";
require_once $root . $publicFolder . "/classes/SaaNote.php";
require_once $root . $publicFolder . "/classes/SaaLocation.php";
//================================================================================================

$sess = new SessionMgr();

// When you don't have access to setting the server's configuration
// you can set the date and time of the cookie to 0 and
// php will destroy the cookie when the browser is closed
setcookie("PHPSESSID", $sess->sessionId, 0, "/");

//================================================================================================
$currPage = explode('/', CurrentPageURL());

$cpa = explode("?", $currPage[count($currPage)-1]);

$cpa2 = explode(".", $cpa[0]);

$currPage[count($currPage)-1] = $cpa2[0];

$sess->SetSessionVariable("hostname", $currPage[2]);

$sess->SetSessionVariable("currPage", $currPage[3]);

if (count($currPage) == 5)
{
	$sess->SetSessionVariable("docName", $currPage[4]);
}
//================================================================================================
$lo = null;

if (isset($_GET["lo"]))
{
	$lo = $_GET["lo"];
}

if ($sess->loggedOn != '1' || $lo != null)
{
	$lopilotId = null;

	if (isset($_POST["lopilotId"]))
	{
		$lopilotId = $_POST["lopilotId"];
	}

	$lopilotPassword = null;

	if (isset($_POST["lopilotPassword"]))
	{
		$lopilotPassword = $_POST["lopilotPassword"];
	}

	$socb = null;

	if (isset($_POST["signOnCheckbox"]))
	{
		$socb = $_POST["signOnCheckbox"];
	}

	$l = new Login($lopilotId, $lopilotPassword, $lo, $sess, $currPage, $socb);
}
?>