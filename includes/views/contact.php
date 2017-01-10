<h1><?= content('page_name_contact', 'Contactpagina'); ?></h1>

<?= content('page_contact_content'); ?>

<hr>

<h2><?= content('page_contact_details', 'Contactgegevens') ?></h2>

<table class="table">
	<tr>
		<th>KVK nummer</th>
		<td><?= config('company_chamber_of_commerce_no'); ?></td>
	</tr>
	<tr>
		<th>BTW nummer</th>
		<td><?= config('company_vat_id'); ?></td>
	</tr>
	<tr>
		<th>Adres gegevens</th>
		<td><?= config('address'); ?></td>
	</tr>
	<tr>
		<th>E-mailadres</th>
		<td><?= config('company_customer_email'); ?></td>
	</tr>
	<tr>
		<th>Telefoonnummer</th>
		<td><?= config('company_customer_phone'); ?></td>
	</tr>
</table>
