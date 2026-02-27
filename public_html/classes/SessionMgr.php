<?php
class SessionMgr
{
	public $sessionId;
	public $ts;
	public $loggedOn;
	public $hostname;
	public $currPage;
	public $docName;
	public $pilotId;
	public $waypoints;
	public $speed;
	public $weather;
	public $winds;
	public $alternate1;
	public $alternate2;
	public $alternate3;
	public $altitude;
	public $planType;
	public $comms;
	public $remarks;
	public $rnav;
	public $registration;
	public $airport;
	public $airportName;
	public $cityState;
	public $station;
	public $fix;
	public $navaid;
	public $tower;
	public $airway;
	public $shortName;
	public $ident;
	public $transition;
	public $computerCode;
	public $depart;
	public $arrive;
	public $dp;
	public $star;
	public $starDpFacilityId;
	public $origin;
	public $destination;
	public $cifpFacilityId;
	public $siapId;
	public $cifptransition;
	public $pilotIdSignUp;
	public $password;
	public $retypePassword;
	public $currentEmail;
	public $email;
	public $retypeEmail;
	public $firstName;
	public $lastName;
	public $homeBase;
	public $showHeliport;
	public $showFrequency;
	public $mapCenter;
	public $mapZoom;
	public $mapToggles;
	public $mapList;
	public $mapBounds;
	public $mapAirports;
	public $mapNavaids;
	public $mapFixs;
	public $mapObstacles;
	public $mapParachutes;
	public $mapMaas;
	public $mapMetars;
	public $mapWeather;
	public $mapConvective;
	public $mapTurbulence;
	public $mapIcing;
	public $mapIFR;
	public $mapMtnObscn;
	public $mapAsh;
	public $mapGIFR;
	public $mapGMtnObscn;
	public $mapGTurbHi;
	public $mapGTurbLo;
	public $mapGIce;
	public $mapGFZLVL;
	public $mapGMFZLVL;
	public $mapGSfcWind;
	public $mapGLLWS;
	public $mapPIREPs;
	public $mapRamps;
	public $pdfIdent;
	public $designator;
	public $saaName;

	public function __construct()
	{
		$this->GetSession(session_id());

		if ($this->sessionId)
		{
			return;
		}

		session_start();

		$this->GetSession(session_id());

		if ($this->sessionId)
		{
			return;
		}

		$this->sessionId = session_id();

		$sql = sprintf("INSERT IGNORE INTO session (sessionId) VALUES ('%s')", $this->sessionId);

		$sessDbase = new Database();

		$sessDbase->ExecSql($sql);
		
		$sessDbase->Disconnect();
	}

	public function SetSessionVariable($var, $val)
	{
		if ($var == "newSession")
		{
			$this->DestroySession($this->sessionId);

			return;
		}

		$val = addslashes($val);

		$sql = sprintf("UPDATE session SET %s='%s',ts=NOW() WHERE sessionId='%s'", $var, $val, $this->sessionId);

		if ($val == null)
		{
			$sql = sprintf("UPDATE session SET %s='',ts=NOW() WHERE sessionId='%s'", $var, $this->sessionId);
		}

		$sessDbase = new Database();

		$sessDbase->ExecSql($sql);
		
		$sessDbase->Disconnect();

		$this->GetSession($this->sessionId);
	}

	public function GetSession($s)
	{
		$sql = sprintf("SELECT * FROM session WHERE sessionId='%s'", $s);

		$sessDbase = new Database();
		
		$sessDbase->ExecSql($sql);

		if ($sessDbase->GetRowCount() > 0)
		{
			$row = $sessDbase->FetchRow();

			$this->GetRow($row);
		}

		$sessDbase->Disconnect();
	}

	public function GetRow($row)
	{
		$this->sessionId = $row["sessionId"];
		$this->ts = $row["ts"];
		$this->loggedOn = $row["loggedOn"];
		$this->hostname = $row["hostname"];
		$this->currPage = $row["currPage"];
		$this->docName = $row["docName"];
		$this->pilotId = $row["pilotId"];
		$this->waypoints = $row["waypoints"];
		$this->speed = $row["speed"];
		$this->weather = $row["weather"];
		$this->winds = $row["winds"];
		$this->alternate1 = $row["alternate1"];
		$this->alternate2 = $row["alternate2"];
		$this->alternate3 = $row["alternate3"];
		$this->altitude = $row["altitude"];
		$this->planType = $row["planType"];
		$this->comms = $row["comms"];
		$this->remarks = $row["remarks"];
		$this->rnav = $row["rnav"];
		$this->registration = $row["registration"];
		$this->airport = $row["airport"];
		$this->airportName = $row["airportName"];
		$this->cityState = $row["cityState"];
		$this->station = $row["station"];
		$this->fix = $row["fix"];
		$this->navaid = $row["navaid"];
		$this->tower = $row["tower"];
		$this->airway = $row["airway"];
		$this->shortName = $row["shortName"];
		$this->ident = $row["ident"];
		$this->transition = $row["transition"];
		$this->computerCode = $row["computerCode"];
		$this->depart = $row["depart"];
		$this->arrive = $row["arrive"];
		$this->dp = $row["dp"];
		$this->star = $row["star"];
		$this->starDpFacilityId = $row["starDpFacilityId"];
		$this->origin = $row["origin"];
		$this->destination = $row["destination"];
		$this->cifpFacilityId = $row["cifpFacilityId"];
		$this->siapId = $row["siapId"];
		$this->cifptransition = $row["cifptransition"];
		$this->pilotIdSignUp = $row["pilotIdSignUp"];
		$this->password = $row["password"];
		$this->retypePassword = $row["retypePassword"];
		$this->currentEmail = $row["currentEmail"];
		$this->email = $row["email"];
		$this->retypeEmail = $row["retypeEmail"];
		$this->firstName = $row["firstName"];
		$this->lastName = $row["lastName"];
		$this->homeBase = $row["homeBase"];
		$this->showHeliport = $row["showHeliport"];
		$this->showFrequency = $row["showFrequency"];
		$this->mapCenter = $row["mapCenter"];
		$this->mapZoom = $row["mapZoom"];
		$this->mapToggles = $row["mapToggles"];
		$this->mapList = $row["mapList"];
		$this->mapBounds = $row["mapBounds"];
		$this->mapAirports = $row["mapAirports"];
		$this->mapNavaids = $row["mapNavaids"];
		$this->mapFixs = $row["mapFixs"];
		$this->mapObstacles = $row["mapObstacles"];
		$this->mapParachutes = $row["mapParachutes"];
		$this->mapMaas = $row["mapMaas"];
		$this->mapMetars = $row["mapMetars"];
		$this->mapWeather = $row["mapWeather"];
		$this->mapConvective = $row["mapConvective"];
		$this->mapTurbulence = $row["mapTurbulence"];
		$this->mapIcing = $row["mapIcing"];
		$this->mapIFR = $row["mapIFR"];
		$this->mapMtnObscn = $row["mapMtnObscn"];
		$this->mapAsh = $row["mapAsh"];
		$this->mapGIFR = $row["mapGIFR"];
		$this->mapGMtnObscn = $row["mapGMtnObscn"];
		$this->mapGTurbHi = $row["mapGTurbHi"];
		$this->mapGTurbLo = $row["mapGTurbLo"];
		$this->mapGIce = $row["mapGIce"];
		$this->mapGFZLVL = $row["mapGFZLVL"];
		$this->mapGMFZLVL = $row["mapGMFZLVL"];
		$this->mapGSfcWind = $row["mapGSfcWind"];
		$this->mapGLLWS = $row["mapGLLWS"];
		$this->mapPIREPs = $row["mapPIREPs"];
		$this->mapRamps = $row["mapRamps"];
		$this->pdfIdent = $row["pdfIdent"];
		$this->designator = $row["designator"];
		$this->saaName = $row["saaName"];
	}

	public function DestroySession($s)
	{
		$sql = sprintf("DELETE FROM session WHERE sessionId='%s'", $s);

		$sessDbase = new Database();

		$sessDbase->ExecSql($sql);
		
		$sessDbase->Disconnect();

		session_regenerate_id(true);

		$this->sessionId = session_id();

		$this->ts = null;
		$this->loggedOn = null;
		$this->hostname = null;
		$this->currPage = null;
		$this->docName = null;
		$this->pilotId = null;
		$this->waypoints = null;
		$this->speed = 120;
		$this->winds = null;
		$this->alternate1 = null;
		$this->alternate2 = null;
		$this->alternate3 = null;
		$this->altitude = null;
		$this->planType = null;
		$this->comms = null;
		$this->remarks = null;
		$this->rnav = null;
		$this->registration = null;
		$this->pilotIdSignUp = null;
		$this->password = null;
		$this->retypePassword = null;
		$this->currentEmail = null;
		$this->email = null;
		$this->retypeEmail = null;
		$this->firstName = null;
		$this->lastName = null;
		$this->homeBase = null;
		$this->showHeliport = null;
		$this->showFrequency = null;
		$this->weather = null;
		$this->airport = null;
		$this->airportName = null;
		$this->cityState = null;
		$this->station = null;
		$this->fix = null;
		$this->navaid = null;
		$this->tower = null;
		$this->airway = null;
		$this->shortName = null;
		$this->ident = null;
		$this->transition = null;
		$this->computerCode = null;
		$this->depart = null;
		$this->arrive = null;
		$this->dp = null;
		$this->star = null;
		$this->starDpFacilityId = null;
		$this->origin = null;
		$this->destination = null;
		$this->cifpFacilityId = null;
		$this->siapId = null;
		$this->cifptransition = null;
		$this->mapCenter = "40.63992575,-73.778694972222";
		$this->mapZoom = 10;
		$this->mapToggles = null;
		$this->mapList = null;
		$this->mapBounds = null;
		$this->mapAirports = null;
		$this->mapNavaids = null;
		$this->mapObstacles = null;
		$this->mapFixs = null;
		$this->mapParachute = null;
		$this->mapMaa = null;
		$this->mapMetars = null;
		$this->mapWeather = null;
		$this->mapConvective = null;
		$this->mapTurbulence = null;
		$this->mapIcing = null;
		$this->mapIFR = null;
		$this->mapMtnObscn = null;
		$this->mapAsh = null;
		$this->mapGIFR = null;
		$this->mapGMtnObscn = null;
		$this->mapGTurbHi = null;
		$this->mapGTurbLo = null;
		$this->mapGIce = null;
		$this->mapGFZLVL = null;
		$this->mapGMFZLVL = null;
		$this->mapGSfcWind = null;
		$this->mapGLLWS = null;
		$this->mapPIREP = null;
		$this->mapRamps = null;
		$this->pdfIdent = null;
		$this->designator = null;
		$this->saaName = null;
	}

	public function FormatXML()
	{
		$str  = sprintf("<ts>%s</ts>", $this->ts);
		$str .= sprintf("<loggedOn>%s</loggedOn>", $this->loggedOn);
		$str .= sprintf("<hostname>%s</hostname>", $this->hostname);
		$str .= sprintf("<currPage>%s</currPage>", $this->currPage);
		$str .= sprintf("<docName>%s</docName>", $this->docName);
		$str .= sprintf("<pilotId>%s</pilotId>", $this->pilotId);
		$str .= sprintf("<waypoints>%s</waypoints>", $this->waypoints);
		$str .= sprintf("<speed>%s</speed>", $this->speed);
		$str .= sprintf("<winds>%s</winds>", $this->winds);
		$str .= sprintf("<alternate1>%s</alternate1>", $this->alternate1);
		$str .= sprintf("<alternate2>%s</alternate2>", $this->alternate2);
		$str .= sprintf("<alternate3>%s</alternate3>", $this->alternate3);
		$str .= sprintf("<altitude>%s</altitude>", $this->altitude);
		$str .= sprintf("<planType>%s</planType>", $this->planType);
		$str .= sprintf("<comms>%s</comms>", $this->comms);
		$str .= sprintf("<remarks>%s</remarks>", $this->remarks);
		$str .= sprintf("<rnav>%s</rnav>", $this->rnav);
		$str .= sprintf("<registration>%s</registration>", $this->registration);
		$str .= sprintf("<pilotIdSignUp>%s</pilotIdSignUp>", $this->pilotIdSignUp);
		$str .= sprintf("<password>%s</password>", $this->password);
		$str .= sprintf("<retypePassword>%s</retypePassword>", $this->retypePassword);
		$str .= sprintf("<currentEmail>%s</currentEmail>", $this->currentEmail);
		$str .= sprintf("<email>%s</email>", $this->email);
		$str .= sprintf("<retypeEmail>%s</retypeEmail>", $this->retypeEmail);
		$str .= sprintf("<firstName>%s</firstName>", $this->firstName);
		$str .= sprintf("<lastName>%s</lastName>", $this->lastName);
		$str .= sprintf("<homeBase>%s</homeBase>", $this->homeBase);
		$str .= sprintf("<showHeliport>%s</showHeliport>", $this->showHeliport);
		$str .= sprintf("<showFrequency>%s</showFrequency>", $this->showFrequency);
		$str .= sprintf("<weather>%s</weather>", $this->weather);
		$str .= sprintf("<airport>%s</airport>", $this->airport);
		$str .= sprintf("<airportName>%s</airportName>", $this->airportName);
		$str .= sprintf("<cityState>%s</cityState>", $this->cityState);
		$str .= sprintf("<station>%s</station>", $this->station);
		$str .= sprintf("<fix>%s</fix>", $this->fix);
		$str .= sprintf("<navaid>%s</navaid>", $this->navaid);
		$str .= sprintf("<tower>%s</tower>", $this->tower);
		$str .= sprintf("<airway>%s</airway>", $this->airway);
		$str .= sprintf("<shortName>%s</shortName>", $this->shortName);
		$str .= sprintf("<ident>%s</ident>", $this->ident);
		$str .= sprintf("<transition>%s</transition>", $this->transition);
		$str .= sprintf("<computerCode>%s</computerCode>", $this->computerCode);
		$str .= sprintf("<depart>%s</depart>", $this->depart);
		$str .= sprintf("<arrive>%s</arrive>", $this->arrive);
		$str .= sprintf("<dp>%s</dp>", $this->dp);
		$str .= sprintf("<star>%s</star>", $this->star);
		$str .= sprintf("<starDpFacilityId>%s</starDpFacilityId>", $this->starDpFacilityId);
		$str .= sprintf("<origin>%s</origin>", $this->origin);
		$str .= sprintf("<destination>%s</destination>", $this->destination);
		$str .= sprintf("<cifpFacilityId>%s</cifpFacilityId>", $this->cifpFacilityId);
		$str .= sprintf("<siapId>%s</siapId>", $this->siapId);
		$str .= sprintf("<cifptransition>%s</cifptransition>", $this->cifptransition);
		$str .= sprintf("<mapCenter>%s</mapCenter>", $this->mapCenter);
		$str .= sprintf("<mapZoom>%s</mapZoom>", $this->mapZoom);
		$str .= sprintf("<mapToggles>%s</mapToggles>", $this->mapToggles);
		$str .= sprintf("<mapList>%s</mapList>", $this->mapList);
		$str .= sprintf("<mapBounds>%s</mapBounds>", $this->mapBounds);
		$str .= sprintf("<mapAirports>%s</mapAirports>", $this->mapAirports);
		$str .= sprintf("<mapNavaids>%s</mapNavaids>", $this->mapNavaids);
		$str .= sprintf("<mapObstacles>%s</mapObstacles>", $this->mapObstacles);
		$str .= sprintf("<mapFixs>%s</mapFixs>", $this->mapFixs);
		$str .= sprintf("<mapParachute>%s</mapParachute>", $this->mapParachute);
		$str .= sprintf("<mapMaa>%s</mapMaa>", $this->mapMaa);
		$str .= sprintf("<mapMetars>%s</mapMetars>", $this->mapMetars);
		$str .= sprintf("<mapWeather>%s</mapWeather>", $this->mapWeather);
		$str .= sprintf("<mapConvective>%s</mapConvective>", $this->mapConvective);
		$str .= sprintf("<mapTurbulence>%s</mapTurbulence>", $this->mapTurbulence);
		$str .= sprintf("<mapIcing>%s</mapIcing>", $this->mapIcing);
		$str .= sprintf("<mapIFR>%s</mapIFR>", $this->mapIFR);
		$str .= sprintf("<mapMtnObscn>%s</mapMtnObscn>", $this->mapMtnObscn);
		$str .= sprintf("<mapAsh>%s</mapAsh>", $this->mapAsh);
		$str .= sprintf("<mapGIFR>%s</mapGIFR>", $this->mapGIFR);
		$str .= sprintf("<mapGMtnObscn>%s</mapGMtnObscn>", $this->mapGMtnObscn);
		$str .= sprintf("<mapGTurbHi>%s</mapGTurbHi>", $this->mapGTurbHi);
		$str .= sprintf("<mapGTurbLo>%s</mapGTurbLo>", $this->mapGTurbLo);
		$str .= sprintf("<mapGIce>%s</mapGIce>", $this->mapGIce);
		$str .= sprintf("<mapFZLVL>%s</mapFZLVL>", $this->mapFZLVL);
		$str .= sprintf("<mapMFZLVL>%s</mapMFZLVL>", $this->mapMFZLVL);
		$str .= sprintf("<mapGSfcWind>%s</mapGSfcWind>", $this->mapGSfcWind);
		$str .= sprintf("<mapLLWS>%s</mapLLWS>", $this->mapLLWS);
		$str .= sprintf("<mapPIREP>%s</mapPIREP>", $this->mapPIREP);
		$str .= sprintf("<mapRamps>%s</mapRamps>", $this->mapRamps);
		$str .= sprintf("<pdfIdent>%s</pdfIdent>", $this->pdfIdent);
		$str .= sprintf("<designator>%s</designator>", $this->designator);
		$str .= sprintf("<saaName>%s</saaName>", $this->saaName);

		return $str;
	}
	
	public function SessionPurge()
	{
		$date = date('Y-m-d H:i:s', (time() - 60 * 15));

		echo $date;

		$sql = sprintf("DELETE FROM session where ts<='%s';", $date);

		$sessDbase = new Database();

		$sessDbase->ExecSql($sql);

		$sessDbase->Disconnect();		
	}
}
?>