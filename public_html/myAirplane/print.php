<?php
require_once "../includes.php";

if ($sess->loggedOn == null)
{
	printf("<script>window.location='../planner/index.php?id=%s'</script>\r\n", $sess->sessionId);
}
?>

<!DOCTYPE html>
<html>

<head>
<title>My Airplane Printable</title>
<meta charset="UTF-8">
<link rel="shortcut icon" href="../favicon.ico">
<link rel="stylesheet" href="../base.css?v=1">
<script type="text/javascript" src="../base.js?v=1"></script>
</head>

<body>

<?php
$ap = new Airplane($sess, $sess->registration);

if ($pln = $ap->GetSingle(0))
{
	printf("%s", $pln->FormatPrintable());
}
?>

<script>print(document)</script>

</body>
</html>