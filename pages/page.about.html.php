Just a dummy page with all of the miscellaneous pages.
<ul>
<?php
$array = array("login.php", "logout.php", "userlist", "admin.themes", "plugins", "register");
foreach($array as $l) {
	echo "<li><a href='{$this->getScriptUrl()}".$l."' >".$l."</a></li>";
}
?>
</ul>