<?php if(!isset($title)){$title="";}?>
<header id="banner" class"body">
    <div id="logo">
        <h1><a href="/index.php" title="Home" id="logo">HTML5 band calendar</a></h1>
    </div>
    <nav><ul>
        <li><a href="/index.php" <?php if ($title=="Home") echo 'class="active"'; ?>>Home</a></li>
        <li><a href="/about.php" <?php if ($title=="About") echo 'class="active"'; ?>>About</a></li>
    </ul></nav>
</header>