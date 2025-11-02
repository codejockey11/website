<?php
if (extension_loaded('declination'))
{
	$today = date("Y.z");
	
	echo $today . "<br/>";
	
	$d = getDeclination(39.342776, -81.440772, $today);
	
	//-8.0705428766845
	//-8.06734381911
	
	echo "39.342776, -81.440772 " . $d;
}
else
{
	printf("declination not loaded");
}
?>