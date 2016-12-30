<?php

require_once "./config.php";
require_once "./client/vendor/autoload.php";

// Global helper functions

function view($name) {
	$name = preg_replace('/[^A-Za-z0-9_\-]/', '', $name);
	include("includes/header.php");
	include("includes/views/$name.php");
	include("includes/footer.php");
}

function route($name, $params = []) {
	$url = config('base_url');
	if (config('has_rewriting')) {
		$url .= urlencode($name);
		foreach ($params as $param) {
			$url .= "/";
			$url .= urlencode($param);
		}
	} else {
		$url .= "?act=" . urlencode($name);
		$key = 1;
		foreach ($params as $param) {
			$url .= "&p" . $key . "=";
			$url .= urlencode($param);
			$key++;
		}
	}
	return $url;
}

// Request routing

$action = isset($_GET['act']) ? $_GET['act'] : false;
if (!$action) $action = 'home';
switch ($action) {
// Static pages
case 'about':
case 'contact':
case 'faq':
case 'home':
	view($action);
	exit();
default:
	// Unknown action, redirect to home.
	header("Location: " . config('base_url'));
	exit();
}

?>