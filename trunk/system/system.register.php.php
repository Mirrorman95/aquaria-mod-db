{compression no-template}
<?php
if(in_array("Auth", pluginManager::getPM()->loadedPlugins()) && (isset($_GET['username']) && isset($_GET['email']) && isset($_GET['pass'])))
{
	function validEmail($email)
	{
		// http://forum.codecall.net/php-tutorials/1751-php-tutorial-email-verification.html
		$email = htmlspecialchars(stripslashes(strip_tags($email))); //parse unnecessary characters to prevent exploits 

		if ( preg_match( '/[a-z||0-9]@[a-z||0-9].[a-z]/', $email ) ) { //checks to make sure the email address is in a valid format 
			$domain = explode( "@", $email ); //get the domain name 

			if ( @fsockopen ($domain[1],80,$errno,$errstr,3)) { 
				//if the connection can be established, the email address is probabley valid 
				return true; 
				/* 

				GENERATE A VERIFICATION EMAIL 

				*/ 
			} else { 
				return "fail"; //if a connection cannot be established return false 
			} 

		} else { 
			return false; //if email address is an invalid format return false 
		} 
	}
	$failed = false;
	function er($string, $color = "red")
	{
		$red = "#FF5254";
		$green = "#52FF63";
		$color2 = $$color;
		$pre = <<<EOF
<div style="border: 3px solid {$color}; background-color: {$color2};padding:3px;text-align:center;color:black;margin-top:5px;">
EOF;
		$suf = <<<EOF
</div>
EOF;
		echo $pre.$string.$suf;
	}
	if($_GET['username'] == "")
	{
		er("The username feild cannot be left blank!");
	}
	elseif(AuthPlugin::getPlugin()->UserExists("user", $_GET['username']))
	{
		$failed = true;
		$temp = strip_tags($_GET['username']);
		er("{$temp} already exists!");
	}
	if($_GET['email'] == "")
	{
		er("Please enter in an email!");
	}
	elseif(AuthPlugin::getPlugin()->UserExists("email", $_GET['email']))
	{
		$failed = true;
		er("That email address is already registered!");
	}
	elseif(validEmail($_GET['email']) == "fail")
	{
		er("Could not establish a connection to the email server.");
	}
	elseif(validEmail($_GET['email']))
	{
		$failed = true;
		er("Invalid email!");
	}
	if($_GET['pass'] == "")
	{
		$failed = true;
		er("The password value cannot be left blank!");
	}
	elseif(strlen($_GET['pass'])<6)
	{
		$failed = true;
		er("The password is too short!");
	}
	elseif($_GET['pass'] != $_GET['cpass'])
	{
		$failed = true;
		er("Both passwords need to be the same!");
	}
	if(!$failed)
	{
		er("Validated Successfully!", "green");
		if(AuthPlugin::getPlugin()->RegisterUser($_GET['username'], $_GET['email'], $_GET['pass']) && validEmail($_GET['email']) != "fail")
			er("Registered!", "green");
		elseif(validEmail($_GET['email']) == "fail")
			er("Registered, but a connection to the email server could not be established! :(", "green");
		else
			er("An error occured while registering. Sorry!");
	}
}