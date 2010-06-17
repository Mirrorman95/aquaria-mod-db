<?php
if (!isset($_POST["theme"]) && AuthPlugin::isAdmin())
{
	$dirPath = './system/themes/';

	// open the specified directory and check if it's opened successfully 
	if ($handle = opendir($dirPath)) {
	   // keep reading the directory entries 'til the end 
	   while (false !== ($file = readdir($handle))) {
		  if ($file != "." && $file != "..") {
			 if (is_dir("$dirPath/$file")) {
				// found a directory, do something with it? 
				if(file_exists("$dirPath/$file/theme.template.php"))
					echo "[$file]<br>";
			 } else {
				// found an ordinary file 
				//echo "$file<br>";
			 }
		  }
	   }
	   closedir($handle);
	}
}
else
{
	echo "You are not an admin!";
}