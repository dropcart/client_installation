<h1>Bestelling afrekenen</h1>

<ul class="nav nav-tabs">
	<li class=""><a href="<?= route('shopping_bag'); ?>"><strong>Stap 1)</strong> Winkelwagen</a></li>
	<li class=""><a href="<?= route('customer_details'); ?>"><strong>Stap 2)</strong> Klantgegevens</a></li>
	<li class="active"><a href="#"><strong>Stap 3)</strong> Afrekenen</a></li>
	<li class="disabled"><a href="#"><strong>Stap 4)</strong> Bestelling geplaatst</a></li>
</ul>

<form class="form-horizontal confirm-form bv-form" role="form" method="post" novalidate="novalidate">
<input type="hidden" name="submit" value="1" />
<table class="customer-details-overview table">
<thead>
	<tr>
		<th width="33%">Factuuradres</th>
		<th width="34%">Afleveradres</th>
		<th width="33%">Contactgegevens</th>
	</tr>
</thead>
<tbody>
	<tr>
		<td>Voornaam Achternaam</td>
		<td></td>
		<td>E-mail</td>
	</tr>
	<tr>
		<td>Straatnaam</td>
		<td></td>
		<td>Telefoon</td>
	</tr>
	<tr>
		<td>Straatnaam2</td>
		<td></td>
	</tr>
	<tr>
		<td>Postcode Plaats</td>
		<td></td>
	</tr>
	<tr>
		<td>Land</td>
		<td></td>
	</tr>
</tbody>
</table>
<table class="shopping-bag table">
<thead>
	<tr>
		<th style="width: 5em"></th>
		<th>Product</th>
		<th width="12%">Aantal</th>
		<th width="12%">Stukprijs</th>
		<th width="12%">Prijs</th>
		<th class="fold"></th>
	</tr>
</thead>
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
			<strong><?= $product['name'] ?></strong>
		</p>
	</td>
	<td>
		<?= $quantity; ?>
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
		&euro;&nbsp;<?= number_format($quantity * $product['price']['price_with_shipment_and_tax'],2,",",".") ?>
	</td>
	<td>
		<div class="float-right flag flag-<?= strtolower($product['price']['price_for_country']) ?>"></div>
	</td>
</tr>
<?php
endforeach;
?>
</tbody>
<tfoot>
	<tr>
		<td colspan="4">
			<div class="next-step">
				<div class="form-group checkbox has-feedback">
					<div class="col-sm-12">
						<label class="confirm"><input type="checkbox" name="conditions" data-bv-field="conditions">
						Ik ga akoord met de algemene voorwaarden</label> <a href="#">(Bekijk)</a>
					</div>
				</div>
			</div>
		</td>
	</tr>
	<tr>
		<td colspan="4">
			<div class="next-step">
				<button type="submit" class="btn btn-lg btn-block btn-primary"><span class="glyphicon glyphicon-shopping-cart"></span>&nbsp;Stap 4: Bestelling plaatsen</button>
				<p>
					U wordt omgeleid naar onze betaalpagina waar u het totaalbedrag direct kan voldoen.
				</p>
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
</table>
</form>

<script type="text/javascript">
$(document).ready(function() {
    $('.confirm-form').bootstrapValidator({
        message: 'Dit veld is noodzakelijk',
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
			conditions: {
				validators: {
					notEmpty: {
						message: 'U bent niet akkoord gegaan met de voorwaarden'
					}
				}
			}
			
		}
    });
});
</script>
<script src="<?= config('base_url') ?>includes/js/bv.min.js" language="javascript"></script>