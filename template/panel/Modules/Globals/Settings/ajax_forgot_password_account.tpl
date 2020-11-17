{$.php.form_hide_input("Modules\Globals\Settings\Settings", "forgot_password_account")}
<input type="hidden" name="account" value="{$account}">
<p>Новый пароль будет вам отправлен на
    {if $.site.session->session.master_account.telegram?}telegram,{/if}
    {if $.site.session->session.master_account.email?}email{elseif $.site.session->session.master_account.phone?}phone{/if}
</p>
{if $.php.check_pin("pins_forgot_password_account")}
<div class="form-group row">
    <label class="col-md-4 col-form-label text-right border-right" for="input_password_pin"> {$lang_input_password_pin} </label>
    <div class="col-md-8 pt-5">
        <input type="password" maxlength="4" class="form-control" id="input_password_pin" name="pin">
    </div>
</div>
{/if}