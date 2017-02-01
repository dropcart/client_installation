<?php

/**
 * THEME: DEFAULT
 *
 * @author     DropCart <info@dropcart.nl>
 * @copyright  2017  DropCart
 * @license    https://creativecommons.org/licenses/by-nc-nd/3.0/legalcode.txt  CreativeCommons by-nc-nd-3.0
 */
?>

@extends('Default::layout')

@section('page_title', lang('page_home.title'))


@section('content')

    @if($paid)
        <h1>{{ lang('page_thanks.paid_title') }}</h1>
        {!! lang('page_thanks.paid_content') !!}
    @else
        <h1>{{ lang('page_thanks.unpaid_title') }}</h1>

        {!! lang('page_thanks.unpaid_content') !!}

        <form action="{{ route('order.checkout', ['locale' => loc()]) }}" method="post">
            <p>
                <button class="btn btn-link" type="submit">{{ lang('page_thanks.try_again') }}</button>
            </p>
        </form>
    @endif

@endsection