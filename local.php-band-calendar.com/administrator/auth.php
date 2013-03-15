<?php
	//Check whether the session variable SESS_USERNAME is present or not
	if(!isset($_SESSION['SESS_USERNAME']) || (trim($_SESSION['SESS_USERNAME']) == '')) {
		header("location: http://local.php-band-calendar.com/administrator/access-denied.php");
		exit();
	}
?>