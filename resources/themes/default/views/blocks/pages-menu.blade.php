<?php

/**
 * @author     DropCart <info@dropcart.nl>
 * @copyright  2017  DropCart
 * @license    https://creativecommons.org/licenses/by-nc-nd/3.0/legalcode.txt  CreativeCommons by-nc-nd-3.0
 */

?>
<nav class="float-right">
    <ul class="nav nav-pills">
        <li><a href="<?= route('contact', ['locale' => loc()]); ?>">{{ lang('contact') }}</a></li>
        <li><a href="<?= route('aboutus', ['locale' => loc()]); ?>">{{ lang("aboutus") }}</a></li>
        <li><a href="<?= route('support', ['locale' => loc()]); ?>">{{ lang('support') }}</a></li>
        <li><a href="<?= route('account', ['locale' => loc()]); ?>">{{ lang('account') }}</a></li>
    </ul>
</nav>
