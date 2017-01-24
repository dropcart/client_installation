<?php

/**
 * CONTENT FILE FOR DEFAULT THEME
 * DUTCH
 *
 * @author     DropCart <info@dropcart.nl>
 * @copyright  2017  DropCart
 * @license    https://creativecommons.org/licenses/by-nc-nd/3.0/legalcode.txt  CreativeCommons by-nc-nd-3.0
 */

return [
	'footer_text'	=> '© ' . date('Y') . ' - Alle prijzen zijn inclusief BTW - Merknamen zijn alleen gebruikt om de toepasbaarheid van producten aan te geven en dienen verder niet te worden geassocieerd met ' . env('SITE_NAME'),
	'site_slug'		=> 'FANTASTISCH WEBWINKEL',
	'contact'		=> 'Contact',
	'aboutus'		=> 'Over ons',
	'support'		=> 'Support & FAQ',
	'account'		=> 'Mijn account',

	'page_all'		=> [
		'shopping_bag'		=> 'Winkelwagen',
		'articles'			=> 'artikelen',
		'no_articles'		=> 'geen artikelen in winkelwagen.',
	],

	'page_home'			=>  [
			'title'			=> 'Welkom',
			'lead_title'	=> 'Originele toners voor spotprijzen!',
			'lead_text'		=> '1 jaar garantie, 14 dagen bedenktermijn, uitstekende prijs-kwaliteitsverhouding'
	],

	'page_contact'		=> [
		'title'			=> 'Onze contactgegevens',
		'content'		=> '@Default::dynamic.page-contact',

		'emailaddress_desc'	=> 'E-mailadres',
		'emailaddress'		=> 'email@adres.nl',
		'phone_desc'		=> 'Telefoonnummer',
		'phone'				=> '072 532 887 12',
		'address_desc'		=> 'Adres',
		'address'			=> 'Teststraat 123<br>1133 IZ&nbsp;&nbsp;NUENEN<br>Nederland',
		'vat_desc'			=> 'BTW-nummer',
		'vat'				=> 'NL902938336B02',
		'coc_desc'			=> 'KvK-nummer',
		'coc'				=> '232494882',
	],

	'page_aboutus'		=> [
		'title'			=> 'Onze ons',
		'content'		=> 'Wij zijn ' . env('SITE_NAME') . '!',
	],

	'page_support'		=> [
		'title'			=> 'Veelgestelde vragen',
		'content'		=> 'Hieronder vindt u de meest gestelde vragen. Staat uw vraag of gewenste antwoord er niet tussen. <a href="contact">Neem contact met ons op</a>',

		'faq'			=> [
			[
				'q' 		=> 'Waarom zijn jullie zo goedkoop?',
				'a'			=> 'Dit heeft voornamelijk te maken met slim inkopen. Wij kopen onze inktcartridges en toners in bulk in uit (opheffings)uitverkopen, faillissementsverkopen in het binnen en buitenland. Hierdoor kan het voorkomen dat de door ons geleverde producten niet meer in de originele verpakking zitten.'
			],
			[
				'q'			=> 'Wat is de houdbaarheid van de cartridges?',
				'a'			=> 'Inktcartridges en toners is niet te vergelijken met bijvoorbeeld melk. Indien de cartridges ongeopend zijn dan kunnen deze niet "over datum raken". Er zijn wel enkele oudere HP inktcartridges welke een melding geven dat het product "vervallen" is. Zie ook: <a href="http://support.hp.com/us-en/document/c01764161?cCode=us" target="_blank">HP.com Ink Expiration</a> (Engelstalig).'
			]
		]
	],

	'page_product_list' => [
		'title'				=> 'Producten in :category_name',
		'no_products'		=> 'In deze categorie verkopen wij nog geen producten. Maar houd het in de gaten, want we zijn er mee bezig!',
	],

	'product_info'		=> [
		'no_description'	=> ':product_name wordt binnen 24 uur verzonden mits op voorraad. Dat is de service van ' . env('SITE_NAME') . '!',
		'not_in_stock'		=> 'Niet op voorraad, langere levertijd',
		'in_stock'			=> ':stock_quantity op voorraad',
		'delivery_time'		=> 'Leverbaar binnen :shipping_days werkdagen',
		'shipping_included'	=> 'inclusief verzendkosten',
	],

	'no_categories'				=> 'Momenteel verkopen wij nog geen producten. Maar houd ons in de gaten!',

	'pagination'			=> [
		'num_results_on_page'		=> ':count resultaten op deze pagina',
		'of_total'					=> 'van de :count in totaal.',
		'prev_page'					=> 'Vorige pagina',
		'next_page'					=> 'Volgende pagina',
	],


	// CHANGES AT OWN RISK!
	'url_contact'				=> 'contact',
	'url_support'				=> 'support-en-faq',
	'url_aboutus'				=> 'over-ons',
	'url_account'				=> 'mijn-account',
	'url_products_by_category'	=> 'producten/categorie/{category_name}/{category_id}',
	'url_product'				=> 'product/{product_name}/{product_id}',
	'url_shopping_bag'			=> 'winkelmandje'

];