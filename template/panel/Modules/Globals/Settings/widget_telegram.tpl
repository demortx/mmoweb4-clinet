<div class="form-group row">
    <label class="col-md-4 col-form-label text-right border-right" for="telegram">{$lang_title}</label>
    <div class="col-md-6 pt-5">
        <form action="/input" method="post" onsubmit="return false;">
        {$.php.form_hide_input("Modules\Globals\Settings\Settings", "bind_telegram")}
            <div class="input-group">
                <input type="text" class="form-control" id="telegram" name="telegram" placeholder="@demo" value="{if !$.php.is_array($.site.session->session.master_account.telegram)}{$.site.session->session.master_account.telegram}{/if}" {if !is_array($.site.session->session.master_account.telegram)}disabled{/if}>



                {if $.php.is_array($.site.session->session.master_account.telegram)}
                    <input type="hidden" name="type" value="enable">
                    {if $.php.check_pin("pins_bind_telegram")}<input type="text" class="form-control" id="pin" name="pin" placeholder="PIN-CODE"> {/if}
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-alt-success submit-form"><i class="fa fa-check"></i>  {$lang_btn_confirm_telegram}</button>
                    </div>
                {else}
                    <input type="hidden" name="type" value="disable">
                    {if $.php.check_pin("pins_bind_telegram")}<input type="text" class="form-control" id="pin" name="pin" placeholder="PIN-CODE"> {/if}
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-alt-danger submit-form"><i class="fa fa-check"></i>  {$lang_btn_disable_telegram}</button>
                    </div>
                {/if}
            </div>

            <div class="form-text text-muted">
                {$lang_text}
            </div>
        </form>
    </div>
</div>