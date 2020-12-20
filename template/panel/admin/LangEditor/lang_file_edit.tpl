<div class="content">
    {include $.php.get_tpl_file('breadcrumb.tpl')}
    <h2 class="content-heading"> {$file} <small>Panel</small></h2>
    <div class="block block-rounded">
        <div class="block-content">
            <div class="row justify-content-center py-20">
                <div class="col-xl-12">
                    <form action="{$.php.set_url($.const.ADMIN_URL~'/lang/panel?file='~$file~'&save=1', false, false)}" method="post" novalidate="novalidate">
                        <div class="input_list">

                            <ul class="nav nav-tabs nav-tabs-block " data-toggle="tabs" role="tablist">
                                {foreach $lang_ as $k_l => $val first=$first}
                                <li class="nav-item">
                                    <a class="nav-link {if $first}active{/if}" href="#{$k_l}">{$k_l}</a>
                                </li>
                                {/foreach}
                            </ul>
                            <div class="block-content tab-content">
                                {foreach $lang_ as $k_l => $lang_key first=$first2}
                                <div class="tab-pane {if $first2}active{/if}" id="{$k_l}" role="tabpanel">
                                    {foreach $keys_all as $key}
                                        {if $lang_key[$key]? AND $.php.is_bool($lang_key[$key])}
                                            <div class="form-group row">
                                                <label class="col-lg-4 col-form-label" for="val-{$key}">{$key}</label>
                                                <div class="col-lg-8">
                                                    <div class="custom-control custom-radio custom-control-inline mb-5">
                                                        <input class="custom-control-input" type="radio" name="lang[{$k_l}][{$key}]" id="{$key}1" value="true" {if $lang_key[$key] == true}checked=""{/if}>
                                                        <label class="custom-control-label" for="{$key}1">True</label>
                                                    </div>
                                                    <div class="custom-control custom-radio custom-control-inline mb-5">
                                                        <input class="custom-control-input" type="radio" name="lang[{$k_l}][{$key}]" id="{$key}2" value="false" {if $lang_key[$key] == false}checked=""{/if}>
                                                        <label class="custom-control-label" for="{$key}2">False</label>
                                                    </div>
                                                </div>
                                            </div>
                                        {elseif $lang_key[$key]? AND $.php.is_array($lang_key[$key])}
                                            <div class="form-group row">
                                            <label class="col-lg-4 col-form-label" for="val-{$key}">{$key}</label>
                                            {foreach $lang_key[$key] as $k => $v}

                                                    <div class="col-lg-12">
                                                        <input type="text" class="form-control" id="val-{$key}" name="lang[{$k_l}][{$key}][{$k}]" value="{if $v?}{$v|escape:'html'}{/if}" placeholder="Укажите значение ключа">
                                                    </div>

                                            {/foreach}
                                            </div>
                                        {else}
                                            <div class="form-group row">
                                                <label class="col-lg-4 col-form-label" for="val-{$key}">{$key}</label>
                                                <div class="col-lg-8">
                                                    <input type="text" class="form-control" id="val-{$key}" name="lang[{$k_l}][{$key}]" value="{if $lang_key[$key]?}{$lang_key[$key]|escape:'html'}{/if}" placeholder="Укажите значение ключа">
                                                </div>
                                            </div>
                                        {/if}
                                    {/foreach}
                                </div>
                                {/foreach}
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-12 mr-auto">
                                <button type="submit" class="btn btn-alt-primary"><i class="fa fa-upload mr-5"></i>{$LangEditor_btn_save}</button>
                                <button type="reset" class="btn btn-alt-secondary ml-10"><i class="fa fa-repeat mr-5"></i>{$LangEditor_btn_reset}</button>

                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>