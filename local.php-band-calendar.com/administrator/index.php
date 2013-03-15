<?php session_start();
if(isset($_SESSION['SESS_USERNAME'])) {
		header("location: /administrator/home.php");
	}
//redirect function
function returnheader($location) {
	$returnheader = header("location: $location");
	return $returnheader;
}
require_once (dirname(dirname(dirname(dirname(dirname(__FILE__))))) . '/wall/php-band-calendar.inc');
$connection = mysql_connect($host, $user, $password) OR die('Hello, we have an error (1).');
$db_select = mysql_select_db($dbname, $connection) OR die('Hello, we have an error (2).');

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
		$salt = substr( $passw, 0, 2 );
		$passw = sha1($passw);
		$passw = crypt($passw, $salt);
		$pepper = "%AqZ38aK9a#";
		$passencrypt = $salt . $passw . $pepper;

		//find out if user and password are present
		try {
			$conn = new PDO('mysql:host='.$host.';dbname='.$dbname.'', $user, $password);
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$statement = $conn->prepare("SELECT `id`, `username`, `password` FROM managers WHERE username = :uname AND password = :passencrypt");

			$statement->bindParam(':uname', mysql_real_escape_string($uname), PDO::PARAM_STR);
			$statement->bindParam(':passencrypt', mysql_real_escape_string($passencrypt), PDO::PARAM_STR);
			
			$statement->execute();
			if ($statement > 0) {
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
			} else {
				//tell there is no username etc
				sleep(3);
				$errors[] = "Your username or password are incorrect";
			}
			$errors[] = "Event Created!";
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
	<link rel="stylesheet" type="text/css" href="/styles/form.css" />
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>PHP band calendar Login</title>
</head>
<body>
	<div id="holder">
		<div id="logo">
			<a href="/" title="Go Home">PHP band calendar</a>
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
						<input id="text" name="username" placeholder="Your Username" title="Your Username" type="text" value="<?php $uname;?>" required="">
						<label for="username">Username</label>
					</li>
					<li>
						<input id="password" name="password" placeholder="Your Password" title="Your Password" type="password" value="" required="">
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