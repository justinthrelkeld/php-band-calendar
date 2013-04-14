<?php
session_start();
// check login
define('__ROOT__', dirname(dirname(__FILE__)));
require_once (__ROOT__ . '/administrator/auth.php');
require_once (__ROOT__ . '/administrator/user.cookies.php');
require_once (__ROOT__ . '/config.php');

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
        $output = clean($input);
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
		$errors[] = "You must have a date for an event, don't you know?";
	}
	if (empty($_POST['address'])) {
		$errors[] = "You must have a location for an event, don't you know?";
	}
	if (empty($_POST['title'])) {
		$errors[] = "No title? how are they going to know what it is?";
	}
	print($_POST['dateF']);
	try {
		$time = DateTime::createFromFormat('Y-m-d\TH:i', $_POST['dateF']);
		if (!is_object($time)) {
			throw new Exception("Error formatting date");
		}
		$time = $time->format('U');
	} catch (Exception $e) {
		//$errors[] = $e->getMessage();
		$errors[] = "Error formating date";
	}
	
	// connect to database if no errors
	if (!$errors) {
		try {
			$conn = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME, DB_USER, DB_PASSWORD);
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$statement = $conn->prepare("INSERT INTO `events` (
				`id` ,
				`title` ,
				`name` ,
				`time` ,
				`timeAdded` ,
				`description` ,
				`address` ,
				`lat` ,
				`lng` ,
				`managerID` ,
				`managerIP`
				)
			VALUES (NULL, :title, :name, :time, UNIX_TIMESTAMP(), :description, :address, :lat, :lng, :managerID, :managerIP);");
			
			$statement->bindParam(':title', $_POST['title'], PDO::PARAM_STR);
			$statement->bindParam(':name', $_POST['name'], PDO::PARAM_STR);
			$statement->bindParam(':time', $time, PDO::PARAM_INT);
			$statement->bindParam(':description', $_POST['description'], PDO::PARAM_STR);
			$statement->bindParam(':address', $_POST['address'], PDO::PARAM_STR);
			$statement->bindParam(':lat', $_POST['lat'], PDO::PARAM_STR);
			$statement->bindParam(':lng', $_POST['lng'], PDO::PARAM_STR);
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
} ?>

<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>add event</title>
	<link type="text/css" rel="stylesheet" href="/administrator/css/style.css" media="all">
	<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>
	<script src="/administrator/js/map.js"></script>
	<link type="text/css" rel="stylesheet" href="/administrator/css/style.css" media="all">
</head>
<body>
	<div id="holder">
		<div id="logo">
			<a href="/" title="Go to root">PHP band calendar</a>
		</div>
		<h1>Add event</h1>
		<?php
			function is_chrome() {
				return(stristr($_SERVER['HTTP_USER_AGENT'],"chrome"));
			}

			if(!is_chrome()) {
				echo '<h2 id="getchrome"><a href="https://www.google.com/intl/en/chrome/browser/" target="_blank">Get Chrome</a> Firefox is still working/waiting <font style="font-size: 0.6em;font-weight: normal;">Just cuz of the event date &amp; time picker</font></h2>';
			}
		?>
		<form id="login" action="#" method="post">
			<fieldset>
				<legend>
					Add event
				</legend>
				<ul>
					<li>
						<label for="title">Title: </label>
						<input type="text" name="title" value="" required="" />
						<p>Example: I don't really know :(</p>
					</li>
					<li>
						<label for="dateF">Date: </label>
					    <input type="datetime-local" name="dateF" />
					</li>
					<li>
						<label for="address">Address: </label>
						<input id="address" class="toggle" type="text" name="address" value="Nashville, TN" x-webkit-speech="" autocorrect="off" />
						<!-- Using input text fields styled like buttons so map does not close when clicked. I think it is pretty clever :) -->
						<input class="button" type="text" value="Geocode" onclick="codeAddress()" readonly="" />
						<input class="button" type="text" value="Rev-Geocode" onclick="revGeocode()" readonly="" />
						<input class="button" type="text" value="Remove overlay" onclick="deleteOverlays()" readonly="" /><br />
						<input id="lat" name="lat" type="text" value="" />
						<input id="lng" name="lng" type="text" value="" /><span>&lt;-- These could be hidden</span>
						<div class="collapsible">
							<div id="map-canvas" style="width: 500px; height: 300px"></div>
						</div>
						<p>Just like any other address. If you type the address press Geocode before adding. You can use the Geocode to locate an area of the map then if needed you may drag the marker to the exact location. Reverse Geocode gets the address from lat lng from marker position. shue, if in chrome you can even speak! haha</p>
					</li>
					<li>
						<label for="description">Description: </label>
						<input type="text" name="description" value="" />
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
			<input class="button_submit" id="submit" name="submit" type="submit" value="Add" />
		</form>
	</div>
</body>
</html>