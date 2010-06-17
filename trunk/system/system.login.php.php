<?php
if(in_array("Auth", pluginManager::getPM()->loadedPlugins()))
{
	if(AuthPlugin::isUser())
	{
		$user = AuthPlugin::User();
		echo AuthPlugin::Username($user['id']);
		echo " is Already Logged in!";
	}
	elseif((isset($_POST["username"]) && isset($_POST["pass"])) && ($_POST["username"] != "" && $_POST["pass"] != ""))
	{
		AuthPlugin::UserLogin($_POST["username"], $_POST["pass"]);
	}
	else
	{
		AuthPlugin::LoginBox("LARGE");
	}
}