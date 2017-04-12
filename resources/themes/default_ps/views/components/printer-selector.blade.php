<?php $h = 'h4' ?>
<h2>{{ lang('printer_selector_title') }}</h2>
<div class="row">
    <div class="col-md-4">
        <<?php echo $h;?>>{{ lang('printer_selector_brand') }} <small>{{ lang('step_one') }}</small></<?php echo $h;?>>

    <select id="printerBrandSelect" name="printerBrand" class="form-control stap1" size="10">
    </select>
</div><!-- /col -->

<div class="col-md-4">
    <<?php echo $h;?>>{{ lang('printer_selector_series') }} <small>{{ lang('step_two') }}</small></<?php echo $h;?>>
<select id="printerSerieSelect" name="printerSerie" class="form-control stap2" size="10" disabled>
</select>
</div><!-- /col -->

<div class="col-md-4">
    <<?php echo $h;?>>{{ lang('printer_selector_type') }} <small>{{ lang('step_three') }}</small></<?php echo $h;?>>
<select id="printerTypeSelect" name="printerType" class="form-control stap3" size="10" disabled>
</select>
</div><!-- /col -->


</div><!-- /row -->

<div class="row">
    <div class="col-md-12">
        <br />
        <a disabled href="#" class="btn btn-primary pull-right submit-btn">{{ lang('show_my_cartridges') }}</a>
    </div><!-- /col-->
</div><!-- /row -->

@push('post-js')
<script>
    // Step 1, fill the brands
    $.get(
        '<?php echo loc().'/'.lang('url_printer_selector_brands') ?>',
        function(data) {
            var index;
            for (index = 0; index < data.length; ++index) {

                $('#printerBrandSelect')
                    .append($("<option></option>")
                        .attr("value",data[index]['id'])
                        .text(data[index]['title']));
            }
        },
        'json'
    );

    // Step 2, fill printer series on brand selection
    $('#printerBrandSelect').change(function(){

        // Create endpoint url, replace variables
        var printerBrandId = $(this).val();
        var endpoint = '<?php echo loc().'/'.lang('url_printer_selector_series')?>';
        endpoint = endpoint.replace('{brand_id}', printerBrandId)

        $.get(
            endpoint,
            function(data) {

                $('#printerSerieSelect').find('option').remove().end();
                $('#printerTypeSelect').find('option').remove().end();

                var index;
                for (index = 0; index < data.length; ++index) {

                    $('#printerSerieSelect')
                        .append($("<option></option>")
                            .attr("value",data[index]['id'])
                            .text(data[index]['title']));
                }

                $('#printerSerieSelect').attr('disabled', false);

                // Auto select first element
                $("#printerSerieSelect").val($("#printerSerieSelect option:first").val());
                $('#printerSerieSelect').trigger("change");

            },
            'json'
        );
    });

    // Step 3, get correct printer types
    $('#printerSerieSelect').change(function(){

        var printerBrandId = $('#printerBrandSelect').val();
        var printerSeriesId = $(this).val();

        // Create endpoint url, replace variables
        var endpoint = '<?php echo loc().'/'.lang('url_printer_selector_types')?>';
        endpoint = endpoint.replace('{brand_id}', printerBrandId);
        endpoint = endpoint.replace('{series_id}', printerSeriesId);

        $.get(
            endpoint,
            function(data) {

                $('#printerTypeSelect').find('option').remove().end();

                var index;
                for (index = 0; index < data.length; ++index) {

                    $('#printerTypeSelect')
                        .append($("<option></option>")
                            .attr("value",data[index]['id'])
                            .text(data[index]['title']));
                }

                $('#printerTypeSelect').attr('disabled', false);

                // Auto select first element
                $("#printerTypeSelect").val($("#printerTypeSelect option:first").val());
                $('.submit-btn').removeAttr('disabled');
            },
            'json'
        );
    });


    $('.submit-btn').click(function(){
        var printerTypeId = $('#printerTypeSelect').val();
        var url = '<?php echo loc().'/'.lang('url_products_by_printer') ?>';
        url = url.replace('{printer_id}', printerTypeId)
        window.location.replace(url);
    });

</script>
@endpush