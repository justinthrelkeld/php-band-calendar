<!doctype html>
<html>
<head>
	<meta content="text/html; charset=utf-8" http-equiv="Content-Type">
	<meta content="width=device-width, initial-scale=1.0" name="viewport">
	<title>event-calendar</title>
	<link href="css/style.css" rel="stylesheet" type="text/css" media="screen" />
	<link href="css/event.css" rel="stylesheet" type="text/css" />

	<script src="js/jquery-1.9.1.js"></script>
	<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAvloktPgM55YJWxAggRuTFD_vO9HkllhY&sensor=true"></script>
	<script type="text/javascript" src="js/calendar.js"></script>
 
</head>
<body onload="initialize()">
	<section id="container">
		<?php include("include/header.php") ?>
	  <div id="events_widget">
	    <?php include('/include/event_cal.php') ?>
	  </div>
	</section>
</body>
</html>