<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="robots" content="index,follow">

<!-- Bootstrap -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

<!-- Stylesheet -->
<link href="<?= config('base_url') ?>includes/css/justified-nav.css" rel="stylesheet" />
<link href="<?= config('base_url') ?>includes/css/bv.min.css" rel="stylesheet" />
<link href="<?= config('base_url') ?>includes/css/flags.css" rel="stylesheet" />
<link href="<?= config('base_url') ?>includes/css/custom.css" rel="stylesheet" />

<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->

<title><?= config('site_name'); ?></title>
</head>
<body>
<div class="colorgraph"></div>

<div class="container">

<div class="row">
	<div class="col-md-6">
		<div class="push-left">
			<!-- <h3 class="text-muted"><?= config('site_name'); ?></h3> -->
			<a href="<?= route('home'); ?>"><img src="<?= config('base_url') ?>includes/images/logo_small.png" alt="<?= config('site_name'); ?>" /></a>
			<h4 class="slogan"><?= config('site_slogan') ?></h4>
		</div>
	</div>
	<div class="col-md-6">
		<div class="push-right">
			<!-- <h3>&nbsp;</h3> -->
			<nav class="float-right">
				<ul class="nav nav-pills">
					<li><a href="<?= route('contact'); ?>">Contact</a></li>
					<li><a href="<?= route('about'); ?>">Over ons</a></li>
					<li><a href="<?= route('faq'); ?>">Support &amp; FAQ</a></li>
					<li><a href="<?= route('account'); ?>">Mijn account</a></li>
				</ul>
			</nav>
			<div class="float-clear"></div>
			<div id="cart">
<?php
global $client;
global $shoppingBag;
global $readShoppingBag;

$total_price = 0.0;
$total_quantity = 0;
foreach ($readShoppingBag as $pq) {
	$product = $pq['product'];
	$quantity = $pq['quantity'];
	$total_price += (float) ($quantity * $product['price']['price_with_shipment_and_tax']);
	$total_quantity += (int) $quantity;
}
?>
				<a href="<?= route('shopping_bag'); ?>">
					<h3>
						<span class="glyphicon glyphicon-shopping-cart"></span> Winkelwagen
					</h3>
					<div class="cart-content">
						<span class="cart-items"><?= $total_quantity; ?></span> artikelen
<?php
if ($total_quantity > 0):
?>
						- <span class="cart-total">&euro;&nbsp;<?= number_format($total_price,2,",","."); ?></span>
<?php
endif;
?>
					</div>
				</a>
			</div>
		</div>
	</div>
</div>

<div class="masthead">
	<nav>
		<ul class="nav nav-justified">
			<li class="no-stretch"><a href="<?= route('home'); ?>"><b class="glyphicon glyphicon-home"></b></a></li>
<?php
global $client;

$categories = $client->getCategories();
foreach ($categories as $category):
?>
			<li><a class="category-link" href="<?= route('products_by_category', $category['id']) ?>" title="<?= $category['description'] ?>"><?= $category['name'] ?></a></li>
<?php
endforeach
?>
		</ul>
	</nav>
</div>
