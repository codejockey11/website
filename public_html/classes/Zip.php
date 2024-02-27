<?php
class Zip
{
	public $sess;
	public $zip;

	public function __construct($sess, $filename)
	{
		$this->sess = $sess;

		$z = zip_open($filename);

		if (is_resource($z))
		{
			$this->zip = $z;
		}
	}

	public function __destruct()
	{
		if ($this->zip == null)
		{
			return;
		}

		zip_close($this->zip);
	}

	public function ExtractEntry($name, $dir)
	{
		if ($this->zip == null)
		{
			return;
		}

		$zip_entry = zip_read($this->zip);

		while ($zip_entry)
		{
			$zena = explode("/", zip_entry_name($zip_entry));

			$zname = "";

			if (count($zena) == 1)
			{
				$zname = $zena[0];
			}

			if (count($zena) == 2)
			{
				$zname = $zena[1];
			}

			if (strcmp($zname, $name) == 0)
			{
				if (zip_entry_open($this->zip, $zip_entry, "r"))
				{
					$fp = fopen($dir . $name, "w");

					$buf = zip_entry_read($zip_entry, zip_entry_filesize($zip_entry));

					fwrite($fp, $buf);

					fclose($fp);

					zip_entry_close($zip_entry);

					break;
				}
			}

			$zip_entry = zip_read($this->zip);
		}
	}

	public function LocateEntry($name)
	{
		if ($this->zip == null)
		{
			return false;
		}

		while($zip_entry = zip_read($this->zip))
		{
			if (strcmp(zip_entry_name($zip_entry), $name) == 0)
			{
				return true;
			}
		}

		return false;
	}

	public function EntryInfo($name)
	{
		if ($this->zip == null)
		{
			return;
		}

		$str = null;

		while($zip_entry = zip_read($this->zip))
		{
			if ($name == null)
			{
				$str .= "Name:               " . zip_entry_name($zip_entry) . "\r\n<br/>";
				$str .= "Actual Filesize:    " . zip_entry_filesize($zip_entry) . "\r\n<br/>";
				$str .= "Compressed Size:    " . zip_entry_compressedsize($zip_entry) . "\r\n<br/>";
				$str .= "Compression Method: " . zip_entry_compressionmethod($zip_entry) . "\r\n<br/>";
				$str .= "\r\n<br/>";
			}
			else if (zip_entry_name($zip_entry) == $name)
			{
				$str .= "Name:               " . zip_entry_name($zip_entry) . "\r\n<br/>";
				$str .= "Actual Filesize:    " . zip_entry_filesize($zip_entry) . "\r\n<br/>";
				$str .= "Compressed Size:    " . zip_entry_compressedsize($zip_entry) . "\r\n<br/>";
				$str .= "Compression Method: " . zip_entry_compressionmethod($zip_entry) . "\r\n<br/>";
				$str .= "\r\n<br/>";

				break;
			}
		}

		return $str;
	}
}
?>