<?php
include("config.php");
$dirs = $_SERVER['SCRIPT_NAME'];
global $SiteTitle;
global $CurrentTheme;
global $InstallPath;
class Axial_UrlInterpreter 
{
	var $basePath = "";
	var $inc = '';
	var $dir = '';
      var $Function = '';
    var $commandName = '';
    var $Command;
	var $PARSEDCONTENT;
    var $parameters = array();
	function Axial_UrlInterpreter(){
			$noq =  explode('?', $_SERVER['REQUEST_URI']);
            $requestURI = explode('/', $noq[0]);
            $scriptName = explode('/',$_SERVER['SCRIPT_NAME']);
            $commandArray = array_diff_assoc($requestURI,$scriptName);
            $commandArray = array_values($commandArray);
            $controllerName = $commandArray[0];
            $controllerFunction = @$commandArray[1];
            $parameters = @array_slice($commandArray,2);
			if(count($parameters)-1 != -1 && $parameters[count($parameters)-1] == "")
				unset($parameters[count($parameters)-1]);
            if($controllerName == '' || $controllerName == 'index.html')
                  {
                  $controllerName = 'root';
                  }
		$this->Axial_Command($controllerName,$controllerFunction,$parameters);
	}
	function getCommand(){
		return $this->Command;
	}
	function Dispatch(){
		switch ($this->getControllerName())
			{
			case '': 
				break;
			default: 
				$this->includ();
				break;
		}
	}
	function includ(){
		$controllerName = $this->getControllerName();
		if($this->isSystemController($controllerName) == true || $this->isSystemController($this->Function) == true){
			$this->inc = 'system/system.'.$controllerName.'.php';
		}
		elseif($this->isController($controllerName) == false && $this->isController($this->Function) == false)
		{
			$controllerName = 'error';
			$this->inc = 'system/system.'.$controllerName.'.php';
		}
		elseif($this->isController($this->Function) == true)
		{
			$this->inc = 'pages/page.'.$this->Function.'.php';
		}
		else{
		$this->inc = 'pages/page.'.$controllerName.'.php';}
		$controllerClass = $controllerName."Controller";
		include('root.php');
	}
	function ic(){
		return $this->inc;
	} 
	function Parse(){
		eval("?>".$this->PARSEDCONTENT);
	}
	function CD(){
	$ttt = '../../';
		$requestURI = explode('/', $_SERVER['PHP_SELF']);
		for($i= 1;$i < sizeof($requestURI);$i++){
		if ($requestURI[count($requestURI)-1] != "index.php")
		{
			unset($requestURI[count($requestURI)-1]);
			$ttt .= "../";
		}
		}
		//$ttt = "../";
		if($this->isController($this->getControllerName()) == false && $this->isController($this->Function) == true)
		{
			$ttt = substr($ttt, 0, -3);
		}
		elseif($this->isController($this->getControllerName()) == true)
		{
			$ttt = substr($ttt, 0, -6);
		}
		else
		{
			$ttt = substr($ttt, 0, -6);
		}
		return $ttt;
	}
	function isController($controllerName){
		if(file_exists('pages/page.'.$controllerName.'.php')){return true;}
		else{return false;}
	}
	function isSystemController($controllerName){
		if(file_exists('system/system.'.$controllerName.'.php')){return true;}
		else{return false;}
	}
        
      function Axial_Command($controllerName,$functionName,$parameters){
            $this->Parameters = $parameters;
            $this->Name = $controllerName;
            $this->Function =$functionName;
            }
      function getControllerName()
            {
            return $this->Name;
            }

      function setControllerName($controllerName)
            {
            $this->Name = $controllerName;
            }

      function getFunction()
            {
            return $this->Function;
            }

      function setFunction($functionName)
            {
            $this->Function = $functionName;
            }
        function getParameters()
                {
                return $this->parameters;
                }

      function setParameters($controllerParameters)
            {
            $this->Parameters = $controllerParameters;
            }
	function dir($bool = false)
	{
		$requestURI = explode('/', $_SERVER['PHP_SELF']);
		for($i= 1;$i < sizeof($requestURI);$i++){
		if ($requestURI[count($requestURI)-1] != "index.php")
			unset($requestURI[count($requestURI)-1]);
		if ($bool)
			unset($requestURI[count($requestURI)-1]);
		else
			break;
		}
		$dir = "http://".$_SERVER['HTTP_HOST'];
		for($i= 1;$i < sizeof($requestURI);$i++){
			$dir .= "/".$requestURI[$i];
		}
		return $dir."/";
	}
	function getScriptUrl()
        {
                /*$scriptName = explode('/',$_SERVER['SCRIPT_NAME']);
        	unset($scriptName[sizeof($scriptName)-1]);
		$scriptName = array_values($scriptName);
		return 'http://'.$_SERVER['SERVER_NAME'].implode('/',$scriptName).'/';*/
		return $this->getBasePath();
        }
	function getBasePath()
	{
		return $this->basePath;
	}
	function curPageURL() {
 $pageURL = 'http';
 if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
 $pageURL .= "://";
 if ($_SERVER["SERVER_PORT"] != "80") {
  $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
 } else {
  $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
 }
 return $pageURL;
}
	function title($tl)
	{
		global $SiteTitle;
		switch($tl)
		{
			case "page":
				break;
			case "site":
				return $SiteTitle;
				break;
		}
	}
	function ThemeParser($strToParse) {
		//Todo: add theme parsing here!
		global $CurrentTheme;
		$this->PARSEDCONTENT = $strToParse;
		$Theme = file("system/themes/".$CurrentTheme."/theme.template.php");
		foreach ($Theme as $__Page) {
			$string="";
			if(preg_match("/^{([a-z0-9]*)}\s*$/i", $__Page))
				$string = preg_replace("/^{([a-z0-9]*)}\s*$/i", "$1", $__Page);
			//echo $string."\n";
			if($string != "")
				include("system/themes/".$CurrentTheme."/theme.".$string.".php");
		}
	}
	function themePath()
	{
		global $InstallPath;
		global $CurrentTheme;
		return $InstallPath."system/themes/".$CurrentTheme."/";
	}
}
$urlInterpreter = new Axial_UrlInterpreter();
$urlInterpreter->basePath = $InstallPath;
$BasePath = $urlInterpreter->getBasePath();
$urlInterpreter->Dispatch();