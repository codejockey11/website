<?php
require_once "../includes.php";

if (isset($_GET["mapToggles"]))
{
    $mapToggles = $_GET["mapToggles"];
}
else
{
    $mapToggles = $sess->mapToggles;
}

if (isset($_GET["mapCenter"]))
{
    $mapCenter = $_GET["mapCenter"];
}
else
{
    $mapCenter = $sess->mapCenter;
}

if (isset($_GET["mapZoom"]))
{
    $mapZoom = $_GET["mapZoom"];
}
else
{
    $mapZoom = $sess->mapZoom;
}

if (isset($_GET["mapBounds"]))
{
    $mapBounds = $_GET["mapBounds"];
}
else
{
    $mapBounds = $sess->mapBounds;
}

if (isset($_GET["waypoints"]))
{
    $waypoints = $_GET["waypoints"];
}
else
{
    $waypoints = $sess->waypoints;
}

if ($_POST)
{
    if (isset($_POST["APT"]))
    {
        $mapAirports = "1";
    }
    else
    {
        $mapAirports = null;
    }
}
else if (isset($_GET["mapAirports"]))
{
    $mapAirports = $_GET["mapAirports"];
}
else
{
    $mapAirports = $sess->mapAirports;
}

if ($_POST)
{
    if (isset($_POST["NAV"]))
    {
        $mapNavaids = "1";
    }
    else
    {
        $mapNavaids = null;
    }
}
else if (isset($_GET["mapNavaids"]))
{
    $mapNavaids = $_GET["mapNavaids"];
}
else
{
    $mapNavaids = $sess->mapNavaids;
}

if ($_POST)
{
    if (isset($_POST["FIX"]))
    {
        $mapFixs = "1";
    }
    else
    {
        $mapFixs = null;
    }
}
else if (isset($_GET["mapFixs"]))
{
    $mapFixs = $_GET["mapFixs"];
}
else
{
    $mapFixs = $sess->mapFixs;
}

if ($_POST)
{
    if (isset($_POST["MET"]))
    {
        $mapMetars = "1";
    }
    else
    {
        $mapMetars = null;
    }
}
else if (isset($_GET["mapMetars"]))
{
    $mapMetars = $_GET["mapMetars"];
}
else
{
    $mapMetars = $sess->mapMetars;
}

if ($_POST)
{
    if (isset($_POST["OBS"]))
    {
        $mapObstacles = "1";
    }
    else
    {
        $mapObstacles = null;
    }
}
else if (isset($_GET["mapObstacles"]))
{
    $mapObstacles = $_GET["mapObstacles"];
}
else
{
    $mapObstacles = $sess->mapObstacles;
}

if ($_POST)
{
    if (isset($_POST["PJA"]))
    {
        $mapParachutes = "1";
    }
    else
    {
        $mapParachutes = null;
    }
}
else if (isset($_GET["mapParachutes"]))
{
    $mapParachutes = $_GET["mapParachutes"];
}
else
{
    $mapParachutes = $sess->mapParachutes;
}

if ($_POST)
{
    if (isset($_POST["MAA"]))
    {
        $mapMaas = "1";
    }
    else
    {
        $mapMaas = null;
    }
}
else if (isset($_GET["mapMaas"]))
{
    $mapMaas = $_GET["mapMaas"];
}
else
{
    $mapMaas = $sess->mapMaas;
}

if ($_POST)
{
    if (isset($_POST["CONVECTIVE"]))
    {
        $mapConvective = "1";
    }
    else
    {
        $mapConvective = null;
    }
}
else if (isset($_GET["mapConvective"]))
{
    $mapConvective = $_GET["mapConvective"];
}
else
{
    $mapConvective = $sess->mapConvective;
}

if ($_POST)
{
    if (isset($_POST["TURB"]))
    {
        $mapTurbulence = "1";
    }
    else
    {
        $mapTurbulence = null;
    }
}
else if (isset($_GET["mapTurbulence"]))
{
    $mapTurbulence = $_GET["mapTurbulence"];
}
else
{
    $mapTurbulence = $sess->mapTurbulence;
}

if ($_POST)
{
    if (isset($_POST["ICE"]))
    {
        $mapIcing = "1";
    }
    else
    {
        $mapIcing = null;
    }
}
else if (isset($_GET["mapIcing"]))
{
    $mapIcing = $_GET["mapIcing"];
}
else
{
    $mapIcing = $sess->mapIcing;
}

if ($_POST)
{
    if (isset($_POST["IFR"]))
    {
        $mapIFR = "1";
    }
    else
    {
        $mapIFR = null;
    }
}
else if (isset($_GET["mapIFR"]))
{
    $mapIFR = $_GET["mapIFR"];
}
else
{
    $mapIFR = $sess->mapIFR;
}

if ($_POST)
{
    if (isset($_POST["MTNOBSCN"]))
    {
        $mapMtnObscn = "1";
    }
    else
    {
        $mapMtnObscn = null;
    }
}
else if (isset($_GET["mapMtnObscn"]))
{
    $mapMtnObscn = $_GET["mapMtnObscn"];
}
else
{
    $mapMtnObscn = $sess->mapMtnObscn;
}

if ($_POST)
{
    if (isset($_POST["ASH"]))
    {
        $mapAsh = "1";
    }
    else
    {
        $mapAsh = null;
    }
}
else if (isset($_GET["mapAsh"]))
{
    $mapAsh = $_GET["mapAsh"];
}
else
{
    $mapAsh = $sess->mapAsh;
}

if ($_POST)
{
    if (isset($_POST["GIFR"]))
    {
        $mapGIFR = "1";
    }
    else
    {
        $mapGIFR = null;
    }
}
else if (isset($_GET["mapGIFR"]))
{
    $mapGIFR = $_GET["mapGIFR"];
}
else
{
    $mapGIFR = $sess->mapGIFR;
}

if ($_POST)
{
    if (isset($_POST["GMTNOBSCN"]))
    {
        $mapGMtnObscn = "1";
    }
    else
    {
        $mapGMtnObscn = null;
    }
}
else if (isset($_GET["mapGMtnObscn"]))
{
    $mapGMtnObscn = $_GET["mapGMtnObscn"];
}
else
{
    $mapGMtnObscn = $sess->mapGMtnObscn;
}

if ($_POST)
{
    if (isset($_POST["GTURBHI"]))
    {
        $mapGTurbHi = "1";
    }
    else
    {
        $mapGTurbHi = null;
    }
}
else if (isset($_GET["mapGTurbHi"]))
{
    $mapGTurbHi = $_GET["mapGTurbHi"];
}
else
{
    $mapGTurbHi = $sess->mapGTurbHi;
}

if ($_POST)
{
    if (isset($_POST["GTURBLO"]))
    {
        $mapGTurbLo = "1";
    }
    else
    {
        $mapGTurbLo = null;
    }
}
else if (isset($_GET["mapGTurbLo"]))
{
    $mapGTurbLo = $_GET["mapGTurbLo"];
}
else
{
    $mapGTurbLo = $sess->mapGTurbLo;
}

if ($_POST)
{
    if (isset($_POST["GICE"]))
    {
        $mapGIce = "1";
    }
    else
    {
        $mapGIce = null;
    }
}
else if (isset($_GET["mapGIce"]))
{
    $mapGIce = $_GET["mapGIce"];
}
else
{
    $mapGIce = $sess->mapGIce;
}

if ($_POST)
{
    if (isset($_POST["GFZLVL"]))
    {
        $mapGFZLVL = "1";
    }
    else
    {
        $mapGFZLVL = null;
    }
}
else if (isset($_GET["mapGFZLVL"]))
{
    $mapGFZLVL = $_GET["mapGFZLVL"];
}
else
{
    $mapGFZLVL = $sess->mapGFZLVL;
}

if ($_POST)
{
    if (isset($_POST["GMFZLVL"]))
    {
        $mapGMFZLVL = "1";
    }
    else
    {
        $mapGMFZLVL = null;
    }
}
else if (isset($_GET["mapGMFZLVL"]))
{
    $mapGMFZLVL = $_GET["mapGMFZLVL"];
}
else
{
    $mapGMFZLVL = $sess->mapGMFZLVL;
}

if ($_POST)
{
    if (isset($_POST["GSFCWND"]))
    {
        $mapGSfcWind = "1";
    }
    else
    {
        $mapGSfcWind = null;
    }
}
else if (isset($_GET["mapGSfcWind"]))
{
    $mapGSfcWind = $_GET["mapGSfcWind"];
}
else
{
    $mapGSfcWind = $sess->mapGSfcWind;
}

if ($_POST)
{
    if (isset($_POST["GLLWS"]))
    {
        $mapLLWS = "1";
    }
    else
    {
        $mapLLWS = null;
    }
}
else if (isset($_GET["mapGLLWS"]))
{
    $mapGLLWS = $_GET["mapGLLWS"];
}
else
{
    $mapGLLWS = $sess->mapGLLWS;
}

if ($_POST)
{
    if (isset($_POST["PIREP"]))
    {
        $mapPIREPs = "1";
    }
    else
    {
        $mapPIREPs = null;
    }
}
else if (isset($_GET["mapPIREPs"]))
{
    $mapPIREPs = $_GET["mapPIREPs"];
}
else
{
    $mapPIREPs = $sess->mapPIREPs;
}

if ($_POST)
{
    if (isset($_POST["Ramps"]))
    {
        $mapRamps = "1";
    }
    else
    {
        $mapRamps = null;
    }
}
else if (isset($_GET["mapRamps"]))
{
    $mapRamps = $_GET["mapRamps"];
}
else
{
    $mapRamps = $sess->mapRamps;
}

$sess->SetSessionVariable("mapToggles", $mapToggles);
$sess->SetSessionVariable("mapCenter", $mapCenter);
$sess->SetSessionVariable("mapZoom", $mapZoom);
$sess->SetSessionVariable("mapBounds", $mapBounds);
$sess->SetSessionVariable("waypoints", $waypoints);
$sess->SetSessionVariable("mapAirports", $mapAirports);
$sess->SetSessionVariable("mapNavaids", $mapNavaids);
$sess->SetSessionVariable("mapFixs", $mapFixs);
$sess->SetSessionVariable("mapMetars", $mapMetars);
$sess->SetSessionVariable("mapObstacles", $mapObstacles);
$sess->SetSessionVariable("mapParachutes", $mapParachutes);
$sess->SetSessionVariable("mapMaas", $mapMaas);
$sess->SetSessionVariable("mapConvective", $mapConvective);
$sess->SetSessionVariable("mapTurbulence", $mapTurbulence);
$sess->SetSessionVariable("mapIcing", $mapIcing);
$sess->SetSessionVariable("mapIFR", $mapIFR);
$sess->SetSessionVariable("mapMtnObscn", $mapMtnObscn);
$sess->SetSessionVariable("mapAsh", $mapAsh);
$sess->SetSessionVariable("mapGIFR", $mapGIFR);
$sess->SetSessionVariable("mapGMtnObscn", $mapGMtnObscn);
$sess->SetSessionVariable("mapGTurbHi", $mapGTurbHi);
$sess->SetSessionVariable("mapGTurbLo", $mapGTurbLo);
$sess->SetSessionVariable("mapGIce", $mapGIce);
$sess->SetSessionVariable("mapGFZLVL", $mapGFZLVL);
$sess->SetSessionVariable("mapGMFZLVL", $mapGMFZLVL);
$sess->SetSessionVariable("mapGSfcWind", $mapGSfcWind);
$sess->SetSessionVariable("mapGLLWS", $mapGLLWS);
$sess->SetSessionVariable("mapPIREPs", $mapPIREPs);
$sess->SetSessionVariable("mapRamps", $mapRamps);

$p = new Parameter('googleMap');

?>

<!DOCTYPE html>
<html>
<head>

<title>Google Map</title>
<meta charset="UTF-8">
<link rel="shortcut icon" href="../favicon.ico"/>
<link rel="stylesheet" href="../base.css?v=1"/>
<script type="text/javascript" src="../base.js?v=1"></script>
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=<?php echo $p->value1; ?>&v=3.46"></script>
<script type="text/javascript">
//==========================================================================================
// Objects
//==========================================================================================
class Marker
{
    marker = null;
    infoWindow = null;
    isOpen = false;
    location = null;
    map = null;

    constructor(map, label, lat, lon, color, icon, info)
    {
        this.map = map;

        this.location = new google.maps.LatLng(lat, lon);

        if (label.length == 0)
        {
            this.marker = new google.maps.Marker(
			{
				position: this.location,
				icon: { url: icon }
			});
        }
        else
        {
            this.marker = new google.maps.Marker(
			{
				position: this.location,
				icon: { url: icon, labelOrigin: new google.maps.Point(7, -7) },
				label: { text: label, fontSize: '12px', fontWeight: 'bold', fontFamily: 'Verdana', color: color }
			});
        }

        this.infoWindow = new google.maps.InfoWindow(
		{
			disableAutoPan: true,
			position: this.location,
			content: info
		});

        google.maps.event.addListener(this.marker, 'click', (function (a)
        {
            return function ()
            {
                if (a.isOpen == false)
                {
                    a.isOpen = true;

                    if (a.infoWindow.getContent() > '')
                    {
                        a.infoWindow.open(a.map, a.marker);
                    }

                }
                else
                {
                    a.isOpen = false;

                    a.infoWindow.close();
                }
            };
        })(this));

        google.maps.event.addListener(this.infoWindow, 'closeclick', (function (a)
        {
            return function ()
            {
                a.isOpen = false;

                a.infoWindow.close();
            };
        })(this));

        this.marker.setMap(this.map);
    }
}
//==========================================================================================
class Line
{
    points = [];
    edit = false;
    infoWindow = null;
    color = null;
    weight = null;
    line = null;
    map = null;
    isOpen = false;

    constructor(map, edit, color, weight, info)
    {
        this.points = [];

        this.map = map;
        this.edit = edit;
        this.color = color;
        this.weight = weight;

        this.infoWindow = new google.maps.InfoWindow(
		{
			disableAutoPan: true,
			pixelOffset: new google.maps.Size(0, -5),
			content: info
		});
    }

    AddPoint(name, lat, lon, info)
    {
        var location = new google.maps.LatLng(lat, lon);

        this.points.push(location);

        //var pointMarker = new Marker(this.map, name, lat, lon, black, info);
    }

    End()
    {
        this.line = new google.maps.Polyline({ path: this.points, editable: this.edit, strokeWeight: this.weight, strokeColor: this.color });

        this.line.setMap(this.map);

        google.maps.event.addListener(this.line, 'click', (function (a)
        {
            return function ()
            {
                if (a.isOpen == false)
                {
                    a.isOpen = true;

                    if (a.mousePosition != null)
                    {
                        a.infoWindow.setPosition(a.mousePosition);
                    }

                    if (a.infoWindow.getContent() > '')
                    {
                        a.infoWindow.open(a.map, a.line);
                    }
                }
                else
                {
                    a.isOpen = false;
                    a.infoWindow.close();
                }
            };
        })(this));

        google.maps.event.addListener(this.infoWindow, 'closeclick', (function (a)
        {
            return function ()
            {
                a.isOpen = false;

                a.infoWindow.close();
            };
        })(this));


        google.maps.event.addListener(this.line, 'dblclick', (function (mouseEvent)
		{
			if (mouseEvent.vertex != undefined)
			{
				DeleteWaypoint(mouseEvent.vertex);
			}
		}
        ));

        google.maps.event.addListener(this.line.getPath(), 'insert_at', (function (mouseEvent)
		{
			var p = this.getArray();

			GetRightClickFlightPlan(new google.maps.LatLng(p[mouseEvent].lat(), p[mouseEvent].lng()), mouseEvent);
		}
        ));
    }

    SetMousePosition(mp)
    {
        this.mousePosition = mp;
    }
}
//==========================================================================================
class MapOverlay
{
    overlay = null;
    isOpen = false;
    order = null;
    name = null;
    minZoom = null;
    maxZoom = null;
    opacity = null;

    constructor(map, name, order, minZoom, maxZoom, opacity, toggle)
    {
        this.map = map;
        this.name = name;
        this.order = order;
        this.minZoom = minZoom;
        this.maxZoom = maxZoom;
        this.opacity = opacity;

        this.overlay = new google.maps.ImageMapType(
		{
			getTileUrl: function (coord, zoom)
			{
				if ((zoom < minZoom) || (zoom > maxZoom))
				{
					return '../images/blank.png';
				}

				// Specific to gdal2tiles api
				var nc = GetNormalizedCoord(coord, zoom);

				var bound = Math.pow(2, zoom);

				var urla = name.split('~');

				var url = null;

				if (urla.length == 1)
				{
					// This url is for localhost 127.0.0.1
					url = urla[0] + '/' + zoom + '/' + nc.x + '/' + (bound - nc.y - 1) + '.png';
				}
				else
				{
					// This url is for openweathermap.org
					url = urla[0] + '/' + zoom + '/' + nc.x + '/' + nc.y + '.png' + urla[1];

					// This url is for tomorrow.io - url requests limited to 3/second so their Basic Map Tile Service fails
					//const TIMESTAMP = (new Date()).toISOString();
					//url = urla[0] + '/' + zoom + '/' + nc.x + '/' + nc.y + '/precipitationIntensity/' + TIMESTAMP + '.png' + urla[1];
				}

				return url;

			},
			tileSize: new google.maps.Size(256, 256),
			isPng: true,
			minZoom: this.minZoom,
			maxZoom: this.maxZoom,
			opacity: this.opacity,
			name: this.name
		});

        this.map.mapTypes.set(this.name, this.overlay);

        if (toggle == 1)
        {
            this.isOpen = true;

            this.map.overlayMapTypes.setAt(this.order, this.overlay);
        }
    }

    Toggle()
    {
        if (this.isOpen == false)
        {
            this.isOpen = true;

            this.map.overlayMapTypes.setAt(this.order, this.overlay);
        }
        else
        {
            this.isOpen = false;

            this.map.overlayMapTypes.setAt(this.order, null);
        }
    }
}
//==========================================================================================
class Circle
{
    circle = null;
    infoWindow = null;
    isOpen = false;
    location = null;
    map = null;
    radius = null;

    constructor(map, radius, lat, lon, color, info)
    {
        this.map = map;

        // radius to meters
        if (radius)
        {
            this.radius = radius * (5280 * 0.3048);
        }
        else
        {
            this.radius = (5280 * 0.3048);
        }

        this.location = new google.maps.LatLng(lat, lon);

        this.circle = new google.maps.Circle(
		{
			center: this.location,
			radius: parseFloat(this.radius),
			fillColor: color,
			fillOpacity: 0.3,
			strokeColor: blue,
			strokeWeight: 2
		});

        this.infoWindow = new google.maps.InfoWindow(
		{
			disableAutoPan: true,
			pixelOffset: new google.maps.Size(0, -5),
			position: this.location,
			content: info
		});

        google.maps.event.addListener(this.circle, 'click', (function (a)
        {
            return function ()
            {
                if (a.isOpen == false)
                {
                    a.isOpen = true;

                    a.circle.setOptions({ strokeColor: green });

                    if (a.infoWindow.getContent() > '')
                    {
                        a.infoWindow.open(a.map);
                    }

                }
                else
                {
                    a.isOpen = false;

                    a.circle.setOptions({ strokeColor: blue });

                    a.infoWindow.close();
                }
            };
        })(this));

        google.maps.event.addListener(this.infoWindow, 'closeclick', (function (a)
        {
            return function ()
            {
                a.isOpen = false;

                a.circle.setOptions({ strokeColor: blue });

                a.infoWindow.close();
            };
        })(this));

        this.circle.setMap(this.map);
    }
}
//==========================================================================================
class Polygon
{
    points = [];
    polygon = null;
    infoWindow = null;
    isOpen = false;
    map = null;
    color = null;
    location = null;
    mousePosition = null;

    constructor(map, color, info)
    {
        this.map = map;
        this.color = color;

        this.infoWindow = new google.maps.InfoWindow(
		{
			disableAutoPan: true,
			pixelOffset: new google.maps.Size(5, -5),
			content: info
		});

        google.maps.event.addListener(this.infoWindow, 'closeclick', (function (a)
        {
            return function ()
            {
                a.isOpen = false;

                a.polygon.setOptions({ strokeColor: darkBlue });

                a.infoWindow.close();
            };
        })(this));
    }

    AddPoint(lat, lon)
    {
        var location = new google.maps.LatLng(lat, lon);

        this.points.push(location);
    }

    End()
    {
        this.polygon = new google.maps.Polygon({ path: this.points, fillColor: this.color, fillOpacity: 0.50, strokeColor: darkBlue });

        google.maps.event.addListener(this.polygon, 'click', (function (a)
        {
            return function ()
            {
                if (a.isOpen == false)
                {
                    a.isOpen = true;

                    a.polygon.setOptions({ strokeColor: green });

                    if (a.mousePosition != null)
                    {
                        a.infoWindow.setPosition(a.mousePosition);
                    }

                    if (a.infoWindow.getContent() > '')
                    {
                        a.infoWindow.open(a.map);
                    }
                }
                else
                {
                    a.isOpen = false;

                    a.polygon.setOptions({ strokeColor: darkBlue });

                    a.infoWindow.close();
                }
            };
        })(this));

        this.polygon.setMap(this.map);
    }

    SetMousePosition(mp)
    {
        this.mousePosition = mp;
    }
}
//==========================================================================================
function GetNormalizedCoord(coord, z)
{
    var y = coord.y;
    var x = coord.x;

    // tile range in one direction range is dependent on zoom level
    // 0 = 1 tile, 1 = 2 tiles, 2 = 4 tiles, 3 = 8 tiles, etc
    var tileRange = 1 << z;

    // don't repeat across y-axis (vertically)
    if (y < 0 || y >= tileRange)
    {
        return null;
    }

    // repeat across x-axis
    if (x < 0 || x >= tileRange)
    {
        x = (x % tileRange + tileRange) % tileRange;
    }

    return { x: x, y: y };
}
//==========================================================================================
// Global Constants
//==========================================================================================
var	mapBoundsAtlanta = new google.maps.LatLngBounds(new google.maps.LatLng(31.8173312985, -89.244485633), new google.maps.LatLng(36.6214189037, -80.7460741073));
var	mapBoundsCharlotte = new google.maps.LatLngBounds(new google.maps.LatLng(31.5048443185, -82.8153979353), new google.maps.LatLng(36.2867440027, -74.8629300153));
var	mapBoundsCincinnati = new google.maps.LatLngBounds(new google.maps.LatLng(35.4966078214, -86.6129097796), new google.maps.LatLng(40.2937510959, -77.7121061676));
var	mapBoundsDetroit = new google.maps.LatLngBounds(new google.maps.LatLng(39.4769562893, -86.1377051125), new google.maps.LatLng(44.30265053, -76.6283988462));
var	mapBoundsHalifax = new google.maps.LatLngBounds(new google.maps.LatLng(43.493189, -70.063838), new google.maps.LatLng(48.293816, -60.621431));
var	mapBoundsJacksonville = new google.maps.LatLngBounds(new google.maps.LatLng(27.4854139629, -85.8837291729), new google.maps.LatLng(32.2769633543, -78.431497756));
var	mapBoundsMiami = new google.maps.LatLngBounds(new google.maps.LatLng(23.7911434249, -83.7779836069), new google.maps.LatLng(28.5491933258, -76.3325709268));
var	mapBoundsMontreal = new google.maps.LatLngBounds(new google.maps.LatLng(43.496616, -78.503078), new google.maps.LatLng(48.312844, -68.311892));
var	mapBoundsNewOrleans = new google.maps.LatLngBounds(new google.maps.LatLng(27.5019447612, -91.8917096581), new google.maps.LatLng(32.2681891857, -84.439785252));
var	mapBoundsNewYork = new google.maps.LatLngBounds(new google.maps.LatLng(39.4681606742, -78.1366566495), new google.maps.LatLng(44.2941606492, -68.6502464261));
var	mapBoundsWashington = new google.maps.LatLngBounds(new google.maps.LatLng(35.4979761291, -79.9482234066), new google.maps.LatLng(40.2792144852, -71.6510119584));

var APTMAPZOOM = 9;
var NAVMAPZOOM = 8;
var FIXMAPZOOM = 11;
var METMAPZOOM = 9;
var OBSMAPZOOM = 11;

// This is the map overlapping order for the sectionals
// Do not sort these
var HALIFAX = 0;
var MONTREAL = 1;
var NEWYORK = 2;
var DETROIT = 3;
var WASHINGTON = 4;
var CINCINNATI = 5;
var CHARLOTTE = 6;
var ATLANTA = 7;
var JACKSONVILLE = 8;
var NEWORLEANS = 9;
var MIAMI = 10;

var WEATHER = 11;

//==========================================================================================
// PHP Dynamic Variables
//==========================================================================================
<?php
$APTMAPZOOM = 9;
$NAVMAPZOOM = 8;
$FIXMAPZOOM = 11;
$METMAPZOOM = 9;
$OBSMAPZOOM = 11;

// This is the map overlapping order for the sectionals
// Do not sort these
$HALIFAX = 0;
$MONTREAL = 1;
$NEWYORK = 2;
$DETROIT = 3;
$WASHINGTON = 4;
$CINCINNATI = 5;
$CHARLOTTE = 6;
$ATLANTA = 7;
$JACKSONVILLE = 8;
$NEWORLEANS = 9;
$MIAMI = 10;

$WEATHER = 11;

printf("var sessionId = '%s';\r\n", $sess->sessionId);

if ($sess->mapToggles == "")
{
    printf("var mapToggles = ['0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0'];\r\n");
}
else
{
    $toggles = explode(",", $sess->mapToggles);

    printf("var mapToggles = [ '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s' ];\r\n", $toggles[0], $toggles[1], $toggles[2], $toggles[3], $toggles[4], $toggles[5], $toggles[6], $toggles[7], $toggles[8], $toggles[9], $toggles[10], $toggles[11]);
}

if ($sess->mapZoom == null)
{
    printf("var mapZoom = '10';\r\n");
}
else
{
    printf("var mapZoom = '%s';\r\n", $sess->mapZoom);
}

if ($sess->mapCenter == null)
{
    // New York, NY 40.63992575, -73.778694972222
    printf("var mapCenter = ['40.63992575', '-73.778694972222'];\r\n");
}
else
{
    $mc = explode(',', $sess->mapCenter);

    printf("var mapCenter = ['%s', '%s'];\r\n", $mc[0], $mc[1]);
}

if ($sess->mapBounds == null)
{
    printf("var mapBounds = '';\r\n");
}
else
{
    printf("var mapBounds = '%s';\r\n", $sess->mapBounds);
}

if ($sess->waypoints == null)
{
    printf("var waypoints = 'No Active Plan';\r\n");
}
else
{
    printf("var waypoints = '%s';\r\n", $sess->waypoints);
}

if ($sess->mapAirports == null)
{
    printf("var mapAirports = '';\r\n");
}
else
{
    printf("var mapAirports = '%s';\r\n", $sess->mapAirports);
}

if ($sess->mapNavaids == null)
{
    printf("var mapNavaids = '';\r\n");
}
else
{
    printf("var mapNavaids = '%s';\r\n", $sess->mapNavaids);
}

if ($sess->mapFixs == null)
{
    printf("var mapFixs = '';\r\n");
}
else
{
    printf("var mapFixs = '%s';\r\n", $sess->mapFixs);
}

if ($sess->mapMetars == null)
{
    printf("var mapMetars = '';\r\n");
}
else
{
    printf("var mapMetars = '%s';\r\n", $sess->mapMetars);
}

if ($sess->mapObstacles == null)
{
    printf("var mapObstacles = '';\r\n");
}
else
{
    printf("var mapObstacles = '%s';\r\n", $sess->mapObstacles);
}

if ($sess->mapParachutes == null)
{
    printf("var mapParachutes = '';\r\n");
}
else
{
    printf("var mapParachutes = '%s';\r\n", $sess->mapParachutes);
}

if ($sess->mapMaas == null)
{
    printf("var mapMaas = '';\r\n");
}
else
{
    printf("var mapMaas = '%s';\r\n", $sess->mapMaas);
}

if ($sess->mapConvective == null)
{
    printf("var mapConvective = '';\r\n");
}
else
{
    printf("var mapConvective = '%s';\r\n", $sess->mapConvective);
}

if ($sess->mapTurbulence == null)
{
    printf("var mapTurbulence = '';\r\n");
}
else
{
    printf("var mapTurbulence = '%s';\r\n", $sess->mapTurbulence);
}

if ($sess->mapIcing == null)
{
    printf("var mapIcing = '';\r\n");
}
else
{
    printf("var mapIcing = '%s';\r\n", $sess->mapIcing);
}

if ($sess->mapIFR == null)
{
    printf("var mapIFR = '';\r\n");
}
else
{
    printf("var mapIFR = '%s';\r\n", $sess->mapIFR);
}

if ($sess->mapMtnObscn == null)
{
    printf("var mapMtnObscn = '';\r\n");
}
else
{
    printf("var mapMtnObscn = '%s';\r\n", $sess->mapMtnObscn);
}

if ($sess->mapAsh == null)
{
    printf("var mapAsh = '';\r\n");
}
else
{
    printf("var mapAsh = '%s';\r\n", $sess->mapAsh);
}

if ($sess->mapGIFR == null)
{
    printf("var mapGIFR = '';\r\n");
}
else
{
    printf("var mapGIFR = '%s';\r\n", $sess->mapGIFR);
}

if ($sess->mapGMtnObscn == null)
{
    printf("var mapGMtnObscn = '';\r\n");
}
else
{
    printf("var mapGMtnObscn = '%s';\r\n", $sess->mapGMtnObscn);
}

if ($sess->mapGTurbHi == null)
{
    printf("var mapGTurbHi = '';\r\n");
}
else
{
    printf("var mapGTurbHi = '%s';\r\n", $sess->mapGTurbHi);
}

if ($sess->mapGTurbLo == null)
{
    printf("var mapGTurbLo = '';\r\n");
}
else
{
    printf("var mapGTurbLo = '%s';\r\n", $sess->mapGTurbLo);
}

if ($sess->mapGIce == null)
{
    printf("var mapGIce = '';\r\n");
}
else
{
    printf("var mapGIce = '%s';\r\n", $sess->mapGIce);
}

if ($sess->mapGFZLVL == null)
{
    printf("var mapGFZLVL = '';\r\n");
}
else
{
    printf("var mapGFZLVL = '%s';\r\n", $sess->mapGFZLVL);
}

if ($sess->mapGMFZLVL == null)
{
    printf("var mapGMFZLVL = '';\r\n");
}
else
{
    printf("var mapGMFZLVL = '%s';\r\n", $sess->mapGMFZLVL);
}

if ($sess->mapGSfcWind == null)
{
    printf("var mapGSfcWind = '';\r\n");
}
else
{
    printf("var mapGSfcWind = '%s';\r\n", $sess->mapGSfcWind);
}

if ($sess->mapGLLWS == null)
{
    printf("var mapGLLWS = '';\r\n");
}
else
{
    printf("var mapGLLWS = '%s';\r\n", $sess->mapGLLWS);
}

if ($sess->mapPIREPs == null)
{
    printf("var mapPIREPs = '';\r\n");
}
else
{
    printf("var mapPIREPs = '%s';\r\n", $sess->mapPIREPs);
}

if ($sess->mapRamps == null)
{
    printf("var mapRamps = '';\r\n");
}
else
{
    printf("var mapRamps = '%s';\r\n", $sess->mapRamps);
}
?>
//==========================================================================================
// Variables
//==========================================================================================
var map = null;

var rcInfoWindow = null;
var httpGetRightClick = null;

var mapOverlay = [];

var flightPath = null;
var flightPathMarkers = null;

var lineArray = [];
var polygonArray = [];
//==========================================================================================
function InitMap()
{
    map = new google.maps.Map(document.getElementById('map'),
        {
            mapTypeId: google.maps.MapTypeId.ROADMAP,
            scrollwheel : true,
            mapTypeControl : true,
            mapTypeControlOptions :
            {
                style: google.maps.MapTypeControlStyle.HORIZONTAL_BAR,
                position : google.maps.ControlPosition.TOP_RIGHT,
                mapTypeIds : [google.maps.MapTypeId.ROADMAP, google.maps.MapTypeId.SATELLITE]
            },
            streetViewControl : false,
            fullscreenControl : false,
            zoomControlOptions :
            {
                position: google.maps.ControlPosition.TOP_RIGHT
            },
            center : new google.maps.LatLng(parseFloat(mapCenter[0]), parseFloat(mapCenter[1])),
            zoom : parseInt(mapZoom)
        });

    google.maps.event.addListener(map, 'mousemove', SetMousePosition);
    google.maps.event.addListener(map, 'zoom_changed', SetDynamicZoomElements);
    google.maps.event.addListener(map, 'bounds_changed', SetDynamicBoundsElements);
    google.maps.event.addListener(map, 'rightclick', GetRightClick);

    SetDynamicZoomElements();

    mapOverlay[HALIFAX] = new MapOverlay(map, '../charts/halifaxVfr', HALIFAX, 7, 10, 1.0, mapToggles[HALIFAX]);
    mapOverlay[MONTREAL] = new MapOverlay(map, '../charts/montrealVfr', MONTREAL, 7, 10, 1.0, mapToggles[MONTREAL]);
    mapOverlay[NEWYORK] = new MapOverlay(map, '../charts/newYorkVfr', NEWYORK, 7, 10, 1.0, mapToggles[NEWYORK]);
    mapOverlay[DETROIT] = new MapOverlay(map, '../charts/detroitVfr', DETROIT, 7, 10, 1.0, mapToggles[DETROIT]);
    mapOverlay[WASHINGTON] = new MapOverlay(map, '../charts/washingtonVfr', WASHINGTON, 7, 10, 1.0, mapToggles[WASHINGTON]);
    mapOverlay[CINCINNATI] = new MapOverlay(map, '../charts/cincinnatiVfr', CINCINNATI, 7, 10, 1.0, mapToggles[CINCINNATI]);
    mapOverlay[CHARLOTTE] = new MapOverlay(map, '../charts/charlotteVfr', CHARLOTTE, 7, 10, 1.0, mapToggles[CHARLOTTE]);
    mapOverlay[ATLANTA] = new MapOverlay(map, '../charts/atlantaVfr', ATLANTA, 7, 10, 1.0, mapToggles[ATLANTA]);
    mapOverlay[JACKSONVILLE] = new MapOverlay(map, '../charts/jacksonvilleVfr', JACKSONVILLE, 7, 10, 1.0, mapToggles[JACKSONVILLE]);
    mapOverlay[NEWORLEANS] = new MapOverlay(map, '../charts/newOrleansVfr', NEWORLEANS, 7, 10, 1.0, mapToggles[NEWORLEANS]);
    mapOverlay[MIAMI] = new MapOverlay(map, '../charts/miamiVfr', MIAMI, 7, 10, 1.0, mapToggles[MIAMI]);

    //mapOverlay[WEATHER] = new MapOverlay(map, 'https://api.tomorrow.io/v4/map/tile~?apikey=SfLJckdaYI7XHKI5x31FWCXOZp1qoJNu', WEATHER, 4, 12, 1.0, mapToggles[WEATHER]);
    mapOverlay[WEATHER] = new MapOverlay(map, 'https://tile.openweathermap.org/map/precipitation~?appid=141671986be9544d529be902af436cb7', WEATHER, 1, 15, 1.0, mapToggles[WEATHER]);
    //mapOverlay[WEATHER] = new MapOverlay(map, '../charts/weather', WEATHER, 4, 9, 1.0, mapToggles[WEATHER]);

    <?php
    if ($sess->waypoints != null)
    {
        printf("    GetFlightPlan();\r\n");
    }

    if ($sess->mapBounds != null)
    {
        // mapBounds is stored as upper-left bottom-right
        $lookup = explode(",", $sess->mapBounds);

        $from = new LatLon($lookup[0], $lookup[1]);

        $to = new LatLon($lookup[2], $lookup[3]);
    }

    if (($mapAirports == "1") && ($sess->mapZoom >= $APTMAPZOOM))
    {
        $sql = sprintf("SELECT * FROM aptAirport USE INDEX(aptAirportLatLon, aptAirportFacilityId) WHERE latitude>='%s' AND latitude<='%s' AND longitude>='%s' AND longitude<='%s'", $to->formattedLat, $from->formattedLat, $to->formattedLon, $from->formattedLon);

        if ($sess->showHeliport)
        {
            $sql .= " AND type='HELIPORT'";
        }
        else
        {
            $sql .= " AND type!='HELIPORT'";
        }

        $apt = new Airport($sess, $sql);

        $str = $apt->MapMarkerGoogle();

        printf("%s\r\n", $str);
    }

    if (($mapNavaids == "1") && ($sess->mapZoom >= $NAVMAPZOOM))
    {
        $sql = sprintf("SELECT * FROM navNavaid WHERE latitude>='%s' AND latitude<='%s' AND longitude>='%s' AND longitude<='%s'", $to->formattedLat, $from->formattedLat, $to->formattedLon, $from->formattedLon);

        $nav = new Navaid($sess, $sql);

        $str = $nav->MapMarkerGoogle();

        printf("%s\r\n", $str);
    }

    if (($mapFixs == "1") && ($sess->mapZoom >= $FIXMAPZOOM))
    {
        $sql = sprintf("SELECT * FROM fixLocation WHERE latitude>='%s' AND latitude<='%s' AND longitude>='%s' AND longitude<='%s'", $to->formattedLat, $from->formattedLat, $to->formattedLon, $from->formattedLon);

        $fix = new Fix($sess, $sql);

        $str = $fix->MapMarkerGoogle();

        printf("%s\r\n", $str);
    }

    if (($mapMetars == "1") && ($sess->mapZoom >= $METMAPZOOM))
    {
        $metar = array();

        $station = array();

        $taf = array();

        $parms = new Parameter("metarsLatLon");

        $xml = $parms->value1;

        $xml .= "&minLat=".$to->decimalLat;
        $xml .= "&minLon=".$from->decimalLon;
        $xml .= "&maxLat=".$from->decimalLat;
        $xml .= "&maxLon=".$to->decimalLon;

        $sr = new SimpleRequest($xml);

        if ($sr->xml !== false)
        {
            foreach($sr->xml->data->METAR as $mtr)
            {
                $stn = trim($mtr->station_id);

                if (array_search($stn, $metar) === false)
                {
                    array_push($metar, $stn);

                    array_push($station, new Station($stn));

                    array_push($taf, new TAF($stn));
                }
            }
        }

        for ($s = 0; $s < count($station); $s++)
        {
            $stn = $station[$s]->GetSingle(0);

            $t = $taf[$s]->GetSingle(0);

            $str = $stn->FormatMarkerGoogle($t);

            printf("%s", $str);
        }

        printf("\r\n");
    }

    if (($mapObstacles == "1") && ($sess->mapZoom >= $OBSMAPZOOM))
    {
        $sql = sprintf("SELECT * FROM obstacle WHERE agl>='00100' AND latitude>='%s' AND latitude<='%s' AND longitude>='%s' AND longitude<='%s'", $to->formattedLat, $from->formattedLat, $to->formattedLon, $from->formattedLon);

        $obs = new Obstacle($sess, $sql);

        $str = $obs->MapMarkerGoogle();

        printf("%s\r\n", $str);
    }

    if ($mapParachutes == "1")
    {
        $sql = sprintf("SELECT * FROM pjaLocation WHERE latitude>='%s' AND latitude<='%s' AND longitude>='%s' AND longitude<='%s'", $to->formattedLat, $from->formattedLat, $to->formattedLon, $from->formattedLon);

        $pja = new PjaLocation($sess, $sql);

        $str = $pja->MapMarkerGoogle();

        printf("%s\r\n", $str);
    }

    if ($mapMaas == "1")
    {
        $sql = sprintf("SELECT * FROM maaBaseData WHERE latitude>='%s' AND latitude<='%s' AND longitude>='%s' AND longitude<='%s'", $to->formattedLat, $from->formattedLat, $to->formattedLon, $from->formattedLon);

        $maa = new MaaBaseData($sess, $sql);

        $str = $maa->MapMarkerGoogle();

        printf("%s\r\n", $str);
    }

    if (($mapConvective == "1") || ($mapTurbulence == "1") || ($mapIcing == "1") || ($mapIFR == "1") || ($mapMtnObscn == "1") || ($mapAsh == "1"))
    {
        $sig = new AirSigmet();
    }

    if ($mapConvective == "1")
    {
        $str = $sig->MapMarkerGoogle("CONVECTIVE");

        printf("%s", $str);
    }

    if ($mapTurbulence == "1")
    {
        $str = $sig->MapMarkerGoogle("TURB");

        printf("%s", $str);
    }

    if ($mapIcing == "1")
    {
        $str = $sig->MapMarkerGoogle("ICE");

        printf("%s", $str);
    }

    if ($mapIFR == "1")
    {
        $str = $sig->MapMarkerGoogle("IFR");

        printf("%s", $str);
    }

    if ($mapMtnObscn == "1")
    {
        $str = $sig->MapMarkerGoogle("MTNOBSCN");

        printf("%s", $str);
    }

    if ($mapAsh == "1")
    {
        $str = $sig->MapMarkerGoogle("ASH");

        printf("%s", $str);
    }

    if (($mapGIFR == "1") || ($mapGMtnObscn == "1") || ($mapGTurbHi == "1") || ($mapGTurbLo == "1") || ($mapGIce == "1") || ($mapGFZLVL == "1") || ($mapGMFZLVL == "1") || ($mapGSfcWind == "1") || ($mapGLLWS == "1"))
    {
        $gairmet = new GAirmet();
    }

    if ($mapGIFR == "1")
    {
        $str = $gairmet->MapMarkerGoogle("IFR");

        printf("%s", $str);
    }

    if ($mapGMtnObscn == "1")
    {
        $str = $gairmet->MapMarkerGoogle("MT_OBSC");

        printf("%s", $str);
    }

    if ($mapGTurbHi == "1")
    {
        $str = $gairmet->MapMarkerGoogle("TURB-HI");

        printf("%s", $str);
    }

    if ($mapGTurbLo == "1")
    {
        $str = $gairmet->MapMarkerGoogle("TURB-LO");

        printf("%s", $str);
    }

    if ($mapGIce == "1")
    {
        $str = $gairmet->MapMarkerGoogle("ICE");

        printf("%s", $str);
    }

    if ($mapGFZLVL == "1")
    {
        $str = $gairmet->MapMarkerGoogle("FZLVL");

        printf("%s", $str);
    }

    if ($mapGMFZLVL == "1")
    {
        $str = $gairmet->MapMarkerGoogle("M_FZLVL");

        printf("%s", $str);
    }

    if ($mapGSfcWind == "1")
    {
        $str = $gairmet->MapMarkerGoogle("SFC_WND");

        printf("%s", $str);
    }

    if ($mapGLLWS == "1")
    {
        $str = $gairmet->MapMarkerGoogle("LLWS");

        printf("%s", $str);
    }

    if ($mapPIREPs == "1")
    {
        $pirep = new Pirep($mapBounds);

        $str = $pirep->MapMarkerGoogle();

        printf("%s", $str);
    }

    if ($mapRamps == "1")
    {
        $sql = sprintf("SELECT * FROM ramps WHERE X<='%s' AND X>='%s' AND Y<='%s' AND Y>='%s'", $from->decimalLon, $to->decimalLon, $from->decimalLat, $to->decimalLat);

        $ramps = new Ramps($sess, $sql);

        $str = $ramps->MapMarkerGoogle();

        printf("%s", $str);
    }
    ?>
}
//==========================================================================================
function SetMousePosition(event)
{
    mousePosition = event.latLng;

    lineArray.forEach(SetArrayMousePosition);

    polygonArray.forEach(SetArrayMousePosition);
}
//==========================================================================================
function SetArrayMousePosition(value, index, array)
{
    array[index].SetMousePosition(mousePosition);
}
//==========================================================================================
function UpdatePlan()
{
    if (document.getElementById('waypoints').innerHTML != 'No Active Plan')
    {
        waypoints = document.getElementById('waypoints').innerHTML;
    }

    PostURL();
}
//==========================================================================================
function ClearPlan()
{
    document.getElementById('waypoints').innerHTML = 'No Active Plan';

    waypoints = '';

    SetSession('waypoints', waypoints);

    PostURL();
}
//==========================================================================================
function SetDynamicBoundsElements()
{
    RemoveElement('sectionals', 'atlanta');
    RemoveElement('sectionals', 'charlotte');
    RemoveElement('sectionals', 'cincinnati');
    RemoveElement('sectionals', 'detroit');
    RemoveElement('sectionals', 'halifax');
    RemoveElement('sectionals', 'jacksonville');
    RemoveElement('sectionals', 'miami');
    RemoveElement('sectionals', 'montreal');
    RemoveElement('sectionals', 'newOrleans');
    RemoveElement('sectionals', 'newYork');
    RemoveElement('sectionals', 'washington');

    SetBorderColor(document.getElementById('bweather'), mapToggles[WEATHER]);

    if ((mapZoom < 7) || (mapZoom > 10))
    {
        return;
    }

    var mb = map.getBounds();

    if (mb.intersects(mapBoundsAtlanta))
    {
        AddElement('sectionals', 'td', 'atlanta');

        AddButtonElement('atlanta', 'button', 'batlanta', 'Atlanta', ATLANTA);

        SetBorderColor(document.getElementById('batlanta'), mapToggles[ATLANTA]);
    }

    if (mb.intersects(mapBoundsCharlotte))
    {
        AddElement('sectionals', 'td', 'charlotte');

        AddButtonElement('charlotte', 'button', 'bcharlotte', 'Charlotte', CHARLOTTE);

        SetBorderColor(document.getElementById('bcharlotte'), mapToggles[CHARLOTTE]);
    }

    if (mb.intersects(mapBoundsCincinnati))
    {
        AddElement('sectionals', 'td', 'cincinnati');

        AddButtonElement('cincinnati', 'button', 'bcincinnati', 'Cincinnati', CINCINNATI);

        SetBorderColor(document.getElementById('bcincinnati'), mapToggles[CINCINNATI]);
    }

    if (mb.intersects(mapBoundsDetroit))
    {
        AddElement('sectionals', 'td', 'detroit');

        AddButtonElement('detroit', 'button', 'bdetroit', 'Detroit', DETROIT);

        SetBorderColor(document.getElementById('bdetroit'), mapToggles[DETROIT]);
    }

    if (mb.intersects(mapBoundsHalifax))
    {
        AddElement('sectionals', 'td', 'halifax');

        AddButtonElement('halifax', 'button', 'bhalifax', 'Halifax', HALIFAX);

        SetBorderColor(document.getElementById('bhalifax'), mapToggles[HALIFAX]);
    }

    if (mb.intersects(mapBoundsJacksonville))
    {
        AddElement('sectionals', 'td', 'jacksonville');

        AddButtonElement('jacksonville', 'button', 'bjacksonville', 'Jacksonville', JACKSONVILLE);

        SetBorderColor(document.getElementById('bjacksonville'), mapToggles[JACKSONVILLE]);
    }

    if (mb.intersects(mapBoundsMiami))
    {
        AddElement('sectionals', 'td', 'miami');

        AddButtonElement('miami', 'button', 'bmiami', 'Miami', MIAMI);

        SetBorderColor(document.getElementById('bmiami'), mapToggles[MIAMI]);
    }

    if (mb.intersects(mapBoundsMontreal))
    {
        AddElement('sectionals', 'td', 'montreal');

        AddButtonElement('montreal', 'button', 'bmontreal', 'Montreal', MONTREAL);

        SetBorderColor(document.getElementById('bmontreal'), mapToggles[MONTREAL]);
    }

    if (mb.intersects(mapBoundsNewOrleans))
    {
        AddElement('sectionals', 'td', 'newOrleans');

        AddButtonElement('newOrleans', 'button', 'bnewOrleans', 'NewOrleans', NEWORLEANS);

        SetBorderColor(document.getElementById('bnewOrleans'), mapToggles[NEWORLEANS]);
    }

    if (mb.intersects(mapBoundsNewYork))
    {
        AddElement('sectionals', 'td', 'newYork');

        AddButtonElement('newYork', 'button', 'bnewYork', 'NewYork', NEWYORK);

        SetBorderColor(document.getElementById('bnewYork'), mapToggles[NEWYORK]);
    }

    if (mb.intersects(mapBoundsWashington))
    {
        AddElement('sectionals', 'td', 'washington');

        AddButtonElement('washington', 'button', 'bwashington', 'Washington', WASHINGTON);

        SetBorderColor(document.getElementById('bwashington'), mapToggles[WASHINGTON]);
    }
}
//==========================================================================================
function SetBorderColor(e, t)
{
    if (t == 1)
    {
        // this will add a style attribute even though there is a style sheet
        e.style.borderColor = darkBlue;
    }
    else if (e.style != null)
    {
        // removing the style attribute doesn't affect the style sheet
        e.removeAttribute('style');
    }
}
//==========================================================================================
function SetDynamicZoomElements()
{
    mapZoom = map.getZoom();

    document.getElementById('labelForAirports').removeAttribute('style');
    document.getElementById('labelForNavaids').removeAttribute('style');
    document.getElementById('labelForFixs').removeAttribute('style');
    document.getElementById('labelForMETARS').removeAttribute('style');
    document.getElementById('labelForObstacles').removeAttribute('style');

    if (mapZoom >= APTMAPZOOM)
    {
        document.getElementById('labelForAirports').style.backgroundColor = 'White';
        document.getElementById('labelForAirports').style.borderColor = 'rgb(211, 211, 211)';
        document.getElementById('labelForAirports').style.borderRadius = '3px';
        document.getElementById('labelForAirports').style.borderStyle = 'solid';
        document.getElementById('labelForAirports').style.borderWidth = 'thin';
    }

    if (mapZoom >= NAVMAPZOOM)
    {
        document.getElementById('labelForNavaids').style.backgroundColor = 'White';
        document.getElementById('labelForNavaids').style.borderColor = 'rgb(211, 211, 211)';
        document.getElementById('labelForNavaids').style.borderRadius = '3px';
        document.getElementById('labelForNavaids').style.borderStyle = 'solid';
        document.getElementById('labelForNavaids').style.borderWidth = 'thin';
    }

    if (mapZoom >= FIXMAPZOOM)
    {
        document.getElementById('labelForFixs').style.backgroundColor = 'White';
        document.getElementById('labelForFixs').style.borderColor = 'rgb(211, 211, 211)';
        document.getElementById('labelForFixs').style.borderRadius = '3px';
        document.getElementById('labelForFixs').style.borderStyle = 'solid';
        document.getElementById('labelForFixs').style.borderWidth = 'thin';
    }

    if (mapZoom >= METMAPZOOM)
    {
        document.getElementById('labelForMETARS').style.backgroundColor = 'White';
        document.getElementById('labelForMETARS').style.borderColor = 'rgb(211, 211, 211)';
        document.getElementById('labelForMETARS').style.borderRadius = '3px';
        document.getElementById('labelForMETARS').style.borderStyle = 'solid';
        document.getElementById('labelForMETARS').style.borderWidth = 'thin';
    }

    if (mapZoom >= OBSMAPZOOM)
    {
        document.getElementById('labelForObstacles').style.backgroundColor = 'White';
        document.getElementById('labelForObstacles').style.borderColor = 'rgb(211, 211, 211)';
        document.getElementById('labelForObstacles').style.borderRadius = '3px';
        document.getElementById('labelForObstacles').style.borderStyle = 'solid';
        document.getElementById('labelForObstacles').style.borderWidth = 'thin';
    }
}
//==========================================================================================
function HandleGetRightClick()
{
    if (httpGetRightClick.readyState == 4 && httpGetRightClick.status == 200)
    {
        var parser = new DOMParser();

        var xmlDoc = parser.parseFromString(httpGetRightClick.responseText, 'text/xml');

        var location = xmlDoc.getElementsByTagName('location')[0].textContent.split(',');

        var loc = new google.maps.LatLng(location[0], location[1]);

        var infoWindow = '<div class="infoboxRightClick">';

        var apt = xmlDoc.getElementsByTagName('apt');

        for (var i = 0; i < apt.length; i++)
        {
            var key = apt[i].getElementsByTagName('key')[0].textContent;
            var icao = apt[i].getElementsByTagName('icao')[0].textContent;
            var ident = apt[i].getElementsByTagName('ident')[0].textContent;
            var name = apt[i].getElementsByTagName('name')[0].textContent;
            var icon = apt[i].getElementsByTagName('icon')[0].textContent;

            infoWindow += '<img onclick="AppendWaypoint(\'A;' + icao + '\')" onmouseover="SetImage(this, \'../images/add.png\')" onmouseout="SetImage(this, \'' + icon + '\')' +
                '" src="' + icon + '" height="10" width="10"/>' +
                ' <a href="../airport/index.php?id=' + sessionId + '&key=' + key + '">' + icao + '</a> ' +
                name + '<br/>';
        }

        var nav = xmlDoc.getElementsByTagName('nav');

        for (var i = 0; i < nav.length; i++)
        {
            var key = nav[i].getElementsByTagName('key')[0].textContent;
            var facilityId = nav[i].getElementsByTagName('facilityId')[0].textContent;
            var name = nav[i].getElementsByTagName('name')[0].textContent;
            var region = nav[i].getElementsByTagName('region')[0].textContent;
            var type = nav[i].getElementsByTagName('type')[0].textContent;
            var freq = nav[i].getElementsByTagName('freq')[0].textContent;
            var icon = nav[i].getElementsByTagName('icon')[0].textContent;

            infoWindow += '<img onclick="AppendWaypoint(\'N;' + facilityId + '\')" onmouseover="SetImage(this, \'../images/add.png\');" onmouseout="SetImage(this, \'' + icon + '\')' +
                '" src="' + icon + '" height="10" width="10"/>' +
                ' <a href="../navaid/index.php?id=' + sessionId + '&key=' + key + '">' + facilityId + '</a> ';

            infoWindow += name + ' ' + type + ' ' + freq + '<br/>';
        }

        var fix = xmlDoc.getElementsByTagName('fix');

        for (var i = 0; i < fix.length; i++)
        {
            var key = fix[i].getElementsByTagName('key')[0].textContent;
            var fixId = fix[i].getElementsByTagName('fixId')[0].textContent;
            var usage = fix[i].getElementsByTagName('usage')[0].textContent;
            var region = fix[i].getElementsByTagName('region')[0].textContent;
            var state = fix[i].getElementsByTagName('state')[0].textContent;
            var category = fix[i].getElementsByTagName('category')[0].textContent;
            var icon = fix[i].getElementsByTagName('icon')[0].textContent;

            infoWindow += '<img onclick="AppendWaypoint(\'F;' + fixId + '\')" onmouseover="SetImage(this, \'../images/add.png\')" onmouseout="SetImage(this, \'' + icon + '\')' +
                '" src="' + icon + '" height="10" width="10"/>' +
                ' <a href="../fix/index.php?id=' + sessionId + '&key=' + key + '">' + fixId + '</a> ' + category + ' ' + usage + ' ' + region + '<br/>';
        }

        var gps = xmlDoc.getElementsByTagName('gps');

        for (var i = 0; i < gps.length; i++)
        {
            var icon = gps[i].getElementsByTagName('icon')[0].textContent;
            var lat = gps[i].getElementsByTagName('latitude')[0].textContent;
            var lon = gps[i].getElementsByTagName('longitude')[0].textContent;

            infoWindow += '<img onclick="AppendWaypoint(\'G;' + lat + ';' + lon + ';USRWP;0.0' + '\')" onmouseover="SetImage(this, \'../images/add.png\')" onmouseout="SetImage(this, \'' + icon + '\')' +
                '" src="' + icon + '" height="10" width="10"/> ' + lat + ';' + lon + ';USRWP;0.0';
        }

        infoWindow += '</div>';

        MakeRightClickInfoWindow(loc, infoWindow)
    }
}
//==========================================================================================
function GetRightClick(e)
{
    httpGetRightClick = new XMLHttpRequest();

    httpGetRightClick.onreadystatechange = HandleGetRightClick;

    httpGetRightClick.open('POST', '../xmlFormatters/getRightClick.php?q=' + e.latLng.lat() + ',' + e.latLng.lng());

    httpGetRightClick.send();
}
//==========================================================================================
function MakeRightClickInfoWindow(loc, infoWindow)
{
    if (rcInfoWindow == null)
    {
        rcInfoWindow = new google.maps.InfoWindow({ disableAutoPan:false });

        rcInfoWindow.setPosition(loc);

        rcInfoWindow.setContent(infoWindow);

        rcInfoWindow.open(map);

        google.maps.event.addListener(rcInfoWindow, 'closeclick', function()
        {
            rcInfoWindow.close();

            delete rcInfoWindow;

            rcInfoWindow = null;

            UpdatePlan();
        });

        return;
    }

    rcInfoWindow.setPosition(loc);

    rcInfoWindow.setHtmlContent(infoWindow);
}
//==========================================================================================
function AppendWaypoint(s)
{
    if (document.getElementById('waypoints').innerHTML == 'No Active Plan')
    {
        document.getElementById('waypoints').innerHTML = '';
    }

    document.getElementById('waypoints').innerHTML += ' ' + s;

    document.getElementById('waypoints').style.visibility = 'visible';
}
//==========================================================================================
function ToggleMapOverlay(nbr)
{
    mapOverlay[nbr].Toggle();

    if (mapOverlay[nbr].isOpen == true)
    {
        mapToggles[nbr] = 1;
    }
    else
    {
        mapToggles[nbr] = 0;
    }

    SetDynamicBoundsElements();

    SetSession('mapToggles', mapToggles);

    mapCenter = map.getCenter().lat().toFixed(6) + ',' + map.getCenter().lng().toFixed(6);
    mapZoom = map.getZoom();
    mapBounds = map.getBounds().getNorthEast().lat() + ',' + map.getBounds().getSouthWest().lng() + ',' + map.getBounds().getSouthWest().lat() + ',' + map.getBounds().getNorthEast().lng();

    SetSession('mapCenter', mapCenter);
    SetSession('mapZoom', mapZoom);
    SetSession('mapBounds', mapBounds);
}
//==========================================================================================
function SetSession(name, val)
{
    var httpSetSession = new XMLHttpRequest();

    httpSetSession.onreadystatechange = function()
    {
        if (httpSetSession.readyState == 4 && httpSetSession.status == 200)
        {
            //var parser = new DOMParser();

            //var xmlDoc = parser.parseFromString(httpSetSession.responseText, 'text/xml');

            //console.log(xmlDoc);
        }
    }

    httpSetSession.open('POST', '../xmlFormatters/setSession.php?q=' + name + '~' + val);

    httpSetSession.send();
}
//==========================================================================================
function GetMapItems()
{
    mapAirports = '';
    mapNavaids = '';
    mapFixs = '';
    mapMetars = '';
    mapObstacles = '';
    mapParachutes = '';
    mapMaas = '';
    mapConvective = '';
    mapTurbulence = '';
    mapIcing = '';
    mapIFR = '';
    mapMtnObscn = '';
    mapAsh = '';
    mapGIFR = '';
    mapGMtnObscn = '';
    mapGTurbHi = '';
    mapGTurbLo = '';
    mapGIce = '';
    mapGFZLVL = '';
    mapGMFZLVL = '';
    mapGSfcWind = '';
    mapGLLWS = '';
    mapPIREPs = '';
    mapRamps = '';

    if (document.getElementById('APT').checked === true)
    {
        mapAirports = 1;
    }

    if (document.getElementById('NAV').checked === true)
    {
        mapNavaids = 1;
    }

    if (document.getElementById('FIX').checked === true)
    {
        mapFixs = 1;
    }

    if (document.getElementById('MET').checked === true)
    {
        mapMetars = 1;
    }

    if (document.getElementById('OBS').checked === true)
    {
        mapObstacles = 1;
    }

    if (document.getElementById('PJA').checked === true)
    {
        mapParachutes = 1;
    }

    if (document.getElementById('MAA').checked === true)
    {
        mapMaas = 1;
    }

    if (document.getElementById('CONVECTIVE').checked === true)
    {
        mapConvective = 1;
    }

    if (document.getElementById('TURB').checked === true)
    {
        mapTurbulence = 1;
    }

    if (document.getElementById('ICE').checked === true)
    {
        mapIcing = 1;
    }

    if (document.getElementById('IFR').checked === true)
    {
        mapIFR = 1;
    }

    if (document.getElementById('MTNOBSCN').checked === true)
    {
        mapMtnObscn = 1;
    }

    if (document.getElementById('ASH').checked === true)
    {
        mapAsh = 1;
    }

    if (document.getElementById('GIFR').checked === true)
    {
        mapGIFR = 1;
    }

    if (document.getElementById('GMTOBSCN').checked === true)
    {
        mapGMtnObscn = 1;
    }

    if (document.getElementById('GTURBHI').checked === true)
    {
        mapGTurbHi = 1;
    }

    if (document.getElementById('GTURBLO').checked === true)
    {
        mapGTurbLo = 1;
    }

    if (document.getElementById('GICE').checked === true)
    {
        mapGIce = 1;
    }

    if (document.getElementById('GFZLVL').checked === true)
    {
        mapGFZLVL = 1;
    }

    if (document.getElementById('GMFZLVL').checked === true)
    {
        mapGMFZLVL = 1;
    }

    if (document.getElementById('GSFCWND').checked === true)
    {
        mapGSfcWind = 1;
    }

    if (document.getElementById('GLLWS').checked === true)
    {
        mapGLLWS = 1;
    }

    if (document.getElementById('PIREP').checked === true)
    {
        mapPIREPs = 1;
    }

    if (document.getElementById('Ramps').checked === true)
    {
        mapRamps = 1;
    }

    PostURL();
}
//==========================================================================================
function ClearSelections()
{
    var table = document.getElementById('mapNavbar');
    
    var td = table.querySelectorAll('tr > td > input');

    for (var i = 0; i < td.length; i++)
    {
        td[i].checked = false;
    }

    td = table.querySelectorAll('tr > td > img');

    for (var i = 0; i < td.length; i++)
    {
        td[i].src = checkboxUnchecked;
    }

    mapAirports = '';
    mapNavaids = '';
    mapFixs = '';
    mapMetars = '';
    mapObstacles = '';
    mapParachutes = '';
    mapMaas = '';
    mapConvective = '';
    mapTurbulence = '';
    mapIcing = '';
    mapIFR = '';
    mapMtnObscn = '';
    mapAsh = '';
    mapGIFR = '';
    mapGMtnObscn = '';
    mapGTurbHi = '';
    mapGTurbLo = '';
    mapGIce = '';
    mapGFZLVL = '';
    mapGMFZLVL = '';
    mapGSfcWind = '';
    mapGLLWS = '';
    mapPIREPs = '';
    mapRamps = '';

    PostURL();
}
//==========================================================================================
function PostURL()
{
    mapCenter = map.getCenter().lat().toFixed(6) + ',' + map.getCenter().lng().toFixed(6);

    mapBounds = map.getBounds().getNorthEast().lat() + ',' + map.getBounds().getSouthWest().lng() + ',' + map.getBounds().getSouthWest().lat() + ',' + map.getBounds().getNorthEast().lng();

    if (waypoints === 'No Active Plan')
    {
        waypoints = '';
    }

    window.location = '../googleMap/index.php?id=' + sessionId + '&mapToggles=' + mapToggles + '&mapCenter=' + mapCenter + '&mapZoom=' + mapZoom + '&mapBounds=' + mapBounds + '&mapAirports=' + mapAirports +
        '&mapNavaids=' + mapNavaids + '&mapFixs=' + mapFixs + '&mapMetars=' + mapMetars + '&mapObstacles=' + mapObstacles + '&mapParachutes=' + mapParachutes + '&mapMaas=' + mapMaas +
        '&mapConvective=' + mapConvective + '&mapTurbulence=' + mapTurbulence + '&mapIcing=' + mapIcing + '&mapIFR=' + mapIFR + '&mapMtnObscn=' + mapMtnObscn + '&mapAsh=' + mapAsh +
        '&mapGIFR=' + mapGIFR + '&mapGMtnObscn=' + mapGMtnObscn + '&mapGTurbHi=' + mapGTurbHi + '&mapGTurbLo=' + mapGTurbLo + '&mapGIce=' + mapGIce + '&mapGFZLVL=' + mapGFZLVL +
        '&mapGMFZLVL=' + mapGMFZLVL + '&mapGSfcWind=' + mapGSfcWind + '&mapGLLWS=' + mapGLLWS + '&mapPIREPs=' + mapPIREPs + '&mapRamps=' + mapRamps +
        '&waypoints=' + waypoints;
}
//==========================================================================================
function HandleGetFlightPlanRequest()
{
    if (httpGetFlightPlan.readyState == 4 && httpGetFlightPlan.status == 200)
    {
        var parser = new DOMParser();

        var xmlDoc = parser.parseFromString(httpGetFlightPlan.responseText, 'text/xml');

        var waypoint = xmlDoc.getElementsByTagName('waypoint');

        flightPath = new Line(map, true, pink, '2', '');

        flightPathMarkers = [];

        for (var i = 0; i < waypoint.length; i++)
        {
            var apt = waypoint[i].getElementsByTagName('apt');
            var fix = waypoint[i].getElementsByTagName('fix');
            var nav = waypoint[i].getElementsByTagName('nav');
            var gps = waypoint[i].getElementsByTagName('gps');

            if (apt[0] != undefined)
            {
                var key = apt[0].getElementsByTagName('key')[0].textContent;
                var ident = apt[0].getElementsByTagName('ident')[0].textContent;
                var icao = apt[0].getElementsByTagName('icao')[0].textContent;
                var name = apt[0].getElementsByTagName('name')[0].textContent;
                var icon = apt[0].getElementsByTagName('icon')[0].textContent;

                var lat = apt[0].getElementsByTagName('latitude')[0].textContent;
                var lon = apt[0].getElementsByTagName('longitude')[0].textContent;


                var infoWindow = '<div class="infoboxText">';

                infoWindow += '<img onclick="AppendWaypoint(\'A;' + icao + ';' + key + '\')" onmouseover="SetImage(this, \'../images/add.png\')" onmouseout="SetImage(this, \'' + icon + '\')' +
                    '" src="' + icon + '" height="10" width="10"/>' +
                    ' <a href="../airport/index.php?id=' + sessionId + '&key=' + key + '">' + icao + '</a> ' +
                    name;

                var rway = apt[0].getElementsByTagName('rway');

                for (var c = 0; c < rway.length; c++)
                {
                    infoWindow += '<br/>' + rway[c].textContent;
                }

                var cs = apt[0].getElementsByTagName('aptcs' + key);

                if (cs.length > 0)
                {
                    var pdf = cs[cs.length - 1].textContent;

                    infoWindow += '<br/><a href="../dTPPCS/index.php?id=' + sessionId + '&ident=' + ident + '&type=cs&pdf=' + pdf + '">Chart Supplement</a>';
                }

                var dtpp = apt[0].getElementsByTagName('dtpp');

                if (dtpp.length > 0)
                {
                    for (var c = 0; c < dtpp.length; c++)
                    {
                        var pdf = dtpp[c].textContent.split('~');

                        infoWindow += '<br/><a href="../dTPPCS/index.php?id=' + sessionId + '&ident=' + ident + '&type=dTPP&pdf=' + pdf[0] + '">' + pdf[1] + ':' + pdf[2] + '</a>';
                    }
                }

                infoWindow += '</div>';

                var airportMarker = new Marker(map, icao, lat, lon, black, icon, infoWindow);

                flightPathMarkers.push(airportMarker);

                flightPath.AddPoint('', lat, lon, '');
            }

            if (fix[0] != undefined)
            {
                var key = fix[0].getElementsByTagName('key')[0].textContent;
                var fixId = fix[0].getElementsByTagName('fixId')[0].textContent;
                var usage = fix[0].getElementsByTagName('usage')[0].textContent;
                var region = fix[0].getElementsByTagName('region')[0].textContent;
                var state = fix[0].getElementsByTagName('state')[0].textContent;
                var icon = fix[0].getElementsByTagName('icon')[0].textContent;

                var lat = fix[0].getElementsByTagName('latitude')[0].textContent;
                var lon = fix[0].getElementsByTagName('longitude')[0].textContent;

                var infoWindow = '<div class="infoboxText">';

                infoWindow += '<img onclick="AppendWaypoint(\'F;' + fixId + ';' + key + '\')" onmouseover="SetImage(this, \'../images/add.png\')" onmouseout="SetImage(this, \'' + icon + '\')' +
                    '" src="' + icon + '" height="10" width="10"/>' +
                    ' <a href="../fix/index.php?id=' + sessionId + '&key=' + key + '">' + fixId + '</a> ' + usage + ' ' + region + ' ' + state;

                var cs = fix[0].getElementsByTagName('fixcs' + key);

                if (cs.length > 0)
                {
                    var pdf = cs[cs.length - 1].textContent;

                    infoWindow += '<br/><a href="../dTPPCS/index.php?id=' + sessionId + '&ident=' + fixId + '&type=cs&pdf=' + pdf + '">Chart Supplement</a>';
                }

                var ilsMarker = fix[0].getElementsByTagName('marker');

                for (var c = 0; c < ilsMarker.length; c++)
                {
                    var key = ilsMarker[c].getElementsByTagName('key')[0].textContent;
                    var locationIdent = ilsMarker[c].getElementsByTagName('locationIdent')[0].textContent;
                    var type = ilsMarker[c].getElementsByTagName('type')[0].textContent;
                    var name = ilsMarker[c].getElementsByTagName('name')[0].textContent;
                    var morse = ilsMarker[c].getElementsByTagName('morse')[0].textContent;
                    var freq = ilsMarker[c].getElementsByTagName('freq')[0].textContent;
                    var status = ilsMarker[c].getElementsByTagName('status')[0].textContent;
                    var icon = ilsMarker[c].getElementsByTagName('icon')[0].textContent;

                    infoWindow += '<br/><img onclick="AppendWaypoint(\'N;' + locationIdent + ';' + key + '\')" onmouseover="SetImage(this, \'../images/add.png\');" onmouseout="SetImage(this, \'' + icon + '\')' +
                        '" src="' + icon + '" height="10" width="10"/>' +
                        ' <a href="../navaid/index.php?id=' + sessionId + '&key=' + key + '">' + locationIdent + '</a> ' + name + ' ' + type + '<br/>' + freq + ' ' + morse + '<br/>' + status;
                }

                var fixNavaid = fix[0].getElementsByTagName('fixNavaid');

                for (var ni = 0; ni < fixNavaid.length; ni++)
                {
                    var fixNavaidInfo = fixNavaid[ni].getElementsByTagName('fixNavaidInfo');
                    var navaidInfo = fixNavaid[ni].getElementsByTagName('navaidInfo');

                    for (var nii = 0; nii < fixNavaidInfo.length; nii++)
                    {
                        if (navaidInfo[nii] != undefined)
                        {
                            var key = navaidInfo[nii].getElementsByTagName('key')[0].textContent;
                            var facilityId = navaidInfo[nii].getElementsByTagName('facilityId')[0].textContent;
                            var type = navaidInfo[nii].getElementsByTagName('type')[0].textContent;
                            var name = navaidInfo[nii].getElementsByTagName('name')[0].textContent;
                            var morse = navaidInfo[nii].getElementsByTagName('morse')[0].textContent;
                            var status = navaidInfo[nii].getElementsByTagName('status')[0].textContent;
                            var freq = navaidInfo[nii].getElementsByTagName('freq')[0].textContent;

                            infoWindow += '<br/>' + fixNavaidInfo[nii].textContent;
                            infoWindow += '<br/><a href="../navaid/index.php?id=' + sessionId + '&key=' + key + '">' + facilityId + '</a> ' + name + ' ' + type + '<br/>' + freq + ' ' + morse + '<br/>' + status;
                        }
                    }
                }

                infoWindow += '</div>';

                var fixMarker = new Marker(map, fixId, lat, lon, black, icon, infoWindow);

                flightPathMarkers.push(fixMarker);

                flightPath.AddPoint('', lat, lon, '');
            }

            if (nav[0] != undefined)
            {
                var key = nav[0].getElementsByTagName('key')[0].textContent;
                var facilityId = nav[0].getElementsByTagName('facilityId')[0].textContent;
                var type = nav[0].getElementsByTagName('type')[0].textContent;
                var name = nav[0].getElementsByTagName('name')[0].textContent;
                var morse = nav[0].getElementsByTagName('morse')[0].textContent;
                var status = nav[0].getElementsByTagName('status')[0].textContent;
                var freq = nav[0].getElementsByTagName('freq')[0].textContent;
                var icon = nav[0].getElementsByTagName('icon')[0].textContent;
                var lat = nav[0].getElementsByTagName('latitude')[0].textContent;
                var lon = nav[0].getElementsByTagName('longitude')[0].textContent;

                var infoWindow = '<div class="infoboxText">';

                infoWindow += '<img onclick="AppendWaypoint(\'N;' + facilityId + ';' + key + '\')" onmouseover="SetImage(this, \'../images/add.png\');" onmouseout="SetImage(this, \'' + icon + '\')' +
                    '" src="' + icon + '" height="10" width="10"/>' +
                    ' <a href="../navaid/index.php?id=' + sessionId + '&key=' + key + '">' + facilityId + '</a> ' + freq + ' ' + morse + '<br/>' + status;

                var cs = nav[0].getElementsByTagName('navcs' + key);

                if (cs.length > 0)
                {
                    var pdf = cs[cs.length - 1].textContent;

                    infoWindow += '<br/><a href="../dTPPCS/index.php?id=' + sessionId + '&ident=' + name + '&type=cs&pdf=' + pdf + '">Chart Supplement</a>';
                }

                infoWindow += '</div>';

                var navaidMarker = new Marker(map, facilityId, lat, lon, black, icon, infoWindow);

                flightPathMarkers.push(navaidMarker);

                flightPath.AddPoint('', lat, lon, '');
            }

            if (gps[0] != undefined)
            {
                var type = gps[0].getElementsByTagName('type')[0].textContent;
                var name = gps[0].getElementsByTagName('name')[0].textContent;

                var freq = '';

                if (gps[0].getElementsByTagName('freq')[0] != undefined)
                {
                    freq = gps[0].getElementsByTagName('freq')[0].textContent;
                }

                var icon = gps[0].getElementsByTagName('icon')[0].textContent;
                var lat = gps[0].getElementsByTagName('latitude')[0].textContent;
                var lon = gps[0].getElementsByTagName('longitude')[0].textContent;

                var infoWindow = null;

                if (freq != '')
                {
                    infoWindow = '<div class="infoboxText">' + name + ' ' + freq + '<br/>' + lat + ',' + lon + '</div>';
                }
                else
                {
                    infoWindow = '<div class="infoboxText">' + name + '<br/>' + lat + ',' + lon + '</div>';
                }

                var gpsMarker = new Marker(map, name, lat, lon, black, icon, infoWindow);

                flightPathMarkers.push(gpsMarker);

                flightPath.AddPoint('', lat, lon, '');
            }
        }

        flightPath.End();

        var d = getDistanceFromLatLonInKm(flightPath.points[0].lat(), flightPath.points[0].lng(), flightPath.points[flightPath.points.length - 1].lat(), flightPath.points[flightPath.points.length - 1].lng());

        //km to mile
        d *= 0.621371;

        mapZoom = 2;

        if (d >= 600)
        {
            mapZoom = 3;
        }
        else if (d >= 500)
        {
            mapZoom = 4;
        }
        else if (d >= 400)
        {
            mapZoom = 5;
        }
        else if (d >= 300)
        {
            mapZoom = 6;
        }
        else if (d >= 200)
        {
            mapZoom = 7;
        }
        else if (d >= 100)
        {
            mapZoom = 8;
        }
        else
        {
            mapZoom = 9;
        }

        map.setZoom(mapZoom);

        var lat = (flightPath.points[0].lat() + flightPath.points[flightPath.points.length - 1].lat()) / 2;
        var lon = (flightPath.points[0].lng() + flightPath.points[flightPath.points.length - 1].lng()) / 2;

        mapCenter = lat + ',' + lon;

        map.setCenter({ lat:lat, lng : lon });
    }
}
//==========================================================================================
function GetFlightPlan()
{
    httpGetFlightPlan = new XMLHttpRequest();

    httpGetFlightPlan.onreadystatechange = HandleGetFlightPlanRequest;

    httpGetFlightPlan.open('POST', '../xmlFormatters/getFlightPlan.php');

    httpGetFlightPlan.send();
}
//==========================================================================================
function HandleGetRightClickFlightPlan()
{
    if (httpGetRightClick.readyState == 4 && httpGetRightClick.status == 200)
    {
        var parser = new DOMParser();

        var xmlDoc = parser.parseFromString(httpGetRightClick.responseText, 'text/xml');

        var index = xmlDoc.getElementsByTagName('index')[0].textContent;

        var location = xmlDoc.getElementsByTagName('location')[0].textContent.split(',');

        var location = new google.maps.LatLng(location[0], location[1]);

        var infoWindow = '<div class="infoboxRightClick">';

        var apt = xmlDoc.getElementsByTagName('apt');

        for (var i = 0; i < apt.length; i++)
        {
            var key = apt[i].getElementsByTagName('key')[0].textContent;
            var icao = apt[i].getElementsByTagName('icao')[0].textContent;
            var name = apt[i].getElementsByTagName('name')[0].textContent;
            var icon = apt[i].getElementsByTagName('icon')[0].textContent;

            infoWindow += '<img onclick="InsertWaypoint(\'A;' + icao + '\', ' + index + ')" onmouseover="SetImage(this, \'../images/add.png\')" onmouseout="SetImage(this, \'' + icon + '\')' +
                '" src="' + icon + '" height="10" width="10"/>' +
                ' <a href="../airport/index.php?id=' + sessionId + '&key=' + key + '">' + icao + '</a> ' +
                name + '<br/>';
        }

        var nav = xmlDoc.getElementsByTagName('nav');

        for (var i = 0; i < nav.length; i++)
        {
            var key = nav[i].getElementsByTagName('key')[0].textContent;
            var facilityId = nav[i].getElementsByTagName('facilityId')[0].textContent;
            var name = nav[i].getElementsByTagName('name')[0].textContent;
            var region = nav[i].getElementsByTagName('region')[0].textContent;
            var type = nav[i].getElementsByTagName('type')[0].textContent;
            var freq = nav[i].getElementsByTagName('freq')[0].textContent;
            var icon = nav[i].getElementsByTagName('icon')[0].textContent;

            infoWindow += '<img onclick="InsertWaypoint(\'N;' + facilityId + '\', ' + index + ')" onmouseover="SetImage(this, \'../images/add.png\');" onmouseout="SetImage(this, \'' + icon + '\')' +
                '" src="' + icon + '" height="10" width="10"/>' +
                ' <a href="../navaid/index.php?id=' + sessionId + '&key=' + key + '">' + facilityId + '</a> ';

            infoWindow += name + ' ' + type + ' ' + freq + '<br/>';
        }

        var fix = xmlDoc.getElementsByTagName('fix');

        for (var i = 0; i < fix.length; i++)
        {
            var key = fix[i].getElementsByTagName('key')[0].textContent;
            var fixId = fix[i].getElementsByTagName('fixId')[0].textContent;
            var usage = fix[i].getElementsByTagName('usage')[0].textContent;
            var region = fix[i].getElementsByTagName('region')[0].textContent;
            var state = fix[i].getElementsByTagName('state')[0].textContent;
            var category = fix[i].getElementsByTagName('category')[0].textContent;
            var icon = fix[i].getElementsByTagName('icon')[0].textContent;

            infoWindow += '<img onclick="InsertWaypoint(\'F;' + fixId + '\', ' + index + ')" onmouseover="SetImage(this, \'../images/add.png\')" onmouseout="SetImage(this, \'' + icon + '\')' +
                '" src="' + icon + '" height="10" width="10"/>' +
                ' <a href="../fix/index.php?id=' + sessionId + '&key=' + key + ',' + region + '">' + fixId + '</a> ' +
                category + ' ' + usage + ' ' + region + '<br/>';
        }

        var gps = xmlDoc.getElementsByTagName('gps');

        for (var i = 0; i < gps.length; i++)
        {
            var icon = gps[i].getElementsByTagName('icon')[0].textContent;
            var lat = gps[i].getElementsByTagName('latitude')[0].textContent;
            var lon = gps[i].getElementsByTagName('longitude')[0].textContent;

            infoWindow += '<img onclick="InsertWaypoint(\'G;' + lat + ';' + lon + ';USRWP;0.0' + '\', ' + index + ')" onmouseover="SetImage(this, \'../images/add.png\')" onmouseout="SetImage(this, \'' + icon + '\')' +
                '" src="' + icon + '" height="10" width="10"/> ' + lat + ';' + lon + ';USRWP;0.0';
        }

        infoWindow += '</div>';

        MakeRightClickInfoWindow(location, infoWindow);
    }
}
//==========================================================================================
function GetRightClickFlightPlan(location, i)
{
    httpGetRightClick = new XMLHttpRequest();

    httpGetRightClick.onreadystatechange = HandleGetRightClickFlightPlan;

    httpGetRightClick.open('POST', '../xmlFormatters/getRightClick.php?q=' + location.lat() + ',' + location.lng() + '&i=' + i);

    httpGetRightClick.send();
}
//==========================================================================================
function InsertWaypoint(p, w)
{
    var wps = document.getElementById('waypoints').innerHTML.split(' ');

    var ip = 0;

    for (var i = 0; i < wps.length; i++)
    {
        if (wps[i].match(flightPathMarkers[w].marker.label.text) != null)
        {
            ip = i;

            break;
        }
    }

    wps.splice(ip, 0, p);

    var wp = '';

    for (var i = 0; i < wps.length; i++)
    {
        wp += wps[i] + ' ';
    }

    waypoints = wp.trim();

    document.getElementById('waypoints').innerHTML = waypoints;

    SetSession('waypoints', waypoints);

    PostURL();
}
//==========================================================================================
function DeleteWaypoint(w)
{
    var wps = document.getElementById('waypoints').innerHTML.split(' ');

    var wp = '';

    for (var i = 0; i < wps.length; i++)
    {
        if (wps[i].match(flightPathMarkers[w].marker.label.text) == null)
        {
            wp += wps[i] + ' ';
        }
    }

    waypoints = wp.trim();

    document.getElementById('waypoints').innerHTML = waypoints;

    SetSession('waypoints', waypoints);

    PostURL();
}
//==========================================================================================
</script>
</head>

<body onload = "InitMap()">

<table class = "topPanel">
    <tr>
        <td><?php require_once "../navSignOn.php";?></td>
    </tr>
</table>

<table class = "pageResult">
    <tr>
        <td>
            <table>
                <tr id="sectionals">
                    <td id="updatePlan"><button id="bupdatePlan" class="smallButton" onclick="UpdatePlan()">UpdatePlan</button></td>
                    <td id="clearPlan"><button id="bclearPlan" class="smallButton" onclick="ClearPlan()">ClearPlan</button></td>
                    <td id="weather"><button id="bweather" class="smallButton" onclick="ToggleMapOverlay(<?php printf(" % s", $WEATHER)?>)">Weather</button></td>
                    <td id="atlanta"><button id="batlanta" class="smallButton" onclick="ToggleMapOverlay(<?php printf(" % s", $ATLANTA)?>)">Atlanta</button></td>
                    <td id="charlotte"><button id="bcharlotte" class="smallButton" onclick="ToggleMapOverlay(<?php printf(" % s", $CHARLOTTE)?>)">Charlotte</button></td>
                    <td id="cincinnati"><button id="bcincinnati" class="smallButton" onclick="ToggleMapOverlay(<?php printf(" % s", $CINCINNATI)?>)">Cincinnati</button></td>
                    <td id="detroit"><button id="bdetroit" class="smallButton" onclick="ToggleMapOverlay(<?php printf(" % s", $DETROIT)?>)">Detroit</button></td>
                    <td id="halifax"><button id="bhalifax" class="smallButton" onclick="ToggleMapOverlay(<?php printf(" % s", $HALIFAX)?>)">Halifax</button></td>
                    <td id="jacksonville"><button id="bjacksonville" class="smallButton" onclick="ToggleMapOverlay(<?php printf(" % s", $JACKSONVILLE)?>)">Jacksonville</button></td>
                    <td id="miami"><button id="bmiami" class="smallButton" onclick="ToggleMapOverlay(<?php printf(" % s", $MIAMI)?>)">Miami</button></td>
                    <td id="montreal"><button id="bmontreal" class="smallButton" onclick="ToggleMapOverlay(<?php printf(" % s", $MONTREAL)?>)">Montreal</button></td>
                    <td id="newOrleans"><button id="bnewOrleans" class="smallButton" onclick="ToggleMapOverlay(<?php printf(" % s", $NEWORLEANS)?>)">NewOrleans</button></td>
                    <td id="newYork"><button id="bnewYork" class="smallButton" onclick="ToggleMapOverlay(<?php printf(" % s", $NEWYORK)?>)">NewYork</button></td>
                    <td id="washington"><button id="bwashington" class="smallButton" onclick="ToggleMapOverlay(<?php printf(" % s", $WASHINGTON)?>)">Washington</button></td>
                </tr>
            </table>
        </td>
    </tr>

    <tr>
    <?php
        if ($sess->waypoints != null)
        {
            printf("<td id=\"waypoints\" class=\"leftLabel\" style=\"background-color:white;border:1px solid rgb(211, 211, 211);border-radius:3px;\">%s</td>\r\n", $sess->waypoints);
        }
        else
        {
            printf("<td id=\"waypoints\" class=\"leftLabel\" style=\"background-color:white;border:1px solid rgb(211, 211, 211);border-radius:3px;\">No Active Plan</td>\r\n");
        }
    ?>
    </tr>

    <tr>
        <td id="msg"></td>
    </tr>
</table>

<table class="mapGoogle">
    <tr>
        <td id="map" width="90%"></td>
        <td class="mapNavbar">
            <table id="mapNavbar">
                <?php
                printf("<tr><td class=\"checkbox\" style=\"padding-top:3px;text-align:right;\"><label for=\"imageAPT\" id=\"labelForAirports\">Airports</label>\r\n");

                if ($sess->mapAirports)
                {
                    printf("<input checked=\"checked\" type=\"checkbox\" name=\"APT\" value=\"APT\" id=\"APT\">\r\n");
                    printf("<img id=\"imageAPT\" src=\"../images/checkboxChecked.png\" onclick=\"CheckboxClicked('APT')\" />\r\n");
                }
                else
                {
                    printf("<input type=\"checkbox\" name=\"APT\" value=\"APT\" id=\"APT\">\r\n");
                    printf("<img id=\"imageAPT\" src=\"../images/checkboxUnchecked.png\" onclick=\"CheckboxClicked('APT')\" />\r\n");
                }

                printf("</td></tr>");


                printf("<tr><td class=\"checkbox\" style=\"padding-top:3px;text-align:right;\"><label for=\"imageNAV\" id=\"labelForNavaids\">Navaids</label>\r\n");

                if ($sess->mapNavaids)
                {
                    printf("<input checked=\"checked\" type=\"checkbox\" name=\"NAV\" value=\"NAV\" id=\"NAV\">\r\n");
                    printf("<img id=\"imageNAV\" src=\"../images/checkboxChecked.png\" onclick=\"CheckboxClicked('NAV')\" />\r\n");
                }
                else
                {
                    printf("<input type=\"checkbox\" name=\"NAV\" value=\"NAV\" id=\"NAV\">\r\n");
                    printf("<img id=\"imageNAV\" src=\"../images/checkboxUnchecked.png\" onclick=\"CheckboxClicked('NAV')\" />\r\n");
                }

                printf("</td></tr>");


                printf("<tr><td class=\"checkbox\" style=\"padding-top:3px;text-align:right;\"><label for=\"imageFIX\" id=\"labelForFixs\">Fixs</label>\r\n");

                if ($sess->mapFixs)
                {
                    printf("<input checked=\"checked\" type=\"checkbox\" name=\"FIX\" value=\"FIX\" id=\"FIX\">\r\n");
                    printf("<img id=\"imageFIX\" src=\"../images/checkboxChecked.png\" onclick=\"CheckboxClicked('FIX')\" />\r\n");
                }
                else
                {
                    printf("<input type=\"checkbox\" name=\"FIX\" value=\"FIX\" id=\"FIX\">\r\n");
                    printf("<img id=\"imageFIX\" src=\"../images/checkboxUnchecked.png\" onclick=\"CheckboxClicked('FIX')\" />\r\n");
                }

                printf("</td></tr>");


                printf("<tr><td class=\"checkbox\" style=\"padding-top:3px;text-align:right;\"><label for=\"imageMET\" id=\"labelForMETARS\">METARS</label>\r\n");

                if ($sess->mapMetars)
                {
                    printf("<input checked=\"checked\" type=\"checkbox\" name=\"MET\" value=\"MET\" id=\"MET\">\r\n");
                    printf("<img id=\"imageMET\" src=\"../images/checkboxChecked.png\" onclick=\"CheckboxClicked('MET')\" />\r\n");
                }
                else
                {
                    printf("<input type=\"checkbox\" name=\"MET\" value=\"MET\" id=\"MET\">\r\n");
                    printf("<img id=\"imageMET\" src=\"../images/checkboxUnchecked.png\" onclick=\"CheckboxClicked('MET')\" />\r\n");
                }

                printf("</td></tr>");


                printf("<tr><td class=\"checkbox\" style=\"padding-top:3px;text-align:right;\"><label for=\"imageOBS\" id=\"labelForObstacles\">Obstacles</label>\r\n");

                if ($sess->mapObstacles)
                {
                    printf("<input checked=\"checked\" type=\"checkbox\" name=\"OBS\" value=\"OBS\" id=\"OBS\">\r\n");
                    printf("<img id=\"imageOBS\" src=\"../images/checkboxChecked.png\" onclick=\"CheckboxClicked('OBS')\" />\r\n");
                }
                else
                {
                    printf("<input type=\"checkbox\" name=\"OBS\" value=\"OBS\" id=\"OBS\">\r\n");
                    printf("<img id=\"imageOBS\" src=\"../images/checkboxUnchecked.png\" onclick=\"CheckboxClicked('OBS')\" />\r\n");
                }

                printf("</td></tr>");


                printf("<tr><td class=\"checkbox\" style=\"padding-top:3px;text-align:right;\"><label for=\"imagePJA\" id=\"labelForParachute\">Parachutes</label>\r\n");

                if ($sess->mapParachutes)
                {
                    printf("<input checked=\"checked\" type=\"checkbox\" name=\"PJA\" value=\"PJA\" id=\"PJA\">\r\n");
                    printf("<img id=\"imagePJA\" src=\"../images/checkboxChecked.png\" onclick=\"CheckboxClicked('PJA')\" />\r\n");
                }
                else
                {
                    printf("<input type=\"checkbox\" name=\"PJA\" value=\"PJA\" id=\"PJA\">\r\n");
                    printf("<img id=\"imagePJA\" src=\"../images/checkboxUnchecked.png\" onclick=\"CheckboxClicked('PJA')\" />\r\n");
                }

                printf("</td></tr>");


                printf("<tr><td class=\"checkbox\" style=\"padding-top:3px;text-align:right;\"><label for=\"imageMAA\" id=\"labelForMAA\">MAAs</label>\r\n");

                if ($sess->mapMaas)
                {
                    printf("<input checked=\"checked\" type=\"checkbox\" name=\"MAA\" value=\"MAA\" id=\"MAA\">\r\n");
                    printf("<img id=\"imageMAA\" src=\"../images/checkboxChecked.png\" onclick=\"CheckboxClicked('MAA')\" />\r\n");
                }
                else
                {
                    printf("<input type=\"checkbox\" name=\"MAA\" value=\"MAA\" id=\"MAA\">\r\n");
                    printf("<img id=\"imageMAA\" src=\"../images/checkboxUnchecked.png\" onclick=\"CheckboxClicked('MAA')\" />\r\n");
                }

                printf("</td></tr>");

                printf("<tr><td class=\"centerLabel\">Sigmets</td></tr>\r\n");


                printf("<tr><td class=\"checkbox\" style=\"padding-top:3px;text-align:right;\"><label for=\"imageCONVECTIVE\" id=\"labelForConvective\">Convective</label>\r\n");

                if ($sess->mapConvective)
                {
                    printf("<input checked=\"checked\" type=\"checkbox\" name=\"CONVECTIVE\" value=\"CONVECTIVE\" id=\"CONVECTIVE\">\r\n");
                    printf("<img id=\"imageCONVECTIVE\" src=\"../images/checkboxChecked.png\" onclick=\"CheckboxClicked('CONVECTIVE')\" />\r\n");
                }
                else
                {
                    printf("<input type=\"checkbox\" name=\"CONVECTIVE\" value=\"CONVECTIVE\" id=\"CONVECTIVE\">\r\n");
                    printf("<img id=\"imageCONVECTIVE\" src=\"../images/checkboxUnchecked.png\" onclick=\"CheckboxClicked('CONVECTIVE')\" />\r\n");
                }

                printf("</td></tr>");


                printf("<tr><td class=\"checkbox\" style=\"padding-top:3px;text-align:right;\"><label for=\"imageTURB\" id=\"labelForTurbulence\">Turbulence</label>\r\n");

                if ($sess->mapTurbulence)
                {
                    printf("<input checked=\"checked\" type=\"checkbox\" name=\"TURB\" value=\"TURB\" id=\"TURB\">\r\n");
                    printf("<img id=\"imageTURB\" src=\"../images/checkboxChecked.png\" onclick=\"CheckboxClicked('TURB')\" />\r\n");
                }
                else
                {
                    printf("<input type=\"checkbox\" name=\"TURB\" value=\"TURB\" id=\"TURB\">\r\n");
                    printf("<img id=\"imageTURB\" src=\"../images/checkboxUnchecked.png\" onclick=\"CheckboxClicked('TURB')\" />\r\n");
                }

                printf("</td></tr>");


                printf("<tr><td class=\"checkbox\" style=\"padding-top:3px;text-align:right;\"><label for=\"imageICE\" id=\"labelForIcing\">Icing</label>\r\n");

                if ($sess->mapIcing)
                {
                    printf("<input checked=\"checked\" type=\"checkbox\" name=\"ICE\" value=\"ICE\" id=\"ICE\">\r\n");
                    printf("<img id=\"imageICE\" src=\"../images/checkboxChecked.png\" onclick=\"CheckboxClicked('ICE')\" />\r\n");
                }
                else
                {
                    printf("<input type=\"checkbox\" name=\"ICE\" value=\"ICE\" id=\"ICE\">\r\n");
                    printf("<img id=\"imageICE\" src=\"../images/checkboxUnchecked.png\" onclick=\"CheckboxClicked('ICE')\" />\r\n");
                }

                printf("</td></tr>");


                printf("<tr><td class=\"checkbox\" style=\"padding-top:3px;text-align:right;\"><label for=\"imageIFR\" id=\"labelForIFR\">IFR</label>\r\n");

                if ($sess->mapIFR)
                {
                    printf("<input checked=\"checked\" type=\"checkbox\" name=\"IFR\" value=\"IFR\" id=\"IFR\">\r\n");
                    printf("<img id=\"imageIFR\" src=\"../images/checkboxChecked.png\" onclick=\"CheckboxClicked('IFR')\" />\r\n");
                }
                else
                {
                    printf("<input type=\"checkbox\" name=\"IFR\" value=\"IFR\" id=\"IFR\">\r\n");
                    printf("<img id=\"imageIFR\" src=\"../images/checkboxUnchecked.png\" onclick=\"CheckboxClicked('IFR')\" />\r\n");
                }

                printf("</td></tr>");


                printf("<tr><td class=\"checkbox\" style=\"padding-top:3px;text-align:right;\"><label for=\"imageMTNOBSCN\" id=\"labelForMtnObscn\">MtnObscn</label>\r\n");

                if ($sess->mapMtnObscn)
                {
                    printf("<input checked=\"checked\" type=\"checkbox\" name=\"MTNOBSCN\" value=\"MTNOBSCN\" id=\"MTNOBSCN\">\r\n");
                    printf("<img id=\"imageMTNOBSCN\" src=\"../images/checkboxChecked.png\" onclick=\"CheckboxClicked('MTNOBSCN')\" />\r\n");
                }
                else
                {
                    printf("<input type=\"checkbox\" name=\"MTNOBSCN\" value=\"MTNOBSCN\" id=\"MTNOBSCN\">\r\n");
                    printf("<img id=\"imageMTNOBSCN\" src=\"../images/checkboxUnchecked.png\" onclick=\"CheckboxClicked('MTNOBSCN')\" />\r\n");
                }

                printf("</td></tr>");


                printf("<tr><td class=\"checkbox\" style=\"padding-top:3px;text-align:right;\"><label for=\"imageASH\" id=\"labelForAsh\">Ash</label>\r\n");

                if ($sess->mapAsh)
                {
                    printf("<input checked=\"checked\" type=\"checkbox\" name=\"ASH\" value=\"ASH\" id=\"ASH\">\r\n");
                    printf("<img id=\"imageASH\" src=\"../images/checkboxChecked.png\" onclick=\"CheckboxClicked('ASH')\" />\r\n");
                }
                else
                {
                    printf("<input type=\"checkbox\" name=\"ASH\" value=\"ASH\" id=\"ASH\">\r\n");
                    printf("<img id=\"imageASH\" src=\"../images/checkboxUnchecked.png\" onclick=\"CheckboxClicked('ASH')\" />\r\n");
                }

                printf("</td></tr>");

                printf("<tr><td class=\"centerLabel\">G-Airmet</td></tr>\r\n");


                printf("<tr><td class=\"checkbox\" style=\"padding-top:3px;text-align:right;\"><label for=\"imageGIFR\" id=\"labelForGIFR\">G-IFR</label>\r\n");

                if ($sess->mapGIFR)
                {
                    printf("<input checked=\"checked\" type=\"checkbox\" name=\"GIFR\" value=\"GIFR\" id=\"GIFR\">\r\n");
                    printf("<img id=\"imageGIFR\" src=\"../images/checkboxChecked.png\" onclick=\"CheckboxClicked('GIFR')\" />\r\n");
                }
                else
                {
                    printf("<input type=\"checkbox\" name=\"GIFR\" value=\"GIFR\" id=\"GIFR\">\r\n");
                    printf("<img id=\"imageGIFR\" src=\"../images/checkboxUnchecked.png\" onclick=\"CheckboxClicked('GIFR')\" />\r\n");
                }

                printf("</td></tr>");


                printf("<tr><td class=\"checkbox\" style=\"padding-top:3px;text-align:right;\"><label for=\"imageGMTOBSCN\" id=\"labelForGMTOBSCN\">G-MtnObscn</label>\r\n");

                if ($sess->mapGMtnObscn)
                {
                    printf("<input checked=\"checked\" type=\"checkbox\" name=\"GMTOBSCN\" value=\"GMTOBSCN\" id=\"GMTOBSCN\">\r\n");
                    printf("<img id=\"imageGMTOBSCN\" src=\"../images/checkboxChecked.png\" onclick=\"CheckboxClicked('GMTOBSCN')\" />\r\n");
                }
                else
                {
                    printf("<input type=\"checkbox\" name=\"GMTOBSCN\" value=\"GMTOBSCN\" id=\"GMTOBSCN\">\r\n");
                    printf("<img id=\"imageGMTOBSCN\" src=\"../images/checkboxUnchecked.png\" onclick=\"CheckboxClicked('GMTOBSCN')\" />\r\n");
                }

                printf("</td></tr>");


                printf("<tr><td class=\"checkbox\" style=\"padding-top:3px;text-align:right;\"><label for=\"imageGTURBHI\" id=\"labelForGTURBHI\">G-TurbHi</label>\r\n");

                if ($sess->mapGTurbHi)
                {
                    printf("<input checked=\"checked\" type=\"checkbox\" name=\"GTURBHI\" value=\"GTURBHI\" id=\"GTURBHI\">\r\n");
                    printf("<img id=\"imageGTURBHI\" src=\"../images/checkboxChecked.png\" onclick=\"CheckboxClicked('GTURBHI')\" />\r\n");
                }
                else
                {
                    printf("<input type=\"checkbox\" name=\"GTURBHI\" value=\"GTURBHI\" id=\"GTURBHI\">\r\n");
                    printf("<img id=\"imageGTURBHI\" src=\"../images/checkboxUnchecked.png\" onclick=\"CheckboxClicked('GTURBHI')\" />\r\n");
                }

                printf("</td></tr>");


                printf("<tr><td class=\"checkbox\" style=\"padding-top:3px;text-align:right;\"><label for=\"imageGTURBLO\" id=\"labelForGTURBLO\">G-TurbLo</label>\r\n");

                if ($sess->mapGTurbLo)
                {
                    printf("<input checked=\"checked\" type=\"checkbox\" name=\"GTURBLO\" value=\"GTURBLO\" id=\"GTURBLO\">\r\n");
                    printf("<img id=\"imageGTURBLO\" src=\"../images/checkboxChecked.png\" onclick=\"CheckboxClicked('GTURBLO')\" />\r\n");
                }
                else
                {
                    printf("<input type=\"checkbox\" name=\"GTURBLO\" value=\"GTURBLO\" id=\"GTURBLO\">\r\n");
                    printf("<img id=\"imageGTURBLO\" src=\"../images/checkboxUnchecked.png\" onclick=\"CheckboxClicked('GTURBLO')\" />\r\n");
                }

                printf("</td></tr>");


                printf("<tr><td class=\"checkbox\" style=\"padding-top:3px;text-align:right;\"><label for=\"imageGICE\" id=\"labelForGICE\">G-Ice</label>\r\n");

                if ($sess->mapGIce)
                {
                    printf("<input checked=\"checked\" type=\"checkbox\" name=\"GICE\" value=\"GICE\" id=\"GICE\">\r\n");
                    printf("<img id=\"imageGICE\" src=\"../images/checkboxChecked.png\" onclick=\"CheckboxClicked('GICE')\" />\r\n");
                }
                else
                {
                    printf("<input type=\"checkbox\" name=\"GICE\" value=\"GICE\" id=\"GICE\">\r\n");
                    printf("<img id=\"imageGICE\" src=\"../images/checkboxUnchecked.png\" onclick=\"CheckboxClicked('GICE')\" />\r\n");
                }

                printf("</td></tr>");


                printf("<tr><td class=\"checkbox\" style=\"padding-top:3px;text-align:right;\"><label for=\"imageGFZLVL\" id=\"labelForGFZLVL\">G-FZLVL</label>\r\n");

                if ($sess->mapGFZLVL)
                {
                    printf("<input checked=\"checked\" type=\"checkbox\" name=\"GFZLVL\" value=\"GFZLVL\" id=\"GFZLVL\">\r\n");
                    printf("<img id=\"imageGFZLVL\" src=\"../images/checkboxChecked.png\" onclick=\"CheckboxClicked('GFZLVL')\" />\r\n");
                }
                else
                {
                    printf("<input type=\"checkbox\" name=\"GFZLVL\" value=\"GFZLVL\" id=\"GFZLVL\">\r\n");
                    printf("<img id=\"imageGFZLVL\" src=\"../images/checkboxUnchecked.png\" onclick=\"CheckboxClicked('GFZLVL')\" />\r\n");
                }

                printf("</td></tr>");


                printf("<tr><td class=\"checkbox\" style=\"padding-top:3px;text-align:right;\"><label for=\"imageGMFZLVL\" id=\"labelForGMFZLVL\">G-MFZLVL</label>\r\n");

                if ($sess->mapGMFZLVL)
                {
                    printf("<input checked=\"checked\" type=\"checkbox\" name=\"GMFZLVL\" value=\"GMFZLVL\" id=\"GMFZLVL\">\r\n");
                    printf("<img id=\"imageGMFZLVL\" src=\"../images/checkboxChecked.png\" onclick=\"CheckboxClicked('GMFZLVL')\" />\r\n");
                }
                else
                {
                    printf("<input type=\"checkbox\" name=\"GMFZLVL\" value=\"GMFZLVL\" id=\"GMFZLVL\">\r\n");
                    printf("<img id=\"imageGMFZLVL\" src=\"../images/checkboxUnchecked.png\" onclick=\"CheckboxClicked('GMFZLVL')\" />\r\n");
                }

                printf("</td></tr>");


                printf("<tr><td class=\"checkbox\" style=\"padding-top:3px;text-align:right;\"><label for=\"imageGSFCWND\" id=\"labelForGSFCWND\">G-SfcWind</label>\r\n");

                if ($sess->mapGSfcWind)
                {
                    printf("<input checked=\"checked\" type=\"checkbox\" name=\"GSFCWND\" value=\"GSFCWND\" id=\"GSFCWND\">\r\n");
                    printf("<img id=\"imageGSFCWND\" src=\"../images/checkboxChecked.png\" onclick=\"CheckboxClicked('GSFCWND')\" />\r\n");
                }
                else
                {
                    printf("<input type=\"checkbox\" name=\"GSFCWND\" value=\"GSFCWND\" id=\"GSFCWND\">\r\n");
                    printf("<img id=\"imageGSFCWND\" src=\"../images/checkboxUnchecked.png\" onclick=\"CheckboxClicked('GSFCWND')\" />\r\n");
                }

                printf("</td></tr>");


                printf("<tr><td class=\"checkbox\" style=\"padding-top:3px;text-align:right;\"><label for=\"imageGLLWS\" id=\"labelForGLLWS\">G-LLWS</label>\r\n");

                if ($sess->mapGLLWS)
                {
                    printf("<input checked=\"checked\" type=\"checkbox\" name=\"GLLWS\" value=\"GLLWS\" id=\"GLLWS\">\r\n");
                    printf("<img id=\"imageGLLWS\" src=\"../images/checkboxChecked.png\" onclick=\"CheckboxClicked('GLLWS')\" />\r\n");
                }
                else
                {
                    printf("<input type=\"checkbox\" name=\"GLLWS\" value=\"GLLWS\" id=\"GLLWS\">\r\n");
                    printf("<img id=\"imageGLLWS\" src=\"../images/checkboxUnchecked.png\" onclick=\"CheckboxClicked('GLLWS')\" />\r\n");
                }

                printf("</td></tr>");

                printf("<tr><td class=\"centerLabel\">Other</td></tr>\r\n");


                printf("<tr><td class=\"checkbox\" style=\"padding-top:3px;text-align:right;\"><label for=\"imagePIREP\" id=\"labelForPIREP\">PIREP</label>\r\n");

                if ($sess->mapPIREPs)
                {
                    printf("<input checked=\"checked\" type=\"checkbox\" name=\"PIREP\" value=\"PIREP\" id=\"PIREP\">\r\n");
                    printf("<img id=\"imagePIREP\" src=\"../images/checkboxChecked.png\" onclick=\"CheckboxClicked('PIREP')\" />\r\n");
                }
                else
                {
                    printf("<input type=\"checkbox\" name=\"PIREP\" value=\"PIREP\" id=\"PIREP\">\r\n");
                    printf("<img id=\"imagePIREP\" src=\"../images/checkboxUnchecked.png\" onclick=\"CheckboxClicked('PIREP')\" />\r\n");
                }

                printf("</td></tr>");


                printf("<tr><td class=\"checkbox\" style=\"padding-top:3px;text-align:right;\"><label for=\"imageRamps\" id=\"labelForRamps\">Ramps</label>\r\n");

                if ($sess->mapRamps)
                {
                    printf("<input checked=\"checked\" type=\"checkbox\" name=\"Ramps\" value=\"Ramps\" id=\"Ramps\">\r\n");
                    printf("<img id=\"imageRamps\" src=\"../images/checkboxChecked.png\" onclick=\"CheckboxClicked('Ramps')\" />\r\n");
                }
                else
                {
                    printf("<input type=\"checkbox\" name=\"Ramps\" value=\"Ramps\" id=\"Ramps\">\r\n");
                    printf("<img id=\"imageRamps\" src=\"../images/checkboxUnchecked.png\" onclick=\"CheckboxClicked('Ramps')\" />\r\n");
                }

                printf("</td></tr>");
                ?>

                <tr>
                    <td><center><button type="submit" name="GetMapItems" id="getMapItems" class="smallButton" onclick="GetMapItems();">GetMapItems</button></center></td>
                </tr>
                <tr>
                    <td><center><button type="submit" name="ClearSelections" id="clearSelections" class="smallButton" onclick="ClearSelections();">ClearSelections</button></center></td>
                </tr>
            </table>
        </td>
    </tr>
</table>

<table class="footer" style="top:-8px">
    <tr>
        <td><?php $f = new Footer();?></td>
    </tr>
</table>

</body>
</html>