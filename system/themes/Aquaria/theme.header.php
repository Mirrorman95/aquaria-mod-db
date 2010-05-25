<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title><?php print($this->title("site")); ?></title>
		<link type="text/css" media="screen" rel="stylesheet" href="<?php echo $this->getBasePath() ?>media/colorbox.css.php" />
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
		<script type="text/javascript" src="<?php echo $this->getBasePath() ?>media/jquery.colorbox-min.js"></script>
		<script type="text/javascript">
			$(document).ready(function(){
				//Examples of how to assign the ColorBox event to elements
				$("a[rel='cbox_view']").colorbox({rel:'nofollow'});
			});
		</script>
		<link type="text/css" media="screen" rel="stylesheet" href="<?php echo $this->themePath() ?>media/main.css.php" />
	</head>
	<body>
		<script type="text/Javascript">
			$(document).ready(function(){
				$(".error").colorbox({width:"50%", inline:true, href:"#ERROR"});
			});
		</script>
		<div style="display:none">
			<div id="ERROR">
				Sorry, this feature hasn't been implemented yet!
			</div>
		</div>
		<div id="content">
			<div class="sideimg left"></div>
			<div class="sideimg bottom"></div>
			<div class="sideimg corners L"></div>
			<div class="sideimg corners R"></div>
			<div class="sideimg right"></div>
			<div class="header"></div>