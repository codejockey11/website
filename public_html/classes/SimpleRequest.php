<?php
class SimpleRequest
{
	public $xml;

	public function __construct($url)
	{
		error_reporting(E_ALL & ~E_WARNING & ~E_DEPRECATED & ~E_STRICT);
		
		$this->xml = simplexml_load_file($url, 'SimpleXMLElement');
		
		error_reporting(E_ALL & ~E_DEPRECATED & ~E_STRICT);

		if ($this->xml === false)
		{
			$this->xml = null;
		}
	}
}
?>