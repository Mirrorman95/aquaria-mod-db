			<h1>Mod List</h1>
			<?php
			mysql_connect("localhost", "aquaria", "data");
			mysql_select_db("aqmoddb");
			$result = mysql_query("SELECT * FROM mods");
			if($result && mysql_num_rows($result))
			{
			$i=0;
				while($row = mysql_fetch_assoc($result))
				{
					if($i!=0)
						print("<hr />");
					$i = 1;
					echo <<<EOF
			<div style="height:auto !important;height:100px;min-height:100px;">
			<div class="ModPicture"><img src="media/mods/{$row["mfile"]}.{$row["mpicture"]}" /></div>
			<div class="ModName">{$row["mname"]}</div>
			<div class="ModDescription">{$row["mdesc"]}</div>
			</div>
EOF;
				}
				?>
				<?php
			}
			else
			{
				?>
			<script type="text/javascript">
				$(document).ready(function(){
					//Examples of how to assign the ColorBox event to elements
					$.fn.colorbox({width:"50%", inline:true, href:"#NoMods", open:true});
				});
			</script>
			<div style="display:none">
				<div id="NoMods">It appears that either the database is down, or there are no mods in the database.<br />Sorry for the inconvenience.</div>
			</div>
				<?php
			}