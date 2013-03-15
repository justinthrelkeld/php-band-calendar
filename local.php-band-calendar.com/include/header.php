<?php
    if(!defined('allow')){die('Direct access not premitted');}
?>
<div id="header">
    <a href="http://local.php-band-calendar.com/index.php" title="Home" id="logo" class="floatright">dev-ical</a>
    <div id="nav" class="floatright">
        <ul>
            <li><a href="http://local.php-band-calendar.com/index.php" <?php if ($title=="Home") echo 'class="active"'; ?>>Home</a></li>
            <li><a href="http://local.php-band-calendar.com/calendar.php" <?php if ($title=="Events") echo 'class="active"'; ?>>Events</a></li>
            <li><a href="http://local.php-band-calendar.com/about.php" <?php if ($title=="Who We Are") echo 'class="active"'; ?>>Who We Are</a></li>
            <li><a href="http://local.php-band-calendar.com/contact.php" <?php if ($title=="Contact Us") echo 'class="active"'; ?>>Contact Us</a></li>
        </ul>
    </div>
</div>