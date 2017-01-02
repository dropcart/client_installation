<?php

global $client;
global $category;
global $products;

?>
<h1>Producten: <?= $category['name'] ?></h1>
<div class="product-list">
<?php

$index = 0;
foreach($products as $product):
$index = $index % 8 + 1;
?>
<div class="row <?= roman_number($index); ?>">
	<div class="col-md-3 center">
<?php
if (count($product['images'])):
?>
		<img src="<?= $product['images'][0] ?>" class="fill" />
<?php
else:
?>
		<img src="<?= config('base_url') ?>includes/images/no_image.gif" class="fill" />
<?php
endif;
?>
	</div>
	<div class="col-md-7 color">
		<h3><a href="<?= route('product', $product['id']) ?>"><?= $product['name'] ?></a></h3>
		<p>
			<?= $product['description'] ?>
		</p>
		<div class="float-left stock-shipping-status">
<?php
if ($product['in_stock']):
?>
			<div class="label label-success">Op voorraad</div>
<?php
else:
?>
			<div class="label label-warning">Niet op voorraad</div>
<?php
endif;
?>
		</div>
		<div class="float-right product-details">
			<table class="product-id-table">
				<tr>
					<th>EAN</th>
					<td><?= $product['ean'] ?></td>
				</tr>
				<tr>
					<th>SKU</th>
					<td><?= $product['sku'] ?></td>
				</tr>
			</table>
		</div>
		<div class="float-clear"></div>
	</div>
	<div class="col-md-2">
<?php
if (isset($product['price'])):
?>
		<h3 class="price">&euro;&nbsp;<?= number_format($product['price']['price_with_shipment_and_tax'],2,",",".") ?> <div class="float-right flag flag-<?= strtolower($product['price']['price_for_country']) ?>"></div></h3>
		<p class="float-clear">
			<small>Incl. verzendkosten</small>
		</p>
		<div>
			<a href="<?= route('add_product', $product['id'], 1); ?>" class="btn btn-lg btn-block btn-primary"><span class="glyphicon glyphicon-shopping-cart"></span>&nbsp;Bestellen</a>
		</div>
<?php
endif;
?>
	</div>
</div>
<?php
endforeach
?>
</div>