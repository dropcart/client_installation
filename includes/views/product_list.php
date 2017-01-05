<?php

global $client;
global $title;
global $category;
global $products;

?>
<h1>Producten: <?= $title ?></h1>

<div class="product-list">
<?php

$index = 0;
foreach($products['list'] as $product):
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
if ($product['stock']):
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
			<a href="<?= route('edit_shopping_bag', [$product['id'], 1]); ?>" class="btn btn-lg btn-block btn-primary"><span class="glyphicon glyphicon-shopping-cart"></span>&nbsp;Bestellen</a>
		</div>
<?php
endif;
?>
	</div>
</div>
<?php
endforeach;

if (isset($products['pagination'])):
?>
<div class="pagination-block">
<span class="info">
<?= $products['pagination']['count'] ?> resultaten op deze pagina
</span>
<ul class="pagination">
<?php
if ($products['pagination']['current_page'] <= 1):
?>
	<li class="disabled"><span>Vorige pagina</span></li>
<?php
else:
?>
	<li><a href="<?= relroute(['page' => $products['pagination']['current_page'] - 1]) ?>" rel="previous">Vorige pagina</a></li>
<?php
endif;
?>
<?php
foreach (compute_pages($products['pagination']['current_page'], $products['pagination']['total_pages']) as $page):
	if ($page == "..."):
?>
	<li class="disabled"><span>...</span></li>
<?php
	elseif ($page == $products['pagination']['current_page']):
?>
    <li class="active"><a href="<?= relroute(['page' => $page]) ?>"><?= $page ?></a></li>
<?php
	else:
?>
	<li><a href="<?= relroute(['page' => $page]) ?>"><?= $page ?></a></li>
<?php
	endif;
endforeach;
?>
<?php
if ($products['pagination']['current_page'] == $products['pagination']['total_pages']):
?>
	<li class="disabled"><span>Volgende pagina</span></li>
<?php
else:
?>
	<li><a href="<?= relroute(['page' => $products['pagination']['current_page'] + 1]) ?>" rel="next">Volgende pagina</a></li>
<?php
endif;
?>
</ul>
<span class="info">
Totaal aantal resultaten: <?= $products['pagination']['total'] ?>
</span>
</div>
<?php
endif;
?>
</div>