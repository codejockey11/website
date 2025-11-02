<?php
//==========================================================================================
function OneSpace($str)
{
	$stra = str_split(trim($str));

	$rstr = null;

	$needSpace = "F";

	foreach ($stra as $chr)
	{
		// ord($chr); ASCII 33 thru 126 viewable characters
		if ((ord($chr) > 32) && (ord($chr) < 127))
		{
			$rstr .= $chr;
			
			$needSpace = "T";
		}
		else if ($needSpace == "T")
		{
			$rstr .= " ";
			
			$needSpace = "F";
		}
	}

	return trim($rstr);
}
//==========================================================================================
function FlipTimeDate($str)
{
	$stra = explode(" ", $str);

	$part = explode("-", $stra[0]);

	$rstr  = $part[1];
	$rstr .= "-";

	$rstr .= $part[2];
	$rstr .= "-";

	$rstr .= $part[0];
	$rstr .= " ";

	$rstr .= $stra[1];

	return $rstr;
}
//==========================================================================================
// enable extension=php_openssl.dll in case of https
class CheckHttp
{
	public $isFound;

	public function __construct($h)
	{
		$fileHeaders = @get_headers($h);

		if ($fileHeaders === false)
		{
			$this->isFound = 0;

			return;
		}

		if (count($fileHeaders) == 0)
		{
			$this->isFound = 0;

			return;
		}

		if (strcmp($fileHeaders[0], "HTTP/1.0 404 Not Found") == 0)
		{
			$this->isFound = 0;

			return;
		}

		if (strcmp($fileHeaders[0], "HTTP/1.1 404 Not Found") == 0)
		{
			$this->isFound = 0;

			return;
		}

		$this->isFound = 1;
	}
}
//==========================================================================================
function varDump($comment, $variable)
{
	ob_start();

	var_dump($variable);

	$output = ob_get_contents();

	ob_end_clean();

	error_log("\n" . $output);

	if ($comment === true)
	{
		echo "/*\r\n<pre>\r\n" . $output . "\r\n</pre>\r\n*/\r\n";
	}
	else
	{
		echo "\r\n<pre>\r\n" . $output . "\r\n</pre>\r\n";
	}
}
//==========================================================================================
function RemoveLeadingZeroes($str, $html)
{
	$rstr = null;

	$fn = 0;

	$stra = str_split($str);

	for ($x = 0;$x < count($stra);$x++)
	{
		if ($stra[$x] == "0")
		{
			if ($fn == 1)
			{
				$rstr .= $stra[$x];
			}
			else
			{
				if ($html)
				{
					$rstr .= "&nbsp;";
				}
				else
				{
					$rstr .= " ";
				}
			}
		}
		else
		{
			$fn = 1;

			$rstr .= $stra[$x];
		}
	}

	return $rstr;
}
//==========================================================================================
function CurrentPageURL()
{
	$pageURL = "http";

	if (isset($_SERVER["HTTPS"]))
	{
		if (strcmp($_SERVER["HTTPS"], "on") == 0)
		{
			$pageURL .= "s";
		}
	}

	$pageURL .= "://";

	if (strcmp($_SERVER["SERVER_PORT"], "80") != 0)
	{
		$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
	}
	else
	{
		$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
	}

	return $pageURL;
}
//==========================================================================================
function ValidateEmail($email)
{
	$emaila = str_split($email);

	$c = 0;
	
	$amp = 0;
	$ampl = 0;
	
	$dot = 0;
	$dotl = 0;

	foreach ($emaila as $part)
	{
		if (strcmp($part,"@") == 0)
		{
			$amp = 1;

			$ampl = $c;

			if ($c == 0)
			{
				return 0;
			}
		}

		if (strcmp($part,".") == 0)
		{
			$dot = 1;

			$dotl = $c;

			if ($c == 0)
			{
				return 0;
			}
		}

		$c++;
	}

	if ($amp == 0)
	{
		return 0;
	}

	if ($dot == 0)
	{
		return 0;
	}

	if ($dotl < $ampl)
	{
		return 0;
	}

	$alpo = $ampl + 1;

	if ($dotl <= $alpo)
	{
		return 0;
	}

	return 1;
}
//==========================================================================================
function Alert($s)
{
	printf("<script>alert('%s')</script>", $s);
}
//==========================================================================================
function UpdateWaypoint($sess, $wp)
{
	if (isset($_POST["addWaypoint"]))
	{
		if (isset($_POST['waypointSelect']))
		{
			$point = $_POST['waypointSelect'];

			$waypoints = explode(" ", $sess->waypoints);

			$index = 0;

			if ($point != "Waypoints")
			{
				foreach($waypoints as $waypoint)
				{
					if ($waypoint == $point)
					{
						break;
					}

					$index++;
				}

				array_splice($waypoints, $index + 1, 0, array($wp));
			}
			else
			{
				array_splice($waypoints, $index, 0, array($wp));
			}

			$sess->waypoints = "";

			foreach($waypoints as $waypoint)
			{
				$sess->waypoints .= $waypoint . " ";
			}

			$sess->waypoints = trim($sess->waypoints);

			$sess->SetSessionVariable("waypoints", $sess->waypoints);
		}
		else
		{
			$sess->waypoints = $wp;

			$sess->SetSessionVariable("waypoints", $sess->waypoints);
		}
	}

	if (isset($_POST["deleteWaypoint"]))
	{
		if ($_POST['waypointSelect'])
		{
			$point = $_POST['waypointSelect'];

			$waypoints = explode(" ", $sess->waypoints);

			$index = 0;

			foreach($waypoints as $waypoint)
			{
				if ($waypoint == $point)
				{
					break;
				}

				$index++;
			}

			unset($waypoints[$index]);

			$sess->waypoints = "";

			foreach($waypoints as $waypoint)
			{
				$sess->waypoints .= $waypoint . " ";
			}

			$sess->waypoints = trim($sess->waypoints);

			$sess->SetSessionVariable("waypoints", $sess->waypoints);
		}
	}
}
//==========================================================================================
function WaypointDropdown($sess)
{
	printf("<td><input type=\"submit\" value=\"Add\" name=\"addWaypoint\" class=\"button\" /></td>");
	
	printf("<td><input type=\"submit\" value=\"Delete\" name=\"deleteWaypoint\" class=\"button\" /></td>");

	if ($sess->waypoints != "")
	{
		printf("<td><select name=\"waypointSelect\" id=\"waypointSelect\" size=\"1\">\r\n");

		printf("<option value=\"Waypoints\" title=\"Waypoints\">Waypoints</option>\r\n");

		$waypoints = explode(" ", $sess->waypoints);

		foreach ($waypoints as $waypoint)
		{
			printf("<option value=\"%s\" title=\"%s\">%s</option>\r\n", $waypoint, $waypoint, $waypoint);
		}

		printf("</select></td></tr></table>\r\n");

		printf("<table><tr><td>%s</td></tr></table>", $sess->waypoints);
	}
	else
	{
		printf("</tr></table>");
	}
}
//==========================================================================================
?>