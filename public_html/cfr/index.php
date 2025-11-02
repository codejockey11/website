<?php
require_once "../includes.php";
?>

<!DOCTYPE html>
<html>

<head>
<title>Code Of Federal Regulations</title>
<meta charset="UTF-8">
<link rel="shortcut icon" href="../favicon.ico">
<link rel="stylesheet" href="../base.css?v=1">
<script type="text/javascript" src="../base.js?v=1"></script>
</head>

<body>

<table class="topPanel">
	<tr>
		<td><?php require_once "../navSignOn.php";?></td>
	</tr>
</table>

<table class="pageResult">
	<tr>
		<td>
		<p>
		<?php
		printf("<a href=\"../cfr/cfr14index.php?id=%s\">Title 14 - Aeronautics and Space</a><br/>\r\n", $sess->sessionId);
		printf("<a href=\"../cfr/cfr49index.php?id=%s#PART 830 - NOTIFICATION AND REPORTING OF AIRCRAFT ACCIDENTS OR INCIDENTS AND OVERDUE AIRCRAFT, AND PRESERVATION OF AIRCRAFT WRECKAGE, MAIL, CARGO, AND RECORDS\">Title 49 - Transportation PART 830</a><br/>\r\n", $sess->sessionId);
		?>
		</p>
		</td>
	</tr>
</table>

<table class="footer">
	<tr>
		<td><?php $f = new Footer(true);?></td>
	</tr>
</table>

</body>
</html>