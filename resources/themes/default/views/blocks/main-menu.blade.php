<?php
/**
 * @author     DropCart <info@dropcart.nl>
 * @copyright  2017  DropCart
 * @license    https://creativecommons.org/licenses/by-nc-nd/3.0/legalcode.txt  CreativeCommons by-nc-nd-3.0
 */
?>

<nav>
    <ul class="nav nav-justified">
        <li class="no-stretch">
            <a href="<?= route('home', ['locale' => loc()]); ?>">
                <b class="glyphicon glyphicon-home"></b>
            </a>
        </li>

        @forelse ($DropCart->getCategories() as $category)
        <li>
            <a href="{{ route('products_by_category', [
                    'locale' => loc(),
                    'category_name' => str_slug($category['name']),
                    'category_id' => $category['id']
            ]) }}" title="{{ $category['description'] }}">
                {{ $category['name'] }}
            </a>
        </li>
        @empty
            <li style="text-align: center; font-weight: bold">&nbsp;&nbsp;{{ lang('no_categories') }}</li>
        @endforelse
    </ul>
</nav>
