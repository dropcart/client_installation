<?php

namespace App\Http\Middleware;

use Closure;
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
        $sb = "";
        if($request->hasCookie('shopping_bag'))
        {
            try {
                $sb = app('dropcart')->readShoppingBag($request->cookie('shopping_bag'));
            } catch (\Exception $e) { }
        }

        if($request->hasCookie('transaction_reference') && $request->hasCookie('transaction_checksum'))
        {
            try {
                $transaction_status = app('dropcart')->statusTransaction(
                    $request->cookie('transaction_reference'),
                    $request->cookie('transaction_checksum')
                )['status'];

                if($transaction_status == 'PARTIAL' || $transaction_status == 'FINAL')
                {
                    $transaction = app('dropcart')->getTransaction(
                        $request->cookie('shopping_bag', ""),
                        $request->cookie('transaction_reference'),
                        $request->cookie('transaction_checksum')
                    );

                } else if($transaction_status == 'PAYED')
                    $clearShoppingBag = $clearTransaction = true;
                else if ($transaction_status == 'CONFIRMED') {
                    // Do nothing
                }
                else {
                    $clearTransaction = true;
                }

            } catch (Exception $e)
            {
                $clearShoppingBag = $clearTransaction = true;
            }

        }

        // Do we need to clear the transaction
        if($clearTransaction){
            unset($_COOKIE['transaction_reference']);
            setcookie('transaction_reference', null, time()-3600);
            unset($_COOKIE['transaction_checksum']);
            setcookie('transaction_checksum', null, time()-3600);
        }
        else {
            if(isset($transaction))
            {
                $request->merge([
                    'transaction'          => $transaction,
                    'transaction_status'   => $transaction_status,
                    'transaction_reference'=> $request->cookie('transaction_reference'),
                    'transaction_checksum' => $request->cookie('transaction_checksum'),
                ]);
            }
        }


        // Do we need to clear the shopping bag?
        if($clearShoppingBag)
        {
            unset($_COOKIE['shopping_bag']);
            setcookie('shopping_bag', null, time()-3600);
        }
        else {
            $request->merge([
                'shopping_bag'          => $sb,
                'shopping_bag_internal' => $request->cookie('shopping_bag', "")
            ]);
        }




        return $next($request);
    }
}
