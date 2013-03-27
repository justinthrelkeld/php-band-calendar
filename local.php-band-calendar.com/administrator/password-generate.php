<?php
session_start();
define('__ROOT__', dirname(dirname(__FILE__))); 
require_once(__ROOT__.'/administrator/auth.php'); 
require_once(__ROOT__.'/administrator/user.cookies.php');

function generatePassword($passw, $username) {
	//encrypt the password
	$salt = strrev(substr($username, 0, 2 ));
	$passw = sha1($passw);
	$passw = crypt($passw, $salt);
	$pepper = "%AqZ38aK9a#";
	$passencrypt = $passw . $pepper;
	return $passencrypt;
}
if (!empty($_POST['submit'])) {
	$psword = $_POST['psword'];
	$username = $_POST['username'];
	$gP = generatePassword($psword, $username);
} else {
	$gP = "";
	$psword = "";
}
?>
<html>
<body>
	<form id="login" action="#" method="post">
		<label for="psword">Passowrd: </label>
		<p><?php echo $gP ?></p>
		<input type="text" name="username" value="" required="" />
		<input type="text" name="psword" value="<?php echo $psword ?>" required=""/>
		<input id="submit" name="submit" type="submit" value="Generate" />
	</form>
</body>
</html>