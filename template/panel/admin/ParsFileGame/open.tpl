<div class="block  block-header-default">
    <div class="block-content">
        <div class="row invisible" data-toggle="appear">
            {if $config.project.server_info? AND $.php.is_array($config.project.server_info)}
                {foreach $config.project.server_info as $platform => $server_list}
                    {if $.php.is_array($server_list) AND $.php.count($server_list)}
                        {foreach $server_list as $sid => $server}
                            {if $sid != $select_sid}{continue}{/if}
                            <div class="col-6 col-xl-3">
                                <a class="block block-link-shadow text-right" href="javascript:void(0)">
                                    <div class="block-content block-content-full clearfix">
                                        <div class="font-size-h3 font-w600">{$platform}</div>
                                        <div class="font-size-sm font-w600 text-uppercase text-muted">{$server.name}</div>
                                    </div>
                                </a>
                            </div>
                        {/foreach}
                    {/if}
                {/foreach}
            {/if}
            <div class="col-6 col-xl-3">
                <a class="block block-link-shadow text-right" href="javascript:void(0)">
                    <div class="block-content block-content-full clearfix">
                        <div class="float-left mt-10 d-none d-sm-block">
                            <i class="si si-bag fa-3x text-body-bg-dark"></i>
                        </div>
                        <div class="font-size-h3 font-w600" data-toggle="countTo" data-speed="1000" data-to="{$count_item}">{$count_item}</div>
                        <div class="font-size-sm font-w600 text-uppercase text-muted">{$ParsFileGame_btn_item}</div>
                    </div>
                </a>
            </div>
            <div class="col-6 col-xl-3">
                <a class="block block-link-shadow text-right" href="{$.php.set_url('admin/files/icon?sid='~$select_sid)}">
                    <div class="block-content block-content-full clearfix">
                        <div class="float-left mt-10 d-none d-sm-block">
                            <i class="fa fa-close fa-3x text-body-bg-dark"></i>
                        </div>
                        <div class="font-size-h3 font-w600" data-toggle="countTo" data-speed="1000" data-to="{$no_icon}">{$no_icon}</div>
                        <div class="font-size-sm font-w600 text-uppercase text-muted">{$ParsFileGame_btn_item_no_icon}</div>
                    </div>
                </a>
            </div>
            <div class="col-6 col-xl-3">
                <a class="block block-link-shadow text-right" href="{$.php.set_url('admin/files/delete?sid='~$select_sid)}">
                    <div class="block-content block-content-full clearfix">
                        <div class="float-left mt-10 d-none d-sm-block">
                            <i class="fa fa-trash fa-3x text-body-bg-dark"></i>
                        </div>
                        <div class="font-size-h3 font-w600">{$ParsFileGame_btn_del_bd_desc}</div>
                        <div class="font-size-sm font-w600 text-uppercase text-muted">{$ParsFileGame_btn_del_bd_title}</div>
                    </div>
                </a>
            </div>
            <!-- END Row #1 -->
        </div>
    </div>
</div>

<div class="block">
    <div class="block-content">
        <table class="table table-borderless table-striped">
            <thead>
            <tr>
                <th>File</th>
                <th>Status</th>
                <th class="text-right">Dir</th>
            </tr>
            </thead>
            <tbody>
            {foreach $files_check as $file_name => $file_dir}
                <tr>
                    <td>
                        <span class="font-w600" >{$file_name}</span>
                    </td>
                    <td>
                        {if $file_dir !== true}<span class="badge badge-danger">{$ParsFileGame_item_no_find}</span>{else}<span class="badge badge-success">{$ParsFileGame_item_find}</span>{/if}
                    </td>
                    <td class="text-right">
                        <span class="text-black">{if $file_dir === true} {else}{$file_dir}{/if}</span>
                    </td>
                </tr>
            {/foreach}
            </tbody>
        </table>
        <div class="text-center mt-10">
        <h6>{$ParsFileGame_img_dir}</h6>
        <p>/template/panel/assets/media/icon/{$select_sid}/</p>
        </div>
    </div>
</div>

<div class="block">
    <div class="block-content text-center">
        {if $select_platform == 'lineage2'}

            <form action="{$.php.set_url('/admin/files/parser?sid='~$select_sid, false)}" method="post" onsubmit="return false;">


                <div class="form-group row">
                    <label class="col-12">{$ParsFileGame_files_format}</label>
                    <div class="col-12">
                        <div class="custom-control custom-radio custom-control-inline mb-5">
                            <input class="custom-control-input" type="radio" name="type" id="type1" value="L2FileEdit" checked="">
                            <label class="custom-control-label" for="type1">L2FileEdit</label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline mb-5">
                            <input class="custom-control-input" type="radio" name="type" id="type2" value="L2ClientDat">
                            <label class="custom-control-label" for="type2">L2ClientDat</label>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-12">
                        <button type="submit" class="btn btn-alt-primary submit-form">{$ParsFileGame_btn_pars}</button>
                    </div>
                </div>
            </form>

        {/if}




    </div>
</div>


