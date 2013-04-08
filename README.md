Band Calendar
=============

This should help you get the calendar in your project pretty quickly.

## Setup.
To setup you just need a few things.

### Using PHP and MySQL

1. A database with a tables for managers and events 
2. The inlclude folder
3. The administrator folder
4. A few Javascript files
5. And a stylesheet
6. The config file
7. Then simply import the scripts and stylesheets, and include the php calendar into the desired page, and a few other things.

Some [quick instructions](#quick-instructions) are below (not directly below).

Here are the instructions.

We have a SQL file named `local.php-band-calendar.com.sql` for you to run, that all ready has some example data in the tables. Just create/select your database and run the SQL.

Put the `include` folder, `administrator` folder and the `config.php` file in the root of your website.

Get the `calendar.js` and `jquery-1.9.1.js` files into your js folder.

Put the `event.css` stylesheet into your css folder.

The file in which you wish the calendar to be must be a PHP file type. At the head import `jquery-1.9.1.js`, google maps api, `calendar.js` and the stylesheet `event.css`

	<link href="css/event.css" rel="stylesheet" type="text/css" />
	<script src="js/jquery-1.9.1.js"></script>
	<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAvloktPgM55YJWxAggRuTFD_vO9HkllhY&sensor=true"></script><!-- Please get your own key -->
	<script type="text/javascript" src="js/calendar.js"></script>

Please use your own google maps api key until we start using google maps api v3

And on body load run the initialize function
		
	<body onload="initialize()">

At the section you want the calendar to be displayed simply include the `event_cal.php` file.

	<div id="events_widget">
		<?php include('/include/event_cal.php') ?>
	</div>

Configure the `config.php` file with your settings.
And I think thats all :confused:


#### <a id="quick-instructions"></a>Quick instructions

We are not responsible for any claim of injury, loss, damage, or any direct, incidental or consequential damages of any kind. **WARNING**: following these instructions may cause what has been mentioned above, follow wisely.

Simply copy all the files from `local.php-band-calendar.com/` to your web site root.

in your database, run the `local.php-band-calendar.com.sql` SQL file.

Then just configure the `config.php` file.


### Hand coding
In the future, we hope for it not to rely on a json object. The HTML would be parsed like this?:

	<div id="events_widget">
	    <header>
			<h3>Events!</h3>
		</header>
		<section>
			<article class="event">
				<h3><a href="#" class="eventlink">a</a></h3>
				<span>March 18 2013</span>
				<span>11:43am</span>
				<address>Tullahoma, TN</address>
			</article>
		</section>
		<footer>
			<p>come to an event</p>
		</footer>
		<div id="map_canvas" class="hidden"></div>
	</div>

## Management

To log in, go to `yoursite.com/administrator/`

| User          | Password      |
| ------------- |:-------------:|
| admin         | admin         |

very complex stuff, I felt it should go in a table :smile:

To log in, go to `yoursite.com/administrator/`

#### Changing the password. (Do not leave these defualt, that's the first thing most anyone will try :smile: )

Log in to the administrator panel, then go to `yoursite.com/administrator/password-generate.php`

Type in a username and password and ~~Hit, Press~~ click `Generate`. Then copy the password and go to the phpMyAdmin panel (for ease). Select the database and managers table. 

Now either insert a new manager or replace current manager. To replace just click on the row and column you need to edit and paste the user and password.

To insert a new manager click on the insert tab at the top paste the user and password leaving the id field empty.

#### Adding an event!

To add an event listing go to `yoursite.com/administrator/` this should redirect you without notice to home.php if logged in. Click the cal icon or text link to insert a new event listing.

##### Filling out the form

It was a little harder than it is now with the time formatting how it was.

The title is self explanatory.

The date has the cool html5 picker (now). The date is converted into a unix timestamp (seconds from a specific date) to be stored in the database.

The address. when you click the address field it expands a map that you can click, drag or clear the marker. The address must filled out with a valid address for Geocoding to work. The address here is used for display and geocoding, in later versions we might be using the lat lng fields, The address will still be used.

The description is not currently used, but it sounded good and it is easier over plan then to under plan.

The big green button labeled `Add`, posts event data and tries to validate then add the event to the database. Errors would be displayed just above. :smile:
