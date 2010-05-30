{no-template compression}
<?xml version="1.0"?>
<!DOCTYPE mods [
<!ELEMENT mods (mod)>
<!ELEMENT mod (name,author,image,file,description)>
<!ELEMENT name (#PCDATA)>
<!ELEMENT author (#PCDATA)>
<!ELEMENT image (#PCDATA)>
<!ELEMENT file (#PCDATA)>
<!ELEMENT description (#PCDATA)>
]>
<mods>
<?php
$this->dbConnect();
$this->dbSelect();
$root = $this->getBasePath();
$result = mysql_query("SELECT * FROM mods");
function nl2br_revert($string) { 
    return preg_replace('`<br(?: /)?>([\\n\\r])`', '$1', $string); 
}
if($result && mysql_num_rows($result))
{
	$continue = true;
	$sql = "SELECT COUNT(*) FROM mods";
	$result2 = mysql_query($sql) or trigger_error("SQL", E_USER_ERROR);
	$r = mysql_fetch_row($result2);
	$numrows = $r[0];
	
	if (isset($_GET['num']) && is_numeric($_GET['num'])) {
		$rowsperpage = $_GET['num'];
	} else {
		$rowsperpage = 10;
	}
	$totalpages = ceil($numrows / $rowsperpage);
	
	if (isset($_GET['p']) && is_numeric($_GET['p'])) {
	   $currentpage = (int) $_GET['p'];
	} else if(isset($_GET['p']) && $_GET['p'] == "list") {
		$continue = false;
		echo <<<NUMBERS
	<mod>
		<name>{$numrows}</name>
	</mod>

NUMBERS;
	} else {
	   $currentpage = 1;
	}

	if ($continue && $currentpage > $totalpages) {
	   $currentpage = $totalpages;
	}
	if ($continue && $currentpage < 1) {
	   $currentpage = 1;
	}
	if ($continue)
	{
		$offset = ($currentpage - 1) * $rowsperpage;

		$sql = "SELECT * FROM mods LIMIT $offset, $rowsperpage";
		$result = mysql_query($sql) or trigger_error("SQL", E_USER_ERROR);
		while ($row = mysql_fetch_assoc($result)) {
			$row["mdesc"] = nl2br_revert($row["mdesc"]);
			echo <<<EOF
	<mod>
		<name>{$row["mname"]}</name>
		<author>{$row["aname"]}</author>
		<image>{$root}{$row["mfile"]}.{$row["mpicture"]}</image>
		<file>{$root}{$row["mfile"]}.{$row["mext"]}</file>
		<description>
{$row["mdesc"]}
		</description>
	</mod>

EOF;
		}
	}
}
?>
</mods>