<?php
if(in_array("Auth", pluginManager::getPM()->loadedPlugins()))
{
	AuthPlugin::getPlugin()->GetUsers(0);
}