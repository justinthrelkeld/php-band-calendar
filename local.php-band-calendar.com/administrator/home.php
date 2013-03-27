<?php
session_start();
define('__ROOT__', dirname(dirname(__FILE__))); 
require_once(__ROOT__.'/administrator/auth.php'); 
require_once(__ROOT__.'/administrator/user.cookies.php');

$username = $_SESSION["SESS_USERNAME"];
?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Administrator</title>
</head>
<body>
	<div id="holder">
		<header>
		<div id="logo">
			<a href="/" title="Go Home">dev-ical</a>
		</div>
		<h1>Welcome <?php echo $username; ?></h1>
		<span><a href="/administrator/logout.php">Logout</a></span>
		</header>
			<ul id="menu">
				<li>
					<p>
						<a href="/administrator/add-event.php">
							<img src="/administrator/images/cal.png" width="256" height="256"></a>
						</p><p><a href="/administrator/add-event.php">Insert Event</a>
					</p>
				</li>
			</ul>
	</div>
</body>
</html>