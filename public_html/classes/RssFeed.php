<?php
class RssFeed
{
	public function __construct($feed)
	{
		$rss = new SimpleRequest($feed);

		if ($rss->xml == null)
		{
			return;
		}

		printf("<table><tr><td class=\"centerLabel\"><h2>%s</h2></td></tr>\r\n", $rss->xml->channel->title);

		foreach ($rss->xml->channel->item as $value)
		{
			printf("<tr><td>\r\n");
			
			printf("<br/><a href=\"%s\">%s</a><br/>\r\n", $value->link, $value->title);
			
			printf("%s</td></tr>\r\n", $value->description);
		}

		printf("</table>\r\n");
	}
}
?>