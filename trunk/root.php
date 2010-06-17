<?php
include("config.php");
function callback($buffer, $mode)
{
	$load = pluginManager::getPM()->loadedPlugins();
	$CSS = "";
	$FOOT = "";
	foreach($load as $loaded)
	{
		$loaded=$loaded."Plugin";
		$Stylesheets = $loaded::getPlugin()->getCSS();
		foreach($Stylesheets as $stylesheet)
		{
			if($stylesheet != "")
				$CSS .= <<<EOF

		{$stylesheet}
EOF;
		}
		/*$footer = $loaded::getPlugin()->getFooter();
		foreach($Stylesheets as $stylesheet)
		{
			if($stylesheet != "")
				$CSS .= <<<EOF

		{$stylesheet}
EOF;
		}*/
	}
	$output = str_ireplace("<plugins content=\"headers\" />", $CSS, $buffer);
	$output = str_ireplace("<plugins content=\"footers\" />", $FOOT, $output);
	return ob_gzhandler($output, $mode);
}
function callback2($buffer, $mode)
{
	$load = pluginManager::getPM()->loadedPlugins();
	$CSS = "";
	foreach($load as $loaded)
	{
		$loaded=$loaded."Plugin";
		$Stylesheets = $loaded::getPlugin()->getCSS();
		foreach($Stylesheets as $stylesheet)
		{
			if($stylesheet != "")
				$CSS .= <<<EOF
		{$stylesheet}
EOF;
		}
	}
	$output = str_ireplace("<plugins />", $CSS, $buffer);
	return $output;
}

$content = file($this->ic());
//First line: $content[0];
$content[0] = $content[0]."\n";
$string = "";
if(preg_match("/^{([- a-z0-9]*)}\r?\n+\s*/mi", $content[0]))
	$string = preg_replace("/^{([a-z0-9 -]*)}\r?\n+\s*/mi", "$1", $content[0]);
$templateExists = preg_match("/(no-template)/i",$string);
$compressionExists = preg_match("/(compression)/i",$string);
if(in_array("Menu", pluginManager::getPM()->loadedPlugins()))
{
	MenuPlugin::s()->SetPage($this, $content);
}
if(preg_match("/^{([- a-z0-9]*)}\r?\n+\s*/mi", $content[0]))
	unset($content[0]);
if($Compression)
	$compressionExists = !$compressionExists;
if($templateExists)
{
	if($compressionExists)
	{
		ob_start('callback');
		//echo "Compressing";
	}
	else
	{
		ob_start('callback2');
	}
	eval("?>".implode("", $content));
	ob_end_flush();
}
else
{
	if($compressionExists)
	{
		ob_start('callback');
	}
	else
	{
		ob_start('callback2');
	}
	$this->ThemeParser(implode("", $content));
	ob_end_flush();
}