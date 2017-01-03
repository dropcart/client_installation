<?php
global $shoppingBag;
global $details;
global $transaction;
global $diff_billing_shipping;
?>

<h1>Klantgegevens</h1>

<ul class="nav nav-tabs order-tabs">
	<li class=""><a href="<?= route('shopping_bag'); ?>"><strong>Stap 1)</strong> Winkelwagen</a></li>
	<li class="active"><a href="#"><strong>Stap 2)</strong> Klantgegevens</a></li>
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

<?php
if ($transaction && !isset($_POST['submit'])):
?>
<div class="alert alert-info">
	Vergeet niet onderaan de pagina op de knop "Opslaan" te drukken na het bewerken van de gegevens. 
</div>
<?php
endif;
?>

<form class="form-horizontal register-form bv-form" role="form" method="post" novalidate="novalidate">
	<input type="hidden" name="submit" value="1" />
	<fieldset>

	<div class="form-group has-feedback">
		<label class="col-sm-2 control-label" for="email">E-mailadres</label>
		<div class="col-sm-8">
			<input type="email" class="form-control" name="email" value="<?= @$details['email'] ?>" data-bv-notempty="true" data-bv-emailaddress="true" data-bv-field="email">
			<p class="help-block">Op dit e-mailadres ontvangt u het besteloverzicht, het betalingsbewijs en de verzendingsinformatie.</p>
		</div>
	</div>
	
	<div class="form-group has-feedback">
		<label class="col-sm-2 control-label" for="telephone">Telefoonnummer</label>
		<div class="col-sm-8">
			<input type="text" class="form-control" name="telephone" value="<?= @$details['telephone'] ?>" data-bv-notempty="true" data-bv-field="telephone">
			<p class="help-block">Met dit telefoonnummer nemen wij contact op als wij u dringend willen spreken over uw bestelling.</p>
		</div>
	</div>

	<hr>
	
	<div class="form-group has-feedback">
		<label class="col-sm-2 control-label" for="billing_first_name">Voornaam</label>
		<div class="col-sm-4">
			<input type="text" placeholder="" class="form-control" name="billing_first_name" value="<?= @$details['billing_first_name'] ?>" data-bv-notempty="true" data-bv-field="billing_first_name">
		</div>
	</div>

	<div class="form-group has-feedback">
		<label class="col-sm-2 control-label" for="billing_last_name">Achternaam</label>
		<div class="col-sm-6">
			<input type="text" placeholder="" class="form-control" name="billing_last_name" value="<?= @$details['billing_last_name'] ?>" data-bv-notempty="true" data-bv-field="billing_last_name">
		</div>
	</div>

	<div class="form-group has-feedback">
		<label class="col-sm-2 control-label" for="billing_address_1">Straatnaam en huisnummer</label>
		<div class="col-sm-8">
			<input type="text" class="form-control billing_address_1" name="billing_address_1" value="<?= @$details['billing_address_1'] ?>" data-bv-notempty="true" autocomplete="off" data-bv-field="billing_address_1" /><br />
			<input type="text" class="form-control billing_address_2 double-input" name="billing_address_2" value="<?= @$details['billing_address_2'] ?>" autocomplete="off" data-bv-field="billing_address_2" />
		</div>
	</div>

	<div class="form-group has-feedback">
		<label class="col-sm-2 control-label" for="billing_postcode">Postcode</label>
		<div class="col-sm-3">
			<input type="text" placeholder="1234AB" class="form-control billing_postcode" name="billing_postcode" value="<?= @$details['billing_postcode'] ?>" data-bv-notempty="true" data-bv-field="billing_postcode">
		</div>
		<label class="col-sm-1 control-label" for="billing_city">Plaats</label>
		<div class="col-sm-4">
			<input type="text" class="form-control billing_city" name="billing_city" value="<?= @$details['billing_city'] ?>" data-bv-notempty="true" data-bv-field="billing_city">
		</div>
	</div>

	<div class="form-group">
		<label class="col-sm-2 control-label" for="billing_country">Land</label>
		<div class="col-sm-8">
<?php
$countries = ["Nederland" => "Nederland", "Belgie" => "Belgi&euml;"];
?>
			<select class="form-control" name="billing_country">
<?php
foreach($countries as $value => $country):
?>
				<option value="<?= $value ?>"<?= @$details['billing_country'] == $value ? ' checked="checked"' : '' ?>><?= $country ?></option>
<?php
endforeach;
?>
			</select>
		</div>
	</div>
	
	</fieldset>

	<div class="form-group checkbox">
		<div class="col-sm-2"></div>
		<div class="col-sm-8">
			<label><input type="checkbox" name="has_delivery" id="deliveryAddress"<?= $diff_billing_shipping ? ' selected="selected"' : '' ?> value="1"> Mijn bestelling afleveren op een ander adres</label>
		</div>
	</div>
	
	<fieldset class="delivery" data-toggle="">

	<legend>Afleveradres</legend>

	<div class="form-group has-feedback">
		<label class="col-sm-2 control-label" for="shipping_first_name">Voornaam</label>
		<div class="col-sm-4">
			<input type="text" placeholder="" class="form-control" name="shipping_first_name" value="<?= @$details['shipping_first_name'] ?>" data-bv-notempty="true" data-bv-field="shipping_first_name">
		</div>
	</div>
	
	<div class="form-group has-feedback">
		<label class="col-sm-2 control-label" for="shipping_last_name">Achternaam</label>
		<div class="col-sm-6">
			<input type="text" placeholder="" class="form-control" name="shipping_last_name" value="<?= @$details['shipping_last_name'] ?>" data-bv-notempty="true" data-bv-field="shipping_last_name">
		</div>
	</div>

	<div class="form-group has-feedback">
		<label class="col-sm-2 control-label" for="shipping_address_1">Straatnaam en huisnummer</label>
		<div class="col-sm-8">
			<input type="text" class="form-control shipping_address_1" name="shipping_address_1" value="<?= @$details['shipping_address_1'] ?>" data-bv-notempty="true" autocomplete="off" data-bv-field="shipping_address_1" /><br />
			<input type="text" class="form-control shipping_address_2 double-input" name="shipping_address_2" value="<?= @$details['shipping_address_2'] ?>" autocomplete="off" data-bv-field="shipping_address_2" />
		</div>
	</div>

	<div class="form-group has-feedback">
		<label class="col-sm-2 control-label" for="shipping_postcode">Postcode</label>
		<div class="col-sm-3">
			<input type="text" placeholder="1234AB" class="form-control shipping_postcode" name="shipping_postcode" value="<?= @$details['shipping_postcode'] ?>" data-bv-notempty="true" data-bv-field="shipping_postcode">
		</div>
		<label class="col-sm-1 control-label" for="shipping_city">Plaats</label>
		<div class="col-sm-4">
			<input type="text" class="form-control shipping_city" name="shipping_city" value="<?= @$details['shipping_city'] ?>" data-bv-notempty="true" data-bv-field="shipping_city">
		</div>
	</div>

	<div class="form-group">
		<label class="col-sm-2 control-label" for="shipping_country">Land</label>
		<div class="col-sm-8">
			<select class="form-control" name="shipping_country">
<?php
foreach($countries as $value => $country):
?>
				<option value="<?= $value ?>"<?= @$details['shipping_country'] == $value ? ' selected="selected"' : '' ?>><?= $country ?></option>
<?php
endforeach;
?>
			</select>
		</div>
	</div>
	
	</fieldset>
	
	<hr />
	
	<div class="shopping-bag"></div>

	<div class="form-group">
		<div class="col-sm-offset-2 col-sm-8">
			<div class="next-step">
				<button type="submit" class="btn btn-lg btn-block btn-primary">Opslaan en naar <span class="glyphicon glyphicon-shopping-cart"></span>&nbsp;Stap 3: Afrekenen</a>
			</div>
		</div>
	</div>
</form>

<script type="text/javascript">
function pwd_to_text() {
    $(".pwd").replaceWith($('.pwd').clone().attr('type', 'text'));
    $(".reveal").on('mouseout.dropcart', text_to_pwd);
}
function text_to_pwd() {
	$(".pwd").replaceWith($('.pwd').clone().attr('type', 'password'));
	$(".reveal").off('mouseout.dropcart');
}
$(".reveal").mousedown(pwd_to_text).mouseup(text_to_pwd);

$('#deliveryAddress').click(function() {
	$('.delivery').slideToggle();
});

$('.zipcode, .houseNr, .houseNrAdd').focusout(function() {
	var curThis					= $(this);
	var input_zipcode			= $(curThis).parent().parent().find('.zipcode').val();
	var input_houseNr			= $(curThis).parent().parent().find('.houseNr').val();
	var input_houseNrAdd		= $(curThis).parent().parent().find('.houseNrAdd').val();
	
	if(input_zipcode != '' && input_houseNr != '') {
		$.get( "/includes/json/validateZipcode.php", {
				zipcode		: input_zipcode,
				houseNr		: input_houseNr,
				houseNrAdd	: input_houseNrAdd
			}, function(data) {
				var street			= data.street;
				var houseNr			= data.houseNumber;
				var houseNumberAdd	= data.houseNumberAdd;
				var zipcode 		= data.postcode;
				var city			= data.city;
				
				jQuery(curThis).parent().parent().next().find('.address').val(street);
				jQuery(curThis).parent().parent().next().next().find('.city').val(city);
		}, 'json');
	}
});
$(document).ready(function() {
	$('.register-form').bootstrapValidator({
		message: 'Dit veld is noodzakelijk',
		feedbackIcons: {
			valid: 'glyphicon glyphicon-ok',
			invalid: 'glyphicon glyphicon-remove',
			validating: 'glyphicon glyphicon-refresh'
		}
	});
<?php
if ($transaction):
?>
	$('.register-form').data('bootstrapValidator').validate();
<?php
endif;
?>
<?php
if (!$diff_billing_shipping):
?>
	// After bootstrap validator
	$('.delivery').toggle();
<?php
endif;
?>
});
</script>
<script src="<?= config('base_url') ?>includes/js/bv.min.js" language="javascript"></script>