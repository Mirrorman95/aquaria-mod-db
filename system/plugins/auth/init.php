<?php
class AuthPlugin extends Plugin
{
	protected static $__Plugin;
	protected $Name = "Authorization";
	protected $Description = "Allows users to login.";
	protected $Version = "1.0";
	function getPlugin()
	{
		parent::$test=new self;
		return parent::getPlugin(self::$__Plugin);
	}
	function s()
	{
		return self::getPlugin();
	}
	public function GetUser($id)
	{
		$user;
		$result = array("hi");
		DB::Connect($user);
		DB::Select($user);
		DB::Query("SELECT * FROM users WHERE id=".($id+1), $user, $result);
		//print_r($result);
		while($row = mysql_fetch_array($result))
		{
			echo ($row['id'] - 1) . ". " . $row['user'] . " - " . $row['email'];
		}
		DB::Close($user);
	}
	public function UserExists($place, $id)
	{
		$user;
		$result = array("hi");
		DB::Connect($user);
		DB::Select($user);
		$id = mysql_real_escape_string(strip_tags($id));
		DB::Query("SELECT * FROM users WHERE ".$place."='".$id."'", $user, $result);
		//print_r($result);
		if($row = mysql_fetch_array($result))
		{
			return true;
		}
		else
		{
			return false;
		}
		DB::Close($user);
	}
	public function RegisterUser($user2, $email, $password)
	{
		DB::Connect($user);
		DB::Select($user);
		$user2 = mysql_real_escape_string(strip_tags($user2));
		$email = mysql_real_escape_string(strip_tags($email));
		$password = SHA1($password);
		$sql = "INSERT INTO users (id, user, email, password) VALUES (NULL, '".$user2."', '".$email."', '".$password."');";
		DB::Query($sql, $user, $r);
		DB::Close($user);
		if(!$r)return false;
		else return true;
	}
	public function UserLogin($user2, $password)
	{
		//http://www.devarticles.com/c/a/MySQL/Security-and-Sessions-in-PHP/
		$user;
		DB::Connect($user);
		DB::Select($user);
		$user2 = mysql_real_escape_string(strip_tags($user2));
		$password = sha1($password);
		$sql="SELECT user, MD5(UNIX_TIMESTAMP() + user + RAND(UNIX_TIMESTAMP())) sGUID FROM users WHERE user = '{$user2}' AND password = '{$password}';";
		DB::Query($sql, $user, $r);
		if($r)
		{
			$re = mysql_fetch_row($r);
			DB::Query("UPDATE users SET sGUID = '{$re[1]}' WHERE user = '{$re[0]}';", $user, $r);
			setcookie("session_id", $re[1], time()+3600);
			echo "Logged in!";
		}
		DB::Close($user);
	}
	public function UserLogout()
	{
		setcookie("session_id", "", time()-3600);
		echo "Logged out!";
	}
	public function GetUsers($id)
	{
		$user;
		$result = array("hi");
		echo <<<EOF

				<table border="1">
					<tr>
						<td>
							id
						</td>
						<td>
							user
						</td>
						<td>
							email
						</td>
					</tr>
EOF;
		DB::Connect($user);
		DB::Select($user);
		DB::Query("SELECT * FROM users LIMIT ".($id).", 30", $user, $result);
		//print_r($result);
		while($row = mysql_fetch_array($result))
		{
			echo <<<EOF

					<tr>
						<td>
							
EOF;
			echo ($row['id'] - 1);
			echo <<<EOF

						</td>
						<td>
							
EOF;
			echo $row['user'];
			echo <<<EOF

						</td>
						<td>
							
EOF;
			//echo $row['email'];
			echo "*SNIP*";
			echo <<<EOF

						</td>
					</tr>
EOF;
			// . ". " . $row['user'] . " - " . $row['email'];
		}
		DB::Close($user);
		echo <<<EOF

				</table>
EOF;
	}
	public function isAdmin()
	{
		$result=false;
		if(self::isUser())
		{
			$sGUID = $_COOKIE['session_id'];
			DB::Connect($user);
			DB::Select($user);
			$sql = "SELECT level FROM users WHERE sGUID = '{$sGUID}';";
			DB::Query($sql, $user, $r);
			$re = mysql_fetch_array($r, MYSQL_ASSOC);
			if($re['level'] <= 10) {
				$result=true;
			}
			$re = mysql_fetch_row($r);
			DB::Close($user);
		}
		return $result;
	}
	public function isUser()
	{
		$result=false;
		if (isset($_COOKIE['session_id'])) {
			$result=true;
			$sGUID = $_COOKIE['session_id'];
			DB::Connect($user);
			DB::Select($user);
			$sql = "SELECT user FROM users WHERE sGUID = '{$sGUID}';";
			DB::Query($sql, $user, $r);
			if(!mysql_affected_rows($user)) {
				$result=false;
			}
			$re = mysql_fetch_row($r);
			DB::Query("UPDATE users SET sGUID = '{$sGUID}' WHERE user = '{$re[0]}';", $user, $r);
			setcookie("session_id", $sGUID, time()+3600);
			DB::Close($user);
		}
		return $result;
	}
	public function Username($id)
	{
		DB::Connect($user);
		DB::Select($user);
		$sql = "SELECT user FROM users WHERE id = '{$id}';";
		DB::Query($sql, $user, $r);
		$re = mysql_fetch_row($r);
		DB::Close($user);
		return $re[0];
	}
	public function User()
	{
		$result=false;
		$sGUID = $_COOKIE['session_id'];
		DB::Connect($user);
		DB::Select($user);
		$sql = "SELECT * FROM users WHERE sGUID = '{$sGUID}';";
		DB::Query($sql, $user, $r);
		if($r)
		{
			$result = mysql_fetch_array($r, MYSQL_ASSOC);
		}
		DB::Close($user);
		return $result;
	}
	/*****************************************
	***************** Tables *****************
	*****************************************/
	public function RegisterTable()
	{
		echo <<<EOF
				<div class="AuthPlugin">
					<script type="text/javascript">
						$(function() {
							$('#pass').pstrength();
						});
					</script>
					<form>
						<div id="response">
							<!-- Our message will be echoed out here -->
						</div>
						<div class="row">
							<span class="label">
								Username:
							</span>
							<span class="formw">
								<input type="text" size="25" maxlength="20" name="username" id="username" />
							</span>
						</div>
						<div class="row">
							<span class="label">
								Email:
							</span>
							<span class="formw">
								<input type="text" size="25" maxlength="30" name="email" id="email"/>
							</span>
						</div>
						<div class="row">
							<span class="label">
								Password:
							</span>
							<span class="formw">
								<input type="password" size="25" maxlength="30" name="pass" id="pass"/>
							</span>
						</div>
						<div class="row">
							<span class="label">
								Confirm Password:
							</span>
							<span class="formw">
								<input type="password" size="25" maxlength="30" name="cpass" id="cpass"/>
							</span>
						</div>
						<div class="buttons">
							<input type="button" onclick="window.location='index.html';" value="Cancel"/>
							<input type="button" name="submit" id="submit" value="Register" onclick="register()"/>
						</div>
						<div class="spacer">
							&nbsp;
						</div>
					</form>
				</div>
EOF;
	}

	public function LoginBox($size = "tiny")
	{
		$size = strtolower($size);
		switch($size)
		{
			case "large":
				echo <<<EOF
				<div class="AuthPlugin">
					<form action="login.php" method="post">
						<div id="response">
							<!-- Our message will be echoed out here -->
						</div>
						<div class="row">
							<span class="label">
								Username:
								<br />
								<span style="font-size : 10px; color: lightgrey;">
									You know, your screen name and the thing you use to login to this site?
								</span>
							</span>
							<span class="formw">
								<input type="text" size="25" maxlength="20" name="username" id="username" />
							</span>
						</div>
						<div class="row">
							<span class="label">
								Password:
								<br />
								<span style="font-size : 10px; color: lightgrey;">
									Something to keep you account secured and locked up, so that only you have access. Hope it's strong and secure. :)
								</span>
							</span>
							<span class="formw">
								<input type="password" size="25" maxlength="30" name="pass" id="pass"/>
							</span>
						</div>
						<div class="buttons">
							<input type="button" onclick="window.location='index.html';" value="Cancel"/>
							<input type="submit" name="submit" id="submit" value="login" onclick="register()"/>
						</div>
						<div class="spacer">
							&nbsp;
						</div>
					</form>
				</div>
EOF;
			break;
			case "tiny":
				echo <<<EOF
				<div class="AuthPlugin2">
					<form action="login.php" method="post">
						<span class="label">
							User:
						</span>
						<span class="formw">
							<input type="text" size="10" maxlength="20" name="username" id="username" />
						</span>
						<span class="label">
							Pass:
						</span>
						<span class="formw">
							<input type="password" size="10" maxlength="30" name="pass" id="pass"/>
						</span>
						<input type="submit" name="submit" id="submit" value="login" onclick="register()"/>
					</form>
				</div>
EOF;
			break;
		}
	}
	
	public function getCSS()
	{
		$css[] = "<link type=\"text/css\" media=\"screen\" rel=\"stylesheet\" href=\"{$this->siteDir}system/plugins/auth/forms.css\" />";
		$css[] = "<script type=\"text/javascript\" src=\"{$this->siteDir}system/plugins/auth/forms.js\"></script>";
		$css[] = "<script type=\"text/javascript\" src=\"{$this->siteDir}system/plugins/auth/jquery.pstrength-min.1.2.js\"></script>";
		return $css;
	}
}