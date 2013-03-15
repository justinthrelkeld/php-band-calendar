<?php
	define('allow', TRUE);
	$title = "Calendar";
?>
<!DOCTYPE HTML>
<html>
<head>
	<meta charset="UTF-8" />
	<title><?php echo $title ?></title>
	<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
	<link href="css/styles.css" type="text/css" rel="stylesheet" />
	<script src="js/jquery-1.9.1.js" type="text/javascript"></script>
	<script src="js/jquery.smooth-scroll.min.js" type="text/javascript"></script>
	<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAvloktPgM55YJWxAggRuTFD_vO9HkllhY&sensor=true"></script>
	<script type="text/javascript" src="js/calendar.js"></script>
</head>
<body onload="initialize()">
	<section id="main">
		<?php include ('include/header.php'); ?>
		<section id="eventcalendar">
			<?php include ('include/event_cal.php'); ?>
		</section>
	<section>
</body>
</html>