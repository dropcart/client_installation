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
        <li>
            <a href="<?= route('order.customer_details', ['locale' => loc()]); ?>">
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
                <tr>
                    <td><img src="{{ ((count($sbi['product']['images']) > 0) ? $sbi['product']['images'][0] : env('BASE_URL', '/') . 'includes/images/no_image.gif') }}" class="fill"></td>
                    <td>
                        <strong><a href="{{ route('product', ['locale' => loc(), 'product_id' => $sbi['product']['id'], 'product_name' => str_slug($sbi['product']['name'])]) }}">{{ $sbi['product']['name'] }}</a></strong>
                        <br>
                        @if($sbi['product']['stock'])
                            <div class="label label-success">{{ lang('product_info.in_stock', [
                                'stock_quantity' => $sbi['product']['stock']
                            ]) }}</div>
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
                        <input type="number" value="{{ $sbi['quantity'] }}" disabled>
                        <br>
                        <a class="btn btn-xs btn-success btn-bag-plus"
                           href="<?= route('shopping_bag_add', [
                                   'locale'        => loc(),
                                   'product_id' => $sbi['product']['id'],
                                   'quantity' => 1]); ?>" alt="+"><span
                                    class="glyphicon glyphicon-plus"></span></a>
                        <a class="btn btn-xs btn-danger btn-bag-minus"
                           href="<?= route('shopping_bag_add', [
                                   'locale'        => loc(),
                                   'product_id' => $sbi['product']['id'],
                                   'quantity' => -1]); ?>" alt="-"><span
                                    class="glyphicon glyphicon-minus"></span></a>
                    </td>
                    <td>
                        &euro;&nbsp;<?= number_format($sbi['product']['price']['price_with_shipment_and_tax'],2,",",".") ?>
                    </td>
                    <td>
                        &euro;&nbsp;<?= number_format($totalPriceProduct,2,",",".") ?>
                    </td>
                </tr>
            @endforeach
            <tfoot>
                <tr>
                    <td colspan="4" align="right">
                        <div class="next-step">
                            @if(isset($transaction))
                                <a href="<?= route('order.checkout', ['locale' => loc()]); ?>" class="btn btn-lg btn-block btn-primary">{{ lang('page_shopping_bag.to_checkout') }} <span class="glyphicon glyphicon-shopping-cart"></span></a>
                                <br>
                            @endif
                                <a href="<?= route('order.customer_details', ['locale' => loc()]); ?>" class="btn btn-lg btn-block btn-primary customer-link">{{ lang('page_shopping_bag.to_customer_details') }} <span class="glyphicon glyphicon-shopping-cart"></span></a>
                        </div>
                    </td>
                    <td>
                        <h3>&euro;&nbsp;<?= number_format($totalPrice,2,",",".") ?></h3>
                        <p>
                            <small>{{ lang('product_info.shipping_included') }}</small>
                        </p>
                    </td>
                </tr>
            </tfoot>
        </tbody>
        @endif
        {{-- END IF HAS PRODUCTS --}}
    </table>
@endsection
