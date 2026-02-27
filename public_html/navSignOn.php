<table>
<tr>
<?php
//==========================================================================================================================
if (($sess->loggedOn == 1) && ($sess->pilotId))
{
	printf("<td class=\"navSignOn\">%s", $sess->pilotId);

	printf("&nbsp;<button class=\"smallButton\" onclick=\"window.location.href='../%s/index.php?id=%s&lo=O'\">SignOff</button>\r\n", $sess->currPage, $sess->sessionId);

	printf("<button id=\"accountLink\" class=\"smallButton\" onclick=\"window.location.href='../myAccount/index.php?id=%s'\">Account</button>\r\n", $sess->sessionId);

	if ($sess->registration == null)
	{
		printf("<button id=\"airplaneLink\" class=\"smallButton\" onclick=\"window.location.href='../myAirplane/index.php?id=%s'\">Airplane</button>\r\n", $sess->sessionId);
	}
	else
	{
		$p = new Airplane($sess, $sess->registration);

		if ($pln = $p->GetSingle(0))
		{
			printf("<button id=\"airplaneLink\" class=\"smallButton\" onclick=\"window.location.href='../myAirplane/index.php?id=%s'\">%s</button>\r\n", $sess->sessionId, $pln->registration);
		}
		else
		{
			printf("<button id=\"airplaneLink\" class=\"smallButton\" onclick=\"window.location.href='../myAirplane/index.php?id=%s'\">Airplane</button>\r\n", $sess->sessionId);
		}
	}

	printf("<button id=\"logbookLink\" class=\"smallButton\" onclick=\"window.location.href='../myLogbook/index.php?id=%s'\">Logbook</button></td>\r\n", $sess->sessionId);

	$p = new Parameter("effectiveDate");

	printf("<td class=\"clock\" id=\"clock1\"></td><td class=\"clock\" id=\"clock2\"></td><td class=\"clock\">Valid:%s</td>\r\n", $p->value1);

	printf("<td style=\"width:300px;\"></td>");
}
else
{
	printf("<form id=\"signOn\" method=\"post\" action=\"../%s/index.php?id=%s&lo=I\">\r\n", $sess->currPage, $sess->sessionId);

	printf("<td class=\"navSignOn\">\r\n");

	printf("<input type=\"text\" id=\"lopilotId\" name=\"lopilotId\" value=\"%s\" />\r\n", $sess->pilotId);

	printf("<input type=\"password\" id=\"lopilotPassword\" name=\"lopilotPassword\" value=\"\" />\r\n");

	printf("<input class=\"smallButton\" id=\"button\" type=\"submit\" name=\"signOn\" value=\"SignOn\" />\r\n");

	printf("<button id=\"signUpLink\" name=\"signUpLink\" class=\"smallButton\" onclick=\"window.location.href='../signUp/index.php?id=%s'\">Sign Up</button>\r\n", $sess->sessionId);

	printf("<button id=\"resetPasswordLink\" name=\"resetPasswordLink\" class=\"smallButton\" onclick=\"window.location.href='../resetPassword/index.php?id=%s'\">Reset Password</button>\r\n", $sess->sessionId);

	printf("</td>\r\n");

	printf("<td class=\"checkboxStay\"><label for=\"imagesignOnCheckbox\">Stay Logged On</label>\r\n");

	printf("<input type=\"checkbox\" id=\"signOnCheckbox\" name=\"signOnCheckbox\" value=\"true\" />\r\n");

	printf("<img id=\"imagesignOnCheckbox\" src=\"../images/checkboxUnchecked.png\" onclick=\"CheckboxClicked('signOnCheckbox')\" />\r\n");

	printf("</td>\r\n");

	$p = new Parameter("effectiveDate");

	printf("<td class=\"clock\" id=\"clock1\"></td><td class=\"clock\" id=\"clock2\"></td><td class=\"clock\">Valid:%s</td>\r\n", $p->value1);

	printf("</form>\r\n");
}

printf("</tr>\r\n");

printf("<tr><td colspan=\"10\">\r\n");

printf("<button id=\"admLink\" class=\"smallButton\" onclick=\"window.location.href='../adm/index.php?id=%s'\">ADM</button>\r\n", $sess->sessionId);
printf("<button id=\"airportLink\" class=\"smallButton\" onclick=\"window.location.href='../airport/index.php?id=%s'\">Airport</button>\r\n", $sess->sessionId);
printf("<button id=\"cdrLink\" class=\"smallButton\" onclick=\"window.location.href='../cdr/index.php?id=%s'\">CDRs</button>\r\n", $sess->sessionId);
printf("<button id=\"cfrLink\" class=\"smallButton\" onclick=\"window.location.href='../cfr/index.php?id=%s'\">CFR</button>\r\n", $sess->sessionId);
printf("<button id=\"cifpLink\" class=\"smallButton\" onclick=\"window.location.href='../cifp/index.php?id=%s'\">CIFP</button>\r\n", $sess->sessionId);
printf("<button id=\"dtppCsLink\" class=\"smallButton\" onclick=\"window.location.href='../dTPPCS/index.php?id=%s'\">dTPP CS</button>\r\n", $sess->sessionId);
printf("<button id=\"e6bLink\" class=\"smallButton\" onclick=\"window.location.href='../e6b/?id=%s'\">E6B</button>\r\n", $sess->sessionId);
printf("<button id=\"fixLink\" class=\"smallButton\" onclick=\"window.location.href='../fix/index.php?id=%s'\">Fix</button>\r\n", $sess->sessionId);
//printf("<button id=\"googleMapLink\" class=\"smallButton\" onclick=\"window.location.href='../googleMap/index.php?id=%s'\">GoogleMap</button>\r\n", $sess->sessionId);
printf("<button id=\"bingMapLink\" class=\"smallButton\" onclick=\"window.location.href='../bingMap/index.php?id=%s'\">BingMap</button>\r\n", $sess->sessionId);
printf("<button id=\"osmMapLink\" class=\"smallButton\" onclick=\"window.location.href='../openStreetMap/index.php?id=%s'\">OSMMap</button>\r\n", $sess->sessionId);
printf("<button id=\"metarLink\" class=\"smallButton\" onclick=\"window.location.href='../metar/index.php?id=%s'\">METAR</button>\r\n", $sess->sessionId);
printf("<button id=\"navaidLink\" class=\"smallButton\" onclick=\"window.location.href='../navaid/index.php?id=%s'\">Navaid</button>\r\n", $sess->sessionId);
printf("<button id=\"plannerLink\" class=\"smallButton\" onclick=\"window.location.href='../planner/index.php?id=%s'\">Planner</button>\r\n", $sess->sessionId);
printf("<button id=\"preferredLink\" class=\"smallButton\" onclick=\"window.location.href='../preferred/index.php?id=%s'\">Preferred</button>\r\n", $sess->sessionId);
printf("<button id=\"saaLink\" class=\"smallButton\" onclick=\"window.location.href='../saa/index.php?id=%s'\">SAA</button>\r\n", $sess->sessionId);
printf("<button id=\"starDpLink\" class=\"smallButton\" onclick=\"window.location.href='../starDp/index.php?id=%s'\">StarDp</button>\r\n", $sess->sessionId);
printf("<button id=\"towerLink\" class=\"smallButton\" onclick=\"window.location.href='../tower/index.php?id=%s'\">Tower</button>\r\n", $sess->sessionId);
printf("<button id=\"weatherLink\" class=\"smallButton\" onclick=\"window.location.href='../weather/index.php?id=%s'\">Weather</button>\r\n", $sess->sessionId);
printf("<button id=\"helpLink\" class=\"smallButton\" onclick=\"window.location.href='../%s/help.php?id=%s'\">Help</button>\r\n", $sess->currPage, $sess->sessionId);
?>
</table>

<?php
printf("<script type=\"text/javascript\">\r\n");

switch($sess->currPage)
{
	case "weather":
	{
		printf("document.getElementById('weatherLink').style.border = border;\r\n");

		break;
	}

	case "planner":
	{
		printf("document.getElementById('plannerLink').style.border = border;\r\n");

		break;
	}

	case "metar":
	{
		printf("document.getElementById('metarLink').style.border = border;\r\n");

		break;
	}

	case "airport":
	{
		printf("document.getElementById('airportLink').style.border = border;\r\n");

		break;
	}

	case "fix":
	{
		printf("document.getElementById('fixLink').style.border = border;\r\n");

		break;
	}

	case "navaid":
	{
		printf("document.getElementById('navaidLink').style.border = border;\r\n");

		break;
	}

	case "tower":
	{
		printf("document.getElementById('towerLink').style.border = border;\r\n");

		break;
	}

	case "starDp":
	{
		printf("document.getElementById('starDpLink').style.border = border;\r\n");

		break;
	}

	case "preferred":
	{
		printf("document.getElementById('preferredLink').style.border = border;\r\n");

		break;
	}

	case "cdr":
	{
		printf("document.getElementById('cdrLink').style.border = border;\r\n");

		break;
	}

	case "cifp":
	{
		printf("document.getElementById('cifpLink').style.border = border;\r\n");

		break;
	}

	case "cfr":
	{
		printf("document.getElementById('cfrLink').style.border = border;\r\n");

		break;
	}

	case "googleMap":
	{
		printf("document.getElementById('googleMapLink').style.border = border;\r\n");

		break;
	}

	case "dTPPCS":
	{
		printf("document.getElementById('dtppCsLink').style.border = border;\r\n");

		break;
	}

	case "e6b":
	{
		printf("document.getElementById('e6bLink').style.border = border;\r\n");

		break;
	}

	case "adm":
	{
		printf("document.getElementById('admLink').style.border = border;\r\n");

		break;
	}

	case "saa":
	{
		printf("document.getElementById('saaLink').style.border = border;\r\n");

		break;
	}

	case "signUp":
	{
		printf("document.getElementById('signUpLink').style.border = border;\r\n");

		break;
	}

	case "myAccount":
	{
		printf("document.getElementById('accountLink').style.border = border;\r\n");

		break;
	}

	case "myAirplane":
	{
		printf("document.getElementById('airplaneLink').style.border = border;\r\n");

		break;
	}

	case "myLogbook":
	{
		printf("document.getElementById('logbookLink').style.border = border;\r\n");

		break;
	}

	case "bingMap":
	{
		printf("document.getElementById('bingMapLink').style.border = border;\r\n");

		break;
	}

	case "openStreetMap":
	{
		printf("document.getElementById('osmMapLink').style.border = border;\r\n");

		break;
	}

	default:
	{
		break;
	}
}

switch($sess->docName)
{
	case "help":
	{
		printf("document.getElementById('helpLink').style.border = border;\r\n");

		break;
	}

	default:
	{
		break;
	}
}

printf("ShowClock();\r\n</script>\r\n\r\n");

if (isset($_POST["signUpLink"]))
{
	printf("<script>window.location='../signUp/index.php?id=%s'</script>\r\n", $sess->sessionId);
}

if (isset($_POST["resetPasswordLink"]))
{
	printf("<script>window.location='../resetPassword/index.php?id=%s'</script>\r\n", $sess->sessionId);
}
?>