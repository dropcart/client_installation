<?php
global $transaction;
?>

<h1>Winkelwagen</h1>

<ul class="nav nav-tabs order-tabs">
	<li class="active"><a href="#"><strong>Stap 1)</strong> Winkelwagen</a></li>
	<li class=""><a href="<?= route('customer_details'); ?>"><strong>Stap 2)</strong> Klantgegevens</a></li>
	<li class="<?= $transaction ? '' : 'disabled' ?>"><a href="<?= route('checkout') ?>"><strong>Stap 3)</strong> Bevestigen en afrekenen</a></li>
	<li class="disabled"><a href="#"><strong>Stap 4)</strong> Bestelling geplaatst</a></li>
</ul>

<?php
if ($transaction && isset($transaction['warnings']))
	foreach($transaction['warnings'] as $warning):
?>
<div class="alert alert-warning">
	<?= $warning ?>
</div>
<?php
	endforeach;
?>

<?php
if ($transaction && isset($transaction['errors']))
	foreach($transaction['errors'] as $error):
?>
<div class="alert alert-danger">
	<?= $error ?>
</div>
<?php
	endforeach;
?>

<table class="shopping-bag table">
<?php
if ($total_quantity > 0):
?>
<thead>
	<tr>
		<th width="10%"></th>
		<th>Product</th>
		<th width="14%">Aantal</th>
		<th width="12%">Stukprijs</th>
		<th width="12%">Prijs</th>
		<th class="fold"></th>
	</tr>
</thead>
<?php
endif;
?>
<tbody>
<?php
global $readShoppingBag;

$index = 0;
$total_price = 0.0;
$total_quantity = 0;
foreach ($readShoppingBag as $pq):
$index = $index % 8 + 1;
$product = $pq['product'];
$quantity = $pq['quantity'];
$total_price += (float) ($quantity * $product['price']['price_with_shipment_and_tax']);
$total_quantity += $quantity;
?>
<tr>
	<td>
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
	</td>
	<td>
		<p>
			<strong><a href="<?= route('product', $product['id']) ?>"><?= $product['name'] ?></a></strong>
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
		</p>
		<table class="product-id-table">
			<tr>
				<th>EAN</th>
				<td><?= $product['ean'] ?></td>
				<th>SKU</th>
				<td><?= $product['sku'] ?></td>
			</tr>
		</table>
	</td>
	<td>
		<input type="text "disabled="disabled" value="<?= $quantity; ?>" /><a
			class="btn btn-primary btn-bag-plus" href="<?= route('edit_shopping_bag', [$product['id'], 1]); ?>" alt="Plus"><span
			class="glyphicon glyphicon-plus"></span></a><a
			class="btn btn-primary btn-bag-minus" href="<?= route('edit_shopping_bag', [$product['id'], -1]); ?>" alt="Minus"><span
			class="glyphicon glyphicon-minus"></span></a>
	</td>
	<td>
<?php
if (isset($product['price'])):
?>
		&euro;&nbsp;<?= number_format($product['price']['price_with_shipment_and_tax'],2,",",".") ?>
<?php
endif;
?>
	</td>
	<td>
		<input type="text "disabled="disabled" value="&euro;&nbsp;<?= number_format($quantity * $product['price']['price_with_shipment_and_tax'],2,",",".") ?>" />
	</td>
	<td>
		<div class="float-right flag flag-<?= strtolower($product['price']['price_for_country']) ?>"></div>
	</td>
</tr>
<?php
endforeach;
?>
</tbody>
<?php
if ($total_quantity > 0):
?>
<tfoot>
	<tr>
		<td colspan="4" align="right">
			<div class="next-step">
<?php
if ($transaction):
?>
				<a href="<?= route('checkout'); ?>" class="btn btn-lg btn-block btn-primary">Naar <span class="glyphicon glyphicon-shopping-cart"></span>&nbsp;Stap 3: Afrekenen</a>
<?php
else:
?>
				<a href="<?= route('customer_details'); ?>" class="btn btn-lg btn-block btn-primary">Naar <span class="glyphicon glyphicon-shopping-cart"></span>&nbsp;Stap 2: Klantgegevens</a>
<?php
endif;
?>
			</div>
		</td>
		<td>
			<h3>&euro;&nbsp;<?= number_format($total_price,2,",",".") ?></h3>
			<p>
				<small>Incl. verzendkosten</small>
			</p>
		</td>
		<td></td>
	</tr>
</tfoot>
<?php
else:
?>
<tfoot>
	<tr>
		<td colspan="6">
			<div class="alert alert-info"><strong>Uw winkelwagen is leeg.</strong> U kunt nog geen producten afrekenen.</div>
		</td>
	</tr>
</tfoot>
<?php
endif;
?>
</table>