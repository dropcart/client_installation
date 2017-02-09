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
<div class="jumbotron">
    <h1>{{ lang('page_error.title') }}</h1>
    <p class="lead">
        {{ lang('page_error.content') }}
    </p>
    <ul class="col-xs-6 col-xs-offset-5" style="text-align: left">
        <li><a href="/">{{ lang('page_error.goto_home') }}</a></li>
        <li><a href="javascript:history.back(-1);">{{ lang('page_error.goto_back') }}</a></li>
    </ul>
</div>
@endsection