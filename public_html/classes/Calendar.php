<?php
class Calendar
{
	public function __construct($y, $m, $id)
	{
		// calculate next and prev month and year used for next / prev month navigation links and
		// store them in respective variables
		$prevYear = $y;
		$nextYear = $y;

		$prevMonth = intval($m) - 1;
		$nextMonth = intval($m) + 1;

		// if current month is December or January
		// month navigation links have to be updated to point to next / prev years
		if ($m == 12)
		{
			$nextMonth = 1;
			
			$nextYear = $y + 1;
		}
		else if ($m == 1)
		{
			$prevMonth = 12;
			
			$prevYear = $y - 1;
		}

		$prevMonth = sprintf("%02d", $prevMonth);
		$nextMonth = sprintf("%02d", $nextMonth);

		printf("<table>\r\n");

		printf("<tr>\r\n");
		
		printf("<td><a href=\"index.php?id=%s&month=%s&year=%s\">&lt;&lt;</a></td>\r\n", $id, $prevMonth, $prevYear);
		
		printf("<td  colspan=\"5\">\r\n");
		printf(date("F, Y",strtotime($y . "-". $m . "-01")));
		printf("</td>\r\n");

		printf("<td><a href=\"index.php?id=%s&month=%s&year=%s\">&gt;&gt;</a></td>\r\n", $id, $nextMonth, $nextYear);
		
		printf("</tr>\r\n");
		
		printf("<tr>\r\n");
		printf("<td>S</td>\r\n");
		printf("<td>M</td>\r\n");
		printf("<td>T</td>\r\n");
		printf("<td>W</td>\r\n");
		printf("<td>T</td>\r\n");
		printf("<td>F</td>\r\n");
		printf("<td>S</td>\r\n");
		printf("</tr>\r\n");

		// time stamp for first day of the month used to calculate
		$first_day_timestamp = mktime(0, 0, 0, $m, 1, $y);

		// number of days in current month
		$maxday = date("t", $first_day_timestamp);

		// find out which day of the week the first date of the month is
		$thismonth = getdate($first_day_timestamp);

		// 0 is for Sunday and ifwant week to start on Mon we subtract 1
		$startday = $thismonth['wday'];

		// get today's day for hilite
		$todayday   = date("d");
		$todayMonth = date("m");
		$todayYear  = date("Y");

		for ($i=0; $i<($maxday + $startday); $i++)
		{
			if (($i % 7) == 0)
			{
				printf("<tr>\r\n");
			}

			if ($i < $startday)
			{
				printf("<td> </td>\r\n");
				
				continue;
			}

			$currentDay = $i - $startday + 1;
			
			$currentDay = sprintf("%02d", $currentDay);

			// check if there are any events on this day
			$ymd = sprintf("%04d%02d%02d", $y, $m, $currentDay);
			
			$e = new Event($ymd);
			
			if (count($e->event) > 0)
			{
				printf("<td><a href=\"index.php?id=%s&action=list&year=%s&month=%s&day=%s\">%02d</a></td>\r\n", $id, $y, $m, $currentDay, $currentDay);
			}
			else if (($currentDay == $todayday) && ($m == $todayMonth) && ($y == $todayYear))
			{
				printf("<td>%02d</td>\r\n", $currentDay);
			}
			else
			{
				printf("<td>%02d</td>\r\n", $currentDay);
			}

			if (($i % 7) == 6)
			{
				printf("</tr>\r\n");
			}
		}

		printf("</table>\r\n");
	}
}
?>