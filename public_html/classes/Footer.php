<?php
class Footer
{
	public function __construct()
	{
		printf("<table class=\"footerTable\">\r\n");

		printf("<tr>\r\n");
		printf("<td class=\"footertd\"><a class=\"footertd\" href=\"http://www.ecfr.gov/cgi-bin/text-idx?tpl=/ecfrbrowse/Title14/14tab_02.tpl\">e-CFR Title 14</a></td>\r\n");
		printf("<td class=\"footertd\"><a class=\"footertd\" href=\"http://skyvector.com/\">Sky Vector Charts</a></td>\r\n");
		printf("<td class=\"footertd\"><a class=\"footertd\" href=\"http://www.spc.noaa.gov/\">Storm Prediction Center</a></td>\r\n");
		printf("<td class=\"footertd\"><a class=\"footertd\" href=\"https://www.1800wxbrief.com\">1-800-WX-BRIEF</a></td>\r\n");
		printf("</tr>\r\n");

		printf("<tr>\r\n");
		printf("<td class=\"footertd\"><a class=\"footertd\" href=\"https://sua.faa.gov/sua/siteFrame.app\">Special Use Airspace</a></td>\r\n");
		printf("<td class=\"footertd\"><a class=\"footertd\" href=\"http://notams.aim.faa.gov/notamSearch/\">NOTAMS</a></td>\r\n");
		printf("<td class=\"footertd\"><a class=\"footertd\" href=\"https://www.faa.gov/regulations_policies/advisory_circulars/index.cfm/go/document.list\">Advisory Circulars</a></td>\r\n");
		printf("<td class=\"footertd\"><a class=\"footertd\" href=\"https://www.faa.gov/regulations_policies/handbooks_manuals/aviation/\">Handbooks</a></td>\r\n");
		printf("</tr>\r\n");

		printf("<tr>\r\n");
		printf("<td class=\"footertd\"><a class=\"footertd\" href=\"http://www.faa.gov/airports/resources/acronyms/\">FAA Acronyms</a></td>\r\n");
		printf("<td class=\"footertd\"><a class=\"footertd\" href=\"http://www.faa.gov/jobs/abbreviations/\">More FAA Acronyms</a></td>\r\n");
		printf("<td class=\"footertd\"><a class=\"footertd\" href=\"http://sunrise-sunset.org/\">Sunrise Sunset</a></td>\r\n");
		printf("<td class=\"footertd\"><a class=\"footertd\" href=\"https://www.faa.gov/forms/\">FAA Forms</a></td>\r\n");
		printf("</tr>\r\n");

		printf("<tr>\r\n");
		printf("<td class=\"footertd\"><a class=\"footertd\" href=\"../metarDecoding/index.htm\">Metar Decoding</a></td>\r\n");
		printf("<td class=\"footertd\"><a class=\"footertd\" href=\"https://www.faa.gov/air_traffic/flight_info/aeronav/Aero_Data/\">Aeronautical Data</a></td>\r\n");
		printf("<td class=\"footertd\"><a class=\"footertd\" href=\"https://www.faa.gov/air_traffic/flight_info/aeronav/digital_products/\">Digital Products</a></td>\r\n");
		printf("<td class=\"footertd\"><a class=\"footertd\" href=\"https://www.faa.gov/air_traffic/flight_info/aeronav/digital_products/cifp/\">Coded Instrument Flight Procedures</a></td>\r\n");
		printf("</tr>\r\n");

		printf("<tr>\r\n");
		printf("<td colspan=\"4\" class=\"footerText\">\r\n");
		printf("The information supplied in this website is official FAA NASR data and is accurate to the valid date at the top of the page for creating IFR and VFR flight plans.");
		printf("\r\n<br/>Please contact 1-800-WXBRIEF (1-800-992-7433) for your preflight weather briefing even though weather station information is being provided.");
		//printf("\r\n<br/>Report broken links or other site issues to MyFlightPlanner@hotmail.com");
		printf("\r\n<br/>&#169;2010-%s My Flight Planner", date("Y", time()));
		printf("</td>\r\n");
		printf("</tr>\r\n");

		printf("</table>\r\n");
	}
}
?>