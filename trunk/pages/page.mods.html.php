				<h1>Mod List</h1>
				<div id="mods">
<?php
			$this->dbConnect();
			$this->dbSelect();
			$result = mysql_query("SELECT * FROM mods");
			if(isset($_GET["file"]))
				$result2 = mysql_query("SELECT * FROM mods WHERE mfile='{$_GET["file"]}'");
			if(!isset($_GET["file"]) && $result && mysql_num_rows($result))
			{
			$i=0;
				/*while($row = mysql_fetch_assoc($result))
				{
					if($i!=0)
						print("<hr />");
					$i = 1;
					echo <<<EOF
					<div class="mod">
						<div style="height:auto !important;height:100px;min-height:100px;">
							<div class="ModPicture"><img src="media/mods/{$row["mfile"]}.{$row["mpicture"]}" /></div>
							<div class="ModName"><a href="?file={$row["mfile"]}">{$row["mname"]}</a> <span class="ModAuthor">by {$row["aname"]}</span></div>
							<div class="ModDescription">{$row["mdesc"]}</div>
						</div>
					</div>
EOF;
				}*/
				$sql = "SELECT COUNT(*) FROM mods";
				$result2 = mysql_query($sql) or trigger_error("SQL", E_USER_ERROR);
				$r = mysql_fetch_row($result2);
				$numrows = $r[0];
				
				$rowsperpage = 10;
				$totalpages = ceil($numrows / $rowsperpage);
				
				if (isset($_GET['p']) && is_numeric($_GET['p'])) {
				   $currentpage = (int) $_GET['p'];
				} else {
				   $currentpage = 1;
				}

				if ($currentpage > $totalpages) {
				   $currentpage = $totalpages;
				}
				if ($currentpage < 1) {
				   $currentpage = 1;
				}
				$offset = ($currentpage - 1) * $rowsperpage;

				$sql = "SELECT * FROM mods LIMIT $offset, $rowsperpage";
				$result = mysql_query($sql) or trigger_error("SQL", E_USER_ERROR);
				while ($row = mysql_fetch_assoc($result)) {
				   if($i!=0)
						print("<hr />");
					$i = 1;
					echo <<<EOF
					<div class="mod">
						<div style="height:auto !important;height:100px;min-height:100px;">
							<div class="ModPicture"><img src="media/mods/{$row["mfile"]}.{$row["mpicture"]}" /></div>
							<div class="ModName"><a href="?file={$row["mfile"]}">{$row["mname"]}</a> <span class="ModAuthor">by {$row["aname"]}</span></div>
							<div class="ModDescription">{$row["mdesc"]}</div>
						</div>
					</div>
EOF;
				}
				?>
					<div class="pagination">
				<?php
				/******  build the pagination links ******/
				$range = 9;

				if ($currentpage > 1) {
				   echo " <a href='?p=1'>&lt;&lt;</a> ";
				   $prevpage = $currentpage - 1;
				   echo " <a href='?p=$prevpage'>&lt;</a> ";
				}

				// loop to show links to range of pages around current page
				for ($x = ($currentpage - $range); $x < (($currentpage + $range) + 1); $x++) {
				   // if it's a valid page number...
				   if (($x > 0) && ($x <= $totalpages)) {
					  // if we're on current page...
					  if ($x == $currentpage) {
						 // 'highlight' it but don't make a link
						 echo " [<b>$x</b>] ";
					  // if not current page...
					  } else {
						 // make it a link
						 echo " <a href='?p=$x'>$x</a> ";
					  } // end else
				   } // end if 
				} // end for
								 
				// if not on last page, show forward and last page links        
				if ($currentpage != $totalpages) {
				   // get next page
				   $nextpage = $currentpage + 1;
					// echo forward link for next page 
				   echo " <a href='?p=$nextpage'>&gt;</a> ";
				   // echo forward link for lastpage
				   echo " <a href='?p=$totalpages'>&gt;&gt;</a> ";
				} // end if
				/****** end build pagination links ******/
				// from http://www.phpfreaks.com/tutorial/basic-pagination
				?>
				</div>
				<?php
			}
			elseif(isset($_GET["file"]) && $result2 && mysql_num_rows($result2))
			{
				$row = mysql_fetch_assoc($result2);
				$zip = new ZipArchive; 
				$zcontent = "";
				if ($zip->open("media/mods/{$row["mfile"]}.zip")) 
				{ 
					 for($i = 0; $i < $zip->numFiles; $i++) 
					 {   
					 if(!preg_match("/(__MACOSX)/",$zip->getNameIndex($i)))
						  $zcontent = $zcontent . '' . $zip->getNameIndex($i) . '<br />'; 
					 } 
				}
				if($zcontent == "")
				{ 
					 $zcontent = 'Error reading the archive! File is not a Zip Archive.'; 
				}
				echo <<<EOF
					<script type="text/javascript">
						$(document).ready(function(){
							$(".files").hide();
							$(".toggle").text("[show]");
							$(".toggle").click(function () { 
							  $(".files").slideToggle('slow', function() {
								// Animation complete.
							  });
							if($(".toggle").html() == "[show]")
								$(".toggle").text("[hide]");
							else
								$(".toggle").text("[show]");
							});
							$("#moddownload").blend({reverse:true});
						});
					</script>
					<div class="mod">
						<div style="height:auto !important;height:100px;min-height:100px;">
							<div class="ModPicture"><img src="media/mods/{$row["mfile"]}.{$row["mpicture"]}" /></div>
							<div class="ModName"><a href="?file={$row["mfile"]}">{$row["mname"]}</a> <span class="ModAuthor">by {$row["aname"]}</span></div>
							<div class="ModDescription">
								{$row["mdesc"]}
								<br /><br />
								<div class="filelist">
									File list <span class="toggle">[hide]</span><hr />
									<div class="files">
										{$zcontent}
									</div>
								</div>
							</div>
								<div id="modbuttons">
									<a id="moddownload" href="media/mods/{$row["mfile"]}.{$row["mext"]}"></a>
								</div>
						</div>
					</div>
EOF;
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
			?>

				</div>