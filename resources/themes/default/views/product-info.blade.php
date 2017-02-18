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
    <h1>{!! $product['name'] !!}</h1>

    <div class="row">
        <div class="col-md-3 center">
            <img src="{{ ((count($product['images']) > 0) ? $product['images'][0] : env('BASE_URL', '/') . 'includes/images/no_image.gif') }}" class="fill">
        </div>
        <div class="col-md-7">
            {{-- PRODUCT DESCRIPTION --}}
            <p>{{ (!empty($product['description']) ? $product['description'] : lang('product_info.no_description', [
                'product_name' => $product['name']
            ])) }}</p>

            {{-- PRODUCT STOCK --}}
            <div class="float-left stock-shipping-status">
                @if($product['stock'])
                    <div class="label label-success">{{ lang('product_info.in_stock', [
                                'stock_quantity' => $product['stock']
                            ]) }}</div>
                    @if($product['shipping_days'])
                        <div class="label label-info">{{ lang('product_info.delivery_time', [
                                'shipping_days' => $product['shipping_days']
                            ]) }}</div>
                    @endif
                @else
                    <div class="label label-warning">{{ lang('product_info.not_in_stock') }}</div>
                @endif
            </div>

            <div class="float-right product-details">
                <table class="product-id-table">
                    <tr>
                        <th>EAN</th>
                        <td>{{ $product['ean'] }}</td>
                    </tr>
                    <tr>
                        <th>SKU</th>
                        <td>{{ $product['sku'] }}</td>
                    </tr>
                </table>
            </div>

            <div class="clearfix"></div>
        </div>

        {{-- PRODUCT PRICE --}}
        <div class="col-md-2">

            @if(isset($product['price']))
                <h3 class="price">&euro;&nbsp;<?= number_format($product['price']['price_with_shipment_and_tax'],2,",",".") ?> <div class="float-right"><span class="flag-icon flag-icon-<?= strtolower($product['price']['price_for_country']) ?>"></span></div></h3>
                <p class="float-clear">
                    <small><em>{{ lang('product_info.shipping_included') }}</em></small>
                </p>
                <div>
                    <a href="<?= route('shopping_bag_add', ['product_id' => $product['id'], 'quantity' => 1, 'locale' => loc()]); ?>" class="btn btn-lg btn-block btn-primary order-link">
                    	<span class="glyphicon glyphicon-shopping-cart"></span>&nbsp;{{ lang('product_info.order_now') }}
                    </a>
                </div>
            @endif

        </div>
    </div>
@endsection
