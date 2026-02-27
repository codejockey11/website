<?php
class Phonetic
{
	public $value;

	public function __construct($name)
	{
		$this->value = null;

		$ca = str_split($name);

		foreach ($ca as $c)
		{
			if (($c >= "A") && ($c <= "Z"))
			{
				if (($c != "A") && ($c != "E") && ($c != "I") && ($c != "O") && ($c != "U"))
				{
					$this->value .= $c;
				}
			}
		}
	}
}
?>