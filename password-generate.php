<?php
function generatePassword($passw) {
	//encrypt the password
	$salt = substr( $passw, 0, 2 );
	$passw = sha1($passw);
	$passw = crypt($passw, $salt);
	$pepper = "%AqZ38aK9a#";
	$passencrypt = $salt . $passw . $pepper;
	return $passencrypt;
}
if (!empty($_POST['submit'])) {
	$psword = $_POST['psword'];
	$gP = generatePassword($psword);
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
		<input type="text" name="psword" value="<?php echo $psword ?>" required=""/>
		<input id="submit" name="submit" type="submit" value="Generate" />
	</form>
</body>
</html>