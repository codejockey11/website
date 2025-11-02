<?php
class BingMap
{
	public $key = "ArZP1HDL-as-_VQnajKbHiDpKqkkSHhLbIyBSUWi0lWZw9b6h8vWJ3H80KJ9fYw9";

	public $latLon;

	public $width = "325";
	public $height = "280";
	public $zoom = "12";

	public $embedLink = "http://www.bing.com/maps/embed/viewer.aspx?v=3&sty=r&typ=d&dir=0&mkt=en-us&form=BMEMJS";

	public function __construct($lat, $lon, $a, $w, $h)
	{
		if (($lat == null) || ($lon == null))
		{
			return;
		}

		$this->latLon = new LatLon($lat, $lon);

		if ($a >= 50)
		{
			$this->zoom = 15;
		}

		if ($a >= 125)
		{
			$this->zoom = 14;
		}

		if ($a >= 1000)
		{
			$this->zoom = 13;
		}

		if ($a >= 5000)
		{
			$this->zoom = 12;
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
		
		$str .= sprintf("&cp=%s~%s", $this->latLon->decimalLat, $this->latLon->decimalLon);
		
		$str .= sprintf("&lvl=%s", $this->zoom);
		
		$str .= sprintf("&w=%s", $this->width);
		
		$str .= sprintf("&h=%s", $this->height);
		
		$str .= sprintf("\"></iframe>\r\n");

		$str .= sprintf("\r\n<br/><a href=\"http://www.bing.com/mapspreview?q=%s,%s&cp=%s~%s&lvl=%s\">Ariel View</a>\r\n", $this->latLon->decimalLat, $this->latLon->decimalLon, $this->latLon->decimalLat, $this->latLon->decimalLon, $this->zoom);

		return $str;
	}
}
?>