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
    <h1>{{ lang('page_customer_details.customer_details') }}</h1>

    <ul class="nav nav-tabs order-tabs">
        <li>
            <a href="{{ route('shopping_bag', ['locale' => loc()]) }}">
                <strong>{{ lang('page_shopping_bag.step', ['no' => 1]) }}</strong>
                {{ lang('page_all.shopping_bag') }}
            </a>
        </li>
        <li class="">
            <a href="{{ route('order.customer_details', ['locale' => loc()]) }}">
                <strong>{{ lang('page_shopping_bag.step', ['no' => 2]) }}</strong>
                {{ lang('page_shopping_bag.customer_details') }}
            </a>
        </li>
        <li class="active">
            <a href="javascript:void(0);">
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

	
	@if($transaction_status == "CONFIRMED")
	<div class="alert alert-warning">
        {!! lang('page_checkout.no_payment') !!}
    </div>
	@else
    <div class="alert alert-info">
        {!! lang('page_checkout.check_info', ['customer_details_route' => route('order.customer_details', ['locale' => loc()])]) !!}
    </div>
    @endif

    <form class="form-horizontal confirm-form bv-form" role="form" method="post">
        <input type="hidden" name="submitting" value="1" />
        <table class="customer-details-overview table table-bordered">
            <thead>
            <tr>
                <th width="33%">{{ lang('page_checkout.invoice_address') }}</th>
                <th width="34%">{{ lang('page_checkout.shipping_address') }}</th>
                <th width="33%">{{ lang('page_checkout.contact_details') }}</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td><?= $transaction['customer_details']['billing_first_name'] ?> <?= $transaction['customer_details']['billing_last_name'] ?></td>
                <td><?= $transaction['customer_details']['shipping_first_name'] ?> <?= $transaction['customer_details']['shipping_last_name'] ?></td>
                <td><?= $transaction['customer_details']['first_name'] ?> <?= $transaction['customer_details']['last_name'] ?></td>
            </tr>
            <tr>
                <td rowspan="2"><?= $transaction['customer_details']['billing_address_1'] ?><?= $transaction['customer_details']['billing_address_2'] ?></td>
                <td rowspan="2"><?= $transaction['customer_details']['shipping_address_1'] ?><?= $transaction['customer_details']['shipping_address_2'] ?></td>
                <td><?= $transaction['customer_details']['email'] ?></td>
            </tr>
            <tr>
                <td><?= $transaction['customer_details']['telephone'] ?></td>
            </tr>
            <tr>
                <td><?= $transaction['customer_details']['billing_postcode'] ?> <?= $transaction['customer_details']['billing_city'] ?></td>
                <td><?= $transaction['customer_details']['shipping_postcode'] ?> <?= $transaction['customer_details']['shipping_city'] ?></td>
            </tr>
            <tr>
                <td><?= $transaction['customer_details']['billing_country'] ?></td>
                <td><?= $transaction['customer_details']['shipping_country'] ?></td>
            </tr>
            </tbody>
        </table>


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
                            {{ $sbi['quantity'] }}
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
                    <td colspan="4">
                        <div class="next-step">
                            <div class="form-group checkbox has-feedback">
                                <div class="col-sm-12">
                                    <label class="confirm"><input type="checkbox" name="conditions"{!! $transaction_status == "CONFIRMED" ? ' checked="checked" disabled="disabled"' : '' !!} data-bv-field="conditions" class="i-agree-with-the-conditions">
                                        {!! lang('page_checkout.accept_terms', ['link_to_terms' => '#']) !!}
                                    </label>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="4" align="right">
                        <div class="next-step">
                        	@if($transaction_status == "CONFIRMED")
                            	<button type="submit" class="btn btn-lg btn-block btn-primary payment-link"><span class="glyphicon glyphicon-shopping-cart"></span>&nbsp;{{ lang('page_checkout.to_payment') }}</button>
                            @else
                            	<button type="submit" class="btn btn-lg btn-block btn-primary payment-link"><span class="glyphicon glyphicon-shopping-cart"></span>&nbsp;{{ lang('page_checkout.confirm_and_to_payment') }}</button>
                            @endif
                            <p>
                                {{ lang('page_checkout.redirect_to_payment_provider') }}
                            </p>
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


@push('post-js')
<script type="text/javascript">
    $(document).ready(function() {
        $('.confirm-form').bootstrapValidator({
            message: '{{ lang('page_customer_details.field_is_mandatory') }}',
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                conditions: {
                    validators: {
                        notEmpty: {
                            message: '{{ lang('fields.agree_with_terms') }}'
                        }
                    }
                }

            }
        });
    });
</script>
<script src="{{ env('BASE_URL', '/') }}js/bv.js" language="javascript"></script>
@endpush