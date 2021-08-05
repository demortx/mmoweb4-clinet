<!-- Footer -->
<footer id="page-footer" class="opacity-0">
    <div class="content py-20 font-size-xs clearfix">


        <div class="float-right">
            <div class="form-material pt-0">
                <select class="form-control font-size-xs" id="change_lang" style="height: 30px;">
                    {foreach $.site.config.site.language_list as $lang_key => $lang_title}
                        <option hreflang="{$lang_key}" value="/{$lang_key}{$.site.uri_string}" {if $.php.select_lang() == $lang_key}selected{/if}>{$lang_title|truncate:3:""|upper}</option>
                    {/foreach}
                </select>
            </div>
        </div>

        <div class="float-left">
            <a class="font-w600" href="https://mmoweb.ru/" target="_blank">MmoWeb</a> &copy; <span class="js-year-copy"></span>
        </div>
    </div>
</footer>
<!-- END Footer -->