<?php
include("config.php");
global $dbhost;
global $dbuser;
global $dbpass;
global $dbname;
global $InstallPath;
final class pluginManager {
	private static $pluginManager;
	private $__DEFAULT = "Auth, Menu";
	private $loaded;
	private $load;
	function load($string)
	{
		$this->load = explode(",",$string);
		foreach($this->load as $value)
		{
			$value = trim($value);
			$temp = "plugins/".strtolower($value)."/init.php";
			try
			{
				if(include($temp))
					$this->loaded[] = $value;
			}
			catch(Exception $e)
			{
			}
		}
	}
	function loadedPlugins()
	{
		return $this->loaded;
	}
	function loadDefaultPlugins()
	{
		$this->load($this->__DEFAULT);
	}
	function getPM()
	{
		if (is_null (self::$pluginManager))
		{
			self::$pluginManager = new pluginManager ();
		}
		return self::$pluginManager;
	}
}

class Plugin {
	protected $siteDir = "";
	protected $Name;
	protected $Description;
	protected $Version;
	public static $test = "Plugin";
	function getPlugin(&$var1)
	{
		global $InstallPath;
		if (is_null ($var1))
		{
			$var1 = new self::$test;
			//self::$__Plugin = get_class($this);
		}
		if($var1->siteDir == "")$var1->siteDir = $InstallPath;
		return $var1;
	}
	final function getInfo()
	{
		return array($this->Name, $this->Description, $this->Version);
	}
	public function getCSS()
	{
	}
}

final class DB {
	function Connect(&$con)
	{
		global $dbhost;
		global $dbuser;
		global $dbpass;
		$con = mysql_connect($dbhost, $dbuser, $dbpass);
	}
	function Select(&$con)
	{
		global $dbname;
		mysql_select_db($dbname, $con);
	}
	function Query($query, &$con, &$r, $type = "NONE")
	{
		$r = mysql_query($query, $con);
		return $r;
	}
	function Close(&$con)
	{
		mysql_close($con);
	}
}
