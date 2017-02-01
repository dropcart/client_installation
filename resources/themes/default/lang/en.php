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
	'site_slug'		=> 'THE BEST WEB SHOP',
	'contact'		=> 'Contact',
	'aboutus'		=> 'Over ons',
	'support'		=> 'Support & FAQ',
	'account'		=> 'Mijn account',

	'page_all'		=> [
		'shopping_bag'		=> 'Winkelwagen',
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
				'q' 		=> 'How can you be so cheap?',
				'a'			=> 'This has all to do with smart purchasing. We buy cartridges and toners in high volumes from (closing down) sales and bankruptcy sale, locally and globally. Because of this, it may occur that the products are not delivered in the original packages anymore.'
			],
			[
				'q'			=> 'Wat is de houdbaarheid van de cartridges?',
				'a'			=> 'Inktcartridges en toners is niet te vergelijken met bijvoorbeeld melk. Indien de cartridges ongeopend zijn dan kunnen deze niet "over datum raken". Er zijn wel enkele oudere HP inktcartridges welke een melding geven dat het product "vervallen" is. Zie ook: <a href="http://support.hp.com/us-en/document/c01764161?cCode=us" target="_blank">HP.com Ink Expiration</a> (Engelstalig).'
			]
		]
	],

	'no_categories'				=> 'Momenteel verkopen wij nog geen producten. Maar houd ons in de gaten!',


	'url_contact'				=> 'contact',
	'url_support'				=> 'support-and-faq',
	'url_aboutus'				=> 'over-ons',
	'url_account'				=> 'mijn-account',
	'url_products_by_category'	=> 'products/catogory/{category_name}/{category_id}'

];