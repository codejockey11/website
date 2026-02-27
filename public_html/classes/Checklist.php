<?php
class ChecklistData
{
	public $id;
	public $pilotId;
	public $registration;
	public $image;

	public function FormatEntry()
	{
		$str  = sprintf("<img id=\"image%s\" src=\"../images/checkboxUnchecked.png\" onclick=\"CheckboxClicked('%s')\" />\r\n", $this->image, $this->image);
		
		$str .= sprintf("<input type=\"checkbox\" name=\"check[]\" value=\"%s\" id=\"%s\"\r\n>", $this->image, $this->image);
		
		$str .= sprintf("<a href=\"../myAirplane/checklists/%s\">%s</a>\r\n", $this->image, $this->image);

		return $str;
	}
}

class Checklist
{
	public $checklist = array();

	public function __construct($pilotId, $registration)
	{
		if ($registration == null)
		{
			$sql = sprintf("SELECT * FROM checklist WHERE pilotId='%s'", $pilotId);
		}
		else
		{
			$sql = sprintf("SELECT * FROM checklist WHERE pilotId='%s' AND registration='%s'", $pilotId, $registration);
		}

		$checklistDbase = new Database();

		$checklistDbase->ExecSql($sql);

		if ($checklistDbase->GetRowCount() > 0)
		{
			while($row = $checklistDbase->FetchRow())
			{
				$this->GetRow($row);
			}
		}
		else
		{
			$this->checklist = null;
		}

		$checklistDbase->Disconnect();
	}

	public function GetRow($row)
	{
		$checklistData = new ChecklistData();

		$checklistData->id = $row["id"];
		$checklistData->pilotId = $row["pilotId"];
		$checklistData->registration = $row["registration"];
		$checklistData->image = $row["image"];

		array_push($this->checklist, $checklistData);
	}

	public function ListEntries()
	{
		$str = "<table style=\"border-collapse:collapse\">\r\n<tr>\r\n<td>\r\n<table>\r\n<tr>\r\n";

		if ($this->checklist == null)
		{
			$str .= "<td>No Checklists</td>\r\n";
			
			$str .= "</tr>\r\n</table>\r\n</td>\r\n</tr>\r\n</table>\r\n";

			return $str;
		}

		$c = 0;

		foreach ($this->checklist as $cls)
		{
			switch($c)
			{
				case 3:
				case 6:
				case 9:
				case 12:
				case 15:
				case 18:
				{
					$str .= "\r\n</tr>\r\n<tr>\r\n";
					break;
				}

				default:
				{
					break;
				}
			}

			$str .= "\r\n<td class=\"checkboxChecklist\">" . $cls->FormatEntry() . "</td>\r\n";
			
			$c++;
		}

		$str .= "</tr>\r\n</table>\r\n</td>\r\n</tr>\r\n</table>\r\n";

		return $str;
	}

	public function AddChecklist($pilotId, $registration, $image)
	{
		$sql = sprintf("INSERT INTO checklist (pilotId,registration,image) VALUES ('%s','%s','%s')", $pilotId, $registration, $image);

		$checklistDbase = new Database();
		
		$checklistDbase->ExecSql($sql);
		
		$checklistDbase->Disconnect();
	}

	public function DeleteChecklist($pilotId, $image)
	{
		$sql = sprintf("DELETE FROM checklist WHERE pilotId='%s' AND image='%s'", $pilotId, $image);

		$checklistDbase = new Database();
		
		$checklistDbase->ExecSql($sql);
		
		$checklistDbase->Disconnect();
	}

	public function CheckName($image)
	{
		$sql = sprintf("SELECT * FROM checklist WHERE image='%s'", $image);

		$checklistDbase = new Database();
		
		$checklistDbase->ExecSql($sql);

		if ($checklistDbase->GetRowCount() > 0)
		{
			$checklistDbase->Disconnect();
			
			return true;
		}

		$checklistDbase->Disconnect();
		
		return false;
	}
}
?>