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
if(!empty($_FILES['zip']) && isset($_POST['nom']) && $_POST['nom'] != "")
{
	$file = $_FILES['zip'];
	$allowedExtensions = array("zip","rar","tar","gz","bz2","7z"); 
	if ($file['tmp_name'] > '') { 
      if (!in_array(end(explode(".", strtolower($file['name']))), $allowedExtensions)) { 
       die('<script type="text/javascript">$(document).ready(function(){$.fn.colorbox({width:"50%", html:"<b>Error!<br />'.$file['name'].' is not an archive file.</b>", open:true});});</script>'); 
      }
	}
	$con = $this->dbConnect();
	$this->dbSelect();
	$result = mysql_query("SHOW TABLE STATUS LIKE 'mods'");
	if($result && mysql_num_rows($result))
	{
		$temp = mysql_fetch_assoc($result);
		$max_id = $temp['Auto_increment'];
	}
	else
		die('<script type="text/javascript">$(document).ready(function(){$.fn.colorbox({width:"50%", html:"<b>Error! Cannot contact the database.</b>", open:true});});</script>');
	$temp = pathinfo($_FILES['zip']['name']);
	$_FILES['zip']['name'] = str_replace(' ', '', basename($_FILES['zip']['name'],".".$temp['extension'])).".".$temp['extension'];
	$zipname = str_replace(' ', '', basename($_FILES['zip']['name'],".".$temp['extension']));
	$pic = null;
	$mfile = alphaID($max_id,false,5);
	mkdir(getcwd()."/media/mods/".$mfile."/");
	if(!empty($_FILES['pic']))
	{
		$file = $_FILES['zip'];
		$allowedExtensions = array("zip","rar","tar","gz","bz2","7z"); 
		if ($file['tmp_name'] > '') { 
			if (in_array(end(explode(".", strtolower($file['name']))), $allowedExtensions)) { 
				$i = getimagesize($_FILES['pic']['tmp_name']);
				if($i[0]<=100 && $i[1] <= 100)
				{
					$temp2 = pathinfo($_FILES['pic']['name']);
					$_FILES['pic']['name'] = alphaID($max_id,false,5).".".$temp2['extension'];
					move_uploaded_file($_FILES['pic']['tmp_name'], getcwd()."/media/mods/{$mfile}/".$_FILES['pic']['name']);
					$pic = $temp2['extension'];	
				}
			}
		}
	}
	$_POST["nom"] = addslashes($_POST["nom"]);
	$_POST["aname"] = addslashes($_POST["aname"]);
	$_POST["desc"] = nl2br(strip_tags(addslashes($_POST["desc"])),true);
	$query = "INSERT INTO mods (mname, aname, mpicture, mfile, mdesc, mext) VALUES (\"{$_POST["nom"]}\", \"{$_POST["aname"]}\", \"{$pic}\", \"{$zipname}\", \"{$_POST["desc"]}\", \"{$temp['extension']}\")";
	//echo $query;
	if(move_uploaded_file($_FILES['zip']['tmp_name'], getcwd()."/media/mods/{$mfile}/".$_FILES['zip']['name']) && mysql_query($query,$con))
	{
		//upload succeeded
		echo '<script type="text/javascript">$(document).ready(function(){$.fn.colorbox({width:"50%", html:"<b>Mod submitted!</b>", open:true});});</script>';
	}
	else
	{
		//upload failed
		echo '<script type="text/javascript">$(document).ready(function(){$.fn.colorbox({width:"50%", html:"<b>Mod upload failed!</b><br />Known reasons why it could fail:<ul><li>Couldn\'t connect to the database</li><li>You forgot to enter in information</li><li>", open:true});});</script>';
	}
}
else
{
?>
<?php } ?>
			<script type="text/javascript">
			function validate_required(field,alerttxt)
			{
				with (field)
				{
					if (value==null||value=="")
					{
						alert(alerttxt);return false;
					}
					else
					{
						return true;
					}
				}
			}

			function validate_form(thisform)
			{
				with (thisform)
				{
					if (validate_required(nom,"Mod must have a name!")==false)
					{nom.focus();return false;}
					if (validate_required(aname,"You know, ever thing has an author, and every author has a NAME!")==false)
					{aname.focus();return false;}
					if (validate_required(zip,"There must be a mod file to be uploaded!")==false)
					{zip.focus();return false;}
					if (validate_required(desc,"Description must be filled out!")==false)
					{desc.focus();return false;}
				}
			}
			</script>
			<h1>Post a Mod</h1>
			<p>Thank you for helping us fill our database with new Aquaria Mods! Please fill out the form below and submit to see your mod in the Mods section of the Mod DB.</p>
			<form enctype="multipart/form-data" action="postmod.html" method="post" id="addmod" onsubmit="return validate_form(this)">
				<table style="margin: 0 auto;">
					<tr>
						<td>
							<label for="nom">Name of the Mod:</label>
						</td>
						<td>
							<input type="text" id="nom" name="nom"></input>
						</td>
					</tr>
					<tr>
						<td>
							<label for="aname">Author Name:</label>
						</td>
						<td>
							<input type="text" id="aname" name="aname"></input>
						</td>
					</tr>
					<tr>
						<td>
							<label for="pic">Picture:</label>
						</td>
						<td>
							<input type="file" id="pic" name="pic"></input>
						</td>
					</tr>
					<tr>
						<td>
							<label for="zip">File (zip):</label>
						</td>
						<td>
							<input type="file" id="zip" name="zip" accept="application/zip"></input>
						</td>
					</tr>
					<tr>
						<td>
							<label for="desc">Description:</label>
						</td>
						<td>
							<textarea id="desc" name="desc"></textarea>
						</td>
					</tr>
					<tr>
						<td colspan="2" style="text-align:center;">
							<input type="submit" value="Submit" />
						</td>
					</tr>
				</table>
			</form>