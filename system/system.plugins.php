<?php
$load = pluginManager::getPM()->loadedPlugins();
foreach($load as $loaded)
{
	$loaded=$loaded."Plugin";
	echo "				Class: ".$loaded;
	//pluginAuth::getPlugin();
	//print_r(pluginAuth::getPlugin()->getInfo());
	$loaded::getPlugin();
	//print_r($loaded::getPlugin()->getInfo());
	$pluginInfo = $loaded::getPlugin()->getInfo();
	echo <<<EOF

				<table border="1">
					<tr>
						<td>
							Name
						</td>
						<td>
							Description
						</td>
						<td>
							Version
						</td>
					</tr>
					<tr>
						<td>
							{$pluginInfo[0]}
						</td>
						<td>
							{$pluginInfo[1]}
						</td>
						<td>
							{$pluginInfo[2]}
						</td>
					</tr>
				</table>
				
EOF;
	echo "<br />\n";
}
//echo AuthPlugin::getPlugin()->Admin();
//print_r($loaded);
/*
Theme Header needs to contain <PLUGINS>

function callback($buffer)
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
	$output = str_ireplace("<plugins>", $CSS, $buffer);
	ob_gzhandler($output);
}
*/