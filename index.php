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
function route($name, $params = [], $absolute = true) {
	if ($absolute) {
		$url = "http://" . config('domain');
	} else {
		$url = "";
	}
	$url .= config('base_url');
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
function acopy($from, &$to, $fields) {
	foreach ($fields as $from_key => $to_key) {
		if (is_int($from_key)) $from_key = $to_key;
		if (isset($from[$from_key]))
			$to[$to_key] = $from[$from_key];
	}
}

try {

// MIDDLEWARE

Client::setEndpoint(config('dropcart_api_endpoint'));
global $client;
$client = Client::instance();
$client->auth(config('dropcart_api_key'), 'NL');

// Shopping bag handling
global $shoppingBag;
global $readShoppingBag;
if (isset($_COOKIE['sb'])) {
	$shoppingBag = $_COOKIE['sb'];
	try {
		$readShoppingBag = $client->readShoppingBag($shoppingBag);
	} catch (Exception $e) {
		// Clear bag on error
		$shoppingBag = "";
		$readShoppingBag = [];
		unset($_COOKIE['sb']);
		setcookie('sb', $shoppingBag, time()-3600);
	}
} else {
	$shoppingBag = "";
	$readShoppingBag = [];
	unset($_COOKIE['sb']);
	setcookie('sb', $shoppingBag, time()-3600);
}

// Transaction handling
global $transaction_status;
global $transaction;
global $reference;
global $checksum;
if ($shoppingBag && isset($_COOKIE['ref']) && isset($_COOKIE['cs'])) {
	$reference = $_COOKIE['ref'];
	$checksum = $_COOKIE['cs'];
	// First retrieve status,
	try {
		$transaction_status = $client->statusTransaction($reference, $checksum);
	} catch (Exception $e) {
		// Checksum does not match, or invalid order
		$transaction_status = null;
	}
	if ($transaction_status && isset($transaction_status['status']) && ($transaction_status['status'] == "PARTIAL" || $transaction_status['status'] == "FINAL")) {
		// Then if PARTIAL or FINAL, retrieve transaction.
		try {
			$transaction = $client->getTransaction($shoppingBag, $reference, $checksum);
		} catch (Exception $e) {
			// Clear transaction on error
			$transaction_status = null;
			$transaction = null;
			$reference = 0;
			$checksum = "";
		}
	} else if ($transaction_status && isset($transaction_status['status']) && ($transaction_status['status'] == "PAYED")) {
		// Clear shopping bag and transaction references, since order was payed
		$transaction = null;
		$reference = "";
		$checksum = "";
		unset($_COOKIE['ref']);
		unset($_COOKIE['cs']);
		setcookie('ref', $reference, time()-3600);
		setcookie('cs', $checksum, time()-3600);
	} else {
		// Clear transaction on status
		$transaction_status = null;
		$transaction = null;
		$reference = "";
		$checksum = "";
		$shoppingBag = "";
		$readShoppingBag = [];
		unset($_COOKIE['ref']);
		unset($_COOKIE['cs']);
		unset($_COOKIE['sb']);
		setcookie('ref', $reference, time()-3600);
		setcookie('cs', $checksum, time()-3600);
		setcookie('sb', $shoppingBag, time()-3600);
	}
} else {
	// Clear transaction if no reference and checksum known
	$transaction_status = null;
	$transaction = null;
	$reference = 0;
	$checksum = "";
}

// REQUEST ROUTING

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
// Dynamic pages
case 'thanks':
	view($action);
	break;
case 'checkout':
	if (!$transaction) {
		redirect('shopping_bag');
		break;
	}
	if (isset($_POST['submit'])) {
		// Confirm the transaction
		$returnURL = route('thanks', [], true);
		$result = $client->confirmTransaction($shoppingBag, $reference, $checksum, $returnURL);
		if (isset($result['redirect'])) {
			// Perform the redirect as instructed by the server
			header("Location: " . $result['redirect']);
			exit(0);
		} else {
			// Otherwise, we retrieve a transaction as usual
			$transaction = $result;
		}
	}
	view('checkout');
	break;
case 'customer_details':
	global $details;
	$details = [];
	if (isset($_POST['submit'])) {
		acopy($_POST, $details, [
					'billing_first_name' => 'first_name',
					'billing_last_name' => 'last_name'
		]);
		acopy($_POST, $details, [
					'email',
					'telephone',
					'billing_first_name',
					'billing_last_name',
					'billing_address_1',
					'billing_address_2',
					'billing_city',
					'billing_postcode',
					'billing_country',
				
		]);
		if (isset($_POST['has_delivery']) && $_POST['has_delivery']) {
			acopy($_POST, $details, [
					'shipping_first_name',
					'shipping_last_name',
					'shipping_address_1',
					'shipping_address_2',
					'shipping_city',
					'shipping_postcode',
					'shipping_country'
			]);
		} else {
			acopy($_POST, $details, [
					'billing_first_name' => 'shipping_first_name',
					'billing_last_name' => 'shipping_last_name',
					'billing_address_1' => 'shipping_address_1',
					'billing_address_2' => 'shipping_address_2',
					'billing_city' => 'shipping_city',
					'billing_postcode' => 'shipping_postcode',
					'billing_country' => 'shipping_country'
			]);
		}
		if ($transaction) {
			// Update transaction to change customer details
			$transaction = $client->updateTransaction($shoppingBag, $reference, $checksum, $details);
		} else {
			// Create new transaction
			$transaction = $client->createTransaction($shoppingBag, $details);
		}
		if ($transaction && isset($transaction['reference']) &&
				isset($transaction['checksum']) && isset($transaction['transaction']) &&
				isset($transaction['transaction']['system_status']) &&
				$transaction['transaction']['system_status'] == "FINAL") {
			$reference = $transaction['reference'];
			$checksum = $transaction['checksum'];
			setcookie('ref', $reference);
			setcookie('cs', $checksum);
			redirect('checkout');
			break;
		}
	} else {
		if ($transaction && isset($transaction['customer_details'])) {
			// Copy customer details as supplied previously.
			acopy($transaction['customer_details'], $details, [
					'email',
					'telephone',
					'billing_first_name',
					'billing_last_name',
					'billing_address_1',
					'billing_address_2',
					'billing_city',
					'billing_postcode',
					'billing_country',
					'shipping_first_name',
					'shipping_last_name',
					'shipping_address_1',
					'shipping_address_2',
					'shipping_city',
					'shipping_postcode',
					'shipping_country'
			]);
		} else {
			// Nothing to do
		}
	}
	// Convert details to escaped value
	foreach ($details as $key => &$value) {
		$value = htmlspecialchars($value);
	}
	global $diff_billing_shipping;
	// Check difference shipping/billing
	$diff_billing_shipping = @$details['billing_first_name'] != @$details['shipping_first_name'] ||
			@$details['billing_last_name'] != @$details['shipping_last_name'] ||
			@$details['billing_address_1'] != @$details['shipping_address_1'] ||
			@$details['billing_address_2'] != @$details['shipping_address_2'] ||
			@$details['billing_city'] != @$details['shipping_city'] ||
			@$details['billing_postcode'] != @$details['shipping_postcode'] ||
			@$details['billing_country'] != @$details['shipping_country'];
	unset($value);
	view('customer_details');
	break;
case 'shopping_bag':
	// Displays same shopping bag as in the header
	view('shopping_bag');
	break;
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