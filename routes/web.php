<?php

/**
 * Custom routes for adding pages. Don't modify.
 * If you want to add custom routes. Use the routes/custom.php file
 *
 * @author     DropCart <info@dropcart.nl>
 * @copyright  2017  DropCart
 * @license    https://creativecommons.org/licenses/by-nc-nd/3.0/legalcode.txt  CreativeCommons by-nc-nd-3.0
 */


include_once __DIR__ . '/custom.php';

$app->get('/', function() use ($app)
{
	$locale = loc();
    return redirect('/' . $locale, 303);
});

$app->group([
    'prefix' => '{locale}',
], function () use ($app)
{
	/** HOME PAGE */
    $app->get('/', ['as' => 'home', function() use ($app)
    {
        return View::make('Current::home');
    }]);

	/** CONTACT PAGE */
    $app->get('/' . lang('url_contact'), ['as' => 'contact', function() use ($app)
    {
        return View::make('Current::static-page', [
            'page_title'    => lang('page_contact.title'),
            'page_name'     => 'contact',
            'page_content'  => lang('page_contact.content')
        ]);
    }]);

	/** ABOUT US PAGE */
    $app->get('/' . lang('url_aboutus'), ['as' => 'aboutus', function() use ($app)
    {
        return View::make('Current::static-page', [
            'page_title'    => lang('page_aboutus.title'),
            'page_name'     => 'aboutus',
            'page_content'  => lang('page_aboutus.content')
        ]);
    }]);

	/** GET SUPPORT PAGE */
    $app->get('/' . lang('url_support'), ['as' => 'support', function() use ($app)
    {

        if(is_array(lang('page_support.faq')))
        {
           return View::make('Current::faq',
               [
                   'page_title'    => lang('page_support.title'),
                   'page_name'     => 'support',
                   'page_content'  => lang('page_support.content'),
                   'faq'           => lang('page_support.faq'),
                ]);
        }
        else {
            View::make('Current::static-page',
                [
                    'page_title'    => lang('page_support.title'),
                    'page_name'     => 'support',
                    'page_content'  => lang('page_support.content'),
                ]);
        }
    }]);

	/** GET ACCOUNT VIEW */
    $app->get('/' . lang('url_account'), ['as' => 'account', function() use ($app)
    {
        return View::make('Current::layout');
    }]);

	/** GET PRODUCTS IN A CATEGORY */
    $app->get('/' . lang('url_products_by_category'), ['as' => 'products_by_category', function($category_name, $category_id) use ($app)
    {
        $request = app('request');
        $show_unavailable_items = !!$request->input('show_unavailable_items', false);
        $selected_brands = $request->input('brands', []);
        if (empty($selected_brands)) {
        	$selected_brands = [];
        }

        $query = $request->input('query', null);
        if (empty($query)) {
        	$query = null;
        }

        $products = [];
        $products   = app('dropcart')->getProductListingByCategory(intval($category_id), $request->input('page', null), $show_unavailable_items, $selected_brands, $query);
        $pagination = $products['pagination'];
        $brands     = $products['brands'];
        $products   = $products['list'];

        return View::make('Current::product-list', [
            'page_title'        => lang('page_product_list.title', ['category_name' => ucfirst($category_name)]),
			'category_name'		=> $category_name,
            'products'          => $products,
        	'brands'            => $brands,
        	'selected_brands'   => $selected_brands,
        	'show_unavailable_items' => $show_unavailable_items,
        	'query'             => $query,
            'pagination'        => $pagination
        ]);
    }]);

    /** GET PRODUCTS BY SEARCH */
    $app->get('/' . lang('url_products_by_query'), ['as' => 'products_by_query', function() use ($app)
    {
        $request = app('request');
        $show_unavailable_items = !!$request->input('show_unavailable_items', false);
        $selected_brands = $request->input('brands', []);
        if (empty($selected_brands)) {
            $selected_brands = [];
        }

        $query = $request->input('query', null);
        if (empty($query)) {
            $query = null;
        }

        $products = [];
        $products   = app('dropcart')->getProductListingBySearch($request->input('page', null), $show_unavailable_items, $selected_brands, $query);
        $pagination = $products['pagination'];
        $brands     = $products['brands'];
        $products   = $products['list'];

        return View::make('Current::product-list', [
            'page_title'        => lang('page_product_list.title', ['category_name' => 'assortiment']),
            'products'          => $products,
            'brands'            => $brands,
            'selected_brands'   => $selected_brands,
            'show_unavailable_items' => $show_unavailable_items,
            'query'             => $query,
            'pagination'        => $pagination
        ]);
    }]);

	/** GET PRODUCT DETAIL VIEW */
    $app->get('/' . lang('url_product'), ['as' => 'product', function($product_name, $product_id) use ($app)
    {
        $product   = app('dropcart')->getProductInfo(intval($product_id));
        
        return View::make('Current::product-info', [
            'page_title'        => lang('page_product_list.title', ['category_name' => ucfirst($product_name)]),
            'product'          => $product,
        ]);
    }]);

	/** DISPLAY SHOPPING BAG */
    $app->get('/' . lang('url_shopping_bag'), ['as' => 'shopping_bag', function() use ($app)
    {
		$data = [
			'page_title'        => lang('page_shopping_bag.title'),
			'shopping_bag'		=> app('request')->get('shopping_bag', [])
		];

		if(app('request')->has('transaction')) {
			$data['transaction'] = app('request')->get('transaction');
			$data['transaction_status'] = app('request')->get('transaction_status');
		}

		return View::make('Current::shopping-bag', $data);
    }]);

	/** WRITE SHOPPING BAG */
    $app->get('/' . lang('url_shopping_bag') . '/{product_id}/{quantity}', ['as' => 'shopping_bag_add', function($product_id, $quantity = 1) use ($app)
    {
    	if (!app('request')->has('transaction') || app('request')->get('transaction_status') != "CONFIRMED") {
    		// Only process shopping bag modifications when not confirmed
    		$shoppingBagInternal	= app('request')->get('shopping_bag_internal', "");
    		if($quantity < 0) {
    			$shoppingBagInternal = app('dropcart')->removeShoppingBag($shoppingBagInternal, intval($product_id), -$quantity);
    		} else {
    			$shoppingBagInternal = app('dropcart')->addShoppingBag($shoppingBagInternal, intval($product_id), $quantity);
    		}
    		setcookie('shopping_bag', $shoppingBagInternal, 0, '/');
    	}
		return redirect()->route('shopping_bag', ['locale' => loc()]);
    }]);

	/** REQUEST CUSTOMER DETAILS */
	$app->get('/' . lang('url_order.customer_details'), ['as' => 'order.customer_details', function()
	{
		if(!app('request')->has('shopping_bag')) {
			return redirect('/');
		}
		if (count(app('request')->get('shopping_bag', [])) < 1) {
			return redirect()->route('shopping_bag', ['locale' => loc()]);
		}
		
		$data = [
			'page_title'=> lang('page_customer_details.title'),
		];

		if(app('request')->has('transaction')) {
			$data['transaction'] = app('request')->get('transaction');
			$data['transaction_status'] = app('request')->get('transaction_status');
			$data['details'] 	 = $data['transaction']['customer_details'];
			$data['diff_billing_shipping'] = (
				@$data['details']['billing_first_name'] != @$data['details']['shipping_first_name'] ||
				@$data['details']['billing_last_name'] 	!= @$data['details']['shipping_last_name'] 	||
				@$data['details']['billing_address_1'] 	!= @$data['details']['shipping_address_1'] 	||
				@$data['details']['billing_address_2'] 	!= @$data['details']['shipping_address_2'] 	||
				@$data['details']['billing_city'] 		!= @$data['details']['shipping_city'] 		||
				@$data['details']['billing_postcode'] 	!= @$data['details']['shipping_postcode'] 	||
				@$data['details']['billing_country'] 	!= @$data['details']['shipping_country']
			);
		}

		return View::make('Current::customer-details', $data);
	}]);

	/** ADD CUSTOMER DETAILS */
	$app->post('/' . lang('url_order.customer_details'), ['as' => 'order.save_customer_details', function()
	{
		if(!app('request')->has('shopping_bag')) {
			return redirect('/');
		}
		if (count(app('request')->get('shopping_bag', [])) < 1) {
			return redirect()->route('shopping_bag', ['locale' => loc()]);
		}
		$request = app('request');

		// Save customer details to transaction
		if (!$request->has('transaction') || $request->get('transaction_status') == "PARTIAL" || $request->get('transaction_status') == "FINAL") {
			$diffSD = (isset($_POST['has_delivery']) && $_POST['has_delivery']);
			$customerDetails = [
				'first_name' 			=> $request->billing_first_name,
				'last_name'				=> $request->billing_last_name,
				'email'					=> $request->email,
				'telephone'				=> $request->telephone,
				'billing_first_name'	=> $request->billing_first_name,
				'billing_last_name'		=> $request->billing_last_name,
				'billing_address_1'		=> $request->billing_address_1,
				'billing_address_2'		=> $request->billing_address_2,
				'billing_city'			=> $request->billing_city,
				'billing_postcode'		=> $request->billing_postcode,
				'billing_country'		=> $request->billing_country,
	
				'shipping_first_name'	=> $diffSD ? $request->shipping_first_name : $request->billing_first_name,
				'shipping_last_name'	=> $diffSD ? $request->shipping_last_name 	: $request->billing_last_name,
				'shipping_address_1'	=> $diffSD ? $request->shipping_address_1 	: $request->billing_address_1,
				'shipping_address_2'	=> $diffSD ? $request->shipping_address_2 	: $request->billing_address_2,
				'shipping_city'			=> $diffSD ? $request->shipping_city 		: $request->billing_city,
				'shipping_postcode'		=> $diffSD ? $request->shipping_postcode 	: $request->billing_postcode,
				'shipping_country'		=> $diffSD ? $request->shipping_country 	: $request->billing_country,
			];
		}

		if($request->has('transaction')) {
			if ($request->get('transaction_status') == "PARTIAL" || $request->get('transaction_status') == "FINAL") {
				// Do not allow updating transactions whenever it is already confirmed.
				$transaction = app('dropcart')->updateTransaction($request->get('shopping_bag_internal', ""), $request->get('transaction_reference', 0), $request->get('transaction_checksum', ""), $customerDetails);
			} else {
				// Retrieve transaction as-is
				$transaction = $request->get('transaction');
			}
		} else {
			$transaction = app('dropcart')->createTransaction($request->get('shopping_bag_internal', ""), $customerDetails);
		}

		if ($transaction['transaction_status'] == "FINAL") {
			setcookie('transaction_reference', $transaction['reference'], 0, '/');
			setcookie('transaction_checksum', $transaction['checksum'], 0, '/');
			// Send thru
			return redirect()->route('order.checkout', ['locale' => loc()]);
		} else {
			setcookie('transaction_reference', $transaction['reference'], 0, '/');
			setcookie('transaction_checksum', $transaction['checksum'], 0, '/');
			
			$data['transaction'] = $transaction;
			$data['transaction_status'] = $transaction['transaction_status'];
			$data['details'] 	 = $transaction['customer_details'];
			$data['diff_billing_shipping'] = (
					@$data['details']['billing_first_name'] != @$data['details']['shipping_first_name'] ||
					@$data['details']['billing_last_name'] 	!= @$data['details']['shipping_last_name'] 	||
					@$data['details']['billing_address_1'] 	!= @$data['details']['shipping_address_1'] 	||
					@$data['details']['billing_address_2'] 	!= @$data['details']['shipping_address_2'] 	||
					@$data['details']['billing_city'] 		!= @$data['details']['shipping_city'] 		||
					@$data['details']['billing_postcode'] 	!= @$data['details']['shipping_postcode'] 	||
					@$data['details']['billing_country'] 	!= @$data['details']['shipping_country']
					);
			
			return View::make('Current::customer-details', $data);
		}
	}]);

	/** CONFIRM DATA */
	$app->get('/' . lang('url_order.checkout'), ['as' => 'order.checkout', function()
	{
		$transaction = app('request')->get('transaction', []);
		if(!isset($transaction['customer_details']) || !app('request')->has('shopping_bag')) {
			return redirect()->route('shopping_bag', ['locale' => loc()]);
		}

		$payment_methods = app('dropcart')->getPaymentMethods();
		
		return View::make('Current::checkout', [
			'page_title'        => lang('page_checkout.title'),
			'shopping_bag'		=> app('request')->get('shopping_bag'),
			'transaction'		=> app('request')->get("transaction", []),
			'payment_methods'	=> $payment_methods,
			'transaction_status' => app('request')->get("transaction_status", "FINAL")
		]);
	}]);

	/** REQUEST PAYMENT */
	$app->post('/' . lang('url_order.checkout'), ['as' => 'order.confirm', function()
	{
		$request = app('request');
		
		if(!isset($request->get('transaction', [])['customer_details']) || !$request->has('shopping_bag'))
		{
			return redirect()->route('shopping_bag', ['locale' => loc()]);
		}
		
		// Check for result
		try {
			$result = app('dropcart')
				->confirmTransaction($request->get('shopping_bag_internal', ""),
									$request->get('transaction_reference', 0),
									$request->get('transaction_checksum', ""),
									route('confirmation', ['locale' => loc()]),
									$request->get('paymentMethod', 'ideal'),
									$request->get('paymentMethodAttributes', []));
		} catch (\Exception $e) {
			\Log::error("Unable to confirm transaction, redirecting back to checkout page", ['exception' => $e]);
			return redirect()->route('order.checkout', ['locale' => loc()]);
		}

		if (isset($result['redirect'])) {
			return redirect()->to($result['redirect']);
		} else {
			return redirect()->route('shopping_bag', ['locale' => loc()]);
		}
	}]);

	/** ORDER CONFIRMATION */
	$app->get('/' . lang('url_order.confirmation'), ['as' => 'confirmation', function()
	{
		if (!app('request')->has('transaction_status')) {
			\Log::warning("Unknown transaction status");
			return abort(404);
		}
		if (app('request')->get('transaction_status') == 'CONFIRMED' || app('request')->has('transaction_status') == 'PAYED') {
			$paid = app('request')->get('transaction_status') == 'PAYED' ? true : false;
			return View::make('Current::confirmation', [
					'paid'	=> $paid
			]);
		} else {
			\Log::error("Invalid transaction status", ['transaction_status' => app('request')->get('transaction_status')]);
			return redirect()->to('/');
		}
	}]);

    /** LOGO ROUTES */
    $app->get('/images/logo-default.png', ['as' => 'images', function()
    {
        $image = app('dropcart')->getLogoDefault();
        return response($image)->header('Content-Type', 'image/png');
    }]);
    $app->get('/images/logo-square.png', ['as' => 'images', function()
    {
        $image = app('dropcart')->getLogoSquare();
        return response($image)->header('Content-Type', 'image/png');
    }]);
    $app->get('/images/logo.png', ['as' => 'images', function()
    {
        $image = app('dropcart')->getLogo();
        return response($image)->header('Content-Type', 'image/png');
    }]);
});

// Template asset management (up to 5 parameters)
$app->get('/css/{p1}',                      ['uses' => 'AssetController@css']);
$app->get('/css/{p1}/{p2}',                 ['uses' => 'AssetController@css']);
$app->get('/css/{p1}/{p2}/{p3}',            ['uses' => 'AssetController@css']);
$app->get('/css/{p1}/{p2}/{p3}/{p4}',       ['uses' => 'AssetController@css']);
$app->get('/css/{p1}/{p2}/{p3}/{p4}/{p5}',  ['uses' => 'AssetController@css']);
$app->get('/js/{p1}',                       ['uses' => 'AssetController@js']);
$app->get('/js/{p1}/{p2}',                  ['uses' => 'AssetController@js']);
$app->get('/js/{p1}/{p2}/{p3}',             ['uses' => 'AssetController@js']);
$app->get('/js/{p1}/{p2}/{p3}/{p4}',        ['uses' => 'AssetController@js']);
$app->get('/js/{p1}/{p2}/{p3}/{p4}/{p5}',   ['uses' => 'AssetController@js']);
$app->get('/img/{p1}',                      ['uses' => 'AssetController@img']);
$app->get('/img/{p1}/{p2}',                 ['uses' => 'AssetController@img']);
$app->get('/img/{p1}/{p2}/{p3}',            ['uses' => 'AssetController@img']);
$app->get('/img/{p1}/{p2}/{p3}/{p4}',       ['uses' => 'AssetController@img']);
$app->get('/img/{p1}/{p2}/{p3}/{p4}/{p5}',  ['uses' => 'AssetController@img']);
