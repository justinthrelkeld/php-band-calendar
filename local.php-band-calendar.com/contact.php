<?php
  define('allow', TRUE);
  $title = "Contact us";
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
				<p>This is the contact page, with contacts, Contact me!</p>
				<ul>
					<li>Phone: 123-123-4321</li>
					<li>Email: no.spam@spam.com</li>
					<li><address>I live here</address></li>
			</section>
		</article>
	</section>
</section>
</body>
</html>