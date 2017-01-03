<h1>Winkelwagen</h1>

<ul class="nav nav-tabs">
	<li class=""><a href="<?= route('shopping_bag'); ?>"><strong>Stap 1)</strong> Winkelwagen</a></li>
	<li class="active"><a href="#"><strong>Stap 2)</strong> Klantgegevens</a></li>
	<li class="disabled"><a href="#"><strong>Stap 3)</strong> Afrekenen</a></li>
	<li class="disabled"><a href="#"><strong>Stap 4)</strong> Bestelling geplaatst</a></li>
</ul>

<div class="shopping-bag"></div>

<form class="form-horizontal register-form bv-form" role="form" method="post" novalidate="novalidate">
	<fieldset>

	<div class="form-group has-feedback">
		<label class="col-sm-2 control-label" for="email">E-mailadres</label>
		<div class="col-sm-8">
			<input type="email" class="form-control" name="email" value="" data-bv-notempty="true" data-bv-emailaddress="true" data-bv-field="email">
			<p class="help-block">Op dit e-mailadres ontvangt u het besteloverzicht, het betalingsbewijs en de verzendingsinformatie.</p>
		</div>
	</div>
	
	<div class="form-group has-feedback">
		<label class="col-sm-2 control-label" for="telephone">Telefoonnummer</label>
		<div class="col-sm-8">
			<input type="text" class="form-control" name="telephone" value="" data-bv-notempty="true" data-bv-field="telephone">
			<p class="help-block">Met dit telefoonnummer nemen wij contact op als wij u dringend willen spreken over uw bestelling.</p>
		</div>
	</div>

	<div class="form-group has-feedback">
		<label class="col-sm-2 control-label" for="textinput">Wachtwoord</label>
		<div class="col-sm-8">
			<div class="input-group">
				<input type="password" class="form-control pwd" value="" name="password" data-bv-notempty="true" data-bv-message="Dit veld is verplicht" data-bv-field="password"><i class="form-control-feedback" data-bv-icon-for="password" style="display: none;"></i>
				<span class="input-group-btn">
					<button class="btn btn-default reveal" type="button"><i class="glyphicon glyphicon-eye-open"></i></button>
				</span>
			</div>
			<p class="help-block">Een uniek wachtwoord is een veilig wachtwoord. Dit wachtwoord gebruikt u om de status van uw bestelling te bekijken.</p>
		</div>
	</div>

	<hr>
	
	<div class="form-group has-feedback">
		<label class="col-sm-2 control-label" for="billing_first_name">Voornaam</label>
		<div class="col-sm-4">
			<input type="text" placeholder="" class="form-control" name="billing_first_name" value="" data-bv-notempty="true" data-bv-field="billing_first_name">
		</div>
	</div>

	<div class="form-group has-feedback">
		<label class="col-sm-2 control-label" for="billing_last_name">Achternaam</label>
		<div class="col-sm-6">
			<input type="text" placeholder="" class="form-control" name="billing_last_name" value="" data-bv-notempty="true" data-bv-field="billing_last_name">
		</div>
	</div>

	<div class="form-group has-feedback">
		<label class="col-sm-2 control-label" for="billing_address_1">Straatnaam en huisnummer</label>
		<div class="col-sm-8">
			<input type="text" class="form-control billing_address_1" name="billing_address_1" value="" data-bv-notempty="true" autocomplete="off" data-bv-field="billing_address_1" /><br />
			<input type="text" class="form-control billing_address_2 double-input" name="billing_address_2" value="" autocomplete="off" data-bv-field="billing_address_2" />
		</div>
	</div>

	<div class="form-group has-feedback">
		<label class="col-sm-2 control-label" for="billing_postcode">Postcode</label>
		<div class="col-sm-3">
			<input type="text" placeholder="1234AB" class="form-control billing_postcode" name="billing_postcode" value="" data-bv-notempty="true" data-bv-field="billing_postcode">
		</div>
		<label class="col-sm-1 control-label" for="billing_city">Plaats</label>
		<div class="col-sm-4">
			<input type="text" class="form-control billing_city" name="billing_city" value="" data-bv-notempty="true" data-bv-field="billing_city">
		</div>
	</div>

	<div class="form-group">
		<label class="col-sm-2 control-label" for="billing_country">Land</label>
		<div class="col-sm-8">
			<select class="form-control" name="billing_country">
				<option value="nl">Nederland</option>
				<option value="be">Belgi&euml;</option>
			</select>
		</div>
	</div>
	
	</fieldset>

	<div class="form-group checkbox">
		<div class="col-sm-2"></div>
		<div class="col-sm-8">
			<label><input type="checkbox" name="has_delivery" id="deliveryAddress" value="1"> Mijn bestelling afleveren op een ander adres</label>
		</div>
	</div>
	
	<fieldset class="delivery" data-toggle="">

	<legend>Afleveradres</legend>

	<div class="form-group has-feedback">
		<label class="col-sm-2 control-label" for="shipping_first_name">Voornaam</label>
		<div class="col-sm-4">
			<input type="text" placeholder="" class="form-control" name="shipping_first_name" value="" data-bv-notempty="true" data-bv-field="shipping_first_name">
		</div>
	</div>
	
	<div class="form-group has-feedback">
		<label class="col-sm-2 control-label" for="shipping_last_name">Achternaam</label>
		<div class="col-sm-6">
			<input type="text" placeholder="" class="form-control" name="shipping_last_name" value="" data-bv-notempty="true" data-bv-field="shipping_last_name">
		</div>
	</div>

	<div class="form-group has-feedback">
		<label class="col-sm-2 control-label" for="shipping_address_1">Straatnaam en huisnummer</label>
		<div class="col-sm-8">
			<input type="text" class="form-control shipping_address_1" name="shipping_address_1" value="" data-bv-notempty="true" autocomplete="off" data-bv-field="shipping_address_1" /><br />
			<input type="text" class="form-control shipping_address_2 double-input" name="shipping_address_2" value="" autocomplete="off" data-bv-field="shipping_address_2" />
		</div>
	</div>

	<div class="form-group has-feedback">
		<label class="col-sm-2 control-label" for="shipping_postcode">Postcode</label>
		<div class="col-sm-3">
			<input type="text" placeholder="1234AB" class="form-control shipping_postcode" name="shipping_postcode" value="" data-bv-notempty="true" data-bv-field="shipping_postcode">
		</div>
		<label class="col-sm-1 control-label" for="shipping_city">Plaats</label>
		<div class="col-sm-4">
			<input type="text" class="form-control shipping_city" name="shipping_city" value="" data-bv-notempty="true" data-bv-field="shipping_city">
		</div>
	</div>

	<div class="form-group">
		<label class="col-sm-2 control-label" for="shipping_country">Land</label>
		<div class="col-sm-8">
			<select class="form-control" name="shipping_country">
				<option value="nl">Nederland</option>
				<option value="be">Belgi&euml;</option>
			</select>
		</div>
	</div>
	
	</fieldset>
	
	<hr />
	
	<div class="shopping-bag"></div>

	<div class="form-group">
		<div class="col-sm-offset-2 col-sm-8">
			<div class="next-step">
				<button type="submit" class="btn btn-lg btn-block btn-primary"><span class="glyphicon glyphicon-shopping-cart"></span>&nbsp;Stap 3: Afrekenen</a>
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
	// After bootstrap validator
    $('.delivery').toggle();
});
</script>
<script src="<?= config('base_url') ?>includes/js/bv.min.js" language="javascript"></script>