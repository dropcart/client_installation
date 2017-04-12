<?php

/**
 * @author     DropCart <info@dropcart.nl>
 * @copyright  2017  DropCart
 * @license    https://creativecommons.org/licenses/by-nc-nd/3.0/legalcode.txt  CreativeCommons by-nc-nd-3.0
 */
?>

<div class="row">
    @foreach($faq as $item)
    <div class="col-xs-12">
        <br>
        <ul class="list">
            <li class="faq-question" id="faq-question-{{ $loop->index }}" data-open="{{ $loop->index }}">
                <a href="#question-{{ $loop->index }}">{!! $item['q'] !!}</a>
                <p class="faq-answer" id="faq-answer-{{ $loop->index }}">
                    {!! $item['a'] !!}
                </p>
            </li>
        </ul>
    </div>
    @endforeach
</div>

{{-- FAQ JS FUNCTIONALITY --}}
@push('post-js')
<script type="text/javascript">
    $(document).ready(function()
    {
        if(window.location.hash !== '')
        {
            $('#faq-answer-' + window.location.hash.substring(window.location.hash.indexOf('-') + 1)).addClass('open');
            $('#faq-question-' + window.location.hash.substring(window.location.hash.indexOf('-') + 1)).addClass('open');
        }
        $('.faq-question').click(function(e)
        {
            $('.faq-answer').removeClass('open');
            $('.faq-question').removeClass('open');
            $('#faq-answer-' + $(this).data('open')).toggleClass('open');
            $('#faq-question-' + $(this).data('open')).toggleClass('open');
        })
    });
</script>
@endpush

{{-- FAQ STYLES --}}
@push('styles')
    <style type="text/css" rel="stylesheet" media="screen">
        .faq-question {
            cursor: pointer;
        }
        .faq-question:before {
            content: ' ▸';
            float: right;
            position: relative;
        }
        .faq-question.open:before
        {
            content: ' ▾';
        }
        .faq-question a {
            color: inherit;
            text-decoration: none;
            font-weight: bold;
        }
        .faq-question a:hover {
            text-decoration: underline;
        }
        .faq-answer {
            transition: 1s all linear;
            display: block;
            height: 0px;
            overflow: hidden;
        }
        .faq-answer.open {
            min-height: 10px;
            height: auto;
        }
    </style>
@endpush