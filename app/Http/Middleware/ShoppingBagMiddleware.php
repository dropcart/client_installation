<?php

namespace App\Http\Middleware;

use Closure;

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

        $sb = "";
        if($request->hasCookie('shopping_bag'))
        {
            try {
                $sb = app('dropcart')->readShoppingBag($request->cookie('shopping_bag'));
            } catch (\Exception $e) { }
        }

        $request->merge([
            'shopping_bag'          => $sb,
            'shopping_bag_internal' => $request->cookie('shopping_bag', "")
        ]);


        return $next($request);
    }
}
