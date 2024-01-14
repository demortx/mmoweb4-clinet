<div class="content">
    {include $.php.get_tpl_file('breadcrumb.tpl')}
    <h2 class="content-heading">
        Broadcast
        <a href="{$.php.set_url($.const.ADMIN_URL~'/broadcast/add')}" class="btn btn-sm btn-rounded btn-outline-primary float-right"><i class="fa fa-plus mr-5"></i>{$Broadcast_btn_add}</a>
        <a href="{$.php.set_url($.const.ADMIN_URL~'/broadcast/delete_cache')}" class="btn btn-sm btn-rounded btn-outline-secondary float-right mr-5"><i class="fa fa-braille mr-5"></i>{$Broadcast_btn_delete_cache}</a>
    </h2>
    <div class="block block-rounded">
        <div class="block-content  p-0">

            <table class="table table-hover table-vcenter" id="stream_list">
                <thead>
                <tr>
                    <th style="width: 32px;" data-sort-method='none' class="no-sort"></th>
                    <th style="width: auto;">{$Broadcast_in_platform}</th>
                    <th style="width: auto;">{$Broadcast_streamer_name}</th>
                    <th style="width: 35%;">{$Broadcast_title}</th>
                    <th style="width: auto;" class="no-sort" data-sort-method='none'>{$Broadcast_in_enable}</th>
                    <th class="text-center no-sort" style="width: 13%;" data-sort-method='none'></th>
                </tr>
                </thead>
                <tbody>
                {foreach $stream_list as $stream}
                    <tr>
                        <td class="font-w600"><img src="{$stream.avatar}" width="32"></td>
                        <td>{$stream.platform}</td>
                        <td>{$stream.name}</td>
                        <td>
                            {if $stream.platform != 'other'}
                                <a href="{$stream.stream}&parent={$.php.urlencode($.server['HTTP_HOST'])}" target="_blank">{$stream.title}</a>
                            {/if}
                        </td>
                        <td>
                            <label class="css-control css-control-sm css-control-success css-switch">
                                <input id="{$stream.id}" type="checkbox" class="css-control-input modification_status"  {if $stream.publish == 1}checked=""{/if}>
                                <span class="css-control-indicator"></span>
                            </label>
                        </td>
                        <td class="d-none d-sm-table-cell">
                            <a href="{$.php.set_url($.const.ADMIN_URL~'/broadcast/edit?id='~$stream.id)}" class="btn btn-sm btn-circle btn-alt-primary mr-5 mb-5" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="{$Broadcast_edit_stream}">
                                <i class="fa fa-pencil"></i>
                            </a>
                            <a href="{$.php.set_url($.const.ADMIN_URL~'/broadcast/delete?stream='~$stream.id)}" onclick="return confirm('Are you sure?')" class="btn btn-sm btn-circle btn-alt-danger mr-5 mb-5" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="{$Broadcast_delete_stream}">
                                <i class="fa fa-trash-o"></i>
                            </a>
                        </td>
                    </tr>
                {/foreach}
                </tbody>
            </table>
        </div>
    </div>
</div>
<script>

    document.addEventListener("DOMContentLoaded", function(event) {
        $('.modification_status').on('change', function() {
            var id = $(this).attr('id');
            $.ajax({
                url: "{$.php.set_url($.const.ADMIN_URL~'/broadcast/status', false, false)}",
                data : {
                    "stream": id,
                    "status": this.checked
                },
                type: "POST",
                cache: false,
                dataType: 'json',
                error: function (xhr, ajaxOptions, thrownError) {
                    console.log("Result : " + xhr.responseText);
                }
            }).done(function (response) {
                if(response.text !== undefined){
                    jQuery.notify({
                            icon: response.icon || '',
                            message: response.text,
                            url: response.url || ''
                        },
                        {
                            element: 'body',
                            type: response.status || 'info',
                            allow_dismiss: true,
                            newest_on_top: true,
                            showProgressbar: false,
                            placement: {
                                from: 'top',
                                align: 'right'
                            },
                            offset: 20,
                            spacing: 10,
                            z_index: 10000,
                            delay: response.time_show || 5000,
                            timer: 1000,
                            animate: {
                                enter: 'animated fadeIn',
                                exit: 'animated fadeOutDown'
                            }
                        });
                }

                if(response.popup !== undefined) {
                    jQuery('#modal-ajax').modal('show');
                    $('.modal-ajax-title').html(response.title);
                    $('.modal-ajax-content').html(response.content);
                    $('.modal-ajax-footer').html(response.footer);
                }

                if(response.html !== undefined) {
                    if (response.html_div !== undefined) {
                        $(response.html_div).html(response.html);
                    }
                }
                if(response.location){
                    setTimeout("document.location.href='"+response.location+"'", response.time_sleep);
                }
                if(response.eval){
                    jQuery.globalEval( response.eval );
                }
            });
        });
    });
</script>