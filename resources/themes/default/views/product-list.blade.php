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
    <h1>{!! $page_title or '' !!}</h1>

    <div class="product-list">
        @forelse($products as $product)
            <div class="row">
                {{-- PRODUCT IMAGE --}}
                <div class="col-md-3 center">
                    <img src="{{ (isset($product['images']) && count($product['images']) > 0 ? $product['images'][0] : env('BASE_URL', '/') . 'img/no_image.gif') }}" class="fill">
                </div>

                <div class="col-md-7 color">
                    {{-- PRODUCT TITLE --}}
                    <h3><a class="product-link" href="{{ route('product', [
                        'locale'        => loc(),
                        'product_name'  => str_slug($product['name']),
                        'product_id'    => $product['id']
                    ]) }}">{{ $product['name'] }}</a></h3>

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

                    {{-- PRODUCT INFO --}}
                    <div class="float-right product-details">
                        <table class="product-id-table">
                            <tr>
                                <th>EAN</th>
                                <td><?= $product['ean'] ?></td>
                            </tr>
                            <tr>
                                <th>SKU</th>
                                <td><?= $product['sku'] ?></td>
                            </tr>
                        </table>
                    </div>
                    <div class="float-clear"></div>
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
            @if(!$loop->last) <hr> @endif
        @empty
            <p>{{ lang('page_product_list.no_products') }}</p>
        @endforelse
    </div>

    @if(count($pagination) > 0)
        <div class="pagination-block">
            <p class="info">
                {{ lang('pagination.num_results_on_page', ['count' => $pagination['count']]) }}
                {{ lang('pagination.of_total', ['count' => $pagination['total']]) }}
            </p>

            <ul class="pagination">
                {{-- PREVIOUS PAGE --}}
                @if($pagination['current_page'] < 2)
                    <li class="disabled"><span>{{ lang('pagination.prev_page') }}</span></li>
                @else
                    <li><a href="?page={{ ($pagination['current_page'] - 1) }}" rel="previous">{{ lang('pagination.prev_page') }}</a></li>
                @endif


                {{-- PAGES BEFORE CURRENT --}}
                <?php
                    $maxLength = 6;
                    $maxLengthHalf = round($maxLength / 2)-1;
                ?>

                @if($pagination['total_pages'] == 1)
                    <li class="disabled">1</li>
                @else
                    <li class="{{ $pagination['current_page'] == 1 ? 'active' : '' }}"><a href="?page=1">1</a></li>
                @endif


                @if($pagination['current_page'] > 1)
                    @if($pagination['current_page'] > $maxLengthHalf + 1)
                        <li class="disabled"><span>...</span></li>
                    @endif
                    @for($i = $maxLengthHalf; $i > 0 ; $i--)
                        @if($pagination['current_page'] - $i <= 1)
                            @continue
                        @endif
                        <li>
                            <a href="?page={{ $pagination['current_page'] - $i }}">{{ ($pagination['current_page'] - $i) }}</a>
                        </li>
                    @endfor

                    {{-- ACTIVE PAGE --}}
                    <li class="active"><a href="?page={{ $pagination['current_page']}}">{{ $pagination['current_page']}}</a></li>
                @endif


                @if($pagination['current_page'] < ($pagination['total_pages']))
                    @for($i = $pagination['current_page'] + 1; $i < ($pagination['current_page'] + $maxLengthHalf + 1); $i++)
                        @if($i >= $pagination['total_pages'])
                            @break
                        @endif
                        <li>
                            <a href="?page={{ $i }}">{{ $i }}</a>
                        </li>
                    @endfor
                @endif
                @if($pagination['current_page'] < ($pagination['total_pages'] - $maxLengthHalf - 1))
                        <li class="disabled"><span>...</span></li>
                @endif


                @if($pagination['total_pages'] > 1 && $pagination['current_page'] < $pagination['total_pages'])
                    <li class="{{ $pagination['current_page'] == $pagination['total_pages'] ? 'active' : '' }}"><a href="?page={{ $pagination['total_pages'] }}">{{ $pagination['total_pages'] }}</a></li>
                @endif

                @if($pagination['current_page'] < $pagination['total_pages'])
                    <li><a href="?page={{ ($pagination['current_page'] + 1) }}" rel="next">{{ lang('pagination.next_page') }}</a></li>
                @else
                    <li class="disabled"><span>{{ lang('pagination.next_page') }}</span></li>
                @endif

            </ul>

        </div>


    @endif
@endsection
