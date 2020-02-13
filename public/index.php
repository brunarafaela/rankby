<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start(); // ready to go!

// $now = time();
// if (isset($_SESSION['discard_after']) && $now > $_SESSION['discard_after']) {
//     // this session has worn out its welcome; kill it and start a brand new one
//     session_unset();
//     session_destroy();
//     session_start();
// }

// // either new or old, it should live at most for another hour
// $_SESSION['discard_after'] = $now + 300;

define('PRODUCTION', false);
define('AMBIENT', 'development');

function isMobile() {
	return (bool)(preg_match('/Android|webOS|iPhone|iPod|BlackBerry|Windows Phone/i', $_SERVER['HTTP_USER_AGENT']));
}

function pr(&$data) {
	echo '<pre>';
	print_r($data);
	echo '</pre>';
}

function dbd() {
	$GLOBALS['debug'] = 1;
}

function dbcache($name, $callback, $timeout = 60) {
	if (apc_exists($name)) {
		return apc_fetch($name);
	} else {
		$cache = $callback();
		apc_store($name, $cache, $timeout);
		return $cache;
	}
}

function dumpcache($name) {
	return apc_delete($name);
}

function includePage($pageName, $controller = false, &$Data = NULL) {
	$controller = (!$controller) ? $GLOBALS['controller'] : $controller;
	$pageName = '../APP/View/'.$controller.'/'.$pageName.'.php';
	if (file_exists($pageName)) 
		require $pageName;
}

function includePartial($pageName, $controller = false, $pData = false){
	$controller = (!$controller) ? $GLOBALS['controller'] : $controller;
	if (file_exists('../APP/View/'.$controller.'/partial/'.$pageName.'.php'))
		require '../APP/View/'.$controller.'/partial/'.$pageName.'.php';
}

/* css/js getters and setters */
function setJs($file) { 
	$GLOBALS['js'] = $file; 
}

function getJs() {
	if(isset($GLOBALS['js'])) {
		foreach($GLOBALS['js'] as $s) {
			echo '<script type="text/javascript" src="'.$s.'"></script>' . PHP_EOL;
		}
	}
}

function setCs($file) { $GLOBALS['cs'] = $file; }

function getCs() {
	if(isset($GLOBALS['cs'])) {
		foreach($GLOBALS['cs'] as $s) {
			echo '<link href="'.$s.'" rel="stylesheet">' . PHP_EOL;
		}
	}
}

/* Utilities */

function isPost(){
	return ($_SERVER['REQUEST_METHOD'] == 'POST') ? true : false;
}

function Session(){
	return call('Helper/Session');
}

function escape($string = '') {
	// $string = addslashes($string);
	// $string = strip_tags($string);
	return $string;
}

function getLast($string, $delimiter){
	$return = explode($delimiter, $string);
	return end($return);
}

function getFirst($string, $delimiter){
	$return = explode($delimiter, $string);
	return $return[0];
}

function urlName($url) {
	$url = str_replace('http://', '', $url);
	$url = str_replace('https://', '', $url);
	$url = str_replace('www.', '', $url);
	$url = explode('/', $url);
	return $url[0];
}

function dt($data = false){
	if (! $data)
		return date('Y-m-d H:i:s');
	$data = explode(' ', $data);
	$dia = explode('-', $data[0]);
	$data = explode(':', $data[1]);
	return $data[0].':'.$data[1].' '.$dia[2].'/'.$dia[1].'/'.$dia[0];
}

/* Data utilities */

function getData($name = false, $orReturn = false, $urlDecode = true){

	if ($name) {
		for ($i = 0; $i < count($GLOBALS["url"]); $i++) {
			if ($GLOBALS["url"][$i] == $name && $urlDecode) {

				$orReturn = escape(urldecode(@$GLOBALS["url"][$i + 1]));
			}else if($GLOBALS["url"][$i] == $name){
				$orReturn = escape(@$GLOBALS["url"][$i + 1]);
			}else{
				$orReturn = isset($_GET[$name]) ? $_GET[$name] : $orReturn;
			}
		}
	}


	if($orReturn === false){
		$orReturn = isset($_GET[$name]) ? $_GET[$name] : false;
	}

	return $orReturn;
}

function postData($name = false, $orReturn = false){
	if ($name)
		$name = (array_key_exists($name, $_POST) && $_POST[$name] != "") ? escape($_POST[$name]) : $orReturn;
	return $name;
}

function returnData($fields = false, $method = 'postData', &$return, $required = true){

	foreach ($fields as $field){

		$main = explode('|', $field);

		if (isset($main[1])){
			$field = $main[0];
			$key = $main[1];
		} else {
			$key = $main[0];
		}

		$return[$key] = $method($field);

		if($return[$key] === false)
			if ($required) return false;
	}
	return true;
}

function params($post = false, $get = false, $return = array()) {

	if (is_array($post)) {
		if (isset($post['req'])) {
			if (! returnData($post['req'], 'postData', $return)) {
				return false;
			}
		}

		if (isset($post['opt'])) {
			returnData($post['opt'], 'postData', $return, false);
		}
	}

	if ($get) {
		if (isset($get['req'])) {
			if (! returnData($get['req'], 'getData', $return)) {
				return false;
			}
		}

		if (isset($get['opt'])) returnData($post['opt'], 'getData', $return, false);
	}

	return $return;
}

/* classes utilities */

function helper($path) {
	$path = 'Helper/' . $path;
	return (isset($GLOBALS[$path])) ? $GLOBALS[$path] : newInstantiate($path);
}

function call($path) {
	return (isset($GLOBALS[$path])) ? $GLOBALS[$path] : newInstantiate($path);
}

function newInstantiate($path){
	if (file_exists('../APP/'.$path.".php")){
		include_once('../APP/'. $path.".php");
		$class = getLast($path, '/');
		if (class_exists($class)){
			$GLOBALS[$path] = new $class();
			return $GLOBALS[$path];
		}
	}
}

/* data utilities */

function timestampToBr($timestamp, $date = true, $hour = false, $year = true, $return = "") {
	$timestamp = explode(' ', $timestamp);
	list($ano, $mes, $dia) = explode('-', $timestamp[0]);
	list($horas, $minutos) = explode(':', $timestamp[1]);
	if ($date) $return .= $dia . '/' . $mes . (($year) ? '/'.$ano : '') . ' ';
	if ($hour) $return .= $horas . ':' . $minutos;
	return $return;
}

/* url threatment */

function cleanUrl($url){
	$url = str_replace('-', '_', $url);
	$url = ltrim($url, '/');
	$url = explode('?', $url);
	$url = explode('/', $url[0]);
	$return = false;
	foreach ($url as $part) {
		if ((! empty($part)) || ($part == 0)) {
			$return[] = $part;
		}
	}

	$return[0] = ucfirst($return[0]);
	return $return;
}

function strstrall($string, $array) {
	foreach ($array as $value) {
		if (strstr($string, $value)) {
			return true;
		}
	}


	return false;
}

function redirect($place = "/"){
	header('Location: '.$place);
	die;
}

function inredirect($place, $data){
	bootstrap($place."/", $data);
}

function bootstrap($url, $data = false){

	$defaultController 	= 'Index';
	$defaultAction 		= 'home';

	$url = cleanUrl($url);
	$GLOBALS['url'] = $url;
	

	if (file_exists("../APP/Controller/".$url[0].'.php')){
		$GLOBALS['controller'] = $url[0];
		$GLOBALS['action'] 	= (! empty($url[1])) ? $url[1] : $defaultAction;
	} else {
		$GLOBALS['controller'] = $defaultController;
		$GLOBALS['action'] 	= (! empty($url[0])) ? $url[0] : $defaultAction;
	}

	$caller = call("Controller/".$GLOBALS['controller']);

	if (method_exists($caller, $GLOBALS['action']))
		$caller->{$GLOBALS['action']}(@$data);
	else
		$caller->notFound();
}

if(PRODUCTION)
	@bootstrap(@$_SERVER['REQUEST_URI'].'/');
else
	bootstrap(@$_SERVER['REQUEST_URI'].'/');
