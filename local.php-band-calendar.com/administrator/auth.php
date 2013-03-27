<?php
	//Check whether the session variable SESS_USERNAME is present or not
	if(!isset($_SESSION['SESS_USERNAME']) || (trim($_SESSION['SESS_USERNAME']) == '')) {
		header("location: ./access-denied.php");
		exit();
	}
?>