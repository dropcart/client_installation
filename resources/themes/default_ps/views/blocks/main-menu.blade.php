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
        <?php
            $category_counter = 0;
            $rest_categories = [];
        ?>

        @forelse ($DropCart->getCategories() as $category)
            <?php $category_counter++ ?>
                <!-- If you want to add more categories in the menu, up the number below  -->
                @if ($category_counter < 8)
                    <li>
                        <a href="{{ route('products_by_category', [
                                'locale' => loc(),
                                'category_name' => str_slug($category['name']),
                                'category_id' => $category['id']
                        ]) }}" class="category-link" title="{{ $category['description'] }}">
                            {{ $category['name'] }}
                        </a>
                    </li>
                @else
                    <?php
                        $rest_categories[] = $category;
                    ?>
                @endif
        @empty
            <li style="text-align: center; font-weight: bold">&nbsp;&nbsp;{{ lang('no_categories') }}</li>
        @endforelse

        <!-- Adds remaining categories to dropdown menu -->
        @if($rest_categories)
            <li role="presentation" class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                    {{lang('more')}} <span class="caret"></span>
                </a>
                <ul class="dropdown-menu">
                    @foreach($rest_categories as $category)
                        <li>
                            <a href="{{ route('products_by_category', [
                                'locale' => loc(),
                                'category_name' => str_slug($category['name']),
                                'category_id' => $category['id']
                        ]) }}" class="category-link" title="{{ $category['description'] }}">
                                {{ $category['name'] }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </li>
        @endif
    </ul>
</nav>
