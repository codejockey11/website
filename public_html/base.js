//==========================================================================================
// Constants
//==========================================================================================
const green = 'rgb(0, 255, 0)';
const darkBlue = 'rgb(11, 83, 148)';
const blue = 'rgb(0, 0, 255)';
const red = 'rgb(255, 0, 0)';
const pink = 'rgb(255, 0, 255)';
const purple = 'rgb(127, 127, 255)';
const lightRed = 'rgb(255, 127, 127)';
const black = 'rgb(0, 0, 0)';
const gold = 'rgb(255, 215, 0)';
const paleVioletRed = 'rgb(219, 112, 147)';
const lightSalmon = 'rgb(255, 160, 122)';

const border = '1px solid SteelBlue';

const radioUnchecked = '../images/radioUnchecked.png';
const radioChecked = '../images/radioChecked.png';

const checkboxUnchecked = '../images/checkboxUnchecked.png';
const checkboxChecked = '../images/checkboxChecked.png';
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
class BingMarker
{
    marker = null;
    infoWindow = null;
    isOpen = false;
    location = null;
    map = null;

    constructor(map, label, lat, lon, color, iconUrl, info)
    {
        this.map = map;

        this.location = new Microsoft.Maps.Location(lat, lon);

        if (label.length == 0)
        {
            this.marker = new Microsoft.Maps.Pushpin(this.location,
			{
				icon: iconUrl
			});
        }
        else
        {
            this.marker = new Microsoft.Maps.Pushpin(this.location,
			{
				icon: iconUrl,
				title: label
			});
        }

        this.infoWindow = new Microsoft.Maps.Infobox(this.location,
		{
			visible: false,
			showPointer: false,
			showCloseButton: false,
			htmlContent: info
		});

		this.infoWindow.setMap(this.map);

        Microsoft.Maps.Events.addHandler(this.marker, 'click', (function (a)
        {
            return function ()
            {
                if (a.isOpen == false)
                {
                    a.isOpen = true;

                    if (a.infoWindow.getHtmlContent() > '')
                    {
						a.infoWindow.setOptions({
							visible: true
						});
					}
                }
                else
                {
                    a.isOpen = false;

					a.infoWindow.setOptions({
						visible: false
					});
                }
            };
        })(this));

		this.map.entities.push(this.marker);
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
class BingLine
{
    points = [];
    edit = false;
    infoWindow = null;
    color = null;
    weight = null;
    line = null;
    map = null;
    isOpen = false;

    constructor(map, color, weight, info, index)
    {
        this.points = [];

        this.map = map;
        this.color = color;
        this.weight = weight;

		this.infoWindow = new Microsoft.Maps.Infobox(null,
		{
			visible: false,
			showPointer: false,
			showCloseButton: false,
			htmlContent: info
		});

		this.infoWindow.setMap(this.map);

		this.index = index;
    }

    AddPoint(name, lat, lon, info)
    {
        var location = new Microsoft.Maps.Location(lat, lon);

        this.points.push(location);

        //var pointMarker = new BingMarker(this.map, name, lat, lon, black, info);
    }

    End()
    {
        this.line = new Microsoft.Maps.Polyline(this.points,
		{
			strokeThickness: this.weight,
			strokeColor: this.color
		});

		this.line.metadata = this.index;

        Microsoft.Maps.Events.addHandler(this.line, 'click', (function (a)
        {
			GetRightClickFlightPlan(a.location, a.target.metadata);
		}));

		this.map.entities.push(this.line);
	}

    SetMousePosition(mp)
    {
        this.infoWindow.metadata = mp;
    }
}
class BingLineGAirmet
{
    points = [];
    edit = false;
    infoWindow = null;
    color = null;
    weight = null;
    line = null;
    map = null;
    isOpen = false;

    constructor(map, color, weight, info, index)
    {
        this.points = [];

        this.map = map;
        this.color = color;
        this.weight = weight;

		this.infoWindow = new Microsoft.Maps.Infobox(null,
		{
			visible: false,
			showPointer: false,
			showCloseButton: false,
			htmlContent: info
		});

		this.infoWindow.setMap(this.map);

		this.index = index;
    }

    AddPoint(name, lat, lon, info)
    {
        var location = new Microsoft.Maps.Location(lat, lon);

        this.points.push(location);

        //var pointMarker = new BingMarker(this.map, name, lat, lon, black, info);
    }

    End()
    {
        this.line = new Microsoft.Maps.Polyline(this.points,
		{
			strokeThickness: this.weight,
			strokeColor: this.color
		});

		Microsoft.Maps.Events.addHandler(this.line, 'click', (function (a)
		{
			return function ()
			{
				if (a.getOptions().visible == false)
				{
					a.setLocation(a.metadata);

					a.setOptions({
						visible: true
					});
				}
				else
				{
					a.setOptions({
						visible: false
					});
				}
			};
		})(this.infoWindow));

		this.map.entities.push(this.line);
	}

    SetMousePosition(mp)
    {
        this.infoWindow.metadata = mp;
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
class BingPolygon
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

		this.infoWindow = new Microsoft.Maps.Infobox(null,
		{
			visible: false,
			showPointer: false,
			showCloseButton: false,
			htmlContent: info
		});

		this.infoWindow.setMap(this.map);
    }

    AddPoint(lat, lon)
    {
        var location = new Microsoft.Maps.Location(lat, lon);

        this.points.push(location);
    }

    End()
    {
        this.polygon = new Microsoft.Maps.Polygon(this.points,
		{
			fillColor: this.color,
			strokeColor: darkBlue
		});

		Microsoft.Maps.Events.addHandler(this.polygon, 'click', (function (a)
		{
			return function ()
			{
				if (a.getOptions().visible == false)
				{
					a.setLocation(a.metadata);

					a.setOptions({
						visible: true
					});
				}
				else
				{
					a.setOptions({
						visible: false
					});
				}
			};
		})(this.infoWindow));

		this.map.entities.push(this.polygon);
    }

    SetMousePosition(mp)
    {
        this.infoWindow.metadata = mp;
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
class BingMapTile
{
	map = null;
	name = null;
	order = null;
	tileSource = null;
	tileLayer = null;
	isOpen = false;
	tileSource = null;
	tileLayer = null;
	opacity = null;
	bounds = null;

	constructor(map, name, order, minZoom, maxZoom, opacity, toggle, bounds)
	{
        this.map = map;
        this.name = name;
        this.order = order;
        this.minZoom = minZoom;
        this.maxZoom = maxZoom;
		this.opacity = opacity;
		this.bounds = bounds;

        if (toggle == 1)
        {
            this.isOpen = true;
        }

		//Define the tile source for the USGS Topo layer.
		this.tileSource = new Microsoft.Maps.TileSource(
			{
				uriConstructor: 'http://127.0.0.1:26105/charts/' + name + '/{zoom}/{x}/{y}.png',
				//uriConstructor: 'http://173.81.27.12:26105/charts/' + name + '/{zoom}/{x}/{y}.png',
				//uriConstructor: 'https://tile.openweathermap.org/map/precipitation_new/{zoom}/{x}/{y}.png?appid=141671986be9544d529be902af436cb7',
				//uriConstructor: 'http://tile.openstreetmap.org/{zoom}/{x}/{y}.png',
				minZoom: this.minZoom,
				maxZoom: this.maxZoom,
				bounds: this.bounds
			});

		//Create a tile layer from the tile source
		this.tileLayer = new Microsoft.Maps.TileLayer(
			{
				mercator: this.tileSource,
				opacity: this.opacity,
				visible: this.isOpen
			});

        this.map.layers.insert(this.tileLayer);
	}

    Toggle()
    {
        if (this.isOpen == false)
        {
            this.isOpen = true;
        }
        else
        {
            this.isOpen = false;
        }

		this.tileLayer.setVisible(this.isOpen);
    }
}
//==========================================================================================
// Functions
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
function RadioClicked(radioid, formid, radioName)
{
    var form = document.getElementById(formid);

    for (var i = 0; i < form.length; i++)
    {
        if (form[i].name == radioName)
        {
            document.getElementById(form[i].id).checked = false;

            document.getElementById('image' + form[i].id).src = radioUnchecked;
        }
    }

    document.getElementById(radioid).checked = true;

    document.getElementById('image' + radioid).src = radioChecked;
}
//==========================================================================================
function CheckboxClicked(checkid)
{
    if (document.getElementById(checkid).checked === true)
    {
        document.getElementById('image' + checkid).src = checkboxUnchecked;

        document.getElementById(checkid).checked = false;
    }
    else
    {
        document.getElementById('image' + checkid).src = checkboxChecked;

        document.getElementById(checkid).checked = true;
    }
}
//==========================================================================================
function SetImage(s, i)
{
    s.src = i;
}
//==========================================================================================
function SetScrollTop(s, fs)
{
    if (document.getElementById(s) !== null)
    {
        document.getElementById(s).scrollTop = (document.getElementById(s).selectedIndex * fs);
    }
}
//==========================================================================================
function GetCookie(cname)
{
    var name = cname + '=';

    var ca = document.cookie.split(';');

    for (var i = 0; i < ca.length; i++)
    {
        var c = ca[i];

        while (c.charAt(0) === ' ')
        {
            c = c.substring(1);
        }

        if (c.indexOf(name) === 0)
        {
            return c.substring(name.length, c.length);
        }
    }

    return null;
}
//==========================================================================================
function SetCookie(cname, cvalue, exdays)
{
    var d = new Date();

    d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));

    var expires = 'expires=' + d.toUTCString();

    document.cookie = cname + '=' + cvalue + ';' + expires + '; path=/';
}
//==========================================================================================
function DeleteCookie(name)
{
    document.cookie = name + '=; expires=Thu, 01 Jan 1970 00:00:01 GMT;';
}
//==========================================================================================
function AddZero(i)
{
    if (i.toString().length < 2)
    {
        i = '0' + i;
    }

    return i;
}
//==========================================================================================
function ShowClock()
{
    var d = new Date();

    var tzo = d.getTimezoneOffset();

    tzo /= 60;

    var pm = '-';

    var m = d.getMonth();

    m += 1;

    var ds = 'GMT' + pm + tzo + ':' + AddZero(m) + '/' +
        AddZero(d.getDate()) + '/' +
        AddZero(d.getFullYear()) + ' ' +
        AddZero(d.getHours()) + ':' +
        AddZero(d.getMinutes());

    document.getElementById('clock1').innerHTML = ds;

    m = d.getUTCMonth();

    m += 1;

    var ds2 = 'UTC:' + m + '/' +
        AddZero(d.getUTCDate()) + '/' +
        AddZero(d.getUTCFullYear()) + ' ' +
        AddZero(d.getUTCHours()) + ':' +
        AddZero(d.getUTCMinutes());

    document.getElementById('clock2').innerHTML = ds2 + 'Z';

    setTimeout('ShowClock()', 999);
}
//==========================================================================================
// javascript to update the 'fileUpload' tag so it will display on the page
function ShowUpload()
{
    // can only obtain the file name
    var fullPath = document.getElementById('fileUpload').value;

    if (fullPath)
    {
        var startIndex = (fullPath.indexOf('\\') >= 0 ? fullPath.lastIndexOf('\\') : fullPath.lastIndexOf('/'));

        var filename = fullPath.substring(startIndex);

        if (filename.indexOf('\\') === 0 || filename.indexOf('/') === 0)
        {
            filename = filename.substring(1);
        }

        document.getElementById('fileUploadError').innerHTML = 'Selected:' + filename;

        document.getElementById('fileUploadError').style.color = 'black';
    }
    else
    {
        document.getElementById('fileUploadError').style.color = 'tomato';
    }

    setTimeout('ShowUpload()', 999);
}
//==========================================================================================
function ClearSelect(s)
{
    for (var i = s.options.length - 1; i > -1; i--)
    {
        s.removeChild(s.options[i]);
    }
}
//==========================================================================================
function URLSpecialChars(s)
{
    return s.replace("&", "%26"); //.replace(">", "&gt;").replace("<", "&lt;").replace("\"", "&quot;");
}
//==========================================================================================
function AddElement(parentId, elementTag, elementId)
{
    var p = document.getElementById(parentId);

    var newElement = document.createElement(elementTag);

    newElement.setAttribute('id', elementId);

    p.appendChild(newElement);
}
//==========================================================================================
function AddButtonElement(parentId, elementTag, elementId, value, nbr)
{
    var p = document.getElementById(parentId);

    var newElement = document.createElement(elementTag);

    newElement.setAttribute('id', elementId);

    newElement.setAttribute('class', 'smallButton');

    newElement.innerHTML = value;

    newElement.onclick = function ()
    {
        ToggleMapOverlay(nbr);
    };

    p.appendChild(newElement);
}
//==========================================================================================
function RemoveElement(parentNode, elementId)
{
    var p = document.getElementById(parentNode);

    var e = document.getElementById(elementId);

    if (e == null)
    {
        return;
    }

    p.removeChild(e);
}
//==========================================================================================
function WaitFunction()
{
    // generic function for timer events
    return;
}
//==========================================================================================
function ToggleDropdownVisibility(id)
{
    var select = document.getElementById(id);

    // select.style.visibility is empty on initial page load even though it is defined in the style sheet
    if ((select.style.visibility == 'hidden') || (select.style.visibility == ''))
    {
        select.style.visibility = 'visible';
    }
    else
    {
        select.style.visibility = 'hidden';
    }
}
//==========================================================================================
// Haversine formula
// from stackoverflow.com
function getDistanceFromLatLonInKm(lat1, lon1, lat2, lon2)
{
    var R = 6371; // Radius of the earth in km
    var dLat = deg2rad(lat2 - lat1);  // deg2rad below
    var dLon = deg2rad(lon2 - lon1);
    var a =
        Math.sin(dLat / 2) * Math.sin(dLat / 2) +
        Math.cos(deg2rad(lat1)) * Math.cos(deg2rad(lat2)) *
        Math.sin(dLon / 2) * Math.sin(dLon / 2);
    var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
    var d = R * c; // Distance in km
    return d;
}
//==========================================================================================
function deg2rad(deg)
{
    return deg * (Math.PI / 180)
}