<?php
class GoogleMap
{
	public $myKey = "&key=";

	public $latLon;

	public $width = "325";
	public $height = "280";

	public $zoom = "12";
	public $zoom2 = "12";

	public $embedLink = "https://www.google.com/maps/embed/v1/view?";

	public function __construct($lat, $lon, $a, $w, $h)
	{
		if ($lat == null || $lon == null)
		{
			return;
		}

		$this->latLon = new LatLon($lat, $lon);

		if ($a < 7000)
		{
			$this->zoom = 12;
		}

		if ($a < 5000)
		{
			$this->zoom = 13;
		}

		if ($a < 2000)
		{
			$this->zoom = 14;
		}

		if ($a < 500)
		{
			$this->zoom = 15;
		}

		$r = strcmp($a, "None");
		
		if ($r == 0)
		{
			$this->zoom = 12;
		}

		if ($w)
		{
			$this->width = $w;
		}
		
		if ($h)
		{
			$this->height = $h;
		}
	}

	public function ShowMap()
	{
		$str  = sprintf("<iframe scrolling=\"no\"");
		$str .= sprintf("width=\"%s\" ", $this->width);
		$str .= sprintf("height=\"%s\" ", $this->height);
		$str .= sprintf("frameborder=\"1\" src=\"");
		
		$str .= $this->embedLink;
		
		$str .= $this->myKey;
		
		$str .= sprintf("&zoom=%s&center=", $this->zoom);
		$str .= sprintf("%s,%s", $this->latLon->decimalLat, $this->latLon->decimalLon);
		$str .= sprintf("\">\r\n");
		$str .= sprintf("</iframe>\r\n");

		return $str;
	}
}
?>