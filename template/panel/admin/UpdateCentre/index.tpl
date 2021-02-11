<div class="content">
    {include $.php.get_tpl_file('breadcrumb.tpl')}

    <div class="row no-gutters d-flex justify-content-center">
        <div class="col-md-10 col-xl-7">
            <h2>{$UpdateCentre_title} {$version}</h2>
            <div class="d-flex justify-content-between">
                <a class="btn btn-hero btn-alt-secondary" href="{$.php.set_url($.const.ADMIN_URL~'/updating')}">
                    <i class="fa fa-refresh mr-5"></i> {$UpdateCentre_btn_check}
                </a>
                {if $check_update AND $new_version != false}
                <a class="btn btn-hero btn-alt-success" href="{$.php.set_url($.const.ADMIN_URL~'/updating/install')}">
                    <i class="fa fa-cloud-download"></i> <span class="d-none d-sm-inline-block ml-5">{$UpdateCentre_btn_update_from} {$new_version}</span>
                </a>
                {/if}
            </div>
            <hr>
            {if $check_update}
                {if $new_version}
                    <div class="alert alert-warning d-flex align-items-center justify-content-between mb-15" role="alert">
                        <div class="flex-fill mr-10">
                            <p class="mb-0">{$UpdateCentre_new_version} MmoWeb {$new_version}</p>
                        </div>
                        <div class="flex-00-auto">
                            <i class="fa fa-fw fa-2x fa-exclamation-triangle"></i>
                        </div>
                    </div>
                    <div id="accordion2" role="tablist" aria-multiselectable="true">
                        {foreach $update_list as $i => $upd}
                            <div class="block block-bordered block-rounded mb-2">
                                <div class="block-header" role="tab" id="accordion_update">
                                    <a class="font-w600" data-toggle="collapse" data-parent="#accordion2" href="#ver_{$i}" aria-expanded="true" aria-controls="ver_{$i}">
                                        {$UpdateCentre_new_version}
                                    </a>
                                    <span class="badge badge-pill badge-success">{$upd.version}</span>
                                </div>
                                <div id="ver_{$i}" class="collapse " role="tabpanel" aria-labelledby="accordion_update">
                                    <div class="block-content">
                                        <p>{$upd.desc}</p>
                                    </div>
                                    <div class="block-content text-center p-2">
                                        <a href="{$upd.url}" class="link-effect text-info ">{$UpdateCentre_btn_dwn_update}</a>
                                    </div>
                                </div>
                            </div>
                        {/foreach}
                    </div>
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