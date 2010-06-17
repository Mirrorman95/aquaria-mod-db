<?php
if(in_array("Auth", pluginManager::getPM()->loadedPlugins()))
{
	AuthPlugin::UserLogout();
}