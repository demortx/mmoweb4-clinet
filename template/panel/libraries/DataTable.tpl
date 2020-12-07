<table class="table table-hover table-vcenter {$class} {$ajax_module}">
    <thead>
    <tr>
        {foreach $DataTable as $bind => $value}
            <th {*data-searchable="{$value.searchable}"*} data-orderable="{$value.orderable}"  data-name="{$bind}">{$value.name}</th>
        {/foreach}
    </tr>
    </thead>
</table>

<style>
    table.dataTable td {
        text-align: center;
    }
    table.dataTable td:first-child {
        text-align: left;
    }
    table.dataTable td:last-child {
        text-align: right;
    }
</style>

<script>
    document.addEventListener("DOMContentLoaded", function(event) {
        var {$ajax_module} = $('.{$ajax_module}').DataTable({
            dom: "<'row'<'col-sm-6 col-md-3'l><'col-sm-6 col-md-3'f><'col-sm-12 col-md-6'B<\"btn-group flex-wrap toolbar_table  ml-5\">>>" +
                "<'row'<'col-sm-12'<\"row gutters-tiny toolbar_table_input mt-5\">tr>>" +
                "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
            pageLength: 30,
            lengthMenu: [[30, 50, 100, 500, 1000], [30, 50, 100, 500, 1000]],
            colReorder: true,
            "order": [],
            "aaSorting": [],
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": "/input",
                "type": "POST",
                "data": function ( data ) {
                    return $.extend( { }, data, {
                        {if $.php.is_array($ajax_post) OR $.php.count($form_add)}
                        "custom": {
                            {if $.php.is_array($ajax_post)}
                            {foreach $ajax_post as $key => $value}
                            "{$key}": "{$value}",
                            {/foreach}
                            {/if}
                            {if $.php.count($form_add)}
                            {foreach $form_add as $in}
                            {foreach $in.inputs as $input}
                            {if $input.___type != 'prepend'}
                            "{$input.name}": $('#{$input.id}').val(),
                            {/if}
                            {/foreach}
                            {/foreach}
                            {/if}
                        },
                        {/if}
                        "module_form": "{$module_form}",
                        "module": "{$ajax_module}"
                    } );
                }
            },
            autoWidth: false,
            fixedHeader: true,
            buttons: [
                'copy', 'csv'
            ]
        });
        {foreach $btn_add as $btn_}
        $("div.toolbar_table").append('<button type="button" class="btn {$btn_.class} {$btn_.trigger}">{$btn_.name}</button>');
        $('body').on('click', '.{$btn_.trigger}', function (event) {
            {if $btn_.confirm?}
            if(!confirm('{$btn_.confirm}'))
                return false;
            {/if}
            if ($('.row_delete:checked').length < 1) {
                alert('No records selected');
                return false;
            }
            send_ajax("module_form={$module_form}&module={$btn_.ajax_module}&"+$('.row_delete:checked').serialize(), false);
        });
        {/foreach}
        {foreach $form_add as $in}
        var $row = $("<div>", {  "class": "{$in.col_class}" });
        var $div = $("<div>", {  "class": "{$in.class}", {$in.att} });
        {foreach $in.inputs as $input}
        {if $input.___type == 'prepend'}
        $div.append('<div class="input-group-prepend input-group-append "><span class="input-group-text font-w600">{$input.name}</span></div>');
        {else}
        $div.append($("<{$input.___type}>", {$.php.json_encode($input)}).change(function(){ {$ajax_module}.ajax.reload(); }));
        {/if}
        {/foreach}
        $row.append($div);
        $("div.toolbar_table_input").append($row);
        {/foreach}
    });
</script>