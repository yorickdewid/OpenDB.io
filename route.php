<?php
$route = substr(urldecode(stripslashes($_SERVER['REQUEST_URI'])), 1);

switch ($route) {
	case "blog":
		break;

	default:
		View(LAYOUT, "Features");
		break;
}
?>