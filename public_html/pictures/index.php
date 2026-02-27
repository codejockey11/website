<?php
printf("<html>\r\n");

printf("<head>\r\n");
printf("<meta http-equiv=\"content-type\" content=\"text/html;charset=utf-8\"/>\r\n");
printf("<title>Pictures</title>\r\n");
printf("</head>\r\n");

printf("<body>\r\n");

$images = glob("*.jpg");

$count = 0;

foreach ($images as $img)
{
    printf("<img width=600 height=400 src=\"" . $img."\" />");
	
	$count++;
	
	if ($count == 3)
	{
		$count = 0;
		
		printf("<br/>\r\n");
	}
}

printf("</body>");
printf("</html>");
?>