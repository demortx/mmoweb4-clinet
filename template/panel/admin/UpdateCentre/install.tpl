<div class="content">
    {include $.php.get_tpl_file('breadcrumb.tpl')}

    <div class="row no-gutters d-flex justify-content-center">
        <div class="col-md-10 col-xl-7">
            <h2>{$UpdateCentre_title_install_1} MmoWeb {$version} {$UpdateCentre_title_install_2} {$new_version}</h2>
            <div class="d-flex justify-content-between">
                <a class="btn btn-hero btn-alt-secondary" href="{$.php.set_url($.const.ADMIN_URL~'/updating')}">
                    <i class="fa fa-refresh mr-5"></i> {$UpdateCentre_btn_check}
                </a>
            </div>
            <hr>
            {if $check_update}
                {if $new_version}
                    {if $update_version != true}
                        <div class="alert alert-warning d-flex align-items-center justify-content-between mb-15" role="alert">
                            <div class="flex-fill mr-10">
                                <p class="mb-0">{$UpdateCentre_error} {$update_version}!</p>
                            </div>
                            <div class="flex-00-auto">
                                <i class="fa fa-fw fa-2x fa-exclamation-triangle"></i>
                            </div>
                        </div>
                        {if $logs[$upd.version]}
                            <textarea class="form-control" rows="{$.php.count($logs['sys'])}">{foreach $logs['sys'] as $line}- {$line}{$.const.PHP_EOL}{/foreach}</textarea>
                        {/if}

                    {else}
                        <div id="accordion2" role="tablist" aria-multiselectable="true">
                            {foreach $update_list as $i => $upd}
                                <div class="block block-bordered block-rounded mb-2">
                                    <div class="block-header" role="tab" id="accordion_update">
                                        <a class="font-w600" data-toggle="collapse" data-parent="#accordion2" href="#ver_{$i}" aria-expanded="true" aria-controls="ver_{$i}">
                                            {$UpdateCentre_install}
                                        </a>
                                        <span class="badge badge-pill badge-success">{$upd.version}</span>
                                    </div>
                                    <div id="ver_{$i}" class="collapse " role="tabpanel" aria-labelledby="accordion_update">
                                        <div class="block-content pb-10">
                                            <p>{$upd.desc}</p>
                                            {if $logs[$upd.version]}
                                                <textarea class="form-control pb-3" rows="{$.php.count($logs[$upd.version])}">{foreach $logs[$upd.version] as $line}- {$line}{$.const.PHP_EOL}{/foreach}</textarea>
                                            {/if}
                                        </div>
                                    </div>
                                </div>
                            {/foreach}
                        </div>
                    {/if}
                {else}
                    <div class="alert alert-success d-flex align-items-center justify-content-between mb-15" role="alert">
                        <div class="flex-fill mr-10">
                            <p class="mb-0">{$UpdateCentre_current_version} MmoWeb {$version} </p>
                        </div>
                        <div class="flex-00-auto">
                            <i class="fa fa-fw fa-2x fa-check-square-o"></i>
                        </div>
                    </div>
                {/if}
            {else}
                <div class="alert alert-danger d-flex align-items-center justify-content-between mb-15" role="alert">
                    <div class="flex-fill mr-10">
                        <p class="mb-0">{$UpdateCentre_error}</p>
                    </div>
                    <div class="flex-00-auto">
                        <i class="fa fa-fw fa-2x fa-bug"></i>
                    </div>
                </div>
            {/if}
        </div>
    </div>
</div>