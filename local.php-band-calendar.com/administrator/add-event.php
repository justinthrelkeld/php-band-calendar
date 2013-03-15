<?php
session_start();
// check login
define('__ROOT__', dirname(dirname(__FILE__)));
require_once (__ROOT__ . '/administrator/auth.php');
require_once (__ROOT__ . '/administrator/user.cookies.php');
require_once (dirname(dirname(dirname(dirname(dirname(__FILE__))))) . '/wall/php-band-calendar.inc');

// setup washer
function clean($input) {
	$input = strip_tags($input);
	$output = htmlspecialchars($input, ENT_QUOTES);
	
    return ($output); //output clean text
}

function sanitize($input) {
    if (is_array($input)) {
        foreach($input as $var => $val) {
            $output[$var] = sanitize($val);
        }
    }
    else {
        if (get_magic_quotes_gpc()) {
            $input = stripslashes($input);
        }
        $input  = clean($input);
        $output = mysql_real_escape_string($input);
    }
    return $output;
}

function clientIP() {
	if (!empty($_SERVER["HTTP_CLIENT_IP"])) {
		//check for ip from share internet
		$ip = $_SERVER["HTTP_CLIENT_IP"];
	} elseif (!empty($_SERVER["HTTP_X_FORWARDED_FOR"])) {
		// Check for the Proxy User
		$ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
	} else {
		$ip = $_SERVER["REMOTE_ADDR"];
	}
	return $ip;
}

$errors = array();
// $errors[] = "error!";
// if post data was sent
if (!empty($_POST['submit'])) {
	$_POST = sanitize($_POST);

	if (empty($_POST['dateF'])) {
		$errors[] = "you must have a date for an event, don't you know?";
	}
	if (empty($_POST['address'])) {
		$errors[] = "you must have a location for an event, don't you know?";
	}
	if (empty($_POST['title']) OR empty($_POST['description'])) {
		$errors[] = "no title/description? how are they going to know what it is?";
	}
	$time = strtotime(date('m/d/Y g:i:s a', strtotime($_POST['dateF'])));

	// connect to database
	if (!$errors) {
		try {
			$conn = new PDO('mysql:host='.$host.';dbname='.$dbname.'', $user, $password);
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$statement = $conn->prepare("INSERT INTO `events` (
				`id` ,
				`title` ,
				`time` ,
				`timeAdded` ,
				`address` ,
				`description` ,
				`managerID` ,
				`managerIP`
				)
				VALUES (NULL, :title, :time, UNIX_TIMESTAMP(), :address, :description, :managerID, :managerIP);
			");

			$statement->bindParam(':title', $_POST['title'], PDO::PARAM_STR);
			$statement->bindParam(':time', $time, PDO::PARAM_INT);
			$statement->bindParam(':address', $_POST['address'], PDO::PARAM_STR);
			$statement->bindParam(':description', $_POST['description'], PDO::PARAM_STR);
			$statement->bindParam(':managerID', $_SESSION["SESS_USERID"], PDO::PARAM_INT);
			$statement->bindParam(':managerIP', clientIP(), PDO::PARAM_STR);

			$statement->execute();
			$errors[] = "Event Created!";
		} catch(PDOException $e) {
			//$errors[] = 'Error: ' . $e->getMessage();
			$errors[] = "error(0)";
		}
	}
} else {
	//$errors[] = "no data was recevied";	
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
			<a href="/" title="Go Home">PHP band calendar</a>
		</div>
		<h1>Add event</h1>
		<form id="login" action="#" method="post">
			<fieldset>
				<legend>
					Add event
				</legend>
				<ul>
					<li>
						<label for="title">Title: </label>
						<input type="text" name="title" value="" required=""/>
						<p>Example: I don't really know :(</p>
					</li>
					<li>
						<label for="dateF">Date: </label>
						<input type="text" name="dateF" class="hasDatepicker" value="" required=""/>
						<p>Current example: <?php echo date('m/d/Y g:i a', time()) ?></p>
					</li>
					<li>
						<label for="address">Address: </label>
						<input type="text" name="address" value="" x-webkit-speech="" autocorrect="off" required=""/>
						<p>Example: just like any other address :)</p>
					</li>
					<li>
						<label for="description">Description: </label>
						<input type="text" name="description" value="" required=""/>
						<p>Do we even need this?</p>
				</ul>
			</fieldset>
			<p>
				<?php
					if (count($errors) > 0) {
						foreach ($errors as $error) {
							echo $error . "<br />";
						}
					}
				?>
			</p>
			<input id="submit" name="submit" type="submit" value="Add" />
		</form>
	</div>
</body>
</html>