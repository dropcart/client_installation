<?php
global $transaction_status;
?>

<?php
if ($transaction_status['status'] == "CONFIRMED"):
?>
<h1>Oops!</h1>

<p>
Er is iets misgegaan tijdens uw betaling. Controlleer goed uw opgegeven e-mail voor
ontvangen berichten: als de betaling toch geslaagd is, ontvangt u een betalingsbevestiging.  
</p>
<p>
<a href="<?= route('checkout', ['submit' => 1]) ?>">Probeer de betaling opnieuw.</a>
</p>
<?php
endif;
if ($transaction_status['status'] == "PAYED"):
?>
<h1>Bedankt voor uw bestelling!</h1>

<p>
We hebben uw betaling ontvangen en u een betalingsbewijs toegezonden. Uw bestelling zal zo spoedig
mogelijk worden geleverd.  
</p>
<?php
endif;
?>