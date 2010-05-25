<?php
include("config.php");
$content = file($this->ic());
//First line: $content[0];
$content[0] = $content[0]."\n";
$string = "";
if(preg_match("/^{([- a-z0-9]*)}\r?\n+\s*/mi", $content[0]))
	$string = preg_replace("/^{([a-z0-9 -]*)}\r?\n+\s*/mi", "$1", $content[0]);
$templateExists = preg_match("/(no-template)/i",$string);
$compressionExists = preg_match("/(compression)/i",$string);
if(preg_match("/^{([- a-z0-9]*)}\r?\n+\s*/mi", $content[0]))
	unset($content[0]);
if($Compression)
	$compressionExists = !$compressionExists;
if($templateExists)
{
	if($compressionExists)
	{
		ob_start('ob_gzhandler');
		//echo "Compressing";
	}
	eval("?>".implode("", $content));
	if($compressionExists)
	{
		ob_end_flush();
	}
}
else
{
	if($compressionExists)
	{
		ob_start('ob_gzhandler');
	}
	$this->ThemeParser(implode("", $content));
	if($compressionExists)
	{
		ob_end_flush();
	}
}