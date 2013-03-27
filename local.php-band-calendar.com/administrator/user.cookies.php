<?php

//redirect function
function returnheader($location) {
	$returnheader = header("location: $location");
	return $returnheader;
}

if (!strlen($_SESSION["SESS_USERNAME"]) > 0) {

	//redirect
	returnheader("http://69.73.170.65/%7ecollinba/administrator/index.php");
}
?>