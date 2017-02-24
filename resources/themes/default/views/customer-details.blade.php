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
        <li class="active">
            <a href="javascript:void(0);">
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
        {!! lang('page_customer_details.no_payment_read_only', ['checkout_route' => route('order.checkout', ['locale' => loc()])]) !!}
    </div>
	@elseif (!isset($_POST['submit']))
    <div class="alert alert-info">
        {{ lang('page_customer_details.dont_forget_save') }}
    </div>
    @endif

    <form class="form-horizontal register-form bv-form" role="form" method="post">
        <input type="hidden" name="submitting" value="1" />
        <fieldset>

            <div class="form-group has-feedback">
                <label class="col-sm-2 control-label" for="email">{{ lang('fields.emailaddress') }}</label>
                <div class="col-sm-8">
                    <input type="email"{{ (isset($transaction) && $transaction_status == "CONFIRMED") ? ' disabled="disabled"' : '' }} class="form-control" name="email" value="{{ @$details['email'] }}" data-bv-notempty="true" data-bv-emailaddress="true" data-bv-field="email">
                    <p class="help-block">
                        {{ lang('fields.emailaddress_help') }}
                    </p>
                </div>
            </div>

            <div class="form-group has-feedback">
                <label class="col-sm-2 control-label" for="telephone">{{ lang('fields.phone') }}</label>
                <div class="col-sm-8">
                    <input type="text"{{ (isset($transaction) && $transaction_status == "CONFIRMED") ? ' disabled="disabled"' : '' }} class="form-control" name="telephone" value="{{ @$details['telephone'] }}" data-bv-notempty="true" data-bv-field="telephone">
                    <p class="help-block">
                        {{ lang('fields.phone_help') }}
                    </p>
                </div>
            </div>

            <hr>

            <div class="form-group has-feedback">
                <label class="col-sm-2 control-label" for="billing_first_name">{{ lang('fields.first_name') }}</label>
                <div class="col-sm-4">
                    <input type="text"{{ (isset($transaction) && $transaction_status == "CONFIRMED") ? ' disabled="disabled"' : '' }} placeholder="" class="form-control" name="billing_first_name" value="{{ @$details['billing_first_name'] }}" data-bv-notempty="true" data-bv-field="billing_first_name">
                </div>
            </div>

            <div class="form-group has-feedback">
                <label class="col-sm-2 control-label" for="billing_last_name">{{ lang('fields.last_name') }}</label>
                <div class="col-sm-6">
                    <input type="text"{{ (isset($transaction) && $transaction_status == "CONFIRMED") ? ' disabled="disabled"' : '' }} placeholder="" class="form-control" name="billing_last_name" value="{{ @$details['billing_last_name'] }}" data-bv-notempty="true" data-bv-field="billing_last_name">
                </div>
            </div>

            <div class="form-group has-feedback">
                <label class="col-sm-2 control-label" for="billing_address_1">{{ lang('fields.street_and_number') }}</label>
                <div class="col-sm-8">
                    <input type="text"{{ (isset($transaction) && $transaction_status == "CONFIRMED") ? ' disabled="disabled"' : '' }} class="form-control billing_address_1" name="billing_address_1" value="{{ @$details['billing_address_1'] }}" data-bv-notempty="true" autocomplete="off" data-bv-field="billing_address_1" /><br />
                    <input type="text"{{ (isset($transaction) && $transaction_status == "CONFIRMED") ? ' disabled="disabled"' : '' }} class="form-control billing_address_2 double-input" name="billing_address_2" value="{{ @$details['billing_address_2'] }}" autocomplete="off" data-bv-field="billing_address_2" />
                </div>
            </div>

            <div class="form-group has-feedback">
                <label class="col-sm-2 control-label" for="billing_postcode">{{ lang('fields.zipcode') }}</label>
                <div class="col-sm-3">
                    <input type="text"{{ (isset($transaction) && $transaction_status == "CONFIRMED") ? ' disabled="disabled"' : '' }} placeholder="1234AB" class="form-control billing_postcode" name="billing_postcode" value="{{ @$details['billing_postcode'] }}" data-bv-notempty="true" data-bv-field="billing_postcode">
                </div>
                <label class="col-sm-1 control-label" for="billing_city">{{ lang('fields.area') }}</label>
                <div class="col-sm-4">
                    <input type="text"{{ (isset($transaction) && $transaction_status == "CONFIRMED") ? ' disabled="disabled"' : '' }} class="form-control billing_city" name="billing_city" value="{{ @$details['billing_city'] }}" data-bv-notempty="true" data-bv-field="billing_city">
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-2 control-label" for="billing_country">{{ lang('fields.country') }}</label>
                <div class="col-sm-8">
                    <?php
                    $countries = explode(',', env('COUNTRIES', 'Nederland'));
                    ?>
                    <select class="form-control"{{ (isset($transaction) && $transaction_status == "CONFIRMED") ? ' disabled="disabled"' : '' }} name="billing_country">
                        @foreach($countries as $country)
                            <?php $country = trim($country); ?>
                        <option value="{{ $country }}"{{ @$details['billing_country'] == $country ? ' selected' : '' }}>{{ $country }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

        </fieldset>

        <div class="form-group checkbox">
            <div class="col-sm-2"></div>
            <div class="col-sm-8">
                <label><input type="checkbox"{{ (isset($transaction) && $transaction_status == "CONFIRMED") ? ' disabled="disabled"' : '' }} name="has_delivery" id="deliveryAddress"{{ (isset($diff_billing_shipping) && $diff_billing_shipping) ? ' checked' : '' }} value="1"> {{ lang('page_customer_details.ship_to_other_address') }}</label>
            </div>
        </div>

        <fieldset class="delivery" data-toggle="">

            <legend>{{ lang('page_customer_details.shipping_address') }}</legend>

            <div class="form-group has-feedback">
                <label class="col-sm-2 control-label" for="shipping_first_name">{{ lang('fields.first_name') }}</label>
                <div class="col-sm-4">
                    <input type="text"{{ (isset($transaction) && $transaction_status == "CONFIRMED") ? ' disabled="disabled"' : '' }} placeholder="" class="form-control" name="shipping_first_name" value="{{ @$details['shipping_first_name'] }}" data-bv-notempty="true" data-bv-field="shipping_first_name">
                </div>
            </div>

            <div class="form-group has-feedback">
                <label class="col-sm-2 control-label" for="shipping_last_name">{{ lang('fields.last_name') }}</label>
                <div class="col-sm-6">
                    <input type="text"{{ (isset($transaction) && $transaction_status == "CONFIRMED") ? ' disabled="disabled"' : '' }} placeholder="" class="form-control" name="shipping_last_name" value="{{ @$details['shipping_last_name'] }}" data-bv-notempty="true" data-bv-field="shipping_last_name">
                </div>
            </div>

            <div class="form-group has-feedback">
                <label class="col-sm-2 control-label" for="shipping_address_1">{{ lang('fields.street_and_number') }}</label>
                <div class="col-sm-8">
                    <input type="text"{{ (isset($transaction) && $transaction_status == "CONFIRMED") ? ' disabled="disabled"' : '' }} class="form-control shipping_address_1" name="shipping_address_1" value="{{ @$details['shipping_address_1'] }}" data-bv-notempty="true" autocomplete="off" data-bv-field="shipping_address_1" /><br />
                    <input type="text"{{ (isset($transaction) && $transaction_status == "CONFIRMED") ? ' disabled="disabled"' : '' }} class="form-control shipping_address_2 double-input" name="shipping_address_2" value="{{ @$details['shipping_address_2'] }}" autocomplete="off" data-bv-field="shipping_address_2" />
                </div>
            </div>

            <div class="form-group has-feedback">
                <label class="col-sm-2 control-label" for="shipping_postcode">{{ lang('fields.zipcode') }}</label>
                <div class="col-sm-3">
                    <input type="text"{{ (isset($transaction) && $transaction_status == "CONFIRMED") ? ' disabled="disabled"' : '' }} placeholder="1234AB" class="form-control shipping_postcode" name="shipping_postcode" value="{{ @$details['shipping_postcode'] }}" data-bv-notempty="true" data-bv-field="shipping_postcode">
                </div>
                <label class="col-sm-1 control-label" for="shipping_city">{{ lang('fields.area') }}</label>
                <div class="col-sm-4">
                    <input type="text"{{ (isset($transaction) && $transaction_status == "CONFIRMED") ? ' disabled="disabled"' : '' }} class="form-control shipping_city" name="shipping_city" value="{{ @$details['shipping_city'] }}" data-bv-notempty="true" data-bv-field="shipping_city">
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-2 control-label" for="shipping_country">Land</label>
                <div class="col-sm-8">
                    <select class="form-control"{{ (isset($transaction) && $transaction_status == "CONFIRMED") ? ' disabled="disabled"' : '' }} name="shipping_country">
                        @foreach($countries as $country)
                            <?php $country = trim($country); ?>
                            <option value="{{ $country }}"{{ @$details['shipping_country'] == $country ? ' selected' : '' }}>{{ $country }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

        </fieldset>

        <hr />

        <div class="shopping-bag"></div>

        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-8">
                <div class="next-step">
                	@if(isset($transaction) && $transaction_status == "CONFIRMED")
                		<button type="submit" class="btn btn-lg btn-block btn-primary quote-link">{{ lang('page_customer_details.to_checkout') }}</button>
                	@else
                    	<button type="submit" class="btn btn-lg btn-block btn-primary quote-link">{{ lang('page_customer_details.save_and_checkout') }}</button>
                    @endif
                </div>
            </div>
        </div>

    </form>
@endsection


@push('post-js')
<script type="text/javascript">
    function pwd_to_text() {
        $(".pwd").replaceWith($('.pwd').clone().attr('type', 'text'));
        $(".reveal").on('mouseout.dropcart', text_to_pwd);
    }
    function text_to_pwd() {
        $(".pwd").replaceWith($('.pwd').clone().attr('type', 'password'));
        $(".reveal").off('mouseout.dropcart');
    }
    $(".reveal").mousedown(pwd_to_text).mouseup(text_to_pwd);
    $('#deliveryAddress').click(function() {
        $('.delivery').slideToggle();
    });
    $('.zipcode, .houseNr, .houseNrAdd').focusout(function() {
        var curThis					= $(this);
        var input_zipcode			= $(curThis).parent().parent().find('.zipcode').val();
        var input_houseNr			= $(curThis).parent().parent().find('.houseNr').val();
        var input_houseNrAdd		= $(curThis).parent().parent().find('.houseNrAdd').val();

        if(input_zipcode != '' && input_houseNr != '') {
            $.get( "/includes/json/validateZipcode.php", {
                zipcode		: input_zipcode,
                houseNr		: input_houseNr,
                houseNrAdd	: input_houseNrAdd
            }, function(data) {
                var street			= data.street;
                var houseNr			= data.houseNumber;
                var houseNumberAdd	= data.houseNumberAdd;
                var zipcode 		= data.postcode;
                var city			= data.city;

                jQuery(curThis).parent().parent().next().find('.address').val(street);
                jQuery(curThis).parent().parent().next().next().find('.city').val(city);
            }, 'json');
        }
    });
    $(document).ready(function() {
        $('.register-form').bootstrapValidator({
            message: '{{ lang('page_customer_details.field_is_mandatory') }}',
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            }
        });

        @if(isset($transaction) && $transaction_status != "CONFIRMED")
            $('.register-form').data('bootstrapValidator').validate();
        @endif

        @if (!isset($diff_billing_shipping) || !$diff_billing_shipping)
            // After bootstrap validator
            $('.delivery').toggle();
        @endif

    });
</script>
<script src="{{ env('BASE_URL', '/') }}js/bv.js" language="javascript"></script>
@endpush