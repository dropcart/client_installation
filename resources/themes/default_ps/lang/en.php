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
	'footer_text'	=> '&copy; ' . date('Y') . ' - All prices are including VAT - Brand names are only used for the applicability of products and should further not be associated with ' . env('SITE_NAME'),
	'site_slug'		=> 'GREAT WEB STORE',
	'contact'		=> 'Contact',
	'aboutus'		=> 'About us',
	'support'		=> 'Support & FAQ',
	'account'		=> 'My account',

	'page_all'		=> [
		'shopping_bag'		=> 'Cart',
		'articles'			=> 'articles',
		'no_articles'		=> 'no articles in your cart',
	],

	'page_shopping_bag'	=> [
		'title'				=> 'Your cart',
		'step'				=> 'Step :no)',
		'customer_details'	=> 'Your personal details',
		'confirm_and_pay'	=> 'Confirm and pay',
		'order_placed'		=> 'Order is placed',

		'no_articles'		=> 'You don\'t have any articles in your cart. Ordering is therefor not possible.',
		'product'			=> 'Product',
		'quantity'			=> 'Quantity',
		'price_per_piece'	=> 'Unit price',
		'price'				=> 'Price',

		'to_checkout'		=> 'To step 3: Checkout',
		'to_customer_details'=> 'To step 2: your personal details',
	],

	'page_customer_details' => [
		'title'				=> 'Your personal data',
		'customer_details'	=> 'Your personal data',
		'dont_forget_save'	=> 'Don\'t forget to push the "save" button at the bottom after editing your details.',
		'ship_to_other_address' => 'Ship my order to an other address.',
		'shipping_address'	=> 'Shipping address',
		'save_and_checkout'	=> 'Save and to step 3: Checkout',

		'field_is_mandatory'=> 'This field is mandatory',
	],

	'fields'				=> [
		'emailaddress'		=> 'E-mail address',
		'emailaddress_help'	=> 'You\'ll receive the order confirmation, payment confirmation and shipping information on the e-mail address.',

		'phone'				=> 'Phone number',
		'phone_help'		=> 'If we need to speak to you regarding your order we\'ll use this phone number.',

		'first_name'		=> 'First name',
		'last_name'			=> 'Surname',

		'street_and_number'	=> 'Address',
		'zipcode'			=> 'Postcode',
		'area'				=> 'Area',
		'country'			=> 'Country',

		'agree_with_terms'	=> 'You need to agree with the terms.',
	],

	'page_home'			=>  [
		'title'			=> 'Welcome',
		'lead_title'	=> 'Original toners for a bargain!',
		'lead_text'		=> '1 year warranty, 14 days on sight, great value for money'
	],

	'page_contact'		=> [
		'title'			=> 'Our contact details',
		'content'		=> '@DefaultPs::dynamic.page-contact',

		'emailaddress_desc'	=> 'E-mail address',
		'emailaddress'		=> 'email@address.co.uk',
		'phone_desc'		=> 'Phone number',
		'phone'				=> '072 532 887 12',
		'address_desc'		=> 'Address',
		'address'			=> 'Teststraat 123<br>1133 IZ&nbsp;&nbsp;NUENEN<br>Nederland',
		'vat_desc'			=> 'VAT identification',
		'vat'				=> 'NL902938336B02',
		'coc_desc'			=> 'Dutch Chamber of Commerce number',
		'coc'				=> '232494882',
	],

	'page_checkout'		=> [
		'title'				=> 'Checkout',
		'check_info'		=> 'Please check the information below! If you discover a mistake in the shipping or invoice adddress or your contact details, <a href=":customer_details_route">please click here to change those</a>.',
		'invoice_address'	=> 'Invoice address',
		'shipping_address'	=> 'Shipping address',
		'contact_details'	=> 'Contact details',
		'to_payment'		=> 'To payment',
		'redirect_to_payment_provider' => 'You\'ll be redirected to our payment provider where you can pay.',
		'accept_terms'		=> 'I accept the terms and conditions. <a href=":link_to_terms">(View)</a>',
		'select_payment_method' => 'Select your preferred payment method',

	],

	'page_thanks'		=> [
		'paid_title'	=> 'Thanks for your order!',
		'paid_content'	=> '<p>
								We\'ve received your payment and send a confirmation to you e-mail. Your order will be delivered as soon as possible.
							</p>',
		'unpaid_title'	=> 'Oops',
		'unpaid_content' => '<p>Something went wrong with your payment. Please check your e-mail for messages. If the payment did succeed anyway you\'ll receive an e-mail.</p>',
		'try_again'		=> 'You can try to pay again.'
	],

	'page_aboutus'		=> [
		'title'			=> 'About us',
		'content'		=> 'We are ' . env('SITE_NAME') . '!',
	],

	'page_support'		=> [
		'title'			=> 'Frequently Asked Questions',
		'content'		=> 'Below you\'ll vind the frequently asked questions. Not statisfied by the answer? <a href="contact">please contact us</a>',

		'faq'			=> [
			[
				'q' 		=> 'How can you be so cheap?',
				'a'			=> 'This has mainly to do with smart shopping. We buy our inkt cartridges and toners from (closing down) sales, bankruptcy sales, locally and globally. Because of this it may appear that the product is not in it\'s original package.'
			],
			[
				'q'			=> 'What is the shelf-life of the cartridges?',
				'a'			=> 'Cartridges and toners are not like milk. While the cartridges are unopened they can not expire. Some older HP cartridges give an "expired" notification. Please check: <a href="http://support.hp.com/us-en/document/c01764161?cCode=us" target="_blank">HP.com Ink Expiration</a>.'
			]
		]
	],

	'page_product_list' => [
		'title'				=> 'Products in :category_name',
		'no_products'		=> 'In this category we don\'t sell any products yet. But please return while we update the site regularly',
	],

	'page_error' => [
		'title'				=> 'Error',
		'content'			=> 'The requested page doesn\'t exists or something else happened. We\'ve logged this error and will take action if needed.',
		'goto_home'			=> 'Back to the home page',
		'goto_back'			=> 'Back to the previous page'
	],

	'product_info'		=> [
		'no_description'	=> ':product_name will be sent out within 24 uur if we have the product in stock. A service from ' . env('SITE_NAME') . '!',
		'not_in_stock'		=> 'Not in stock, longer delivery time',
		'in_stock'			=> ':stock_quantity item(s) in stock',
		'delivery_time'		=> 'Deliverable within :shipping_days working days',
		'shipping_included'	=> 'shipping included',
	],

	'no_categories'				=> 'We don\'t sell any products yet. But please return soon since we are updating regularly!',

	'pagination'			=> [
		'num_results_on_page'		=> ':count results on this page',
		'of_total'					=> 'of the :count in total.',
		'prev_page'					=> 'Previous page',
		'next_page'					=> 'Next page',
	],


	// CHANGES AT OWN RISK!
	'url_contact'				=> 'contact',
	'url_support'				=> 'support-and-faq',
	'url_aboutus'				=> 'about-us',
	'url_account'				=> 'my-account',
	'url_products_by_category'	=> 'products/category/{category_name}/{category_id}',
	'url_product'				=> 'product/{product_name}/{product_id}',
	'url_shopping_bag'			=> 'cart',
	'url_order'	=> [
		'customer_details'		=> 'order/customer-details',
		'checkout'				=> 'order/checkout',
		'confirmation'			=> 'order/confirmation'
	]

];