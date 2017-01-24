<?php

/**
 * @author     DropCart <info@dropcart.nl>
 * @copyright  2017  DropCart
 * @license    https://creativecommons.org/licenses/by-nc-nd/3.0/legalcode.txt  CreativeCommons by-nc-nd-3.0
 */

$total_price = 0.0;
$total_quantity = 0;
foreach (app('request')->get('shopping_bag') as $pq) {
    $product = $pq['product'];
    $quantity = $pq['quantity'];
    $total_price += (float) ($quantity * $product['price']['price_with_shipment_and_tax']);
    $total_quantity += (int) $quantity;
}
?>

    <h3>
        <a href="{{ route('shopping_bag', ['locale' => loc()]) }}" style="text-decoration: none;">
            <span class="glyphicon glyphicon-shopping-cart"></span> {{ lang('page_all.shopping_bag') }}
        </a>
    </h3>
    <div class="cart-content">
        @if ($total_quantity > 0)
        <span class="cart-items">{{ $total_quantity . ' ' . lang('page_all.articles') }}</span>
        - <span class="cart-total">&euro;&nbsp;{{ number_format($total_price,2,",",".") }}</span>
        @else
            <small><i>{{ lang('page_all.no_articles') }}</i></small>
        @endif
    </div>
