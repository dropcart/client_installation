<?php

namespace App\Http\Middleware;

use Closure;
use Dropcart\ClientException;
use Mockery\CountValidator\Exception;

class ShoppingBagMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        $clearShoppingBag = false;
        $clearTransaction = false;
        $sb = [];
        if($request->hasCookie('shopping_bag'))
        {
            try {
                $sb = app('dropcart')->readShoppingBag($request->cookie('shopping_bag'));
            } catch (\Exception $e) {
            	$sb = [];
            }
        }

        if($request->hasCookie('transaction_reference') && $request->hasCookie('transaction_checksum'))
        {
            try {
                $transaction_status = app('dropcart')->statusTransaction(
                    $request->cookie('transaction_reference'),
                    $request->cookie('transaction_checksum')
                )['status'];


                if($transaction_status == 'PARTIAL' || $transaction_status == 'FINAL' || $transaction_status == 'CONFIRMED') {
                    $transaction = app('dropcart')->getTransaction(
                        $request->cookie('shopping_bag', ""),
                        $request->cookie('transaction_reference'),
                        $request->cookie('transaction_checksum')
                    );
                } else if($transaction_status == 'PAYED') {
                    $request->merge([
                        'transaction_status' => $transaction_status
                    ]);
                    $clearShoppingBag = $clearTransaction = true;
                } else {
                	// Unknown transaction status: we just clear the transaction.
                    $clearTransaction = true;
                }
            } catch (ClientException $e)
            {
            	// Something went wrong, so better to clear the transaction.
            	// Potentially results in a lost shopping bag.
                $clearShoppingBag = $clearTransaction = true;
            }

        }

        // Do we need to clear the transaction
        if($clearTransaction){
            setcookie('transaction_reference', "0");
            setcookie('transaction_checksum', "0");
        } elseif(isset($transaction)) {
            $request->merge([
                'transaction'          => $transaction,
                'transaction_status'   => $transaction_status,
                'transaction_reference'=> $request->cookie('transaction_reference'),
                'transaction_checksum' => $request->cookie('transaction_checksum'),
            ]);
        }

        // Do we need to clear the shopping bag
        if($clearShoppingBag) {
            setcookie('shopping_bag', "none");
        } else {
        	$request->merge([
            	'shopping_bag'          => $sb,
            	'shopping_bag_internal' => ($clearShoppingBag ? "" : $request->cookie('shopping_bag', ""))
        	]);
        }
        
        return $next($request);
    }
}
