				<h1>Mod List</h1>
				<div id="mods">
<?php
/**
 * Translates a number to a short alhanumeric version
 *
 * Translated any number up to 9007199254740992
 * to a shorter version in letters e.g.:
 * 9007199254740989 --> PpQXn7COf
 *
 * specifiying the second argument true, it will
 * translate back e.g.:
 * PpQXn7COf --> 9007199254740989
 *
 * this function is based on any2dec && dec2any by
 * fragmer[at]mail[dot]ru
 * see: http://nl3.php.net/manual/en/function.base-convert.php#52450
 *
 * If you want the alphaID to be at least 3 letter long, use the
 * $pad_up = 3 argument
 *
 * In most cases this is better than totally random ID generators
 * because this can easily avoid duplicate ID's.
 * For example if you correlate the alpha ID to an auto incrementing ID
 * in your database, you're done.
 *
 * The reverse is done because it makes it slightly more cryptic,
 * but it also makes it easier to spread lots of IDs in different
 * directories on your filesystem. Example:
 * $part1 = substr($alpha_id,0,1);
 * $part2 = substr($alpha_id,1,1);
 * $part3 = substr($alpha_id,2,strlen($alpha_id));
 * $destindir = "/".$part1."/".$part2."/".$part3;
 * // by reversing, directories are more evenly spread out. The
 * // first 26 directories already occupy 26 main levels
 *
 * more info on limitation:
 * - http://blade.nagaokaut.ac.jp/cgi-bin/scat.rb/ruby/ruby-talk/165372
 *
 * if you really need this for bigger numbers you probably have to look
 * at things like: http://theserverpages.com/php/manual/en/ref.bc.php
 * or: http://theserverpages.com/php/manual/en/ref.gmp.php
 * but I haven't really dugg into this. If you have more info on those
 * matters feel free to leave a comment.
 * 
 * @author    Kevin van Zonneveld <kevin@vanzonneveld.net>
 * @author    Simon Franz
 * @author    Deadfish
 * @copyright 2008 Kevin van Zonneveld (http://kevin.vanzonneveld.net)
 * @license   http://www.opensource.org/licenses/bsd-license.php New BSD Licence
 * @version   SVN: Release: $Id: alphaID.inc.php 344 2009-06-10 17:43:59Z kevin $
 * @link      http://kevin.vanzonneveld.net/
 * 
 * @param mixed   $in      String or long input to translate
 * @param boolean $to_num  Reverses translation when true
 * @param mixed   $pad_up  Number or boolean padds the result up to a specified length
 * @param string  $passKey Supplying a password makes it harder to calculate the original ID
 * 
 * @return mixed string or long
 */
function alphaID($in, $to_num = false, $pad_up = false, $passKey = null)
{
    $index = "abcdefghijklmnopqrstuvwxyz0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    if ($passKey !== null) {
        // Although this function's purpose is to just make the
        // ID short - and not so much secure,
        // with this patch by Simon Franz (http://blog.snaky.org/)
        // you can optionally supply a password to make it harder
        // to calculate the corresponding numeric ID
        
        for ($n = 0; $n<strlen($index); $n++) {
            $i[] = substr( $index,$n ,1);
        }
 
        $passhash = hash('sha256',$passKey);
        $passhash = (strlen($passhash) < strlen($index))
            ? hash('sha512',$passKey)
            : $passhash;
 
        for ($n=0; $n < strlen($index); $n++) {
            $p[] =  substr($passhash, $n ,1);
        }
        
        array_multisort($p,  SORT_DESC, $i);
        $index = implode($i);
    }
 
    $base  = strlen($index);
 
    if ($to_num) {
        // Digital number  <<--  alphabet letter code
        $in  = strrev($in);
        $out = 0;
        $len = strlen($in) - 1;
        for ($t = 0; $t <= $len; $t++) {
            $bcpow = bcpow($base, $len - $t);
            $out   = $out + strpos($index, substr($in, $t, 1)) * $bcpow;
        }
 
        if (is_numeric($pad_up)) {
            $pad_up--;
            if ($pad_up > 0) {
                $out -= pow($base, $pad_up);
            }
        }
        $out = sprintf('%F', $out);
        $out = substr($out, 0, strpos($out, '.'));
    } else { 
        // Digital number  -->>  alphabet letter code
        if (is_numeric($pad_up)) {
            $pad_up--;
            if ($pad_up > 0) {
                $in += pow($base, $pad_up);
            }
        }
 
        $out = "";
        for ($t = floor(log($in, $base)); $t >= 0; $t--) {
            $bcp = bcpow($base, $t);
            $a   = floor($in / $bcp) % $base;
            $out = $out . substr($index, $a, 1);
            $in  = $in - ($a * $bcp);
        }
        $out = strrev($out); // reverse
    }
 
    return $out;
}
?>
<?php
			$this->dbConnect();
			$this->dbSelect();
			$result = mysql_query("SELECT * FROM mods");
			if(isset($_GET["file"]))
			{
				$_GET["file"] = alphaID($_GET["file"],true,5);
				$result2 = mysql_query("SELECT * FROM mods WHERE id='{$_GET["file"]}'");
			}
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
				
				$rowsperpage = 5;
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
					$temp = alphaID($row["id"],false,5);
					echo <<<EOF
					<div class="mod">
						<div style="height:auto !important;height:100px;min-height:100px;">
							<div class="ModPicture"><img src="media/mods/{$temp}/{$temp}.{$row["mpicture"]}" /></div>
							<div class="ModName"><a href="?file={$temp}">{$row["mname"]}</a> <span class="ModAuthor">by {$row["aname"]}</span></div>
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
				$temp = alphaID($row["id"],false,5);
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
							$("#moddownload").blend();
						});
					</script>
					<div class="mod">
						<div style="height:auto !important;height:100px;min-height:100px;">
							<div class="ModPicture"><img src="media/mods/{$temp}/{$temp}.{$row["mpicture"]}" /></div>
							<div class="ModName"><a href="?file={$temp}">{$row["mname"]}</a> <span class="ModAuthor">by {$row["aname"]}</span></div>
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
									<a id="moddownload" href="media/mods/{$temp}/{$row["mfile"]}.{$row["mext"]}"></a>
								</div>
						</div>
					</div>
EOF;
				//echo basename($row["mfile"].$row["mext"],".".$row["mext"]);
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