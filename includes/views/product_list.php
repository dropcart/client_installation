<?php

global $client;
global $category;

?>
<h1>Producten: <?= $category['name'] ?></h1>
<div class="product-list">
<?php

$products = $client->getProductListing($category);
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
	<div class="col-md-7">
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
		<h3>&euro;&nbsp;<?= $product['price'] ?></h3>
		<div>
			<a href="#" class="btn btn-lg btn-block btn-primary"><span class="glyphicon glyphicon-shopping-cart"></span>&nbsp;Bestellen</a>
		</div>
	</div>
</div>
<?php
endforeach
?>
</div>