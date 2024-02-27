<?php
require_once "../Utility.php";
require_once "../classes/Database.php";

$selection = null;
if (isset($_GET["s"]))
{
	$selection = $_GET["s"];
}

?>
<!DOCTYPE html>
<html>
<head>
<title>Cookbook</title>
<style>
body{
	font-family:Arial;
	font-size:18px;
}

table {
	width:100%;
	table-layout:fixed;
	border-collapse:collapse;
}

td {
	vertical-align:top;
    word-wrap:break-word;
	margin:5px;
}

.steps {
	vertical-align:top;
    word-wrap:break-word;
	text-align:justify;
	text-justify:block;
}

.pagebreak {
	page-break-before:always;
}
</style>
</head>

<body>

<?php
$title = null;
$author = null;

$ingredients = array();

$steps = null;

if ($selection)
{
	$sa = explode(",", $selection);

	$d = new Database();

	$d->ExecSql(sprintf("SELECT * FROM cbTitle WHERE title='%s'", $sa[0]));

	if ($d->GetRowCount() > 0)
	{
		$row = $d->FetchRow();

		$title = $row["title"];
		$author = $row["author"];
	}

	$d->ExecSql(sprintf("SELECT * FROM cbIngredients WHERE title='%s'", $sa[0]));

	if ($d->GetRowCount() > 0)
	{
		while($row = $d->FetchRow())
		{
			array_push($ingredients, $row["name"]);
		}
	}

	$d->ExecSql(sprintf("SELECT * FROM cbSteps WHERE title='%s'", $sa[0]));

	if ($d->GetRowCount() > 0)
	{
		while($row = $d->FetchRow())
		{
			$steps = str_replace("\r\n", "<br/>", $row["text"]);
		}
	}

	FormatRecipe($title, $author, $ingredients, $steps, 0);
}
else
{
	$d = new Database();

	$d->ExecSql(sprintf("SELECT * FROM cbTitle ORDER BY title"));

	$page = 1;

	printf("<table>\r\n");

	while($row = $d->FetchRow())
	{
		printf("<tr><td>" . $row["title"] . "</td><td>" . $page . "</td></tr>\r\n");
		$page++;
	}

	printf("<table>\r\n");

	printf("<div class=\"pagebreak\"></div>");

	$d->ExecSql(sprintf("SELECT * FROM cbTitle t, cbIngredients i, cbSteps s WHERE t.title=i.title AND t.title=s.title ORDER BY t.title"));

	$prevTitle = null;

	if ($d->GetRowCount() > 0)
	{
		$row = $d->FetchRow();

		$title = $row["title"];
		$author = $row["author"];

		array_push($ingredients, $row["name"]);

		$steps = str_replace("\r\n", "<br/>", $row["text"]);

		$prevTitle = $title;
		$prevAuthor = $author;
		$prevSteps = $steps;

		$page = 1;

		while($row = $d->FetchRow())
		{
			$title = $row["title"];
			$author = $row["author"];

			$steps = str_replace("\r\n", "<br/>", $row["text"]);

			if ($prevTitle != $title)
			{
				FormatRecipe($prevTitle, $prevAuthor, $ingredients, $prevSteps, $page);

				printf("<div class=\"pagebreak\"></div>");

				$ingredients = array();

				$prevTitle = $title;
				$prevAuthor = $author;
				$prevSteps = $steps;

				$page++;
			}

			array_push($ingredients, $row["name"]);
		}

		FormatRecipe($prevTitle, $prevAuthor, $ingredients, $prevSteps, $page);
	}
}

function FormatRecipe($title, $author, $ingredients, $steps, $page)
{

	if ($page == 0)
	{
		printf("<table>\r\n");		
		printf("<tr><td colspan=\"3\">" . $title . "</td></tr>\r\n");
	}
	else
	{
		printf("<table>\r\n");
		printf("<tr><td colspan=\"2\">" . $title . "</td><td style=\"text-align:right;\">" . $page . "</td></tr>\r\n");
		printf("</table>\r\n");
		printf("<table>\r\n");
	}



	printf("<tr><td>&nbsp;</td></tr>\r\n");

	$col1 = null;
	$col2 = null;
	$col3 = null;

	$col = 0;

	for ($i = 0; $i < count($ingredients);$i++)
	{
		$t = $ingredients[$i] . "<br/>";

		switch($col)
		{
			case 0:
			{
				$col1 .= $t;

				break;
			}
			case 1:
			{
				$col2 .= $t;

				break;
			}
			case 2:
			{
				$col3 .= $t;

				break;
			}
		}

		$col++;
		if ($col == 3)
		{
			$col = 0;
		}
	}

	printf("<tr>\r\n");

	printf("<td>" . $col1 . "</td>\r\n");
	printf("<td>" . $col2 . "</td>\r\n");
	printf("<td>" . $col3 . "</td>\r\n");

	printf("</tr>\r\n");

	printf("<tr><td>&nbsp;</td></tr>\r\n");

	printf("<tr>\r\n");

	if($steps != null)
	{
		printf("<td colspan=\"3\" class=\"steps\">" . $steps . "</td>\r\n");
	}

	printf("</tr>\r\n");

	printf("</table>\r\n");
}
?>

<script>print(document);</script>

</body>

</html>