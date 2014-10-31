<?php
function View($name, $content){
	$view = "../view/".$name.".layout.php";
	return include($view);
}

function Load($name){
	$view = "../view/".$name.".inc.php";
	return include($view);
}

function Copyright(){
	return date('Y') ." © Copyright ".APPNAME.", all rights reserved. ";
}
?>