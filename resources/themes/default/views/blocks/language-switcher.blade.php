<?php

/**
 * @author     DropCart <info@dropcart.nl>
 * @copyright  2017  DropCart
 * @license    https://creativecommons.org/licenses/by-nc-nd/3.0/legalcode.txt  CreativeCommons by-nc-nd-3.0
 */

$languages = list_languages();
list($found, $routeInfo, $params) = app('request')->route() ?: [false, [], []];
$routeName = isset($routeInfo['as']) ? $routeInfo['as'] : null;
?>

@if(count($languages) > 0)
    @foreach($languages as $lang)
        @if(count($languages) - 1 > 1 && !$loop->first)
        |
        @endif
        @if($lang != loc())
            <a href="{{ lang_route($routeName, $lang, $params) }}"><span class="flag-icon flag-icon-{{ ($lang == 'en' ? 'gb' : $lang) }}"></span></a>
        @endif
    @endforeach
@endif
