<?php
class Temperature
{
	public $fValue;
	public $cValue;
	public $kValue;
	public $rValue;
	public $vValue;

	public function __construct($tp, $t)
	{
		if (strcmp($tp, "C") == 0)
		{
			$this->cValue = floatval($t);
			$this->fValue = floatval($this->ConvertCtoF($this->cValue));
			$this->kValue = floatval($this->ConvertCtoK($this->cValue));
			$this->rValue = floatval($this->ConvertKtoR($this->kValue));
		}

		if (strcmp($tp, "F") == 0)
		{
			$this->fValue = floatval($t);
			$this->cValue = floatval($this->ConvertFtoC($this->fValue));
			$this->kValue = floatval($this->ConvertCtoK($this->cValue));
			$this->rValue = floatval($this->ConvertKtoR($this->kValue));
		}

		if (strcmp($tp, "K") == 0)
		{
			$this->kValue = floatval($t);
			$this->cValue = floatval($this->ConvertKtoC($this->kValue));
			$this->fValue = floatval($this->ConvertCtoF($this->cValue));
			$this->rValue = floatval($this->ConvertKtoR($this->kValue));
		}
	}

	public function ConvertCtoF($t)
	{
		return ($t * (9/5)) + 32;
	}

	public function ConvertCtoK($t)
	{
		return $t + 273.15;
	}

	public function ConvertFtoC($t)
	{
		return ($t - 32) * (5/9);
	}

	public function ConvertKtoR($t)
	{
		$tc = $this->ConvertKtoC($t);
		
		$tf = $this->ConvertCtoF($tc);

		return $tf + 459.69;
	}

	public function ConvertKtoC($t)
	{
		return $t - 273.15;
	}
}
?>