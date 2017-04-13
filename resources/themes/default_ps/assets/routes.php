<?php

/**
 * Custom routes for adding pages. Don't modify.
 * If you want to add custom routes. Use the routes/custom.php file
 *
 * @author     DropCart <info@dropcart.nl>
 * @copyright  2017  DropCart
 * @license    https://creativecommons.org/licenses/by-nc-nd/3.0/legalcode.txt  CreativeCommons by-nc-nd-3.0
 */

use Psr\Http\Message\RequestInterface;
use GuzzleHttp\Psr7\Request;
use Firebase\JWT\JWT;


$app->get('/', function() use ($app)
{
    $locale = loc();
    return redirect('/' . $locale, 303);
});

$app->group([
    'prefix' => '{locale}',
], function () use ($app) {

    /** GET PRINTER BRANDS */
    $app->get('/' . lang('url_printer_selector_brands'), ['as' => 'printer_brands', function() use ($app) {
        $endpoint = env('DROPCART_ENDPOINT') . '/v2/printer-selector/printers/brands';
        try {
            $request = new Request('GET', $endpoint);

            try {
                // Use static create method to use default Middleware
                $stack = \GuzzleHttp\HandlerStack::create();

                $auth = function (callable $handler) {
                    return function (RequestInterface $request, array $options) use ($handler) {
                        $token = [ 'iss' => env('DROPCART_KEY'), 'iat' => time() ];
                        $jwt = JWT::encode($token, env('DROPCART_SECRET'));
                        $request = $request->withHeader("Authorization", "Bearer " . $jwt);
                        return $handler($request, $options);
                    };
                };

                $stack->push($auth);

                // Construct client with custom stack
                $client = new \GuzzleHttp\Client(['handler' => $stack]);
            } catch (\Exception $any) {
                $this->response->errorNotFound('Authorization error');
            }

            $params = [
                'timeout' => 60.0,
                'connect_timeout' => 30.0,
                'verify' => false
            ];

            $response = $client->send($request, $params);

            $code = $response->getStatusCode();
            $this->context[] = ['code' => $code, 'body' => (string) $response->getBody()];
            if ($code == 200 || $code == 201) {
                $json = json_decode($response->getBody(), true);
                return $json;
            }
        } catch (\Exception $any) {
            $this->response->errorNotFound('Error getting brands');
        }
    }]);

    /** GET PRINTER SERIES */
    $app->get('/' . lang('url_printer_selector_series'), ['as' => 'printer_series', function($brand_id) use ($app) {
        $endpoint = env('DROPCART_ENDPOINT') . '/v2/printer-selector/printers/series';
        try {
            $request = new Request('GET', $endpoint);
            try {
                // Use static create method to use default Middleware
                $stack = \GuzzleHttp\HandlerStack::create();

                $auth = function (callable $handler) {
                    return function (RequestInterface $request, array $options) use ($handler) {
                        $token = [ 'iss' => env('DROPCART_KEY'), 'iat' => time() ];
                        $jwt = JWT::encode($token, env('DROPCART_SECRET'));
                        $request = $request->withHeader("Authorization", "Bearer " . $jwt);
                        return $handler($request, $options);
                    };
                };

                $stack->push($auth);

                // Construct client with custom stack
                $client = new \GuzzleHttp\Client(['handler' => $stack]);
            } catch (\Exception $any) {
                $this->response->errorNotFound('Authorization error');
            }

            $params = [
                'timeout' => 60.0,
                'connect_timeout' => 30.0,
                'verify' => false,
                'json' => ['printerBrandId' => $brand_id]
            ];

            $response = $client->send($request, $params);

            $code = $response->getStatusCode();
            $this->context[] = ['code' => $code, 'body' => (string) $response->getBody()];
            if ($code == 200 || $code == 201) {
                $json = json_decode($response->getBody(), true);
                return $json;
            }
        } catch (\Exception $any) {
            $this->response->errorNotFound('Error getting series');
        }
    }]);

    /** GET PRINTER TYPES */
    $app->get('/' . lang('url_printer_selector_types'), ['as' => 'printer_types', function($brand_id, $series_id) use ($app) {
        $endpoint = env('DROPCART_ENDPOINT') . '/v2/printer-selector/printers/types';
        try {
            $request = new Request('GET', $endpoint);
            try {
                // Use static create method to use default Middleware
                $stack = \GuzzleHttp\HandlerStack::create();

                $auth = function (callable $handler) {
                    return function (RequestInterface $request, array $options) use ($handler) {
                        $token = [ 'iss' => env('DROPCART_KEY'), 'iat' => time() ];
                        $jwt = JWT::encode($token, env('DROPCART_SECRET'));
                        $request = $request->withHeader("Authorization", "Bearer " . $jwt);
                        return $handler($request, $options);
                    };
                };

                $stack->push($auth);

                // Construct client with custom stack
                $client = new \GuzzleHttp\Client(['handler' => $stack]);
            } catch (\Exception $any) {
                $this->response->errorNotFound('Authorization error');
            }

            $params = [
                'timeout' => 60.0,
                'connect_timeout' => 30.0,
                'verify' => false,
                'json' => [
                    'printerBrandId' => $brand_id,
                    'printerSerieId' => $series_id
                ]
            ];

            $response = $client->send($request, $params);

            $code = $response->getStatusCode();
            $this->context[] = ['code' => $code, 'body' => (string) $response->getBody()];
            if ($code == 200 || $code == 201) {
                $json = json_decode($response->getBody(), true);
                return $json;
            }
        } catch (\Exception $any) {
            $this->response->errorNotFound('Error getting types');
        }
    }]);

    /** GET PRODUCTS BY PRINTER */
    $app->get('/' . lang('url_products_by_printer'), ['as' => 'products_by_printer', function($printer_id) use ($app) {
        $request = app('request');
        $locale = loc();

        // Set the selected printer name
        $printer_name = $request->get('printer-brand').' '.$request->get('printer-series').' '.$request->get('printer-type');

        // Always show unavailable items for now
        $show_unavailable_items = !!$request->input('show_unavailable_items', true);

        $selected_brands = $request->input('brands', []);
        if (empty($selected_brands)) {
            $selected_brands = [];
        }

        $param = [];

        // Set parameters
        $query = $request->input('query', null);
        if ($request->input('page')) $param['page'] = (string) $request->input('page');
        if ($query) $param['query'] = (string) $query;

        $products = [];

        // Set endpoint and add parameters
        $endpoint = env('DROPCART_ENDPOINT') . '/v2/printer-selector/' . $printer_id . '/products?country=' . $locale;
        foreach ($param as $key => $value) {
            $endpoint .= "&" . urlencode($key) . "=" . urlencode($value);
        }

        try {
            $request = new Request('GET', $endpoint, $param);

            try {
                // Use static create method to use default Middleware
                $stack = \GuzzleHttp\HandlerStack::create();

                $auth = function (callable $handler) {
                    return function (RequestInterface $request, array $options) use ($handler) {
                        $token = [ 'iss' => env('DROPCART_KEY'), 'iat' => time() ];
                        $jwt = JWT::encode($token, env('DROPCART_SECRET'));
                        $request = $request->withHeader("Authorization", "Bearer " . $jwt);
                        return $handler($request, $options);
                    };
                };

                $stack->push($auth);

                // Construct client with custom stack
                $client = new \GuzzleHttp\Client(['handler' => $stack]);
            } catch (\Exception $any) {
                $this->response->errorNotFound('Authorization error');
            }

            $params = [
                'timeout' => 60.0,
                'connect_timeout' => 30.0,
                'verify' => false
            ];

            $response = $client->send($request, $params);

            $code = $response->getStatusCode();
            $this->context[] = ['code' => $code, 'body' => (string) $response->getBody()];
            if ($code == 200 || $code == 201) {
                $json = json_decode($response->getBody(), true);

                $result = [
                    'list' => [],
                    'pagination' => [],
                    'brands' => [],
                ];
                if (isset($json['data'])) {
                    $result['list'] = $json['data'];
                }
                if (isset($json['meta']) && isset($json['meta']['pagination'])) {
                    $result['pagination'] = $json['meta']['pagination'];
                }
                if (isset($json['meta']) && isset($json['meta']['brands'])) {
                    $result['brands'] = $json['meta']['brands'];
                }
                if (count($result) > 0) {
                    $products = $result;
                }
                // throw new ClientException("Server responded with an error");
            }
        } catch (\Exception $any) {
            $this->response->errorNotFound('Printer not found');
        }

        $pagination = $products['pagination'];
        $brands     = $products['brands'];
        $products   = $products['list'];

        return View::make('Current::product-list', [
            'page_title'        => lang('page_product_list.title_printer', ['printer_name' => $printer_name]),
            'products'          => $products,
            'brands'            => $brands,
            'selected_brands'   => $selected_brands,
            'show_unavailable_items' => $show_unavailable_items,
            'query'             => $query,
            'pagination'        => $pagination
        ]);

    }]);
});
