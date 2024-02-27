DEL weather.tif.bat
DEL weather.tif.gz
DEL weather.tif
DEL weather.vrt

GetCurrentWeatherImage.exe

CALL "weather.tif.bat"

SET GDAL_DRIVER_PATH="C:\Program Files\QGIS 3.22.1\bin\gdalplugins"
SET OSGEO4W_ROOT=C:\Program Files\QGIS 3.22.1
SET PATH=%OSGEO4W_ROOT%\bin;%PATH%
SET PYTHONHOME=%OSGEO4W_ROOT%\apps\Python39
SET PYTHONPATH="%OSGEO4W_ROOT%\apps\Python39"
SET WEBSITE_ROOT=C:\Users\junk_\Documents\website\public_html\charts

IF EXIST "weather.tif" ( CALL "%PYTHONHOME%\Scripts\gdal2tiles.bat" -z 4-9 -w google -r average -s EPSG:4326 --xyz -b ArZP1HDL-as-_VQnajKbHiDpKqkkSHhLbIyBSUWi0lWZw9b6h8vWJ3H80KJ9fYw9 weather.tif "public_html\charts\weather" )

PAUSE