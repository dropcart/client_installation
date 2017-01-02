<?php

// Default configuration properties
require_once "./config.php";
if (!Config::$domain) {
	Config::$domain = $_SERVER['SERVER_NAME'];
}

// Dropcart API
require_once "./client/vendor/autoload.php";
use Dropcart\Client;

// Global helper functions

function config($name) {
	return Config::$$name;
}
function view($name) {
	$name = preg_replace('/[^A-Za-z0-9_\-]/', '', $name);
	include("includes/header.php");
	include("includes/views/$name.php");
	include("includes/footer.php");
}
function redirect($name, $params = []) {
	header("Location: " . route($name, $params));
	exit();
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
		if (!is_array($params)) {
			$params = [$params];
		}
		foreach ($params as $param) {
			$url .= "&p" . $key . "=";
			$url .= urlencode($param);
			$key++;
		}
	}
	return $url;
}
function roman_number($integer) {
	$table = array('x'=>10, 'ix'=>9, 'v'=>5, 'iv'=>4, 'i'=>1);
	$return = '';
	while($integer > 0) {
		foreach($table as $rom=>$arb) {
			if($integer >= $arb) {
				$integer -= $arb;
				$return .= $rom;
				break;
			}
		}
	}
	return $return;
}

try {

Client::setEndpoint(config('dropcart_api_endpoint'));
global $client;
$client = Client::instance();
$client->auth(config('dropcart_api_key'), 'NL');

// Shopping bag handling
global $shoppingBag;
if (isset($_COOKIE['sb'])) {
	$shoppingBag = $_COOKIE['sb'];
} else {
	$shoppingBag = "";
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
	break;
// Semi-static pages
case 'shopping_bag':
	view($action);
	break;
// Dynamic pages
case 'products_by_category':
	$category_id = (int) $_GET['p1'];
	$categories = $client->getCategories();
	global $category;
	foreach ($categories as $c) {
		if ($c['id'] == $category_id) {
			$category = $c;
			break;
		}
	}
	if ($category) {
		global $products;
		$products = $client->getProductListing($category_id);
		view('product_list');
	} else {
		// Unknown category
		redirect('home');
	}
	break;
case 'product':
	$product_id = (int) $_GET['p1'];
	global $product;
	$product = $client->getProductInfo($product_id);
	view('product_details');
	break;
// Actions
case 'edit_shopping_bag':
case 'add_product':
	$product_id = (int) $_GET['p1'];
	if (isset($_GET['p2'])) {
		$quantity = (int) $_GET['p2'];
	} else {
		$quantity = 1;
	}
	$product = $client->getProductInfo($product_id);
	if ($quantity < 0) {
		$shoppingBag = $client->removeShoppingBag($shoppingBag, $product, -$quantity);
	} else {
		$shoppingBag = $client->addShoppingBag($shoppingBag, $product, $quantity);
	}
	setcookie('sb', $shoppingBag, time() + 60*60*24*30); // 30 days
	switch ($action) {
	case 'edit_shopping_bag':
		redirect('shopping_bag');
		break;
	default:
		redirect('product', [$product_id]);
		break;
	}
	break;
default:
	// Unknown action, redirect to home.
	redirect('home');
	break;
}

} catch (Exception $e) {
	print("<h1>");
	print($e->getMessage());
	print("</h1>");
	print("<pre>");
	var_dump($e->context);
	print("</pre>");
}

?>