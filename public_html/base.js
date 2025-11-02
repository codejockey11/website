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

const border = '1px solid rgb(70, 130, 180)';

const radioUnchecked = '../images/radioUnchecked.png';
const radioChecked = '../images/radioChecked.png';

const checkboxUnchecked = '../images/checkboxUnchecked.png';
const checkboxChecked = '../images/checkboxChecked.png';
//==========================================================================================
// Functions
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