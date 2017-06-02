<?php

/**
 * @author     DropCart <info@dropcart.nl>
 * @copyright  2017  DropCart
 * @license    https://creativecommons.org/licenses/by-nc-nd/3.0/legalcode.txt  CreativeCommons by-nc-nd-3.0
 */

?>


@extends('Default::layout')

@section('page_title', isset($page_title) ? $page_title : '')


@section('content')
    <h1>{{ lang('page_shopping_bag.title') }}</h1>

    <ul class="nav nav-tabs order-tabs">
        <li class="active">
            <a href="javascript:void(0);">
                <strong>{{ lang('page_shopping_bag.step', ['no' => 1]) }}</strong>
                {{ lang('page_all.shopping_bag') }}
            </a>
        </li>
        <li class="{{ count($shopping_bag) >= 1 ? '' : 'disabled' }}">
            <a href="{{ (count($shopping_bag) >= 1 ? route('order.customer_details', ['locale' => loc()]) : 'javascript:void(0);') }}">
                <strong>{{ lang('page_shopping_bag.step', ['no' => 2]) }}</strong>
                {{ lang('page_shopping_bag.customer_details') }}
            </a>
        </li>
        <li class="{{ isset($transaction) ? '' : 'disabled' }}">
            <a href="{{ (isset($transaction) ? route('order.checkout', ['locale' => loc()]) : 'javascript:void(0);') }}">
                <strong>{{ lang('page_shopping_bag.step', ['no' => 3]) }}</strong>
                {{ lang('page_shopping_bag.confirm_and_pay') }}
            </a>
        </li>
        <li class="disabled">
            <a href="javascript:void(0);">
                <strong>{{ lang('page_shopping_bag.step', ['no' => 4]) }}</strong>
                {{ lang('page_shopping_bag.order_placed') }}
            </a>
        </li>
    </ul>

    @include('Default::blocks.errors-and-warnings')
    
    @if (isset($transaction) && $transaction_status == "CONFIRMED")
	<div class="alert alert-warning">
        {!! lang('page_shopping_bag.no_payment_read_only', ['checkout_route' => route('order.checkout', ['locale' => loc()])]) !!}
    </div>
    @endif
    <table class="shopping-bag table">
        @if(count($shopping_bag) < 1)
            <tbody>
                <td>
                    <div class="alert alert-info center">
                        <h5>{{ lang('page_shopping_bag.no_articles') }}</h5>
                    </div>
                </td>
            </tbody>
        @else
        <thead>
            <tr>
                <th width="10%"></th>
                <th>{{ lang('page_shopping_bag.product') }}</th>
                <th width="14%">{{ lang('page_shopping_bag.quantity') }}</th>
                <th width="12%">{{ lang('page_shopping_bag.price_per_piece') }}</th>
                <th width="12%">{{ lang('page_shopping_bag.price') }}</th>
                <th class="fold"></th>
            </tr>
        </thead>
        <tbody>
            <?php
                    $totalPrice = 0.0;
                    $totalQuantity = 0;
            ?>
            @foreach($shopping_bag as $sbi)
                <?php
                    $totalPriceProduct = ($sbi['product']['price']['price_with_shipment_and_tax'] * $sbi['quantity']);
                    $totalPrice     = $totalPrice + $totalPriceProduct;
                    $totalQuantity  = ($totalQuantity + $sbi['quantity']);
                ?>
                <tr class="{{$sbi['product']['id']}}">
                    <td><img src="{{ ((count($sbi['product']['images']) > 0) ? $sbi['product']['images'][0] : env('BASE_URL', '/') . 'includes/images/no_image.gif') }}" class="fill"></td>
                    <td>
                        <strong><a href="{{ route('product', ['locale' => loc(), 'product_id' => $sbi['product']['id'], 'product_name' => str_slug($sbi['product']['name'])]) }}">{{ $sbi['product']['name'] }}</a></strong>
                        <br>
                        @if($sbi['product']['stock'])
                            @if($sbi['quantity'] > $sbi['product']['stock_quantity'])
                                <div class="label label-warning">{{ lang('product_info.not_enough_stock') }}</div>
                            @else
                                <div class="label label-success">{{ lang('product_info.in_stock', [
                                'stock_quantity' => $sbi['product']['stock']
                            ]) }}</div>
                            @endif
                            @if($sbi['product']['shipping_days'])
                                <div class="label label-info">{{ lang('product_info.delivery_time', [
                                'shipping_days' => $sbi['product']['shipping_days']
                            ]) }}</div>
                            @endif
                        @else
                            <div class="label label-warning">{{ lang('product_info.not_in_stock') }}</div>
                        @endif
                        <table class="product-id-table">
                            <tr>
                                <th>EAN</th>
                                <td><?= $sbi['product']['ean'] ?></td>
                            </tr>
                            <tr>
                                <th>SKU</th>
                                <td><?= $sbi['product']['sku'] ?></td>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <input class="product-quantity" type="text" data-truevalue="<?=$sbi['quantity'];?>" value="<?=$sbi['quantity'];?>" disabled/>
                        @if (!isset($transaction) || $transaction_status != "CONFIRMED")
                            <span data-productid="{{$sbi['product']['id']}}" data-route="<?= route('shopping_bag_add_ajax', [
                                'locale'     => loc(),
                                'product_id' => $sbi['product']['id'],
                                'quantity'   => 1
                            ]); ?>" class="btn btn-xs btn-success btn-bag-plus"  alt="+">
                                <span
                                        class="glyphicon glyphicon-plus"></span>
                            </span>
                            <span data-productid="{{$sbi['product']['id']}}" data-route="<?= route('shopping_bag_add_ajax', [
                                'locale'     => loc(),
                                'product_id' => $sbi['product']['id'],
                                'quantity'   => -1
                            ]); ?>" class="btn btn-xs btn-danger btn-bag-minus"
                                   alt="-"><span
                                        class="glyphicon glyphicon-minus"></span>
                            </span>
                        @endif
                    </td>
                    <td>
                        &euro;&nbsp;<span class="product_piece"><?= number_format($sbi['product']['price']['price_with_shipment_and_tax'],2,",",".") ?></span>
                    </td>
                    <td>
                        &euro;&nbsp;<span class="product_subtotal"><?= number_format($totalPriceProduct,2,",",".") ?></span>
                    </td>
                </tr>
            @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="4" align="right">
                        <div class="next-step">
                            @if(isset($transaction))
                                <a href="<?= route('order.checkout', ['locale' => loc()]); ?>" class="btn btn-lg btn-block btn-primary">{{ lang('page_shopping_bag.to_checkout') }} <span class="glyphicon glyphicon-shopping-cart"></span></a>
                            @else
                                <a href="<?= route('order.customer_details', ['locale' => loc()]); ?>" class="btn btn-lg btn-block btn-primary customer-link">{{ lang('page_shopping_bag.to_customer_details') }} <span class="glyphicon glyphicon-shopping-cart"></span></a>
                            @endif
                        </div>
                    </td>
                    <td>
                        <h3>&euro;&nbsp;<span class="shopping-bag-total"><?= number_format($totalPrice,2,",",".") ?></span></h3>
                        <p>
                            <small>{{ lang('product_info.shipping_included') }}</small>
                        </p>
                    </td>
                </tr>
            </tfoot>
        @endif
        {{-- END IF HAS PRODUCTS --}}
    </table>
@endsection

@push('post-js')
<script>
    $('.btn-bag-minus, .btn-bag-plus').click(function () {

        var product_id = $(this).data('productid');
        var route = $(this).data('route');
        var $product_row = $('tr.' + product_id);
        var $quantity_input = $product_row.find('.product-quantity');
        var current_value = parseInt($quantity_input.val(), 10);

        $product_row.find('.btn-bag-plus, .btn-bag-minus').attr('disabled', true);

        var new_value = 0;

        if ($(this).hasClass('btn-bag-plus')) {
            // add 1 to current value
            new_value = current_value + 1;
        } else {
            // subtract 1 from current_value
            new_value = current_value - 1;
        }

        $.ajax({
            method: 'GET',
            url: route,
            changed_value: new_value
        }).success(function (output) {
            if (output.error === 0) {
                // Set new value
                $quantity_input.val(new_value);

                // Check what came back from the response change the stock message accordingly
                if (output.stock_ok === 0) {
                    $product_row.find('.label').first().removeClass('label-success').addClass('label-warning').text(output.stock_response);
                } else {
                    $product_row.find('.label').first().removeClass('label-warning').addClass('label-success').text(output.stock_response);
                }

                // Calculate total items and update the cart items span
                var amount_products = 0;
                $('.product-quantity').each(function () {
                    amount_products = amount_products + parseInt($(this).val(), 10);
                });

                var total_products = '' + amount_products + ' {{lang('page_all.articles')}}';
                $('.cart-items').text(total_products);

                var sub_total = parseFloat(parseFloat($product_row.find('.product_piece').text().replace(',', '.')) * new_value).toFixed(2).replace('.', ',');
                $product_row.find('.product_subtotal').text(sub_total);

                // Calculate total price of shopping bag and update the total in the header and footer of the shopping bag
                var total = 0.00;
                $('.product_subtotal').each(function () {
                    total = total + parseFloat($(this).text().replace(',', '.'));
                });

                total = total.toFixed(2).replace('.', ',');

                // Format total amount
                total = total.toLocaleString('nl-NL', {
                    style: 'currency',
                    currency: 'EUR',
                    maximumFractionDigits: 2,
                    useGrouping: true
                });

                // Change total amounts on the shopping bag page
                $('.cart-total-amount, .shopping-bag-total').text(total);

                $product_row.find('.btn-bag-plus, .btn-bag-minus').attr('disabled', false);
                // Reload page when quantity is set to 0 to remove product from list
                if (new_value === 0) {
                    window.location.reload();
                }
            }
        });
    });

    // Re-set the values because the cache is interfering
    $(document).ready(function(){
       $('.product-quantity').each(function(){
           var value = $(this).data('truevalue');
           $(this).val(value);
       });
    });
</script>
@endpush
