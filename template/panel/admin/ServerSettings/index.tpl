<div class="content">
    {include $.php.get_tpl_file('breadcrumb.tpl')}
    <style>
        .form-group {
            margin-bottom: 5px;
        }
    </style>
    <div class="row justify-content-center py-20">
        <div class="col-xl-12">
            <form action="{$.php.set_url($.const.ADMIN_URL~'/servers/save', false, false)}" novalidate="novalidate" method="post" onsubmit="return false;">

                <ul class="nav nav-tabs nav-tabs-block rounded" data-toggle="tabs" role="tablist">
                    {foreach $server_info as $plat => $srv_list first=$first}
                        <li class="nav-item">
                            <a class="nav-link {if $first}active{/if}" href="#btabs-{$plat}">{$plat}</a>
                        </li>
                    {/foreach}
                </ul>
                <div class="tab-content overflow-hidden">
                    {foreach $server_info as $plat => $srv_list first=$first}
                        <div class="tab-pane fade {if $first}show active{/if} mt-5" id="btabs-{$plat}" role="tabpanel">

                            <div class="row">
                            {foreach $srv_list as $sid_ => $srv}
                                <div class="col-12 col-lg-6">
                                    <div class=" block block-rounded">
                                        <div class="block-content">
                                            <h5 class="text-center">{$srv.name} x{$srv.rate} <small>{if $srv.status == 1}{$ServerSettings_enable}{else}{$ServerSettings_disable}{/if}</small></h5>
                                            <div class="form-group row">
                                                <label class="col-lg-4 col-form-label" for="val-name-{$sid_}">{$ServerSettings_name}</label>
                                                <div class="col-lg-8">
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">
                                                                <input type="hidden" name="info[{$sid_}][re_name]"  value="0">
                                                                <input type="checkbox" name="info[{$sid_}][re_name]" title="{$ServerSettings_re_name}" style="display: block;" value="1" {if $server_cfg[$sid_]['re_name']? AND $server_cfg[$sid_]['re_name']==1}checked{/if}>
                                                            </span>
                                                        </div>
                                                        <input type="text" class="form-control form-control-sm" id="val-name-{$sid_}" name="info[{$sid_}][name]" value="{if $server_cfg[$sid_]['re_name']? AND $server_cfg[$sid_]['re_name']==1}{$server_cfg[$sid_]['name']}{else}{$srv.name}{/if}" placeholder="Server name">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-lg-4 col-form-label" for="val-rate-{$sid_}">{$ServerSettings_rate}</label>
                                                <div class="col-lg-8">
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                                <span class="input-group-text">
                                                                    <input type="hidden" name="info[{$sid_}][re_rate]"  value="0">
                                                                    <input type="checkbox" name="info[{$sid_}][re_rate]" title="{$ServerSettings_re_rate}" style="display: block;" value="1" {if $server_cfg[$sid_]['re_rate']? AND $server_cfg[$sid_]['re_rate']==1}checked{/if}>
                                                                </span>
                                                        </div>
                                                        <input type="number" class="form-control form-control-sm" id="val-rate-{$sid_}" name="info[{$sid_}][rate]" value="{if $server_cfg[$sid_]['re_rate']? AND $server_cfg[$sid_]['re_rate']==1}{$server_cfg[$sid_]['rate']}{else}{$srv.rate}{/if}" placeholder="Server rate">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-lg-4 col-form-label" for="val-icon-{$sid_}">{$ServerSettings_icon} <i class="fa fa-info-circle" title="{$ServerSettings_notice_tpl}"></i>
                                                    <div class="text-muted"><small>{$ServerSettings_icon_url}</small></div>
                                                </label>
                                                <div class="col-lg-8">
                                                    <input type="text" class="form-control form-control-sm" id="val-icon-{$sid_}" name="info[{$sid_}][icon]" value="{if $server_cfg[$sid_]['icon']?}{$server_cfg[$sid_]['icon']}{/if}" placeholder="Server icon">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-lg-4 col-form-label" for="val-img-{$sid_}">{$ServerSettings_img} <i class="fa fa-info-circle" title="{$ServerSettings_notice_tpl}"></i>
                                                    <div class="text-muted"><small>{$ServerSettings_icon_url}</small></div>
                                                </label>
                                                <div class="col-lg-8">
                                                    <input type="text" class="form-control form-control-sm" id="val-img-{$sid_}" name="info[{$sid_}][img]" value="{if $server_cfg[$sid_]['img']?}{$server_cfg[$sid_]['img']}{/if}" placeholder="Server image">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-lg-4 col-form-label" for="val-link-{$sid_}">{$ServerSettings_link} <i class="fa fa-info-circle" title="{$ServerSettings_notice_tpl}"></i></label>
                                                <div class="col-lg-8">
                                                    <input type="text" class="form-control form-control-sm" id="val-link-{$sid_}" name="info[{$sid_}][link]" value="{if $server_cfg[$sid_]['link']?}{$server_cfg[$sid_]['link']}{/if}" placeholder="Server image">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-lg-4 col-form-label" for="val-chronicle-{$sid_}">{$ServerSettings_chronicle} <i class="fa fa-info-circle" title="{$ServerSettings_notice_tpl}"></i></label>
                                                <div class="col-lg-8">
                                                    <input type="text" class="form-control form-control-sm" id="val-chronicle-{$sid_}" name="info[{$sid_}][chronicle]" value="{if $server_cfg[$sid_]['chronicle']?}{$server_cfg[$sid_]['chronicle']}{/if}" placeholder="Server chronicle">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-lg-4 col-form-label" for="val-description-{$sid_}">{$ServerSettings_description} <i class="fa fa-info-circle" title="{$ServerSettings_notice_tpl}"></i></label>
                                                <div class="col-lg-8">
                                                    <input type="text" class="form-control form-control-sm" id="val-description-{$sid_}" name="info[{$sid_}][description]" value="{if $server_cfg[$sid_]['description']?}{$server_cfg[$sid_]['description']}{/if}" placeholder="Server description">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-lg-4 col-form-label" for="val-date-{$sid_}">{$ServerSettings_date} <i class="fa fa-info-circle" title="{$ServerSettings_notice_tpl}"></i></label>
                                                <div class="form-inline col-lg-8">
                                                    <input type="date" class="form-control form-control-sm" id="val-date-{$sid_}" name="info[{$sid_}][date]" value="{if $server_cfg[$sid_]['date']?}{$server_cfg[$sid_]['date']}{/if}" placeholder="Info date">
                                                    <input type="time" class="form-control form-control-sm" id="val-time-{$sid_}" name="info[{$sid_}][time]" value="{if $server_cfg[$sid_]['time']?}{$server_cfg[$sid_]['time']}{/if}" placeholder="Info time">

                                                    <select class="form-control form-control-sm" name="info[{$sid_}][time_zone]">
                                                        {foreach $time_zone as $zn}
                                                        <option value="{$zn}" {if $server_cfg[$sid_]['time_zone']? AND $server_cfg[$sid_]['time_zone'] == $zn}selected{/if}>{$zn}</option>
                                                        {/foreach}
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-lg-4 col-form-label" for="val-max_online-{$sid_}">{$ServerSettings_maxonline} <i class="fa fa-info-circle" title="{$ServerSettings_notice_tpl}"></i></label>
                                                <div class="col-lg-8">
                                                    <input type="text" class="form-control form-control-sm" id="val-max_online-{$sid_}" name="info[{$sid_}][max_online]" value="{if $server_cfg[$sid_]['max_online']?}{$server_cfg[$sid_]['max_online']}{/if}" placeholder="Server max online percent">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-lg-4 col-form-label" for="val-max_online-{$sid_}">
                                                    {$ServerSettings_online_s} <i class="fa fa-info-circle" title="{$ServerSettings_notice_tpl}"></i>
                                                    <div class="text-muted"><small>{$ServerSettings_online_sdesc}</small></div>
                                                </label>
                                                <div class="col-lg-8">
                                                    <div class="custom-control custom-checkbox custom-control-inline mb-5">
                                                        <input class="custom-control-input" type="checkbox" name="info[{$sid_}][on_login]" id="on-login-{$sid_}" value="1" {if $server_cfg[$sid_]['on_login']? AND $server_cfg[$sid_]['on_login']==1}checked{/if}>
                                                        <label class="custom-control-label" for="on-login-{$sid_}">{$ServerSettings_online_ls}</label>
                                                    </div>
                                                    <div class="custom-control custom-checkbox custom-control-inline mb-5">
                                                        <input class="custom-control-input" type="checkbox" name="info[{$sid_}][on_server]" id="on-server-{$sid_}" value="1" {if $server_cfg[$sid_]['on_server']? AND $server_cfg[$sid_]['on_server']==1}checked{/if}>
                                                        <label class="custom-control-label" for="on-server-{$sid_}">{$ServerSettings_online_gs}</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-lg-4 col-form-label" for="val-max_online-{$sid_}">
                                                    {$ServerSettings_hide_s} <i class="fa fa-info-circle" title="{$ServerSettings_notice_tpl}"></i>
                                                    <div class="text-muted"><small>{$ServerSettings_hide_sdesc}</small></div>
                                                </label>
                                                <div class="col-lg-8">
                                                    <div class="custom-control custom-checkbox custom-control-inline mb-5">
                                                        <input class="custom-control-input" type="radio" name="info[{$sid_}][hide]" id="hide-show-{$sid_}" value="1" {if $server_cfg[$sid_]['hide']?}{if $server_cfg[$sid_]['hide']==1}checked{/if}{else}checked{/if}>
                                                        <label class="custom-control-label" for="hide-show-{$sid_}">{$ServerSettings_hide_yes}</label>
                                                    </div>
                                                    <div class="custom-control custom-checkbox custom-control-inline mb-5">
                                                        <input class="custom-control-input" type="radio" name="info[{$sid_}][hide]" id="hide-hide-{$sid_}" value="0" {if $server_cfg[$sid_]['hide']? AND $server_cfg[$sid_]['hide']==0}checked{/if}>
                                                        <label class="custom-control-label" for="hide-hide-{$sid_}">{$ServerSettings_hide_no}</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-text text-muted text-center pb-10"><small>{$ServerSettings_info}</small></div>
                                    </div>
                                </div>
                            {/foreach}
                            </div>
                        </div>
                    {/foreach}
                </div>
                <div class="form-group row">
                    <div class="col-lg-12 mr-auto">
                        <button type="submit" class="btn btn-alt-primary ml-10 submit-form"><i class="fa fa-upload mr-5"></i>{$LangEditor_btn_save}</button>
                        <button type="reset" class="btn btn-alt-secondary ml-10"><i class="fa fa-repeat mr-5"></i>{$LangEditor_btn_reset}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>