<h1><?= content('page_name_contact', 'Contactpagina'); ?></h1>

<?= content('page_contact_content'); ?>

<hr>

<h2><?= content('page_contact_details', 'Contactgegevens') ?></h2>

<table class="table">
	<tr>
		<th>KVK nummer</th>
		<td><?= config('chamber_of_commerce_no'); ?></td>
	</tr>
	<tr>
		<th>BTW nummer</th>
		<td><?= config('vat_id'); ?></td>
	</tr>
	<tr>
		<th>Adres gegevens</th>
		<td><?= config('address'); ?></td>
	</tr>
	<tr>
		<th>E-mailadres</th>
		<td><?= config('customer_email'); ?></td>
	</tr>
	<tr>
		<th>Telefoonnummer</th>
		<td><?= config('phone_number'); ?></td>
	</tr>
</table>
