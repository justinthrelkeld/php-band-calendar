<?php
    if(!defined('allow')){die('Direct access not premitted');}
?>
<header id="banner" class"body">
    <div id="logo">
        <h1><a href="http://local.php-band-calendar.com/index.php" title="Home" id="logo">HTML5 band calendar</a></h1>
    </div>
    <nav><ul>
        <li><a href="http://local.php-band-calendar.com/index.php" <?php if ($title=="Home") echo 'class="active"'; ?>>Home</a></li>
        <li><a href="http://local.php-band-calendar.com/calendar.php" <?php if ($title=="Calendar") echo 'class="active"'; ?>>Events</a></li>
        <li><a href="http://local.php-band-calendar.com/about.php" <?php if ($title=="Who We Are") echo 'class="active"'; ?>>Who We Are</a></li>
        <li><a href="http://local.php-band-calendar.com/contact.php" <?php if ($title=="Contact Us") echo 'class="active"'; ?>>Contact Us</a></li>
    </ul></nav>
</header>