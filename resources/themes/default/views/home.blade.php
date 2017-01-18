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
    <h1>{{ lang('page_home.lead_title') }}</h1>
    <p class="lead">
        {{ lang('page_home.lead_text') }}
    </p>
</div>

<div class="row">

</div>
@endsection