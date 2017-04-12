<?php

/**
 * @author     DropCart <info@dropcart.nl>
 * @copyright  2017  DropCart
 * @license    https://creativecommons.org/licenses/by-nc-nd/3.0/legalcode.txt  CreativeCommons by-nc-nd-3.0
 */

?>


@extends('DefaultPs::layout')

@section('page_title', $page_title)


@section('content')
    <h1>{!! $page_title !!}</h1>

    @if(substr($page_content, 0, 1) == '@')
    {{-- DO INCLUDE --}}
    @include(substr($page_content, 1))
    @else
    {{-- DO PRINT --}}
    {!! $page_content !!}
    @endif
@endsection
