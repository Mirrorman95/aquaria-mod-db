<?xml version="1.0" encoding="UTF-8"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<title><?php echo $this->title("site"); ?></title>
	<link type="text/css" href="<?php echo $this->themePath() ?>theme.css" rel="stylesheet" media="screen" />
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
	<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.2/jquery-ui.min.js"></script>
	<script src="<?php echo $this->themePath() ?>js/aquaria.js"></script>
</head>
<body>
	<div id="header"><div>
		<h1><a href="<?php echo $this->getBasePath(); ?>">Aquaria Mod&#124;Database</a></h1>
		<ul id="menu">
			<?php MenuPlugin::getPlugin()->getMenu("current"); ?>
		<ul>
	</div></div>
	<div id="page">
		<div id="content">
			<div id="content-tape"></div>
			<div id="body">
				<?php $this->Parse(); ?>
			</div>
		</div>
	</div>
	<div id="footer">
		<div id="footer-angler"></div>
		<div id="footer-body">
			<div id="footer-menu">
				<a href="<?php echo $this->getBasePath(); ?>">Home</a> &#124; 
				<a href="<?php echo $this->getBasePath(); ?>mods.html">Download</a> &#124; 
				<a href="<?php echo $this->getBasePath(); ?>postmod.html">Submit</a> &#124; 
				<a href="<?php echo $this->getBasePath(); ?>about.html">About</a><br />
				<a href="<?php echo $this->getBasePath(); ?>contact.html">Contact</a> &#124; 
				<a href="<?php echo $this->getBasePath(); ?>legal.html">Legal</a> &#124; 
				<a href="http://ssd.doesntexist.com:7777/" class="frosty">Frosty</a> &#124; 
				<a href="http://surrealness.org" class="lady">Lady</a> &#124; 
				<a href="http://bit-blot.com" class="bitblot">Bit-Blot</a>
			</div>
			<div id="footer-copyright">
				<span class="frosty">Powered by SSD Doesn't Exist</span> &#124; 
				<span class="lady">Themed by Surrealness</span> &#124; 
				<span class="copyright">&copy; 2010</span>
			</div>
		</div>
	</div>
</body>
</html>