<?php

/**
 * THEME: DEFAULT
 *
 * @author     DropCart <info@dropcart.nl>
 * @copyright  2017  DropCart
 * @license    https://creativecommons.org/licenses/by-nc-nd/3.0/legalcode.txt  CreativeCommons by-nc-nd-3.0
 */
?>
        <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="index,follow">
    <title>
        @hasSection('page_title')
        @yield('page_title') -
        @endif
        {{ env('SITE_NAME', 'DropCart Client Website') }}
    </title>

    <!-- STYLES -->
@include('Default::dynamic.styles')

@stack('styles')

<!-- SCRIPTS -->
    @include('Default::dynamic.pre-js')

    @stack('pre-js')
</head>
<body>
<div class="colorgraph"></div>

<div class="container">
    <div class="row">
        <div class="col-md-3">
            <span style="height:10px; display: block" aria-hidden="true">&nbsp;</span>
            <div class="push-left">
            <!-- <h3 class="text-muted"><?= env('SITE_NAME') ?></h3> -->
                <a href="<?= route('home', ['locale' => loc()]); ?>"><img style="max-height: 94px;"
                                                                          src="<?= route('home', ['locale' => loc()]); ?>/images/logo.png"
                                                                          alt="<?= env('SITE_NAME'); ?>"/></a>
                @if(lang('site_slug') !== 'site_slug')<h4
                        class="slogan"><?= substr(lang('site_slug'), 0, 25) ?></h4>@else
                    <div style="height: 39px;"></div>@endif
            </div>
        </div>
        <div class="col-md-5">
            <form class="form-horizontal" method="get" action="<?= route('products_by_query', ['locale' => loc()]); ?>">
                @if (isset($selected_brands))
                    @foreach($selected_brands as $key => $selected_brand)
                        <input type="hidden" name="brands[{{$key}}]" value="{{$selected_brand}}" />
                    @endforeach
                @endif
                <div class="form-group">
                    <div class="col-sm-12">
                        <h5 class="global-search-title">Zoek in assortiment:</h5>
                        <div class="search input-group" data-initialize="search" role="search">
                            <input id="query" name="query" class="form-control"
                                   placeholder="Naam, beschrijving, EAN of SKU" type="search"
                                   value="{{(isset($query) ? $query : '')}}">
                            <span class="input-group-btn">
		        <button class="btn btn-default" type="submit">
		          <span class="glyphicon glyphicon-search"></span>
		          <span class="sr-only">Search</span>
		        </button>
		      </span>
                        </div>

                    </div>
                </div>
            </form>
        </div>
        <div class="col-md-4">
            @if(env('MULTILINGUAL', FALSE))
                <div class="float-right" style="padding-top: 10px; padding-left: 10px;">
                    @include('Default::blocks.language-switcher')
                </div>
            @endif
            <div class="push-right">
                @include("Default::blocks.pages-menu")
                <div class="float-clear"></div>

                <div id="cart">
                    @include('Default::blocks.shopping-bag')
                </div>

            </div>
        </div>
    </div>

    <div class="masthead">
        @include('Default::blocks.main-menu')
    </div>