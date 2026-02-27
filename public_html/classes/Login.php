<?php
class Login
{
	public $sess;

	public function __construct($lopilotId, $lopilotPassword, $lo, $sess, $currPage, $socb)
	{
		$this->sess = $sess;

		switch($lo)
		{
			// logout
			case "O":
			{
				unset($_GET['lo']);

				$this->sess->DestroySession($sess->sessionId);

				$this->sess = new SessionMgr();

				$this->sess->SetSessionVariable("hostname", $currPage[2]);
				
				$this->sess->SetSessionVariable("currPage", $currPage[3]);

				if (count($currPage) == 5)
				{
					$this->sess->SetSessionVariable("docName", $currPage[4]);
				}

				setcookie("id", null, time() - 1000000, "/");
				
				setcookie("pass", null, time() - 1000000, "/");

				$this->Redirect();

				break;
			}

			// login typed
			case "I":
			{
				if (($lopilotId) && ($lopilotPassword))
				{
					$account = new Account($lopilotId, $lopilotPassword, null);

					if ($account->pilotId)
					{
						$this->SetSessionVariables($account);

						if ($socb === "true")
						{
							// cookie is set to expire in 5000 days
							setcookie("id", $account->pilotId, time() + 60 * 60 * 24 * 5000, "/", null, null, true);
							
							setcookie("pass", $account->pilotPassword, time() + 60 * 60 * 24 * 5000, "/", null, null, true);

							unset($socb);
						}

						unset($_GET['lo']);

						$this->Redirect();
					}
				}

				break;
			}

			// login with Cookie
			default:
			{
				if (isset($_COOKIE["id"]) && isset($_COOKIE["pass"]))
				{
					if ($this->sess->loggedOn == null)
					{
						$account = new Account($_COOKIE["id"], null, $_COOKIE["pass"]);
						
						if ($account->pilotId)
						{
							$this->SetSessionVariables($account);

							$this->Redirect();
						}
					}
				}

				break;
			}
		}
	}

	private function SetSessionVariables($account)
	{
		$this->sess->SetSessionVariable("pilotId", $account->pilotId);
		$this->sess->SetSessionVariable("currentEmail", $account->email);
		$this->sess->SetSessionVariable("firstName", $account->firstName);
		$this->sess->SetSessionVariable("lastName", $account->lastName);
		$this->sess->SetSessionVariable("homeBase", $account->homeBase);
		$this->sess->SetSessionVariable("showHeliport", $account->showHeliport);
		$this->sess->SetSessionVariable("showFrequency", $account->showFrequency);
		$this->sess->SetSessionVariable("loggedOn", 1);

		$sql = sprintf("SELECT * FROM aptAirport WHERE ICAO='%s'", $account->homeBase);
		
		$a = new Airport($this->sess, $sql);

		if ($a->airport != null)
		{
			$apt = $a->GetSingle(0);

			$ll = sprintf("%s,%s", $apt->latLon->decimalLat, $apt->latLon->decimalLon);

			$this->sess->SetSessionVariable("mapCenter", $ll);
		}
	}

	private function Redirect()
	{
		if ((strcmp($this->sess->currPage, "myAccount") == 0) || (strcmp($this->sess->currPage, "myAirplane") == 0) || (strcmp($this->sess->currPage, "signUp") == 0))
		{
			printf("<script>window.location='../airport/index.php?id=%s'</script>\r\n", $this->sess->sessionId);
		}
		else if (($this->sess->currPage != "test") && ($this->sess->currPage != "xmlFormatters"))
		{
			printf("<script>window.location='../%s/index.php?id=%s'</script>\r\n", $this->sess->currPage, $this->sess->sessionId);
		}
	}
}
?>