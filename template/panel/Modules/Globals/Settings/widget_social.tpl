<div class="form-group row">
    <label class="col-md-4 col-form-label text-right border-right" for="name">
        {$lang_title}
    </label>
    <div class="col-md-6 pt-5 text-justify">


        <table class="table table-sm table-vcenter table-hover">
            <tbody>
            
           
            {foreach $social_list as $soc}
                <tr>
                    <td style="width: 45px;" class="pl-10">
                        <a {if !isset($soc_list[$soc])}href="javascript:void(0)" onclick="$('.ulogin-button-{$soc}').trigger('click');"{else}href="{$soc_list[$soc]['identity']}" target="_blank"{/if}>
                            <img width="32" height="32" src="{if $soc_list[$soc]['identity']?}{$soc_list[$soc]['photo']}{else}{$.site.dir_panel}/assets/media/social/{$soc}.png{/if}" alt="avatar" class="widget-image img-circle pull-left animation-fadeIn">
                        </a>
                    </td>
                    <td>
                        <a {if !isset($soc_list[$soc])}href="javascript:void(0)" onclick="$('.ulogin-button-{$soc}').trigger('click');"{else}href="{$soc_list[$soc]['identity']}" target="_blank"{/if}>{if !isset($soc_list[$soc])}{ucfirst($soc)}{else}{$soc_list[$soc]['first_name']}{/if}</a><br>
                        <small> {if !isset($soc_list[$soc])}{$lang_text_no_connect}{else}{$soc_list[$soc]['data_add']}{/if}</small>
                    </td>
                    <td class="text-center" style="width: 70px;">
                        <div class="btn-group btn-group-xs">
                            {if isset($soc_list[$soc])}
                                <button type="button"  {$.php.btn_ajax("Modules\Globals\Settings\Settings", "social_delete", ['delete' => $soc])} class="btn btn-default submit-btn"><i class="fa fa-times"></i></button>
                            {else}
                                <a {if !isset($soc_list[$soc])}href="javascript:void(0)" onclick="$('.ulogin-button-{$soc}').trigger('click');"{/if} class="btn btn-default"><i class="fa fa-user-plus"></i></a>
                            {/if}
                        </div>
                    </td>
                </tr>
            {/foreach}
            </tbody>
        </table>

    </div>
    <script src="//ulogin.ru/js/ulogin.js"></script>
    <div style="display: none;" id="uLogin" data-ulogin="display=panel;theme=flat;
                                            fields=fields=first_name,last_name,email,photo_big;
                                            providers={implode(',',$social_list)};
                                            redirect_uri={urlencode($.site.config.project.url_site)}auth;
                                            callback=set_ulogin;
                                            mobilebuttons=0;"></div>
</div>
<hr>
<script>
    window.set_ulogin = function (token) {
        send_ajax('{http_build_query(['module_form' => "Modules\Globals\Settings\Settings",'module' => "social_bind"])}&token='+token, true);
    };
</script>