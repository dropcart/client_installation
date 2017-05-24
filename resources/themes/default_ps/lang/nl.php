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
	'footer_text'	=> '&copy; ' . date('Y') . ' - Alle prijzen zijn inclusief BTW - Merknamen zijn alleen gebruikt om de toepasbaarheid van producten aan te geven en dienen verder niet te worden geassocieerd met ' . env('SITE_NAME'),
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

	'page_shopping_bag'	=> [
		'title'				=> 'Uw winkelwagen',
		'step'				=> 'Stap :no)',
		'customer_details'	=> 'Uw gegevens',
		'confirm_and_pay'	=> 'Bevestigen en betalen',
		'order_placed'		=> 'Bestelling geplaatst',

		'no_articles'		=> 'U heeft nog geen artikelen in uw winkelwagen. Bestellen is derhalve nog niet mogelijk.',
		'product'			=> 'Product',
		'quantity'			=> 'Aantal',
		'price_per_piece'	=> 'Stukprijs',
		'price'				=> 'Prijs',

		'to_checkout'		=> 'Naar stap 3: Afrekenen',
		'to_customer_details'=> 'Naar stap 2: Uw gegevens',
		'no_payment_read_only' => 'De bestelling is al bevestigd. U kunt deze gegevens daarom niet meer aanpassen, maar alleen lezen: <a href=":checkout_route">klik hier om te betalen</a>.',
	],

	'page_customer_details' => [
		'title'				=> 'Uw gegevens',
		'customer_details'	=> 'Uw gegevens',
		'dont_forget_save'	=> 'Vergeet niet onderaan de pagina op de knop "Opslaan" te drukken na het bewerken van de gegevens.',
		'ship_to_other_address' => 'Mijn bestelling op een ander adres afleveren.',
		'shipping_address'	=> 'Afleveradres',
		'save_and_checkout'	=> 'Opslaan en naar stap 3: Afrekenen',
		
		'field_is_mandatory'=> 'Dit is een verplicht veld',
		'no_payment_read_only' => 'De bestelling is al bevestigd. U kunt deze gegevens daarom niet meer aanpassen, maar alleen lezen: <a href=":checkout_route">klik hier om te betalen</a>.',
		'to_checkout'		=> 'Naar stap 3: Afrekenen',
	],
	
	'fields'				=> [
		'emailaddress'		=> 'E-mailadres',
		'emailaddress_help'	=> 'Op dit e-mailadres ontvangt u het besteloverzicht, het betalingsbewijs en de verzendingsinformatie.',
		
		'phone'				=> 'Telefoonnummer',
		'phone_help'		=> 'Met dit telefoonnummer nemen wij contact op als wij u dringend willen spreken over uw bestelling.',

		'first_name'		=> 'Voorname',
		'last_name'			=> 'Achternaam',

		'street_and_number'	=> 'Straatnaam en huisnummer',
		'zipcode'			=> 'Postcode',
		'area'				=> 'Woonplaats',
		'country'			=> 'Land',

		'agree_with_terms'	=> 'U dient akkoord te gaan met de algemene (verkoop)voorwaarden.',
	],

	'page_home'			=>  [
			'title'			=> 'Welkom',
			'lead_title'	=> 'Originele toners voor spotprijzen!',
			'lead_text'		=> '1 jaar garantie, 14 dagen bedenktermijn, uitstekende prijs-kwaliteitsverhouding'
	],

	'page_contact'		=> [
		'title'			=> 'Onze contactgegevens',
		'content'		=> '@DefaultPs::dynamic.page-contact',

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

	'page_checkout'		=> [
		'title'				=> 'Afrekenen',
		'check_info'		=> 'Controleer de onderstaande informatie goed! Als u een fout ontdekt in het afleveradres, factuuradres of in de contactgegevens, <a href=":customer_details_route">klik hier om deze te wijzigen</a>.',
		'no_payment'        => 'De bestelling is al bevestigd. Het is nog niet gelukt om de betaling te voltooien. Druk nogmaals op onderstaande knop om deze bestelling te betalen.',
		'invoice_address'	=> 'Factuuradres',
		'shipping_address'	=> 'Afleveradres',
		'contact_details'	=> 'Contactgegevens',
		'to_payment'		=> 'Opnieuw naar Betalen',
		'confirm_and_to_payment' => 'Bestelling plaatsen en Betalen',
		'redirect_to_payment_provider' => 'U wordt omgeleid naar onze betaalpagina waar u het totaalbedrag direct kan voldoen.',
		'accept_terms'		=> 'Ik ga akkoord met de algemene voorwaarden <a href=":link_to_terms">(Bekijk)</a>',
		'select_payment_method' => 'Selecteer uw gewenste betaalmethode',
	],

	'page_thanks'		=> [
		'paid_title'	=> 'Bedankt voor uw bestelling!',
		'paid_content'	=> '<p>
								We hebben uw betaling ontvangen en u een betalingsbewijs toegezonden. Uw bestelling zal zo spoedig mogelijk worden geleverd.
							</p>',
		'unpaid_title'	=> 'Er ging iets fout',
		'unpaid_content' => '<p>Er is iets misgegaan tijdens uw betaling. Controlleer goed uw opgegeven e-mail voor ontvangen berichten: als de betaling toch geslaagd is, ontvangt u een betalingsbevestiging.</p>',
		'try_again'		=> 'U kunt de betaling ook opnieuw proberen te doen.'
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
		'title_printer'     => 'Producten geschikt voor de :printer_name',
		'no_products'		=> 'In deze categorie verkopen wij nog geen producten. Maar houd het in de gaten, want we zijn er mee bezig!',
		'filter_brand'		=> 'Filter op merk',
		'filter'			=> 'Filter',
		'search_in_category'=> 'Zoek binnen :category',
        'not_available'    => 'Toon ook producten die niet op voorraad zijn',
	],

	'search_in_products'	=> 'Zoek binnen assortiment',
	'search'				=> 'Zoeken',
	'search_placeholder'	=> 'Naam, beschrijving, EAN of SKU',

	'page_error' => [
		'title'				=> 'Fout',
		'content'			=> 'De pagina bestaat niet of er is een andere fout. We hebben deze opgeslagen en zullen actie ondernemen wanneer nodig.',
		'goto_home'			=> 'Terug naar de landingspagina',
		'goto_back'			=> 'Terug naar de vorige pagina'
	],

	'product_info'		=> [
		'no_description'	=> ':product_name wordt binnen 24 uur verzonden mits op voorraad. Dat is de service van ' . env('SITE_NAME') . '!',
		'not_in_stock'		=> 'Niet op voorraad, langere levertijd',
		'in_stock'			=> ':stock_quantity op voorraad',
		'delivery_time'		=> 'Leverbaar binnen :shipping_days werkdagen',
		'shipping_included'	=> 'inclusief verzendkosten',
		'order_now'         => 'Bestellen',
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
    'url_products_by_query'	    => 'producten',
	'url_products_by_category'	=> 'producten/categorie/{category_name}/{category_id}',
	'url_product'				=> 'product/{product_name}/{product_id}',
	'url_shopping_bag'			=> 'winkelmandje',
	'url_order'	=> [
		'customer_details'		=> 'bestellen/klantgegevens',
		'checkout'				=> 'bestellen/afrekenen',
		'confirmation'			=> 'bestellen/bevestiging'
	],

    // PRINTER SELECTOR ROUTES
    'url_printer_selector_brands'   => 'printer-selector/brands',
    'url_printer_selector_series'   => 'printer-selector/series/{brand_id}',
    'url_printer_selector_types'   => 'printer-selector/{brand_id}/types/{series_id}',
    'url_products_by_printer'   => 'producten/printer/{printer_id}',

    // PRINTER SELECTOR VARS
    'printer_selector_title'    => 'Selecteer uw printer:',
    'printer_selector_brand'    => 'Selecteer merk',
    'printer_selector_series'   => 'Selecteer serie',
    'printer_selector_type'     => 'Selecteer model',
    'show_my_cartridges'        => 'Toon mijn cartridges',

    'step_one'      => 'Stap 1',
    'step_two'      => 'Stap 2',
    'step_three'    => 'Stap 3',

    'more' => "Meer",
];