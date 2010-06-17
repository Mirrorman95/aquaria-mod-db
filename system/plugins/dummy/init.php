<?php
class DummyPlugin extends Plugin
{
	protected static $__Plugin;
	protected $Name = "Plugin Name";
	protected $Description = "This is a dummy plugin, it does absolutely nothing except correctly works and registers with the site. So if you are a mod developer";
	protected $Version = "1.0.0";
	function getPlugin()
	{
		parent::$test=new self;
		return parent::getPlugin(self::$__Plugin);
	}
}