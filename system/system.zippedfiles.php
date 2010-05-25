{no-template compression}
<?php
//$file = 'monkey.gif';
$array_temp[] = $this->Function;
$file = "media\\".implode("\\",array_merge($array_temp,$this->Parameters));
//echo $file;
if (file_exists($file)) {
    //header('Content-Description: File Transfer');
    //header('Content-Type: application/octet-stream');
    //header('Content-Disposition: attachment; filename='.basename($file));
    //header('Content-Transfer-Encoding: binary');
    //header('Expires: 0');
    //header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
    //header('Pragma: public');
    //header('Content-Length: ' . filesize($file));
    //ob_clean();
    //flush();
	$periods = explode(".",basename($file));
	$set = false;
	if(count($periods)-1 > 0 && $periods[count($periods)-1] == "css")
	{
		header('Content-Type: text/css');
		$set = true;
	}
	if(count($periods)-1 > 0 && $periods[count($periods)-1] == "js")
	{
		header('Content-Type: application/x-javascript');
		$set = true;
    }
	if($set == true)
		readfile($file);
	elseif($set == false && (count($periods)-1 > 0 && $periods[count($periods)-1] == "php"))
		eval("?>".file_get_contents($file));
	else
		die("An error has occured!");
    exit;
}