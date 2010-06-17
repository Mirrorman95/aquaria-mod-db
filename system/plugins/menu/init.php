<?php
class MenuPlugin extends Plugin
{
	protected static $__Plugin;
	protected $Name = "Menu Plugin";
	protected $Description = "This goes ahead and generates a menu list for themes.";
	protected $Version = "1.0.0";
	public $default = "Home";
	function getPlugin()
	{
		parent::$test=new self;
		return parent::getPlugin(self::$__Plugin);
	}
	function s()
	{
		return self::getPlugin();
	}
	function getMenu($current2 = "", $prefix = "<li class=\"[class]\">", $suffix = "</li>")
	{
		global $InstallPath;
		include("pages/links.php");
		foreach($menu as $t => $l) {
		$current = "";
			if($t == $this->default)
				$current = " " . $current2;
			$l = str_ireplace("[baseurl]", $InstallPath, $l);
			$l = str_ireplace("[class]", $t.$current, $prefix) .
				"<a href=\"{$l}\">{$t}</a>" .
				str_ireplace("[class]", $t, $suffix);
			//echo "<li><a href='".$l."' >".$t."</a></li>";
			echo($l);
		}
	}
	function SetPage($page, &$c)
	{
		include("pages/links.php");
		$temp = "hi";
		//$c = array_merge(array($page->getControllerName()."\n"),$c);
		foreach($info as $link => $files) {
			if(in_array($page->getControllerName(), $files))
				$this->default = $link;
		//$c = array_merge(array($link." - ".join(",",$files)."\n"),$c);
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