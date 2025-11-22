<?php
require_once "../includes.php";
?>

<!DOCTYPE html>
<html>

<head>
<title>My Logbook Printable</title>
<meta charset="UTF-8">
<link rel="shortcut icon" href="../favicon.ico">
<link rel="stylesheet" href="../base.css?v=1">
<script type="text/javascript" src="../base.js?v=1"></script>
</head>

<body>

<table>
	<tr>
		<td class="logbook">
		<?php
		$lb = new Logbook($sess, null);

		printf("%s", $lb->ListEntries());
		?>
		<script>print(document)</script>
		</td>
	</tr>
</table>

</body>
</html>