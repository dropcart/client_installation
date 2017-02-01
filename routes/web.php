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
    $app->get('/', ['as' => 'home', function() use ($app)
    {
        return View::make('Current::home');
    }]);

    $app->get('/' . lang('url_contact'), ['as' => 'contact', function() use ($app)
    {
        return View::make('Current::static-page', [
            'page_title'    => lang('page_contact.title'),
            'page_name'     => 'contact',
            'page_content'  => lang('page_contact.content')
        ]);
    }]);

    $app->get('/' . lang('url_aboutus'), ['as' => 'aboutus', function() use ($app)
    {
        return View::make('Current::static-page', [
            'page_title'    => lang('page_aboutus.title'),
            'page_name'     => 'aboutus',
            'page_content'  => lang('page_aboutus.content')
        ]);
    }]);

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

    $app->get('/' . lang('url_account'), ['as' => 'account', function() use ($app)
    {
        return View::make('Current::layout');
    }]);

    $app->get('/' . lang('url_products_by_category'), ['as' => 'products_by_category', function($category_name, $category_id) use ($app)
    {
        $request = app('request');


        $products = [];
        try {
            $products   = app('dropcart')->getProductListing(intval($category_id), $request->input('page', null));
            $pagination = $products['pagination'];
            $products   = $products['list'];

        } catch (\Exception $e) { abort(404); }


        return View::make('Current::product-list', [
            'page_title'        => lang('page_product_list.title', ['category_name' => ucfirst($category_name)]),
            'products'          => $products,
            'pagination'        => $pagination
        ]);
    }]);


    $app->get('/' . lang('url_product'), ['as' => 'product', function($product_name, $product_id) use ($app)
    {
        try {
            $product   = app('dropcart')->getProductInfo(intval($product_id));

        } catch (\Exception $e) { abort(404); }


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

		if(app('request')->has('transaction'))
			$data['transaction'] =	app('request')->get('transaction');

		return View::make('Current::shopping-bag', $data);
    }]);

	/** WRITE SHOPPING BAG */
    $app->get('/' . lang('url_shopping_bag') . '/{product_id}/{quantity}', ['as' => 'shopping_bag_add', function($product_id, $quantity = 1) use ($app)
    {

		$shoppingBagInternal	= app('request')->get('shopping_bag_internal', "");

		try {
			if($quantity < 0)
				$shoppingBagInternal = app('dropcart')->removeShoppingBag($shoppingBagInternal, intval($product_id), -$quantity);
			else
				$shoppingBagInternal = app('dropcart')->addShoppingBag($shoppingBagInternal, intval($product_id), $quantity);
			
			return redirect()
				->route('shopping_bag', ['locale' => loc()])
				->withCookie(new \Symfony\Component\HttpFoundation\Cookie('shopping_bag', $shoppingBagInternal, time() + 60*60*24*5)); // 5 days
		} catch (Exception $e)
		{
			throw $e;
		}

		$last_url = app('request')->headers->get('referer');
		return redirect($last_url);
    }]);


	$app->get('/' . lang('url_order.customer_details'), ['as' => 'order.customer_details', function()
	{

		if(!app('request')->has('shopping_bag'))
			return redirect('/');


		$data = [
			'page_title'=> lang('page_customer_details.title'),
		];

		if(app('request')->has('transaction')) {
			$data['transaction'] = app('request')->get('transaction');
			$data['details'] 	 = $data['transaction']['customer_details'];
			$data['diff_billling_shipping'] = (
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
	$app->post('/' . lang('url_order.customer_details'), ['as' => 'order.save_customer_details', function()
	{
		$request = app('request');

		// Save customer details to transaction
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

			'shipping_first_name'	=> $diffSD ? $request->shippping_first_name : $request->billing_first_name,
			'shipping_last_name'	=> $diffSD ? $request->shipping_last_name 	: $request->billing_last_name,
			'shipping_address_1'	=> $diffSD ? $request->shipping_address_1 	: $request->billing_address_1,
			'shipping_address_2'	=> $diffSD ? $request->shipping_address_2 	: $request->billing_address_2,
			'shipping_city'			=> $diffSD ? $request->shipping_city 		: $request->billing_city,
			'shipping_postcode'		=> $diffSD ? $request->shipping_postcode 	: $request->billing_postcode,
			'shipping_country'		=> $diffSD ? $request->shipping_country 	: $request->billing_country,
		];

		if($request->has('transaction'))
			$transaction = app('dropcart')->updateTransaction($request->get('shopping_bag_internal', ""), $request->get('transaction_reference', 0), $request->get('transaction_checksum', ""), $customerDetails);
		else
			$transaction = app('dropcart')->createTransaction($request->get('shopping_bag_internal', ""), $customerDetails);


		// Send thru
		return redirect()->route('order.checkout', ['locale' => loc()])
							->withCookie(new \Symfony\Component\HttpFoundation\Cookie('transaction_reference', $transaction['reference']))
							->withCookie(new \Symfony\Component\HttpFoundation\Cookie('transaction_checksum', $transaction['checksum']));
	}]);

	$app->get('/' . lang('url_order.checkout'), ['as' => 'order.checkout', function()
	{
		if(!isset(app('request')->get('transaction', [])['customer_details']) || !app('request')->has('shopping_bag'))
		{
			return redirect()->route('shopping_bag', ['locale' => loc()]);
		}


		return View::make('Current::checkout', [
			'page_title'        => lang('page_checkout.title'),
			'shopping_bag'		=> app('request')->get('shopping_bag'),
			'transaction'		=> app('request')->get("transaction", [])
		]);
	}]);
	$app->post('/' . lang('url_order.checkout'), ['as' => 'order.confirm', function()
	{
		$request = app('request');
		// Check for result
		try {
			$result = app('dropcart')->confirmTransaction($request->get('shopping_bag_internal', ""), $request->get('transaction_reference', 0), $request->get('transaction_checksum', ""), route('thanks', ['locale' => loc()]));

			if (isset($result['redirect'])) {
				return redirect()->to($result['redirect']);
			}
		} catch (Exception $e) {  }

		return redirect()->route('shopping_bag', ['locale' => loc()]);
	}]);

	$app->get('/' . lang('url_thanks'), ['as' => 'thanks'], function()
	{
		return 'Ja bedankt!';
	});
});

// Template asset management
// It is a little dirty yes
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

