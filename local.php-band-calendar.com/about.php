<?php
  define('allow', TRUE);
  $title = "Who We Are";
?>

<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
	<link href="css/styles.css" type="text/css" rel="stylesheet" />
	<title><?php echo $title ?></title>
</head>
<body>
<section id="main">
	<?php include("include/header.php") ?>
	<section>
		<article>
			<header>
				<h1><?php echo $title ?><h1>
			</header>
			<section>
				<p>We are <b>Not much to say here.</b></p>
			</section>
		</article>
	</section>
</section>
</body>
</html>