<?php
/**
 * @author     DropCart <info@dropcart.nl>
 * @copyright  2017  DropCart
 * @license    https://creativecommons.org/licenses/by-nc-nd/3.0/legalcode.txt  CreativeCommons by-nc-nd-3.0
 */
?>

@if(isset($transaction) && isset($transaction['warnings']))
    <div class="alert alert-dismissable alert-warning">
        <ul>
            @foreach($transaction['warnings'] as $warning)
                <li>{{ $warning }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if(isset($transaction) && isset($transaction['errors']))
    <div class="alert alert-dismissable alert-error">
        <ul>
            @foreach($transaction['errors'] as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
