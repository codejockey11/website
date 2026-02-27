<?php
require_once "../Utility.php";
require_once "../classes/Database.php";

$query = null;
if (isset($_GET["q"]))
{
	$query = $_GET["q"];
}

$selection = null;
if (isset($_GET["s"]))
{
	$selection = $_GET["s"];
}

$searchName = null;

if (isset($_POST["searchName"]))
{
	$searchName = $_POST["searchName"];
}

$pageType = null;

if (isset($_POST["searchPage"]))
{
	$pageType = $_POST["searchPage"];
}

if (isset($_POST["searchIngredient"]))
{
	$pageType = $_POST["searchIngredient"];
}

if (isset($_POST["searchAuthor"]))
{
	$pageType = $_POST["searchAuthor"];
}

$addPage = false;
if (isset($_POST["addPage"]))
{
	$addPage = true;
	$searchName = null;
	$pageType = $_POST["addPage"];
}

if (isset($_POST["updatePage"]))
{
	$searchName = null;
	$pageType = $_POST["updatePage"];
}

if (isset($_POST["printBook"]))
{
	$searchName = null;
	$pageType = $_POST["printBook"];
}

$pageFunction = null;

if (isset($_POST["addRecipe"]))
{
	$searchName = null;
	$pageType = null;
	$pageFunction = $_POST["addRecipe"];
}

if (isset($_POST["updateRecipe"]))
{
	$searchName = null;
	$pageType = null;
	$pageFunction = $_POST["updateRecipe"];
}

if (isset($_POST["deleteRecipe"]))
{
	$searchName = null;
	$pageType = null;
	$pageFunction = $_POST["deleteRecipe"];
}

if (isset($_POST["resetRecipe"]))
{
	$addPage = true;
	$searchName = null;
	// must be same value as addPage value
	$pageType = "Add";
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

form {
   display:inline;
   margin:0;
   padding:0;
}

textarea{
	width:100%;
	max-height:400px;
	height:400px;
	font-family:Arial;
	font-size:28px;
}

.navigation {
	vertical-align:top;
	width:25%;
}

.page {
	vertical-align:top;
	text-align:left;
	width:75%;
}

.button{
	width:100px;
	font-size:16px;
}

.inputText{
	width:100%;
	font-size:28px;
}
</style>
</head>

<body>

<table>
<tr>
<td class="navigation">
<form name="mainForm"  method="post" action="index.php">
	<table>
	<tr><td>Welcome to The Cookbook</td></tr>
	<tr><td>
		<input type="text" name="searchName" class="inputText" style="width:400px;" value="<?php printf($searchName); ?>" placeholder="Search Text"/>
	</td></tr>
	<tr><td>
		<input type="submit" name="searchPage" value="Title" class="button" />&nbsp;&nbsp;&nbsp;Search by Title
	</td></tr>
	<tr><td>
		<input type="submit" name="searchIngredient" value="Ingredient" class="button" />&nbsp;&nbsp;&nbsp;Search by Ingredient
	</td></tr>
	<tr><td>
		<input type="submit" name="searchAuthor" value="Author" class="button" />&nbsp;&nbsp;&nbsp;Search by Author
	</td></tr>
	<?php
	if ($addPage === false)
	{
		printf("<tr><td>\r\n<input type=\"submit\" name=\"addPage\"    value=\"Add\"    class=\"button\" />&nbsp;&nbsp;&nbsp;Add a recipe\r\n</td></tr>\r\n");
	}
	?>
	<tr><td>
	</form>
	<form name="printForm"  method="post" target="_blank" action="print.php?s=">
	<input type="submit" name="printBook"    value="Print Book"    class="button" />&nbsp;&nbsp;&nbsp;Print the cookbook
	</form>
	</td></tr>
	</table>
</td>
<?php
if ($query)
{
	WriteUpdateForm($query);
}
else if ($pageFunction)
{
	switch ($pageFunction)
	{
		case "Add":
		{
			$t = AddRecipe();

			if ($t != null)
			{
				WriteUpdateForm($t);	
			}
			else
			{
				WriteAddForm();
			}

			break;
		}

		case "Delete":
		{
			DeleteRecipe($selection);

			break;
		}

		case "Update":
		{
			DeleteRecipe($selection);

			$t = AddRecipe();

			if ($t != null)
			{
				WriteUpdateForm($t);	
			}
			else
			{
				WriteAddForm();
			}

			break;
		}
	}
}
else if ($pageType)
{
	switch ($pageType)
	{
		case "Title":
		{
			SearchRecipe($searchName);

			break;
		}

		case "Ingredient":
		{
			SearchIngredient($searchName);

			break;
		}

		case "Author":
		{
			SearchAuthor($searchName);

			break;
		}

		case "Add":
		{
			WriteAddForm();

			break;
		}
	}
}

function DeleteRecipe($selection)
{
	$d = new Database();

	$d->ExecSql(sprintf("DELETE FROM cbTitle WHERE title='%s'", $selection));
	$d->ExecSql(sprintf("DELETE FROM cbIngredients WHERE title='%s'", $selection));
	$d->ExecSql(sprintf("DELETE FROM cbSteps WHERE title='%s'", $selection));
}

function AddRecipe()
{
	if ($_POST["title"] == null)
	{
		return;
	}

	if ($_POST["author"] == null)
	{
		return;
	}
	
	if ($_POST["ingredient0000"] == null)
	{
		return;
	}

	if ($_POST["steps"] == null)
	{
		return;
	}

	$d = new Database();

	$d->ExecSql(sprintf("INSERT INTO cbTitle (title, author) VALUES ('%s','%s')", $_POST["title"], $_POST["author"]));

	if ($_POST["ingredient0000"])
	{
		$d->ExecSql(sprintf("INSERT INTO cbIngredients (title, name) VALUES ('%s','%s')", $_POST["title"], $_POST["ingredient0000"]));
	}
	if ($_POST["ingredient0001"])
	{
		$d->ExecSql(sprintf("INSERT INTO cbIngredients (title, name) VALUES ('%s','%s')", $_POST["title"], $_POST["ingredient0001"]));
	}
	if ($_POST["ingredient0002"])
	{
		$d->ExecSql(sprintf("INSERT INTO cbIngredients (title, name) VALUES ('%s','%s')", $_POST["title"], $_POST["ingredient0002"]));
	}
	if ($_POST["ingredient0100"])
	{
		$d->ExecSql(sprintf("INSERT INTO cbIngredients (title, name) VALUES ('%s','%s')", $_POST["title"], $_POST["ingredient0100"]));
	}
	if ($_POST["ingredient0101"])
	{
		$d->ExecSql(sprintf("INSERT INTO cbIngredients (title, name) VALUES ('%s','%s')", $_POST["title"], $_POST["ingredient0101"]));
	}
	if ($_POST["ingredient0102"])
	{
		$d->ExecSql(sprintf("INSERT INTO cbIngredients (title, name) VALUES ('%s','%s')", $_POST["title"], $_POST["ingredient0102"]));
	}
	if ($_POST["ingredient0200"])
	{
		$d->ExecSql(sprintf("INSERT INTO cbIngredients (title, name) VALUES ('%s','%s')", $_POST["title"], $_POST["ingredient0200"]));
	}
	if ($_POST["ingredient0201"])
	{
		$d->ExecSql(sprintf("INSERT INTO cbIngredients (title, name) VALUES ('%s','%s')", $_POST["title"], $_POST["ingredient0201"]));
	}
	if ($_POST["ingredient0202"])
	{
		$d->ExecSql(sprintf("INSERT INTO cbIngredients (title, name) VALUES ('%s','%s')", $_POST["title"], $_POST["ingredient0202"]));
	}
	if ($_POST["ingredient0300"])
	{
		$d->ExecSql(sprintf("INSERT INTO cbIngredients (title, name) VALUES ('%s','%s')", $_POST["title"], $_POST["ingredient0300"]));
	}
	if ($_POST["ingredient0301"])
	{
		$d->ExecSql(sprintf("INSERT INTO cbIngredients (title, name) VALUES ('%s','%s')", $_POST["title"], $_POST["ingredient0301"]));
	}
	if ($_POST["ingredient0302"])
	{
		$d->ExecSql(sprintf("INSERT INTO cbIngredients (title, name) VALUES ('%s','%s')", $_POST["title"], $_POST["ingredient0302"]));
	}
	if ($_POST["ingredient0400"])
	{
		$d->ExecSql(sprintf("INSERT INTO cbIngredients (title, name) VALUES ('%s','%s')", $_POST["title"], $_POST["ingredient0400"]));
	}
	if ($_POST["ingredient0401"])
	{
		$d->ExecSql(sprintf("INSERT INTO cbIngredients (title, name) VALUES ('%s','%s')", $_POST["title"], $_POST["ingredient0401"]));
	}
	if ($_POST["ingredient0402"])
	{
		$d->ExecSql(sprintf("INSERT INTO cbIngredients (title, name) VALUES ('%s','%s')", $_POST["title"], $_POST["ingredient0402"]));
	}
	if ($_POST["ingredient0500"])
	{
		$d->ExecSql(sprintf("INSERT INTO cbIngredients (title, name) VALUES ('%s','%s')", $_POST["title"], $_POST["ingredient0500"]));
	}
	if ($_POST["ingredient0501"])
	{
		$d->ExecSql(sprintf("INSERT INTO cbIngredients (title, name) VALUES ('%s','%s')", $_POST["title"], $_POST["ingredient0501"]));
	}
	if ($_POST["ingredient0502"])
	{
		$d->ExecSql(sprintf("INSERT INTO cbIngredients (title, name) VALUES ('%s','%s')", $_POST["title"], $_POST["ingredient0502"]));
	}

	if ($_POST["steps"])
	{
		$d->ExecSql(sprintf("INSERT INTO cbSteps (title, text) VALUES ('%s','%s')", $_POST["title"], $_POST["steps"]));
	}

	return $_POST["title"];
}

function SearchRecipe($searchName)
{
	if ($searchName == null)
	{
		return;
	}

	$d = new Database();

	$d->ExecSql(sprintf("SELECT * FROM cbTitle WHERE UPPER(title) LIKE UPPER('%%%s%%')", strtoupper($searchName)));

	if ($d->GetRowCount() > 0)
	{
		printf("<tr><td>Search Results</td></tr>\r\n");

		while($row = $d->FetchRow())
		{
			printf("<tr><td><a href=\"index.php?q=%s\">%s,%s</a></td></tr>", $row["title"], $row["title"],  $row["author"]);
		}
	}
}

function SearchIngredient($searchName)
{
	if ($searchName == null)
	{
		return;
	}

	$d = new Database();

	$d->ExecSql(sprintf("SELECT * FROM cbIngredients i, cbTitle t WHERE UPPER(name) LIKE ('%%%s%%') AND t.title=i.title", strtoupper($searchName)));

	if ($d->GetRowCount() > 0)
	{
		printf("<tr><td>Search Results</td></tr>\r\n");

		while($row = $d->FetchRow())
		{
			printf("<tr><td><a href=\"index.php?q=" . $row["title"] . "\">" . $row["title"] . "," . $row["author"] . "</a></td></tr>");
		}
	}
}

function SearchAuthor($searchName)
{
	if ($searchName == null)
	{
		return;
	}

	$d = new Database();

	$d->ExecSql(sprintf("SELECT * FROM cbTitle WHERE UPPER(author) LIKE ('%%%s%%')", strtoupper($searchName)));

	if ($d->GetRowCount() > 0)
	{
		printf("<tr><td>Search Results</td></tr>\r\n");

		while($row = $d->FetchRow())
		{
			printf("<tr><td><a href=\"index.php?q=" . $row["title"] . "\">" . $row["title"] . "," . $row["author"] . "</a></td></tr>");
		}
	}
}

function WriteAddForm()
{
	printf("<td class=\"page\">\r\n");
	printf("<form name=\"addForm\"  method=\"post\" action=\"index.php\">\r\n");
	printf("<table>\r\n");
	printf("<tr><td colspan=\"2\">Title</td><td>Author</td></tr>\r\n");
	printf("<tr><td colspan=\"2\">\r\n");
	printf("<input type=\"text\" name=\"title\" class=\"inputText\" value=\"\"/></td>\r\n");
	printf("<td><input type=\"text\" name=\"author\" class=\"inputText\" value=\"\"/></td>\r\n");
	printf("</tr>\r\n");
	printf("<tr><td colspan=\"3\">Ingredients</td></tr>\r\n");

	for($row = 0;$row < 6;$row++)
	{
		printf("<tr>\r\n");

		for($col = 0;$col < 3;$col++)
		{
			printf("<td><input type=\"text\" name=\"ingredient" . sprintf("%02d%02d", $row, $col) . "\" class=\"inputText\" value=\"\"/></td>\r\n");
		}

		printf("</tr>\r\n");
	}

	printf("<tr><td colspan=\"3\">Steps</td></tr>\r\n");

	printf("<tr>\r\n");
	printf("<td colspan=\"3\"><textarea name=\"steps\"></textarea></td>\r\n");
	printf("</tr>\r\n");

	printf("<tr><td>\r\n");
	printf("<input type=\"submit\" name=\"addRecipe\"    value=\"Add\"    class=\"button\" />\r\n");
	printf("<input type=\"submit\" name=\"resetRecipe\"  value=\"Reset\"  class=\"button\" />\r\n");
	printf("</td></tr>\r\n");
	printf("</table>\r\n");
	printf("</form>\r\n");
	printf("</td>\r\n");
}

function WriteUpdateForm($selection)
{
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
				$steps = $row["text"];
			}
		}
	}

	printf("<td class=\"page\">\r\n");
	printf("<form name=\"updateForm\"  method=\"post\" action=\"index.php?s=" . $title . "\">\r\n");
	printf("<table>\r\n");
	printf("<tr><td colspan=\"2\">Title</td><td>Author</td></tr>\r\n");
	printf("<tr><td colspan=\"2\">\r\n");
	printf("<input type=\"text\" name=\"title\" class=\"inputText\" value=\"" . $title . "\"/></td>\r\n");
	printf("<td><input type=\"text\" name=\"author\" class=\"inputText\" value=\"" . $author . "\"/></td>\r\n");
	printf("</tr>\r\n");
	printf("<tr><td colspan=\"3\">Ingredients</td></tr>\r\n");

	$c = 0;

	for($row = 0;$row < 6;$row++)
	{
		printf("<tr>\r\n");

		for($col = 0;$col < 3;$col++)
		{
			if(($c < count($ingredients)) && (count($ingredients) > 0))
			{
				printf("<td><input type=\"text\" name=\"ingredient" . sprintf("%02d%02d", $row, $col) . "\" class=\"inputText\" value=\"" . $ingredients[$c] . "\"/></td>\r\n");
			}
			else
			{
				printf("<td><input type=\"text\" name=\"ingredient" . sprintf("%02d%02d", $row, $col) . "\" class=\"inputText\" value=\"\"/></td>\r\n");
			}

			$c++;
		}

		printf("</tr>\r\n");
	}

	printf("<tr><td colspan=\"3\">Steps</td></tr>\r\n");

	printf("<tr>\r\n");

	if($steps != null)
	{
		printf("<td colspan=\"3\"><textarea name=\"steps\">" . $steps . "</textarea></td>\r\n");
	}
	else
	{
		printf("<td colspan=\"3\"><textarea name=\"steps\"></textarea></td>\r\n");
	}

	printf("</tr>\r\n");

	printf("<tr><td>\r\n");
	printf("<input type=\"submit\" name=\"updateRecipe\" value=\"Update\" class=\"button\" />\r\n");
	printf("<input type=\"submit\" name=\"deleteRecipe\" value=\"Delete\" class=\"button\" />\r\n");
	printf("</form>\r\n");
	printf("<form name=\"printForm\"  method=\"post\" target=\"_blank\" action=\"print.php?s=" . $title . "\">\r\n");
	printf("<input type=\"submit\" name=\"printRecipe\"  value=\"Print\"  class=\"button\" />\r\n");
	printf("</form>");
	printf("</td></tr>");
	printf("</table>\r\n");
	printf("</td>\r\n");
}
?>
</tr>
</table>

</body>

</html>