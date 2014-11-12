<?php

function getRoute(){
	return $route = substr(urldecode(stripslashes($_SERVER['REQUEST_URI'])), 1);
}

function View($name, $header, $content){
	$view = "../view/".$name.".layout.php";
	return include($view);
}

function Controller($name, $action="index"){
	$controller = "../controller/".$name."Controller.php";
	return include($controller);
}

function requireClass($name){
	$class = "../class/".$name.".class.php";
	return include_once($class);
}

function Load($name){
	$view = "../view/".$name.".inc.php";
	return include($view);
}

function Copyright(){
	return date('Y') ." © Copyright ".APPNAME.", all rights reserved. ";
}

function phpbool($str){
	return ($str=='t' ? 1 : 0);
}

function pgbool($bool){
	return ($bool ? 't' : 'f');
}

?>