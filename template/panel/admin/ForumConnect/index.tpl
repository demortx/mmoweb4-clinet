<div class="content">
    {include '/panel/breadcrumb.tpl'}
    <div class="row justify-content-center py-20">
        <div class="col-xl-12">
            <form action="{$.php.set_url('admin/forum/save', false)}" novalidate="novalidate" method="post" onsubmit="return false;">
                <div class="block block-rounded">
                    <div class="block-content">
                        <div class="form-group row">
                            <label class="col-lg-4 col-form-label" for="val-enable">{$ForumConnect_in_enable}</label>
                            <div class="col-lg-8">
                                <div class="custom-control custom-radio custom-control-inline mb-5">
                                    <input class="custom-control-input" type="radio" name="enable" id="show1" value="true" {if $forum_config.enable}checked=""{/if}>
                                    <label class="custom-control-label" for="show1">Yes</label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline mb-5">
                                    <input class="custom-control-input" type="radio" name="enable" id="show2" value="false" {if $forum_config.enable == false}checked=""{/if}>
                                    <label class="custom-control-label" for="show2">No</label>
                                </div>
                                <div class="form-text text-muted">{$ForumConnect_in_enable_desc}</div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-lg-4" for="l-version">{$ForumConnect_in_version}</label>
                            <div class="col-lg-8">
                                <select class="form-control" id="l-version" name="version">
                                    {foreach $forum_version as $ver => $name}
                                        <option value="{$ver}" {if $ver == $forum_config.version}selected{/if}>{$name}</option>
                                    {/foreach}
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-lg-4 col-form-label" for="val-url">{$ForumConnect_in_url}</label>
                            <div class="col-lg-8">
                                <input type="text" class="form-control" id="val-url" name="url" value="{$forum_config.url}" placeholder="{$ForumConnect_in_url_pa}">
                                <div class="form-text text-muted">{$ForumConnect_in_url_desc}</div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-4 col-form-label" for="val-api_key">{$ForumConnect_in_api}</label>
                            <div class="col-lg-8">
                                <input type="text" class="form-control" id="val-api_key" name="api_key" value="{$forum_config.api_key}" placeholder="{$ForumConnect_in_api_pa}">
                                <div class="form-text text-muted">{$ForumConnect_in_api_desc}</div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-lg-4 col-form-label" for="val-count">{$ForumConnect_in_count}</label>
                            <div class="col-lg-8">
                                <input type="number" class="form-control" id="val-count" name="count" value="{$forum_config.count}" placeholder="10">
                                <div class="form-text text-muted">{$ForumConnect_in_count_desc}</div>
                            </div>
                        </div>

                    </div>


                    <ul class="nav nav-tabs nav-tabs-block" data-toggle="tabs" role="tablist">
                        {foreach $language_list as $lg => $name_lg first=$first}
                            <li class="nav-item">
                                <a class="nav-link {if $first}active{/if}" href="#btabs-{$lg}">{$name_lg}</a>
                            </li>
                        {/foreach}
                    </ul>
                    <div class="block-content tab-content overflow-hidden">
                        {foreach $language_list as $lg => $name_lg first=$first}
                            <div class="tab-pane fade {if $first}show active{/if}" id="btabs-{$lg}" role="tabpanel">

                                <div class="form-group row">
                                    <label class="col-lg-4 col-form-label" for="val-allow">{$ForumConnect_in_allow}</label>
                                    <div class="col-lg-8">
                                        <input type="text" class="form-control" id="val-allow" name="allow[{$lg}]" value="{if $forum_config.allow[$lg]?}{$forum_config.allow[$lg]}{/if}" placeholder="1,2,3,4">
                                        <div class="form-text text-muted">{$ForumConnect_in_allow_desc}</div>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-lg-4 col-form-label" for="val-deny">{$ForumConnect_in_deny}</label>
                                    <div class="col-lg-8">
                                        <input type="text" class="form-control" id="val-deny" name="deny[{$lg}]" value="{if $forum_config.deny[$lg]?}{$forum_config.deny[$lg]}{/if}" placeholder="5,6,7,8">
                                        <div class="form-text text-muted">{$ForumConnect_in_deny_desc}</div>
                                    </div>
                                </div>

                            </div>
                        {/foreach}
                    </div>
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