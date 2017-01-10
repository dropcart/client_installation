<?php 

global $product;

?>
<h1><?= $product['name'] ?></h1>

<div class="row">
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
			<?= (empty($product['description']) ? content('product_boilerplate', $product['name'] . ' bij %STORE_NAME%. Binnen 24 uur geleverd, mits op voorraad.') : $product['description']) ?>
		</p>
		<div class="float-left stock-shipping-status">
<?php
if ($product['stock']):
?>
<div class="label label-success"><?= $product['stock'] ?> stuk<?= $product['stock'] != 1 ? 's' : '' ?> op voorraad</div>
<?php
	if ($product['shipping_days']):
?>
<div class="label label-info">Leverbaar binnen <?= $product['shipping_days'] ?> werkdagen</div>
<?php
	endif;
?>
<?php
else:
?>
<div class="label label-warning">Niet op voorraad, langere levertijd</div>
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
		<h3 class="price">&euro;&nbsp;<?= number_format($product['price']['price_with_shipment_and_tax'],2,",",".") ?> <div class="float-right flag flag-<?= strtolower($product['price']['price_for_country']) ?>"></div></h3>
		<p class="float-clear">
			<small>Incl. verzendkosten</small>
		</p>
		<div>
			<a href="<?= route('edit_shopping_bag', [$product['id'], 1]); ?>" class="btn btn-lg btn-block btn-primary"><span class="glyphicon glyphicon-shopping-cart"></span>&nbsp;Bestellen</a>
		</div>
	</div>
<?php
endif;
?>
</div>