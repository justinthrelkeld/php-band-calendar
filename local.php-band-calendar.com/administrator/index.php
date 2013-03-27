<?php session_start();
define('__ROOT__', dirname(dirname(__FILE__)));
if(isset($_SESSION['SESS_USERNAME'])) {
		returnheader("/administrator/home.php");
	}
//redirect function
function returnheader($location) {
	$returnheader = header("location: $location");
	return $returnheader;
}

require_once (__ROOT__ . '/config.php');

$errors = array();

if (isset($_POST["iebugaround"])) {
	//fetch posted details
	$uname = trim(htmlentities($_POST['username']));
	$passw = trim(htmlentities($_POST['password']));
	//check username is present
	if (empty($uname)) {
		//echo error message
		$errors[] = "Please input a username";
	}
	//check password was present
	if (empty($passw)) {
		//echo error message
		$errors[] = "Please input a password";
	}
	if (!$errors) {
		//encrypt the password
		$salt = strrev(substr($uname, 0, 2 ));
	        $passw = sha1($passw);
	        $passw = crypt($passw, $salt);
	        $pepper = "%AqZ38aK9a#";
	        $passencrypt = $passw . $pepper;

		//find out if user and password are present
		try {
			$conn = new PDO('mysql:host='.DB_HOST.'; dbname='.DB_NAME, DB_USER, DB_PASSWORD);
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$statement = $conn->prepare("SELECT `id`, `username`, `password` FROM managers WHERE username = :uname AND password = :passencrypt");

			$statement->bindParam(':uname', $uname, PDO::PARAM_STR);
			$statement->bindParam(':passencrypt', $passencrypt, PDO::PARAM_STR);
			
			$statement->execute();
			$total = $statement->rowCount();
			if ($total > 0) {
				while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
					$idsess = stripslashes($row["id"]);
					$username = stripslashes($row["username"]);

					$_SESSION["SESS_USERID"] = $idsess;
					$_SESSION["SESS_USERNAME"] = $username;

					setcookie("userloggedin", $username);
					setcookie("userloggedin", $username, time() + 3600);
					// expires in 1 hour
					//success, login to page
					returnheader("/administrator/home.php");
				}
			} else{
				// Wait 3 seconds to slow down brute force attack
				sleep(3);
				$errors[] = "Username or Password are Incorrect";
			}
		} catch(PDOException $e) {
			//$errors[] = 'Error: ' . $e->getMessage();
			$errors[] = "error(0)";
		} 
	}
} else {
	$uname = "";
}
?>

<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>PHP band calendar Login</title>
</head>
<body>
	<div id="holder">
		<div id="logo">
			<a href="/index.php" title="Go Home">PHP band calendar</a>
		</div>
		<h1>Login Area</h1>
		<form id="login" action="#" method="post">
			<fieldset>
				<legend>
					User Login
				</legend>
				<ul>
					<li>
						<input name="iebugaround" type="hidden" value="1">
						<input id="text" name="username" placeholder="Your Username" title="Your Username" type="text" value="<?php $uname;?>" required="" />
						<label for="username">Username</label>
					</li>
					<li>
						<input id="password" name="password" placeholder="Your Password" title="Your Password" type="password" value="" required="" />
						<label for="password">Password</label>
					</li>
				</ul>
			</fieldset>
			<p>
				<?php
					if (count($errors) > 0) {
						foreach ($errors as $error) {
						echo $error . "<br />";
						}
					} else {
						echo "Encrypted Area!";
					}
				?>
			</p>
			<input id="submit" name="submit" type="submit" value="Login" />
		</form>
	</div>
</body>
</html>