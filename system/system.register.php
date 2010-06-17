<?php
if(in_array("Auth", pluginManager::getPM()->loadedPlugins()))
{
	if(!AuthPlugin::isUser())
		AuthPlugin::RegisterTable();
	else
		echo "You are already a registered user!";
}