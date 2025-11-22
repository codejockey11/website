<?php
class Ils
{
	public $ilsApproach;
	public $ilsFrequency;
	public $ilsGlideslope;
	public $ilsDME;
	public $ilsMarker;
	public $ilsRemarks;

	public $sess;

	public function __construct($sess, $ident, $rwy)
	{
		$this->sess = $sess;

		$this->ilsApproach = new IlsApproach($ident, $rwy);
		$this->ilsFrequency = new IlsFrequency($ident, $rwy);
		$this->ilsGlideslope = new IlsGlideslope($ident, $rwy);
		$this->ilsDME = new IlsDME($ident, $rwy);
		$this->ilsMarker = new IlsMarker($this->sess, $ident, $rwy);
		$this->ilsRemarks = new IlsRemarks($ident, $rwy);
	}

	public function ListEntries()
	{
		$str  = $this->ilsApproach->ListEntries();
		
		$str .= $this->ilsFrequency->ListEntries();
		
		$str .= $this->ilsGlideslope->ListEntries();
		
		$str .= $this->ilsDME->ListEntries();
		
		$str .= $this->ilsMarker->ListEntries();
		
		$str .= $this->ilsRemarks->ListEntries();

		return $str;
	}

	public function FormatPlanInfo()
	{
		$str  = "\r\n<br/>";
		
		$str .= $this->ilsApproach->WaypointInfo();
		
		$str .= $this->ilsFrequency->WaypointInfo();
		
		$str .= $this->ilsGlideslope->WaypointInfo();
		
		$str .= $this->ilsDME->WaypointInfo();
		
		$str .= $this->ilsMarker->WaypointInfo();

		return $str;
	}
}
?>