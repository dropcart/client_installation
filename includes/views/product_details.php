<?php 

global $product;

?>
<h1><?= $product['name'] ?></h1>
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
		<h3>&nbsp;</h3>
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
<?php
if (isset($product['price'])):
?>
	<div class="col-md-2">
		<h3 class="price">&euro;&nbsp;<?= $product['price']['price_with_shipment_and_tax'] ?> <div class="float-right flag flag-<?= strtolower($product['price']['price_for_country']) ?>"></div></h3>
		<p class="float-clear">
			<small>Incl. verzendkosten</small>
		</p>
		<div>
			<a href="#" class="btn btn-lg btn-block btn-primary"><span class="glyphicon glyphicon-shopping-cart"></span>&nbsp;Bestellen</a>
		</div>
	</div>
<?php
endif;
?>
</div>