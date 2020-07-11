<div class="content">
    {include '/panel/breadcrumb.tpl'}
    <h2 class="content-heading pt-20">
        <a href="{$.php.set_url($.const.ADMIN_URL~'/lang/panel')}" class="btn btn-sm btn-rounded btn-alt-primary float-right">{$LangEditor_panel_btn}</a>
        <a href="https://mmoweb.ru/panel/plugin/template" class="btn btn-sm btn-rounded btn-alt-secondary float-right mr-5">{$LangEditor_shop_btn}</a>
        <i class="fa fa-code mr-5"></i> {$LangEditor_title}
    </h2>
    <div class="row row-deck items-push">
        {foreach $template_list as $tpl_name => $tpl_info}
        <div class="col-md-6 col-xl-3" title="{$tpl_info.platform}">
            <div class="block block-link-shadow block-rounded ribbon ribbon-modern ribbon-left ribbon-success text-center">
                {if $tpl_name == $.const.TEMPLATE}<div class="ribbon-box">{$LangEditor_select}</div>{/if}
                <div class="block-content block-content-full p-0 pt-5">
                    <img class="img-avatar" style="width: 95%;height: 170px;border-radius: 2%;" src="{$.const.VIEWPATH~'/site/'~$tpl_name~$tpl_info.poster}" alt="{$tpl_name}">

                    <div class="font-size-sm text-muted mt-5">
                        {if $tpl_info.lang? AND $.php.is_array($tpl_info.lang)}
                            {foreach $tpl_info.lang as $lg}
                                <a href="{$.php.set_url($.const.ADMIN_URL~'/lang/'~$tpl_name)~'?lang='~$lg}" title="{$LangEditor_edit_lang} {$lg}">[{$lg}]</a>
                            {/foreach}
                        {else}
                            {$LangEditor_not_found_lang}
                        {/if}
                    </div>
                </div>
                <div class="block-content block-content-full block-content-sm bg-body-light">
                    <div class="font-size-sm text-muted">{$tpl_info.author} &bull; {$tpl_info.html}</div>
                </div>
                <div class="block-content block-content-full block-content-sm">
                    <div class="font-w600">{$tpl_info.name}</div>
                </div>
            </div>
        </div>
        {/foreach}
    </div>

</div>