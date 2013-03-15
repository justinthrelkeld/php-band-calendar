This is an event calendar
=========================

Setup
-----

Mysql database setup with a table called "events" for the id, title, time, timeAdded, address, description, managerID and managerIP (events.sql) if you want to clear it out use <code>TRUNCATE TABLE events</code>

On the page where you want the event calendar available load these scripts:
	<script src="js/jquery-1.9.1.js" type="text/javascript"></script>
	<script src="js/jquery.smooth-scroll.min.js" type="text/javascript"></script>
	<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAvloktPgM55YJWxAggRuTFD_vO9HkllhY&sensor=true"></script>
	<script type="text/javascript" src="js/calendar.js"></script>
And initialize:

        <body onload="initialize()">

Now put this in where the calendar should load:

        <section id="eventcalendar">
            <?php include ('include/event_cal.php'); ?>
        </section>