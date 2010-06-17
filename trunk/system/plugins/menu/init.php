<?php
class MenuPlugin extends Plugin
{
	protected static $__Plugin;
	protected $Name = "Menu Plugin";
	protected $Description = "This goes ahead and generates a menu list for themes.";
	protected $Version = "1.0.0";
	function getPlugin()
	{
		parent::$test=new self;
		return parent::getPlugin(self::$__Plugin);
	}
	function s()
	{
		self::getPlugin();
	}
	function getMenu($current, $prefix = "<li class=\"[class]\">", $suffix = "</li>")
	{
		include("pages/links.php");
		foreach($menu as $t => $l) {
			$l = str_ireplace("[baseurl]", $this->getScriptUrl(), $l);
			$l = str_ireplace("[class]", $t, $prefix) .
				"<a href=\"{$l}\">{$t}</a>" .
				str_ireplace("[class]", $t, $suffix);
			//echo "<li><a href='".$l."' >".$t."</a></li>";
			echo($l);
		}
	}
}



/*
$href["Home"] = "[baseurl]";
$href["Dummy"] = "[baseurl]dummy";
$href["Forum"] = "[baseurl]forum";
<li class="home current"><a href="<?php echo $this->getBasePath(); ?>">Home</a></li>

$menu["Home"] = "[baseurl]";

include("pages/links.php");
foreach($href as $t => $l) {
	$l = str_ireplace("[baseurl]", $this->getScriptUrl(), $l);
	echo "<li><a href='".$l."' >".$t."</a></li>";
}

*/